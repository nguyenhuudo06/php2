<?php

class App
{
    private $__controller, $__action, $__params, $__routes, $__db;
    static public $app;

    function __construct()
    {
        global $routes;
        global $configs;
        self::$app = $this; // Gán instace hiện tại cho class App, dùng bằng cách App::$app

        $this->__routes = new Route();  // Tạo instance của class Route

        // Tạo mặc định / reset các giá trị của controller, action (method), param
        if (!empty($routes['default_controller'])) {
            $this->__controller = 'home';
        }
        $this->__action = 'index';
        $this->__params = [];

        // Tạo instance của class DB -> Database -> Connection -> Kết nối database
        // Bước DB có vẻ dài dòng, thừa
        if (class_exists('DB')) {
            $dbObject = new DB();
            $this->__db = $dbObject->db;
        }

        // Bắt đầu xử lý URL
        $this->handleUrl();
    }

    // Lấy URL hiện tại của trang web
    function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }

    // Hàm xử lý URL
    // function handleUrl()
    // {

    //     $url = $this->getUrl(); // Lấy URL

    //     $url = $this->__routes->handleRoute($url); // Xử lý route - rewrite route

    //     // echo '<pre>';
    //     // echo($url . '</br>');
    //     // print_r($_GET);
    //     // echo '</pre>';
    //     // die();


    //     $urlArr = array_filter(explode('/', $url)); // Biến URL thành mảng, lọc các phần từ rỗng
    //     $urlArr = array_values($urlArr); // Tạo ra một mảng mới với các giá trị của mảng chỉ định, bắt đầu từ khóa 0

    //     // Xử lý đối với controller không trực tiếp trong folder controlllers, cấp thư mục nhỏ hơn vd: controlllers/admin/categoriescontroller.php
    //     $urlcheck = '';
    //     if (!empty($urlArr)) {
    //         foreach ($urlArr as $key => $item) {
    //             // Nối URL từ mảng
    //             $urlcheck .= $item . '/';
    //             $fileCheck = rtrim($urlcheck, '/'); // Cắt dấu '/' ở cuối

    //             $fileArr = explode('/', $fileCheck);
    //             $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]); // Chuyển đổi ký tự đầu tiên của phần tử cuối cùng trong mảng $fileArr thành chữ hoa
    //             $fileCheck = implode('/', $fileArr); // Nối các phần tử trong mảng lại thành một chuỗi mới với dấu '/' là phân cách

    //             // Xóa key:value vòng lặp trước đó
    //             if (!empty($urlArr[$key - 1])) {
    //                 unset($urlArr[$key - 1]);
    //             }

    //             // echo '<pre>';
    //             // echo('urlcheck:     ' . $urlcheck . '</br>');
    //             // echo('fileCheck:    ' . $fileCheck . '</br>');
    //             // print_r($urlArr);
    //             // echo('</br>');
    //             // echo '</pre>';

    //             // Nếu tìm được file thì dừng vòng lặp
    //             if (file_exists('app/controllers/' . ($fileCheck) . 'Controller.php')) {
    //                 $urlcheck = $fileCheck;
    //                 break;
    //             }
    //         }
    //     }

    //     $urlArr = array_values($urlArr); // Tạo ra một mảng mới với các giá trị của mảng chỉ định, bắt đầu từ khóa 0


    //     if (!empty($urlArr[0])) {
    //         $this->__controller = ucfirst($urlArr[0]); // Viết hoa chữ cái đầu
    //     } else {
    //         $this->__controller = ucfirst($this->__controller);
    //     }

    //     if (empty($urlcheck)) {
    //         $urlcheck = $this->__controller;
    //     }

    //     // Nhúng file controller
    //     if (file_exists('app/controllers/' . ($urlcheck) . 'Controller.php')) {
    //         require_once 'app/controllers/' . ($urlcheck) . 'Controller.php';

    //         // Kiem tra class ton tai
    //         if (class_exists($this->__controller)) {
    //             $this->__controller = new $this->__controller();
    //             unset($urlArr[0]);

    //             if (!empty($this->__db)) {
    //                 $this->__controller->db = $this->__db;
    //             }
    //         } else {
    //             $this->loadError();
    //         }
    //     } else {
    //         $this->loadError();
    //     }

    //     // Xử lý action
    //     if (!empty($urlArr[1])) {
    //         $this->__action = ucfirst($urlArr[1]);
    //         unset($urlArr[1]);
    //     }

    //     // Xử lý param
    //     $this->__params = array_values($urlArr);

    //     // Kiểm tra method tồn tại
    //     if (method_exists($this->__controller, $this->__action)) {
    //         call_user_func_array([$this->__controller, $this->__action], $this->__params);
    //     } else {
    //         $this->loadError();
    //     }
    // }

    function handleUrl()
    {
        $url = $this->getUrl(); // Lấy URL
        $url = $this->__routes->handleRoute($url); // Xử lý route - rewrite route

        $urlArr = array_filter(explode('/', $url)); // Biến URL thành mảng, lọc các phần từ rỗng
        $urlArr = array_values($urlArr); // Tạo ra một mảng mới với các giá trị của mảng chỉ định, bắt đầu từ khóa 0

        // Xử lý đối với controller không trực tiếp trong folder controllers, cấp thư mục nhỏ hơn vd: controllers/admin/categoriescontroller.php
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

        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (empty($urlcheck)) {
            $urlcheck = $this->__controller;
        }

        if (file_exists('app/controllers/' . ($urlcheck) . 'Controller.php')) {
            require_once 'app/controllers/' . ($urlcheck) . 'Controller.php';

            if (class_exists($this->__controller)) {
                $controllerInstance = new $this->__controller();
                $this->__controller = $controllerInstance;
                unset($urlArr[0]);

                if (!empty($this->__db)) {
                    $this->__controller->db = $this->__db;
                }
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }

        if (!empty($urlArr[1])) {
            $this->__action = ucfirst($urlArr[1]);
            unset($urlArr[1]);
        }

        $this->__params = array_values($urlArr);

        // Kiểm tra method tồn tại
        if (method_exists($this->__controller, $this->__action)) {
            // Gọi middleware kiểm tra quyền truy cập
            $middleware = new AuthMiddleware();
            $controllerClass = get_class($this->__controller);
            $actionName = $this->__action;
            if (!$middleware->check('1', $controllerClass, $actionName)) {
                $this->loadError('403'); // Tải trang lỗi 403 nếu không có quyền truy cập
                return;
            }

            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }

        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }



    public function getCurrentController()
    {
        return $this->__controller;
    }

    function loadError($name = '404', $data = [])
    {
        extract($data);
        require_once 'app/errors/' . $name . '.php';
    }
}
