<?php
function unicode_decode($name){
 
   $json = '{"str":"'.$name.'"}';
     $arr = json_decode($json,true);
	   if(empty($arr)) return '';
	     return $arr['str'];

		 }
$aihao = unicode_decode("\u7f8e\u98df");
echo $aihao;

?>
