<?php
class orderModule
{
	
	public function get_deal_list()
	{
		$page_size = 10;
		$request_data = $GLOBALS['request_data'];
		$p = 1;
		if(isset($request_data['p']))
		{
			$p = $request_data['p'];
		}
		$where = " where stock>0 and is_effect=1 ";
		if(isset($request_data['key']))
		{
			$where .= " and deal_name like ".'"%'.(string)$request_data['key'].'%"';
		}
		if(!isset($request_data['key1']))
		{
			$order = " order by sale_amount DESC";
		}
		else if($request_data['key1'] == "xl")
		{
			$order = " order by sale_amount DESC";
		}
		else if($request_data['key1'] == "xp")
		{
			$order = " order by id DESC";
		}
		else if($request_data['key1'] == "jg1")
		{
			$order = " order by current_price DESC";
		}
		else if($request_data['key1'] == "jg2")
		{
			$order = " order by current_price ASC";
		}
		else
		{
			$order = " order by id ASC";
		}
		$start = ($p-1)*$page_size;
		$limit = " limit ".$start.','.$page_size;
		$sql = "select * from ".DB_PREFIX."deal ".$where.$order.$limit;
		$deal_data= $GLOBALS['db']->getAll($sql);
		$deal_list = array();
		foreach($deal_data as $item)
		{
			$deal_list[] = array("id" => $item['id'],
								 "deal_name" => $item['deal_name'],
								 "img" => $item['img'],
								 "current_price" => $item['current_price'],
								 "breaf" => $item['brief'],
								 "stock" => $item['stock'],
								 "img1" => $item['img1'],
								 "img2" => $item['img2'],
								 "img3" => $item['img3'],
								 "sale_amount" => $item['sale_amount']
								 );
		}
		$result = array('status' => true,"msg"=> "获取成功","deal_list" => $deal_list);
		echo json_encode($result);
	}

	public function get_deal_item()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['deal_id']) && $request_data['deal_id'] != "")
		{
			$result = array("status"=> false,"msg"=> "参数异常！");
			echo json_encode($result);
			exit(0);
		}
		$deal_id = $request_data['deal_id'];
		$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id;
		$item_detail = $GLOBALS['db']->getRow($sql);
		$result = array("status" => true,"data"=>$item_detail);
		echo json_encode($result);
	}


	public function do_payment()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['deal_id']) || !isset($request_data['return_sps']) || !isset($request_data['deal_price']) || !isset($request_data['amount']) || !isset($request_data['address_id']))
		{
			$result = array("status"=> false,"msg"=> "参数异常！");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$deal_id = $request_data['deal_id'];
		$return_sps = $request_data['return_sps'];
		$deal_price = $request_data['deal_price'];
		$amount = $request_data['amount'];
		$address_id = $request_data['address_id'];

		if(isset($request_data['user_pwd_trade']))
		{
			if(md5($request_data['user_pwd_trade']) != $user_info['user_pwd_trade'])
			{
				$result = array("status"=> false,"msg"=> "密码错误！");
				echo json_encode($result);
				exit(0);
			}
		}

		$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id;
		$deal_detail = $GLOBALS['db']->getRow($sql);
		$gen_return_sps = round($amount*$this->gen_return_sps($deal_id),2);
		if($deal_detail['current_price'] != $deal_price || $return_sps != $gen_return_sps)
		{
			$result = array("status"=> false,"msg"=> "参数异常");
			echo json_encode($result);
			exit(0);
		}
		$total_price = $deal_price*$amount;
		if($total_price > $user_info['consume_credits'])
		{
			$result = array("status"=> false,"msg"=> "积分不足");
			echo json_encode($result);
			exit(0);
		}
		$order_sn = '"'.$id.time().$deal_id.'"';
		$deal_name = '"'.$deal_detail['deal_name'].'"';
		$deal_img = isset($deal_detail['img']) ? '"'.$deal_detail['img'].'"': " ";
		$user_name = '"'.$user_info['user_name'].'"';
		$order_status = 1;
		$user_id = $user_info['id'];
		$time = time();
		$type = '"consume"';
		$from_user_id = $user_id;
		$base_num = $total_price;
		$num = round($return_sps,2);
		$msg = '"您购物'.$base_num.',获赠'.$num.'sps链"';


		$sql = "insert into ".DB_PREFIX."order(order_sn,deal_name,deal_id,deal_img,amount,user_name,user_id,order_status,price,total_price,create_time,address_id)";
		$sql .= " values(".$order_sn.','.$deal_name.','.$deal_id.','.$deal_img.','.$amount.','.$user_name.','.$id.','.$order_status.','.$deal_price.','.$total_price.','.time().','.$address_id.")";
		$sql1 = "update ".DB_PREFIX."user set consume_credits=consume_credits-".$total_price.",sc_chain=sc_chain+".$return_sps." where id=".$id;
		$sql2 = "insert into xcb_reward_log(user_id,time,type,from_user_id,base_num,num,msg) values(".$user_id.','.$time.','.$type.','.$from_user_id.','.$base_num.','.$num.','.$msg.")";
		$sql3 = "insert into ".DB_PREFIX."sc_list(user_id,time,sc_num,remaining_num) values(".$id.','.time().','.$num.','.$num.")";

		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res = mysql_query($sql);
		$res1 = mysql_query($sql1);
		$res2 = mysql_query($sql2);
		$res3 = mysql_query($sql3);
		if($res && $res1 && $res2 && $res3)
		{
			mysql_query("COMMIT");
			$result = array("status" => true,"msg" => "付款成功！");
			echo json_encode($result);
		}
		else
		{
			mysql_query("ROLLBACK");
			$result = array("status" => false,"msg" => "付款失败！");
			echo json_encode($result);
		}
		mysql_query("END");
		exit(0);
	}

	public function get_order_list()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		$p = 1;
		$page_size = 10;
		if(isset($request_data['p']) && $request_data['p']>=0)
		{
			$p = $request_data['p'];
		}
		$where = " where user_id=".$user_info['id'];
		if(isset($request_data['order_status']))
		{
			$where .= " and order_status=".$request_data['order_status'];
		}
		$start= 10*($p-1);
		$limit = " limit $start".", $page_size";
		$sql = "select * from ".DB_PREFIX."order ".$where." order  by id desc".$limit;
		$order_data= $GLOBALS['db']->getAll($sql);
		$order_list = array();
		
		$sql = "select count(*) from ".DB_PREFIX."order ".$where;
		$total_var = $GLOBALS['db']->getRow($sql);
		$total = $total_var['count(*)'];
		if($total%$page_size == 0)
			$pages = intval($total/$page_size);
		else
			$pages = intval($total/$page_size) +1;
		
		foreach($order_data as $item)
		{
			$address_id = $item['address_id'];
			$sql = "select * from ".DB_PREFIX."user_address where address_id=".$address_id;
			$address_detail = $GLOBALS['db']->getRow($sql);
			if($address_detail == false)
				$address_detail = NULL;
			$order_list[] = array("id" => $item['id'],
								 "deal_name" => $item['deal_name'],
								 "img" => $item['deal_img'],
								 "current_price" => $item['price'],
								 "total_price" => $item['total_price'],
								 "amount" => $item['amount'],
								 "order_sn" => $item['order_sn'],
								 "express_num" => $item['express_num'],
								 "create_time" => $item['create_time'],
								 "end_time" => $item['end_time'],
								 "receive_time" => $item['receive_time'],
								 "address_detail" => $address_detail
								 );	
		}
		$result = array('status' => true,"msg"=> "获取成功","order_list" => $order_list,"p" => $p,"pages" => $pages);
		echo json_encode($result);
	}



	public function do_del_order()
	{
		$request_data = $GLOBALS['request_data'];
		if(!(isset($request_data['id']) && is_numeric($request_data['id']) && $request_data['id'] > 0))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);
		}
		
		if(!(isset($request_data['order_id']) && is_numeric($request_data['order_id']) && $request_data['order_id'] > 0))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);
		}

		$id = $request_data['id'];
		$order_id = $request_data['order_id'];
		$sql = "delete from ".DB_PREFIX."order where id=".$order_id;
		if(!$GLOBALS['db']->query($sql))
		{
			$result = array("status" => false,"msg"=> "订单id错误");
			echo json_encode($result);
			exit(0);	
		}
		$result = array("status" => true,"msg" => "删除成功！");
		echo json_encode($result);
		exit(0);
	}


	public function do_receive_package()
	{
		$request_data = $GLOBALS['request_data'];
		if(!(isset($request_data['id']) && is_numeric($request_data['id']) && $request_data['id'] > 0))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);
		}
		
		if(!(isset($request_data['order_id']) && is_numeric($request_data['order_id']) && $request_data['order_id'] > 0))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$order_id = $request_data['order_id'];
		$sql = "update ".DB_PREFIX."order set order_status=3,receive_time=".time()." where id=".$order_id;
		if(!$GLOBALS['db']->query($sql))
		{
			$result = array("status" => false,"msg"=> "订单id错误");
			echo json_encode($result);
			exit(0);	
		}
		$result = array("status" => true,"msg" => "收货成功！");
		echo json_encode($result);
		exit(0);
	}
	

	public function get_return_sps()
	{
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		$deal_id = $request_data['deal_id'];
		$return_sps = $this->gen_retrun_sps($deal_id);
		$result = array("status" => true,"return_sps" => $return_sps);
		echo json_encode($result);
	}

	private function gen_return_sps($deal_id)
	{
		$sql = "select * from ".DB_PREFIX."kline order by id DESC limit 0,1";
		$kline_item_deatil = $GLOBALS['db']->getRow($sql);
	
		if(!isset($kline_item_deatil['price']))
		{
			return 0;	
		}
		$current_sps_price = $kline_item_deatil['price'];

		$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id;
		$deal_deatil = $GLOBALS['db']->getRow($sql);
		$current_price = isset($deal_deatil['current_price']) ? $deal_deatil['current_price'] : 0;

		$return_sps = round($current_price/$current_sps_price,2);
		return $return_sps;
	}





	

	
}


?>
