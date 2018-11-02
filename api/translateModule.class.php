<?php
class translateModule
{
	private $page_size;

	public function __construct(){
		$page_size = 10;
	}

	public function do_translate_consume_credits()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['trade_pwd']) || !isset($request_data['code']) || !isset($request_data['to_phone_number']) || !isset($request_data['num']))	
		{
			$result = array("status" => false,"msg"=> "参数错误！");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$num = (float)$request_data['num'];
		$to_phone_number = $request_data['to_phone_number'];

		if($num < 0.00001)
		{
			$result = array("status" => false,"msg"=> "转出数目有误！");
			echo json_encode($result);
			exit(0);
		}
		$user_info = $GLOBALS['user_info'];
		if($user_info['id'] != $request_data['id'])
		{
			$result = array("status" => false,"msg"=> "登录异常！");
			echo json_encode($result);
			exit(0);
		}

		if($num > $user_info['consume_credits'])
		{
			$result = array("status" => false,"msg"=> "积分不足！");
			echo json_encode($result);
			exit(0);
		}
		$sql = "select * from ".DB_PREFIX."user where phone_number=".'"'.$to_phone_number.'"';
		$to_user_info = $GLOBALS['db']->getRow($sql);
		if(!isset($to_user_info['id']))
		{
			$result = array("status" => false,"msg"=> "转出账号有误！");
			echo json_encode($result);
			exit(0);
		}
		if($id == $to_user_info['id'])
		{
			$result = array("status" => false,"msg"=> "不能转给自己！");
			echo json_encode($result);
			exit(0);
		}


		if($user_info['user_pwd_trade'] != md5($request_data['trade_pwd']))
		{
			$result = array("status" => false,"msg"=> "密码错误！");
			echo json_encode($result);
			exit(0);
		}

		//1.从用户账户减去对应的消费积分
		//2.往对应的账号加上相应的消费积分
		//3.写转账记录
		$type = '"consume_credits"';
		$sql1 = "update ".DB_PREFIX."user set consume_credits=consume_credits-".$num." where id=$id";   
		$sql2 = "update ".DB_PREFIX."user set consume_credits=consume_credits+".$num." where phone_number=".'"'.$to_phone_number.'"';
		$msg = '"'.$user_info['user_name']." 转账给 ".$to_user_info['user_name']." ".$num.'消费积分"';
		$id_phone_number = $user_info['phone_number'];
		$sql3 = "insert into ".DB_PREFIX."translate_log(id,id_phone_number,to_id,time,type,num,msg) values(".$id.',"'.$id_phone_number.'","'.$to_phone_number.'",'.time().','.$type.','.$num.','.$msg.")";
		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res1 = mysql_query($sql1);   
		$res2 = mysql_query($sql2);    
		$res3 = mysql_query($sql3);
		if($res1 && $res2 && $res3){   
			mysql_query("COMMIT");
			$msg = '转账成功';   
			$result = array("status" => true,"msg" => $msg);
			echo json_encode($result);
		}
		else
		{   
			mysql_query("ROLLBACK");   
			$msg = '转账失败';   
			$result = array("status" => false,"msg" => $msg);
			echo json_encode($result);
		}   
		mysql_query("END"); 

	}


	public function get_consume_credits_log()
	{
		$request_data = $GLOBALS['request_data'];	
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']))
		{
			$msg = "参数错误";
			$result = array("status" => false,"msg" => $msg);
			echo json_encode($result);
		}
		$id= $request_data['id'];
		$p = 0;
		$page_size = 20;;
		if(isset($request_data['p']))
		{
			$p = $request_data['p'] - 1;
		}

		$type = '"consume_credits"';
		$start = $p*$page_size;
		$sql = "select * from ".DB_PREFIX."translate_log where (id=".$id." or to_id=".'"'.$user_info['phone_number'].'"'.") and type=".$type." order by time DESC limit ".$start.",".$page_size;
		$translate_deatil = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."translate_log where (id=".$id." or to_id=".'"'.$user_info['phone_number'].'") and type='.$type;
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_page =(int)( $count_var['count(*)']/$page_size + 1);


		$data = array("p"=>$p,"total_pages" => $total_page,"data" => $translate_deatil,"user_info" => $user_info);
		$result = array('status' => true,'msg'=>"获取成功",'data' => $data);
		echo json_encode($result);
	}


	public function do_translate_sps()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['trade_pwd']) || !isset($request_data['code']) || !isset($request_data['to_phone_number']) || !isset($request_data['num']))	
		{
			$result = array("status" => false,"msg"=> "参数错误！");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$num = (float)$request_data['num'];
		$to_phone_number = $request_data['to_phone_number'];
		$user_pwd_trade = $request_data['trade_pwd'];

		if($num < 0.00001 || $num > $user_info['cz_chain'])
		{
			$result = array("status" => false,"msg"=> "转出数目有误！");
			echo json_encode($result);
			exit(0);
		}
		$user_info = $GLOBALS['user_info'];
		if($user_info['id'] != $request_data['id'])
		{
			$result = array("status" => false,"msg"=> "登录异常！");
			echo json_encode($result);
			exit(0);
		}

		if($num > $user_info['consume_credits'])
		{
			$result = array("status" => false,"msg"=> "积分不足！");
			echo json_encode($result);
			exit(0);
		}
		$sql = "select * from ".DB_PREFIX."user where phone_number=".'"'.$to_phone_number.'"';
		$to_user_info = $GLOBALS['db']->getRow($sql);
		if(!isset($to_user_info['id']))
		{
			$result = array("status" => false,"msg"=> "转出账号有误！");
			echo json_encode($result);
			exit(0);
		}
		if($id == $to_user_info['id'])
		{
			$result = array("status" => false,"msg"=> "不能转给自己！");
			echo json_encode($result);
			exit(0);
		}

		if($user_info['user_pwd_trade'] != md5($user_pwd_trade))
		{
			$result = array("status" => false,"msg"=> "密码错误！");
			echo json_encode($result);
			exit(0);
		}



		//1.从用户账户减去对应的消费积分
		//2.往对应的账号加上相应的消费积分
		//3.写转账记录
		$type = '"sps"';
		$sql1 = "update ".DB_PREFIX."user set cz_chain=cz_chain-".$num." where id=$id";   
		$sql2 = "update ".DB_PREFIX."user set cz_chain=cz_chain+".$num." where phone_number=".'"'.$to_phone_number.'"';
		$msg = '"'.$user_info['user_name']." 转账给 ".$to_user_info['user_name']." ".$num.'sps"';
		$id_phone_number = $user_info['phone_number'];
		$sql3 = "insert into ".DB_PREFIX."translate_log(id,id_phone_number,to_id,time,type,num,msg) values(".$id.',"'.$id_phone_number.'","'.$to_phone_number.'",'.time().','.$type.','.$num.','.$msg.")";
		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res1 = mysql_query($sql1);   
		$res2 = mysql_query($sql2);    
		$res3 = mysql_query($sql3);
		if($res1 && $res2 && $res3){   
			mysql_query("COMMIT");
			$msg = '转账成功';   
			$result = array("status" => true,"msg" => $msg);
			echo json_encode($result);
		}
		else
		{   
			mysql_query("ROLLBACK");   
			$msg = '转账失败';   
			$result = array("status" => false,"msg" => $msg);
			echo json_encode($result);
		}   
		mysql_query("END"); 
	}
	
	public function get_translate_sps_log()
	{
		$request_data = $GLOBALS['request_data'];	
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']))
		{
			$msg = "参数错误";
			$result = array("status" => false,"msg" => $msg);
			echo json_encode($result);
		}
		$id= $request_data['id'];
		$p = 0;
		$page_size = 20;;
		if(isset($request_data['p']))
		{
			$p = $request_data['p'] - 1;
		}

		$type = '"sps"';
		$start = $p*$page_size;
		$sql = "select * from ".DB_PREFIX."translate_log where (id=".$id." or to_id=".'"'.$user_info['phone_number'].'"'.") and type=".$type." order by time DESC limit ".$start.",".$page_size;
		$translate_deatil = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."translate_log where (id=".$id." or to_id=".'"'.$user_info['phone_number'].'") and type='.$type;
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_page =(int)( $count_var['count(*)']/$page_size + 1);


		$data = array("p"=>$p,"total_pages" => $total_page,"data" => $translate_deatil,"user_info" => $user_info);
		$result = array('status' => true,'msg'=>"获取成功",'data' => $data);
		echo json_encode($result);
	}


	public function do_withdraw_sps()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['to_address']) || !isset($request_data['num']) || !isset($request_data['user_pwd_trade']))
		{
			$result = array("status" => false,"msg"=> "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$to_address = $request_data['to_address'];
		$num = $request_data['num'];
		$user_pwd_trade = md5($request_data['user_pwd_trade']);

		if(!is_numeric($num) || $num < 0.0001 || $num > $user_info['cz_chain'])
		{
			$result = array("status" => false,"msg"=> "转账数目不对");
			echo json_encode($result);
			exit(0);
		}


		if($id != $user_info['id'] || $user_pwd_trade != $user_info['user_pwd_trade'])
		{
			$result = array("status" => false,"msg"=> "账户或密码不对");
			echo json_encode($result);
			exit(0);
		}
		if($this->update_sps_wallet_balance($to_address,$num))
		{
			#转账成功,扣储值链，写转账记录
			$sql = "update ".DB_PREFIX."user set cz_chain=cz_chain-".$num." where id=".$id;
			$sql1 = "insert into ".DB_PREFIX."translate_log(id,to_id,time,type,num,msg) values(".$id.',"'.$to_user_info['id'].'",'.time().','.$type.','.$num.','.$msg.")";
		}

	}

	private function update_sps_wallet_balance($to_address,$num)
	{
		return true;
	}



	public function do_translate_sps_to_credits()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['num']) || !isset($request_data['coin_price']) || !isset($request_data['user_pwd_trade']))
		{
			$result = array("status" => false,"msg"=> "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$num = $request_data['num'];
		$coin_price = $request_data['coin_price'];
		$user_pwd_trade = $request_data['user_pwd_trade'];

		if($user_info['id'] != $request_data['id'])
		{
			$result = array("status" => false,"msg"=> "登录异常！");
			echo json_encode($result);
			exit(0);
		}
		if($num > $user_info['cz_chain'] || $num < 0.00001)
		{
			$result = array("status" => false,"msg"=> "数目有误！");
			echo json_encode($result);
			exit(0);
		}
		if($user_info['user_pwd_trade'] != md5($user_pwd_trade))
		{
			$result = array("status" => false,"msg"=> "密码错误！");
			echo json_encode($result);
			exit(0);
		}


		$sql = "select * from ".DB_PREFIX."kline order by id DESC limit 1";
		$price_var = $GLOBALS['db']->getRow($sql);
		$price = isset($price_var['price'])? $price_var['price'] : 0;
		if($coin_price != $price)
		{
			$result = array("status" => false,"msg"=> "价格异常！");
			echo json_encode($result);
			exit(0);
		}
		$type = '"sps_to_credits"';
		$id_phone_number = $user_info['phone_number'];
		$to_phone_number = $id_phone_number;
		$add_consume_credits = $price * $num;
		$msg = '"'."您将".$num."sps兑换为".$add_consume_credits.'消费积分"';

		$user_id = $id;
		$from_user_id = $id;
		$base_num = $num;
		$sql = "update ".DB_PREFIX."user set consume_credits=consume_credits+".$add_consume_credits.",cz_chain=cz_chain-".$num." where id=".$id;
		$sql1 = "insert into xcb_reward_log(user_id,time,type,from_user_id,base_num,num,msg) values(".$user_id.','.time().','.$type.','.$from_user_id.','.$base_num.','.$add_consume_credits.','.$msg.")";

		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res = mysql_query($sql);   
		$res1 = mysql_query($sql1);    
		if($res && $res1){   
			mysql_query("COMMIT");
			$msg = '成功';   
			$result = array("status" => true,"msg" => $msg);
			echo json_encode($result);
		}
		else
		{   
			mysql_query("ROLLBACK");   
			$msg = '失败';   
			$result = array("status" => false,"msg" => $msg);
		}
		mysql_query("END");
	}


	public function get_sps_to_credits_log()
	{
		$request_data = $GLOBALS['request_data'];	
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']))
		{
			$msg = "参数错误";
			$result = array("status" => false,"msg" => $msg);
			echo json_encode($result);
		}
		$id= $request_data['id'];
		$p = 0;
		$page_size = 20;;
		if(isset($request_data['p']))
		{
			$p = $request_data['p'] - 1;
		}

		$start = $p*$page_size;
		$type = '"sps_to_credits"';
		$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$id." and type=".$type." order by time DESC limit ".$start.",".$page_size;
		$translate_deatil = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."reward_log where user_id=".$id." and type=".$type;
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_page =(int)( $count_var['count(*)']/$page_size + 1);


		$data = array("p"=>$p,"total_pages" => $total_page,"data" => $translate_deatil,"user_info" => $user_info);
		$result = array('status' => true,'msg'=>"获取成功",'data' => $data);
		echo json_encode($result);
	
	}
}
?>
