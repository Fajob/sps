<?php

/*
**默认展示登陆页面
*/


class indexModule 
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
}

?>
