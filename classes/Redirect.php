<?php
/**
 * Author : Taranpreet Singh
 * PHPCLASSES Profile : https://www.phpclasses.org/browse/author/1466924.html
 * Want to get something developed ? Let's make it email at : taranpreet@taranpreetsingh.com 
 */
class Redirect{

    public static function to($location = null){
        if($location){
            if(is_numeric($location)){
                switch($location){
                    case '404':
                        header('HTTP/1.0 404 Not Found', true, 404);
                        exit();
                      break;
                  default :
                      exit();
                      break;
                }
            }
            echo "<script>window.location='{$location}'</script>";
            exit();
        }
    }

}