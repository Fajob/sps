<?php

define("CTL",'ctl');
define("ACT",'act');
define("ERROR_LOG_PATH","/mnt/log/xcb_error.log");
define("ADMIN_ACCESS_LOG","/mnt/log/xcb_admin_access.log");

class AdminApp{		
	private $module_obj;
	#网站项目构造
	public function __construct(){
		if(!isset($_REQUEST[CTL]))
		{
			$_REQUEST[CTL] = "admin";
		}
		if(!isset($_REQUEST[ACT]))
		{	
			$_REQUEST[ACT] = "index";
		}
		$access_log_msg = date("Y-m-d h:i:s ").json_encode($_REQUEST)."\n";
		file_put_contents(ADMIN_ACCESS_LOG,$access_log_msg,FILE_APPEND);


		#定义不需要登录就能调用的接口
		$NONE_AUTHOR_API = array();
		$NONE_AUTHOR_API[] = "admin#do_login";
		$NONE_AUTHOR_API[] = "admin#";
		$NONE_AUTHOR_API[] = "admin#index";
		$NONE_AUTHOR_API[] = "index#index";
		$NONE_AUTHOR_API[] = "image#deal_image";
		#定义session
		session_start();
		if(isset($_SESSION['m_user_name'])  && isset($_SESSION['client_ip']) && $_SESSION['client_ip'] == md5(getUserIP()))
		{
			#已登录 刷新session 和 global user_info
			$sql = "select * from ".DB_PREFIX.'admin_user where user_name="'.$_SESSION['m_user_name'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			$GLOBALS['m_user_info'] = $user_info;
		}
		else
		{
			#未登录或登录过期
			$request_api = $_REQUEST[CTL]."#".$_REQUEST[ACT];
			if(!in_array($request_api,$NONE_AUTHOR_API))
			{
				#$msg = "未登录或登录信息过期，请重新登录";
				#$result = array("status" => false,"msg"=> $msg);
				#echo json_encode($result);
				header("location:http://xcb.quanx.cc/m.php");
				exit(0);
			}
		}


		$pre_c = '/admin/controller/';
		$pre = "/admin/";

		$GLOBALS['tmpl']->template_dir = ROOT_PATH.$pre."view/";
		#print_r($GLOBALS['tmpl']->getTemplateDir()); 
		#$GLOBALS['tmpl']->complie_dir = ROOT_PATH."/templates_c/";

		$GLOBALS['tmpl']->config_dir = ROOT_PATH."/configs";
		$GLOBALS['tmpl']->cache_dir = ROOT_PATH."/cache";
		$GLOBALS['tmpl']->left_delimiter = '{%';
		$GLOBALS['tmpl']->right_delimiter = '%}';
		
		
		$module = strtolower($_REQUEST[CTL]?$_REQUEST[CTL]:"index");
		$action = strtolower($_REQUEST[ACT]?$_REQUEST[ACT]:"index");
		
		
		if(!file_exists(ROOT_PATH.$pre_c.$module."Module.class.php"))
		$module = "index";
		
		require_once(ROOT_PATH.$pre_c.$module."Module.class.php");				
		if(!class_exists($module."Module"))
		{
			$module = "index";
			require_once(ROOT_PATH.$pre_c.$module."Module.class.php");	
		}
		if(!method_exists($module."Module",$action))
		$action = "index";
		
		define("MODULE_NAME",$module);
		define("ACTION_NAME",$action);
		
		

		
		$module_name = $module."Module";
		$this->module_obj = new $module_name;
		$this->module_obj->$action();
	}
	
	public function __destruct()
	{
		unset($this);
	}
}
?>
