<?php
/*
//var_dump($_SERVER);
$path = $_SERVER['PHP_SELF'];
$path_var = explode('/',$path);
var_dump($path_var);
if(count($path_var) >2)
{
	$num = count($path_var);
	$pre = '/';
	for($i=1;$i<$num-1;$i++)
		$pre = $pre.$path_var[$i]."/";
}
else
{
	$pre = '/';
}
echo $pre;

*/

class testModule
{
	public function test()
	{
		$id = 29;
		$sql = "select * from ".DB_PREFIX."user where id=".$id;
		$GLOBALS['user_info'] = $GLOBALS['db']->getROw($sql);
		check_upgrade();
	}
}
?>
