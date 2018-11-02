<?php

class orderModule
{
	/*
	**展示所有订单信息，带筛选条件
	*/
	public function index()
	{
		$request_data =$GLOBALS['request_data'];
		#参数检查
		if(isset($request_data['p']) &&( $request_data['p'] < 0  || !is_numeric($request_data['p'])))
		{
			$result = array("status" => false,"msg" => "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$page_size = 10;
		#筛选条件，商品名,会员名，商品id，会员id，订单号，订单状态，发货状态
		$request_data = $GLOBALS['request_data'];
		$where = " where 1=1 ";
		if(isset($request_data['deal_name']) && $request_data['deal_name'] != NULL)
		{
			$deal_name = $request_data['deal_name'];
			$where .= " and  deal_name=".'"'.$deal_name.'"';
		}
		if(isset($request_data['user_name']) && $request_data['user_name'] != NULL)
		{
			$user_name = $request_data['deal_name'];
			$where .= " and  user_name=".'"'.$user_name.'"';
		}
		if(isset($request_data['deal_id']) && $request_data['deal_id'] != NULL)
		{
			$deal_id = $request_data['deal_id'];
			$where .= " and  deal_id=".$deal_id;
		}
		if(isset($request_data['user_id']) && $request_data['user_id'] != NULL)
		{
			$user_id = $request_data['user_id'];
			$where .= " and  user_id=".$user_id;
		}
		if(isset($request_data['order_sn']) && $request_data['order_sn'] != NULL)
		{
			$order_sn = $request_data['order_sn'];
			$where .= " and  order_sn=".'"'.$order_sn.'"';
		}
		if(isset($request_data['order_status']) && $request_data['order_status'] != NULL)
		{
			$order_status = $request_data['order_status'];
			$where .= " and  order_status=".$order_status;
		}


		
		$start = 0;
		if(isset($request_data['p']))
		{
			$p = $request_data['p'];
			$start = ($p-1)*$page_size;
		}
		$limit = " limit ".$start.",".$page_size;
		$sql = "select * from ".DB_PREFIX."order ".$where.$limit;
		$orders_info = $GLOBALS['db']->getAll($sql);	
		$data = array('count' => count($orders_info),'orders_info' => $orders_info);

		$sql = "select count(*) from ".DB_PREFIX."order";
		$order_count_var = $GLOBALS['db']->getRow($sql);
		$order_count = $order_count_var['count(*)'];

		$GLOBALS['tmpl']->assign('data' ,  $data);
		$GLOBALS['tmpl']->assign('total_order_count' ,  $order_count);
		$GLOBALS['tmpl']->display("ddgl/ddgl.html");
		#var_dump($data);
				
	}
	
	/*
	**更新订单信息
	*/

	public function do_update()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['order_status']))
		{
			$result = array("status" => false,"msg" => "订单信息有误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$order_status = $request_data['order_status'];
		if(!(is_numeric($id) && $id>0) || ($order_status<0 || $order_status >2 || !is_numeric($order_status)))
		{
			$result = array("status" => false,"msg" => "订单信息有误");
			echo json_encode($result);
			exit(0);
		}

		$express_num = "不需要配送";
		if(isset($request_data['express_num']) && $request_data['express_num'] != "")
		{
			$express_num = $request_data['express_num'];
		}
		$sql = "update ".DB_PREFIX."order set order_status=".$order_status.", express_num=".'"'.$express_num.'",end_time='.time()." where id=".$id;
		#echo $sql;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg" => "更新成功！");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg" => "更新出错！");
			echo json_encode($result);
			exit(0);
		}



		
	}
	

	public function do_delete()
	{

		$request_data = $GLOBALS['request_data'];
		if(!(isset($request_data['id']) && is_numeric($request_data['id'] && $request_data['id'] > 0)))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);
			
		}
		
		$id = $request_data['id'];
		$sql = "delete from ".DB_PREFIX."order where id=".$id;
		if(!$GLOBALS['db']->query($sql))
		{
			$result = array("status" => false,"msg"=> "id错误！");
			echo json_encode($result);
			exit(0);	
		}
		$result = array("status" => true,"msg" => "删除成功！");
		echo json_encode($result);
		exit(0);
	}



	public function do_export()
	{
		$sql = "select * from ".DB_PREFIX."order";
		$sql1 = "select COLUMN_NAME,column_comment from INFORMATION_SCHEMA.Columns where table_name='xcb_order' and table_schema='xcb'";
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
