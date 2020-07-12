<?php

class TestController extends Controller{
    
    public $has_error = false;

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['super_admin', 'admin']);
    }
    
    public function index(){
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/admin/test_creator');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Create Test',
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js',
                'public/js/fb_fields_acsite.js',
                'public/js/testcreator.js'
            ], //include site level javascript file. it means this javascript file are only included in testcreator/ controller
            'content' => $content, //this is the pages/admin/test_creator html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
    public function search(){
        
        //init model
        $test = $this->initModel('TestModel');
        
        //search
        if(isset($_POST['search'])){
            $where = array();
            $where['conditions'] = "AND tbassessment.AssName LIKE ?";
            $where['values'][] = "%".xss_clean($_POST['assessment_name'])."%";
            $tests = $test->getAllTests($where);
        } else {
            $tests = $test->getAllTests();
        }
        
         //load a view and put it in a variable for later use
        $content = $this->getView('pages/admin/test_search', ['tests' => $tests]);
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Search Test',
            'includeSiteLevelJS' => [], //include site level javascript file. it means this javascript file are only included in testcreator/ controller
            'content' => $content, //this is the pages/admin/test_search html
        ];
        $this->renderView('layouts/admin', $html);
    }
    
    public function view(){
               
        //init model
        $test = $this->initModel('TestModel');
        $test_info = $test->getTest($_GET['id']);

        if(!empty($test_info['question'])){
            
            $questions = $this->loadQuestionsAdmin($test_info['question']);
            $test_info['question'] = $questions;

            //load a view and put it in a variable for later use
            $content = $this->getView('pages/admin/test_view', ['test' => $test_info]);

            //create an array that will store data to be passed to the render view method
            $html = [
                'page_name' => 'View Test: '.$test_info['AssName'],
                'includeSiteLevelJS' => [
                    'public/js/formbuilder/form-builder.min.js', 
                    'public/js/formbuilder/form-render.min.js', 
                    'public/js/formbuilder/control_plugins/starRating.js', 
                    'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                    'public/js/formbuilder/control_plugins/startPageMarker.js', 
                    'public/js/formbuilder/control_plugins/endPageMarker.js', 
                    'public/js/formbuilder/control_plugins/likertQuestion.js',
                    'public/js/formbuilder/control_plugins/LeastBestQuestion.js',
                    'public/js/formbuilder/control_plugins/rankingQuestion.js',
                    'public/js/formbuilder/control_plugins/sliderQuestion.js',
                    'public/js/formbuilder/control_plugins/customMC1Question.js',
                    'public/js/formbuilder/control_plugins/customMC2Question.js',
                    'public/js/fb_fields_acsite.js',
                    'public/js/testview.js'
                ], 
                'content' => $content, //this is the pages/admin/test_creator html
            ];
            $this->renderView('layouts/admin', $html);
            
        }else {
            
            #Get items for conversion 
            $items_for_conversion = $test->getQuestionsForConversion($test_info['AssCode']);
            $test_info['items_for_conversion'] = $items_for_conversion;
            
//            echo '<pre>';
//            print_r($items_for_conversion);
//            echo '</pre>';
            
            
            if(!empty($items_for_conversion)){
                $content = $this->getView('pages/admin/test_conversion', ['test' => $test_info]);
            }  else {
                $content = '<div class="alert alert-info">
                                Invalid test format, sorry this test cannot be converted. 
                            </div>';
            }
            
            $html['page_name'] = 'View Test: '.$test_info['AssName'];
            $html['content'] = $content;

            $this->renderView('layouts/admin', $html);
            
        }
   
    }
    
    
    public function update(){
        
        //init model
        $test = $this->initModel('TestModel');
        $test_info = $test->getTest($_GET['id']);
        
         //load a view and put it in a variable for later use
        $content = $this->getView('pages/admin/test_update', ['test' => $test_info]);
        
//        $json_q = json_decode($test_info['question']);
//        echo '<pre>';
//        print_r($json_q);
//        echo '</pre>';
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Edit Test: '.$test_info['AssName'],
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testupdate.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/admin', $html);
    }
    
    
    public function convert(){
        
        $assessment_id = xss_clean($_GET['id']);
        
        //init model
        $test = $this->initModel('TestModel');
        #1 get ass_code from tbassessment
        $tb_assessment = $test->get_tb_assessment($assessment_id);
        #2 get assessment dimensions
        $tb_dimensions = $test->get_tb_dimensions($tb_assessment['AssCode']);

        //conversion start
        $items_for_conversion = [];
        $items_for_conversion['tb_dimensions'] = $tb_dimensions;
        $items_for_conversion['questions'] = $test->getQuestionsForConversion($tb_assessment['AssCode']);
        
        list($build_test, $total_pages) = $this->buildTest($items_for_conversion);
        
//        echo '<pre>';
//        print_r($build_test);
//        echo '</pre>';
        
        if(!$this->has_error){
            $insert = [];
            $insert['ass_code'] = $tb_assessment['AssCode']; 
            $insert['total_pages'] = $total_pages; 
            $insert['question'] = json_encode($build_test);
            $test->save_tbtest_items_summary($insert);
            //conversion end
            header("Location:".APP_BASE_URL."test/view/?id=".$assessment_id);
        } else {
            header("Location:".APP_BASE_URL."test/view/?id=".$assessment_id."&err_msg=".xss_clean($build_test));
        }
        
    }
        
    function buildTest($data){
        
        $test = $this->initModel('TestModel');

        $final_test = array();
        $total_pages = 0;
        $assessment_id = xss_clean($_GET['id']);
        $error = [];
        
        
        if(empty($data)){
            return $error[] = 'No data found';
        }
        
        
        //Start building the test
        if(isset($_POST['group_test_by'])){
            
            if(xss_clean($_POST['group_test_by']) == '1'){ // GROUP BY DimensionNumber
                $inc = 1;
                foreach($data['tb_dimensions'] as $dimension){
                    
                    //page instruction
                    $page_instruction = $test->get_instruction_per_dimension($dimension['AssCode'], $dimension['dimensionNumber']);
                    $final_test[] = $this->startMarker($inc);
                    $final_test[] = $this->instructionPage($inc, $page_instruction['CategoryInst']);
                    $final_test[] = $this->defaultSubmitButton($inc);
                    $final_test[] = $this->endMarker($inc);  
                    $total_pages++;

                    
                    //Start Marker
                    $final_test[] = $this->startMarker($inc);
                    $total_pages++;
                    //Questions
                    foreach($data['questions'] as $question_info){

                        if($dimension['dimensionNumber'] == $question_info['level']){
                            $generate_question = $this->generate_question($inc++, $question_info);
                            if($this->has_error){
                                return (is_array($generate_question)) ? array(implode(', ', $generate_question), $total_pages) : array($generate_question, $total_pages);
                            } else {
                                $final_test[] = $generate_question;
                            }
                        } else {
                            continue;
                            //$this->has_error = true;
                            //return array('Error: tbdimension.dimensionNumber and tbtest_items.level does not match. 11 ' .$question_info['fldQOrder'] .' '.  $dimension['dimensionNumber'] .'=='. $question_info['level'], $total_pages);
                        }
                    }
                    //Submit Button
                    $final_test[] = $this->defaultSubmitButton($inc);
                    //End Marker
                    $final_test[] = $this->endMarker($inc);       
                }
                
            } else if (xss_clean($_POST['group_test_by']) == '2'){ // GROUP BY TopicCode
                $inc = 1;
                
                $question_by_topic_code = [];
                foreach($data['questions'] as $question_info){
                    $question_by_topic_code[$question_info['TopicCode']][] = $question_info;
                }

                $question_info = [];
                
                foreach($question_by_topic_code as $key => $question_info){

                    //page instruction
                    $page_instruction = $test->get_instruction_by_topicCode($data['tb_dimensions'][0]['AssCode'], $key);
                    $final_test[] = $this->startMarker($inc);
                    $final_test[] = $this->instructionPage($inc, $page_instruction['CategoryInst']);
                    $final_test[] = $this->defaultSubmitButton($inc);
                    $final_test[] = $this->endMarker($inc);  
                    $total_pages++;
                    
                    
                    //Start Marker
                    $final_test[] = $this->startMarker($inc);
                    $total_pages++;
                    
                    //Questions
                    foreach ($question_info as $question){
                    
                        $csv_level = $question['level'];
                        $exploded_csv_level = explode(',', $csv_level);
                        if($question['dimensionNumber'] == $question['level']){
                            $generate_question = $this->generate_question($inc++, $question);
                            if($this->has_error){
                                return (is_array($generate_question)) ? array(implode(', ', $generate_question), $total_pages) : array($generate_question, $total_pages);
                            } else {
                                $final_test[] = $generate_question;
                            }
                        } else if (in_array($question['dimensionNumber'], $exploded_csv_level)) { //example tests: pti
                            $generate_question = $this->generate_question($inc++, $question);
                            if($this->has_error){
                                return (is_array($generate_question)) ? array(implode(', ', $generate_question), $total_pages) : array($generate_question, $total_pages);
                            } else {
                                $final_test[] = $generate_question;
                            }
                        } else {
                            $this->has_error = true;
                            return array('Error: tbdimension.dimensionNumber and tbtest_items.level does not match. 22', $total_pages);
                        }
                        
                    }
                    
                    //Submit Button
                    $final_test[] = $this->defaultSubmitButton($inc);
                    //End Marker
                    $final_test[] = $this->endMarker($inc);  
                    
                }
                
            }
        }
        
//        echo '<pre>';
//        print_r($total_pages);
//        echo '</pre>';
        
        return array($final_test, $total_pages);
    }
    
    protected function startMarker($inc){
        return (object)[
            "type" => "startPageMarker",
            "required" => false,
            "label" => "<span class=\"text-info\"><b>Start Page Marker</b></span>",
            "name" => "startPageMarker-".$inc++."",
            "access" => false,
            "randomize" => "false",
            "onTimerTimesUp" => "console.log(\"Times up!\");",
            "enableSnapshot" => "false"
        ];
    }
    
    protected function defaultSubmitButton($inc){
        return (object)[
            "type" => "button",
            "subtype" => "submit",
            "label" => "Submit",
            "className" => "btn-success btn",
            "name" => "button-".$inc++."",
            "access" => false,
            "style" => "success"
        ];
    }
    
    protected function endMarker($inc){
        return (object)[
            "type" => "endPageMarker",
            "required" => false,
            "label" => "<span class=\"text-danger\"><b>End Page Marker</b></span>",
            "name" => "endPageMarker-".$inc++."",
            "access" => false
        ];
    }
    
    protected function generate_question($inc, $question_info){
        
        $valid_question_types = ['mc1', 'mc2', 'mc3', 'mc4', 'cd', 'wh', 'tf1', 'tf2', 'yn1', 'yn2', 'ein', 'lkr', 'pti', 'rn1', 'rn2', 'rn3'];
        $error = '';
        
        if(!in_array($question_info['QuesType'], $valid_question_types)){
            $this->has_error = true;
            $error = 'Invalid QuesType "'.$question_info['QuesType'].'"';
        }
        
        if($this->has_error){
            return $error;
        }
            
        switch ($question_info['QuesType']){
            case 'mc1':
            case 'mc2':
            case 'mc3':
            case 'mc4':
                
                //explode tbtest_items.CorrectAns
                $CorrectAns = explodeData('CorrectAns', $question_info['CorrectAns']);
                //count correct answers
                $correct_answers = 0;
                foreach($CorrectAns as $ans){
                    if($ans > 0){
                        ++$correct_answers;
                    }
                }   
                
                if(isset($_POST['test_layout']) && $_POST['test_layout'] == 'basic'){
                    
                    if($correct_answers > 1){
                        return $this->multiAnswerQuestion($inc, $question_info['question'], $question_info['options']);
                    } else {
                        return $this->singleAnswerQuestion($inc, $question_info['question'], $question_info['options']);
                    }
                    
                } else if(isset($_POST['test_layout']) && $_POST['test_layout'] == 'custom'){ 
                    
                    
                    if($question_info['QuesType'] == 'mc1'){
                        return $this->singleAnswerQuestion_CustomMC1($inc, $question_info['question'], $question_info['options']);
                    } else if($question_info['QuesType'] == 'mc2'){
                        return $this->multiAnswerQuestion_CustomMC2($inc, $question_info['question'], $question_info['options']);
                    } else {
                        //mc3 //mc4
                        if($correct_answers > 1){
                            return $this->multiAnswerQuestion_Custom($inc, $question_info['question'], $question_info['options']);
                        } else {
                            return $this->singleAnswerQuestion_Custom($inc, $question_info['question'], $question_info['options']);
                        }
                    }
                }
                
                
                break;
                
            case 'cd':
                //contributes (C) or (1)
                //detracts (D) or (2)
                return $this->singleAnswerQuestion_CD($inc, $question_info['question']);
                break;
            case 'wh':    
                //what kind of (W) or (1)
                //how (H) or (2)
                return $this->singleAnswerQuestion_WH($inc, $question_info['question']);
                break;
            case 'tf1':
                //True (T) or (1)
                //False (F) or (2)
                return $this->singleAnswerQuestion_TF1($inc, $question_info['question']);
                break;
            case 'tf2':
                //True (T) or (1)
                //False (F) or (2)
                //Undecided (U) or (3)
                return $this->singleAnswerQuestion_TF2($inc, $question_info['question']);
                break;
            case 'yn1':
                //Yes (Y) or (1)
                //No (N) or (2)
                return $this->singleAnswerQuestion_YN1($inc, $question_info['question']);
                break;
            case 'yn2':
                //Yes (Y) or (1)
                //No (N) or (2)
                //Undecided (U) or (3)
                return $this->singleAnswerQuestion_YN2($inc, $question_info['question']);
            case 'ein':    
                //Effective (E) or (1)
                //Ineffective (I) or (2)
                //Neutral (N) or (0)
                return $this->singleAnswerQuestion_EIN($inc, $question_info['question']);
            case 'lkr':
                //Likert
                
                //explode tbtest_items.CorrectAns
                $CorrectAns = explodeData('CorrectAns', $question_info['CorrectAns']);
                //count correct answers
                $count_options = count($CorrectAns);
                
                if($count_options == 5){
                    $options['options_type'] = '1';
                    $options['key'] = [1,2,3,4,5];
                    $options['val'] = ['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'];
                    $initial_option = "Neutral";
                } else if ($count_options == 7){
                    $options['options_type'] = '2';
                    $options['key'] = [1,2,3,4,5,6,7];
                    $options['val'] = ['Very Untrue of Me', 'Untrue of Me', 'Somewhat Untrue of Me', 'Neither True or Untrue', 'Somewhat True of Me', 'True of Me', 'Very True of Me'];
                    $initial_option = "Neither True or Untrue";
                } else {
                    //default
                    $options['options_type'] = '1';
                    $options['key'] = [1,2,3,4,5];
                    $options['val'] = ['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'];
                    $initial_option = "Neutral";
                }
                
                return $this->singleAnswerQuestion_LKR($inc, $question_info['question'], $options, $initial_option);
                break;
                
            case 'pti':
                
                //explode tbtest_items.CorrectAns
                $CorrectAns = explodeData('CorrectAns', $question_info['CorrectAns']);
                //count correct answers
                $correct_answers = 0;
                foreach($CorrectAns as $ans){
                    if($ans > 0){
                        ++$correct_answers;
                    }
                }                
                
                if($correct_answers > 1){
                    return $this->multiAnswerQuestion($inc, $question_info['question'], $question_info['options']);
                } else {
                    return $this->singleAnswerQuestion($inc, $question_info['question'], $question_info['options']);
                }
                break; 
                
            case 'rn1':
                //Ranking
                
                $ranking['ranking_question_type'] = '2';
                $ranking['question'] = [1 => '1-Least like you',
                                        2 => '2-Next Least like you',
                                        3 => '3-Next Most like you',
                                        4 => '4-Most like you'];
                return $this->multiAnswerQuestion_RN1($inc, $question_info['question'], $question_info['options'], $ranking);
                break;
            
            case 'rn2':
                
                return $this->singleAnswerQuestion_RN2($inc, $question_info['question']);
                break;
            
            case 'rn3':
                
                return $this->singleAnswerQuestion_RN3($inc, $question_info['question']);
                break;
            
            default:
                return '';
        }
         
    }
    
    
    protected function singleAnswerQuestion_RN3($inc, $question){
        
        $value = "<font color=\"#000000\">&lt;input type=\"text\" onkeyup=\"javascript:char_question_rn3_onKeyUp(this);\" onblur=\"javascript:char_question_rn3_onBlur(this);\" maxlength=\"1\" style=\"width:75px;\" id=\"char_question_".$inc."\" name=\"char_question_".$inc."\"&gt;&amp;nbsp;".$question."&lt;hr&gt;</font>";
        
        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $value,
            "access" => false,
        ];
    }
    
    
    protected function singleAnswerQuestion_RN2($inc, $question){
        
        $value = "<font color=\"#000000\">&lt;input type=\"text\" onkeyup=\"javascript:char_question_onKeyUp(this);\" onblur=\"javascript:char_question_onBlur(this);\" maxlength=\"1\" style=\"width:75px;\" id=\"char_question_".$inc."\" name=\"char_question_".$inc."\"&gt;&amp;nbsp;".$question."&lt;hr&gt;</font>";
        
        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $value,
            "access" => false,
        ];
    }
    
    
    protected function multiAnswerQuestion_RN1($inc, $question, $options, $ranking){
        
        $ranking_question_html = '';
        foreach($ranking['question'] as $key => $rank_question){
            $ranking_question_html .= "<p>{$rank_question}<input type='hidden' id='q{$inc}_{$key}' name='q{$inc}_{$key}'></p>";
        }        
        
        $choice_html = '';
        $choices_arr = explodeData('options', $options);
        foreach ($choices_arr as $key => $choice){ 
            $choice_html .= "<div class='col-xs ranking-choice c{$inc}_{$key}'>{$choice}</div>";
        }
        
        
        $value = "
<div class='container-fluid'>
    <div class='row ranking-question'>
        <div class='col-sm ranking-question-box-left' id='q{$inc}'>
            {$ranking_question_html}
        </div>
        <div class='col-sm ranking-question-box-right'>
        <div class='row ranking-choice-box' id='q{$inc}'>
            {$choice_html}
        </div>
        <br>
        {$question}
    </div>
</div>";
        
        return (object)[
            "type" => "rankingQuestion",
            "required" => false,
            "label" => '#3 Ranking Answer (DISC)',
            "name" => "rankingQuestion-".$inc."",
            "access" => false,
            "value" => $value,
            "question_type" => "rn1",
            "rn_question" => $ranking['ranking_question_type'],
        ];
    }
    
    protected function singleAnswerQuestion_LKR($inc, $question, $options, $initial_option = "Neutral"){
        
        $values = [];
        $total_options = count($options['val']);
        $data_options_type = $options['options_type']; 
        $imploded_options_key = implode(':', $options['key']);
        $imploded_options_val = implode(':', $options['val']);

        $value = "<div class=\"sliderTypeQuestion\">\t<div>{$question}</div>\t<br>\t";
        $value .= "<div class=\"sliderTypeQuestion_text\" id=\"q_sl_{$inc}\">\t\t<span>{$initial_option}</span>\t</div>\t<br>\t<div class=\"sliderTypeQuestion_choice\" id=\"q_sl_{$inc}\">\t\t<input type=\"range\" class=\"custom-range\" min=\"1\" max=\"{$total_options}\" step=\"1\" id=\"sliderTypeQuestion_range\" name=\"q_sl_{$inc}\" data-options-key=\"{$imploded_options_key}\" data-options-val=\"{$imploded_options_val}\" data-options-type=\"{$data_options_type}\">\t</div></div>";
        
        return (object)[
            "type" => "sliderQuestion",
            "required" => false,
            "label" => '<b>Slider Type Answer</b>',
            "name" => "sliderQuestion-".$inc."",
            "access" => false,
            "value" => $value,
            "question_type" => "lkr",
            "slider_options" => $data_options_type,
        ];
    }
    
    
    protected function singleAnswerQuestion_EIN($inc, $question, $options = ['1' => 'Effective', '2' => 'Ineffective', '0' => 'Neutral']){
        
        $values = [];
        foreach($options as $opt_key => $opt_value){
            $values[] = (object)[
                "label" => $opt_value,
                "value" => $opt_key,
            ];
        }
        
        return (object)[
            "type" => "radio-group",
            "required" => false,
            "label" => htmlentities(strip_tags($question)),
            "inline" => false,
            "name" => "radio-group-".$inc."",
            "access" => false,
            "other" => false,
            "values" => $values
        ];
    }
    
    protected function singleAnswerQuestion_YN2($inc, $question, $options = ['1' => 'Yes', '2' => 'No', '3' => 'Undecided']){

        //WITH IMAGE
        $value = "&lt;p&gt;".$question."&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\"&gt;<br>&lt;center&gt;&lt;input type=\"radio\" name=\"yn2_q_".$inc."\" id=\"yn2_q_".$inc."_y\" value=\"1\" /&gt;&lt;label for=\"yn2_q_".$inc."_y\"&gt;&lt;img for=\"yn2_q_".$inc."_y\" src=\"../img/assessments/types/yn2/Yes.png\" width=\"70\" height=\"70\" alt=\"Yes\" /&gt;&lt;/label&gt;&lt;span style=\"width: 10%;display: inline-block;\"&gt;&lt;/span&gt;&lt;input type=\"radio\" name=\"yn2_q_".$inc."\" id=\"yn2_q_".$inc."_n\" value=\"2\" /&gt;&lt;label for=\"yn2_q_".$inc."_n\"&gt;&lt;img for=\"yn2_q_".$inc."_n\" src='../img/assessments/types/yn2/No.png' width=\"70\" height=\"70\" alt=\"No\" /&gt;&lt;/label&gt;&lt;span style=\"width: 10%;display: inline-block;\"&gt;&lt;/span&gt;&lt;input type=\"radio\" name=\"yn2_q_".$inc."\" id=\"yn2_q_".$inc."_u\" value=\"0.5\" /&gt;&lt;label for=\"yn2_q_".$inc."_u\"&gt;&lt;img for=\"yn2_q_".$inc."_u\" src='../img/assessments/types/yn2/Undecided.png' width=\"70\" height=\"70\" alt=\"Undecided\" /&gt;&lt;/label&gt;&lt;/center&gt;<br>&lt;/div&gt;";

        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $value,
            "access" => false,
        ];
        
//        //BASIC
//        $values = [];
//        foreach($options as $opt_key => $opt_value){
//            $values[] = (object)[
//                "label" => $opt_value,
//                "value" => $opt_key,
//            ];
//        }
//        return (object)[
//            "type" => "radio-group",
//            "required" => false,
//            "label" => htmlentities(strip_tags($question)),
//            "inline" => false,
//            "name" => "radio-group-".$inc."",
//            "access" => false,
//            "other" => false,
//            "values" => $values
//        ];
        
    }
    
    protected function singleAnswerQuestion_YN1($inc, $question, $options = ['1' => 'Yes', '2' => 'No']){
        
        //WITH IMAGE
        $value = "&lt;p&gt;".$question."&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\"&gt;<br>&lt;center&gt;&lt;input type=\"radio\" name=\"yn1_q_".$inc."\" id=\"yn1_q_".$inc."_y\" value=\"1\" /&gt;&lt;label for=\"yn1_q_".$inc."_y\"&gt;&lt;img for=\"yn1_q_".$inc."_y\" src=\"../img/assessments/types/yn1/Yes.png\" width=\"70\" height=\"70\" alt=\"Yes\" /&gt;&lt;/label&gt;&lt;span style=\"width: 10%;display: inline-block;\"&gt;&lt;/span&gt;&lt;input type=\"radio\" name=\"yn1_q_".$inc."\" id=\"yn1_q_".$inc."_n\" value=\"2\" /&gt;&lt;label for=\"yn1_q_".$inc."_n\"&gt;&lt;img for=\"yn1_q_".$inc."_n\" src='../img/assessments/types/yn1/No.png' width=\"70\" height=\"70\" alt=\"No\" /&gt;&lt;/label&gt;&lt;/center&gt;<br>&lt;/div&gt;";

        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $value,
            "access" => false,
        ];
        
//        //BASIC
//        $values = [];
//        foreach($options as $opt_key => $opt_value){
//            $values[] = (object)[
//                "label" => $opt_value,
//                "value" => $opt_key,
//            ];
//        }
//        return (object)[
//            "type" => "radio-group",
//            "required" => false,
//            "label" => htmlentities(strip_tags($question)),
//            "inline" => false,
//            "name" => "radio-group-".$inc."",
//            "access" => false,
//            "other" => false,
//            "values" => $values
//        ];
        
    }
    
    protected function singleAnswerQuestion_TF2($inc, $question, $options = ['1' => 'True', '2' => 'False', '3' => 'Undecided']){
        
        //WITH IMAGE
        $value = "&lt;p&gt;".$question."&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\"&gt;<br>&lt;center&gt;&lt;input type=\"radio\" name=\"tf2_q_".$inc."\" id=\"tf2_q_".$inc."_t\" value=\"1\" /&gt;&lt;label for=\"tf2_q_".$inc."_t\"&gt;&lt;img for=\"tf2_q_".$inc."_t\" src=\"../img/assessments/types/tf2/True.png\" width=\"70\" height=\"70\" alt=\"True\" /&gt;&lt;/label&gt;&lt;span style=\"width: 10%;display: inline-block;\"&gt;&lt;/span&gt;&lt;input type=\"radio\" name=\"tf2_q_".$inc."\" id=\"tf2_q_".$inc."_f\" value=\"2\" /&gt;&lt;label for=\"tf2_q_".$inc."_f\"&gt;&lt;img for=\"tf2_q_".$inc."_f\" src='../img/assessments/types/tf2/False.png' width=\"70\" height=\"70\" alt=\"False\" /&gt;&lt;/label&gt;&lt;span style=\"width: 10%;display: inline-block;\"&gt;&lt;/span&gt;&lt;input type=\"radio\" name=\"tf2_q_".$inc."\" id=\"tf2_q_".$inc."_u\" value=\"0.5\" /&gt;&lt;label for=\"tf2_q_".$inc."_u\"&gt;&lt;img for=\"tf2_q_".$inc."_u\" src='../img/assessments/types/tf2/Undecided.png' width=\"70\" height=\"70\" alt=\"Undecided\" /&gt;&lt;/label&gt;&lt;center&gt;<br>&lt;/div&gt;";
        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $value,
            "access" => false,
        ];
        
//        //BASIC
//        $values = [];
//        foreach($options as $opt_key => $opt_value){
//            $values[] = (object)[
//                "label" => $opt_value,
//                "value" => $opt_key,
//            ];
//        }
//        
//        return (object)[
//            "type" => "radio-group",
//            "required" => false,
//            "label" => htmlentities(strip_tags($question)),
//            "inline" => false,
//            "name" => "radio-group-".$inc."",
//            "access" => false,
//            "other" => false,
//            "values" => $values
//        ];
        
    }
    
    protected function singleAnswerQuestion_TF1($inc, $question, $options = ['1' => 'True', '2' => 'False']){
        
        //WITH IMAGE
        $value = "&lt;p&gt;".$question."&lt;/p&gt;&lt;div id=\"radio-image-selector\"&gt;<br>&lt;center&gt;<br>&lt;input type=\"radio\" name=\"tf1_q_".$inc."\" id=\"tf1_q_".$inc."_t\" value=\"1\" /&gt;&lt;label for=\"tf1_q_".$inc."_t\"&gt;&lt;img for=\"tf1_q_".$inc."_t\" src=\"../img/assessments/types/tf1/True.png\" width=\"70\" height=\"70\" alt=\"True\" /&gt;&lt;/label&gt;&lt;span style=\"width: 10%;display: inline-block;\"&gt;&lt;/span&gt;&lt;input type=\"radio\" name=\"tf1_q_".$inc."\" id=\"tf1_q_".$inc."_f\" value=\"2\" /&gt;&lt;label for=\"tf1_q_".$inc."_f\"&gt;&lt;img for=\"tf1_q_".$inc."_f\" src='../img/assessments/types/tf1/False.png' width=\"70\" height=\"70\" alt=\"False\" /&gt;&lt;/label&gt;<br>&lt;/center&gt;<br>&lt;/div&gt;";
        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $value,
            "access" => false,
        ];
        
//        //BASIC       
//        $values = [];
//        foreach($options as $opt_key => $opt_value){
//            $values[] = (object)[
//                "label" => $opt_value,
//                "value" => $opt_key,
//            ];
//        }
//        return (object)[
//            "type" => "radio-group",
//            "required" => false,
//            "label" => htmlentities(strip_tags($question)),
//            "inline" => false,
//            "name" => "radio-group-".$inc."",
//            "access" => false,
//            "other" => false,
//            "values" => $values
//        ];
        
    }
    
    protected function singleAnswerQuestion_WH($inc, $question, $options = ['1' => 'What kind of', '2' => 'How']){
        
        $values = [];
        foreach($options as $opt_key => $opt_value){
            $values[] = (object)[
                "label" => $opt_value,
                "value" => $opt_key,
            ];
        }
        
        return (object)[
            "type" => "radio-group",
            "required" => false,
            "label" => htmlentities(strip_tags($question)),
            "inline" => false,
            "name" => "radio-group-".$inc."",
            "access" => false,
            "other" => false,
            "values" => $values
        ];
    }
    
    protected function singleAnswerQuestion_CD($inc, $question, $options = ['1' => 'Contributes', '2' => 'Detracts']){
        
        $values = [];
        foreach($options as $opt_key => $opt_value){
            $values[] = (object)[
                "label" => $opt_value,
                "value" => $opt_key,
            ];
        }
        
        return (object)[
            "type" => "radio-group",
            "required" => false,
            "label" => htmlentities(strip_tags($question)),
            "inline" => false,
            "name" => "radio-group-".$inc."",
            "access" => false,
            "other" => false,
            "values" => $values
        ];
    }
    
    
     protected function multiAnswerQuestion_CustomMC2($inc, $question, $options){
        
        $choices = '';
        $i=1;
        $value = '';
        $options = explodeData('options', $options);
        foreach($options as $opt_key => $opt_value){
           $choices .= "\t<div class=\"row custom_mc_row\">\t\t<label class=\"custom_mc_container q{$inc}\">\t\t\t<input class=\"custom_mc_checkbox\" type=\"checkbox\" name=\"q{$inc}[]\" value=\"{$i}\">\t\t\t{$opt_value}\t\t</label>\t</div>";
           $i++;
        }
        $value = "<div class=\"container\">\t<div class=\"row custom_mc_row_question\">\t\t<b>{$inc}.&nbsp;</b>\t\t{$question}\t</div>{$choices}</div>";
        
        return (object)[
            "type" => "customMC2Question",
            "label" => "Custom mc2 Answer",
            "name" => "customMC2Question-".$inc."",
            "access" => false,
            "value" => $value
        ];
        
    }
   
    protected function singleAnswerQuestion_Custom($inc, $question, $options){
        
        $choices = '';
        $i=1;
        $value = '';
        $options = explodeData('options', $options);
        foreach($options as $opt_key => $opt_value){
           $choices .= "\t<div class=\"row custom_mc_row\">\t\t<label class=\"custom_mc_container q{$inc}\">\t\t\t<input class=\"custom_mc_radio\" type=\"radio\" name=\"q{$inc}\" value=\"{$i}\">\t\t\t{$opt_value}\t\t</label>\t</div>";
           $i++;
        }
        $value = "<div class=\"container\">\t<div class=\"row custom_mc_row_question\">\t\t<b>{$inc}.&nbsp;</b>\t\t{$question}\t</div>{$choices}</div>";
        
        return (object)[
            "type" => "customMC1Question",
            "label" => "Custom mc1 Answer",
            "name" => "customMC1Question-".$inc."",
            "access" => false,
            "value" => $value
        ];
        
    }
    
    protected function multiAnswerQuestion_Custom($inc, $question, $options){
        
        $choices = '';
        $i=1;
        $value = '';
        $options = explodeData('options', $options);
        foreach($options as $opt_key => $opt_value){
           $choices .= "\t<div class=\"row custom_mc_row\">\t\t<label class=\"custom_mc_container q{$inc}\">\t\t\t<input class=\"custom_mc_checkbox\" type=\"checkbox\" name=\"q{$inc}[]\" value=\"{$i}\">\t\t\t{$opt_value}\t\t</label>\t</div>";
           $i++;
        }
        $value = "<div class=\"container\">\t<div class=\"row custom_mc_row_question\">\t\t<b>{$inc}.&nbsp;</b>\t\t{$question}\t</div>{$choices}</div>";
        
        return (object)[
            "type" => "customMC2Question",
            "label" => "Custom mc2 Answer",
            "name" => "customMC2Question-".$inc."",
            "access" => false,
            "value" => $value
        ];
        
    }
   
    protected function singleAnswerQuestion_CustomMC1($inc, $question, $options){
        
        $choices = '';
        $i=1;
        $value = '';
        $options = explodeData('options', $options);
        foreach($options as $opt_key => $opt_value){
           $choices .= "\t<div class=\"row custom_mc_row\">\t\t<label class=\"custom_mc_container q{$inc}\">\t\t\t<input class=\"custom_mc_radio\" type=\"radio\" name=\"q{$inc}\" value=\"{$i}\">\t\t\t{$opt_value}\t\t</label>\t</div>";
           $i++;
        }
        $value = "<div class=\"container\">\t<div class=\"row custom_mc_row_question\">\t\t<b>{$inc}.&nbsp;</b>\t\t{$question}\t</div>{$choices}</div>";
        
        return (object)[
            "type" => "customMC1Question",
            "label" => "Custom mc1 Answer",
            "name" => "customMC1Question-".$inc."",
            "access" => false,
            "value" => $value
        ];
        
    }
    
    protected function singleAnswerQuestion($inc, $question, $options){
        
        $values = [];
        $options = explodeData('options', $options);
        foreach($options as $opt_key => $opt_value){
            $values[] = (object)[
                "label" => $opt_value,
                "value" => $opt_key,
            ];
        }
        
        return (object)[
            "type" => "radio-group",
            "required" => false,
            "label" => htmlentities(strip_tags($question)),
            "inline" => false,
            "name" => "radio-group-".$inc."",
            "access" => false,
            "other" => false,
            "values" => $values
        ];
    }
    

    protected function multiAnswerQuestion($inc, $question, $options){
        
        $values = [];
        $options = explodeData('options', $options);
        foreach($options as $opt_key => $opt_value){
            $values[] = (object)[
                "label" => $opt_value,
                "value" => $opt_key,
            ];
        }
        
        return (object)[
            "type" => "checkbox-group",
            "required" => false,
            "label" => htmlentities(strip_tags($question)),
            "toggle" => false,
            "inline" => false,
            "name" => "checkbox-group-".$inc."",
            "access" => false,
            "other" => false,
            "values" => $values
        ];
        
    }
    
     protected function instructionPage($inc, $html){
         
        return (object)[
            "type" => "paragraph",
            "subtype" => "p",
            "label" => $html,
            "access" => false,
        ];
     
    }



    //Ajax requests under this controller will be passed here
    public function submitAjax(){
        parent::submitAjax();
        
        $ajax_name = $_POST['ajax_name'];
        switch ($ajax_name) {
            case "save_test":
                ajax_save_test();
                break;
            case "update_test":
                $test_id = $_POST['test_id'];
                ajax_update_test($test_id);
                break;
            default:
              echo "ajax_name not found.";
        }
        
    }
    
}
