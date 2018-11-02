<?php
class indexModule 
{
	public function index()
	{		
		//var_dump($GLOBALS['tmpl']);
		$GLOBALS['tmpl']->assign("title","this is an tmpl");
		$GLOBALS['tmpl']->assign("contents","12345678");
		$GLOBALS['tmpl']->display("index.html");
	}
}

?>
