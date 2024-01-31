<?php

class Controller {

    public $db;
    
    function model($model){
        if(file_exists(_DIR_ROOT_ . '/app/models/' . $model . '.php')){
            require_once _DIR_ROOT_ . '/app/models/' . $model . '.php';
            if(class_exists($model)){
                $model = new $model();
                return $model;
            }
        }
        return false;
    }

    function render($view, $data=[]){

        extract($data);

        if(file_exists(_DIR_ROOT_ . '/app/views/' . $view . '.php')){
            require_once _DIR_ROOT_ . '/app/views/' . $view . '.php';
        }
    }

    function isLoggedIn(){
        return !empty($_SESSION['auth']) ? $_SESSION['auth'] : false;
    }
}