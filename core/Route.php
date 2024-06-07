<?php

class Route {

    function handleRoute($url)
    {
        global $routes;

        unset($routes['default_controller']);

        // Loại bỏ dấu '/' ở đầu và cuối URL
        $url = trim($url, '/');
        if(empty($url)){
            $url = '/';
        }

        $handleUrl = $url;
        if(!empty($routes)){
            foreach($routes as $key => $value){
                // Kiểm tra xem URL khớp với mẫu định tuyến nào
                if(preg_match('~' . $key . '~is', $url)){
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url); // Thay $value vào $url -> gán vào $handleUrl
                }
            }
        }

        return $handleUrl;
    }
}