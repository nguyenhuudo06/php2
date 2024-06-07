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
            $result = $statement->fetchAll();

            return $result;
        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            $data['message'] = $mess;
            App::$app->loadError('database', $data);
            die();
        }
    }

    function query2($sql, $params = [])
    {
        try {
            $statement = $this->__conn->prepare($sql);

            // Bind các tham số nếu có
            foreach ($params as $key => &$value) {
                $statement->bindParam($key, $value);
            }

            $statement->execute();
            // $result = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    public function insertData($table, $data)
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

    public function readData($table, $conditions = [])
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


    // public function updateData($table, $data, $conditions)
    // {
    //     $updateFields = [];
    //     foreach ($data as $key => $value) {
    //         $updateFields[] = "$key = :$key";
    //     }

    //     $sql = "UPDATE $table SET " . implode(', ', $updateFields);

    //     $whereConditions = [];
    //     foreach ($conditions as $key => $value) {
    //         $whereConditions[] = "$key = :where_$key";
    //     }

    //     $sql .= " WHERE " . implode(' AND ', $whereConditions);

    //     $stmt = $this->__conn->prepare($sql);

    //     foreach ($data as $key => $value) {
    //         $stmt->bindValue(':' . $key, $value);
    //     }

    //     foreach ($conditions as $key => $value) {
    //         $stmt->bindValue(':where_' . $key, $value);
    //     }

    //     // var_dump($stmt);
    //     return $stmt->execute();
    // }

    // public function deleteData($table, $conditions)
    // {
    //     $sql = "DELETE FROM $table";

    //     $whereConditions = [];
    //     foreach ($conditions as $key => $value) {
    //         $whereConditions[] = "$key = :$key";
    //     }

    //     $sql .= " WHERE " . implode(' AND ', $whereConditions);

    //     $stmt = $this->__conn->prepare($sql);

    //     foreach ($conditions as $key => $value) {
    //         $stmt->bindValue(':' . $key, $value);
    //     }

    //     return $stmt->execute();
    // }

    function updateData($table, $data, $conditions = '')
    {
        if (!empty($data)) {
            $updateStr = '';
            foreach ($data as $key => $value) {
                $updateStr .= "$key='$value',";
            }

            $updateStr = rtrim($updateStr, ',');

            if (!empty($conditions)) {
                $sql = "UPDATE $table SET $updateStr  WHERE $conditions";
            } else {
                $sql = "UPDATE $table SET $updateStr";
            }

            $status = $this->query($sql);
            if ($status) {
                return true;
            }
        }
        return false;
    }

    function deleteData($table, $conditions = '')
    {
        if (!empty($conditions)) {
            $sql = 'DELETE FROM ' . $table . ' WHERE ' . $conditions;
        } else {
            $sql = 'DELETE FROM ' . $table;
        }
        $status = $this->query($sql);
        if ($status) {
            return true;
        }
        return false;
    }
}
