<?php 

class FaqnController extends Controller{
    
    public $ass_code = 'faqn';

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }
    
    public function index(){
        
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
        //4.4) Set the submit_page
        $test_info['submit_page'] = (__FUNCTION__ == 'index') ? 'page2' : 'index'; 
        
        //5.) Load the testing page and pass the test_info array
        $content = $this->loadView('pages/candidate/testing', $test_info);
        
        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html = [
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
        
    }
    
    public function page1(){
        $this->index();
    }
    
    public function page2(){
        
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
        
        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);
        
        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);
        
        //3.) Set test page timer
        //testTimer('unset', $this->ass_code, 0); //unset timer on this page
        testTimer('init', $this->ass_code, $question_arr['page2'][0]->setTimer); //initialize a new timer for this test page
        
        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page2']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page2'][0]->onTimerTimesUp;
        //4.4) Set the submit_page
        $test_info['submit_page'] = 'page3'; 
        
        //5.) Load the testing page and pass the test_info array
        $content = $this->loadView('pages/candidate/testing', $test_info);
        
        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html = [
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);

    }
    
    
    public function page3(){
        
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);
        
        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);
        
        //3.) Set test page timer
        //testTimer('unset', '', 0); //unset timer on this page
        //testTimer('init', $this->ass_code, $question_arr['page2'][0]->setTimer); //initialize a new timer for this test page
        testTimer('continue', $this->ass_code, 0); // continue the timer set from the previous test page
        
        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page3']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page3'][0]->onTimerTimesUp;
        //4.4) Set the submit_page
        $test_info['submit_page'] = 'page4'; 
        
        //5.) Load the testing page and pass the test_info array
        $content = $this->loadView('pages/candidate/testing', $test_info);
        
        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html = [
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
     
    }
    
    public function page4(){
 
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';

        //1.) Initialize Model Class -> TestModel (For DB functions)
        $test = $this->initModel('TestModel');
        $test_data = $test->getTestByAssCode($this->ass_code);
        
        //2.) Get questions from db
        $question_arr = $this->loadQuestionCandidate($test_data['question']);
        
        //3.) Set test page timer
        //testTimer('unset', '', 0); //unset timer on this page
        //testTimer('init', $this->ass_code, $question_arr['page2'][0]->setTimer); //initialize a new timer for this test page
        //testTimer('continue', $this->ass_code, 0); // continue the timer set from the previous test page
        testTimer('unset', $this->ass_code, 0); //unset currently active timer
        testTimer('init', $this->ass_code, $question_arr['page4'][0]->setTimer); //initialize a new timer for this test page
        
        //4.) Set the required test_info variables
        $test_info = [];
        //4.1) Set AssCode
        $test_info['AssCode'] = $this->ass_code;
        //4.2) Set the questions to display
        $test_info['question'] = json_encode($question_arr['page4']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page4'][0]->onTimerTimesUp;
        //4.4) Set the submit_page
        $test_info['submit_page'] = 'finish'; 
        
        //5.) Load the testing page and pass the test_info array
        $content = $this->loadView('pages/candidate/testing', $test_info);
        
        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html = [
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
        
    }
   
    public function finish(){
        
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
        
        //remove currently active timer
        testTimer('unset', $this->ass_code, 0);
        
        $content = $this->loadView('pages/candidate/finish');
        
        $html = [
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/fb_fields_acsite.js',
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
        
        
    }
    
}