<?php

class Home extends Controller
{

    public $model_home;
    public $data = [];

    function __construct()
    {
        $this->model_home = $this->model('HomeModel');
    }

    function index()
    {
        // Dùng model tương ứng
        $data = $this->model_home->getList();
        // Dùng trực tiếp core model
        // $data = $this->model_home->get();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    function list_product()
    {
        $detail = $this->model_home->getList()->fetchAll(PDO::FETCH_ASSOC);
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
        $data = $this->model_home->ttt();
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
