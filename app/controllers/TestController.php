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
            $content = $this->getView('pages/admin/test_conversion', ['test' => $test_info]);
            
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
        
        $build_test = $this->buildTest($items_for_conversion);
        if(!$this->has_error){
            $insert = [];
            $insert['ass_code'] = $tb_assessment['AssCode']; 
            $insert['total_pages'] = count($tb_dimensions); 
            $insert['question'] = json_encode($build_test);
            $test->save_tbtest_items_summary($insert);
            //conversion end
            header("Location:".APP_BASE_URL."test/view/?id=".$assessment_id);
        } else {
            header("Location:".APP_BASE_URL."test/view/?id=".$assessment_id."&err_msg=".xss_clean($build_test));
        }
        
    }
        
    function buildTest($data){

        $final_test = array();
        $error = [];
        
        
        if(empty($data)){
            return $error[] = 'No data found';
        }
        
        
        //Start building the test
        $inc = 0;
        foreach($data['tb_dimensions'] as $dimension){
            
            //Start Marker
            $final_test[] = $this->startMarker($inc);
            
            //Questions
            foreach($data['questions'] as $question_info){
                
                if($dimension['dimensionNumber'] == $question_info['level']){
                    
                    $generate_question = $this->generate_question($inc++, $question_info);
                    if($this->has_error){
                        return (is_array($generate_question)) ? implode(', ', $generate_question) : $generate_question;
                    } else {
                        $final_test[] = $generate_question;
                    }
                    
                }
                
            }
            
            //Submit Button
            $final_test[] = $this->defaultSubmitButton($inc);
                    
            //End Marker
            $final_test[] = $this->endMarker($inc);       
            
        }
        
        return $final_test;
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
        
        $valid_question_types = ['mc1', 'mc2', 'mc3', 'mc4', 'cd', 'wh', 'tf1', 'tf2', 'yn1', 'yn2', 'ein', 'lkr'];
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
                
                if($correct_answers > 1){
                    return $this->multiAnswerQuestion($inc, $question_info['question'], $question_info['options']);
                } else {
                    return $this->singleAnswerQuestion($inc, $question_info['question'], $question_info['options']);
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
                
                //default
//                $options['key'] = [1,2,3,4,5];
//                $options['val'] = ['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'];
//                $initial_option = "Neutral";
//                
//                $options['key'] = [1,2,3,4,5,6,7];
//                $options['val'] = ['Very Untrue of Me', 'Untrue of Me', 'Somewhat Untrue of Me', 'Neither True or Untrue', 'Somewhat True of Me', 'True of Me', 'Very True of Me'];
//                $initial_option = "Neither True or Untrue";
                
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
            default:
                return '';
        }
         
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
    
    protected function singleAnswerQuestion_YN1($inc, $question, $options = ['1' => 'Yes', '2' => 'No']){
        
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
    
    protected function singleAnswerQuestion_TF2($inc, $question, $options = ['1' => 'True', '2' => 'False', '3' => 'Undecided']){
        
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
    
    protected function singleAnswerQuestion_TF1($inc, $question, $options = ['1' => 'True', '2' => 'False']){
        
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
