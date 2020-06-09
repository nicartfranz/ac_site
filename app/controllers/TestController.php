<?php

class TestController extends Controller{

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['super_admin', 'admin']);
    }
    
    public function index(){
        
        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/test_creator');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Create Test',
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js',
                'public/js/fb_fields_acsite.js',
                'public/js/testcreator.js'
            ], //include site level javascript file. it means this javascript file are only included in testcreator/ controller
            'content' => $content, //this is the pages/admin/test_creator html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
    public function search(){
        
        //init model
        $test = $this->initModel('TestModel');
        $tests = $test->getAllTests();
        
         //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/test_search', ['tests' => $tests]);
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Search Test',
            'includeSiteLevelJS' => [], //include site level javascript file. it means this javascript file are only included in testcreator/ controller
            'content' => $content, //this is the pages/admin/test_search html
        ];
        $this->renderView('layouts/admin', $html);
    }
    
    public function view(){
               
        //init model
        $test = $this->initModel('TestModel');
        $test_info = $test->getTest($_GET['id']);

        $questions = $this->loadQuestionsAdmin($test_info['question']);
        $test_info['question'] = $questions;

         //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/test_view', ['test' => $test_info]);
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'View Test: '.$test_info['AssName'],
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/formbuilder/control_plugins/likertQuestion.js',
                'public/js/formbuilder/control_plugins/LeastBestQuestion.js',
                'public/js/formbuilder/control_plugins/rankingQuestion.js',
                'public/js/fb_fields_acsite.js',
                'public/js/testview.js'
            ], 
            'content' => $content, //this is the pages/admin/test_creator html
        ];
        $this->renderView('layouts/admin', $html);
    }
    
    
    public function update(){
        
        //init model
        $test = $this->initModel('TestModel');
        $test_info = $test->getTest($_GET['id']);
        
         //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/test_update', ['test' => $test_info]);
        
//        $json_q = json_decode($test_info['question']);
//        echo '<pre>';
//        print_r($json_q);
//        echo '</pre>';
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Edit Test: '.$test_info['AssName'],
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testupdate.js'
            ],
            'content' => $content, 
        ];
        $this->renderView('layouts/admin', $html);
    }
    
    
    
    //Ajax requests under this controller will be passed here
    public function submitAjax(){
        parent::submitAjax();
        
        $ajax_name = $_POST['ajax_name'];
        switch ($ajax_name) {
            case "save_test":
                ajax_save_test();
                break;
            case "update_test":
                $test_id = $_POST['test_id'];
                ajax_update_test($test_id);
                break;
            default:
              echo "ajax_name not found.";
        }
        
    }
    
}
