<?php

class Auth extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('UserModel');
    }

    function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->model->authenticateUser($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                // Chuyển hướng đến trang khác
                header('Location: ' . _WEB_ROOT_ . '/home');
                exit();
            } else {
                header('Location: ' . _WEB_ROOT_ . ' /auth/login');
            }
        } else {
            $this->data['info']['page_title'] = 'Login';

            $this->render('users/auth/login', $this->data);
        }
    }

    function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->model->store($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // Chuyển hướng đến trang khác
                header('Location: ' . _WEB_ROOT_ . '/home');
                exit();
            } else {
                header('Location: ' . _WEB_ROOT_ . ' /auth/login');
            }

        } else {
            $this->data['info']['page_title'] = 'Register';

            $this->render('users/auth/register', $this->data);
        }
    }

    function logout()
    {
        // Xóa session
        session_unset(); // Xóa tất cả các biến session
        session_destroy(); // Hủy bỏ phiên làm việc

        // Chuyển hướng về trang đăng nhập hoặc trang chính của ứng dụng
        header('Location: ' . _WEB_ROOT_ . ' /auth/login');
        exit();
    }
}
