<?php
/* Smarty version 3.1.32, created on 2018-05-26 11:25:05
  from '/root/project/xcb/wap/view/login/login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b08d39109a1a9_10951724',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ea30af89ffdfcd4da09ce26110e617cf25815fe' => 
    array (
      0 => '/root/project/xcb/wap/view/login/login.html',
      1 => 1527305103,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b08d39109a1a9_10951724 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1" name="viewport">
		<?php echo '<script'; ?>
 src="public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="public/js/layer/layer.js"><?php echo '</script'; ?>
>
		<link rel="stylesheet" type="text/css" href="public/css/media-100.css"/>
		<link rel="stylesheet" type="text/css" href="public/css/login-style.css"/>
	</head>
	<style type="text/css">
		input{
			color: #fff;
		}
	</style>
	<body style="height: 100%;">
		<?php echo '<script'; ?>
 src="public/js/mui.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript">
			
		<?php echo '</script'; ?>
>
		<div class="log_login_bg">
			<div class="log_nav">
				
			</div>
			<div class="log_login_logo">
				<img src="public/web/images/logo.png" alt="" />
			</div>
			<div class="log_login_logo_word">
				<span>CHINA SPS BLOCK CHAIN</span>
			</div>
			<div class="log_login_ask">
				<p>
					<input type="text" class="log_input_icon log_user" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="text" id="phone_number" class="log_inupt_content" placeholder="输入手机号码"/>
				</p>
				<p>
					<input type="text" class="log_input_icon log_password" disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="password" id="user_pwd" class="log_inupt_content" placeholder="输入登录密码"/>
				</p>
				<p>
					<input type="text" class="log_input_icon log_verificatincode"  disabled="true"/>
					<span class="log_vertical_bar"></span>
					<input type="text" id="verify" class="log_inupt_content" placeholder="输入验证码"/>
					<span class="log_code_picture" id="verify_img_con"><img id="verify_img" src="verify.php" alt="" /></span>
				</p>
				<a><button type="button" id="login_btn" class="log_login_btn">登录</button></a>
			</div>
			<div class="go_reg">
				<div class="go_reg_register">
					<a href="index.php?ctl=user&act=register">新户注册</a>
				</div>
				<div class="go_reg_forget_password">
					<a href="index.php?ctl=user&act=forgetpwd">忘记密码</a>
				</div>
			</div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
		$(document).on("click","#login_btn",function(){
			var mobile = $("#phone_number").val();
			var pwd = $("#user_pwd").val();
			var verify = $("#verify").val();
			$.post("api/index.php?ctl=user&act=do_login",{"phone_number":mobile,"user_pwd":pwd,"verify":verify},function(data){
				if(data)
				{
					var obj = eval('(' + data + ')');
					if(obj.status == true){
						window.location.href = "index.php?ctl=user&act=myinfo";
					}
					else
					{	
						layer.msg(obj.msg, function(){
							
						});
					}
				}
				else
				{
					alert('服务器返回一个错误');
				}
			})
		})
		$(document).on('click','#verify_img',function(){
			$("#verify_img_con").html("<img id='verify_img' src='verify.php' />");
		})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
