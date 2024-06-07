<?php

class Products extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('AdminProductsModel');
    }

    function index()
    {
        $product_list = $this->model->index();
        $this->data['data']['all'] = $product_list;
        $this->data['info']['page_title'] = 'Admin - Products';
        $this->data['contents'] = 'admin/products/index';


        $this->render('layouts/admin_layout', $this->data);
    }
}