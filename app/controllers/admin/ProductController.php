<?php

class Product extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('ProductModel');
    }

    function index()
    {
        $list = $this->model->getList()->fetchAll(PDO::FETCH_ASSOC);
        $this->data['sub_content']['title'] = 'Admin/Product';
        $this->data['sub_content']['lists'] = $list;
        $this->data['sub_content']['js'][0] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        $this->data['sub_content']['js'][1] = _WEB_ROOT_ . '\public\vendors\sweetAlert2\sweetAlert2.js';
        $this->data['sub_content']['js'][2] = _WEB_ROOT_ . '\public\assets\admin\js\product-delete.js';
        $this->data['content'] = 'admin\products\index';

        // echo '<pre>';
        // print_r($list);
        // echo '</pre>';

        $this->render('layouts/admin_layout', $this->data);
    }

    function delete($id)
    {
        header('Content-Type: application/json');
        try{
            http_response_code(200);
            // Dùng die không dùng return
            // Dữ liệu ajax truyền qua http( ? ), phải echo/die mới lấy được data, 
            // return -> bug, vì giá trị của nó cần gán cho variables -> dùng
            die(json_encode([
                'code' => 200,
                'message' => 'success'
            ]));
        }catch (Exception $exception) {
            http_response_code(500);
            // Dùng die không dùng return
            die(json_encode([
                'code' => 500,
                'message' => 'false',
                'error' => $exception->getMessage(),
            ]));
        }
     
    }
}
