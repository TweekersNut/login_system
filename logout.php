<?php

include 'init.php';

if(Session::exists('isLoggedIn')){    
    (new User)->createLog(Session::get('U_ID'),'Logged Out from '. getIP());
    (new User)->logout();
    Redirect::to($_SERVER['PHP_SELF']); 
}else{
    Redirect::to('login.php');
}
