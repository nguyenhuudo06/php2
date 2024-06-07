<?php

class AdminCategoriesModel extends Model
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

    function index()
    {
        $data = $this->db->query("SELECT c1.id, c1.name, c1.home, c1.parent_id,c2.name AS parent_name FROM categories c1 LEFT JOIN categories c2 ON c1.parent_id = c2.id");
        return $data;
    }
}
