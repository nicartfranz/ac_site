<?php

class AdminController extends Controller{

    public function index(){
        
        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/admin/dashboard');
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/admin', $html);

    }
    
}
