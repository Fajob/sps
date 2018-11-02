//登录

$(document).on("click","#login_btn",function(){
	var mobile = $("#phone_number").val();
	var pwd = $("#user_pwd").val();
	$.post("index.php?ctl=user&act=do_login",{"phone_number":mobile,"user_pwd":pwd},function(data){
		if(data){
			if(data.status == true){
				alert(data.msg);
				window.location.href = "index.php?ctl=user&act=userinfo";
			}
		}
	})
})
