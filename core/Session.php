<?php

class Session
{

    // data(key, value) => Set session
    // data(key)        => Get session
    static public function data($key = '', $value = '')
    {
        $sessionKey = self::isInvalid();

        if(!empty($value)){
            if(!empty($key)){
                $_SESSION[$sessionKey][$key] = $value; // Set session
                return true;
            }
            return false;
        }else{
            if(empty($key)){
                if(isset(($_SESSION[$sessionKey]))){
                    return $_SESSION[$sessionKey];     // Get session all
                }
            }
            if(isset($_SESSION[$sessionKey][$key])){
                return $_SESSION[$sessionKey][$key];  // Get session
            }
        }
    }

    // delete(key) => Xóa session với key
    // delete()    => Xóa hết session
    static public function delete($key=''){
        $sessionKey = self::isInvalid();
        if(!empty($key)){
            if(isset($_SESSION[$sessionKey][$key])){
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
            return false;
        }else{
            unset($_SESSION[$sessionKey]);
            return true;
        }
        return false;
    }

    // Flash data
    // - set flash data => giống như set session
    // - get flash data => giống như get session, xóa luôn sesion sau khi get
    static public function flash($key = '', $value = ''){
        $dataFlash = self::data($key, $value);
        if(empty($value)){
            self::delete($key);
        }
        return $dataFlash;
    }

    static public function showErrors($message)
    {
        $data = ['message' => $message];
        App::$app->loadError('exception', $data);
        die();
    }

    static public function isInvalid()
    {
        global $configs;
        if (!empty($configs['session'])) {
            $sessionConfig = $configs['session'];
            if (!empty($sessionConfig['session_key'])) {
                $sesionKey = $sessionConfig['session_key'];
                return $sesionKey;
            } else {
                self::showErrors('Thieu cau session, Vui long kiem tra file configs/session.php');
            }
        } else {
            self::showErrors('Thieu cau session, Vui long kiem tra file configs/session.php');
        }
    }
}
