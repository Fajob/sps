<?php
/* Smarty version 3.1.32, created on 2018-05-26 11:21:23
  from '/root/project/xcb/wap/view/login/forgetpwd.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b08d2b3db2bd5_33171095',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e47412b3caa526aebb3766289278c4c97e91774' => 
    array (
      0 => '/root/project/xcb/wap/view/login/forgetpwd.html',
      1 => 1526728377,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b08d2b3db2bd5_33171095 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="/public/css/media-100.css"/>
		<link rel="stylesheet" type="text/css" href="/public/css/login-style.css"/>
		<?php echo '<script'; ?>
 src="/public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="public/js/layer/layer.js"><?php echo '</script'; ?>
>
	</head>
	<body>
		<div class="log-fp-bg">
			<div class="log-fp-input">
				<div class="log-fp-header">
					<a href="javascript:history.back(-1)"><img src="/public/web/images/back_arrow.png" /></a>
					<p>忘记密码</p>
				</div>
				<div class="log-fp-content">
					<span>手 &nbsp;机 &nbsp;号</span>
					<input type="text" id="phone_number" placeholder="输入手机号" />
				</div>
				<div class="log-fp-content-code">
					<span>验 &nbsp;证 &nbsp;码</span>
					<input type="text" id="code" class="log-fp-code" placeholder="短信验证码" />
					<input type="button" class="get_code" value="获取验证码"/>
				</div>
				<div class="log-fp-content">
					<span>登录密码</span>
					<input type="password" id="user_pwd" placeholder="设置新的登录密码" />
				</div>
				<div class="log-fp-content">
					<span>确认密码</span>
					<input type="password" id="user_pwd_confirm" placeholder="再次确认登录密码" />
				</div>
			</div>
			<div class="log-fp-btn">
				<button type="button">确认</button>
			</div>		
		</div>
	</body>
	<?php echo '<script'; ?>
>
		
		//提交
		$(document).on("click",".log-fp-btn button",function(){
			var phone_number = $("#phone_number").val();
			var code = $("#code").val();
			var user_pwd = $("#user_pwd").val();
			var user_pwd_confirm = $("#user_pwd_confirm").val();
			$.ajax({
				url:"api/index.php?ctl=user&act=do_reset_pwd",
				type:"post",
				data:{"phone_number":phone_number,"code":code,"user_pwd":user_pwd,"user_pwd_confirm":user_pwd_confirm},
				dataType:"json",
				success:function(data){
					if(data.status == true){
						window.location.href="index.php?ctl=user&act=do_login";
					}else{
						layer.msg(data.msg,function(){
							
						})
					}
				}
			})
		})
		
		//获取验证码
		$(document).on("click",".get_code",function(){
			var phone_number = $("#phone_number").val();
			$.post("sms.php?",{"phone_number":phone_number},function(data){
				if(data){
					var obj = eval("("+data+")");
					if(obj.msg == true){
						timing();
					}else{
						layer.msg(obj.msg,function(){
							
						})
					}
				}
			})
		})
		
		
		//发送验证码倒计时
		var time=60; 
		function timing() { 
			if (time == 0) { 
				$("#code").attr("disabled",false);
				$("#code").val("重新获取"); 
				$('#code').css("color","#01a8ff");
				time = 60; 
				return;
			} else { 
				$("#code").attr("disabled", true); 
				$("#code").val("重新发送" + time + "s"); 
				$('#code').css("color","#bbb");
				time--; 
				setTimeout(function() { 
					timing() 
				},1000) 
			} 
		} 
	<?php echo '</script'; ?>
>
</html>
<?php }
}
