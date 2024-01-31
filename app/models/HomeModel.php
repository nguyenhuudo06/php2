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

    function getList()
    {
        $data = $this->db->query("SELECT * FROM products");
        return $data;
    }

    function ttt()
    {
        // $data= $this->db->table('products')->select('id, name, price')->where('id', '>', 3)->where('name', 'LIKE', '%no%')->orderBy('id', 'ASC')->limit(0, 5)->get();
        // $data = $this->db->orderBy('id', 'DESC');
        // $data = $this->db->orderBy('id DESC , name DESC');
        $data = $this->db
            ->table('products')
            ->select('products.id as p_id, categories.id as c_id')
            ->join('categories', 'products.category_id=categories.id')
            ->get();

        return $data;
    }

    function insertUser($data)
    {
        $this->db
            ->table('users')
            ->insert($data);
        return $this->db->lastId();
    }

    function updateUser($id, $data)
    {
        $this->db
            ->table('users')
            ->where('id', '=', $id)
            ->update($data);
    }

    function deleteUser($id)
    {
        $this->db
            ->table('users')
            ->where('id', '=', $id)
            ->delete();
    }
}
