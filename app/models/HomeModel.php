<?php

class HomeModel {

    protected $_table = 'products';

    function getList(){
        $data = [
            'Item1',
            'Item1',
            'Item1',
            'Item1',
        ];
        return $data;
    }

    function getDetail($id){
        $data = [
            'Item1',
            'Item2',
            'Item3',
            'Item4',
        ];
        return $data[$id];
    }
}