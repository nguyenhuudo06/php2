<?php

class Database
{

    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    function query($sql)
    {
        try{
            $statement = $this->__conn->prepare($sql);
            $statement->execute();
            return $statement;
        }catch(Exception $exception){
            $mess = $exception->getMessage();
            $data['message'] = $mess;
            App::$app->loadError('database', $data);
            die();
        }
    }

    function lastInsertId()
    {
        return $this->__conn->lastInsertId();
    }

    function getAuthId($email){
        return $this->__conn->query("SELECT id FROM users WHERE 'users.email' = $email")->fetch(PDO::FETCH_ASSOC);
    }

    function insert($table, $data) {
        if (!empty($data)) { 
            $fieldStr = '';
            $valueStr = '';
            foreach ($data as $key => $value) { 
                $fieldStr.=$key.',';
                $valueStr.="'".$value."',";
            }
            $fieldStr = rtrim($fieldStr, ', ');
            $valueStr = rtrim($valueStr, ',');

            $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)";

            $status = $this->query($sql);

            if ($status) {
                return true;
            }
            return false;
        }
    }
}
