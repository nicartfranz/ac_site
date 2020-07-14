<?php

class CandidateController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        
        $test = $this->initModel('TestModel');
        $tests = $test->getAllTests();
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/candidate/index', $tests);
        
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
        
       
        if(isset($_POST['submit'])){
            header("Location:".APP_BASE_URL.'candidate/index');
        }
        
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/candidate/candidate_demographics');
        
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
