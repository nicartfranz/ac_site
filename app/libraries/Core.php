<?php 
    /*
     * Contributor: Franz
     * Date Modified: May 9, 2020
     * 
     * Description: This class is the base core class
     * 1. This class creates URL FORMAT for the Base Controller - /controller/method/params 
     *      Example: site/about/?test=1
     */
    class Core {
        protected $currentController = 'SiteController';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            //print_r($this->getUrl());
           
            $url = $this->getUrl();

            //Look In Controllers For First Value
            if(file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')){
                //if exists, set as controller
                $this->currentController = ucwords($url[0])."Controller";
                //unset 0 index
                unset($url[0]);
            }
            
            //require controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            
            //instantiate controller class
            $controllerName = $this->currentController;
            $this->currentController = new $controllerName;
            
            //check for the second part of the url
            if(isset($url[1])){
                //check to see if method exist
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1]; 

                    //unset 1 index
                    unset($url[1]);
                } else {
                    die('Method '.$url[1].' is not found in '.$controllerName);
                }
                
            }

           // get params

           $this->params = $url ? array_values($url) : [];

           //call a callback with array of params

           call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

        }
        

        public function getUrl(){
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }

    