<?php

if(!defined('ROOT_PATH')) {
        # 网站URL根目录
        $_root = dirname(__FILE__); 
        define('ROOT_PATH', $_root  );
}

#定义$_SERVER['REQUEST_URI']兼容性
if (!isset($_SERVER['REQUEST_URI']))
{
	if (isset($_SERVER['argv']))
	{
		$uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
	}
	else
	{
		$uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
	}
	$_SERVER['REQUEST_URI'] = $uri;
}

$post_data = $_POST;
$post_data1 = array();
foreach($post_data as $k=>$v)
{
    $post_data1[$k] = str_replace(PHP_EOL, '', $v);
}
$get_data = $_GET;
$get_data1 = array();
foreach($get_data as $k=>$v)
{
    $get_data1[$k] = str_replace(PHP_EOL, '', $v);
}
$request_data = array_merge($post_data1,$get_data1);



#require_once ROOT_PATH."/common/phpqrcode/phpqrcode.php";
require_once ROOT_PATH."/common/phpqrcode/qrlib.php";
#定义全局变量
require_once ROOT_PATH."/common/common.php";
require_once ROOT_PATH."/common/local_common.php";
global $request_data;

require_once ROOT_PATH."/common/db/mysql_cls.php";
$dbcfg = require ROOT_PATH."/conf/db_config.php";
define("DB_PREFIX",$dbcfg['DB_PREFIX']);
$pconnect = false;
global $db;
$db = new cls_mysql();
$db->connect($dbcfg['DB_HOST'],$dbcfg['DB_USER'],$dbcfg['DB_PWD'],$dbcfg['DB_NAME'],$dbcfg['DB_CHARACTER']);

#定义模板
require_once ROOT_PATH."/common/tmplibs/Smarty.class.php";
global $tmpl;
$tmpl = new Smarty();




?>
