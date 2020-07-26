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
        protected $controller = 'SiteController';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            //print_r($this->getUrl());
           
            $url = $this->getUrl();

            //Look In Controllers For First Value
            if(file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')){
                //if exists, set as controller
                $this->controller = ucwords($url[0]);
                $this->currentController = $this->controller."Controller";
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
           
           
           $this->track_web_history();
           
        }
        
        public function track_web_history(){
            
            //Track web history of the candidate.
            if(isset($_SESSION['is_authenticated']) && $_SESSION['usertype'] == 'test_taker'){
                
                require_once '../app/libraries/webHistory.php';
                $web_history = new webHistory();
               
                //INSERT NEW ROW - id  user_id  web_history_controller  web_history_method  web_history_get  web_history_post  usertype  date_entered  
                $params = array();
                $params['username'] = $_SESSION['candidate_info']['username'];
                $params['web_history_controller'] = $this->controller;
                $params['web_history_method'] = $this->currentMethod;
                $params['web_history_get'] = json_encode($_GET);
                $params['web_history_post'] = json_encode($_POST);
                $params['usertype'] = $_SESSION['usertype'];
                $params['device'] = $_SESSION['device'];
                $params['date_entered'] = date('Y-m-d H:i:s');
                $web_history->log_web_history($params);
                
//                echo 'CONTROLLER: '. $this->controller . '<br>';
//                echo 'METHOD: ' . $this->currentMethod . '<br>';
//                echo '_GET: ' . json_encode($_GET) . '<br>';
//                echo '_POST: ' . json_encode($_POST) . '<br>';
                
//                echo '<pre>';
//                print_r($_SESSION);
//                echo '</pre>';
                
            }

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

    