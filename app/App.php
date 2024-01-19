<?php

class App
{
    private $__controller, $__action, $__params;

    function __construct()
    {
        $this->__controller = 'home';
        $this->__action = 'index';
        $this->__params = [];
        $this->handleUrl();
    }

    function getUrl()
    {
        if(!empty($_SERVER['PATH_INFO'])){
            $url = $_SERVER['PATH_INFO'];
        }else{
            $url = '/';
        }
        return $url;
    }

    function handleUrl(){
        $url = $this->getUrl();
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);

        echo '<pre>';
        print_r($urlArr);
        echo '</pre>';

        if(!empty($urlArr[0])){
            $this->__controller = ucfirst($urlArr[0]);
            if(file_exists('app/controllers/' . ($this->__controller) . '.php')){
                require_once 'app/controllers/' . ($this->__controller) . '.php';
                $this->__controller = new $this->__controller();

            }else{
                $this->loadError();
            }
        }
    }

    function loadError($name='404'){
        require_once 'app/errors/' . $name . '.php';
    }
}
