<?php

class Home extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('HomeModel');
    }

    function index()
    {
        $this->data['data']['all'] = $this->model->index();
        $this->data['data']['mostViews'] = $this->model->mostViews();
        $this->data['data']['lessCommon'] = $this->model->lessCommon();
        $this->data['data']['categories'] = $this->model->getCategory(1);
        $this->data['info']['page_title'] = 'Home';
        $this->data['contents'] = 'users/home/index';


        $this->render('layouts/users_layout', $this->data);
    }
}
