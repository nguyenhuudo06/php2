<?php

class AdminUsersModel extends Model
{

    protected $_table = 'users';

    function tableFill()
    {
        return 'users';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryKey()
    {
        return 'id';
    }

    function index()
    {
        $data = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $data;
    }

}
