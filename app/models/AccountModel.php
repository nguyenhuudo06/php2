<?php

class AccountModel extends Model{

    protected $_table = 'users';

    function tableFill(){
        return 'users';
    }

    function fieldFill(){
        return '*';
    }

    function primaryKey(){
        return 'id';
    }

    function get_list(){
        $data = $this->db->query("SELECT * FROM users");
        return $data;
    }

    function create_user($table, $data){
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