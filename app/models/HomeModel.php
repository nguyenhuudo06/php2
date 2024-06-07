<?php

class HomeModel extends Model
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

    // Có 3 kiểu truy vấn
    // Theo Core Database Query: Truyền SQL trực tiếp vào query (Query của Core Database) - Dùng thông qua $this->db (Thuộc tính của Core Model)
    // Theo Core Database + QueryBuilder: Xây dựng query (Method của QueryBuilder) - Dùng thông qua $this->db (Thuộc tính của Core Model)
    // Trực tiếp theo các hàm thiết đặt ở trên: Dùng theo cấu hình trực tiếp của model tương ứng - gọi trực tiếp

    function index()
    {
        $data = $this->db->query("SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.categories_id = c.id ORDER BY id DESC");
        return $data;
    }

    function mostViews()
    {
        $data = $this->db->query("SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.categories_id = c.id ORDER BY views DESC");
        return $data;
    }

    function lessCommon()
    {
        $data = $this->db->query("SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.categories_id = c.id ORDER BY quantity DESC");
        return $data;
    }

    function getCategory($id = 1)
    {
        $data = [];
        $categories = $this->db->query("SELECT * FROM categories WHERE home = " . $id);

        foreach ($categories as $category){
            $data[$category['name']] = $this->db->query("SELECT * FROM products WHERE categories_id = " . $category['id']);
        }
        
        return $data;
    }
}
