<?php

if(!defined('ROOT_PATH')) {
	// 网站URL根目录
	$_root = dirname(__FILE__); 
	define('ROOT_PATH', $_root  );
}
require_once ROOT_PATH.'/common/global_init.php';
require_once ROOT_PATH.'/common/MainApp.class.php';
require_once "./common/verify/es_image.php";
session_start();
es_image::buildImageVerify(4,1);



?>
