<?php

trait QueryBuilder {

     public $tableName = '';
     public $where = '';
     public $operater = '';
     public $selectField = '*';
     public $limit = '';

    //  Xây dựng query (Method của Core Database) - Dùng thông qua $this->db (Thuộc tính của core model)

     public function table($tableName){
        $this->tableName = $tableName;
        return $this;
     }

     public function where($field, $compare, $value){
        if(empty($this->where)){
            $this->operater = ' WHERE ';
        }else{
            $this->operater = ' AND ';
        }
        $this->where .= "$this->operater $field $compare '$value'";

        return $this;
     }

     public function orWhere($field, $compare, $value){
        if(empty($this->where)){
            $this->operater = ' WHERE ';
        }else{
            $this->operater = ' OR ';
        }
        $this->where .= "$this->operater $field $compare '$value'";

        return $this;
     }

     public function select($field){
        $this->selectField = $field;
        return $this;
     }

     public function get(){
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->where $this->limit";
        $query = $this->query($sqlQuery);

        // Reset field
        $this->resetQuery();

        if(!empty($query)){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
     }

     public function first(){
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->where";
        $query = $this->query($sqlQuery);

        // Reset field
        $this->resetQuery();

        if(!empty($query)){
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
     }

     public function limit($offset=0, $number){
        $this->limit = " LIMIT $offset, $number";
        return $this;
     }

     public function resetQuery(){
        $this->tableName = '';
        $this->where = '';
        $this->operater = '';
        $this->selectField = '*';
     }
}