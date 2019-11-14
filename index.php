<?php

/**
 * Include initial file for all the configuration and settings.
 */
require 'init.php';

/**
 * Adding Header
 */
$pageTitle = "Home";
include Config::get('template/inc/header');
/**
 * Check is user logged in or not.
 * If user not logged in redirect to login page.
 */

if(!Session::exists('isLoggedIn')){
    Redirect::to('login.php');
}

$userData = (new User)->get(Session::get('U_ID'));

include Config::get('template/home/index');

/**
 * Adding Footer
 */
include  Config::get('template/inc/footer');