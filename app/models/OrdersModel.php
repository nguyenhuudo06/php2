<?php

class OrdersModel extends Model
{

    protected $_table = 'orders';

    function tableFill()
    {
        return 'orders';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryKey()
    {
        return 'id';
    }

    function getList()
    {
        $data = $this->db->query("SELECT *FROM orders");

        return $data;
    }
}
