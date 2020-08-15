<?php 

class Bea1Controller extends Test{

    public $ass_code = 'bea1';
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
        'public/js/fb_fields_acsite.js',
        'public/js/testtaking.js',
    ];

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);

        $this->bea1_model = $this->initModel('Bea1Model');
        $last_visited_page = $this->bea1_model->getLastVisitedPage();
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
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 2 load, update tbstatus
        $tbstatus = array('page' => '2');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 3 load, update tbstatus
        $tbstatus = array('page' => '3');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 4 load, update tbstatus
        $tbstatus = array('page' => '4');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 5 load, update tbstatus
        $tbstatus = array('page' => '5');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 6 load, update tbstatus
        $tbstatus = array('page' => '6');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 7 load, update tbstatus
        $tbstatus = array('page' => '7');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $test_info['question'] = json_encode($question_arr['page7']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page7'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page7'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page8';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page8(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 8 load, update tbstatus
        $tbstatus = array('page' => '8');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $test_info['question'] = json_encode($question_arr['page8']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page8'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page8'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page9';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page9(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 9 load, update tbstatus
        $tbstatus = array('page' => '9');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $test_info['question'] = json_encode($question_arr['page9']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page9'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page9'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page10';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page10(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 10 load, update tbstatus
        $tbstatus = array('page' => '10');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $test_info['question'] = json_encode($question_arr['page10']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page10'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page10'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page11';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page11(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 11 load, update tbstatus
        $tbstatus = array('page' => '11');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $test_info['question'] = json_encode($question_arr['page11']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page11'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page11'][0]->enableSnapshot;
        $test_info['submit_page'] = 'page12';
        //5.) Load the testing page and pass the test_info array
        $content = $this->getView('pages/candidate/testing', $test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        $html['includeSiteLevelCSS'] = array(); //include site level css
        $html['includeSiteLevelJS'] = $this->site_level_form_builder_js; //include site level js
        $html['content'] = $content;
        $this->renderView('layouts/candidate', $html);
    }
            
            
    public function page12(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm(false);
        $this->saveSnapshot();
        //--------------------//
        
        
                
        //On page 12 load, update tbstatus
        $tbstatus = array('page' => '12');
        $this->bea1_model->update_tbstatus($tbstatus);

                
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
        $test_info['question'] = json_encode($question_arr['page12']);
        //4.3) Javascript to run on timer times up
        $test_info['onTimesUp'] = $question_arr['page12'][0]->onTimerTimesUp;
        //4.4) Snapshot
        $test_info['enableSnapshot'] = $question_arr['page12'][0]->enableSnapshot;
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
    
        //On page 13 load, update tbstatus 
        $tbstatus = array('status' => 'scored', 'page' => '13', 'date_completed' => date('Y-m-d H:i:s'), '`usage`' => date('Yn'));
        $this->bea1_model->update_tbstatus($tbstatus);

        parent::finish();
    }

        
}