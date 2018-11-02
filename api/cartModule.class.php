<?php
#购物车先关
class cartModule
{
	# 获取购物车列表,不分页
	public function get_cart_list()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']))
		{
			$result = array('status' => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$sql = "select * from ".DB_PREFIX."cart where user_id=".$id." order by time DESC";
		$cart_data= $GLOBALS['db']->getAll($sql);
		$cart_list = array();
		foreach($cart_data as $item)
		{
			$deal_id = $item['deal_id'];
			$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id." and is_effect=1";
			$deal_deatil = $GLOBALS['db']->getRow($sql);
			if(!isset($deal_deatil['id']))
			{
				continue;
			}
			$cart_list[] = array("cart_id" => $item['cart_id'],
								 "deal_id" => $deal_deatil['id'],
								 "deal_name" => $deal_deatil['deal_name'],
								 "img" => $deal_deatil['img'],
								 "current_price" => $deal_deatil['current_price'],
								 "breaf" => $deal_deatil['brief'],
								 "stock" => $deal_deatil['stock'],
								 "num" => $item['num']	
								 );
		}
		$result = array('status' => true,"msg"=> "获取成功","cart_list" => $cart_list);
		echo json_encode($result);

	}

	public function do_add_to_cart()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['num']) || !isset($request_data['deal_id']))
		{
			$result = array('status' => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$num = $request_data['num'];
		$deal_id = $request_data['deal_id'];
		if($num < 1)
		{
			$result = array('status' => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "insert into ".DB_PREFIX."cart(user_id,deal_id,time,num) values(".$id.','.$deal_id.','.time().','.$num.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array('status' => true,"msg" => "添加成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array('status' => false,"msg" => "添加失败");
			echo json_encode($result);
			exit(0);
		}
	}

	public function do_del_from_cart()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['cart_id']))
		{
			$result = array('status' => false,"msg" => "参数有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $result['id'];
		$cart_ids = $request_data['cart_id'];
		$card_id_var = explode(",",$cart_ids);
		$success = true;
		foreach($card_id_var as $item)
		{
			$sql = "delete from ".DB_PREFIX."cart where cart_id=".$item;
			$res = mysql_query($sql);
			if(!$res)
			{
				$success = false;
				break;
			}
		}

		if($success)
		{
			mysql_query("COMMIT");
			mysql_query("END");
			$result = array("status" => true,"msg" => "删除成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败！");
			echo json_encode($result);
		}
		
	}


	public function do_update_cart()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['cart_id']) || !isset($request_data['num']))
		{
			$result = array("status" => false,"msg" => "参数异常");	
			echo json_encode($result);
			exit(0);	
		}

		$cart_id = $request_data['cart_id'];
		$num = $request_data['num'];
		$sql = "update ".DB_PREFIX."cart set num=".$num." where cart_id=".$cart_id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "更新成功");	
			echo json_encode($result);
			exit(0);	
		}
		else
		{
			$result = array("status" => false,"msg" => "更新失败");	
			echo json_encode($result);
			exit(0);	
		}
	}


	public function cart_do_payment()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['cart_id']) || !isset($request_data['address_id']))
		{
			$result = array("status"=> false,"msg"=> "参数异常！");
			echo json_encode($result);
			exit(0);
		}

		$id = $request_data['id'];
		$cart_ids = $request_data['cart_id'];
		$card_id_var = explode(",",$cart_ids);
		$total_price = 0;
		$gen_return_sps = 0;
		$address_id = $request_data['address_id'];
		
		if(isset($request_data['user_pwd_trade']))
		{
			if($user_info['user_pwd_trade'] != md5($request_data['user_pwd_trade']))
			{
				$result = array("status" => false,"msg" => "密码错误！");
				echo json_encode($result);
				exit(0);
			}

		}


		foreach($card_id_var as $item)
		{
			$sql = "select * from ".DB_PREFIX."cart where cart_id=".$item;
			$cart_detail = $GLOBALS['db']->getRow($sql);
			if(!isset($cart_detail['cart_id']))
			{
				$result = array("status" => false,"msg" => "购物车产品不存在！");
				echo json_encode($result);
				exit(0);
			}
			$deal_id = $cart_detail['deal_id'];
			$num = $cart_detail['num'];

			$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id;
			$deal_detail = $GLOBALS['db']->getRow($sql);

			$amount = $num;
			$deal_price = $deal_detail['current_price'];
			$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id;
			$deal_detail = $GLOBALS['db']->getRow($sql);
			$total_price += $deal_price*$amount;
		}

		if($total_price > $user_info['consume_credits'])
		{
			$result = array("status"=> false,"msg"=> "积分不足");
			echo json_encode($result);
			exit(0);
		}


		$success = true;
		$total_sps = 0;
		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		foreach($card_id_var as $item)
		{
			$sql = "select * from ".DB_PREFIX."cart where cart_id=".$item;
			$cart_detail = $GLOBALS['db']->getRow($sql);
			if(!isset($cart_detail['cart_id']))
			{
				$result = array("status" => false,"msg" => "购物车产品不存在！");
				echo json_encode($result);
				exit(0);
			}
			$deal_id = $cart_detail['deal_id'];
			$num = $cart_detail['num'];

			$sql = "select * from ".DB_PREFIX."deal where id=".$deal_id;
			$deal_detail = $GLOBALS['db']->getRow($sql);

			$deal_price = $deal_detail['current_price'];
			$total_price = $deal_price*$num;
			$return_sps = round($num*gen_return_sps($deal_id),2);
			$total_sps += $return_sps;
			$amount = $num;
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
			$num = $return_sps;
			$msg = '"您购物'.$base_num.',获赠'.$num.'sps链"';

			$sql = "insert into ".DB_PREFIX."order(order_sn,deal_name,deal_id,deal_img,amount,user_name,user_id,order_status,price,total_price,create_time,address_id)";
			$sql .= " values(".$order_sn.','.$deal_name.','.$deal_id.','.$deal_img.','.$amount.','.$user_name.','.$id.','.$order_status.','.$deal_price.','.$total_price.','.time().','.$address_id.")";
			$sql1 = "update ".DB_PREFIX."user set consume_credits=consume_credits-".$total_price.",sc_chain=sc_chain+".$return_sps." where id=".$id;
			$sql2 = "insert into xcb_reward_log(user_id,time,type,from_user_id,base_num,num,msg) values(".$user_id.','.$time.','.$type.','.$from_user_id.','.$base_num.','.$num.','.$msg.")";
			$sql3 = "delete from ".DB_PREFIX."cart where cart_id=".$item;
			$res = mysql_query($sql);
			$res1 = mysql_query($sql1);
			$res2 = mysql_query($sql2);
			$res3 = mysql_query($sql3);
		
			if(!($res && $res1 && $res2 && $res3))
			{
				$success = false;
			}
		}
		$total_sps = round($total_sps,2);
		$sql = "insert into ".DB_PREFIX."sc_list(user_id,time,sc_num,remaining_num) values(".$id.','.time().','.$total_sps.','.$total_sps.")";
		$res = mysql_query($sql);

		if($success && $res)
		{
			mysql_query("COMMIT");
			mysql_query("END");
			$result = array("status" => true,"msg" => "付款成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "付款失败！");
			echo json_encode($result);
		}
	}
}

?>
