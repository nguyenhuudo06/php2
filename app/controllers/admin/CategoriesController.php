<?php

class Categories extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('AdminCategoriesModel');
    }

    function index()
    {
        $this->data['data']['all'] = $this->model->index();
        $this->data['info']['page_title'] = 'Admin - Categories';
        $this->data['contents'] = 'admin/categories/index';


        $this->render('layouts/admin_layout', $this->data);
    }
}