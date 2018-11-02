<?php
class userModule
{

	/*
	**展示会员详细列表,带筛选条件
	*/
	public function index()
	{
		$request_data = $GLOBALS['request_data'];
		#参数检查
		if(isset($request_data['p']) &&( $request_data['p'] < 0  || !is_numeric($request_data['p'])))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}

		$page_size = 10;
		$request_data = $GLOBALS['request_data'];
		$where = " where 1=1 ";
		if(isset($request_data['id']) && $request_data['id'] != NULL)	
		{
			$id = $request_data['id'];
			$where .= " and id=".$id;
		}				
		if(isset($request_data['user_name']) && $request_data['user_name'] != NULL)
		{
			$user_name = $request_data['user_name'];
			$where .= " and user_name=".'"'.$user_name.'"';
		}
		if(isset($request_data['phone_number']) && $request_data['phone_number'] != NULL)
		{
			$phone_number = $request_data['phone_number'];
			$where .= " and phone_number=".$phone_number;
		}
		if(isset($request_data['p_id']) && $request_data['p_id'] != NULL)
		{
			$p_id = $request_data['p_id'];
			$where .= " and p_id=".$p_id;
		}
		$start = 0;
		if(isset($request_data['p']))
		{
			$p = $request_data['p'];
			$start = ($p-1)*$page_size;
		}
		$limit = " limit ".$start.",".$page_size;
		$sql = "select * from ".DB_PREFIX."user ".$where.$limit;
		#echo $sql;
		$users_info = $GLOBALS['db']->getAll($sql);
		$sql = "select count(*) from ".DB_PREFIX."user ".$where;
		$result = $GLOBALS['db']->getRow($sql);
		$total_user_count = $result['count(*)'];
		$page_num = $total_user_count/$page_size + 1;

		$data = array('count' => count($users_info),'users_info' => $users_info);
		$GLOBALS['tmpl']->assign("title","会员管理");
		$GLOBALS['tmpl']->assign('page_num',$page_num);
		$GLOBALS['tmpl']->assign('total_user_count',$total_user_count);
		$GLOBALS['tmpl']->assign('data', $data);
		$GLOBALS['tmpl']->display("hygl/hygl.html");
		#echo json_encode($GLOBALS['tmpl']);
		
	}

	/*
	**展示会员编辑页面信息
	*/
	public function edit()
	{

	}

	
	/*
	**更新会员信息接口
	*/
	public function do_update()
	{
		$request_data = $GLOBALS['request_data'];

		#参数检查
		if(!isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数异常！");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];


		#不需要更新的参数
		$except_var = array();
		$except_var[] = "ctl";
		$except_var[] = "act";
		$except_var[] = "id";
		
		$sql = "select * from ".DB_PREFIX."user where id=".$id;
		$user_detail = $GLOBALS['db']->getRow($sql);

		#更新参数
		foreach($request_data as $key => $value)
		{
			if(in_array($key,$except_var))
			{
				continue;
			}
			if(!is_null($value) && $key != "user_pwd")
			{
					$value = '"'.$value.'"';
			}
			if($key == "user_pwd")
			{
				$value = '"'.md5($value).'"';
			}
			$sql = "update ".DB_PREFIX."user set ".$key."=".$value." where id=".$id;
			if(!$GLOBALS['db']->query($sql))
			{
				$msg = date("Y-m-d h:m:s ").json_encode($request_data).$GLOBALS['db']->error();
				file_put_contents(ERROR_LOG_PATH,$msg,FILE_APPEND);
				$result = array("status" => false,"msg"=> "系统更新异常！");
				echo json_encode($result);
				exit(0);
			}
		}	
		$result = array("status" => true,"msg"=> "更新成功！");
		echo json_encode($result);

		$msg = array();
		$msg[] = "更新用户信息";
		if($user_detail['consume_credits'] != $request_data['consume_credits'])
		{
			$msg[] = "更新".$id."购物积分".$user_detail['consume_credits']."->".$request_data['consume_credits'];
		}
		if($user_detail['cz_chain'] != $request_data['cz_chain'])
		{
			$msg[] = "更新".$id."可用sps链".$user_detail['cz_chain']."->".$request_data['cz_chain'];
		}
		if($user_detail['sc_chain'] != $request_data['sc_chain'])
		{
			$msg[] = "更新".$id."锁仓sps链".$user_detail['sc_chain']."->".$request_data['sc_chain'];
		}
		if($user_detail['static_reward'] != $request_data['static_reward'])
		{
			$msg[] = "更新".$id."持币算力".$user_detail['static_reward']."->".$request_data['static_reward'];
		}
		if($user_detail['dynamic_reward'] != $request_data['dynamic_reward'])
		{
			$msg[] = "更新".$id."分享算力".$user_detail['dynamic_reward']."->".$request_data['dynamic_reward'];
		}
		if($user_detail['p_rate'] != $request_data['p_rate'])
		{
			$msg[] = "更新".$id."趴点".$user_detail['p_rate']."->".$request_data['p_rate'];
		}
		$msg =  json_encode($msg);
		$func = "do_update";

		save_log($func,$msg);
		
		exit(0);
	}

	/*
	**添加会员接口	
	*/
	public function do_add()
	{
		$request_data = $GLOBALS['request_data'];

		$user_name = $request_data['user_name'];
		#参数检查，格式检查
		if(!isName($user_name))
		{
			$result = array("status" => false,"msg" => "会员名格式错误！");
			echo json_encode($result);
			exit(0);
		}	
				
		
		#不需要更新的参数
		$except_var = array();
		$except_var[] = "ctl";
		$except_var[] = "act";
		$except_var[] = "user_name";
		
		#判断用户名是否占用
		$sql = "select * from ".DB_PREFIX."user where user_name=".'"'.$user_name.'"';
		$result = $GLOBALS['db']->getAll($sql);
		if(count($result) > 0)
		{
			$result = array("status" => false,"msg" => "会员名已存在！");
			echo json_encode($result);
			exit(0);
			
		}

		
		#添加用户信息
		$sql = "insert into ".DB_PREFIX."user(user_name) values(".'"'.$user_name.'"'.")";
		if($GLOBALS['db']->query($sql))
		{
			foreach($request_data as $key => $value)
			{
				if(in_array($key,$except_var))
				{
					continue;
				}
				$sql = "update ".DB_PREFIX."user set ".$key."=".$value." where user_name=".'"'.$user_name.'"';
				if(!$GLOBALS['db']->query($sql))
				{
					$msg = date("Y-m-d h:m:s ").json_encode($request_data).$GLOBALS['db']->error();
					file_put_contents(ERROR_LOG_PATH,$msg,FILE_APPEND);
					$result = array("status" => false,"msg"=> "系统更新异常！");
					echo json_encode($result);
					exit(0);
				}
				$result = array("status" => true,"msg"=> "添加成功！");
				echo json_encode($result);
				$func = "do_add";
				$msg = array();
				$msg[] = "成功添加用户".$user_name;
				$msg = json_encode($msg);
				save_log($func,$msg);	
				exit(0);
				
			}
		
		}
		$result = array("status" => false,"msg"=> "系统更新异常！");
		echo json_encode($result);
		exit(0);
		
	}
	
	/*	
	**删除会员接口,目前只删除单独的会员信息，如果有多重上下级依赖关系，不会删除上下级依赖关系
	*/
	public function do_delete()
	{
		$request_data = $GLOBALS['request_data'];
		if(!(isset($request_data['id']) && is_numeric($request_data['id']) && $request_data['id'] > 0))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);
			
		}
		
		$id = $request_data['id'];
		$sql = "delete from ".DB_PREFIX."user where id=".$id;
		if(!$GLOBALS['db']->query($sql))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);	
		}
		$result = array("status" => true,"msg" => "删除成功！");
		echo json_encode($result);
		$func = "do_delete";
		$msg = array();
		$msg[] = "成功删除用户".$id;
		$msg = json_encode($msg);
		save_log($func,$msg);
		exit(0);
		
	}

	public function do_export()
	{
		$sql = "select * from ".DB_PREFIX."user";
		$sql1 = "select COLUMN_NAME,column_comment from INFORMATION_SCHEMA.Columns where table_name='xcb_user' and table_schema='xcb'";
		$result = $GLOBALS['db']->getAll($sql);
		$result1 = $GLOBALS['db']->getAll($sql1);
		
		#echo json_encode($result1);
		#echo json_encode($result);
		$this->export_csv($result1,$result);

	}

	private	function export_csv($keys,$data)
	{
		$string="";
		foreach ($keys as $item) 
		{
			$string .= $item['COLUMN_NAME'].'('.$item['column_comment'].'),';
		}
		$string .="\n";
		foreach ($data as $key => $value) 
		{
			foreach ($value as $k => $val)
			{
				$value[$k]=iconv('utf-8','gb2312',$value[$k]);
			}
			$string .= implode(",",$value)."\n"; //用英文逗号分开 
		}
		$filename = date('Ymd').'.csv'; //设置文件名
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $string; 
	}
}



?>
