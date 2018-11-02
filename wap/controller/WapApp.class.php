<?php
if(!defined("CTL") || !defined("ACT"))
{
	define("CTL",'ctl');
	define("ACT",'act');
}

class WapApp{		
	private $module_obj;
	#网站项目构造
	public function __construct(){
		if(!isset($_REQUEST[CTL]))
		{
			$_REQUEST[CTL] = "index";
		}
		if(!isset($_REQUEST[ACT]))
		{	
			$_REQUEST[ACT] = "index";
		}
		$request_data = $GLOBALS['request_data'];

		#定义不需要登录就能调用的接口
		$NONE_AUTHOR_API = array();
		$NONE_AUTHOR_API[] = "#";
		$NONE_AUTHOR_API[] = "user#do_login";
		$NONE_AUTHOR_API[] = "user#index";
		$NONE_AUTHOR_API[] = "user#register";
		$NONE_AUTHOR_API[] = "user#do_register";
		$NONE_AUTHOR_API[] = "user#forgetpwd";
		$NONE_AUTHOR_API[] = "user#do_reset_pwd";
		$NONE_AUTHOR_API[] = "user#about";
		$NONE_AUTHOR_API[] = "index#index";
		#定义session
		session_start();
		$session_id = session_id();
		$client_ip = getUserIP();
		$GLOBALS['request_data']['s_id'] = $session_id;
		$GLOBALS['request_data']['client_ip'] = $client_ip;
		session_commit();
		if(isset($_SESSION['id']))
		{
			#已登录 刷新session 和 global user_info
			$sql = "select * from ".DB_PREFIX.'user where id="'.$_SESSION['id'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			#$_SESSION['user_name'] = $post_data['user_name'];
			$GLOBALS['user_info'] = $user_info;
			$GLOBALS['request_data']['id'] = $_SESSION['id'];
		}
		else
		{
			#未登录或登录过期
			$request_api = $_REQUEST[CTL]."#".$_REQUEST[ACT];
			if(!in_array($request_api,$NONE_AUTHOR_API))
			{
				$msg = "您未登录或登录信息过期，请重新登录!!";
				$result = array("status" => false,"msg"=> $msg);
				echo json_encode($result);
				exit(0);
			}
		}


		$pre_c = '/wap/controller/';
		$pre = "/wap/";

		$GLOBALS['tmpl']->template_dir = ROOT_PATH.$pre."view/";
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
