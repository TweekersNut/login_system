<?php
/**
 * Author : Taranpreet Singh
 * PHPCLASSES Profile : https://www.phpclasses.org/browse/author/1466924.html
 * Want to get something developed ? Let's make it email at : taranpreet@taranpreetsingh.com 
 */
class Config{

    public static function get($path = null){
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/',$path);
            
            foreach ($path as $bit){
                if(isset($config[$bit])){
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }

}
