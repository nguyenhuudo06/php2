<?php

class Connection
{

    private static $instance = null, $conn = null;


    private function __construct($config)
    {
        $hostName = $config['host'];
        $dbName = $config['db'];
        $user = $config['username'];
        $pass = empty($config['password']) ? '' : $config['password'];

        try {
            $con = new PDO("mysql:host=$hostName;dbname=$dbName;port=3307", $user, $pass);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->exec("SET NAMES 'utf8'");
            self::$conn = $con;
        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            $data['message'] = $mess;
            App::$app->loadError('database', $data);
            die();
        }
    }

    public static function getInstance($config)
    {
        if (self::$instance == null) {
            $connection = new Connection($config);
            self::$instance = self::$conn;
        }
        return self::$instance;
    }
}
