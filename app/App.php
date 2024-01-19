<?php

class App
{
    private $__controller, $__action, $__params, $__routes;

    function __construct()
    {
        global $routes;

        $this->__routes = new Route();

        if (!empty($routes['default_controller'])) {
            $this->__controller = 'home';
        }
        $this->__action = 'index';
        $this->__params = [];

        $this->handleUrl();
    }

    function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }

    function handleUrl()
    {

        $url = $this->getUrl();

        $url = $this->__routes->handleRoute($url);


        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);

        $urlcheck = '';
        if (!empty($urlArr)) {
            foreach ($urlArr as $key => $item) {
                $urlcheck .= $item . '/';
                $fileCheck = rtrim($urlcheck, '/');
                $fileArr = explode('/', $fileCheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                $fileCheck = implode('/', $fileArr);

                if (!empty($urlArr[$key - 1])) {
                    unset($urlArr[$key - 1]);
                }
                if (file_exists('app/controllers/' . ($fileCheck) . 'Controller.php')) {
                    $urlcheck = $fileCheck;
                    break;
                }
            }
        }

        $urlArr = array_values($urlArr);

        // Xử lý controller
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (file_exists('app/controllers/' . ($urlcheck) . 'Controller.php')) {
            require_once 'app/controllers/' . ($urlcheck) . 'Controller.php';

            // Kiem tra class ton tai
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
                unset($urlArr[0]);
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }

        // Xử lý action
        if (!empty($urlArr[1])) {
            $this->__action = ucfirst($urlArr[1]);
            unset($urlArr[1]);
        }

        // Xử lý param
        $this->__params = array_values($urlArr);

        // echo '<pre>';
        // print_r($this->__params);
        // echo '</pre>';

        // Kiem tra method ton tai
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }

    function loadError($name = '404')
    {
        require_once 'app/errors/' . $name . '.php';
    }
}
