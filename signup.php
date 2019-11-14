<?php
/**
 * Include initial file for all the configuration and settings.
 */
require 'init.php';

/**
 * Header Data Processing
 */

 $pageTitle = "Login page";
/**
 * Adding Header
 */
require Config::get('template/inc/header');

if(Session::exists('isLoggedIn')){
    Redirect::to('index.php');
}

include Config::get('template/signup/index');

/**
 * Adding Footer
 */
require Config::get('template/inc/footer');