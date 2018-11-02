<?php
class userModule
{

	public function  index()
	{
		$GLOBALS['tmpl']->assign("contents","this is user index");
		$GLOBALS['tmpl']->assign("title","this is user title");
		$GLOBALS['tmpl']->display("index.html");
	}


	public function doregister()
	{
	
	}


	public function dologin()
	{
		$request_data = $GLOBALS['request_data'];
		$client_ip = getUserIP();
		
		//参数检查
		if(!isset($request_data['user_name']))
		{
			$msg = "请输入用户名";
			$status = false;
			$result = array('status'=> $status,'msg'=> $msg);
			echo json_encode($result);
			exit(0);
		}
		if(!isset($request_data['user_pwd']))
		{
			$msg = "请输入密码";
			$status = false;
			$result = array('status'=> $status,'msg'=> $msg);
			echo json_encode($result);
			exit(0);
		}

		if(isset($_SESSION['user_name']) && $_SESSION['user_name'] == $request_data['user_name'])
		{
			//登录成功
			$sql = "select * from ".DB_PREFIX.'user where user_name="'.$request_data['user_name'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			$GLOBAL['user_info'] = $user_info;
			$msg = "session登录成功！";
			$status = true;
			$result = array("status" => $status,'msg' => $msg,"user_info" => $user_info);
			echo json_encode($result);
			exit(0);
			
		}
		else
		{
			$sql = "select * from ".DB_PREFIX.'user where user_name="'.$request_data['user_name'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			if(isset($user_info['user_name']))
			{
				if($user_info['user_pwd'] == md5($request_data['user_pwd']))
				{
					$_SESSION['user_name'] = $request_data['user_name'];
					$_SESSION['client_ip'] = md5($client_ip);
					$GLOBALS['user_info'] = $user_info;
					$msg = "登录成功！";
					$status = true;
					$result = array("status" => $status,'msg' => $msg,"user_info" => $user_info);
					echo json_encode($result);
					exit(0);
				}
				else
				{
					$msg = "密码错误！";
					$status = false;
					$result = array("status" => $status,"msg" => $msg);
					echo json_encode($result);
					exit;
				}
			}
		}
		

	}	

	public function userinfo()
	{
		echo json_encode($GLOBALS['user_info']);
	}

	
	public function doplogin()
	{

	}	

	public function dowxlogin()
	{

	}	

	public function doqqlogin()
	{

	}	

	public function loginout()
	{
		//清除session
		$_SESSION = array();
		session_destroy();
		$msg = "退出成功！";
		$status = "ok";
		$result = array("status" => $status,"msg" => $msg); 
		echo json_encode($result);
		exit(0);
		
	}

	public function domodifypassword()
	{

	}

	public function updateUserInfo()
	{
			
	}		

}



?>
