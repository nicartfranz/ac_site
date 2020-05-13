<?php

/* 
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: This Site Controller is the landing page of the site.
 */

class SiteController extends Controller{
    
    public function index(){

        $error = [];
        $content = $this->loadView('pages/login', $error);
        $data = [
            'content' => $content, 
        ];
        $this->renderView('pages/index', $data);
        
    }
    
    public function login(){
        
        if(isset($_POST['submit'])){
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            if($username == 'admin' && $password == 'password'){
                $_SESSION['username'] = 'admin';
                $_SESSION['is_authenticated'] = true;
                $_SESSION['usertype'] = 'super_admin';
                header("Location:".APP_BASE_URL."admin/index");
            } else if ($username == 'candidate' && $password == 'password'){
                $_SESSION['username'] = 'candidate';
                $_SESSION['is_authenticated'] = true;
                $_SESSION['usertype'] = 'test_taker';
                header("Location:".APP_BASE_URL."candidate/index");
            } else{

                $error = [
                    'invalid_login' => 'Invalid login credentials'
                ];
                $content = $this->loadView('pages/login', $error);
                $data = [
                    'content' => $content, 
                ];
                $this->renderView('pages/index', $data);
            }
        } else {
            $this->index();
        }
       
                
    }
    
    
    public function logout(){
        
        // Stores in Array
        $_SESSION = array();
        // Swipe via memory
        if (ini_get("session.use_cookies")) {
        // Prepare and swipe cookies
        $params = session_get_cookie_params();
        // clear cookies and sessions
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
           );
        }

        session_destroy(); 
        
        //redirect to login
        header("Location:".APP_BASE_URL."site/index");
        
    }
    
}
