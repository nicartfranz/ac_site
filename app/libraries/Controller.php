<?php
/*
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: Base Controller Class
 * Default Methods:
 *  index(); - reminds the programmer to create a method index() in the controller.
 *  initModel(); - Loads and initializes the model file 
 *  renderView(); - Loads the view file
 */
class Controller {

    public function index(){
        $className = get_called_class();// get the class name, who extended this class
        die("index(); method not defined in <b>{$className} Controller</b>.");
    }


    //load model
    public function initModel($model){
        //require model file
        
        if(strpos($model, 'Model') !== false){
            require_once '../app/models/' . $model . '.php';
        } else{
            $model = $model."Model";
            require_once '../app/models/' . $model . '.php';
        }
        
        //instantiate model
        return new $model();
    }

    //load the view
    public function renderView($view, $data = []){
        //check for the view file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            //view does not exist 
            die('view not found');
        }
    }
    
}