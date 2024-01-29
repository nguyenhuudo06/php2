<?php

class UsersModel extends Model
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

    function getList()
    {
        $data = $this->db->query("SELECT *FROM users");

        return $data;
    }
}
