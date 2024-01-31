<?php

class Request
{

    // 1. Method
    // 2. Body 

    private $__rules = [], $__messages = [], $__errors = [];
    public $db;

    function __construct()
    {
        $this->db = new Database();
    }

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

    // Set message, description
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

                    if ($ruleName == 'required') {
                        if (empty(trim($datafields[$fieldName]))) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'min') {
                        if (strlen(trim($datafields[$fieldName])) < $ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'max') {
                        if (strlen(trim($datafields[$fieldName])) > $ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'email') {
                        if (!filter_var(trim($datafields[$fieldName]), FILTER_VALIDATE_EMAIL)) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'match') {
                        if (trim($datafields[$fieldName]) != trim($datafields[$ruleValue])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'unique') {
                        $tableName = null;
                        $fieldCheck = null;
                        // echo '<pre>';
                        // print_r($rulesArr);
                        // echo '</pre>';

                        if (!empty($rulesArr[1])) {
                            $tableName = $rulesArr[1];
                        }
                        if (!empty($rulesArr[2])) {
                            $fieldCheck = $rulesArr[2];
                        }

                        if (!empty($tableName) && !empty($fieldCheck)) {
                            if (count($rulesArr) == 3) {
                                $checkExit = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck='$datafields[$fieldName]'")->rowCount();
                            } else if (count($rulesArr) == 4) { // Trường hợp update bị trùng với chính mình
                                if (!empty($rulesArr[3]) && preg_match('~.+?\=.+?~is', $rulesArr[3])) {
                                    $conditionWhere = $rulesArr[3];
                                    $conditionWhere = str_replace('=', '<>', $conditionWhere);
                                    $checkExit = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck='$datafields[$fieldName]' AND $conditionWhere")->rowCount();
                                }
                            }
                            if (!empty($checkExit)) {
                                $this->setErrors($fieldName, $ruleName);
                                $checkValidate = false;
                            }
                        }
                    }
                    // Callback validate
                    if (preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)) {
                        echo '<pre>';
                        print_r($callbackArr);
                        echo '</pre>';
                    }
                }
            }
        }

        return $checkValidate;
    }

    public function check_age($age)
    {
        return $age >= 20 ? true : false;
    }

    // Errors
    public function errors($fieldName = '')
    {
        if (!empty($this->__errors)) {
            if (empty($fieldName)) {
                $errorsArr = [];
                foreach ($this->__errors as $key => $error) {
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
        $this->__errors[$fieldName][$ruleName] = $this->__messages[$fieldName . '.' . $ruleName];
    }
}
