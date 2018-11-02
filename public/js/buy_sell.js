   //求购出售列表
   
$(document).on("click",".zc_cs",function(){
	var order_id = $(this).attr("id");
	var id = $(this).val();
	var qg_num = $(this).parents(".wwt_son").find(".qg_num").text();
	var qg_price = $(this).parents(".wwt_son").find(".qg_price").text();
	var name = $(this).parents(".wwt_son").find(".name").text();
	$('.buy_num').find(".xq_num").text(qg_num);
	$('.buy_num').find(".xq_price").text(qg_price);
	$('.buy_num').find(".name").text(name);
	$('.buy_num').find("#cs_num").attr("name",id);
	$('.buy_num').find("#cs_pwd").attr("name",order_id);
	$(".mm").removeClass("none");
	$('.buy_num').removeClass("none");
	
})
$(document).on("click",".cs_btn",function(){
 	var cs_num = $("#cs_num").val();
 	var cs_pwd = $("#cs_pwd").val();
 	var cs_price = $("#cs_price").text();
 	var cs_id = $("#cs_num").attr("name")
 	var cs_order_id = $("#cs_pwd").attr("name")
 	$.post("api/index.php?ctl=trade&act=do_sale",{"id":cs_id,"order_id":cs_order_id,"num":cs_num,"price":cs_price,"user_pwd_trade":cs_pwd},function(data){
 		if(data){
 			var _data = eval("("+data+")");
 			if(_data.status == true){
 				alert(_data.msg);
 				window.location.reload()
 			}else{
 				layer.msg(_data.msg, function(){
					
				});
 			}
 		}
 	})
 })
 
  //出售购买列表
$(document).on("click",".zc_gm",function(){ 	
	var gm_order_id = $(this).attr("id");
	var gm_id = $(this).val();
	var gm_num = $(this).parents(".wwt_son").find(".gm_num").text();
	var gm_price = $(this).parents(".wwt_son").find(".gm_price").text();
	var gm_name = $(this).parents(".wwt_son").find(".name").text();
	$('.sell_num').find(".cs_yh").text(gm_name);
	$('.sell_num').find(".gm_price_s").text(gm_price);
	$('.sell_num').find(".gm_num_s").text(gm_num);
	$('.sell_num').find(".my_num").attr("name",gm_id);
	$('.sell_num').find(".my_pwd").attr("name",	gm_order_id);
	$(".mm").removeClass("none");
	$('.sell_num').removeClass("none");
	
})
$(document).on("click",".gm_btn",function(){
 	var gm_num = $(".my_num").val();
 	var gm_pwd = $(".my_pwd").val();
 	var gm_price = $(".gm_price_s").text();
 	var gm_id = $(".my_num").attr("name")
 	var gm_order_id = $(".my_pwd").attr("name")
 	$.post("api/index.php?ctl=trade&act=do_buy",{"id":gm_id,"order_id":gm_order_id,"num":gm_num,"price":gm_price,"user_pwd_trade":gm_pwd},function(data){
 		if(data){
 			var _data = eval("("+data+")");
 			if(_data.status == true){
 				alert(_data.msg);
   				window.location.reload();
 			}else{
 				layer.msg(_data.msg, function(){
					
				});
 			}
 		}
 	})
 })


//发布购买
$(document).on("click","#sure_buy_btn",function(){
	var obj = $("#gm_form").serialize();
	$.post("api/index.php?ctl=trade&act=do_pulish_order",obj,function(data){
		if(data){
			var _data = eval("("+data+")");
			if(_data.status == true){
				alert(_data.msg);
				window.location.reload();
			}else{
				layer.msg(_data.msg, function(){
					
				});
			}
		}
	})
})


//发布出售
$(document).on("click","#sure_sell_btn",function(){
	var obj = $("#cs_form").serialize();
	$.post("api/index.php?ctl=trade&act=do_pulish_order",obj,function(data){
		if(data){
			var _data = eval("("+data+")");
			if(_data.status == true){
				alert(_data.msg);
				window.location.reload();
			}else{
				layer.msg(_data.msg, function(){
					
				});
			}
		}
	})
})

