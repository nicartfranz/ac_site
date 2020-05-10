<?php

class UserController extends Controller{

    public function index(){
        
        $user = $this->initModel('User');

        $data = [
            'title' => 'User Page',
        ];

        $this->renderView('pages/index', $data);
    }
    
    
    public function view(){
        
        $user = $this->initModel('User');

        $data = [
            'title' => 'View User Page',
        ];

        $this->renderView('pages/index', $data);
    }
    
}
