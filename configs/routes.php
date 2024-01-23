<?php

$routes['default_controller'] = 'home';

// Slug
$routes['san-pham'] = 'product/index';
$routes['trang-chu'] = 'home/index';
// $routes['login'] = 'account/get_login';
// $routes['register'] = 'account/get_register';
$routes['tin-tuc/.+-(\d+).html'] = 'news/categories/$1';