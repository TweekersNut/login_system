<?php

function encrypt($string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = ENC_KEY;
    $secret_iv = ENC_KEY;
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
}
function decrypt($string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = ENC_KEY;
    $secret_iv = ENC_KEY;
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
}

function pwdStrength($pass) {
    $upper = 0;
    $lower = 0;
    $number = 0;
    $special = 0;
    for ($i = 0; $i < strlen($pass); $i++) {
        if (
                $pass[$i] >= 'A' &&
                $pass[$i] <= 'Z'
        )
            $upper++;
        else if (
                $pass[$i] >= 'a' &&
                $pass[$i] <= 'z'
        )
            $lower++;
        else if (
                $pass[$i] >= '0' &&
                $pass[$i] <= '9'
        )
            $number++;
        else
            $special++;
    }
    if ($upper != 0 && $lower != 0 && $number != 0 && $special != 0) {
        return true;
    } else {
        return false;
    }
}

function isSSL() {
    if (isset($_SERVER['HTTPS'])) {
        if ('on' == strtolower($_SERVER['HTTPS'])) {
            return true;
        }
        if ('1' == $_SERVER['HTTPS']) {
            return true;
        }
    } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
        return true;
    }
    return false;
}

function senatize($string,$type = 'string') {
    switch(strtolower($type)){
        case 'int':
            return filter_var($string, FILTER_SANITIZE_STRING);
        break;
        case 'url':
            return filter_var($string, FILTER_SANITIZE_URL);
        break;
        case 'email':
            return filter_var($string, FILTER_VALIDATE_EMAIL);
        break;
        case 'ip':
            return filter_var($string, FILTER_VALIDATE_IP);
        break;
        default:
            return filter_var($string, FILTER_SANITIZE_STRING);
        break;
    }
}

function generateRandomKey() {
    return random_int(9999, 99999999);
}

function timestamp(){
    return date('Y-m-d H:i:s');
}

function randomString($length = 6) {
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

function timeElapsedString($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getIP(){
    if (function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
    } else {
        $headers = $_SERVER;
    }
    if (array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $IP = $headers['X-Forwarded-For'];
    } else if (array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['X-HTTP_X_FORWARDED_FOR-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $IP = $headers['HTTP_X_FORWARDED_FOR'];
    } else {
        $IP = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
    return $IP;
}