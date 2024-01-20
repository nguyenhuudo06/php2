<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Account extends Controller
{

    public $model_account;
    public $data = [];

    function __construct()
    {
        $this->model_account = $this->model('AccountModel');
    }

    function login()
    {
        if (!empty($_SESSION['auth']['id'])) {
            header("Location: ../home");
            exit();
        }
        if (!empty($_POST)) {
            $dataLogin = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ];

            $userList = $this->model_account->getAccount();
            $hasAccount = false;
            foreach ($userList as $user) {
                if ($user['email'] = $_POST['email'] && password_verify($dataLogin['password'], $user['password'])) {
                    $hasAccount = true;
                    break;
                }
            }
            if ($hasAccount) {
                $this->model_account->getAuthId($dataLogin['email'])['id'];
                $_SESSION['auth']['id'] = $this->model_account->getAuthId($dataLogin['email'])['id'];
                header("Location: ../home");
                exit();
            } else {

                header("Location: ../account/login");
                exit();
            }
        } else {
            $title = 'Dang nhap';

            $this->data['sub_content']['title'] = $title;
            $this->data['content'] = 'login';

            $this->render($this->data['content'], $this->data);
        }
    }
    function register()
    {

        // echo '<pre>';
        // print_r($userAll);
        // echo '</pre>';

        if (!empty($_POST)) {
            $userCheck = $this->model_account->checkAvailable($_POST['email']);
            if ($userCheck) {
                $this->data['errors']['emailError'] = 'Email da ton tai';
                // Điều hướng về trang trước đó
                $title = 'Dang ky';
                $this->data['sub_content']['title'] = $title;
                $this->data['content'] = 'register';

                echo '<pre>';
                print_r($this->data);
                echo '</pre>';

                $this->render($this->data['content'], $this->data);
                exit();
            } else {
                $dataImport = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                ];

                $this->model_account->getRegister('users', $dataImport);

                $dataCodes = [
                    'user_id' => $this->model_account->lastInsertId(),
                    'activation_code' => bin2hex(random_bytes(20))
                ];

                var_dump($dataCodes);

                $this->model_account->inserst_activation_code('activation_codes', $dataCodes);

                header("Location: ../home");



                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 2;
                    $mail->isSMTP(); // Sử dụng SMTP để gửi mail
                    $mail->Host = 'smtp.gmail.com'; // Server SMTP của gmail
                    $mail->SMTPAuth = true; // Bật xác thực SMTP
                    $mail->Username = 'nguyenhuudo1206@gmail.com'; // Tài khoản email
                    $mail->Password = 'xvqylzsz hnjy kazq'; // Mật khẩu ứng dụng ở bước 1 hoặc mật khẩu email
                    $mail->SMTPSecure = 'ssl'; // Mã hóa SSL
                    $mail->Port = 465; // Cổng kết nối SMTP là 465

                    //Recipients
                    $mail->setFrom('nguyenhuudo1206@gmail.com', 'Nguyen Huu Do'); // Địa chỉ email và tên người gửi
                    $mail->addAddress('nguyenhuudo1206@gmail.com', 'Nguyen Huu Do'); // Địa chỉ mail và tên người nhận

                    //Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'Ma kich hoat tai khoan'; // Tiêu đề
                    $mail->Body = $dataCodes['activation_code']; // Nội dung

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
        } else {
            $title = 'Dang ky';
            $this->data['sub_content']['title'] = $title;
            $this->data['content'] = 'register';

            $this->render($this->data['content'], $this->data);
        }
    }
}
