<?php

/**
 * Include initial file for all the configuration and settings.
 */
require 'init.php';

/**
 * Adding Header
 */
$pageTitle = "Forgot Password";
include Config::get('template/inc/header');
/**
 * Check is user logged in or not.
 * If user not logged in redirect to login page.
 */

if(Session::exists('isLoggedIn')){
    Redirect::to('index.php');
}

include Config::get('template/forgot/index');

include Config::get('template/inc/footer');

