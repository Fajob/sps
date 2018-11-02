<?php
if(!defined('ROOT_PATH')) {
        # 网站URL根目录
        $_root = dirname(__FILE__); 
        define('ROOT_PATH', $_root  );
}
require_once ROOT_PATH.'/common/global_init.php';
require_once ROOT_PATH.'/web/controller/MainApp.class.php';
require_once ROOT_PATH.'/wap/controller/WapApp.class.php';
require_once ROOT_PATH.'/api/api_common.php';
#实例化一个网站应用实例
$AppWeb = new WapApp();


?>
