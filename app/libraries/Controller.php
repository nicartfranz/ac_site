<?php
/*
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: Base Controller Class
 * Default Methods:
 *  index(); - reminds the programmer to create a method index() in the controller.
 *  initModel(); - Loads and initializes the model file 
 *  renderView(); - Loads the view file
 */
class Controller {
    
    public function __construct() {
        $this->isAuthenticated(); //This will redirect the user to login page if he/she is not login yet 
    }

    public function index(){
        $className = get_called_class();// get the class name, who extended this class
        die("index(); method not defined in <b>{$className} Controller</b>.");
    }


    //load model
    public function initModel($model){
        //require model file
        
        if(strpos($model, 'Model') !== false){
            require_once '../app/models/' . $model . '.php';
        } else{
            $model = $model."Model";
            require_once '../app/models/' . $model . '.php';
        }
        
        //instantiate model
        return new $model();
    }
    
    //load the view
    public function renderView($view, $data = []){
        //check for the view file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            //view does not exist 
            die('view '.$view.' not found in app/views/pages/');
        }
    }
    
    //loads a view and store it in a variable
    public function getView($view, $data = []){
        $content = '';
        if(file_exists('../app/views/' . $view . '.php')){
            ob_start();
            require_once '../app/views/' . $view . '.php';
            $content = ob_get_clean();
        } else {
            //view does not exist 
            die('view '.$view.' not found in app/views/pages/');
        }
        
        return $content;
    }
    
    //load Questions
    public function loadQuestionsAdmin($raw_questions){
        
        $decoded_questions = json_decode($raw_questions);
        
        $questions_arr = [];
        $page_inc = 0;
        
        //1) group the question by page start
        foreach ($decoded_questions as $key => $question){
            
            //unset unnecessary fields
            unset($decoded_questions[$key]->part);
            unset($decoded_questions[$key]->section);
//            unset($decoded_questions[$key]->fldQOrder);
            unset($decoded_questions[$key]->correctAns);
            
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
                        $submitButton = $question;
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
            if(isset($submitButton) && !empty($submitButton)){
                $final_questions[] = (object)$submitButton;
            }
            
            if(isset($temp_bottom_field) && !empty($temp_bottom_field)){
                foreach ($temp_bottom_field as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($endMarker) && !empty($endMarker)){
                $final_questions[] = (object)$endMarker;
            }
            unset($temp_questions);//unset per page group
            unset($temp_top_field);//unset per page group
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
            unset($decoded_questions[$key]->part);
            unset($decoded_questions[$key]->section);
//            unset($decoded_questions[$key]->fldQOrder);
            unset($decoded_questions[$key]->correctAns);
        
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
                        $submitButton = $question;
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
            if(isset($submitButton) && !empty($submitButton)){
                $final_questions[] = (object)$submitButton;
            }
            
            if(isset($temp_bottom_field) && !empty($temp_bottom_field)){
                foreach ($temp_bottom_field as $q){
                    $final_questions[] = (object)$q;
                }
            }
            
            if(isset($endMarker) && !empty($endMarker)){
                $final_questions[] = (object)$endMarker;
            }
            
            $test_info['page'.$i] = $final_questions;
            unset($temp_questions);//unset per page group
            unset($temp_top_field);//unset per page group
            unset($temp_bottom_field);//unset per page group
            
        }
            
        
        unset($test_info['question']); //not used
        return $test_info;
        
    }
    
    public function finish(){
        
        //--SUBMIT PREV FORM---//
        $this->submitForm();
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
    
    
    //this controller method is for ajax requests only
    public function submitAjax(){

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        if(!$isAjax){
            echo 'Invalid access: this controller is for ajax requests only';
            exit;
        }
        
    }
    
    //Force redirect user to login page if he/she is not yet authenticated/logged in. 
    public function isAuthenticated(){
        $controller = getController();
        
        if(in_array($controller, ['', 'site'])){
            return;
        } else {
            if(!isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] != '1'){
                header("Location:".APP_BASE_URL."site/index");
            } 
        }
        
    }
    
    
    //submit form 
    public function submitForm(){
        
        if(isset($_POST)){
//            echo '<pre>';
//            print_r($_POST);
//            echo '</pre>';
        }
        
    }
    
    //saves the snapshot to a directory
    public function saveSnapshot($directory = ''){
        
        if(isset($_POST['mysnapshot']) && !empty($_POST['mysnapshot'])){
            $encoded_data = $_POST['mysnapshot'];
            $binary_data = base64_decode( $encoded_data );

            // save to server (beware of permissions)
            $unique_pic_name = strtotime(date('Y-m-d H:i:s'));
            $result = file_put_contents("img/snapshots/{$unique_pic_name}.jpg", $binary_data );
            if (!$result) die("Could not save image!  Check file permissions.");
        }
        
    }
    
}