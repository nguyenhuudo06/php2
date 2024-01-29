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
        $list = $this->model->getList()->fetchAll(PDO::FETCH_ASSOC);
        $this->data['sub_content']['title'] = 'Home';
        $this->data['sub_content']['lists'] = $list;
        $this->data['content'] = 'home\index';

        $this->render('layouts/client_layout', $this->data);
    }

    function list_product()
    {
        $detail = $this->model->getList()->fetchAll(PDO::FETCH_ASSOC);
        $title = 'Trang chu';

        $this->data['sub_content']['title'] = $title;
        $this->data['sub_content']['product_list'] = $detail;
        $this->data['content'] = 'home/index';

        echo '<pre>';
        print_r($detail);
        echo '</pre>';

        // $this->render('layouts/client_layout', $this->data);
    }

    function getListProduct()
    {
        $data = $this->model->ttt();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    function get_category()
    {
        $request = new Request();
        $data = $request->getFields();

        $response = new Response();
        // $response->redirect('home/index');
        // $response->redirect('https://www.google.com/');

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
