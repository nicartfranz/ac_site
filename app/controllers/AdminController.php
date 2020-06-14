<?php

class AdminController extends Controller{
    
    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['super_admin', 'admin']);
    }

    public function index(){
        
        //load a view and put it in a variable for later use
        $content = $this->getView('pages/admin/dashboard');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'page_name' => 'Dashboard',
            'includeSiteLevelJS' => ['public/js/chart.js/Chart.min.js', 'public/js/demo/chart-area-demo.js', 'public/js/demo/chart-pie-demo.js'],
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
}
