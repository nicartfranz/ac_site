<?php

class CandidateController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        
        $test = $this->initModel('TestModel');
        
        $tests = ($_SESSION['usertype'] == 'super_admin') ? $test->getAllTests() : $test->getTestByUsername($_SESSION['username']);
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/candidate/index', array('scheduled_tests' => $tests));
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/candidate', $html);
       
    }
    
    public function privacy_consent(){
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/candidate/privacy_consent');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
            'includeSiteLevelJS' => [
                'public/js/candidate.js'
            ],
        ];
        $this->renderView('layouts/candidate', $html);
        
    }
    
    public function candidate_demographics(){
        
        $candidate = $this->initModel('CandidateModel');
        $this_candidate = $candidate->get_candidate_info($_SESSION['username']);
       
        if(isset($_POST['submit'])){
            
            $params = array();
            $params['gender'] = (isset($_POST['gender'])) ? $_POST['gender'] : $this_candidate['gender'];
            $params['age'] = (isset($_POST['age'])) ? $_POST['age'] : $this_candidate['age'];
            $params['high_educ'] = (isset($_POST['educational_attaiment'])) ? $_POST['educational_attaiment'] : $this_candidate['high_educ'];
            $params['workexp'] = (isset($_POST['work_exp_yr']) && isset($_POST['work_exp_mon'])) ? $_POST['work_exp_yr'] .' and '. $_POST['work_exp_mon'] : $this_candidate['workexp'];
            $params['job_level'] = (isset($_POST['position'])) ? $_POST['position'] : $this_candidate['job_level'];
            $params['username'] = $_SESSION['username'];
            $candidate->update_candidate_demographics($params);
            header("Location:".APP_BASE_URL.'candidate/index');
            
        }
        
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/candidate/candidate_demographics', array('candidate_info' => $this_candidate));
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
            'includeSiteLevelJS' => [
                'public/js/candidate.js'
            ],
        ];
        $this->renderView('layouts/candidate', $html);
        
    }
    
    public function window_exit(){
        $content = $this->getView('pages/candidate/window_exit');
        
        $html = [
            'includeSiteLevelJS' => [
                'public/js/candidate.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/candidate', $html);
    }
    
}
