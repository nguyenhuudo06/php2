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

                foreach ($userArr as $userItem) {
                    if ($userItem['email'] == $dataAccount['email'] && password_verify($dataAccount['password'], $userItem['password'])) {
                        $_SESSION['auth'] = $userItem['id'];
                        $response->redirect('home');
                        break;
                    }
                }
            }
        } else {
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

                // $this->model_account->inserst('user_activate_tokens', $dataActiveToken);

                $response->redirect('account/login');
            }
        } else {
            $this->data['sub_content']['title'] = 'Register';
            $this->data['content'] = 'register';

            $this->render($this->data['content'], $this->data);
        }

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

    function change_password()
    {
        $request = new Request();
        $response = new Response();

        if ($request->isPost()) {
            // Set rules
            $request->rules([
                'email' => 'required|email|min:8',
                'password' => 'required|min:8',
                'confirm_password' => 'required|min:8|match:password',
                'token' => 'required',
            ]);

            // Set message 
            $request->message([
                'email.required' => 'Name must be less than 50 characters',
                'email.email' => 'Name must be less than 50 characters',
                'email.min' => 'Name must be greater than 8 characters',
                'password.required' => 'Name must be less than 50 characters',
                'password.min' => 'Name must be greater than 8 characters',
                'confirm_password.required' => 'Name must be less than 50 characters',
                'confirm_password.min' => 'Name must be greater than 8 characters',
                'confirm_password.match' => 'Password does not match',
                'token.required' => 'Password is required',
            ]);

            $validate = $request->validate();
            if (!$validate) {
                $this->data['errors'] = $request->errors();
                $this->data['msg'] = "Error";
                $this->data['old'] = $request->getFields();
                $this->data['sub_content']['title'] = 'Change password';
                $this->data['content'] = 'change_password';

                $this->render($this->data['content'], $this->data);
                exit();
            } else {
                $dataUser = [
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'token' => $_POST['token'],
                ];

                $this->model_account->change_password($dataUser['password'], $dataUser['token']);

                $response->redirect('account/login');
            }
        } else {
            $this->data['sub_content']['title'] = 'Change password';
            $this->data['content'] = 'change_password';

            $this->render($this->data['content'], $this->data);
        }
    }

    function logout()
    {
        // Hủy bỏ session để đăng xuất
        session_unset();
        session_destroy();

        $response = new Response();
        $response->redirect('account/login');
        exit();
    }

    function forget()
    {
        $request = new Request();
        $response = new Response();

        if ($request->isPost()) {
            // Set rules
            $request->rules([
                'email' => 'required',
            ]);

            // Set message 
            $request->message([
                'email.required' => 'Email is required',
            ]);

            $validate = $request->validate();
            if (!$validate) {
                $this->data['errors'] = $request->errors();
                $this->data['msg'] = "Error";
                $this->data['old'] = $request->getFields();
                $this->data['sub_content']['title'] = 'Forget';
                $this->data['content'] = 'forget';

                $this->render($this->data['content'], $this->data);
                exit();
            } else {
                $dataFoget = [
                    'email' => trim($_POST['email']),
                ];

                $data = $this->model_account->find_email($dataFoget['email']);

                if ($data) {
                    $dataFogetToken = [
                        'user_id' => $data['id'],
                        'token' => bin2hex(random_bytes(50)),
                    ];

                    $this->model_account->inserst_remove_uplicate('password_reset_tokens', $dataFogetToken);
                    $result = $this->model_account->get_token('password_reset_tokens', $dataFogetToken['user_id']);

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
                        $mail->addAddress($data['email'], $data['name']); // Địa chỉ mail và tên người nhận

                        //Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Ma thay doi mat khau'; // Tiêu đề
                        $mail->Body = 'Code: ' . $result['token']; // Nội dung

                        // Ẩn debug log
                        $mail->SMTPDebug = 0; // 0: Tắt debug, 2: Hiển thị toàn bộ debug thông tin
                        // $mail->send();

                        $response->redirect('account/change_password');
                    } catch (Exception $e) {
                        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                    }
                } else {
                    $this->data['errors']['email'] = 'Not found!';
                    $this->data['msg'] = "Error";
                    $this->data['old'] = $request->getFields();
                    $this->data['sub_content']['title'] = 'Forget';
                    $this->data['content'] = 'forget';

                    $this->render($this->data['content'], $this->data);
                    exit();
                }
            }
        } else {
            $this->data['sub_content']['title'] = 'Forget';
            $this->data['content'] = 'forget';

            $this->render($this->data['content'], $this->data);
        }
    }
}
