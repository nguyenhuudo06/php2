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

    // Hàm kiểm tra phương thức post/get
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

    // Lấy dữ liệu các trường
    public function getDataFields()
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

        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $value) {
                if (is_array($value['error'])) {
                    $check = true;
                    foreach ($value['error'] as $key1 => $value1) {
                        if ($value1  == UPLOAD_ERR_OK) {
                            $check = true;
                        } else {
                            $check = false;
                            break;
                        }
                    }
                    if ($check) {
                        $dataFields[$key] = $value['tmp_name'];
                    } else {
                        $dataFields[$key] = '';
                    }
                } elseif ($value['error'] == UPLOAD_ERR_OK) {
                    $dataFields[$key] = $value['tmp_name'];
                } else {
                    $dataFields[$key] = '';
                }
            }
            // echo '<pre>' . '</br>';
            // print_r($_FILES);
            // echo '<pre>' . '</br>';
        }

        return $dataFields;
    }

    // Set rules
    public function rules($rules = [])
    {
        $this->__rules = $rules;
    }

    // Set message of rules
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

            $datafields = $this->getDataFields();
            echo '<pre>' . '</br>';
            print_r($datafields);
            echo '<pre>' . '</br>';
            // exit();

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

                    if (isset($datafields[$fieldName])) {
                        if ($ruleName == 'required') {
                            if (is_array($datafields[$fieldName])) {
                                if (empty(($datafields[$fieldName]))) {
                                    $this->setErrors($fieldName, $ruleName);
                                    $checkValidate = false;
                                }
                            } else {
                                if (empty(trim($datafields[$fieldName]))) {
                                    $this->setErrors($fieldName, $ruleName);
                                    $checkValidate = false;
                                }
                            }
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

                        if (!empty($rulesArr[1])) {
                            $tableName = $rulesArr[1];
                        }
                        if (!empty($rulesArr[2])) {
                            $fieldCheck = $rulesArr[2];
                        }

                        if (!empty($tableName) && !empty($fieldCheck)) {
                            $condition = trim($datafields[$fieldName]);
                            if (count($rulesArr) == 3) {
                                $checkExit = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck='$condition'")->rowCount();
                            } else if (count($rulesArr) == 4) { // Trường hợp update bị trùng với chính mình
                                if (!empty($rulesArr[3]) && preg_match('~.+?\=.+?~is', $rulesArr[3])) {
                                    $conditionWhere = $rulesArr[3];
                                    $conditionWhere = str_replace('=', '<>', $conditionWhere);
                                    $checkExit = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck='$condition' AND $conditionWhere")->rowCount();
                                }
                            }
                            if (!empty($checkExit)) {
                                $this->setErrors($fieldName, $ruleName);
                                $checkValidate = false;
                            }
                        }
                    }

                    // Callback validate
                    if (!empty($datafields[$fieldName])) {
                        if (preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)) {
                            if (!empty($callbackArr[1])) {
                                $callbackName = $callbackArr[1];
                                $controller = App::$app->getCurrentController();
                                if (method_exists($controller, $callbackName)) {
                                    $agurment = !empty($datafields[$fieldName]) && !is_array($datafields[$fieldName]) ? trim($datafields[$fieldName]) : $datafields[$fieldName];

                                    $checkCallback = call_user_func_array([$controller, $callbackName], [$agurment]);
                                    if (!$checkCallback) {
                                        $this->setErrors($fieldName, $ruleName);
                                        $checkValidate = false;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $sessionKey = Session::isInvalid();
        Session::flash($sessionKey . '_errors', $this->errors());
        Session::flash($sessionKey . '_old', $this->getDataFields());
        return $checkValidate;
    }

    // Get errors
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
