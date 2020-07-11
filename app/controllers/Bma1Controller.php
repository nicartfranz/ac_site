<?php 

class Bma1Controller extends Controller{

    public $ass_code = 'bma1';
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
        'public/js/formbuilder/control_plugins/customMC1Question.js',
        'public/js/formbuilder/control_plugins/customMC2Question.js',
        'public/js/fb_fields_acsite.js',
        'public/js/testtaking.js',
    ];

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }
    
    
    public function index(){
        
        //--SUBMIT PREV FORM---//
        //$this->submitForm(false);
        //$this->saveSnapshot();
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
        $test_info['question'] = json_encode($question_arr['page1']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page1'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page1'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page2';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
                
    public function page1(){
        $this->index();
    }

                
    public function page2(){
        
        //--SUBMIT PREV FORM---//
        //$this->submitForm(false);
        //$this->saveSnapshot();
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
        $test_info['submit_page'] = 'page3';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page3(){
        
        //--SUBMIT PREV FORM---//
        //$this->submitForm(false);
        //$this->saveSnapshot();
        //--------------------//

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);

        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);

        //3.) Set test page timer
        testTimer('init', $this->ass_code, $question_arr['page3'][0]->setTimer); //unset timer on this page

        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page3']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page3'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page3'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page4';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page4(){
        
        //--SUBMIT PREV FORM---//
//        echo '<pre>';
//        print_r($this->saveBMA1Answers(1));
//        echo '</pre>';
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
        $test_info['question'] = json_encode($question_arr['page4']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page4'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page4'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page5';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page5(){
        
        //--SUBMIT PREV FORM---//
        //$this->submitForm(false);
        //$this->saveSnapshot();
        //--------------------//

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);

        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);

        //3.) Set test page timer
        testTimer('init', $this->ass_code, $question_arr['page5'][0]->setTimer); //unset timer on this page

        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page5']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page5'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page5'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page6';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page6(){
        
        //--SUBMIT PREV FORM---//
//        echo '<pre>';
//        print_r($this->saveBMA1Answers(2));
//        echo '</pre>';
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
        $test_info['question'] = json_encode($question_arr['page6']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page6'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page6'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page7';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
    
    public function page7(){
        
        //--SUBMIT PREV FORM---//
        //$this->submitForm(false);
        //$this->saveSnapshot();
        //--------------------//

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);

        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);

        //3.) Set test page timer
        testTimer('init', $this->ass_code, $question_arr['page7'][0]->setTimer); //unset timer on this page

        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page7']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page7'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page7'][0]->enableSnapshot;
        $test_info['submit_page'] = 'finish';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
    
    
     public function finish(){
        
        //--SUBMIT PREV FORM---//
//        echo '<pre>';
//        print_r($this->saveBMA1Answers(3));
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
    
    
     private function saveBMA1Answers($dim_id){

         if(isset($_POST['save']) && $_POST['save'] == '1'){
            
            $all_dim_correct_answers = array(
                'q1' => 'B',
                'q2' => 'B',
                'q3' => 'A',
                'q4' => 'D',
                'q5' => 'C',
                'q6' => 'D',
                'q7' => 'A',
                'q8' => 'F',
                'q9' => 'E',
                'q10' => 'A',
                'q11' => 'A',
                'q12' => 'C',
                'q13' => 'B',
                'q14' => 'A',
                'q15' => 'C',
                'q16' => 'B',
                'q17' => 'C',
                'q18' => 'B',
                'q19' => 'A',
                'q20' => 'D',
                'q21' => 'B',
                'q22' => 'B',
                'q23' => 'D',
                'q24' => 'B',
                'q25' => 'B',
                'q26' => 'D',
                'q27' => 'D',
                'q28' => 'B',
                'q29' => 'A',
                'q30' => 'A',
                'q31' => 'E',
                'q32' => 'B',
                'q33' => 'E',
                'q34' => 'C',
                'q35' => 'C',
                'q36' => 'A',
                'q37' => 'C',
                'q38' => 'D',
                'q39' => 'A',
                'q40' => 'B',
                'q41' => 'B',
                'q42' => 'D',
                'q43' => 'D',
                'q44' => 'B',
                'q45' => 'D',
            );

            
            if($dim_id == '1'){
                $item_start = 1;
                $item_end = 15;
            } else if ($dim_id == '2'){
                $item_start = 16;
                $item_end = 30;                
            } else if($dim_id == '3'){
                $item_start = 31;
                $item_end = 45;                
            }
            
            $answer_str = '';
            $dimension_score=0;
            for($i = $item_start; $i <= $item_end; $i++){
                
                //FORMAT
                //1:1:B;1:2:A;1:3:;1:4:B;1:5:;1:6:B;1:7:;1:8:B;1:9:;1:10:E;1:11:A;1:12:C;1:13:A;1:14:B;1:15:B;
                //2:16:A;2:17:A;2:18:A;2:19:B;2:20:B;2:21:C;2:22:E;2:23:C;2:24:D;2:25:D;2:26:C;2:27:C;2:28:D;2:29:D;2:30:C;
                //3:31:E;3:32:A;3:33:B;3:34:A;3:35:A;3:36:A;3:37:A;3:38:A;3:39:A;3:40:A;3:41:A;3:42:A;3:43:A;3:44:A;3:45:A;
                if(isset($_POST['q'.$i])){
                    $raw_response = xss_clean($_POST['q'.$i]);//integer
                    $get_letter = range('A', 'Z')[$raw_response-1];
                    $answer_str .= $dim_id.':'.$i.':'.$get_letter.';';
                    
                    if($get_letter == $all_dim_correct_answers['q'.$i]){
                        $dimension_score++;
                    }
                    
                } else {
                    $answer_str .= '';
                }

            }
            
            
            //TO DO
            #1 UPDATE tbstatus to scored
            #2 CREATE RECORD IN tbanswer
            #3 CREATE RECORD IN tbresult
            #4 send report using the template

            return array('tbanswer__answer' => $answer_str, 'tbresult__scores' => $dimension_score);

        } 
        
        return false;
        
    } 
    
            
}