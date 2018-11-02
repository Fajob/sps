<?php

define("CTL",'ctl');
define("ACT",'act');

class MainApp{		
	private $module_obj;
	//网站项目构造
	public function __construct(){
		if(!isset($_REQUEST[CTL]))
		{
			$_REQUEST[CTL] = "index";
		}
		if(!isset($_REQUEST[ACT]))
		{	
			$_REQUEST[ACT] = "index";
		}


		//定义不需要登录就能调用的接口
		$NONE_AUTHOR_API = array();
		$NONE_AUTHOR_API[] = "#";
		$NONE_AUTHOR_API[] = "index#index";
		$NONE_AUTHOR_API[] = "user#dologin";
		$NONE_AUTHOR_API[] = "user#index";
		$NONE_AUTHOR_API[] = "user#doplogin";
		$NONE_AUTHOR_API[] = "user#dowxlogin";
		$NONE_AUTHOR_API[] = "user#doqqlogin";
		$NONE_AUTHOR_API[] = "user#doregister";
		//定义session
		session_start();
		if(isset($_SESSION['user_name']) && $_SESSION['user_name'] == $post_data['user_name'] && isset($_SESSION['client_ip']) && $_SESSION['client_ip'] == md5(getUserIP()))
		{
			//已登录 刷新session 和 global user_info
			$sql = "select * from ".DB_PREFIX.'user where user_name="'.$post_data['user_name'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			$_SESSION['user_name'] = $post_data['user_name'];
			$GLOBALS['user_info'] = $user_info;
		}
		else
		{
			//未登录或登录过期
			$request_api = $_REQUEST[CTL]."#".$_REQUEST[ACT];
			if(!in_array($request_api,$NONE_AUTHOR_API))
			{
				$msg = "您未登录或登录信息过期，请重新登录";
				$result = array("status" => false,"msg"=> $msg);
				echo json_encode($result);
				exit(0);
			}
		}


		$path = $_SERVER['PHP_SELF'];
		$path_var = explode('/',$path);
		if(count($path_var) >2)
		{
			$num = count($path_var);
			$pre = '/';
			for($i=1;$i<$num-1;$i++)
				$pre = $pre.$path_var[$i]."/";
			$pre_c = $pre;
		}
		else
		{
			$pre = '/web/';
			$pre_c = '/web/controller/';
		}

		$GLOBALS['tmpl']->template_dir = ROOT_PATH.$pre."view/";
		//$GLOBALS['tmpl']->complie_dir = ROOT_PATH."/templates_c/";

		$GLOBALS['tmpl']->config_dir = ROOT_PATH."/configs";
		$GLOBALS['tmpl']->cache_dir = ROOT_PATH."/cache";
		//$GLOBALS['tmpl']->left_delimiter = @#<{@#; 
		//$GLOBALS['tmpl']->right_delimiter = @#}>@#;
		
		
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
