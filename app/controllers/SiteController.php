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
        
        $error = [];
        $warning = [];
        $candidate_site_req = $this->initModel('CandidateSiteRequirementsModel');
        $requirements = $candidate_site_req->get_requirements();
        
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
            
            $site = $this->initModel('SiteModel');
            
            if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['login_type'])){
                
                $username = xss_clean($_POST['username']);
                $password = xss_clean($_POST['password']);
                $login_type = xss_clean($_POST['login_type']);

                if($login_type == 'candidate'){
                    
                    $candidate_info = $site->candidate_login($username, $password);
                    
                    if($candidate_info){
                        $_SESSION['username'] = $username;
                        $_SESSION['is_authenticated'] = true;
                        $_SESSION['usertype'] = 'test_taker';
                        $_SESSION['device'] = ucfirst(getDevice());
                        $_SESSION['candidate_info'] = $candidate_info;
                        
                        //record login info
                        if(isset($_SESSION['is_authenticated']) && $_SESSION['usertype'] == 'test_taker'){
                            
                            if($_SESSION['candidate_info']['relog_record'] != ''){
                                $relog_record = json_decode($_SESSION['candidate_info']['relog_record']);
                                $relog_record[] = array('date' => date('Y-m-d H:i:s'), 'bandwidth' => 'not implemented', 'device' => $_SESSION['device']);
                                $update_tbaker['relog_record'] = json_encode($relog_record);
                            } else {
                                $update_tbaker['relog_record'] = json_encode([array('date' => date('Y-m-d H:i:s'), 'bandwidth' => 'not implemented', 'device' => $_SESSION['device'])]);
                            }
                            $site->update_tbtaker($update_tbaker);
                        }
                        
                        header("Location:".APP_BASE_URL."candidate/privacy_consent");
                    } else {
                        $this->invalid_login();
                    }
                    
   
                    
                } else if ($login_type == 'admin'){
                    
                    if($username == 'admin' && $password == 'dynamics2002'){
                        $_SESSION['username'] = 'admin';
                        $_SESSION['is_authenticated'] = true;
                        $_SESSION['usertype'] = 'super_admin';
                        header("Location:".APP_BASE_URL."admin/index");
                    } else {
                        $this->invalid_login();
                    }
                    
                } else { 
                    $this->invalid_login();
                }
                
            } else {
                $this->invalid_login();
            }
            
        } else {
            $this->index();
        }
                
    }
    
    public function invalid_login(){
        
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
    
    
    public function logout(){
        
        $site = $this->initModel('SiteModel');
        
        
        if(isset($_SESSION['is_authenticated']) && $_SESSION['usertype'] == 'test_taker'){
            
            //record logout info
            if($_SESSION['candidate_info']['logout_history'] != ''){
                $logout_history = json_decode($_SESSION['candidate_info']['logout_history']);
                $logout_history[] = array('date' => date('Y-m-d H:i:s'), 'logout_type' => 'not implemented', 'device' => $_SESSION['device']);
                $update_tbaker['logout_history'] = json_encode($logout_history);
            } else {
                $update_tbaker['logout_history'] = json_encode([array('date' => date('Y-m-d H:i:s'), 'logout_type' => 'not implemented', 'device' => $_SESSION['device'])]);
            }
            
            $site->update_tbtaker($update_tbaker);
        
            //record web history
            require_once '../app/libraries/webHistory.php';
            $web_history = new webHistory();
            //INSERT NEW ROW - id  user_id  web_history_controller  web_history_method  web_history_get  web_history_post  usertype  date_entered  
            $params = array();
            $params['username'] = $_SESSION['candidate_info']['username'];
            $params['web_history_controller'] = 'Site';
            $params['web_history_method'] = 'logout';
            $params['web_history_get'] = '[]';
            $params['web_history_post'] = '[]';
            $params['usertype'] = $_SESSION['usertype'];
            $params['device'] = ucfirst(getDevice());
            $params['date_entered'] = date('Y-m-d H:i:s');
            $web_history->log_web_history($params);
        }
        
        
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
