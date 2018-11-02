<?php
class settingModule 
{
	public function index()
	{		
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("setting/index.html");
		echo json_encode($GLOBALS['tmpl']);
	}
	
	
	#修改昵称
	public function update_name()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("setting/update_name.html");
		echo json_encode($GLOBALS['tmpl']);
	}
	
	
	#修改登录密码
	public function update_login_pwd()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("setting/update_login_pwd.html");
	}
	
	
	#修改交易密码
	public function update_trade_pwd()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("setting/update_trade_pwd.html");
	}
	
	
	#地址管理
	public function address_gl()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		$request_data['ctl'] = "user";
		$request_data['act'] = "get_address";
		$address_var = json_decode(call_api($request_data),true);
		$address = $address_var['data'];

		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->assign("address",$address);
		$GLOBALS['tmpl']->display("setting/address_gl.html");
		echo json_encode($GLOBALS['tmpl']);
	}
	
	
	#添加地址
	public function add_address()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("setting/add_address.html");
	}
	
	
	#编辑地址
	public function edit_address()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		$request_data['ctl'] = "user";
		$request_data['act'] = "get_address";
		$address_var = json_decode(call_api($request_data),true);
		$address = $address_var['data'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->assign("address",$address);
		$GLOBALS['tmpl']->display("setting/edit_address.html");
		echo json_encode($GLOBALS['tmpl']);
	}
	
}

?>
