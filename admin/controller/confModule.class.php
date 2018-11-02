<?php

/*
**默认展示登陆页面
*/


class confModule 
{
	public function index()
	{		
		//$var_dump($GLOBALS['tmpl']);
		$GLOBALS['tmpl']->assign("title","this is an tmpl");
		$GLOBALS['tmpl']->assign("contents","12345678");
		$GLOBALS['tmpl']->display("index.html");
	}
	
	public function test()
	{
		$sql = "select count(*) from ".DB_PREFIX."user";
		$result = $GLOBALS['db']->getRow($sql);
		echo json_encode($result);
		echo $result['count(*)'];

	}


	############################## K线管理
	############################## K线管理
	############################## K线管理
	############################## K线管理
	public function kline()
	{
		$request_data = $GLOBALS['request_data'];
		$page_size = 10;
		if(!isset($request_data['p']))
		{
			$p=1;
		}
		else
		{
			$p= $request_data['p'];
		}
		$start = $page_size*($p-1);
		$limit = " limit ".$start.",".$page_size;
		$sql = "select * from ".DB_PREFIX."kline order by date DESC ".$limit;
		$kline_data = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."kline";
		$total_kline_count_var = $GLOBALS['db']->getRow($sql);
		$total_kline_count = $total_kline_count_var['count(*)'];

		$GLOBALS['tmpl']->assign("title","k线管理");
		$GLOBALS['tmpl']->assign('data', $kline_data);
		$GLOBALS['tmpl']->assign('total_kline_count', $total_kline_count);
		$GLOBALS['tmpl']->display("xtgl/xtgl_k.html");
		
	}

	#(1)添加k线行情
	public function do_add_kline()
	{
		$request_data = $GLOBALS['request_data'];
		$date = $request_data['date'];
		$price = $request_data['price'];
		if(!is_numeric($date) || !is_numeric($price))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "insert into ".DB_PREFIX."kline(date,price) values(".$date.','.$price.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "添加成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "添加失败");
			echo json_encode($result);
			exit(0);
		}
	}
	#(2)删除K线行情
	public function do_del_kline()
	{
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		if(!is_numeric($id))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "delete from ".DB_PREFIX."kline where id=".$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败");
			echo json_encode($result);
			exit(0);
		}
	}


	#(3)修改k线行情
	public function do_update_kline()
	{
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		$price = $request_data['price'];
		if(!is_numeric($price) || !is_numeric($id))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "update ".DB_PREFIX."kline set price=".$price." where id=".$id;
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
	############################## K线管理##############################
	############################## K线管理##############################
	############################## K线管理##############################
	############################## K线管理##############################


	############################## 公告管理 
	############################## 公告管理
	############################## 公告管理
	############################## 公告管理
	public function notice()
	{
		$request_data = $GLOBALS['request_data'];
		$page_size = 20;
		if(!isset($request_data['p']))
		{
			$p=1;
		}
		else
		{
			$p= $request_data['p'];
		}
		$start = $page_size*($p-1);
		$limit = " limit ".$start.",".$page_size;

		$sql = "select * from ".DB_PREFIX."notice order by date DESC".$limit;
		$kline_data = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."notice";
		$total_notice_count_var = $GLOBALS['db']->getRow($sql);
		$total_notice_count = $total_notice_count_var['count(*)'];

		$GLOBALS['tmpl']->assign("title","公告管理");
		$GLOBALS['tmpl']->assign('data', $kline_data);
		$GLOBALS['tmpl']->assign('total_notice_count', $total_notice_count);
		$GLOBALS['tmpl']->display("xtgl/xtgl_gg.html");
	}
	#(1)添加公告
	public function do_add_notice()
	{
		$request_data = $GLOBALS['request_data'];
		$date = time();
		$title = '"'.$request_data['title'].'"';
		$detail = '"'.$request_data['detail'].'"';

		$sql = "insert into ".DB_PREFIX."notice(date,title,detail) values(".$date.','.$title.','.$detail.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "添加成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "添加失败");
			echo json_encode($result);
			exit(0);
		}
	}
	#(2)删除公告
	public function do_del_notice()
	{
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		if(!is_numeric($id))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "delete from ".DB_PREFIX."notice where id=".$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败");
			echo json_encode($result);
			exit(0);
		}
	}


	public function do_update_notice()
	{
	
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		$title = '"'.$request_data['title'].'"';
		$detail = '"'.$request_data['detail'].'"';

		$sql = "update ".DB_PREFIX."notice set title=".$title.', detail='.$detail.' where id='.$id;
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
	

	############################## 公告管理############################## 
	############################## 公告管理##############################
	############################## 公告管理##############################
	############################## 公告管理##############################


	############################## 轮播图管理 
	############################## 轮播图管理 
	############################## 轮播图管理
	############################## 轮播图管理
	public function carousel()
	{
		$request_data = $GLOBALS['request_data'];
		$page_size = 20;
		if(!isset($request_data['p']))
		{
			$p=1;
		}
		else
		{
			$p= $request_data['p'];
		}
		$start = $page_size*($p-1);
		$limit = " limit ".$start.",".$page_size;

		
		$sql = "select * from ".DB_PREFIX."carousel".$limit;
		$kline_data = $GLOBALS['db']->getAll($sql);
		$new_data = array();
		foreach($kline_data as $item)
		{
			$new_item = array();
			foreach($item as $key => $value)
			{
				#if($key == "img")
				#{
				#	$image_path = ROOT_PATH.$value;
				#	$value = "data:image/png;base64,".base64_encode(file_get_contents($image_path));
				#}
				$new_item[$key] = $value;
			}
			$new_data[] = $new_item;
		}
		$GLOBALS['tmpl']->assign("title","轮播图管理");
		$GLOBALS['tmpl']->assign('data', $new_data);
		$GLOBALS['tmpl']->display("xtgl/xtgl_banner.html");
	}
	#(1)添加轮播
	public function do_add_carousel()
	{
		$request_data = $GLOBALS['request_data'];
		$id_index = $request_data['id_index'];
		$img = $request_data['img'];
		$link = $request_data['link'];
		if(!is_numeric($id_index))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		if(isset($request_data['img']))
		{
			$image = $request_data['img'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img'] = $image_path;
		}
			
		$sql = "insert into ".DB_PREFIX."carousel(id_index,img,link) values(".$id_index.',"'.$request_data['img'].'","'.$link.'"'.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "添加成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "添加失败");
			echo json_encode($result);
			exit(0);
		}
	}
	#(2)删除轮播
	public function do_del_carousel()
	{
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		if(!is_numeric($id))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "delete from ".DB_PREFIX."carousel where id=".$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败");
			echo json_encode($result);
			exit(0);
		}
	}

	#(3)修改轮播图
	public function do_update_carousel()
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
		
		#更新参数
		$sql = "select count(*) from ".DB_PREFIX."carousel where id=".$id;
		$num_var = $GLOBALS['db']-> getRow($sql);
		$num = $num_var['count(*)'];
		if($num !=1)
		{
			$result = array("status" => false,"msg"=> "公告不存在！");
			echo json_encode($result);
			exit(0);
		}
		if(isset($request_data['img']) && $request_data['img'] != '')
		{
			$image = $request_data['img'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img'] = $image_path;
		}	
		if($request_data['img'] == '')
		{
			unset($request_data['img']);
		}
		foreach($request_data as $key => $value)
		{
			if(in_array($key,$except_var))
			{
				continue;
			}
			if(!is_numeric($value))
			{
				$value = '"'.$value.'"';
			}
			$sql = "update ".DB_PREFIX."carousel set ".$key."=".$value." where id=".$id;
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
		exit(0);
	}

	############################## 轮播图管理############################## 
	############################## 轮播图管理##############################
	############################## 轮播图管理##############################
	############################## 轮播图管理##############################

	############################## 导航栏管理
	############################## 导航栏管理
	############################## 导航栏管理
	############################## 当行蓝管理
	public function navagation()
	{
		$sql = "select * from ".DB_PREFIX."navigation order by id_index asc";
		$data = $GLOBALS['db']->getAll($sql);
		$new_data = array();
		foreach($data as $item)
		{
			$new_item = array();
			foreach($item as $key => $value)
			{
				#if($key == "img")
				#{
				#	$image_path = ROOT_PATH.$value;
				#	$value = "data:image/png;base64,".base64_encode(file_get_contents($image_path));
				#}
				$new_item[$key] = $value;
			}
			$new_data[] = $new_item;
		}
		$GLOBALS['tmpl']->assign("title","导航栏管理");
		$GLOBALS['tmpl']->assign('data', $new_data);
		$GLOBALS['tmpl']->display("xtgl/xtgl_dh.html");
		#echo json_encode($new_data);
	}
	#(1)添加导航
	public function do_add_navigation()
	{
		$request_data = $GLOBALS['request_data'];
		$id_index = $request_data['id_index'];
		$img = $request_data['img'];
		$link = $request_data['link'];
		$name = $request_data['name'];
		if(!is_numeric($id_index))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		if(isset($request_data['img']))
		{
			$image = $request_data['img'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img'] = $image_path;
		}
			
		$sql = "insert into ".DB_PREFIX."navigation(id_index,name,img,link) values(".$id_index.',"'.$name.'","'.$image_path.'","'.$link.'"'.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "添加成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "添加失败");
			echo json_encode($result);
			exit(0);
		}
	}
	#(2)删除导航栏
	public function do_del_navigation()
	{
		$request_data = $GLOBALS['request_data'];
		$id = $request_data['id'];
		if(!is_numeric($id))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$sql = "delete from ".DB_PREFIX."navigation where id=".$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "删除失败");
			echo json_encode($result);
			exit(0);
		}
	}

	#(3)修改导航栏
	public function do_update_navigation()
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
		
		#更新参数
		$sql = "select count(*) from ".DB_PREFIX."navigation where id=".$id;
		$num_var = $GLOBALS['db']-> getRow($sql);
		$num = $num_var['count(*)'];
		if($num !=1)
		{
			$result = array("status" => false,"msg"=> "导航栏不存在！");
			echo json_encode($result);
			exit(0);
		}
		if(isset($request_data['img']) && $request_data['img'] != '')
		{
			$image = $request_data['img'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img'] = $image_path;
		}	
		if($request_data['img'] == '')
		{
			unset($request_data['img']);
		}
		foreach($request_data as $key => $value)
		{
			if(in_array($key,$except_var))
			{
				continue;
			}
			if(!is_numeric($value))
			{
				$value = '"'.$value.'"';
			}
			$sql = "update ".DB_PREFIX."navigation set ".$key."=".$value." where id=".$id;
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
		exit(0);
	}

	
	############################## 导航栏管理############################## 
	############################## 导航栏管理##############################
	############################## 导航栏管理##############################
	############################## 当行蓝管理##############################


	############################## 参数管理
	############################## 参数管理
	############################## 参数管理
	############################## 参数管理

	public function argument()
	{
		$sql = "select * from ".DB_PREFIX."conf_argument where id=1";
		$argument = $GLOBALS['db']->getRow($sql);
		$GLOBALS['tmpl']->assign("title","参数管理");
		$GLOBALS['tmpl']->assign('data', $argument);
		$GLOBALS['tmpl']->display("xtgl/xtgl_cs.html");
		#echo json_encode($GLOBALS['tmpl']);
	}

	public function do_update_argument()
	{
		$request_data = $GLOBALS['request_data'];
		#参数检查
		$except_var = array();
		$except_var[] = "ctl";
		$except_var[] = "act";
		$except_var[] = "id";
		$id=1;
		
		#更新参数
		if(isset($request_data['img']) && $request_data['img'] != '')
		{
			$image = $request_data['img'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img'] = $image_path;
		}	
		if($request_data['img'] == '')
		{
			unset($request_data['img']);
		}

		foreach($request_data as $key => $value)
		{
			if(in_array($key,$except_var))
			{
				continue;
			}
			if(!is_numeric($value))
			{
				$value = '"'.$value.'"';
			}
			$sql = "update ".DB_PREFIX."conf_argument set ".$key."=".$value." where id=".$id;
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
		exit(0);
	}
		

	############################## 参数管理############################## 
	############################## 参数管理##############################
	############################## 参数管理##############################
	############################## 参数管理##############################


	public function share()
	{
		$sql = "select * from ".DB_PREFIX."conf_share";
		$share = $GLOBALS['db']->getAll($sql);
		$GLOBALS['tmpl']->assign("title","分享管理");
		$GLOBALS['tmpl']->assign('data', $share);
		$GLOBALS['tmpl']->display("xtgl/xtgl_share.html");
		#echo json_encode($GLOBALS['tmpl']);
	
	
	}

	public function do_update_share()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']))
		{
			$result = array("status" => false,"msg" => "参数异常");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$success = true;
		if(isset($request_data['img']) && $request_data['img'] != '')
		{
			$image = $request_data['img'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img'] = $image_path;
			$sql = "update ".DB_PREFIX."conf_share set img=".'"'.$request_data['img'].'"'." where id=".$id;
			if(!$GLOBALS['db']->query($sql))
			{
				$success = false;
			}
		}	
		if($request_data['img'] == '')
		{
			unset($request_data['img']);
		}
		if(isset($request_data['link']))
		{
			$sql = "update ".DB_PREFIX."conf_share set link=".'"'.$request_data['link'].'"'." where id=".$id;
			if(!$GLOBALS['db']->query($sql))
			{
				$success = false;
			}
		}
		if($success)
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
	




}

?>

