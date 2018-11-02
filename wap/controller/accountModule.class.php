<?php
class accountModule 
{
//	public function index()
//	{		
	#	$GLOBALS['tmpl']->display("index.html");
//	}
	
	#账户管理
	public function account_gl()
	{
		$request_data = $GLOBALS['request_data'];
		$request_data['ctl'] = "user";
		$request_data['act'] = "get_payment";
		$user_info = $GLOBALS['user_info'];
		$id = $user_info['id'];
		$account_data_var = json_decode(call_api($request_data),true);
		$data = $account_data_var['data'];
		$GLOBALS['tmpl']->assign("data",$data);
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("my/account_gl.html");
		echo json_encode($GLOBALS['tmpl']);
	}
	
	
	#添加账户
	public function add_account()
	{
		$user_info = $GLOBALS['user_info'];
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->display("my/add_account.html");
		echo json_encode($GLOBALS['tmpl']);
	}
	
	
	#添加支付宝
	public function add_zfb()
	{
		$GLOBALS['tmpl']->display("my/add_zfb.html");
	}
	
	
	#添加银行卡
	public function add_yhk()
	{
		$GLOBALS['tmpl']->display("my/add_yhk.html");
	}
	
	
	#编辑银行卡
	public function edit_yhk()
	{
		$GLOBALS['tmpl']->display("my/edit_yhk.html");
	}
	
	
	#编辑支付宝
	public function edit_zfb()
	{
		$GLOBALS['tmpl']->display("my/edit_zfb.html");
	}
	
	
	
	
}

?>
