<?php

class Categories extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('CategoriesModel');
    }

    function index()
    {
        $list = $this->model->getList()->fetchAll(PDO::FETCH_ASSOC);
        $this->data['sub_content']['title'] = 'Admin/Product';
        $this->data['sub_content']['lists'] = $list;
        // $this->data['sub_content']['js'][0] = 'https://code.jquery.com/jquery-3.6.4.min.js';
        // $this->data['sub_content']['js'][1] = _WEB_ROOT_ . '\public\vendors\sweetAlert2\sweetAlert2.js';
        // $this->data['sub_content']['js'][2] = _WEB_ROOT_ . '\public\assets\admin\js\product-delete.js';
        $this->data['content'] = 'admin\categories\index';

        // echo '<pre>';
        // print_r($list);
        // echo '</pre>';

        $this->render('layouts/admin_layout', $this->data);
    }

}
