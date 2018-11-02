//资产交易模态框显示与隐藏
//function block_sell(){
//	$(".mm").removeClass("none");
//	$(".sell_num").removeClass("none");
//	$(".buy_num").addClass("none");
//}
//function block_buy(){
//	$(".mm").removeClass("none");
//	$(".buy_num").removeClass("none");
//	$(".sell_num").addClass("none");
//}

function none(){
	$(".mm").addClass("none");
	$('.buy_num').addClass("none");
	$('.sell_num').addClass("none");
}
//资产交易买卖切换
$(document).on("click",".wwt_jy_biao ul li a",function(){
	$(this).addClass("wwt_dd_active");
	$(this).parent().siblings().children().removeClass("wwt_dd_active");
	var index = $(this).parent().index();
	$(".wwt_jy_con .wwt_biao_con").eq(index).removeClass("none").siblings().addClass("none");
})


//资产交易求购列表出售
//$(document).on("click",".zc_cs",function(){
//	block_buy();
//	var id = $(this).val();
//	var order_id = $(this).attr("id");
//})



//资产交易出售列表购买
//$(document).on("click",".zc_gm",function(){
//	block_sell();
//	var id = $(this).val();
//	var order_id = $(this).attr("id");
//})


//弹出提示框
function tishi(){
	$(".sign_out_con").removeClass("none");
}
//关闭提示框
function wwt_close(){
	$(".sign_out_con").addClass("none");
}

//获取验证码倒计时
var time=60; 
function timing() { 
	if (time == 0) { 
		$(".huoqu").attr("disabled",false);
		$(".huoqu").val("重新获取"); 
		$('.huoqu').addClass("huoqu_no");
		time = 60; 
		return;
	} else { 
		$(".huoqu").attr("disabled", true); 
		$(".huoqu").val("重新发送" + time + "s"); 
		$('.huoqu').removeClass("huoqu_no");
		time--; 
		setTimeout(function() { 
			timing() 
		},1000) 
	} 
} 



//账户管理添加，修改，银行卡跳转
		//进入添加付款方式
		$(document).on("click","#add_payment",function(){
			$(".account_gl_con").addClass("_left");
			$(".add_payment").addClass("left");
		})
		//选择付款方式返回上一页
		$(document).on("click",".add_payment .back",function(){
			$(".account_gl_con").removeClass("_left");
			$(".add_payment").removeClass("left");
		})
		
		//选择银行卡页面
		$(document).on("click","#go_add_yhk",function(){
			$(".add_payment").addClass("_left");
			$(".choose_yhk").addClass("left");
		})
		//选择支付宝页面
		$(document).on("click","#go_add_zfb",function(){
			$(".add_payment").addClass("_left");
			$(".choose_zfb").addClass("left");
		})
		
		//返回选择添加账户页面
		$(document).on("click",".choose_yhk .back",function(){
			$(".add_payment").removeClass("_left");
			$(".choose_yhk").removeClass("left");
		})
		//返回选择添加账户页面
		$(document).on("click",".choose_zfb .back",function(){
			$(".add_payment").removeClass("_left");
			$(".choose_zfb").removeClass("left");
		})
		//进入编辑付款方式页面
		$(document).on("click",".label",function(){
			$(".account_gl_con").addClass("_left");
			$(this).next().addClass("left");
		})
		//编辑付款方式页面退回账户管理
		$(document).on("click",".edit .back",function(){
			$(this).parents(".edit").removeClass("left");
			$(".account_gl_con").removeClass("_left");
		})


//添加付款信息
$(document).on("click",".bind_btn",function(){
	var obj = $(this).prev().serialize();
	$.post("api/index.php?ctl=user&act=do_add_payment",obj,function(data){
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



//修改付款方式信息
$(document).on("click",".edit_btn",function(){
	var obj = $(this).prev().serialize();
	$.post("api/index.php?ctl=user&act=do_update_payment",obj,function(data){
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

//删除付款方式
$(document).on("click",".edit .right",function(){
	var id = $(this).parent().next().find(".id").val();
	var payment_id = $(this).parent().next().find(".payment_id").val();
	$.post("api/index.php?ctl=user&act=do_del_payment",{"id":id,"payment_id":payment_id},function(data){
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

//当付款方式为两种的时候移除添加付款方式，及页面
$(window).ready(function(){
	var pay_fs = $(".pay_img img");
	if(pay_fs.length >= 2){
		$("#add_payment").parent().remove();
		$(".choose_yhk").remove();
		$(".choose_zfb").remove();
	}else if(pay_fs.length == 1){
		var pay_con = $(".pay_img img").attr("alt");
		if(pay_con == "支付宝"){
			$(".add_payment .zfb").remove();
			$(".choose_zfb").remove();
		}else{
			$(".add_payment .yhk").remove();
			$(".choose_yhk").remove();
		}
	}
})

//时间戳转换时间格式
function date(e){
	var time = new Date(e*1000);
	var year = time.getFullYear();
	var month = time.getMonth()+1;
	var day = time.getDate();
	var hour = time.getHours();
	var min = time.getMinutes();
	var sen = time.getSeconds();
	return times = year +'-'+ getzf(month) +'-'+ getzf(day) +' '+ getzf(hour) +':'+ getzf(min) +':'+getzf(sen);
}
function dateNoTime(e){
	var time = new Date(e*1000);
	var year = time.getFullYear();
	var month = time.getMonth()+1;
	var day = time.getDate();
	return times = year +'-'+ getzf(month) +'-'+ getzf(day);
}
 //补0操作
function getzf(num){  
    if(parseInt(num) < 10){  
       num = '0'+num;  
    }  
    return num;  
}
Date.prototype.format = function(format)
{
 var o = {
	 "M+" : this.getMonth()+1, //month
	 "d+" : this.getDate(),    //day
	 "h+" : this.getHours(),   //hour
	 "m+" : this.getMinutes(), //minute
	 "s+" : this.getSeconds(), //second
	 "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
	 "S" : this.getMilliseconds() //millisecond
 }
 if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
 (this.getFullYear()+"").substr(4 - RegExp.$1.length));
 for(var k in o)if(new RegExp("("+ k +")").test(format))
 format = format.replace(RegExp.$1,
 RegExp.$1.length==1 ? o[k] :
 ("00"+ o[k]).substr((""+ o[k]).length));
 return format;
}
/*比例转换*/
function rate(baseno,no){
	var rate = no/baseno*100;
	rate = rate.toFixed(2);
	return rate;
}
function rateD(baseno,no){
	var rate = no/baseno*100;
	rate = rate.toFixed(0);
	return rate;
}







