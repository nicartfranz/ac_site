<?php

    //DB Params
    define('DB_DRIVER', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'assessment_center');
    define('DB_CHARSET', 'utf8');
    define('DB_COLLATION', 'utf8_general_ci');
    define('DB_PREFIX', '');
    
    //APPFOLDER
    define('APPFOLDER', 'ac_site/');
    
    //APPROOT
    define('APPROOT', dirname(dirname(__FILE__)));
    
    //APP_BASE_URL
    define('APP_BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].'/'.APPFOLDER);

    //Site Name
    define('SITENAME', 'Assessment Center');