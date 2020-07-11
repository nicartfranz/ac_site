<?php 

class Ppp2Controller extends Controller{

    public $ass_code = 'ppp2';
    public $site_level_form_builder_js = [
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
        'public/js/testtaking.js',
    ];

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }
    
    
    public function index(){
        
//        //--SUBMIT PREV FORM---//
//        $this->submitForm(true);
//        $this->saveSnapshot();
//        //--------------------//
        
        
        if(isset($_POST['submit_index']) && !empty($_POST['submit_index'])){
            $submit_index = xss_clean($_POST['submit_index']);
            if($submit_index == 'go_back_home'){
                echo 'Home';
                header("Location:".APP_BASE_URL."candidate/");
            } else if ($submit_index == 'page2'){
                echo 'Proceed';
                header("Location:".APP_BASE_URL."ppp2/page2");
            }
        } 

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);

        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);

        //3.) Set test page timer
        testTimer('unset', $this->ass_code, 0); //unset timer on this page

        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page1']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page1'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page1'][0]->enableSnapshot;
        
        $test_info['submit_page'] = ''; //'page2';
      
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array('public/css/ppp2.css',); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
                
    public function page1(){
        $this->index();
    }

                
    public function page2(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(true);
        $this->saveSnapshot();
        //--------------------//

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);

        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);

        //3.) Set test page timer
        testTimer('unset', $this->ass_code, 0); //unset timer on this page

        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page2']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page2'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page2'][0]->enableSnapshot;
        $test_info['submit_page'] = 'finish';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array('public/css/ppp2.css',); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
    
     public function finish(){
        
        //--SUBMIT PREV FORM---//
        //$this->submitForm(false);
//        echo '<pre>';
//        print_r($this->savePPP2Responses());
//        echo '</pre>';
        $this->saveSnapshot();
        //--------------------//
        
        //remove currently active timer
        testTimer('unset', $this->ass_code, 0);
        
        $content = $this->getView('pages/candidate/finish');
        
        $html = [
            'includeSiteLevelJS' => [
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
        
        
    }

    private function savePPP2Responses(){
        
        if(isset($_POST['save']) && $_POST['save'] == '1'){
            
            $dimension_scores = array('dim_1' => 0, 'dim_2' => 0, 'dim_3' => 0, 'dim_4' => 0);
            $item_dimension_order = array(
                array('2', '1', '4', '3'), //item 1 dim order
                array('2', '3', '1', '4'), //item 2 dim order
                array('3', '2', '4', '1'), //..
                array('1', '4', '2', '3'),
                array('4', '3', '1', '2'),
                array('2', '1', '4', '3'),
                array('2', '3', '1', '4'),
                array('2', '3', '4', '1'),
                array('4', '1', '2', '3'),
                array('2', '1', '3', '4'),
                array('1', '2', '4', '3'),
                array('4', '2', '3', '1'),
                array('1', '4', '3', '2'),
                array('3', '2', '1', '4'),
                array('2', '1', '4', '3'),
                array('4', '3', '2', '1'),
                array('2', '4', '1', '3'),
                array('1', '4', '3', '2'),
                array('4', '1', '2', '3'),
                array('3', '2', '1', '4'),
                array('2', '1', '3', '4'),
                array('4', '2', '1', '3')  //item 22 dim order
            );

            $total_items = 22;
            $answer_str = '';
            
            for($i = 1; $i <= $total_items; $i++){

                $item_i = array();
                if(isset($_POST['q'.$i])){
                    $item_i = $_POST['q'.$i]; 
                }

                //gather responses
                $answers = '';
                $answer_str .= $i.':';
                $answers .= implode('', $item_i);//ITEM RESPONSE 1st-3rd
                //get missing item  from 1-4
                $given_answer = $_POST['q'.$i]; //ITEM RESPONSE 4th
                $answers_range = range(1,4);                                                    
                $answers .= implode('', array_diff($answers_range,$given_answer)); 
                
                //sum responses by item dimension order
                $item_ans_arr = str_split($answers);
                foreach($item_ans_arr as $item_answer_key => $item_answer_value){
                    $identify_dimension = 'dim_' . $item_dimension_order[$i-1][$item_answer_key];
                    $dimension_scores[$identify_dimension] += $item_answer_value;
                }
                
                
                //at this point it is = 1:4132
                $answer_str .= $answers;

                if($i != $total_items){
                    $answer_str .= ';';
                }

            }
            
            
            //TO DO
            #1 UPDATE tbstatus to scored
            #2 CREATE RECORD IN tbanswer
            #3 CREATE RECORD IN tbresult
            #4 send report using the template

            return array('tbanswer__answer' => $answer_str, 'tbresult__scores' => $dimension_scores);

        } 
        
        return false;
        
    } 
        
}

