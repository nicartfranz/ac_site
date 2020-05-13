<?php

class AdminController extends Controller{
    
    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['super_admin', 'admin']);
    }

    public function index(){
        
        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/dashboard');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
    public function create_sample(){
        
        print_r($_GET);
        echo '<br>';
        print_r($_POST);
        
        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/create_sample');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
}
