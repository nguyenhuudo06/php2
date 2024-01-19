<?php

class Home extends Controller{

    public $model_home;
    public $data = [];

    function __construct()
    {
        $this->model_home = $this->model('HomeModel');
    }

    function index(){
        $detail = $this->model_home->getDetail(0);

        echo '<pre>';
        print_r($detail);
        echo '</pre>';
    }

    function list_product($id = 0){
        $detail = $this->model_home->getDetail($id);
        $title = 'Trang chu';

        $this->data['sub_content']['title'] = $title;
        $this->data['sub_content']['product_list'] = $detail;
        $this->data['content'] = 'home/index';

        $this->render('layouts/client_layout', $this->data);
    }
}