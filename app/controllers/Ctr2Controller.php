<?php 

class Ctr2Controller extends Test{

    public $ass_code = 'ctr2';
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
        
        $this->ctr2_model = $this->initModel('Ctr2Model');
        $last_visited_page = $this->ctr2_model->getLastVisitedPage();
        if(getCurrentTestPage() < $last_visited_page){
            header('Location:'.APP_BASE_URL.$this->ass_code.'/page'.$last_visited_page);
        }
        
    }
    
    
    public function index(){
        
        //On page 1 load, update tbstatus
        $tbstatus = array('status' => 'started', 'page' => '1', 'date_started' => date('Y-m-d H:i:s'));
        $this->ctr2_model->update_tbstatus($tbstatus);

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
        $this->saveSnapshot($this->ass_code, 'page1');
        //--------------------//

        //On page 2 load, update tbstatus
        $tbstatus = array('page' => '2');
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
        //$this->saveSnapshot();
        //--------------------//

        //On page 3 load, update tbstatus
        $tbstatus = array('page' => '3');
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
        //SAVE: [tbanswer__answer]
        $tbanswer = array();
        $tbanswer['answer'] = $this->saveResponsesCTR2(1);
        $tbanswer['page'] = 4;
        $this->ctr2_model->save_update_tbanswer($tbanswer);
        //SAVE: [tbresult__scores]
        $responses_result = $this->saveResultCTR2(1);
        $tbresult = array();
        $tbresult['DimID'] = 1; 
        $tbresult['Score'] = $responses_result['result_Score'];
        $tbresult['fldAdjScore'] = $responses_result['result_fldAdjScore'];
        $tbresult['fldWrongAns'] = $responses_result['result_fldWrongAns'];
        $tbresult['fldUnAns'] = $responses_result['result_fldUnAns'];
        $this->ctr2_model->save_update_tbresult($tbresult);
        //$this->saveSnapshot();
        //--------------------//

        //On page 4 load, update tbstatus
        $tbstatus = array('page' => '4');
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
        //$this->saveSnapshot();
        //--------------------//

        //On page 5 load, update tbstatus
        $tbstatus = array('page' => '5');
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
        //SAVE: [tbanswer__answer]
        $tbanswer = array();
        $tbanswer['answer'] = $this->saveResponsesCTR2(2);
        $tbanswer['page'] = 6;
        $this->ctr2_model->save_update_tbanswer($tbanswer);
        //SAVE: [tbresult__scores]
        $responses_result = $this->saveResultCTR2(2);
        $tbresult = array();
        $tbresult['DimID'] = 2; 
        $tbresult['Score'] = $responses_result['result_Score'];
        $tbresult['fldAdjScore'] = $responses_result['result_fldAdjScore'];
        $tbresult['fldWrongAns'] = $responses_result['result_fldWrongAns'];
        $tbresult['fldUnAns'] = $responses_result['result_fldUnAns'];
        $this->ctr2_model->save_update_tbresult($tbresult);
        //$this->saveSnapshot();
        //--------------------//

        //On page 6 load, update tbstatus
        $tbstatus = array('page' => '6');
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
        //$this->saveSnapshot();
        //--------------------//

        //On page 7 load, update tbstatus
        $tbstatus = array('page' => '7');
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
        //SAVE: [tbanswer__answer]
        $tbanswer = array();
        $tbanswer['answer'] = $this->saveResponsesCTR2(3);
        $tbanswer['page'] = 8;
        $this->ctr2_model->save_update_tbanswer($tbanswer);
        //SAVE: [tbresult__scores]
        $responses_result = $this->saveResultCTR2(3);
        $tbresult = array();
        $tbresult['DimID'] = 3; 
        $tbresult['Score'] = $responses_result['result_Score'];
        $tbresult['fldAdjScore'] = $responses_result['result_fldAdjScore'];
        $tbresult['fldWrongAns'] = $responses_result['result_fldWrongAns'];
        $tbresult['fldUnAns'] = $responses_result['result_fldUnAns'];
        $this->ctr2_model->save_update_tbresult($tbresult);
        $this->saveSnapshot($this->ass_code, 'page7');
        //--------------------//
        
        //On page 8 load, update tbstatus
        $tbstatus = array('status' => 'scored', 'page' => '8', 'date_completed' => date('Y-m-d H:i:s'), '`usage`' => date('Ym'));
        $this->ctr2_model->update_tbstatus($tbstatus);
        
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
    
    
    public function saveResponsesCTR2($dimension_number){
        
        $responses = '';
        
        if($dimension_number == '1'){
            //Format is: 1:1:A;1:2:A;1:3:A;1:4:A;1:5:A;1:6:A;1:7:A;1:8:A;1:9:A;1:10:A;1:11:A;1:12:A;1:13:A;1:14:A;1:15:A;1:16:A;1:17:A;1:18:A;1:19:A;1:20:A;1:21:A;1:22:A;1:23:A;1:24:A;1:25:A;1:26:A;1:27:A;1:28:A;1:29:A;1:30:A;
            for($i=1;$i <= 30; $i++){
                
                if(isset($_POST['q'.$i])){
                    $raw_response = xss_clean($_POST['q'.$i]);//integer
                    $get_letter = range('A', 'Z')[$raw_response-1];
                    $responses .= '1:'.$i.':'.$get_letter.';';
                } else {
                    $responses .= '';
                }

            }
            
        } else if ($dimension_number == '2'){
            //Format is: //2:31a:A;2:31b:A;2:32:A;2:33:A;2:34:A;2:35a:A;2:35b:A;2:35c:A;2:35d:A;2:35e:A;2:36:A;2:37:A;2:38:A;2:39:A;2:40:A;2:41:A;2:42:A;2:43:A;2:44:A;2:45:A;2:46:A;2:47:A;2:48:A;2:49:A;2:50:A;
            $dim2_item_keys = array('31a', '31b', '32', '33', '34', '35a', '35b', '35c', '35d', '35e', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50');
            foreach($dim2_item_keys as $item_key){
                if(isset($_POST['q'.$item_key])){
                    $raw_response = xss_clean($_POST['q'.$item_key]);//integer
                    $get_letter = range('A', 'Z')[$raw_response-1];
                    $responses .= '2:'.$item_key.':'.$get_letter.';';
                } else {
                    $responses .= '';
                }
            }
            
        } else if ($dimension_number == '3'){
            //Format is: //3:51:AB;3:52:AB;3:53:AB;3:54:AB;3:55:AB;3:56:AB;3:57:AB;3:58:AB;3:59:AB;3:60:AB;
            for($i=51; $i<=60; $i++){
                
                if(isset($_POST['q'.$i])){
                    $raw_response = $_POST['q'.$i];//array integer
                    
                    $responses .= '3:'.$i.':';
                    $letters = '';
                    foreach ($raw_response as $r_response){
                        $get_letter = range('A', 'Z')[$r_response-1];
                        $letters .= $get_letter;
                    }
                    $responses .= $letters;
                    $responses .= ';';
                    
                } else {
                    $responses .= '';
                }
                
            }
            
        }
        
        return $responses;
        
    }
    
    
    function saveResultCTR2($dimension_number){
        
        $test = $this->initModel('TestModel');
        $test_items = $test->get_test_items2($this->ass_code);
        
        
        
        $result_Score = 0;
        $result_fldAdjScore = 0;
        $result_fldWrongAns = 0;
        $result_fldUnAns = 0;
        
        if($dimension_number == '1'){
            //Format is: 1:1:A;1:2:A;1:3:A;1:4:A;1:5:A;1:6:A;1:7:A;1:8:A;1:9:A;1:10:A;1:11:A;1:12:A;1:13:A;1:14:A;1:15:A;1:16:A;1:17:A;1:18:A;1:19:A;1:20:A;1:21:A;1:22:A;1:23:A;1:24:A;1:25:A;1:26:A;1:27:A;1:28:A;1:29:A;1:30:A;
            //CorrectAns: 1:0;2:0;3:1;4:0;
            foreach ($test_items as $item){
                if($item['level'] == '1'){
                    $i = $item['fldQNo'];
                    $corrent_ans_arr = explodeData('CorrectAns', $item['CorrectAns']);
                    if(isset($_POST['q'.$i])){
                        $raw_response = xss_clean($_POST['q'.$i]);//integer ex. 1
                        if($corrent_ans_arr[$raw_response] == '1'){
                            $result_Score++;
                        } else {
                            $result_fldWrongAns++;
                        }
                    } else {
                        $result_fldUnAns++;
                    }
                } else {
                    continue;
                }
            }
            
        } else if ($dimension_number == '2'){
            //Format is: //2:31a:A;2:31b:A;2:32:A;2:33:A;2:34:A;2:35a:A;2:35b:A;2:35c:A;2:35d:A;2:35e:A;2:36:A;2:37:A;2:38:A;2:39:A;2:40:A;2:41:A;2:42:A;2:43:A;2:44:A;2:45:A;2:46:A;2:47:A;2:48:A;2:49:A;2:50:A;
            //CorrectAns: 1:0;2:0;3:1;4:0;
            foreach ($test_items as $item){
                if($item['level'] == '2'){
                    $i = $item['fldQNo'];
                    $corrent_ans_arr = explodeData('CorrectAns', $item['CorrectAns']);
                    if(isset($_POST['q'.$i])){
                        $raw_response = xss_clean($_POST['q'.$i]);//integer ex. 1
                        if($corrent_ans_arr[$raw_response] == '1'){
                            $result_Score++;
                        } else {
                            $result_fldWrongAns++;
                        }
                    } else {
                        $result_fldUnAns++;
                    }
                } else {
                    continue;
                }
            }
            
        } else if ($dimension_number == '3'){
            //Format is: //3:51:AB;3:52:AB;3:53:AB;3:54:AB;3:55:AB;3:56:AB;3:57:AB;3:58:AB;3:59:AB;3:60:AB;
            
            //1:0;2:0;3:0;4:1;5:0;6:0;
            //1:1;2:-1;3:-1;4:1;5:-1;6:-1;
            
            foreach ($test_items as $item){
                if($item['level'] == '3'){
                    $i = $item['fldQNo'];
                    $corrent_ans_arr = explodeData('CorrectAns', $item['CorrectAns']);
                    if(isset($_POST['q'.$i])){
                        $raw_response = $_POST['q'.$i];//array integer
                        foreach ($raw_response as $r_response){
                            if($corrent_ans_arr[$r_response] == '1'){
                                $result_Score++;
                            } else if ($corrent_ans_arr[$r_response] == '-1'){
                                $result_Score--;
                                $result_fldWrongAns++;
                            } else {
                                $result_fldWrongAns++;
                            }
                        }
                    } else {
                        $result_fldUnAns++;
                    }
                    
                }
            }
            
        }
        
        $result = array('result_Score' => $result_Score, 'result_fldAdjScore' => $result_fldAdjScore, 'result_fldWrongAns' => $result_fldWrongAns, 'result_fldUnAns' => $result_fldUnAns); 
        return $result;
        
        
    }
            
            
}