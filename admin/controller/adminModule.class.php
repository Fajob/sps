<?php
class adminModule
{

	/*
	**展示管理后台登陆页面
	*/
	public function  index()
	{
		$GLOBALS['tmpl']->display("login/login.html");

	}


	/*
	**登陆接口
	*/

	public function do_login()
	{
		$request_data = $GLOBALS['request_data'];
		$client_ip = getUserIP();
		
		#参数检查
		if(!isset($request_data['m_user_name']))
		{
			$msg = "请输入用户名";
			$status = 0;
			$result = array('status'=> $status,'msg'=> $msg);
			echo json_encode($result);
			exit(0);
		}
		if(!isset($request_data['user_pwd']))
		{
			$msg = "请输入密码";
			$status = 0;
			$result = array('status'=> $status,'msg'=> $msg);
			echo json_encode($result);
			exit(0);
		}


		$sql = "select * from ".DB_PREFIX.'admin_user where user_name="'.$request_data['m_user_name'].'"';
		$user_info = $GLOBALS['db']->getRow($sql);
		if(isset($user_info['user_name']))
		{
			if($user_info['user_pwd'] == md5($request_data['user_pwd']))
			{
				$_SESSION['m_user_name'] = $request_data['m_user_name'];
				$_SESSION['client_ip'] = md5($client_ip);
				session_commit();
				$GLOBALS['user_info'] = $user_info;
				$msg = "登录成功！";
				$status = true;
				$result = array("status" => $status,'msg' => $msg,"user_info" => $user_info);
				echo json_encode($result);

				$func = "do_login";
				$msg = array();
				$msg[] = $request_data['m_user_name']."登录成功！";
				$msg = json_encode($msg);
				save_log($func,$msg);
				exit(0);
			}
			else
			{
				$msg = "密码错误！";
				$status = false;
				$result = array("status" => $status,"msg" => $msg);
				echo json_encode($result);
				exit(0);
			}
		}
		else
		{
			$msg = "账户不存在！";
			$status = false;
			$result = array("status" => $status,"msg" => $msg);
			echo json_encode($result);
			exit(0);

		}


	}	

	public function userinfo()
	{
		echo json_encode($GLOBALS['user_info']);
	}

	
	/*
	**注销后展示登陆页面
	*/

	public function do_loginout()
	{
		#清除session
		$_SESSION = array();
		session_destroy();
		$msg = "退出成功！";
		$result = array("status" => true,"msg" => $msg); 
		echo json_encode($result);
		exit(0);
		
	}

	public function domodifypassword()
	{

	}

	


}



?>
