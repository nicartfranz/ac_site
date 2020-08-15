<?php 

class DemoController extends Test{

    public $ass_code = 'demo';
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
        'public/js/formbuilder/control_plugins/single_char_question_template.js',
        'public/js/formbuilder/control_plugins/true_false_question_template.js',
        'public/js/formbuilder/control_plugins/yes_no_question_template.js',
        'public/js/formbuilder/control_plugins/true_false_undecided_question_template.js',
        'public/js/formbuilder/control_plugins/yes_no_undecided_question_template.js',
        'public/js/formbuilder/control_plugins/video_question_template.js',
        'public/js/formbuilder/control_plugins/record_video_answer_template.js',
        'public/js/formbuilder/control_plugins/demo_test_component_template.js',
        'public/js/fb_fields_acsite.js',
        'public/js/testtaking.js',
    ];

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
        
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';

        $this->demo_model = $this->initModel('DemoModel');
        $last_visited_page = $this->demo_model->getLastVisitedPage();
        if(getCurrentTestPage() < $last_visited_page){
            header('Location:'.APP_BASE_URL.$this->ass_code.'/page'.$last_visited_page);
        }
        
    }
    
    
    public function index(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 1 load, update tbstatus
        $tbstatus = array('status' => 'started', 'page' => '1', 'date_started' => date('Y-m-d H:i:s'));
        $this->demo_model->update_tbstatus($tbstatus);

                
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
        $test_info['submit_page'] = 'finish';
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

                
                
    public function finish(){
    
        //On page 2 load, update tbstatus 
        $tbstatus = array('status' => 'scored', 'page' => '2', 'date_completed' => date('Y-m-d H:i:s'), '`usage`' => date('Yn'));
        $this->demo_model->update_tbstatus($tbstatus);

        parent::finish();
    }

        
}