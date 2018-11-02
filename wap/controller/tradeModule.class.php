<?php
class tradeModule 
{
	#资产发布
	public function index()
	{		
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		$request_data['id'] = $user_info['id'];
		
		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_kline";
		$kline_data_var = json_decode(call_api($request_data),true);
		$kline_data = $kline_data_var['data'];

		$request_data['act'] = "get_sale_list";
		$sale_list_var = json_decode(call_api($request_data),true);
		$sale_list = $sale_list_var['data'];

		$request_data['act'] = "get_buy_list";
		$buy_list_var = json_decode(call_api($request_data),true);
		$buy_list = $buy_list_var['data'];

		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_coin_price";
		$price_detail = call_api($request_data);
		$price_var = json_decode($price_detail,true);
		$price = $price_var['price'];

		$GLOBALS['tmpl']->assign("coin_price",$price);
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->assign("kline_data",$kline_data);
		$GLOBALS['tmpl']->assign("sale_list",$sale_list);
		$GLOBALS['tmpl']->assign("buy_list",$buy_list);

		$GLOBALS['tmpl']->display("trade/index.html");
		echo  json_encode($GLOBALS['tmpl']);
	}
	
	
	#资产发布记录
	public function trade_record()
	{		
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		$request_data['id'] = $user_info['id'];

		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_punish_list";
		$punish_list_var = json_decode(call_api($request_data),true);
		$punish_list = $punish_list_var['data'];
		
		$request_data['act'] = "get_trade_list";
		$trade_list_var = json_decode(call_api($request_data),true);
		$trade_list = $trade_list_var['data'];

		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->assign("punish_list",$punish_list);
		$GLOBALS['tmpl']->assign("trade_list",$trade_list);

		$GLOBALS['tmpl']->display("trade/trade_record.html");
		echo  json_encode($GLOBALS['tmpl']);
	}
	
	
	#资产交易平台购买
	public function asset_trading_pt_buy()
	{
		$user_info = $GLOBALS['user_info'];
		$request_data = $GLOBALS['request_data'];
		$request_data['id'] = $user_info['id'];
		
		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_kline";
		$kline_data_var = json_decode(call_api($request_data),true);
		$kline_data = $kline_data_var['data'];

		$request_data['act'] = "get_sale_list";
		$sale_list_var = json_decode(call_api($request_data),true);
		$sale_list = $sale_list_var['data'];

		$request_data['act'] = "get_buy_list";
		$buy_list_var = json_decode(call_api($request_data),true);
		$buy_list = $buy_list_var['data'];


		$request_data['ctl'] = "trade";
		$request_data['act'] = "get_coin_price";
		$price_detail = call_api($request_data);
		$price_var = json_decode($price_detail,true);
		$price = $price_var['price'];


		$GLOBALS['tmpl']->assign("coin_price",$price);
		$GLOBALS['tmpl']->assign("user_info",$user_info);
		$GLOBALS['tmpl']->assign("kline_data",$kline_data);
		$GLOBALS['tmpl']->assign("sale_list",$sale_list);
		$GLOBALS['tmpl']->assign("buy_list",$buy_list);

		$GLOBALS['tmpl']->display("trade/asset_trading_pt_buy.html");
		echo  json_encode($GLOBALS['tmpl']);
	}
	
	
	#资产交易平台出售
	public function asset_trading_pt_sell()
	{
		$GLOBALS['tmpl']->display("trade/asset_trading_pt_sell.html");
	}
}

?>
