<?php

class Home extends Controller{

    public $model_home;
    public $data = [];

    function __construct()
    {
        $this->model_home = $this->model('HomeModel');
    }

    function index(){
        $data = $this->model_home->getList();
        // $data = $this->model_home->get();
        echo '<pre>';
        print_r($data);
        echo '</pre>';

    }

    function list_product(){
        $detail = $this->model_home->getList();
        $title = 'Trang chu';

        $this->data['sub_content']['title'] = $title;
        $this->data['sub_content']['product_list'] = $detail;
        $this->data['content'] = 'home/index';

        echo '<pre>';
        print_r($detail);
        echo '</pre>';

        // $this->render('layouts/client_layout', $this->data);
    }
}