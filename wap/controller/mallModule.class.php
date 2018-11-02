<?php

class mallModule
{
	#商城首页
	public function index()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		$request_data['ctl'] = "order";
		$request_data['act'] = "get_deal_list";
		$request_data['id'] = $user_info['id'];
		$data = call_api($request_data);
		$data_var = json_decode($data,true);
		if($data_var['status'] == true)
		{
			$data = $data_var['deal_list'];
		}
		else
		{
			$data = array();
		}
			
		$GLOBALS['tmpl']->assign("data",$data);
		$GLOBALS['tmpl']->display("mall/index.html");	
		echo json_encode($data);
	}

	#商品详情
	public function deal_detail()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		$deal_id = $request_data['deal_id'];
		$request_data['ctl'] = "order";
		$request_data['act'] = "get_deal_item";
		$request_data['deal_id'] = $deal_id;
		$data_var = json_decode(call_api($request_data),true);
		$data = $data_var['data'];

		$GLOBALS['tmpl']->assign("data",$data);
		$GLOBALS['tmpl']->assign("user_info",$user_info);

		$GLOBALS['tmpl']->display("mall/deal_detail.html");	
		echo json_encode($data);
	}
	
	#购买也详情
	public function buy_detail()
	{
		$request_data = $GLOBALS['request_data'];
		$user_info = $GLOBALS['user_info'];
		$deal_id = $request_data['deal_id'];
		$request_data['id'] = $user_info['id'];
		$request_data['ctl'] = "order";
		$request_data['act'] = "get_deal_item";
		$request_data['deal_id'] = $deal_id;
		$data_var = json_decode(call_api($request_data),true);
		$data = $data_var['data'];

		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_coin_price";
		$price_detail = call_api($request_data);
		$price_var = json_decode($price_detail,true);
		$price = $price_var['price'];

		$request_data['ctl'] = "user";
		$request_data['act'] = "get_address";
		$request_data['is_default'] = 1;
		$address_var = json_decode(call_api($request_data),true);
		$address = $address_var['data'];
		


		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->assign("coin_price",$price);
		$GLOBALS['tmpl']->assign("data",$data);
		$GLOBALS['tmpl']->assign('address',$address);
		echo json_encode($GLOBALS['tmpl']);
		$GLOBALS['tmpl']->display("mall/buy_detail.html");
	}
	
	
	
	//购物车
	public function cart_detail()
	{
		$request_data = $GLOBALS['request_data'];
		$request_data['ctl'] = 'cart';
		$request_data['act'] = 'get_cart_list';
		$request_data['id'] = $GLOBALS['user_info']['id'];

		$data_var = json_decode(call_api($request_data),true);
		$data = $data_var['cart_list'];


		$request_data['ctl'] = "user";
		$request_data['act'] = "get_address";
		$request_data['is_default'] = 1;
		$address_var = json_decode(call_api($request_data),true);
		$address = $address_var['data'];


		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_coin_price";
		$price_var = json_decode(call_api($request_data),true);
		$price = $price_var['price'];



		$GLOBALS['tmpl']->assign("data",$data);
		$GLOBALS['tmpl']->assign("user_info",$GLOBALS['user_info']);
		$GLOBALS['tmpl']->assign('address',$address);
		$GLOBALS['tmpl']->assign("price",$price);
	
		$GLOBALS['tmpl']->display("mall/cart_detail.html");
		echo json_encode($GLOBALS['tmpl']);
	}
}

?>
