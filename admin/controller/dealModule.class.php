<?php

class dealModule
{
	/*
	**展示所有商品,带筛选条件
	*/
	public function index()
	{
		$page_size = 20;
		#筛选条件，商品名
		$request_data = $GLOBALS['request_data'];
		$where = " ";
		if(isset($request_data['id']))
		{
			$id= $request_data['id'];
			$where = " where id=".'"'.$id.'"';
		}
		if(isset($request_data['deal_name']))
		{
			$deal_name = $request_data['deal_name'];
			$where = " where deal_name=".'"'.$deal_name.'"';
		}
		if(isset($request_data['type']))
		{
			$type = $request_data['type'];
			$where = " where type=".$type;
		}
		$start = 0;
		if(isset($request_data['p'])&& $request_data['p']>0)
		{
			$p = $request_data['p'];
			$start = ($p-1)*$page_size;
		}
		$limit = " limit ".$start.",".$page_size;
		$sql = "select * from ".DB_PREFIX."deal ".$where.$limit;
		$deals_info = $GLOBALS['db']->getAll($sql);	
		$new_deals_info = array();
		foreach($deals_info as $item)
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
			$new_deals_info[] = $new_item;
			
		}
		$sql = "select * from ".DB_PREFIX."deal_type";
		$type_info = $GLOBALS['db']->getAll($sql);

		$sql = "select count(*) from ".DB_PREFIX."deal ";
		$total_deal_count_var = $GLOBALS['db']->getRow($sql);
		$total_deal_count = $total_deal_count_var['count(*)'];
		$data = array('count' => count($new_deals_info),'deals_info' => $new_deals_info,'type_info' => $type_info);
		$GLOBALS['tmpl']->assign('data' , $data);
		$GLOBALS['tmpl']->assign('total_deal_count' , $total_deal_count);
		$GLOBALS['tmpl']->display("spgl/spgl.html");
		#echo json_encode($GLOBALS['tmpl']);
		
			
	}

	

	/*
	**添加商品信息
	*/
	public function do_add()
	{
		$request_data = $GLOBALS['request_data'];
		#参数检查
		if(!isset($request_data['deal_name']))
		{
			$result = array("status" => false,"msg" => "请输入商品名！");
			echo json_encode($result);
			exit(0);
		}
		$deal_name = $request_data['deal_name'];

		#参数验证
		
		#不需要更新的参数
		$except_var = array();
		$except_var[] = "ctl";
		$except_var[] = "act";
		$except_var[] = "deal_name";
		if(!isDealName($deal_name))
		{
			$result = array("status" => false,"msg" => "商品名不合法！");
			echo json_encode($result);
			exit(0);
		}
		#判断商品名是否占用
		$sql = "select * from ".DB_PREFIX."deal where deal_name=".'"'.$deal_name.'"';
		$result = $GLOBALS['db']->getAll($sql);
		if(count($result) > 0)
		{
			$result = array("status" => false,"msg" => "商品已存在！");
			echo json_encode($result);
			exit(0);
		}	
		#添加商品信息
		$sql = "insert into ".DB_PREFIX."deal(deal_name) values(".'"'.$deal_name.'"'.")";
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
		if(isset($request_data['img1']) && $request_data['img1'] != '')
		{
			$image = $request_data['img1'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img1'] = $image_path;
		}
		if($request_data['img1'] == '')
		{
			unset($request_data['img1']);
		}
		if(isset($request_data['img2']) && $request_data['img1'] != '')
		{
			$image = $request_data['img2'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img2'] = $image_path;
		}
		if($request_data['img2'] == '')
		{
			unset($request_data['img2']);
		}
		if(isset($request_data['img3']) && $request_data['img1'] != '')
		{
			$image = $request_data['img3'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img3'] = $image_path;
		}
		if($request_data['img3'] == '')
		{
			unset($request_data['img3']);
		}
		if($GLOBALS['db']->query($sql))
		{
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
				$sql = "update ".DB_PREFIX."deal set ".$key."=".$value." where deal_name=".'"'.$deal_name.'"';
				if(!$GLOBALS['db']->query($sql))
				{
					$msg = date("Y-m-d h:m:s ").json_encode($request_data).$GLOBALS['db']->error();
					file_put_contents(ERROR_LOG_PATH,$msg,FILE_APPEND);
					$result = array("status" => false,"msg"=> "系统更新异常！");
					echo json_encode($result);
					exit(0);
				}
			}
			$result = array("status" => true,"msg"=> "添加成功！");
			echo json_encode($result);
			exit(0);

		}
		$result = array("status" => false,"msg"=> "系统更新异常");
		echo json_encode($result);

		
	}




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
		
		#更新参数
		$sql = "select count(*) from ".DB_PREFIX."deal where id=".$id;
		$num_var = $GLOBALS['db']-> getRow($sql);
		$num = $num_var['count(*)'];
		if($num !=1)
		{
			$result = array("status" => false,"msg"=> "商品不存在！");
			echo json_encode($result);
			exit(0);
		}
		if(isset($request_data['img'])  && $request_data['img']!= '')
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
		if(isset($request_data['img1']) && $request_data['img1'] != '')
		{
			$image = $request_data['img1'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img1'] = $image_path;
		}
		if($request_data['img1'] == '')
		{
			unset($request_data['img1']);
		}
		if(isset($request_data['img2']) && $request_data['img2'] != '')
		{
			$image = $request_data['img2'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img2'] = $image_path;
		}
		if($request_data['img2'] == '')
		{
			unset($request_data['img2']);
		}
		if(isset($request_data['img3']) && $request_data['img3'] != '')
		{
			$image = $request_data['img3'];
			$path = "/public/images/";
			$image_path = save_base64_image($path,$image);
			$request_data['img3'] = $image_path;
		}
		if($request_data['img3'] == '')
		{
			unset($request_data['img3']);
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
			$sql = "update ".DB_PREFIX."deal set ".$key."=".$value." where id=".$id;
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
		$sql = "delete from ".DB_PREFIX."deal where id=".$id;
		if(!$GLOBALS['db']->query($sql))
		{
			$result = array("status" => false,"msg"=> "id错误");
			echo json_encode($result);
			exit(0);	
		}
		$result = array("status" => true,"msg" => "删除成功！");
		echo json_encode($result);
		exit(0);

	}
}

?>
