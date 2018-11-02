<?php

define("CTL",'ctl');
define("ACT",'act');
define("API_ACCESS_LOG","/mnt/log/xcb_api_access.log");
define("APP_RUN_LOG","/mnt/log/xcb_app_run.log");

class ApiApp{		
	private $module_obj;
	#网站项目构造
	public function __construct(){
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data[CTL]))
		{
			$request_data[CTL] = "index";
		}
		if(!isset($request_data[ACT]))
		{	
			$request_data[ACT] = "index";
		}
		$access_log_msg = date("Y-m-d h:i:s ").json_encode($request_data)."\n";
		file_put_contents(API_ACCESS_LOG,$access_log_msg,FILE_APPEND);


		#定义不需要登录就能调用的接口
		$NONE_AUTHOR_API = array();
		$NONE_AUTHOR_API[] = "#";
		$NONE_AUTHOR_API[] = "index#index";
		$NONE_AUTHOR_API[] = "user#do_login";
		$NONE_AUTHOR_API[] = "user#index";
		$NONE_AUTHOR_API[] = "user#do_plogin";
		$NONE_AUTHOR_API[] = "user#do_wxlogin";
		$NONE_AUTHOR_API[] = "user#do_reset_pwd";
		$NONE_AUTHOR_API[] = "user#do_register";
		$NONE_AUTHOR_API[] = "order#get_deal_list";
		$NONE_AUTHOR_API[] = "trade#get_coin_price";
		$NONE_AUTHOR_API[] = "trade#get_kline";
		$NONE_AUTHOR_API[] = "test#test";
		#var_dump($_SERVER);
		#定义session
		if(isset($request_data['s_id']))
		{
			session_id($request_data['s_id']);
		}
		if(isset($request_data['client_ip']))
		{
			$client_ip = $request_data['client_ip'];
		}
		session_start();
		#var_dump($_SESSION);
		#var_dump($request_data);
		if(!isset($request_data['id']))
		{
			$request_data['id'] = -1;
		}
		if(isset($_SESSION['id']) && $request_data['id'] == $_SESSION['id'])
		{
			#已登录 刷新session 和 global user_info
			$sql = "select * from ".DB_PREFIX.'user where id="'.$_SESSION['id'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			#$_SESSION['user_name'] = $post_data['user_name'];
			$GLOBALS['user_info'] = $user_info;
			session_commit();
		}
		else
		{
			#未登录或登录过期
			session_commit();
			$request_api = $request_data[CTL]."#".$request_data[ACT];
			if(!in_array($request_api,$NONE_AUTHOR_API))
			{
				$msg = "您未登录或登录信息过期，请重新登录";
				$result = array("status" => false,"msg"=> $msg);
				echo json_encode($result);
				exit(0);
			}
		}


		$pre = '/api/';
		$pre_c = '/api/';
		
		
		$module = strtolower($request_data[CTL]?$request_data[CTL]:"index");
		$action = strtolower($request_data[ACT]?$request_data[ACT]:"index");
		
		
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
