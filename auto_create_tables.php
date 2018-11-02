<?php
if(!defined('ROOT_PATH')) {
        // 网站URL根目录
        $_root = dirname(__FILE__); 
        define('ROOT_PATH', $_root  );
}
require_once ROOT_PATH.'/common/global_init.php';
require_once ROOT_PATH.'/api/MainApp.class.php';
require_once "./common/global_init.php";
$sql = "select * from ".DB_PREFIX."user where id=95";
var_dump($GLOBALS['db']->getAll($sql));




?>
