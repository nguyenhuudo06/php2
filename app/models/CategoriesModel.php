<?php

class CategoriesModel extends Model
{

    protected $_table = 'categories';

    function tableFill()
    {
        return 'categories';
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
        $data = $this->db->query("SELECT *FROM categories");

        return $data;
    }
}
