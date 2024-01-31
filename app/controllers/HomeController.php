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
        $data = [
            'name' => '12345',
            'email' => 'conco144@gmail.com',
            'password' => '12344555',
        ];
        echo $this->model->deleteUser(10);
        
        $title = 'Trang chu';
        $this->data['sub_content']['title'] = $title;
        // $this->data['sub_content']['product_list'] = $detail;
        $this->data['content'] = 'home/index';

        // $this->render('layouts/client_layout', $this->data);
    }

    function getListProduct()
    {
        $data = $this->db->table('users')->get();
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
