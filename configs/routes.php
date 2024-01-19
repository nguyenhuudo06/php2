<?php

$routes['default_controller'] = 'home';

// Slug
$routes['san-pham'] = 'product/index';
$routes['trang-chu'] = 'home/index';
$routes['tin-tuc/.+-(\d+).html'] = 'news/categories/$1';