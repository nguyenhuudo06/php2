<?php

class AccountModel extends Model{

    protected $_table = 'users';

    function tableFill(){
        return 'users';
    }

    function fieldFill(){
        return '*';
    }

    function getList(){
        $data = $this->db->query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function checkAvailable($email){
        $data = $this->db->query("SELECT * FROM $this->_table WHERE email = '$email'")->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function getAuthId($email){
        return $this->db->query("SELECT id FROM users WHERE users.email = '$email'")->fetch(PDO::FETCH_ASSOC);
    }

    function getAccount(){
        $data = $this->db->query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getRegister($table, $data){
        $this->db->insert($table, $data);
    }

    function inserst_activation_code($table, $data){
        $this->db->insert($table, $data);
    }

    function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}