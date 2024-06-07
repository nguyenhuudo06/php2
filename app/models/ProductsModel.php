<?php

class ProductsModel extends Model
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

    function index($id)
    {
        $data = $this->db->query("SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.categories_id = c.id WHERE p.id=" . $id);
        return $data;
    }

    function increaseViews($id)
    {
        $this->db->query("UPDATE products SET views = views + 1 WHERE id=" . $id);
    }

    function homeCategories()
    {
        $data = $this->db->query("SELECT * FROM categories WHERE home = 1 LIMIT 6");
        return $data;
    }
}
