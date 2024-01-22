<?php

class Database
{

    use QueryBuilder;

    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    function query($sql)
    {
        try {
            $statement = $this->__conn->prepare($sql);

            $statement->execute();

            return $statement;
        } catch (Exception $exception) {
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

    function getAuthId($email)
    {
        return $this->__conn->query("SELECT id FROM users WHERE 'users.email' = $email")->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->__conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    public function read($table, $conditions = [])
    {
        $sql = "SELECT * FROM $table";

        if (!empty($conditions)) {
            $placeholders = [];
            foreach ($conditions as $key => $value) {
                $placeholders[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(' AND ', $placeholders);
        }
        $stmt = $this->__conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWithCondition($sql = "", $conditions = [])
    {

        $stmt = $this->__conn->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($table, $data, $conditions)
    {
        $updateFields = [];
        foreach ($data as $key => $value) {
            $updateFields[] = "$key = :$key";
        }

        $sql = "UPDATE $table SET " . implode(', ', $updateFields);

        $whereConditions = [];
        foreach ($conditions as $key => $value) {
            $whereConditions[] = "$key = :where_$key";
        }

        $sql .= " WHERE " . implode(' AND ', $whereConditions);

        $stmt = $this->__conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(':where_' . $key, $value);
        }

        return $stmt->execute();
    }

    public function delete($table, $conditions)
    {
        $sql = "DELETE FROM $table";

        $whereConditions = [];
        foreach ($conditions as $key => $value) {
            $whereConditions[] = "$key = :$key";
        }

        $sql .= " WHERE " . implode(' AND ', $whereConditions);

        $stmt = $this->__conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }
}
