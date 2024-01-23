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
        $request = new Request();
        $response = new Response();

        if ($request->isPost()) {
            // Set rules
            $request->rules([
                'email' => 'required',
                'password' => 'required',
            ]);

            // Set message 
            $request->message([
                'email.required' => 'Name is required',
                'password.required' => 'Email is required',
            ]);

            $validate = $request->validate();
            if (!$validate) {
                $this->data['errors'] = $request->errors();
                $this->data['msg'] = "Error";
                $this->data['old'] = $request->getFields();
                $this->data['sub_content']['title'] = 'Login';
                $this->data['content'] = 'login';

                $this->render($this->data['content'], $this->data);
                exit();
            } else {
                $dataAccount = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                ];

                $userArr = $this->model_account->get_list()->fetchAll(PDO::FETCH_ASSOC);

                $checkUser = false;
                foreach($userArr as $userItem){
                    if($userItem['email'] == $dataAccount['email'] && password_verify($dataAccount['password'], $userItem['password'])){
                        echo 'Right';
                        $checkUser = true;
                        break;
                    }
                }
                if($checkUser){
                    
                    $response->redirect('home');
                }
            }

        }else{
            $this->data['sub_content']['title'] = 'Login';
            $this->data['content'] = 'login';
    
            $this->render($this->data['content'], $this->data);
        }

    }

    function register()
    {
        $request = new Request();
        $response = new Response();

        if ($request->isPost()) {
            // Set rules
            $request->rules([
                'name' => 'required|min:8|max:50',
                'email' => 'required|email|min:8',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|match:password',
            ]);

            // Set message 
            $request->message([
                'name.required' => 'Name is required',
                'name.min' => 'Name must be greater than 8 characters',
                'name.max' => 'Name must be less than 50 characters',
                'email.required' => 'Name must be less than 50 characters',
                'email.email' => 'Name must be less than 50 characters',
                'email.min' => 'Name must be greater than 8 characters',
                'password.required' => 'Name must be less than 50 characters',
                'password.min' => 'Name must be greater than 8 characters',
                'confirm_password.required' => 'Name must be less than 50 characters',
                'confirm_password.min' => 'Name must be greater than 8 characters',
                'confirm_password.match' => 'Password does not match',
            ]);

            $validate = $request->validate();
            if (!$validate) {
                $this->data['errors'] = $request->errors();
                $this->data['msg'] = "Error";
                $this->data['old'] = $request->getFields();
                $this->data['sub_content']['title'] = 'Register';
                $this->data['content'] = 'register';

                $this->render($this->data['content'], $this->data);
                exit();
            } else {
                $dataUser = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ];

                $this->model_account->create_user('users', $dataUser);

                $dataActiveToken = [
                    'user_id' => $this->model_account->lastInsertId(),
                    'token' => bin2hex(random_bytes(50)),
                ];

                // $this->model_account->inserst_activation_code('user_activate_token', $dataActiveToken);

                $response->redirect('account/login');
            }
        } else {
            $this->data['sub_content']['title'] = 'Register';
            $this->data['content'] = 'register';

            $this->render($this->data['content'], $this->data);
        }


        // echo '<pre>';
        // print_r($request->__errors['name']);
        // echo '</pre>';

        // $mail = new PHPMailer(true);
        // try {
        //     //Server settings
        //     $mail->SMTPDebug = 2;
        //     $mail->isSMTP(); // Sử dụng SMTP để gửi mail
        //     $mail->Host = 'smtp.gmail.com'; // Server SMTP của gmail
        //     $mail->SMTPAuth = true; // Bật xác thực SMTP
        //     $mail->Username = 'nguyenhuudo1206@gmail.com'; // Tài khoản email
        //     $mail->Password = 'xvqylzsz hnjy kazq'; // Mật khẩu ứng dụng ở bước 1 hoặc mật khẩu email
        //     $mail->SMTPSecure = 'ssl'; // Mã hóa SSL
        //     $mail->Port = 465; // Cổng kết nối SMTP là 465

        //     //Recipients
        //     $mail->setFrom('nguyenhuudo1206@gmail.com', 'Nguyen Huu Do'); // Địa chỉ email và tên người gửi
        //     $mail->addAddress('nguyenhuudo1206@gmail.com', 'Nguyen Huu Do'); // Địa chỉ mail và tên người nhận

        //     //Content
        //     $mail->isHTML(true); // Set email format to HTML
        //     $mail->Subject = 'Ma kich hoat tai khoan'; // Tiêu đề
        //     $mail->Body = $dataCodes['activation_code']; // Nội dung

        //     $mail->send();
        //     echo 'Message has been sent';
        // } catch (Exception $e) {
        //     echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        // }
    }
}
