<?php

class CandidateSiteSettingsController extends Controller{
    
    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['super_admin', 'admin']);
    }

    function requirements(){
        
        $candidate_site_req = $this->initModel('CandidateSiteRequirementsModel');
        $requirements = $candidate_site_req->get_requirements();
        
        if(isset($_POST['submit']) && $_POST['submit'] == 'update'){
            
            if(isset($requirements) && !empty($requirements['id'])){//update
                
                $params = array();
                $params['id'] = $_POST['id'];
                $params['web_browsers'] = (isset($_POST['selectmultiple_webbrowser'])) ? implode(',', $_POST['selectmultiple_webbrowser']) : '';
                $params['devices'] = (isset($_POST['checkboxes_devices'])) ? implode(',', $_POST['checkboxes_devices']) : '';
                $params['os'] = (isset($_POST['selectmultiple_os'])) ? implode(',', $_POST['selectmultiple_os']) : ''; 
                $params['cookies'] = $_POST['radios_cookies'];
                $params['camera'] = $_POST['radios_camera'];
                $params['microphone'] = $_POST['radios_microphone'];
                $params['page_reload_back'] = $_POST['radios_page_reload_back'];
                $params['page_focus'] = $_POST['radios_page_focus'];
                $candidate_site_req->save_update_requirements($params);
                $params['success_update_insert'] = true;
                
            } else { //insert 
                
                $params = array();
                $params['id'] = '';
                $params['web_browsers'] = (isset($_POST['selectmultiple_webbrowser'])) ? implode(',', $_POST['selectmultiple_webbrowser']) : '';
                $params['devices'] = (isset($_POST['checkboxes_devices'])) ? implode(',', $_POST['checkboxes_devices']) : '';
                $params['os'] = (isset($_POST['selectmultiple_os'])) ? implode(',', $_POST['selectmultiple_os']) : ''; 
                $params['cookies'] = $_POST['radios_cookies'];
                $params['camera'] = $_POST['radios_camera'];
                $params['microphone'] = $_POST['radios_microphone'];
                $params['page_reload_back'] = $_POST['radios_page_reload_back'];
                $params['page_focus'] = $_POST['radios_page_focus'];
                $candidate_site_req->save_update_requirements($params);
                $params['success_update_insert'] = true;
                
            }
            
            unset($requirements);
            $requirements = $params;

        } 
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/admin/candidate_site_requirements', $requirements);
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Candidate Site Settings',
            'includeSiteLevelJS' => [], //include site level javascript file. it means this javascript file are only included in testcreator/ controller
            'content' => $content, //this is the pages/admin/test_creator html
        ];
        $this->renderView('layouts/admin', $html);
        
    }

}