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

    ////////////////////////////////////////////////////////////////////////////
    // START CONTROLLER BASE
    ////////////////////////////////////////////////////////////////////////////
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
    
    //load class in library
    public function initClass($class){
        //require model file
        require_once '../app/libraries/' . $class . '.php';
        
        //instantiate model
        return new $class();
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
        
        $candidate_site_req = $this->initModel('CandidateSiteRequirementsModel');
        $requirements = $candidate_site_req->get_requirements();
        $data['requirements'] = $requirements;
        
//        echo '<pre>';
//        print_r($requirements);
//        echo '</pre>';
        
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
    
    //Force redirect user to login page if he/she is not yet authenticated/logged in. 
    public function isAuthenticated(){
        $controller = getController();
        
        if(isset($_GET['login']) && $_GET['login'] = 'link_redirect'){
            
            //http://localhost/ac_site/demo/?username=username1&password=password1&login=link_redirect&login_type=candidate
            $site = $this->initModel('SiteModel');
            $username = xss_clean($_GET['username']);
            $password = xss_clean($_GET['password']);
            $login = xss_clean($_GET['login']);
            $login_type = xss_clean($_GET['login_type']);
    
            $username_decryption=openssl_decrypt($username, CIPHERING, ENCRYPTION_DECRYPTION_KEY, CIPHER_OPTIONS, ENCRYPTION_DECRYPTION_IV); 
            $password_decryption=openssl_decrypt($password, CIPHERING, ENCRYPTION_DECRYPTION_KEY, CIPHER_OPTIONS, ENCRYPTION_DECRYPTION_IV); 
            $candidate_info = $site->candidate_login($username_decryption, $password_decryption);
            
            if($candidate_info){
                $_SESSION['ac2']['username'] = $username;
                $_SESSION['ac2']['is_authenticated'] = true;
                $_SESSION['ac2']['usertype'] = 'test_taker';
                $_SESSION['ac2']['device'] = ucfirst(getDevice());
                $_SESSION['ac2']['candidate_info'] = $candidate_info;
                return;
            } else {
                header("Location:".APP_BASE_URL."site/invalid_login2");
            }
            return;
            
        }
        
        
        if(in_array($controller, ['', 'site'])){
            return;
        } else {
            if(!isset($_SESSION['ac2']['is_authenticated']) && $_SESSION['ac2']['is_authenticated'] != '1'){
                header("Location:".APP_BASE_URL."site/index");
            } 
        }
        
    }

    //this controller method is for ajax requests only
    public function submitAjax(){

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        if(!$isAjax){
            echo 'Invalid access: this controller is for ajax requests only';
            exit;
        }
        
    }
    ////////////////////////////////////////////////////////////////////////////
    // END CONTROLLER BASE
    ////////////////////////////////////////////////////////////////////////////
    
}