<?php
class typeModule
{
	public function index()
	{
		$sql = "select * from ".DB_PREFIX."deal_type";
		$type_detail = $GLOBALS['db']->getAll($sql);
		$title = "分类管理";
		$GLOBALS['tmpl']->assign("data",$type_detail);
		$GLOBALS['tmpl']->display("spgl/type.html");
	}

	public function do_add()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['type']) || !isset($request_data['id_index']))
		{
			$result = array("status" => false,"msg"=> "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$type = '"'.$request_data['type'].'"';
		$id_index = $request_data['id_index'];
		#检查type是否存在
		$sql = "select count(*) from ".DB_PREFIX."deal_type where type=".$type;
		$sql_var = $GLOBALS['db']->getRow($sql);
		if($sql_var['count(*)'] > 0)
		{
			$result = array("status" => false,"msg"=> "该类型已添加");
			echo json_encode($result);
			exit(0);
		}
		$sql = "insert into ".DB_PREFIX."deal_type(type,id_index) values(".$type.','.$id_index.")";
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg"=> "添加成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg"=> "添加失败");
			echo json_encode($result);
			exit(0);
		}
	}


	public function do_del()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']))
		{
			$result = array("status" => false,"msg"=> "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		#检查该分类下面是否有商品
		$sql = "select count(*) from ".DB_PREFIX."deal where type=".$id;
		$sql_var = $GLOBALS['db']->getRow($sql);
		if($sql_var['count(*)'] > 0)
		{
			$result = array("status" => false,"msg"=> "该分类下有商品，暂时不能删除");
			echo json_encode($result);
			exit(0);
		}
		
		$sql = "delete from ".DB_PREFIX."deal_type where id=".$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg"=> "删除成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg"=> "删除失败");
			echo json_encode($result);
			exit(0);
		}

	}

	public function do_update()
	{
		$request_data = $GLOBALS['request_data'];
		if(!isset($request_data['id']) || !isset($request_data['type']) || !isset($request_data['id_index']))
		{
			$result = array("status" => false,"msg"=> "参数错误");
			echo json_encode($result);
			exit(0);
		}
		$id = $request_data['id'];
		$type = '"'.$request_data['type'].'"';
		$id_index = $request_data['id_index'];
		$sql = "select count(*) from ".DB_PREFIX."deal_type where type=".$type;
		$sql_var = $GLOBALS['db']->getRow($sql);
		if($sql_var['count(*)'] > 0)
		{
			$result = array("status" => false,"msg"=> "该类型已添加");
			echo json_encode($result);
			exit(0);
		}
		$sql = "update ".DB_PREFIX."deal_type set type=".$type.",id_index=".$id_index." where id=".$id;
		if($GLOBALS['db']->query($sql))
		{
			$result = array("status" => true,"msg"=> "更新成功");
			echo json_encode($result);
			exit(0);
		}
		else
		{
			$result = array("status" => false,"msg"=> "更新失败");
			echo json_encode($result);
			exit(0);
		}
	}
}


?>
