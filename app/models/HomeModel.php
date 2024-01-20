<?php

class HomeModel extends Model{

    protected $_table = 'products';

    function tableFill(){
        return 'products';
    }

    function fieldFill(){
        return '*';
    }

    function getList(){
        $data = $this->db->query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);
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