<?php
if(!defined('ROOT_PATH')) {
        # 网站URL根目录
        $_root = dirname(__FILE__); 
        define('ROOT_PATH', $_root  );
}
require_once ROOT_PATH.'/common/global_init.php';
require_once ROOT_PATH.'/admin/controller/AdminApp.class.php';
#实例化一个网站应用实例
$AppWeb = new AdminApp();


?>
