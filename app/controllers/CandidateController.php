<?php

class CandidateController extends Controller{
    
    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }

    public function index(){
        
        $test = $this->initModel('TestModel');
        $tests = $test->getAllTests();
        
        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/candidate/index', $tests);
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/candidate', $html);
        
    }
    
}
