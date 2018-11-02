<?php
	//通用函数,适用所有项目的通用函数


	// 1. 获取用户ip
	function getUserIP()
	{
		$real_client_ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		return $real_client_ip;
	}

	// 2.调用api，拼接请求从新获取结果
	function call_api($request_data)
	{
		$header = array();

		$header[] = 'Content-Type: application/x-www-form-urlencoded';
		$header[] = 'Accept: application/json';
		if(isset($request_data['s_id']))
		{	
		#	$header[] = 'Cookie: PHPSESSID='.$request_data['s_id'];
		}
		$o = '';
		foreach ( $request_data as $k => $v ) 
		{ 
			$o.= "$k=" . urlencode( $v ). "&" ;
		}
		$request_data= substr($o,0,-1);
		$url = "http://xcb.quanx.cc/api/index.php";
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
		$return_content = curl_exec($ch);        
		$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
		curl_close($ch);
		return $return_content;
	}


	// api输出
	function output($result)
	{
		$path = $_SERVER['PHP_SELF'];
		$path_var = explode('/',$path);
		if(count($path_var) >2)
		{
			$num = count($path_var);
			$pre = '/';
			for($i=1;$i<$num-1;$i++)
				$pre = $pre.$path_var[$i]."/";
			$pre_c = $pre;
		}
		if($pre == "\/api\/")
		{
			echo json_encode($result);
		}
		else
		{
			return $result;
		}
		
	}


	// 3.判断是否是合法的用户名
	function isName($val)  
	{  
		if( preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val) )//2008-7-24  
		{  
			if(strlen($val) > 45)
				return false;  
			return true;
		}  
		return true;  
	}

	function isDealName($val)  
	{  
		if( preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val) )//2008-7-24  
		{  
			if(strlen($val) > 45)
				return false;  
			return true;
		}  
		return false;  
	}


	// 保存base64 图片
	function save_base64_image($path,$image)
	{
		$imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';
		$file_path = "$path".$imageName;
		if (strstr($image,","))
		{
			$image = explode(',',$image);
			$image = $image[1];
		}
		file_put_contents(ROOT_PATH.$file_path, base64_decode($image));
		return $file_path;
	}


	function save_log($func,$msg)
	{
		$ip = getUserIP();
		$time = time();
		$func = '"'.$func.'"';
		$ip = '"'.$ip.'"';
		$msg = '\''.$msg.'\'';
		$sql = "insert into xcb_log(func,time,ip,msg) values(".$func.','.$time.','.$ip.','.$msg.')';
		if($GLOBALS['db']->query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	

?>
