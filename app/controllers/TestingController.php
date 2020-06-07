<?php

class TestingController extends Controller{
    
    public $ass_code = 'faqn';

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }
    
        public function index(){
        
        //1.) Init model
        //2.) Remove unnecessary attr in the html question
        //3.) Display the first page: identified by type:startPageMarker & type:endPageMarker
        $question_arr = $this->load_question();
        
        //Create test_info array and pass test_info data.
        $test_info = [];
        $test_info['AssCode'] = $this->ass_code;
        
        //4.) set the questions to display
        $test_info['question'] = json_encode($question_arr['page1']);
        
        //5.) set the submit_page
        $test_info['submit_page'] = (__FUNCTION__ == 'index') ? 'page2' : 'index'; 
        
        //6.) load the testing page inside page and pass the test_info/questions_info data
        $content = $this->loadView('pages/candidate/testing', $test_info);
        
        //7.) load the candidate template page, pass the candidate testing inside page then load the page.
        $html = [
            'includeSiteLevelJS' => [
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
        
//        //process page1 before rendering page 2 questions
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
//        
//        echo 'load questions on page 2';
        
        //1.) Init model
        //2.) Remove unnecessary attr in the html question
        //3.) Display the first page: identified by type:startPageMarker & type:endPageMarker
        $question_arr = $this->load_question();
        
        //Create test_info array and pass test_info data.
        $test_info = [];
        $test_info['AssCode'] = $this->ass_code;
        
        //4.) set the questions to display
        $test_info['question'] = json_encode($question_arr['page2']);
        
        //5.) set the submit_page
        $test_info['submit_page'] = 'finish'; 
        
        //6.) load the testing page inside page and pass the test_info/questions_info data
        $content = $this->loadView('pages/candidate/testing', $test_info);
        
        //7.) load the candidate template page, pass the candidate testing inside page then load the page.
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
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
        
        
    }
    
    public function load_question(){
        
        //1.) init model
        $test = $this->initModel('TestModel');
        $test_info = $test->getTestByAssCode($this->ass_code);
        
        $question_arr = [];
        
        $page_inc = 0;
        //2.) remove unnecessary attr in the html question
        $decoded_questions = json_decode($test_info['question']);
        foreach ($decoded_questions as $key => $question){
            unset($decoded_questions[$key]->part);
            unset($decoded_questions[$key]->section);
            unset($decoded_questions[$key]->fldQOrder);
            unset($decoded_questions[$key]->correctAns);
        
            //3.) Display the first page: identified by type:startPageMarker & type:endPageMarker
            if($decoded_questions[$key]->type == 'startPageMarker'){
                $page_inc++;
            }
            $test_info['page'.$page_inc][] = $decoded_questions[$key];

        }
        
        
        return $test_info;
        
    }
    
}
