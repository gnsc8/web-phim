<?php session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

//1. Khai báo các đường dẫn:
define('base_url','/web-phim');
define('app_path', __DIR__);
define('view_path', app_path .'/views');
define('layout_path', app_path .'/views/layout');
define('controller_path', app_path.'/controllers');
define('model_path',app_path.'/models');
define('public_path',base_url.'/publics');
define('frontend_path',view_path.'/index');
define('video_path',base_url.'/video');
define('thong_tin_phim_path',base_url.'/thong-tin-phim');





// nhúng file ứng dụng vào và chạy MVC

require_once 'core/autoload.php';
require_once 'function.php';

$mvc = new MyMVC();
$mvc->run();