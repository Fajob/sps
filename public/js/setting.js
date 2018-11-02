
//用户退出
$(document).on("click",".sign_out",function(){
	$(".sign_out_con").removeClass("none");
})

function tuichu(){
	var obj = $("#user_id").serialize();
	$.post("api/index.php?ctl=user&act=do_loginout",obj,function(data){
		if(data){
			var _data = eval("("+data+")");
			if(_data.status == true){
//				window.location.reload();
				window.location.href="index.php?ctl=user";
			}else{
				layer.msg(_data.msg, function(){
				});
			}
		}
	})
}
function off(){
	$(".sign_out_con").addClass("none");
}




