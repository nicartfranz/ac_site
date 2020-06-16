<?php

/* 
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: This Site Controller is the landing page of the site.
 */

class SiteController extends Controller{
    
    public function index(){
        
        $candidate_site_req = $this->initModel('CandidateSiteRequirementsModel');
        $requirements = $candidate_site_req->get_requirements();
        
        $error_site_requirement = $this->isSystemCompatible();
        $inside_page_data = [
            'invalid_login' => '',
            'error_site_requirement' => $error_site_requirement['errors'],
            'warning_site_requirement' => $error_site_requirement['warnings'],
            'requirements' => $requirements,
        ];
        
        $content = $this->getView('pages/login', $inside_page_data);
        $data = [
            'includeSiteLevelJS' => [
                'public/js/system_check.js'
            ],
            'content' => $content,
        ];
        $this->renderView('pages/index', $data);
        
    }
    
    public function isSystemCompatible(){
        global $browser, $device, $os;
        
//        echo '<pre>';
//        print_r($_COOKIE);
//        echo '</pre>';
//        
//        echo 'Browser: ' .$browser->getName() . '<br>';
//        echo 'Browser version: ' .$browser->getVersion() . '<br>';
//        echo 'OS: ' . $os->getName(). '<br>';
//        echo 'Device: ' . getDevice(). '<br>';
        
        $error = [];
        $warning = [];
        $candidate_site_req = $this->initModel('CandidateSiteRequirementsModel');
        $requirements = $candidate_site_req->get_requirements();
        
//        echo '<pre>';
//        print_r($requirements);
//        echo '</pre>';
        
        $valid_web_browsers = explode(',', $requirements['web_browsers']);
        if(!in_array($browser->getName(), $valid_web_browsers)){
            $error[] = '<b>' .ucfirst($browser->getName()). ' browser is currently not supported</b>.<br>Please use the following web browser(s): ' . implode(', ', $valid_web_browsers) . '.';
        }
        $valid_devices = explode(',', $requirements['devices']);
        if(!in_array(getDevice(), $valid_devices)){
            $error[] = '<b>' .ucfirst(getDevice()). ' device is currently not supported</b>.<br>Please use the following device: ' . implode(', ', $valid_devices) . '.';
        }
        $valid_os = explode(',', $requirements['os']);
        if(!in_array($os->getName(), $valid_os)){
            $error[] = '<b>' .ucfirst($os->getName()). ' OS is currently not supported</b>.<br>Please use a device with the following operating system: ' . implode(', ', $valid_os) . '.';
        }
        
        //Cookie checker
        if(!checkCookies() && $requirements['cookies'] == '1'){
            $warning[] = 'This website uses cookies to give you the best possible experience. Click here if you <a href="'.APP_BASE_URL.'site/accept_cookie_usage">agree</a>.';
        }
        
        //IF mobile and camera required, add error message
        if(in_array(getDevice(), ['mobile', 'tablet']) && $requirements['camera'] == '1'){
            $error[] = '<b>Camera is currently not supported in mobile and tablet</b>.<br>Please use a laptop or PC/desktop with camera attahed.';
        }
        
        return array('errors' => $error, 'warnings' => $warning);
        
    }
    
    public function accept_cookie_usage(){
        setcookie("is_cookie_usage_accepted", true);
        header("Location:".APP_BASE_URL.'site/');
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
                header("Location:".APP_BASE_URL."candidate/privacy_consent");
            } else{

                $error = [
                    'invalid_login' => 'Invalid login credentials',
                    'error_site_requirement' => [],
                    'requirements' => [],
                ];
                $content = $this->getView('pages/login', $error);
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
        //setcookie('is_cookie_usage_accepted', '');

        session_destroy(); 
        
        //redirect to login
        header("Location:".APP_BASE_URL."site/");
        
    }
    
}
