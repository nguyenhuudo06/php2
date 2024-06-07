<?php

class UserModel extends Model
{

    protected $_table = 'users';

    function tableFill()
    {
        return 'users';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryKey()
    {
        return 'id';
    }

    function authenticateUser($email, $password)
    {
        // Chuẩn bị truy vấn SQL để lấy thông tin người dùng từ email
        $sql = "SELECT id, name, email, role, password FROM users WHERE email = :email";
        $params = [':email' => $email];
        $user = $this->db->query2($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

        // Nếu người dùng tồn tại và mật khẩu đúng
        if ($user && password_verify($password, $user[0]['password'])) {
            return $user[0];
        } else {
            echo 'Somthing Wrong';
        }
    }

    function store($email, $password)
    {
        // Mã hóa mật khẩu
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Chuẩn bị câu lệnh SQL để chèn người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $params = [':email' => $email, ':password' => $passwordHash];

        // Thực hiện câu lệnh SQL và bind tham số
        $result = $this->db->query2($sql, $params);

        // Kiểm tra kết quả của câu lệnh INSERT
        if ($result->rowCount() > 0) {
            // Nếu thành công, thực hiện xác thực người dùng
            return $this->authenticateUser($email, $password);
        } else {
            // Nếu không thành công, trả về false
            return false;
        }
    }
}
