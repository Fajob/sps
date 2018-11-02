<?php
	function check_upgrade()
	{
		$sql = "select * from ".DB_PREFIX."conf_argument where id=1";
		
		$conf_argument =$GLOBALS['db']->getRow($sql);

		$proxy_1_consume_min = $conf_argument['proxy_1_consume_min'];
		$proxy_1_direct_min = $conf_argument['proxy_1_direct_min'];
		$proxy_1_direct_consume_min = $conf_argument['proxy_1_direct_consume_min'];
		
		$proxy_2_consume_min = $conf_argument['proxy_2_consume_min'];
		$proxy_2_direct_min = $conf_argument['proxy_2_direct_min'];
		$proxy_2_proxy1__min= $conf_argument['proxy_2_proxy1__min'];

		$proxy_3_consume_min = $conf_argument['proxy_3_consume_min'];
		$proxy_3_direct_min = $conf_argument['proxy_3_direct_min'];
		$proxy_3_proxy2__min = $conf_argument['proxy_3_proxy2__min'];
		
		$user_info = $GLOBALS['user_info'];
		$user_level = $user_info['user_level'];

		$total_conusme = get_rainbow_consume($user_info["phone_number"]);

		$direct_user_1 = get_ngeneration_user($user_info["phone_number"],1);
		#var_dump($direct_user_1);

		$direct_user_1_num = count($direct_user_1);

		$proxy_1_user_num = 0;
		$proxy_2_user_num = 0;
		$proxy_consume_1_num = 0; #大于proxy_1_consume_min 的直推下线数目
		foreach($direct_user_1 as $item)
		{
			$sql = "select * from ".DB_PREFIX."user where phone_number=".$item;
			$user_detail = $GLOBALS['db']->getRow($sql);
			$user_phone_number = $user_detail['phone_number'];
			if(get_proxy_1_num($user_phone_number) > 0)
				$proxy_1_user_num ++;
			if(get_proxy_2_num($user_phone_number) > 0)
				$proxy_2_user_num ++;
			if(get_rainbow_consume($user_phone_number) > $proxy_1_direct_consume_min)
				$proxy_consume_1_num ++;
		}

		#echo "  proxy_1_consume_min : ".$proxy_1_consume_min;
		#echo "  proxy_1_direct_min : ".$proxy_1_direct_min;
		#echo "  proxy_1_direct_consume_min : ".$proxy_1_direct_consume_min;
		#echo "  proxy_2_consume_min : ".$proxy_2_consume_min;
		#echo "  proxy_2_direct_min : ".$proxy_2_direct_min;
		#echo "  proxy_2_proxy1__min : ".$proxy_2_proxy1__min;
		#echo "  proxy_3_consume_min : ".$proxy_3_consume_min;
		#echo "  proxy_3_direct_min : ".$proxy_3_direct_min;
		#echo "  proxy_3_proxy2__min : ".$proxy_3_proxy2__min;
		#echo "  total_conusme : ".$total_conusme;
		#echo "  proxy_1_user_num : ".$proxy_1_user_num;
		#echo "  proxy_2_user_num : ".$proxy_2_user_num;
		#echo "  proxy_consume_1_num : ".$proxy_consume_1_num;

		$should_upgrade = false;
		if($user_level == 3)
		{
			#已经是最高级，不用再升
			#exit(0);
		}
		if($user_level == 0)
		{
			if($proxy_consume_1_num >= $proxy_1_direct_min && $total_conusme >= $proxy_1_consume_min)
				$should_upgrade = true;
			
		}
		if($user_level == 1)
		{
			if($proxy_1_user_num >= $proxy_2_proxy1__min && $total_conusme >= $proxy_2_consume_min)
				$should_upgrade = true;
		
		}

		if($user_level == 2)
		{
			if($proxy_2_user_num >= $proxy_3_proxy2__min && $total_conusme >= $proxy_3_consume_min)
				$should_upgrade = true;
				
		}
		if($should_upgrade)
		{
			$sql = "update ".DB_PREFIX."user set user_level=user_level+1 where id=".$GLOBALS['user_info']['id'];
			if($GLOBALS['db']->query($sql))
			{
				$access_log_msg = date("Y-m-d h:i:s ").$GLOBALS['user_info']['id']."upgrade "."\n";
				file_put_contents(APP_RUN_LOG,$access_log_msg,FILE_APPEND);
			}
		}
	}


	
	#判断某个用户是： 1.普通节点   2.优质节点   3.极速节点   4.超级节点
	function get_node_type($user_info,$conf_var)
	{
		$node_1_coins_money = $conf_var['node_1_coins_money'];
		$node_2_coins_money = $conf_var['node_2_coins_money'];
		$node_3_coins_money = $conf_var['node_3_coins_money'];
		$node_4_coins_money = $conf_var['node_4_coins_money'];
		$total_coins =  $user_info['sc_chain'];
		$user_id = $user_info['id'];
		if($user_info['id'] == '') 
		{
			return 0;
		}
		$sql = "select * from ".DB_PREFIX."sc_list where user_id=".$user_id;

		$sc_list = $GLOBALS['db']->getAll($sql);

		$sql = "select * from ".DB_PREFIX."order where user_id=".$user_id;
		$order_list = $GLOBALS['db']->getAll($sql);

		$total_consume = 0;
		foreach($sc_list as $item)
		{
			$price = get_coin_price_by_time($item['time']);
			$total_consume += $item['sc_num']*$price;
		}
		
		if($total_consume < $node_1_coins_money)
		{
			return 0;	
		}
		else if($total_consume < $node_2_coins_money)
		{
			return 1;	
		}
		else if($total_consume < $node_3_coins_money)
		{
			return 2;	
		}
		else if($total_consume < $node_4_coins_money)
		{
			return 3;	
		}
		else
		{
			return 4;	
		}
	}

	function get_coin_price_by_time($time)
	{
		$sql = "select * from ".DB_PREFIX."kline where date<".$time." order by id DESC limit 1";
		$price_var = $GLOBALS['db']->getRow($sql);
		$price = $price_var['price'];
		return $price;
	}

	#获取某个用户伞下的县代理个数，包括自己
	function get_proxy_1_num($phone_number)
	{
		$rainbow_user = array();
		get_rainbow_user($phone_number,$rainbow_user);
		$rainbow_user[] = $phone_number;
		$total_num = 0;
		foreach($rainbow_user as $item)
		{
			if($item == '') continue;
			$sql = "select * from xcb_user where phone_number=".$item;
			$res = $GLOBALS['db']->getRow($sql);
			if(!isset($res['id']))
			{
				continue;
			}
			$user_id = $res['id'];
			if($res['user_level'] == 1)
			{
				$total_num ++;
			}
		}
		return $total_num;
	}

	#获取某个用户下面市代理的个数，包括自己
	function get_proxy_2_num($phone_number)
	{
		$rainbow_user = array();
		get_rainbow_user($phone_number,$rainbow_user);
		$rainbow_user[] = $phone_number;
		$total_num = 0;
		foreach($rainbow_user as $item)
		{
			if($item == '') continue;
			$sql = "select * from xcb_user where phone_number=".$item;
			$res = $GLOBALS['db']->getRow($sql);
			if(!isset($res['id']))
			{
				continue;
			}
			$user_id = $res['id'];
			if($res['user_level'] == 2)
			{
				$total_num ++;
			}
		}
		return $total_num;
	}

	#判断id1 是id下面的多少代,如果不是id下面的用户，则返回0
	function get_generation_num($id,$id1)
	{
		$num = 0;
		while(1)
		{
			$sql = "select * from ".DB_PREFIX."user where id=".$id1;
			if($id1 == '')
			{
				return 0;
			}
			$user_deatil = $GLOBALS['db']->getRow($sql);
			if(isset($user_deatil['p_id']) && $user_deatil['p_id'] == $id)
			{
				$num++;
				return $num;
			}
			else if(isset($user_deatil['p_id']) && $user_deatil['p_id'] != $id)
			{
				$num++;
				$id1 = $user_deatil['p_id'];
			}
			else
			{
				return 0;
			}
		}
	}

	#根据手机号获取所有的伞下用户的手机号码
	function get_rainbow_user($phone_number,&$result)
	{
		if($phone_number == '') return 0;
		$sql = "select * from ".DB_PREFIX."direct_user where phone_number=".$phone_number;
		$res = $GLOBALS['db']->getAll($sql);
		foreach($res as $item)
		{
			$result[] = $item['d_phone_number'];
			get_rainbow_user($item['d_phone_number'],$result);
		}
	}

	#根据手机号获取下面$n代用户的手机号
	function get_ngeneration_user($phone_number,$n)
	{
		$result = array();
		if($phone_number == '') continue;
		$sql = "select * from xcb_direct_user where phone_number=".$phone_number;
		$gener_1_var = $GLOBALS['db']->getAll($sql);
		$gener_1 = array();
		foreach($gener_1_var as $item)
		{
			$gener_1[] = $item['d_phone_number'];
		}
		if($n <2)
		{
			return $gener_1;
		}
		$result = array_merge($result,$gener_1);
		$n--;
		while($n--)
		{
			$gener_i = array();
			foreach($gener_1 as $item1)	
			{
				if($item1 == '') continue;
				$sql = "select * from xcb_direct_user where phone_number=".$item1;
				$d_user_var = $GLOBALS['db']->getAll($sql);
				foreach($d_user_var as $item2)
				{
					$gener_i[] = $item2['d_phone_number'];
				}
			}
			$gener_1 = $gener_i;
			$result = array_merge($result,$gener_i);
		}
		return $result;
	}


	#获取某个用户的团队总投资额,包含该用户自己的业绩
	function get_rainbow_consume($phone_number)
	{
		$total_consume = 0;
		$rainbow_users = array();
		

		get_rainbow_user($phone_number,$rainbow_users);
		$rainbow_users[] = $phone_number;
		foreach($rainbow_users as $item)
		{
			if($item == '') continue;
			$sql = "select * from xcb_user where phone_number=".$item;
			$res = $GLOBALS['db']->getRow($sql);
			if(!isset($res['id']))
			{
				continue;
			}
			$user_id = $res['id'];
			$sql = "select * from xcb_order where user_id=".$user_id." and order_status!=0";

			$sql = "select * from ".DB_PREFIX."sc_list where user_id=".$user_id;
			$sc_list = $GLOBALS['db']->getAll($sql);
			foreach($sc_list as $item)
			{
				$price = get_coin_price_by_time($item['time']);
				$total_consume += $item['sc_num']*$price;
			}

			#$order_var = $GLOBALS['db']->getAll($sql);
			##var_dump($order_var);
			#foreach($order_var as $item1)
			#{
			#	$total_consume += $item1['total_price'];
			#}
		}
		return $total_consume;
	}
	#获取某个用户的团队总投资额,不包含该用户自己的业绩
	function get_rainbow_consume_1($phone_number)
	{
		$total_consume = 0;
		$rainbow_users = array();
		

		get_rainbow_user($phone_number,$rainbow_users);
		#$rainbow_users[] = $phone_number;
		foreach($rainbow_users as $item)
		{
			if($item == '') continue;
			$sql = "select * from xcb_user where phone_number=".$item;
			$res = $GLOBALS['db']->getRow($sql);
			if(!isset($res['id']))
			{
				continue;
			}
			$user_id = $res['id'];
			$sql = "select * from xcb_order where user_id=".$user_id." and order_status!=0";

			$sql = "select * from ".DB_PREFIX."sc_list where user_id=".$user_id;
			$sc_list = $GLOBALS['db']->getAll($sql);
			foreach($sc_list as $item)
			{
				$price = get_coin_price_by_time($item['time']);
				$total_consume += $item['sc_num']*$price;
			}

			#$order_var = $GLOBALS['db']->getAll($sql);
			##var_dump($order_var);
			#foreach($order_var as $item1)
			#{
			#	$total_consume += $item1['total_price'];
			#}
		}
		return $total_consume;
	}

	#取某个用户的团队当天的新增业绩
	function get_rainbow_consume_daily($phone_number)
	{
		$total_consume = 0;
		$today_time = strtotime(date("Y-m-d"));
		$rainbow_users = array();

		
		get_rainbow_user($phone_number,$rainbow_users);
		$rainbow_users[] = $phone_number;
		foreach($rainbow_users as $item)
		{
			if($item == '')
			{
				continue;
			}
			$sql = "select * from xcb_user where phone_number=".$item;
			$res = $GLOBALS['db']->getRow($sql);
			if(!isset($res['id']))
			{
				continue;
			}
			$user_id = $res['id'];
			#$sql = "select * from xcb_order where user_id=".$user_id." and order_status!=0 and create_time>".$today_time;
			#$order_var = $GLOBALS['db']->getAll($sql);
			#foreach($order_var as $item1)
			#{
			#	$total_consume += $item1['total_price'];
			#}
			$sql = "select * from ".DB_PREFIX."sc_list where user_id=".$user_id." and time>".$today_time;
			$sc_list = $GLOBALS['db']->getAll($sql);
			foreach($sc_list as $item)
			{
				$price = get_coin_price_by_time($item['time']);
				$total_consume += $item['sc_num']*$price;
			}
		}
		return $total_consume;
	}


	#根据user_info获取某个用户的持币量
	function get_own_coins($user_info)
	{
		$total_own_coins = $user_info['sc_chain'] + $user_info['cz_chain'];
		return $total_own_coins;
	}

	#根据user_info获取某个用户总共拿到多少静态收益
	function get_all_static_reward($user_info)
	{
		$all_static_reward = $user_info['static_reward'];
		return $all_static_reward;
	}

	#根据user_info 获取某个用户的锁仓的币
	function get_sc_coins($user_info)
	{
		$sc_chain = $user_info['sc_chain'];
		return $sc_chain;
	}
	function gen_return_sps($deal_id)
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

		$return_sps = $current_price/$current_sps_price;
		return $return_sps;
	}

?>
