<?php
if(!defined('ROOT_PATH')) {
        # 网站URL根目录
        $_root = $_SERVER['DOCUMENT_ROOT']; 
        define('ROOT_PATH', $_root  );
}
require_once ROOT_PATH.'/common/global_init.php';
require_once ROOT_PATH.'/api/ApiApp.class.php';
require_once ROOT_PATH.'/api/api_common.php';
#实例化一个网站应用实例
$ApiApp= new ApiApp();


?>
