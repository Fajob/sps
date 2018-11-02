<?php
class userModule
{
	public function do_register()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['phone_number']) || !isset($request_data['user_pwd']) || !isset($request_data['user_pwd_trade']) || !isset($request_data['code']) || !isset($request_data['invite_code']))
		{
			$result = array("status" => false,"msg" => "参数有误");
			echo json_encode($result);
		}
		$phone_number = $request_data['phone_number'];
		$user_pwd = $request_data['user_pwd'];
		$user_pwd_trade = $request_data['user_pwd_trade'];
		$code = $request_data['code'];
		$invite_code = $request_data['invite_code'];
		
		if($user_pwd_trade == $user_pwd)
		{
			$result = array("status" => false,"msg" => "交易密码和登录密码不能相同！");
			echo json_encode($result);
			exit(0);
		}

		if(!(isset($_SESSION['code']) && $_SESSION['code'] == $code))
		{
			$result = array("status" => false,"msg" => "验证码错误！");
			echo json_encode($result);
			exit(0);
		}
		#unset($_SESSION['code']);

		#查询邀请码是否有效
		$sql = "select * from ".DB_PREFIX."user where invite_code=".$invite_code;
		$invite_user_detail = $GLOBALS['db']->getRow($sql);
		if(isset($invite_user_detail['id']))
		{
			$p_id = $invite_user_detail['id'];
		}
		else
		{
			$result = array("status" => false,"msg" => "邀请码错误！");
			echo json_encode($result);
			exit(0);
		}

		#生成邀请码
		$invite_code = "1".substr($phone_number,-7);
		while(1)
		{
			$sql = "select count(*) from ".DB_PREFIX."user where invite_code=".$invite_code;
			$code_var = $GLOBALS['db']->getRow($sql);
			if($code_var['count(*)']>0)
			{
				$invite_code = intval($invite_code)+1;
			}
			else
			{
				break;
			}
		}
		$url = "http://xcb.quanx.cc/index.php?ctl=user&act=register&code=".$invite_code;
		$errorCorrectionLevel = "L";
		$matrixPointSize = "4";
		$title = md5($invite_code);
		$file_name = "/mnt/test/".$title.".png";
		$file = QRcode::png($url, $file_name, $errorCorrectionLevel, $matrixPointSize, 2);
		$qr_url = "public/qr/".$title.".png";




		$sql = "select  count(*) from  ".DB_PREFIX."user where phone_number=".$phone_number;
		$count_var = $GLOBALS['db']->getRow($sql);
		$count  = $count_var['count(*)'];
		if($count > 0)
		{
			$result = array("status" => false,"msg" => "手机号已注册！");
			echo json_encode($result);
			exit(0);
			
		}
		$user_pwd = md5($user_pwd);
		$user_pwd_trade = md5($user_pwd_trade);
		$sql = "insert into ".DB_PREFIX."user(phone_number,user_pwd,user_pwd_trade,p_id,invite_code,qr_url) values(".'"'.$phone_number.'","'.$user_pwd.'","'.$user_pwd_trade.'",'.$p_id.',"'.$invite_code.'","'.$qr_url.'")';
		$sql1 = "insert into ".DB_PREFIX."direct_user(phone_number,d_phone_number,time) values(".$invite_user_detail['phone_number'].',"'.$phone_number.'",'.time().')';
		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");#或者mysql_query("START TRANSACTION");   
		$res = mysql_query($sql);
		$res1 = mysql_query($sql1);
		if($res && $res1)
		{
			mysql_query("COMMIT");
			$result = array("status" => true,"msg" => "注册成功！");
			echo json_encode($result);
		}
		else
		{
			mysql_query("ROLLBACK");
			$result = array("status" => false,"msg" => "注册失败！");
			echo json_encode($result);
		}
		mysql_query("END");
		exit(0);
	}


	public function do_login()
	{
		$request_data = $GLOBALS['request_data'];
		$client_ip = getUserIP();
		#参数检查
		if(!isset($request_data['phone_number']) || $request_data['phone_number'] == '')
		{
			$msg = "请输入手机号";
			$status = false;
			$result = array('status'=> $status,'msg'=> $msg);
			echo json_encode($result);
			exit(0);
		}
		if(!isset($request_data['user_pwd']) || $request_data['user_pwd'] == '')
		{
			$msg = "请输入密码";
			$status = false;
			$result = array('status'=> $status,'msg'=> $msg);
			echo json_encode($result);
			exit(0);
		}
		if(!isset($request_data['verify']) || $request_data['verify'] == '')
		{
		#	$msg = "请输入验证码";
		#	$status = false;
		#	$result = array('status'=> $status,'msg'=> $msg);
		#	echo json_encode($result);
		#	exit(0);
		}
		else
		{
			if($_SESSION['verify'] != $request_data['verify'])
			{
				$msg = "验证码错误";
				$status = false;
				$result = array('status'=> $status,'msg'=> $msg);
				echo json_encode($result);
				exit(0);
			}
		}
		session_start();
		$_SESSION['verify'] = '';
		session_commit();


		$sql = "select * from ".DB_PREFIX.'user where phone_number="'.$request_data['phone_number'].'"';
		$user_info = $GLOBALS['db']->getRow($sql);
		if(isset($user_info['phone_number']))
		{
			if($user_info['user_pwd'] == md5($request_data['user_pwd']))
			{
				session_start();
				$_SESSION['phone_number'] = $request_data['phone_number'];
				$_SESSION['client_ip'] = md5($client_ip);
				$_SESSION['id'] = $user_info['id'];
				session_commit();
				#var_dump($_SESSION);
				$GLOBALS['user_info'] = $user_info;
				$msg = "登录成功！";
				$status = true;
				$result = array("status" => $status,'msg' => $msg,"user_info" => $user_info,"s_id"=>session_id());
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
		else
		{
			$msg = "账户不存在！";
			$status = false;
			$result = array("status" => $status,"msg" => $msg);
			echo json_encode($result);
			exit;
		}
	}	

	public function get_user_info()
	{
		echo json_encode($GLOBALS['user_info']);
	}

	
	public function do_plogin()
	{
		$request_data = $GLOBALS['request_data'];
		$phone_num = $request_data['phone_num'];
		$code = $request_data['code'];
		if(!isset($_SESSION['code']))
		{
			$result = array("status" => false,"msg"=> "登陆失败！");
			echo json_encode($result);
			exit(0);
		}
		if($_SESSION['code'] != $code)
		{
			$result = array("status" => false,"msg"=> "登陆失败！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$sql = "select * from ".DB_PREFIX.'user where phone_number="'.$request_data['phone_number'].'"';
			$user_info = $GLOBALS['db']->getRow($sql);
			if(isset($user_info['user_name']))
			{
				$_SESSION['user_name'] = $user_info['user_name'];
				$_SESSION['client_ip'] = md5($client_ip);
				$result = array("status" => true,"msg"=> "登陆成功！");
				echo json_encode($result);
				exit(0);
			}
			else
			{
				$result = array("status" => false,"msg"=> "该手机号还未注册！");
				echo json_encode($result);
				exit(0);
				
			}
			
		}

	}	


	public function do_loginout()
	{
		#清除session
		session_start(); 
		$_SESSION = array();
		session_destroy();
		$msg = "退出成功！";
		$status = "ok";
		$result = array("status" => true,"msg" => $msg); 
		echo json_encode($result);
		exit(0);
	}

	public function do_modify_pwd()
	{
		$request_data = $GLOBALS['request_data'];	
		if(!isset($request_data['old_pwd']) || !isset($request_data['new_pwd']) || !isset($request_data['new_pwd_confirm']) || !isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$old_pwd = $request_data['old_pwd'];
		$new_pwd = $request_data['new_pwd'];
		$new_pwd_confirm = $request_data['new_pwd_confirm'];

		if($new_pwd_confirm != $new_pwd)
		{
			$result = array("status" => false,"msg" => "两次输入的新密码不一致");
			echo json_encode($result);
			exit(0);
		}

		$user_info = $GLOBALS['user_info'];
		$old_pwd_1 = $user_info['user_pwd'];
		if(md5($old_pwd) != $old_pwd_1)
		{
			$result = array("status" => false,"msg" => "原密码错误");
			echo json_encode($result);
			exit(0);
		}
		if($new_pwd == $old_pwd)
		{
			$result = array("status" => false,"msg" => "新密码不能和原密码一样");
			echo json_encode($result);
			exit(0);
		}

		$user_pwd = md5($new_pwd);
		$sql = "update ".DB_PREFIX."user set user_pwd=".'"'.$user_pwd.'" where id='.$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "修改成功");
			#echo json_encode($result);
			$this->do_loginout();
			exit(0);
			
		}
		else
		{
			$result = array("status" => false,"msg" => "修改失败");
			echo json_encode($result);
			exit(0);
		
		}
				

	}

	public function do_modify_pwd_trade()
	{
		$request_data = $GLOBALS['request_data'];	
		if(!isset($request_data['code']) || !isset($request_data['new_pwd_trade']) || !isset($request_data['new_pwd_trade_confirm']) || !isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$new_pwd_trade = $request_data['new_pwd_trade'];
		$new_pwd_trade_confirm = $request_data['new_pwd_trade_confirm'];
		$code = $request_data['code'];
	
		if(!(isset($_SESSION['code']) && $_SESSION['code'] == $code))
		{
			$result = array("status" => false,"msg" => "验证码错误");
			echo json_encode($result);
			exit(0);
		}
		#unset($_SESSION['code']);


		if($new_pwd_trade_confirm != $new_pwd_trade)
		{
			$result = array("status" => false,"msg" => "两次输入的新密码不一致");
			echo json_encode($result);
			exit(0);
		}

		$user_info = $GLOBALS['user_info'];
		$old_pwd_trade_1 = $user_info['user_pwd_trade'];
		if(md5($new_pwd_trade) == $old_pwd_trade_1)
		{
			$result = array("status" => false,"msg" => "新密码不能和原密码相同");
			echo json_encode($result);
			exit(0);
		}
		$user_pwd_trade = md5($new_pwd_trade);
		$sql = "update ".DB_PREFIX."user set user_pwd_trade=".'"'.$user_pwd_trade.'" where id='.$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "修改成功");
			echo json_encode($result);
			exit(0);
			
		}
		else
		{
			$result = array("status" => false,"msg" => "修改失败");
			echo json_encode($result);
			exit(0);
		}
	}


	public function do_modify_user_name()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['new_user_name']))
		{
			$result = array("status" => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$new_user_name = $request_data['new_user_name'];

		if(!isName($new_user_name))
		{
			$result = array("status" => false,"msg" => "用户名有误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "update ".DB_PREFIX."user set user_name=".'"'.$new_user_name.'" where id='.$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "修改成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "修改失败");
			echo json_encode($result);
			exit(0);
		}
	}


	public function do_reset_pwd()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['phone_number']) || !isset($request_data['code']) || !isset($request_data['user_pwd'])|| !isset($request_data['user_pwd_confirm']))
		{
			$result = array("status" => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$phone_number = $request_data['phone_number'];
		$code = $request_data['code'];
		$pwd = $request_data['user_pwd'];
		$pwd_confirm = $request_data['user_pwd_confirm'];

		if($pwd != $pwd_confirm)
		{
			$result = array("status" => false,"msg" => "两次输入的密码不一致");
			echo json_encode($result);
			exit(0);
		}

		if(!(isset($_SESSION['phone_number']) && isset($_SESSION['code'])))
		{
			$result = array("status" => false,"msg" => "未发送验证码");
			echo json_encode($result);
			exit(0);
		}
		if($phone_number != $_SESSION['phone_number'] || $code != $_SESSION['code'])
		{
			$result = array("status" => false,"msg" => "验证码错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "update ".DB_PREFIX."user set user_pwd=".'"'.md5($pwd).'"'."where phone_number=".'"'.$phone_number.'"';
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "重置成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "重置失败");
			echo json_encode($result);
			exit(0);
		}
	}		

	public function get_address()
	{
		$request_data = $GLOBALS['request_data'];
		$user_id = $request_data['id'];
		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}
		if(isset($request_data['is_default']))
		{
			$sql = "select * from ".DB_PREFIX."user_address where user_id=".$user_id." and is_default=1 and is_delete=0";
		}
		else
		{
			$sql = "select * from ".DB_PREFIX."user_address where user_id=".$user_id." and is_delete=0";
		}
		$data = $GLOBALS['db']->getAll($sql);
		$result = array("status" => true,"msg" => "获取成功","data"=>$data);
		echo json_encode($result);
		exit(0);
	}



	public function do_add_address()
	{
		$request_data = $GLOBALS['request_data'];
		$user_id = $request_data['id'];
		$address = $request_data['address'];
		$address1 = $request_data['address1'];
		$user_name = $request_data['user_name'];
		$user_phone = $request_data['user_phone'];
		$is_default = $request_data['is_default'];
		#var_dump($request_data);
		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}
		//判断是否有默认地址
		$sql = "select count(*) from ".DB_PREFIX."user_address where user_id=".$user_id." and is_default=1";
		
		$defaul_count_var = $GLOBALS['db']->getRow($sql);
		#var_dump($defaul_count_var);
		$defaul_count = $defaul_count_var['count(*)'];
		if($defaul_count >0 && $is_default ==1)
		{
			$sql = "update ".DB_PREFIX."user_address set is_default=0 where is_default=1 and user_id=".$user_id;
			if(!$GLOBALS['db']->query($sql))
			{
				$result = array("status" => false,"msg" => "添加失败！");
				echo json_encode($result);
				exit(0);
			}
		}


		$sql = "insert into ".DB_PREFIX."user_address(user_id,address,address1,user_name,user_phone,is_default)";
		$sql .= " values(".$user_id.','.'"'.$address.'","'.$address1.'","'.$user_name.'","'.$user_phone.'",'.$is_default.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "添加成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "添加失败！");
			echo json_encode($result);
			exit(0);
		}
	}

	public function do_del_address()
	{
		$request_data = $GLOBALS['request_data'];
		$user_id = $request_data['id'];
		$address_id = $request_data['address_id'];

		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}

		$sql = "select * from ".DB_PREFIX."user_address where user_id=".$user_id." and address_id=".$address_id;

		$address_deatil = $GLOBALS['db']->getRow($sql);
		#var_dump($address_deatil);
		if(!isset($address_deatil['address_id']))
		{
			$result = array("status" => false,"msg" => "用户信息有误！!");
			echo json_encode($result);
			exit(0);
		}
		if($address_deatil['user_id'] != $user_id)
		{
			$result = array("status" => false,"msg" => "用户信息有误！！！");
			echo json_encode($result);
			exit(0);
		}
		$sql = "update ".DB_PREFIX."user_address set is_delete=1 where address_id=".$address_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败！！！");
			echo json_encode($result);
			exit(0);
		}
	}


	public function do_update_address()
	{
		$request_data = $GLOBALS['request_data'];
		$address_id = $request_data['address_id'];
		$user_id = $request_data['id'];
		$address = $request_data['address'];
		$address1 = $request_data['address1'];
		$user_name = $request_data['user_name'];
		$user_phone = $request_data['user_phone'];
		$is_default = $request_data['is_default'];
		if(!isset($request_data['is_default']))
		{
			$result = array("status" => false,"msg" => "参数有误！");
			echo json_encode($result);
			exit(0);
		}
		if($is_default != 0 && $is_default != 1)
		{
			$result = array("status" => false,"msg" => "参数有误！");
			echo json_encode($result);
			exit(0);
		}


		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}
		//当is_deafault为1的时候，判断是否有默认地址
		if($is_default != 0)
		{
			$sql = "select count(*) from ".DB_PREFIX."user_address where user_id=".$user_id." and is_default=1";
			
			$defaul_count_var = $GLOBALS['db']->getRow($sql);
			$defaul_count = $defaul_count_var['count(*)'];
			if($defaul_count >0)
			{
				$sql = "update ".DB_PREFIX."user_address set is_default=0 where is_default=1 and user_id=".$user_id;
				if(!$GLOBALS['db']->query($sql))
				{
					$result = array("status" => false,"msg" => "修改失败！");
					echo json_encode($result);
					exit(0);
					
				}
			}
		}

		$sql = "update ".DB_PREFIX."user_address set address=".'"'.$address.'",address1="'.$address1.'",user_name="'.$user_name.'",user_phone="'.$user_phone.'",is_default='.$is_default;
		$sql .= " where address_id=$address_id";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "更新成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "更新失败！");
			echo json_encode($result);
			exit(0);
		}
	}


	public function get_payment()
	{
		$request_data = $GLOBALS['request_data'];
		$user_id = $request_data['id'];
		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}
		$sql = "select * from ".DB_PREFIX."user_payment where user_id=".$user_id;
		$data = $GLOBALS['db']->getAll($sql);
		$result = array("status" => true,"msg" => "获取成功","data"=>$data);
		echo json_encode($result);
		exit(0);
	}

	public function do_add_payment()
	{
		$request_data = $GLOBALS['request_data'];
		$user_id = $request_data['id'];
		$type = $request_data['type'];
		$user_name = $request_data['user_name'];
		$id_num = $request_data['id_num'];
		$extra = isset($request_data['extra']) ? $request_data['extra'] : "none";
		$extra1 = isset($request_data['extra1']) ? $request_data['extra1'] : "none";
		$is_default = $request_data['is_default'];
		#var_dump($request_data);
		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}
		//判断是否有默认收款方式
		$sql = "select count(*) from ".DB_PREFIX."user_payment where user_id=".$user_id." and is_default=1";
		
		$defaul_count_var = $GLOBALS['db']->getRow($sql);
		#var_dump($defaul_count_var);
		$defaul_count = $defaul_count_var['count(*)'];
		if($defaul_count >0)
		{
			$sql = "update ".DB_PREFIX."user_payment set is_default=0 where user_id=".$user_id;
			if(!$GLOBALS['db']->query($sql))
			{
				$result = array("status" => false,"msg" => "添加失败！");
				echo json_encode($result);
				exit(0);
			}
		}


		$sql = "insert into ".DB_PREFIX."user_payment(user_id,type,user_name,id_num,extra,extra1,is_default)";
		$sql .= " values(".$user_id.','.'"'.$type.'","'.$user_name.'","'.$id_num.'","'.$extra.'","'.$extra1.'",'.$is_default.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "添加成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "添加失败！");
			echo json_encode($result);
			exit(0);
		}
	}


	public function do_del_payment()
	{
		$request_data = $GLOBALS['request_data'];
		$user_id = $request_data['id'];
		$payment_id = $request_data['payment_id'];

		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}

		$sql = "select * from ".DB_PREFIX."user_payment where user_id=".$user_id." and payment_id=".$payment_id;

		$payment_deatil = $GLOBALS['db']->getRow($sql);
		#var_dump($payment_deatil);
		if(!isset($payment_deatil['payment_id']))
		{
			$result = array("status" => false,"msg" => "用户信息有误！!");
			echo json_encode($result);
			exit(0);
		}
		if($payment_deatil['user_id'] != $user_id)
		{
			$result = array("status" => false,"msg" => "用户信息有误！！！");
			echo json_encode($result);
			exit(0);
		}
		$sql = "delete from ".DB_PREFIX."user_payment where payment_id=".$payment_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败！！！");
			echo json_encode($result);
			exit(0);
		}
	}

	public function do_update_payment()
	{
		$request_data = $GLOBALS['request_data'];
		$payment_id = $request_data['payment_id'];
		$user_id = $request_data['id'];
		$type = $request_data['type'];
		$user_name = $request_data['user_name'];
		$id_num = $request_data['id_num'];
		$extra = isset($request_data['extra']) ? $request_data['extra'] : "none";
		$extra1 = isset($request_data['extra1']) ? $request_data['extra1'] : "none";
		$is_default = $request_data['is_default'];
		if(!isset($request_data['is_default']))
		{
			$result = array("status" => false,"msg" => "参数有误！");
			echo json_encode($result);
			exit(0);
		}
		if($is_default != 0 && $is_default != 1)
		{
			$result = array("status" => false,"msg" => "参数有误！");
			echo json_encode($result);
			exit(0);
		}


		if($user_id != $GLOBALS['user_info']['id'])
		{
			$result = array("status" => false,"msg" => "用户信息有误！");
			echo json_encode($result);
			exit(0);
		}
		//当is_deafault为1的时候，判断是否有默认收款方式
		if($is_default != 0)
		{
			$sql = "select count(*) from ".DB_PREFIX."user_payment where user_id=".$user_id." and is_default=1";
			
			$defaul_count_var = $GLOBALS['db']->getRow($sql);
			$defaul_count = $defaul_count_var['count(*)'];
			if($defaul_count >0)
			{
				$sql = "update ".DB_PREFIX."user_payment set is_default=0 where user_id=".$user_id;
				if(!$GLOBALS['db']->query($sql))
				{
					$result = array("status" => false,"msg" => "修改失败！");
					echo json_encode($result);
					exit(0);
				}
			}
		}

		$extra = isset($request_data['extra']) ? $request_data['extra'] : "none";
		$extra1 = isset($request_data['extra1']) ? $request_data['extra1'] : "none";
		$sql = "update ".DB_PREFIX."user_payment set id_num=".'"'.$id_num.'",user_name="'.$user_name.'",type="'.$type.'",extra="'.$extra.'",extra1="'.$extra1.'",is_default='.$is_default;
		$sql .= " where payment_id=".$payment_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "更新成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "更新失败！");
			echo json_encode($result);
			exit(0);
		}
	}

	#个人中心
	public function myinfo()
	{
		$user_info = $GLOBALS['user_info'];
		check_upgrade();	

		$sql = "select * from ".DB_PREFIX."kline order by id DESC limit 1";
		$price_var = $GLOBALS['db']->getRow($sql);
		$price = isset($price_var['price'])? $price_var['price'] : 0;

		$sql = "select count(*) from ".DB_PREFIX."order where user_id=".$user_info['id'];
		$sql_res = $GLOBALS['db']->getRow($sql);
		$order_num = $sql_res['count(*)'];

		$sql = "select * from ".DB_PREFIX."conf_argument where id=1";
		$conf_var = $GLOBALS['db']->getRow($sql);
		$node_type = get_node_type($user_info,$conf_var);
		$total_consume = get_rainbow_consume_1($user_info['phone_number']);
		$result = array("status" => true,"user_info" => $user_info,"coin_price" => $price,"order_num"=> $order_num,"node_type"=>$node_type,"total_consume" => $total_consume,"phone_number" => "15837456045");
		echo json_encode($result);
		exit(0);
	}

	public function get_share_detail()
	{
		$user_info = $GLOBALS['user_info'];
		$share_url = "http://xcb.quanx.cc/index.php?ctl=user&act=register&code=".$user_info['invite_code'];
		$result = array("status" => true, "user_info" => $user_info,"share_url" => $share_url);

		echo json_encode($result);
	}



	#业绩明细
	public function yjmx()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		$user_phone_number = $user_info['phone_number'];
		$p_id = $user_info['p_id'];
		$p_user_detail = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user where id=".$p_id);
		if($p_user_detail == false)
			$p_user_detail = NULL;
		$direct_users = get_ngeneration_user($user_phone_number,1);

		$sql = "select * from ".DB_PREFIX."conf_argument where id=1";
		$conf_var = $GLOBALS['db']->getRow($sql);

		$direct_users_detail = array();
		foreach($direct_users as $item)
		{
			$rainbow_consume = get_rainbow_consume($item);
			$rainbow_consume_daily = get_rainbow_consume_daily($item);
			$sql = "select * from ".DB_PREFIX."user where phone_number=".'"'.$item.'"';
			$item_info = $GLOBALS['db']->getRow($sql);
			if($item_info == false)
				$item_info = NULL;
			$item_detail = array("rainbow_consume" => $rainbow_consume,"rainbow_consume_daily" => $rainbow_consume_daily,"user_info" => $item_info);
			$direct_users_detail[] = $item_detail;
		}
		$user_node_type = get_node_type($user_info,$conf_var);
		$p_user_node_type = get_node_type($p_user_detail,$conf_var);
		$total_consume = get_rainbow_consume_1($user_info['phone_number']);
		$user_info['node_type'] = $user_node_type;
		$user_info['total_consume'] = $total_consume;
		$p_user_detail['node_type'] = $p_user_node_type;

		$data = array("user_info"=>$user_info,"p_user_info" => $p_user_detail,"direct_users_detail" => $direct_users_detail);
		$result = array("status" => true,"data"=>$data);
		echo json_encode($result);
	}

	#app首页配置，包括公告，导航栏，轮播栏详情
	public function appconf()
	{
		$request_data = $GLOBALS['request_data'];
		$sql = "select * from ".DB_PREFIX."notice order by id DESC limit 20";
		$notice = $GLOBALS['db']->getAll($sql);

		$sql = "select * from ".DB_PREFIX."navigation order by id_index ASC";
		$navigation = $GLOBALS['db']->getAll($sql);

		$sql = "select * from ".DB_PREFIX."carousel order by id_index ASC";
		$carousel = $GLOBALS['db']->getAll($sql);

		$data = array("notice" =>$notice,"navigation" => $navigation,"carousel" => $carousel);
		$result = array("status" =>true,"msg" => "ok","data" => $data);
		echo json_encode($result);
		exit(0);
	}




}



?>
