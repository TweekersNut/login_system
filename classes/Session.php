<?php 
/**
 * Author : Taranpreet Singh
 * PHPCLASSES Profile : https://www.phpclasses.org/browse/author/1466924.html
 * Want to get something developed ? Let's make it email at : taranpreet@taranpreetsingh.com 
 */
class Session {
    
    /**
     * 
     * @param type $key
     * @return boolean
     */
    public static function exists($key) : bool{
        return (isset($_SESSION[$key])) ? true : false;
    }
    
    /**
     * 
     * @param type $key
     * @param type $val
     * @return string
     */
    public static function insert($key,$val){
        return $_SESSION[$key] = $val;
    }
    
    /**
     * 
     * @param type $key
     * @return string
     */
    public static function get($key) : string{
        return $_SESSION[$key];
    }
    
    /**
     * 
     * @param type $key
     */
    public static function del($key){
        if(self::exists($key)){
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * 
     * @param type $key
     * @param type $val
     * @return string
     */
    public static function flash($key,$val = ''){
        if(self::exists($key)){
            $session = self::get($key);
            self::del($key);
            return $session;
        }else{
            self::insert($key, $val);
        }
    }
    
}