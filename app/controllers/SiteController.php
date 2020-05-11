<?php

/* 
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: This Site Controller is the landing page of the site.
 */

class SiteController extends Controller{
    
    public function __construct(){

    }

    public function index(){

        $data = [
            'title' => 'Welcome 1',
        ];

        $this->renderView('pages/index', $data);
    }

    public function admin_login(){
        $data = [
            'title' => 'Admin Login Page',
        ];

       $this->renderView('pages/about', $data);
    }
    
}
