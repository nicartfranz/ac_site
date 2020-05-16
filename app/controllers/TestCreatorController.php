<?php

class TestCreatorController extends Controller{

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['super_admin', 'admin']);
    }
    
    public function index(){
        
        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/test_creator');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'includeSiteLevelJS' => ['public/js/formbuilder/form-builder.min.js', 'public/js/testcreator.js'], //include site level javascript file. it means this javascript file are only included in testcreator/ controller
            'content' => $content, //this is the pages/admin/test_creator html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
}
