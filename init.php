<?php

/**
 * Starting session.
 */

 session_start();

 /**
  * Configs
  */
  date_default_timezone_set("Asia/Calcutta"); // set tiemezone according to your timezone. All time zone list : https://www.w3schools.com/php/php_ref_timezones.asp
  define('ENC_KEY','CKXH2U9RPY3EFD70TLS1ZG4N8WQBOVI6AMJ5'); // Encryption and decrption key
  define('URL_ROOT',"http://loginsystem.local/");
  define('APP_ROOT',(dirname(__FILE__)));

 /**
  * Autoload All classes
  */

  spl_autoload_register(function($class){
        if(file_exists('./classes/'.$class.'.php')){
            include './classes/'. $class . '.php';
        }
  });

/**
 * Loading global functions
 */

include 'functions/functions.php';

/**
 * Static Settings
 */

 $GLOBALS['config'] = [
     'db' => [
         'username' => 'root',
         'password' => '',
         'host' => 'localhost',
         'database' => 'login_system'
     ],
     'template' => [
         'inc' => [
             'header' => './template/inc/header.php',
             'footer' => './template/inc/footer.php'
         ],
         'home' => [
             'index' => './template/home/index.php'
         ],
         'forgot' => [
             'index' => './template/forgot/index.php'
         ],
         'signin' => [
             'index' => './template/login/index.php'
         ],
         'signup' => [
             'index' => './template/signup/index.php'
         ]
    ],
    'support' => [
        'email' => 'admin@tweekersnut.com'
    ]
 ];
