<?php
/**
 * Author : Taranpreet Singh
 * PHPCLASSES Profile : https://www.phpclasses.org/browse/author/1466924.html
 * Want to get something developed ? Let's make it email at : taranpreet@taranpreetsingh.com 
 */
class Validator {

    private $db = null, $_passed = false, $_errors = [];

    function __construct() {
        $database = new DB;
        $this->db = $database->getConnection();
    }

    public function validate($source, $items = []) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $ruleValue) {
                $value = trim($source[$item]);
                $item = htmlentities($item, ENT_QUOTES, 'UTF-8');

                if ($rule == 'required' && empty($value)) {
                    $this->addError("Error {$item} is required.");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $ruleValue) {
                                $this->addError("Error {$item} must be minimum of {$ruleValue}.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $ruleValue) {
                                $this->addError("Error {$item} must be maximum of {$ruleValue}.");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$ruleValue]) {
                                $this->addError("Error {$ruleValue} must match {$item}.");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->prepare("SELECT * FROM {$ruleValue} where {$item} = '{$value}'");
                            $check->execute();
                            if (count($check->fetchAll(PDO::FETCH_OBJ)) > 0) {
                                $this->addError("Error {$item} already exists.");
                            }
                            break;
                        default:

                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

}