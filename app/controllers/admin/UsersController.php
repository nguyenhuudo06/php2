<?php

class Users extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('AdminUsersModel');
    }

    function index()
    {
        $this->data['data']['all'] = $this->model->index();
        $this->data['info']['page_title'] = 'Admin - Users';
        $this->data['contents'] = 'admin/users/index';


        $this->render('layouts/admin_layout', $this->data);
    }
}