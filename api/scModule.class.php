<?php
class scModule
{
	private $page_num;

	public function __construct(){
		$page_num = 10;
	}


	# 用户锁仓
	public function do_sc()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		if(!isset($request_data['id']) || !isset($request_data['user_pwd']) || !isset($request_data['num']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			exit(0);
		}
		$id = $request_data['id'];
		$user_pwd = $request_data['user_pwd'];
		$num = $request_data['num'];

		if(!is_numeric($num) || $num < 0.00001 || $num > $user_info['cz_chain'])
		{
			$result = array("status" => false,"msg" => "锁仓数目有误");
			echo json_encode($result);
			exit(0);
		}


		if(md5($user_pwd) != $user_info['user_pwd_trade'])
		{
			$result = array("status" => false,"msg" => "交易密码有误");
			echo json_encode($result);
			exit(0);
		}

		$sql = "update ".DB_PREFIX."user set sc_chain=sc_chain+".$num.",cz_chain=cz_chain-".$num." where id=".$id;
		$sql1 = "insert into ".DB_PREFIX."sc_list(user_id,time,sc_num,remaining_num) values(".$id.','.time().','.$num.','.$num.")";
		mysql_query("set autocommit=0");
		mysql_query("START TRANSACTION");
		$res = mysql_query($sql);
		$res1 = mysql_query($sql1);
		if($res && $res1)
		{
			mysql_query("COMMIT");
			$result = array("status" => true,"msg" => "锁仓成功！");
			echo json_encode($result);
		}
		else
		{
			mysql_query("ROLLBACK");
			$result = array("status" => false,"msg" => "锁仓失败！");
			echo json_encode($result);
		}
		mysql_query("END");
		exit(0);

	}

	# 获取锁仓记录，分页展示
	public function get_sc_list()
	{
		$user_info = $GLOBALS['user_info'];
		$page_num = 10;
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['p']))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$p = $request_data['p'];
		if(!is_numeric($p) || $p<1)
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$page_size = 10;

		$limit = " limit ".($p-1)*($page_size).",".$page_size;
		$sql = "select * from ".DB_PREFIX."sc_list where user_id=".$request_data['id']." and remaining_num>0 order by time asc ".$limit;	
		
		$data = $GLOBALS['db']->getAll($sql);
		$sql = "select count(*) from ".DB_PREFIX."sc_list where user_id=".$request_data['id']." and remaining_num>0";
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_pages = intval($count_var['count(*)']/$page_size + 1);

		$sql = "select sum(sc_num) as total_num from ".DB_PREFIX."sc_list where user_id=".$request_data['id'];
		$total_num_var = $GLOBALS['db']->getRow($sql);
		$total_num = round($total_num_var['total_num'],2);


		$data1 = array("p" => $p,"total_pages" => $total_pages,'data' => $data,"user_info" => $user_info,"total_num" => $total_num);
		$result = array("status" => true,"msg"=> "获取成功","data" => $data1);
		echo json_encode($result);
		exit(0);
	}
	# 获取消费获取sps记录，分页展示
	public function get_consume_sps_list()
	{
		$user_info = $GLOBALS['user_info'];
		$page_num = 10;
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['p']))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$p = $request_data['p'];
		if(!is_numeric($p) || $p<1)
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$page_size = 10;

		
		$limit = " limit ".($p-1)*($page_size).",".$page_size;
		$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".'"consume"'." order by time asc ".$limit;	
		
		$data = $GLOBALS['db']->getAll($sql);
		$sql = "select count(*) from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and  type=".'"consume"';
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_pages = intval($count_var['count(*)']/$page_size + 1);

		$sql = "select sum(num) as total_sps from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and  type=".'"consume"';
		$total_sps_var = $GLOBALS['db']->getRow($sql);
		$total_sps = round($total_sps_var['total_sps'],2);

		$data1 = array("p" => $p,"total_pages" => $total_pages,'data' => $data,"user_info" => $user_info,"total_sps" => $total_sps);
		$result = array("status" => true,"msg"=> "获取成功","data" => $data1);
		echo json_encode($result);
		exit(0);
	}

	# 获取静态收益记录,分页展示
	public function get_static_reward_list()
	{
		$page_num = 10;
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['p']))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$p = $request_data['p'];
		if(!is_numeric($p) || $p<1)
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}

		$limit = " limit ".($p-1)*$page_num.",".$page_num;

		$type = '"static"';
		$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".$type." order by time desc".$limit;	
		$data = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".$type;
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_page = $count_var['count(*)']/$page_num + 1;
		$data1 = array("p" => $p,"total_pages" => $total_page,'data' => $data);


		$result = array("status" => true,"msg"=> "获取成功","data" => $data1,"user_info" => $user_info);
		echo json_encode($result);
		exit(0);
	}

	# 获取动态收益记录
	public function get_dynamic_reward_list()
	{
		$page_num = 10;
		$user_info = $GLOBALS['user_info'];
		$page_num = 10;
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['p']))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$p = $request_data['p'];
		if(!is_numeric($p) || $p<1)
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}

		$limit = " limit ".($p-1)*$page_num.",".$page_num;
		$type = '"dynamic"';
		$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".$type." order by time desc".$limit;	
		
		$data = $GLOBALS['db']->getAll($sql);


		$sql = "select count(*) from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".$type;
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_page = intval($count_var['count(*)']/$page_num + 1);
		$data1 = array("p" => $p,"total_pages" => $total_page,'data' => $data);
		$result = array("status" => true,"msg"=> "获取成功","data" => $data1,"user_info" => $user_info);
		echo json_encode($result);
		exit(0);
	}


	# 获取返现记录
	public function get_reback_list()
	{
		$page_num = 10;
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['p']))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$p = $request_data['p'];
		if(!is_numeric($p) || $p<1)
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}

		$limit = " limit ".($p-1)*$page_num.",".$page_num;
		$type = '"reback"';
		$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".$type." order by time desc".$limit;	
		
		$data = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."reward_log where user_id=".$request_data['id']." and type=".$type;
		$count_var = $GLOBALS['db']->getRow($sql);
		$total_page = $count_var['count(*)']/$page_num + 1;
		$data1 = array("p" => $p,"total_pages" => $total_page,'data' => $data);
		$result = array("status" => true,"msg"=> "获取成功","data" => $data1,"user_info" => $user_info);
		echo json_encode($result);
		exit(0);
	}

	# 获取用户当日总收益
	public function get_daily_total_reward()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];

		$time = strtotime(date("Y-m-d"));
		$sql = "select * from ".DB_PREFIX."reward_log where time>".$time.' and  user_id='.$id.' and (type="static" or type="dynamic")';
		$reward_list = $GLOBALS['db']->getAll($sql);
		$daily_total_reward = 0;
		foreach($reward_list as $item)
		{
			$daily_total_reward += $item['num'];
		}
		$result = array("status"=> true,"total_reward" => $daily_total_reward);
		echo json_encode($result);
	}


}


?>
