<?php

class tradeModule
{
	private $page_size;
	public function __construct(){
		$this->page_size = 10;
	}
	#获取k线图
	public function get_kline()
	{
		$sql = "select * from ".DB_PREFIX."kline order by date DESC limit 7";
		$kline = $GLOBALS['db']->getAll($sql);
		$result = array("status"=> true,"msg"=> "获取成功","data"=> $kline);
		echo json_encode($result);
		#$type = '"buy"';
		#$sql = "select * from ".DB_PREFIX."c2c_order_item where status=1 and type=".$type;
		#$buy_order = $GLOBALS['db']->getAll($sql);
		#$type = "sale";
		#$sql = "select * from ".DB_PREFIX."c2c_order_item where status=1 and type=".$type;
		#$sale_order = $GLOBALS['db']->getAll($sql);


		exit(0);
	}

	#获取所有的卖单
	public function get_sale_list()
	{
		$request_data =  $GLOBALS['request_data'];
		if(!isset($request_data['p']))
		{
			$p =1;
		}
		else
		{
			$p =  $request_data['p'];
		}
		$limit = " limit ".($p-1)*$this->page_size.",$this->page_size";
		$type = '"sale"';
		$sql = "select * from ".DB_PREFIX."c2c_order_item where status=1 and type=".$type.$limit;
		$sale_order = $GLOBALS['db']->getAll($sql);
		$new_sale_order = array();
		foreach($sale_order as $item)
		{
			$user_id = $item['user_id'];
			$sql = "select * from ".DB_PREFIX."user where id=".$user_id;
			$user_detail = $GLOBALS['db']->getRow($sql);
			$user_name = $user_detail['user_name'];
			$user_avatar = $user_detail['user_avatar'];
			$item['user_name'] = $user_name;
			$item['user_avatar'] = $user_avatar;
			$new_sale_order[] = $item;
		}
		$data = array("p" => $p,"data" => $new_sale_order);
		$result = array("status" => true,"msg" => "获取成功","data"=>$data);
		echo json_encode($result);
		
	}

	public function get_buy_list()
	{
		$request_data =  $GLOBALS['request_data'];
		if(!isset($request_data['p']))
		{
			$p =1;
		}
		else
		{
			$p =  $request_data['p'];
		}
		$limit = " limit ".($p-1)*$this->page_size.",$this->page_size";
		$type = '"buy"';
		$sql = "select * from ".DB_PREFIX."c2c_order_item where status=1 and type=".$type.$limit;
		$buy_order = $GLOBALS['db']->getAll($sql);
		$new_buy_order = array();
		foreach($buy_order as $item)
		{
			$user_id = $item['user_id'];
			$sql = "select * from ".DB_PREFIX."user where id=".$user_id;
			$user_detail = $GLOBALS['db']->getRow($sql);
			$user_name = $user_detail['user_name'];
			$user_avatar = $user_detail['user_avatar'];
			$item['user_name'] = $user_name;
			$item['user_avatar'] = $user_avatar;
			$new_buy_order[] = $item;
		
		}
		$data = array("p" => $p,"data" => $new_buy_order);
		$result = array("status" => true,"msg" => "获取成功","data"=>$data);
		echo json_encode($result);
	}
		

	public function do_pulish_order()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['type']) || !isset($request_data['num']) || !isset($request_data['price']) || !isset($request_data['user_pwd_trade']))
		{
			$result = array("status" => false, "msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$type = '"'.$request_data['type'].'"';
		$num = $request_data['num'];
		$price = $request_data['price'];
		$user_pwd_trade = $request_data['user_pwd_trade'];
		$cj_num = 0;
		$status = 1;

		if($id != $user_info['id'] || md5($user_pwd_trade) != $user_info['user_pwd_trade'])
		{
			$result = array("status" => false, "msg" => "用户信息错误");
			echo json_encode($result);
			exit(0);
		}

		if(!is_numeric($num) || $num <0.0001)
		{
			$result = array("status" => false, "msg" => "订单数目有误");
			echo json_encode($result);
			exit(0);
		}
		if(!is_numeric($price) || $num <0.0001)
		{
			$result = array("status" => false, "msg" => "价格有误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "insert into ".DB_PREFIX."c2c_order_item(user_id,time,type,num,cj_num,price,status)";
		$sql .= " values(".$id.','.time().','.$type.','.$num.','.$cj_num.','.$price.','.$status.")";
		if($GLOBALS['db']->query($sql))
		{
		
			$result = array("status" => true,"msg" => "下单成功");
			echo json_encode($result);
		}
		else
		{
			$result = array("status" => true,"msg" => "下单失败");
			echo json_encode($result);
		}
	}



	public function do_buy()
	{
		$request_data = $GLOBALS['request_data'];			
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['order_id']) || !isset($request_data['num']) || !isset($request_data['price']) || !isset($request_data['user_pwd_trade']))
		{
			$result = array('status' => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}

		$id = $request_data['id'];
		$order_id = $request_data['order_id'];
		$num = $request_data['num'];
		$price = $request_data['price'];
		$user_pwd_trade = $request_data['user_pwd_trade'];
		$sql = "select * from ".DB_PREFIX."c2c_order_item where order_id=".$order_id;
		$order_detail = $GLOBALS['db']->getRow($sql);
		if(!isset($order_detail['order_id']))
		{
			$result = array('status' => false,"msg" => "订单不存在");
			echo json_encode($result);
			exit(0);
		}

		if($order_detail['status'] == 0)
		{
			$result = array('status' => false,"msg" => "订单被撤回");
			echo json_encode($result);
			exit(0);
		}

		if(md5($user_pwd_trade) != $user_info['user_pwd_trade'])
		{
			$result = array('status' => false,"msg" => "交易密码不正确");
			echo json_encode($result);
			exit(0);
		}

		if($num > $order_detail['num'] - $order_detail['cj_num'])
		{
			$result = array('status' => false,"msg" => "交易数目不对");
			echo json_encode($result);
			exit(0);
		}
		if($price != $order_detail['price'])
		{
			$result = array('status' => false,"msg" => "价格不对");
			echo json_encode($result);
			exit(0);
		}
		$status = 1;
		if($order_detail['num'] - $order_detail['cj_num'] == $num)
		{
			$status = 2;
		}
		$to_user_id = $order_detail['user_id'];

		$type = '"buy"';
		$sql = "update ".DB_PREFIX."c2c_order_item set cj_num=cj_num+".$num.",status=".$status." where order_id=".$order_id;
		$sql1 = "insert into ".DB_PREFIX."c2c_order_log(user_id,type,to_user_id,order_id,num,price,status,c_time)";
		$sql1 .= "values(".$id.','.$type.','.$to_user_id.','.$order_id.','.$num.','.$price.',0'.','.time().')';

		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res = mysql_query($sql);
		$res1 = mysql_query($sql1);
		if($res && $res1)
		{
			mysql_query("COMMIT");
			$result = array("status" => true,"msg" => "购买成功！");
			echo json_encode($result);
		}
		else
		{
			mysql_query("ROLLBACK");
			$result = array("status" => false,"msg" => "购买失败！");
			echo json_encode($result);
		}
		mysql_query("END");
		exit(0);

	}

	public function do_sale()
	{
		$request_data = $GLOBALS['request_data'];			
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['order_id']) || !isset($request_data['num']) || !isset($request_data['price']) || !isset($request_data['user_pwd_trade']))
		{
			$result = array('status' => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}

		$id = $request_data['id'];
		$order_id = $request_data['order_id'];
		$num = $request_data['num'];
		$price = $request_data['price'];
		$user_pwd_trade = $request_data['user_pwd_trade'];
		$sql = "select * from ".DB_PREFIX."c2c_order_item where order_id=".$order_id;
		$order_detail = $GLOBALS['db']->getRow($sql);
		if(!isset($order_detail['order_id']))
		{
			$result = array('status' => false,"msg" => "订单不存在");
			echo json_encode($result);
			exit(0);
		}

		if($order_detail['status'] == 0)
		{
			$result = array('status' => false,"msg" => "订单被撤回");
			echo json_encode($result);
			exit(0);
		}

		if(md5($user_pwd_trade) != $user_info['user_pwd_trade'])
		{
			$result = array('status' => false,"msg" => "交易密码不正确");
			echo json_encode($result);
			exit(0);
		}

		if($num > $order_detail['num'] - $order_detail['cj_num'])
		{
			$result = array('status' => false,"msg" => "交易数目不对");
			echo json_encode($result);
			exit(0);
		}
		if($price != $order_detail['price'])
		{
			$result = array('status' => false,"msg" => "价格不对");
			echo json_encode($result);
			exit(0);
		}
		$status = 1;
		if($order_detail['num'] - $order_detail['cj_num'] == $num)
		{
			$status = 2;
		}

		$type = '"sale"';
		$sql = "update ".DB_PREFIX."c2c_order_item set cj_num=cj_num+".$num.",status=".$status." where order_id=".$order_id;
		$sql1 = "insert into ".DB_PREFIX."c2c_order_log(user_id,type,order_id,num,price,status,c_time)";
		$sql1 .= "values(".$id.','.$type.','.$order_id.','.$num.','.$price.',0,'.time().')';

		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res = mysql_query($sql);
		$res1 = mysql_query($sql1);
		if($res && $res1)
		{
			mysql_query("COMMIT");
			$result = array("status" => true,"msg" => "出售成功！");
			echo json_encode($result);
		}
		else
		{
			mysql_query("ROLLBACK");
			$result = array("status" => false,"msg" => "出售失败！");
			echo json_encode($result);
		}
		mysql_query("END");
		exit(0);
	
	}

	#获取交易记录
	public function get_trade_list()
	{
		$page_size = 10;
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		if(!isset($request_data['p']))
			$p = 1;
		else
			$p = $request_data['p'];
		$id = $request_data['id'];
		if($p <1)
		{
			$p =1;
		}
		$start = ($p-1)*$page_size;
		$limit = " limit ".$start.','.$page_size;
		$sql = "select * from ".DB_PREFIX."c2c_order_log where user_id=".$id." order by id DESC".$limit;
		$data = $GLOBALS['db']->getAll($sql);
		$result = array("status" => true,"msg" => "获取成功","data" => $data);
		echo json_encode($result);
		exit(0);

	}

	#获取发布记录
	public function get_punish_list()
	{
		$page_size = 10;
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		if(!isset($request_data['p']))
			$p = 1;
		else
			$p = $request_data['p'];
		$id = $request_data['id'];
		if($p <1)
		{
			$p =1;
		}
		$start = ($p-1)*$page_size;
		$limit = " limit ".$start.','.$page_size;
		$sql = "select * from ".DB_PREFIX."c2c_order_item where user_id=".$id." order by order_id DESC".$limit;
		$data = $GLOBALS['db']->getAll($sql);
		$result = array("status" => true,"msg" => "获取成功","data" => $data);
		echo json_encode($result);
		exit(0);
	
	}
	
	#确认付款
	public function do_confirm_pay()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['order_id']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$order_id = $request_data['order_id'];

		if(!is_numeric($order_id))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		#买家确认付钱表示买家已经收到货，并且已经付钱到卖方，等待卖方确认收款。
		$status = 1; 
		$sql = "update ".DB_PREFIX."c2c_order_log set status=".$status." where order_id=".$order_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true ,"msg" => "确认付款成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "确认付款失败");
			echo json_encode($result);
			exit(0);
		}
	}


	#确认收款,确认收款后才会把币从卖出账号加到买入的账号
	public function do_confirm_recieve()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['order_id']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$order_id = $request_data['order_id'];

		if(!is_numeric($order_id))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		#卖家确认收到钱表示订单已完成
		$status = 2; 
		$sql = "update ".DB_PREFIX."c2c_order_log set status=".$status." where order_id=".$order_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true ,"msg" => "确认收款成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "确认收款失败");
			echo json_encode($result);
			exit(0);
		}
	}


	#取消订单
	public function do_cancel()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['order_id']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
		}
		$order_id = $request_data['order_id'];
		$id = $request_data['id'];

		$sql = "update ".DB_PREFIX."c2c_order_item set status=0 where order_id=".$order_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "取消成功");
			echo json_encode($result);
		}
		else
		{
			$result = array("status" => false,"msg" => "取消失败");
			echo json_encode($result);
		}

	}


	#获取当前价格 
	public function get_coin_price()
	{
		$sql = "select * from ".DB_PREFIX."kline order by id DESC limit 1";
		$price_var = $GLOBALS['db']->getRow($sql);
		$price = isset($price_var['price'])? $price_var['price'] : 0;
		$result  = array("status" => true,"price" => $price);
		echo json_encode($result);
		exit(0);
	}

}

?>
