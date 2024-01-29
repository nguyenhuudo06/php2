<?php

class ProductModel extends Model
{

    protected $_table = 'products';

    function tableFill()
    {
        return 'products';
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
        $data = $this->db->query("SELECT 
            products.*, 
            categories.name AS category_name
            FROM products
            JOIN categories ON products.category_id = categories.id WHERE products.deleted_at IS NULL
        ");

        return $data;
    }
}
