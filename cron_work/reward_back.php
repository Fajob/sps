<?php
if(!defined('ROOT_PATH')) {
        # 网站URL根目录
        $_root = dirname(__FILE__); 
        define('ROOT_PATH', $_root  );
}
#定义全局变量
require_once ROOT_PATH."/../common/common.php";
require_once ROOT_PATH."/../common/local_common.php";
require_once ROOT_PATH."/../api/api_common.php";

require_once ROOT_PATH."/../common/db/mysql_cls.php";
$dbcfg = require ROOT_PATH."/../conf/db_config.php";
define("DB_PREFIX",$dbcfg['DB_PREFIX']);
$pconnect = false;
global $db;
$db = new cls_mysql();
$db->connect($dbcfg['DB_HOST'],$dbcfg['DB_USER'],$dbcfg['DB_PWD'],$dbcfg['DB_NAME'],$dbcfg['DB_CHARACTER']);

$sql = "select * from xcb_conf_argument where id=1";
$conf_argument = $GLOBALS['db']->getRow($sql);
$static_rate = $conf_argument['static_rate'];


#本金释放相关
$sc_days = $conf_argument['sc_days'];
$sc_release_days = $conf_argument['sc_release_days'];
$sc_release_rate = $conf_argument['sc_release_rate'];

$start = 0;
$page_num = 100;
if(isset($_GET['n_day']))
	$n_day = $_GET['n_day'];
else
	$n_day = 0;

while(1)
{
	$sql = "select * from xcb_user where is_valid=1 order by id asc limit ".$start.",".$page_num;
	$user_var = $GLOBALS['db']->getAll($sql);
	if(count($user_var) == 0)
	{
		break;
	}
	$start += count($user_var);
	foreach($user_var as $item)
	{
		# 1.静态收益
		if($item['sc_chain'] > 0)
		{
			#获取静态收益，每天千分之1到千分之1.7,$static_rate
			$user_id = $item['id'];
			$time = strtotime(date("Y-m-d",strtotime("+$n_day day")));
			$type = '"static"';
			$from_user_id = $user_id;
			$base_num = $item['sc_chain'];
			$static_reward = round($base_num * $static_rate,2);
			$num = $static_reward;
			$msg ='"您获取'.$num.'静态收益"';

			#判断当天是否已经返还，如果返还就不在返还
			$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$user_id." and time=".$time." and type=".$type;
			$sql_var = $GLOBALS['db']->getAll($sql);
			#echo count($sql_var);
			if(count($sql_var) > 0)
			{
				$log = date("Y-m-d H:i:s ",$time).$user_id." 在今天已经有静态返还，不再返还\n";
				$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
				file_put_contents($path,$log,FILE_APPEND);
			}
			else
			{


				$sql = "insert into xcb_reward_log(user_id,time,type,from_user_id,base_num,num,msg) values(".$user_id.','.$time.','.$type.','.$from_user_id.','.$base_num.','.$num.','.$msg.")";
				$sql1 = "update xcb_user set cz_chain=cz_chain+".$num.", static_reward=static_reward+".$num."  where id=".$item['id'];

				if(!$GLOBALS['db']->query($sql))
				{
					$log = date("Y-m-d H:i:s ",$time).$sql."    exe error!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
				else
				{
					$log = date("Y-m-d H:i:s ",$time).$sql."    exe success!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}

				if(!$GLOBALS['db']->query($sql1))
				{
					$log = date("Y-m-d H:i:s ",$time).$sql1."    exe error!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
				else
				{
					$log = date("Y-m-d H:i:s ",$time).$sql1."    exe success!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
			}
		}
		else
		{
			$log = date("Y-m-d H:i:s ",$time).$item['id']." 无锁仓无静态收益\n";
			$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
			file_put_contents($path,$log,FILE_APPEND);
		}

		# 2.动态收益
		$node_type = get_node_type($item,$conf_argument);
		if($node_type != 0)
		{
			echo $node_type." ";
			switch($node_type)
			{
				case 1:
					$n = $conf_argument['node_1_get_generations'];
				break;
				case 2:
					$n = $conf_argument['node_2_get_generations'];
				break;
				case 3:
					$n = $conf_argument['node_3_get_generations'];
				break;
				case 4:
					$n = $conf_argument['node_4_get_generations'];
				break;
				default:
					$n = 0;
				break;
			}
			echo $item['phone_number']." ".$n."\n";
			$users_phone = get_ngeneration_user($item['phone_number'],$n);
			var_dump($users_phone);
			foreach($users_phone as $item1)
			{
				$sql = "select * from xcb_user where phone_number=".$item1;
				$item1_info = $GLOBALS['db']->getRow($sql);
				$gen_num = get_generation_num($item['id'],$item1_info['id']);
				$num = $gen_num;
				if($num <= $conf_argument['dynamic_generation_1'] )
				{
					$dynamic_rate = $conf_argument['dynamic_rate_1'];
				}
				else if($num <= $conf_argument['dynamic_generation_2'])
				{
					$dynamic_rate = $conf_argument['dynamic_rate_2'];
				}
				else
				{
					continue;
				}
				if($item1_info['sc_chain'] > 0)
				{
					$user_id = $item['id'];
					$time = strtotime(date("Y-m-d",strtotime("+$n_day day")));
					$type = '"dynamic"';
					$from_user_id = $item1_info['id'];
					$static_reward = round($item1_info['sc_chain']*$static_rate,2);
					$dynamic_reward = round($static_reward*$dynamic_rate,2);
					$num = $dynamic_reward;
	
					#判断该用户是否拿到对应的下线的当天的动态收益
					$sql = "select * from ".DB_PREFIX."reward_log where user_id=".$user_id." and from_user_id=".$from_user_id." and type=".$type." and time=".$time;
					$sql_var = $GLOBALS['db']->getAll($sql);
					if(count($sql_var) > 0)
					{
						$log = date("Y-m-d H:i:s ",$time).$user_id." 在今天已经有拿到用户".$from_user_id."的动态收益，不再返还\n";
						$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
						file_put_contents($path,$log,FILE_APPEND);
						continue;
					
					}
	
					$msg ='"'.$item1_info['user_name'].'获得'.$static_reward.'静态收益,您获取'.$num.'动态收益"';
					$sql = "insert into xcb_reward_log(user_id,time,type,from_user_id,base_num,num,msg) values(".$user_id.','.$time.','.$type.','.$from_user_id.','.$static_reward.','.$num.','.$msg.")";
	
					$sql1 = "update xcb_user set cz_chain=cz_chain+".$num.", dynamic_reward=dynamic_reward+".$num."  where id=".$item['id'];
					if(!$GLOBALS['db']->query($sql))
					{
						$log = date("Y-m-d H:i:s ",$time).$sql."    exe error!\n";
						$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
						file_put_contents($path,$log,FILE_APPEND);
					}
					else
					{
						$log = date("Y-m-d H:i:s ",$time).$sql."    exe success!\n";
						$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
						file_put_contents($path,$log,FILE_APPEND);
					}
	
					if(!$GLOBALS['db']->query($sql1))
					{
						$log = date("Y-m-d H:i:s ",$time).$sql1."    exe error!\n";
						$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
						file_put_contents($path,$log,FILE_APPEND);
					}
					else
					{
						$log = date("Y-m-d H:i:s ",$time).$sql1."    exe success!\n";
						$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
						file_put_contents($path,$log,FILE_APPEND);
					}
				}
			}
		}

		# 3. 本金返回
		if($item['sc_chain'] <= 0.0001)
		{
			$log = date("Y-m-d H:i:s ",$time).$item['id']." 无锁仓无本金返还\n";
			$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
			file_put_contents($path,$log,FILE_APPEND);
		}
		else
		{
		
			$sql = "select * from ".DB_PREFIX."sc_list where user_id=".$item['id'];
			$sc_list = $GLOBALS['db']->getAll($sql);

			foreach($sc_list as $item1)
			{
				$c_time = $item1['time'];

				#锁仓期未到
				$time = strtotime(date("Y-m-d",strtotime("+$n_day day")));
				if($time - $c_time < $sc_days * 24*3600)
				{
					continue;
				}

				$last_release_time = isset($item1['last_release_time']) ? $item1['last_release_time'] : 0;

				#最近一个周期的已经释放
				if($time-$last_release_time< $sc_release_days*3600*24)
				{
					continue;	
				}
				
				$should_release = round($item1['remaining_num'] * $sc_release_rate,2);
				$sql = "update ".DB_PREFIX."user set cz_chain=cz_chain+".$should_release.",sc_chain=sc_chain-".$should_release." where id=".$item1['user_id'];
				$sql1 = "update ".DB_PREFIX."sc_list set remaining_num=remaining_num-".$should_release.",last_release_time=".$time." where user_id=".$item1['user_id']." and time=".$item1['time']." and sc_num=".$item1['sc_num']; 
				$type = '"reback"';

				$msg = '"本金返还"';
				$sql2 = "insert into xcb_reward_log(user_id,time,type,from_user_id,base_num,num,msg) values(".$user_id.','.$time.','.$type.','.$user_id.','.$item1['remaining_num'].','.$should_release.','.$msg.")";
				if(!$GLOBALS['db']->query($sql))
				{
					$log = date("Y-m-d H:i:s ",$time).$sql."    exe error!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
				else
				{
					$log = date("Y-m-d H:i:s ",$time).$sql."    exe success!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
	
				if(!$GLOBALS['db']->query($sql1))
				{
					$log = date("Y-m-d H:i:s ",$time).$sql1."    exe error!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
				else
				{
					$log = date("Y-m-d H:i:s ",$time).$sql1."    exe success!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
				if(!$GLOBALS['db']->query($sql2))
				{
					$log = date("Y-m-d H:i:s ",$time).$sql2."    exe error!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
				else
				{
					$log = date("Y-m-d H:i:s ",$time).$sql2."    exe success!\n";
					$path = "./log/".date("Y-m-d",$time)."_reward_back.log";
					file_put_contents($path,$log,FILE_APPEND);
				}
			}
		}
	}
}


#获取n天后的起始时间,n可为负数
function GetNdayTime($n)
{
	$c_time = time();
	$n_time = $c_time + $n*3600*24;
	$n_date = date("Y-m-d",$n_time);
	$n_start_time = strtotime($n_date);
	return $n_start_time;
}

?>
