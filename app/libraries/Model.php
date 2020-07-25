<?php

/*
 * Contributor: Franz
 * Date Modified: May 10, 2020
 * 
 * Description: Base Model Class
 * I am using https://www.doctrine-project.org/projects/doctrine-dbal/en/2.10/index.html for database layer/orm class
 */
class Model {

    public $db;
    public $queryBuilder;
    public function __construct() {
        global $db, $queryBuilder;
        $this->db = $db;
        $this->queryBuilder = $queryBuilder;
    }
    
    //load class in library
    public function initClass($class){
        //require model file
        require_once '../app/libraries/' . $class . '.php';
        
        //instantiate model
        return new $class();
    }

 }