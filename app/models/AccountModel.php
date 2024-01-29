<?php

class AccountModel extends Model
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

    function get_list()
    {
        $data = $this->db->query("SELECT * FROM users");
        return $data;
    }

    function get_token($table, $user_id)
    {
        $data = $this->db->query("SELECT * FROM $table WHERE user_id = $user_id")->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function create_user($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function inserst_remove_uplicate($table, $data)
    {
        $tokenArr = $this->db->query("SELECT * FROM $table");
        $this->db->query("DELETE FROM $table WHERE user_id = {$data['user_id']}");

        return $this->db->insert($table, $data);
    }

    function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    function find_email($email = '')
    {
        $data = $this->db->table('users')->where('email', '=', $email)->first();
        return $data;
    }

    function change_password($newPassword, $token)
    {
        $this->db->query("UPDATE users
                        SET password = '$newPassword'
                        WHERE id = (
                            SELECT user_id
                            FROM password_reset_tokens
                            WHERE token = '$token'
                            LIMIT 1
                        )");

        // echo("DELETE FROM password_reset_tokens WHERE token = '$token'");
        $this->db->query("DELETE FROM password_reset_tokens WHERE token = '$token'");
    }
}
