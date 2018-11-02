<?php
class translateModule
{
	public function index()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("translate/index.html");
		echo json_encode($GLOBALS['tmpl']);
	}

	public function out()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("translate/out.html");
		echo json_encode($GLOBALS['tmpl']);
	}
}

?>
