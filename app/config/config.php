<?php
    //set timezone
    date_default_timezone_set('Asia/Manila');

    //DB Params
    define('DB_DRIVER', 'pdo_mysql');
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
    
    //DOCROOT
    define('DOCROOT', $_SERVER['DOCUMENT_ROOT'].'/'.APPFOLDER.'app');
    
    //APP_BASE_URL
    define('APP_BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].'/'.APPFOLDER);

    //Site Name
    define('SITENAME', 'Assessment Center');
    
    //PHPMAILER config
    define('MAIL_HOST', 'smtp1.example.com');       // Set the SMTP server to send through
    define('MAIL_SMTPAUTH', true);                  // Enable SMTP authentication
    define('MAIL_USERNAME', 'user@example.com');    // SMTP username
    define('MAIL_PASSWORD', 'secret');              // SMTP password
    define('MAIL_PORT', 587);                       // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above