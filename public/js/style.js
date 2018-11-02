
//给小标题加背景色
$(document).on("click",".title>p>a",function(){
	$(this).addClass("hui").siblings().removeClass("hui");
	$(this).parents(".title").siblings(".title").children('p').children("a").removeClass("hui");
});

//编辑会员信息
function edit(e){
	var obj = $(e.target);
	obj.parents("tr").find("input").attr("disabled",false);
	obj.parents("tr").find("textarea").attr("disabled",false);
	obj.parents("tr").find("select").attr("disabled",false);
	obj.addClass("none");
	obj.next().removeClass("none");
}

//提交会员
function submit(e){
	var obj = $(e.target);
	obj.parents("tr").find("input").attr("disabled",true);
	obj.addClass("none");
	obj.prev().removeClass("none");
	var user_id = obj.parents("tr").find(".user_id").text();
	var user_name = obj.parents("tr").find("input[name='user_name']").val();
	var user_level = obj.parents("tr").find("input[name='user_level']").val();
	var real_name = obj.parents("tr").find("input[name='real_name']").val();
	var phone_number = obj.parents("tr").find("input[name='phone_number']").val();
	var p_id = obj.parents("tr").find(".p_id").text();
	var consume_credits = obj.parents("tr").find(".consume_credits").text();
	var cb_sl = obj.parents("tr").find(".cb_sl").text();
	var tg_sl = obj.parents("tr").find(".tg_sl").text();
	var static_reward = obj.parents("tr").find(".static_reward").text();
	var dynamic_reward = obj.parents("tr").find(".dynamic_reward").text();
	var cz_chain = obj.parents("tr").find(".cz_chain").text();
	var sc_chain = obj.parents("tr").find(".sc_chain").text();
	var p_rate = obj.parents("tr").find("input[name='p_rate']").val();
	var is_valid = obj.parents("tr").find("input[name='is_valid']").val();
	if(is_valid == "是"){
		is_valid = 1;
	}else if(is_valid == "否"){
		is_valid = 0
	}
	$.ajax({
		url:'m.php?ctl=user&act=do_update',
		type:'post',
		data:{
			"id":user_id,
			"user_name":user_name,
			"user_level":user_level,
			"real_name":real_name,
			"phone_number":phone_number,
			"consume_credits":consume_credits,
			"cb_sl":cb_sl,
			"tg_sl":tg_sl,
			"cz_chain":cz_chain,
			"sc_chain":sc_chain,
			"is_valid":is_valid,
			"p_id":p_id,
			"p_rate":p_rate,
			"static_reward":static_reward,
			"dynamic_reward":dynamic_reward,
		},
		dataType:"json",
		success:function(data){
			if(data.status == true){
				alert(data.msg);
				window.location.reload();
			}
		}
	})
}

//关闭增加商品弹窗
function close(e){
	var obj = $(e.target);
	obj.parents(".add_con").addClass("none")
}

//打开增加商品弹窗
function open(){
	$(".add_con").removeClass("none");
}

//上传图片
function add_img(e){
	var obj = $(e.target);
	var file = this.files[0];
	var reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onload = function(){
		obj.prev().attr("src",this.result);
	}
}

//删除用户信息
function del_user_info(e){
	var obj = $(e.target);
	var id = obj.parents("tr").children(".user_id").text();
	if(confirm("确认删除？")){
		$.ajax({
			type:"post",
			url:"m.php?ctl=user&act=do_delete",
			data:{"id":id},
			dataType:"json",
			success:function(data){
				var obj = eval("("+data+")");
				if(obj.status == true){
					alert(obj.msg);
					window.location.reload();
				}else{
					alert(obj.msg);
					return false;
				}
			}
		})
	}
	
}




//退出用户
function back(){
	if(confirm("确认退出！！！")){
		$.ajax({
			type:"post",
			url:"m.php?ctl=admin&act=do_loginout",
			success:function(data){
				var obj = eval("("+data+")");
				if(obj.status == false){
					alert(obj.msg);
					return false;
				}else{
					window.location.reload();
				}
			}
		});
	}
	
}

//替换会员是否有效文本
function tihuan(){
	var valids = $(".xg");
	for(var i = 0;i<valids.length;i++){
		var valid = valids.eq(i).val();
		if(valid == 0){
			valids.eq(i).val("否");
		}else{
			valids.eq(i).val("是");
		}
	}
}

//搜索会员
function search(){
	var user_name = $('.search_name').val();
	var id = $(".search_id").val();
	var p_id = $(".search_p_id").val();
	var phone_number = $(".search_mobile").val();
	var d = {"user_name":user_name,"id":id,"p_id":p_id,"phone_number":phone_number};
	$.ajax({
		type:"post",
		url:"m.php?ctl=user",
		data:d,
		dataType:'json',
		success:function(data){
		}
	});
	if(user_name != ""){
		window.location.href="m.php?ctl=user&user_name="+user_name;
	}else if(id != ""){
		window.location.href="m.php?ctl=user&id="+id;
	}else if(p_id != ""){
		window.location.href="m.php?ctl=user&p_id="+p_id;
	}else if(phone_number != ""){
		window.location.href="m.php?ctl=user&phone_number="+phone_number;
	}
}


//商品添加
function add_sp(e){
	var obj = $(e.target);
	var deal_name = obj.parents(".add_content").find(".deal_name").val();
	var img = obj.parents(".add_content").find("#img").attr("src");
	var img1 = obj.parents(".add_content").find("#img1").attr("src");
	var img2 = obj.parents(".add_content").find("#img2").attr("src");
	var img3 = obj.parents(".add_content").find("#img3").attr("src");
	var current_price = obj.parents(".add_content").find(".current_price").val();
	var stock = obj.parents(".add_content").find(".stock").val();
	var type = obj.parents(".add_content").find(".type_name").val();
	var brief = obj.parents(".add_content").find(".brief").val();
	var xl = obj.parents(".add_content").find(".stock").val();
	$.ajax({
		type:"post",
		url:"m.php?ctl=deal&act=do_add",
		data:{"deal_name":deal_name,"img":img,"current_price":current_price,"stock":stock,"type":type,"img1":img1,"img2":img2,"img3":img3,"brief":brief,},
		dataType:"json",
		success:function(data){
			console.log(data)
			if(data.status == true){
				alert(data.msg);
				window.location.reload();
			}else{
				alert(data.msg);
			}
		}
	});
}

//删除商品信息
function del_sp(e){
	var obj = $(e.target);
	var id = obj.parents("tr").children(".user_id").text();
	$.ajax({
		type:"post",
		url:"m.php?ctl=deal&act=do_delete",
		data:{"id":id},
		dataType:"json",
		success:function(data){
			if(data.status == true){
				confirm("确认删除！！！");
				return true;
				if(true){
				}
			}else{
				alert(data.msg);
			}
		}
	})
}

//更改商品信息
function submit_sp(e){
	var obj = $(e.target);
	var id = obj.parents("tr").find(".user_id").text();
	var deal_name = obj.parents("tr").find(".deal_name").val();
	var img = obj.parents("tr").find(".img").attr("src");
	var img1 = obj.parents("tr").find(".img1").attr("src");
	var img2 = obj.parents("tr").find(".img2").attr("src");
	var img3 = obj.parents("tr").find(".img3").attr("src");
	var current_price = obj.parents("tr").find(".current_price").val();
	var stock = obj.parents("tr").find(".stock").val();
	var type = obj.parents("tr").find(".type_name").val();
	var brief = obj.parents("tr").find(".brief").val();
	var is_effect = obj.parents("tr").find(".is_effect").val();
	if(is_effect == "是"){
		is_effect = 1;
	}else{
		is_effect = 0;
	}
	$.ajax({
		type:"post",
		url:"m.php?ctl=deal&act=do_update",
		data:{
			"id":id,
			"deal_name":deal_name,
			"img":img,
			"current_price":current_price,
			"img1":img1,
			"img2":img2,
			"img3":img3,
			"brief":brief,
			"stock":stock,
			"type":type,
			"is_effect":is_effect,
		},
		dataType:"json",
		success:function(data){
			if(data.status == true){
				alert(data.msg);
				window.location.reload();
			}
		}
	})
}

//发货状态
function fh_status(e){
	var obj_s = $(".sp_status");
	for(var i=0;i<obj_s.length;i++){
		var status = obj_s.eq(i).text();
		if(status == 0){
			obj_s.eq(i).text("未付款");
		}else if(status == 1){
			obj_s.eq(i).text("未发货");
		}else if(status == 2){
			obj_s.eq(i).text("已发货");
		}else if(status == 3){
			obj_s.eq(i).text("已收货");
		}
	}
}

//发货请求
function go_fh(e){
	var obj = $(e.target);
	var id = obj.parents("tr").find(".fh_id").text();
	var express_num = obj.parents("tr").find(".express_num").val();
	var order_status = obj.parents("tr").find(".sp_status").text();
	if(order_status == "未付款"){
		order_status = 2;
	}else if(order_status == "未发货"){
		order_status = 2;
	}else if(order_status == "已发货"){
		order_status = 2;
	}
	if(express_num !="不需要配送"){
		$.ajax({
			type:"post",
			url:"m.php?ctl=order&act=do_update",
			data:{"id":id,"express_num":express_num,"order_status":order_status},
			dataType:"json",
			success:function(data){
				if(data.status == true){
					alert(data.msg);
					window.location.reload();
				}
			},
			error:function(data){
				alert("发货失败，请重试")
			}
		});
	}else{
		alert("请输入快递单号！！！");
		return false;
	}
}

//删除订单
function del_dd(e){
	var obj = $(e.target);
	var id = obj.parents("tr").find(".fh_id").text();
	$.post("m.php?ctl=order&act=do_delete",{"id":id},function(data){
		if(data){
			if(data.status == true){
				confirm("确认删除此订单？")
				return true;
				if(true){
					window.location.reload();
				}
			}else{
				alert(data.msg)
			}
		}
	},"json")
}

//订单搜索
function sp_search(e){
	var obj = $(e.target);
	var search_title = $(".lm_s").val();
	var search_con = obj.next().val();
	if(search_title == ""){
		return false;
	}else if(search_title == "order_sn"){
		 window.location.href = "m.php?ctl=order&order_sn="+search_con;
	}else if(search_title == "user_id"){
		window.location.href = "m.php?ctl=order&user_id="+search_con;
	}else if(search_title == "user_name"){
		window.location.href = "m.php?ctl=order&user_name="+search_con;
	}else if(search_title == "express_num"){
		window.location.href = "m.php?ctl=order&express_num="+search_con;
	}
}



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
 //补0操作
function getzf(num){  
    if(parseInt(num) < 10){  
       num = '0'+num;  
    }  
    return num;  
}