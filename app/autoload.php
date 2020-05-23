<?php
/* 
 * Contributor: Franz
 * Date Modified: May 10, 2020
 * 
 * Description: Auto Loader for the mvp core libraries, composer classes, db class, config, helper functions, ajax
 */
//global variables
global $db, $queryBuilder;

//Configuration file
require_once 'config/config.php';

// autoload for the classes installed using composer
require '../vendor/autoload.php';

//Using https://www.doctrine-project.org/projects/doctrine-dbal/en/2.10/index.html for database layer class
$connectionParams = array(
        'driver'    => DB_DRIVER,
        'host'      => DB_HOST,
        'dbname'  => DB_NAME,
        'user'  => DB_USER,
        'password'  => DB_PASS,
        'charset'   => DB_CHARSET,
        'collation' => DB_COLLATION,
        'prefix'    => DB_PREFIX
);
$db = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
$queryBuilder = $db->createQueryBuilder();

//Auto Loader for the libraries and classes
spl_autoload_register(function($className){
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    require_once 'libraries/' . $className . '.php';
});

//Gen helper file
require_once 'helpers/gen.helpers.php';

//Gen ajax file
require_once 'helpers/gen.ajax.php';

//Start the session
session_start();