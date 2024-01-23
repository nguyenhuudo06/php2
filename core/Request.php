<?php

class Request
{

    // 1. Method
    // 2. Body

    private $__rules = [], $__messages = [];
    public $__errors = [];

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost()
    {
        if ($this->getMethod() == 'post') {
            return true;
        }
        return false;
    }

    public function isGet()
    {
        if ($this->getMethod() == 'get') {
            return true;
        }
        return false;
    }

    public function getFields()
    {

        $dataFields = [];

        if ($this->isGet()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    // Lọc ký tự đặc biệt
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    // Lọc ký tự đặc biệt
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        return $dataFields;
    }

    // Set rules
    public function rules($rules = [])
    {
        $this->__rules = $rules;
    }

    // Set message
    public function message($message = [])
    {
        $this->__messages = $message;
    }

    // Run validate
    public function validate()
    {
        $this->__rules = array_filter($this->__rules);
        $checkValidate = true;

        if (!empty($this->__rules)) {

            $datafields = $this->getFields();

            foreach ($this->__rules as $fieldName => $ruleItem) {
                $ruleItemArr = explode('|', $ruleItem);

                foreach ($ruleItemArr as $rules) {
                    $ruleName = null;
                    $ruleValue = null;

                    $rulesArr = explode(':', $rules);

                    $ruleName = reset($rulesArr);

                    if (count($rulesArr) > 1) {
                        $ruleValue = end($rulesArr);
                    }

                    if($ruleName == 'required'){
                        if(empty(trim($datafields[$fieldName]))){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if($ruleName == 'min'){
                        if(strlen(trim($datafields[$fieldName])) < $ruleValue){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if($ruleName == 'max'){
                        if(strlen(trim($datafields[$fieldName])) > $ruleValue){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if($ruleName == 'email'){
                        if(!filter_var(trim($datafields[$fieldName]), FILTER_VALIDATE_EMAIL)){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if($ruleName == 'match'){
                        if(trim($datafields[$fieldName]) != trim($datafields[$ruleValue])){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }
                }
            }
        }

        return $checkValidate;
    }

    // Errors
    public function errors($fieldName='')
    {
        if(!empty($this->__errors)){
            if(empty($fieldName)){
                $errorsArr = [];
                foreach($this->__errors as $key => $error){
                    $errorsArr[$key] = reset($error);
                }
                return $errorsArr;
            }
            return $this->__errors[$fieldName];
        }
    }

    // Set error
    public function setErrors($fieldName, $ruleName)
    {
        $this->__errors[$fieldName][$ruleName] = $this->__messages[$fieldName.'.'.$ruleName];
    }
}
