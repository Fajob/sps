<?php
/* Smarty version 3.1.32, created on 2018-05-30 18:00:43
  from '/root/project/xcb/wap/view/login/register.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0e764bbf6911_64808126',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '66ebd1e80a67c809b738e566dab8e7ab94b77e99' => 
    array (
      0 => '/root/project/xcb/wap/view/login/register.html',
      1 => 1527674439,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0e764bbf6911_64808126 (Smarty_Internal_Template $_smarty_tpl) {
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
	<style type="text/css">
		input{
			outline: none;
		}
	</style>
	<body>
		<div class="log_login_bg">
			<div class="log_nav">
				<div class="log_back">
					<a href="javascript:history.back(-1)"><img src="/public/images/back.png" /></a>
				</div>
			</div>
			<div class="log_login_logo">
				<img src="/public/images/logo.png" alt="" />
			</div>
			<div class="log_login_logo_word">
				<span>CHINA SPS BLOCK CHAIN</span>
			</div>
			<form id="reg_form">
			<div class="log_login_ask">
				<p>
					<input type="text" class="log_input_icon log_user" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="text" name="phone_number" id="phone_number" class="log_inupt_content" placeholder="输入手机号码"/>
				</p>
				<p>
					<input type="text" class="log_input_icon log_verified_code" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="text" name="code" class="log_inupt_content_verificode" placeholder="输入验证码"/>
					<input type="button" class="log_btn_verificode" value="获取验证码"/>
				</p>
				<p>
					<input type="text" class="log_input_icon log_invited_code" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="text" name="invite_code" class="log_inupt_content" placeholder="输入邀请码（必填）"/>
				</p>
				<p>
					<input type="text" class="log_input_icon log_password" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="password" name="user_pwd" class="log_inupt_content" placeholder="设置登录密码"/>
				</p>
				<p>
					<input type="text" class="log_input_icon log_tsf_password" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="password" name="user_pwd_trade" class="log_inupt_content" placeholder="设置交易密码"/>
				</p>
				<button type="button" class="log_register_btn">注册</button>
			</div>
			</form>
		</div>
	</body>
	<?php echo '<script'; ?>
>
		$(document).on("click",".log_register_btn",function(){
			var _data = $("#reg_form").serialize();
			$.post("api/index.php?ctl=user&act=do_register",_data,function(data){
				if(data){
					var obj = eval("("+data+")");
					if(obj.status == true){
						window.location.href="index.php?ctl=user&act=do_login";
					}else{
						layer.msg(obj.msg,function(){
							
						})
					}
				}
			})
		})
//		获取验证码
		$(document).on("click",".log_btn_verificode",function(){
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
				$(".log_btn_verificode").attr("disabled",false);
				$(".log_btn_verificode").val("重新获取"); 
				$('.log_btn_verificode').css("background-color","#01a8ff");
				time = 60; 
				return;
			} else { 
				$(".log_btn_verificode").attr("disabled", true); 
				$(".log_btn_verificode").val("重新发送" + time + "s"); 
				$('.log_btn_verificode').css("background-color","#bbb");
				time--; 
				setTimeout(function() { 
					timing() 
				},1000) 
			} 
		} 
		/*获取邀请码*/
		var thisURL = document.URL;
		var getval = thisURL.split('&');
		var inviteC = getval[getval.length-1].split('=');
		if(inviteC[0] == 'code' && inviteC.length != 0){
			$('.log_nav').addClass('none');
			inviteC = inviteC[1];
			$('input[name="invite_code"]').val(inviteC);
		}
	<?php echo '</script'; ?>
>
</html>
<?php }
}
