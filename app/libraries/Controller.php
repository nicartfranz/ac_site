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
    public function loadView($view, $data = []){
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
    
}