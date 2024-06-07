<?php

class HomeProducts extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('ProductsModel');
    }

    function index()
    {
        echo 123;
    }
    
    function details()
    {
        if (empty($_GET['id'])) {
            App::$app->loadError();
            exit();
        }

        $this->model->increaseViews($_GET['id']);
        $this->data['data']['details'] = $this->model->index($_GET['id']);
        $this->data['data']['categories'] = $this->model->homeCategories();
        $this->data['contents'] = 'users/products/details';

        $this->render('layouts/users_layout', $this->data);
    }
}
