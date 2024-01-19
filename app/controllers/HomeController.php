<?php

class Home {

    function index(){
        echo '1';
    }

    function detail($id='', $slug=''){
        echo 'Id: ' . $id . '</br>';
        echo 'Slug: ' . $slug . '</br>';
    }
}