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

        // Xử lý controller
        if(!empty($urlArr[0])){
            $this->__controller = ucfirst($urlArr[0]);
            if(file_exists('app/controllers/' . ($this->__controller) . 'Controller.php')){
                require_once 'app/controllers/' . ($this->__controller) . 'Controller.php';
                $this->__controller = new $this->__controller();
                unset($urlArr[0]);
            }else{
                $this->loadError();
            }
        }

        // Xử lý action
        if(!empty($urlArr[1])){
            $this->__action = ucfirst($urlArr[1]);
            unset($urlArr[1]);
        }
        echo  $this->__action;

        // Xử lý param
        $this->__params = array_values($urlArr);
        
        echo '<pre>';
        print_r($this->__params);
        echo '</pre>';

        call_user_func_array([$this->__controller, $this->__action], $this->__params);
    }

    function loadError($name='404'){
        require_once 'app/errors/' . $name . '.php';
    }
}
