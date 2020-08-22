<?php
/**
 * Description of Test
 * - All candidate test related functions
 * @author Nitro 5
 */
class Test extends Controller{
    
    //load Questions
    public function loadQuestionsAdmin($raw_questions){
        
        $decoded_questions = json_decode($raw_questions);
        
        $questions_arr = [];
        $page_inc = 0;
        
        //1) group the question by page start
        foreach ($decoded_questions as $key => $question){
            
            //group the pages by startPageMarker
            if($decoded_questions[$key]->type == 'startPageMarker'){
                $page_inc++;
            }            
            $decoded_questions[$key]->setTimer = isset($decoded_questions[$key]->setTimer) ? $decoded_questions[$key]->setTimer : -1; 
            $questions_arr['page'.$page_inc][] = $decoded_questions[$key];
        
            
        }
        
        //check if valid test format level 1
        if(isset($questions_arr['page0'])){
            die('Invalid test format: Please add startPageMarker identifier at the beginning of the test page.');
        }
      
        //2) sort questions by page group
        $final_questions = [];
        $startMarker = [];
        $temp_top_field = [];
        $temp_questions = [];
        $submitButton = [];
        $temp_bottom_field = [];
        $endMarker = [];
        foreach($questions_arr as $page => $questions){
         
            if(isset($questions[0]->randomize) && ($questions[0]->randomize === true || $questions[0]->randomize == 'true')){
                shuffle($questions);
            }

            //Format the page
            //1. startMarker
            //2. questions
            //3. submit button
            //4. endMarker
            foreach($questions as $question){
                if(!in_array($question->type, ['startPageMarker', 'button', 'endPageMarker'])){
                    
                    if(isset($question->fldQOrder) && $question->fldQOrder == 'display_top'){
                        $temp_top_field[] = $question;
                    } else if (isset($question->fldQOrder) && $question->fldQOrder == 'display_bottom'){
                        $temp_bottom_field[] = $question;
                    } else {
                        $temp_questions[] = $question;
                    }
                    
                } else {
                    if($question->type == 'startPageMarker'){
                        $startMarker = $question;
                    }
                    if($question->type == 'button'){
                        $submitButton[] = $question;
                    }
                    if($question->type == 'endPageMarker'){
                        $endMarker = $question;
                    }
                }
            }
            
            //Finally
            if(isset($startMarker) && !empty($startMarker)){
                $final_questions[] = (object)$startMarker;
            }
            
            if(isset($temp_top_field) && !empty($temp_top_field)){
                foreach ($temp_top_field as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($temp_questions) && !empty($temp_questions)){
                foreach ($temp_questions as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($temp_bottom_field) && !empty($temp_bottom_field)){
                foreach ($temp_bottom_field as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($submitButton) && !empty($submitButton)){
                //$final_questions[] = (object)$submitButton;
                foreach ($submitButton as $b){
                    $final_questions[] = (object)$b;
                }
            }
            
            if(isset($endMarker) && !empty($endMarker)){
                $final_questions[] = (object)$endMarker;
            }

            unset($temp_top_field);//unset per page group
            unset($temp_questions);//unset per page group
            unset($submitButton);//unset per page group
            unset($temp_bottom_field);//unset per page group
                                    
        }
        
        return json_encode($final_questions);
        
    }
    
    //load question candidate
    public function loadQuestionCandidate($raw_questions){
        
        $question_arr = [];
        
        $page_inc = 0;
        //2.) remove unnecessary attr in the html question
        $decoded_questions = json_decode($raw_questions);
        foreach ($decoded_questions as $key => $question){
        
            //3.) Display the first page: identified by type:startPageMarker & type:endPageMarker
            if($decoded_questions[$key]->type == 'startPageMarker'){
                $page_inc++;
            }
            
            $decoded_questions[$key]->setTimer = isset($decoded_questions[$key]->setTimer) ? $decoded_questions[$key]->setTimer : -1; 
            $test_info['page'.$page_inc][] = $decoded_questions[$key];

        }
        
        //check if valid test format level 1
        if(isset($questions_arr['page0'])){
            die('Invalid test format: Please add startPageMarker identifier at the beginning of the test page.');
        }
        
        //2.1) sort questions by page group
        $final_questions = [];
        $startMarker = [];
        $temp_questions = [];
        $submitButton = [];
        $endMarker = [];
        
        for($i = 1; $i <= $page_inc; $i++){
            
            $questions = $test_info['page'.$i];
            
            //2) sort questions by page group
            $final_questions = [];
            $startMarker = [];
            $temp_top_field = [];
            $temp_questions = [];
            $submitButton = [];
            $temp_bottom_field = [];
            $endMarker = [];
            
            if(isset($questions[0]->randomize) && ($questions[0]->randomize === true || $questions[0]->randomize == 'true')){
                shuffle($questions);
            }   

            //Format the page
            //1. startMarker
            //2. questions
            //3. submit button
            //4. endMarker
            foreach($questions as $question){
                
                if(!in_array($question->type, ['startPageMarker', 'button', 'endPageMarker'])){
                    
                    if(isset($question->fldQOrder) && $question->fldQOrder == 'display_top'){
                        $temp_top_field[] = $question;
                    } else if (isset($question->fldQOrder) && $question->fldQOrder == 'display_bottom'){
                        $temp_bottom_field[] = $question;
                    } else {
                        $temp_questions[] = $question;
                    }
                    
                } else {
                    if($question->type == 'startPageMarker'){
                        $startMarker = $question;
                    }
                    if($question->type == 'button'){
                        $submitButton[] = $question;
                    }
                    if($question->type == 'endPageMarker'){
                        $endMarker = $question;
                    }
                }
            }
            
            //Finally
            if(isset($startMarker) && !empty($startMarker)){
                $final_questions[] = (object)$startMarker;
            }
            
            if(isset($temp_top_field) && !empty($temp_top_field)){
                foreach ($temp_top_field as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($temp_questions) && !empty($temp_questions)){
                foreach ($temp_questions as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($temp_bottom_field) && !empty($temp_bottom_field)){
                foreach ($temp_bottom_field as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($submitButton) && !empty($submitButton)){
                //$final_questions[] = (object)$submitButton;
                foreach ($submitButton as $b){
                    $final_questions[] = (object)$b;
                }
            }
            
            if(isset($endMarker) && !empty($endMarker)){
                $final_questions[] = (object)$endMarker;
            }
            
            $test_info['page'.$i] = $final_questions;
            unset($temp_top_field);//unset per page group
            unset($temp_questions);//unset per page group
            unset($submitButton);//unset per page group
            unset($temp_bottom_field);//unset per page group
            
        }
            
        
        unset($test_info['question']); //not used
        return $test_info;
        
    }
    
    //Used in candidate testing: Page 1 of the test
    public function page1(){
        $content = $this->getView('pages/candidate/test_not_found');
        
        $html = [
            'includeSiteLevelJS' => [
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
    }
    
    //Used in candidate testing: Finish page
    public function finish(){
        
        //--SUBMIT POST FROM PREVIOUS PAGE---//
        $this->saveSnapshot();
        //-----------------------------------//
        
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
    
    //Used in candidate testing: Scored page
    public function scored(){
        
        $content = $this->getView('pages/candidate/scored');
        
        $html = [
            'includeSiteLevelJS' => [
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
        
    }
    
    //Used in candidate testing: submit form 
    public function submitForm($confirm_submit = true){
        
        if($confirm_submit){
            //back end saving
        } else {
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
        }

    }
    
    //Used in candidate testing: saves the snapshot to a directory
    public function saveSnapshot($ass_code = '', $page = ''){
        
        if(isset($_POST['mysnapshot']) && !empty($_POST['mysnapshot'])){
            $encoded_data = $_POST['mysnapshot'];
            $binary_data = base64_decode( $encoded_data );

            //create a folder
            
            if (!is_dir("img/snapshots/".$_SESSION['ac2']['username']."/")){
                mkdir("img/snapshots/".$_SESSION['ac2']['username'], 0777, true);
            }
            
            // save to server (beware of permissions)
            $unique_pic_name = strtotime(date('Y-m-d H:i:s'));
            if($ass_code!=''){ $unique_pic_name .= '_'.$ass_code; }
            if($page!=''){ $unique_pic_name .= '_'.$page; }
            $result = file_put_contents("img/snapshots/".$_SESSION['ac2']['username']."/".$unique_pic_name.".jpg", $binary_data );
            if (!$result) die("Could not save image!  Check file permissions.");
        }
        
    }
    
    //Used in candidate testing: redirects the user to prevent reload and back page
    public function prevent_reload_and_back(){
        $content = $this->getView('pages/candidate/prevent_reload_and_back');
        
        $html = [
            'includeSiteLevelJS' => [
                'public/js/testtaking.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
    }
    
    
}
