<?php
/* Smarty version 3.1.32, created on 2018-05-26 20:52:16
  from '/root/project/xcb/admin/view/login/login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0958800703b2_80236816',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '222fe6f9634e8327df7bde25527172720036bfaa' => 
    array (
      0 => '/root/project/xcb/admin/view/login/login.html',
      1 => 1527339133,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0958800703b2_80236816 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="public/css/style.css" />
		<link rel="stylesheet" href="public/css/layui.css" />
		<?php echo '<script'; ?>
 src="public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="public/js/layui.js"><?php echo '</script'; ?>
>
	</head>
	<body style="background: rgba(75,75,75,1);">
		<div class="loginCon">
			<div class="logo">
				<img style="height: auto;" src="public/images/logo.png"/>
			</div>
			<div class="loginBz">
				<form action="" method="post">
					<p>
						<span>用户名</span>
						<input type="text" placeholder="输入用户名" class="input_a"/>
						<i class="name"></i>
					</p>
					<p>
						<span>登录密码</span>
						<input type="password" placeholder="输入登录密码" class="input_b"/>
						<i class="password"></i>
					</p>
					<button type="button" class="btn" style="margin-top: 50px;">登录</button>
				</form>
			</div>
			<div class="clear"></div>
			<!--<p class="bz">2018 © LFC Investment Holdings Limited</p>-->
		</div>
	</body>
	<?php echo '<script'; ?>
>
		$(function(){
			//验证input不能为空
			$(document).on("click",".btn",function(){
				var name = $(".input_a").val(); 
				var pw = $(".input_b").val();
				if(name == ''){
					alert("用户名不能为空!!!");
					return false;
				}else if(pw == ''){
					alert("密码不能为空!!!");
					return false;
				}else{
					$.ajax({
						type:"post",
						url:"m.php?ctl=admin&act=do_login",
						data:{"m_user_name":name,"user_pwd":pw},
						dataType:"json",
						success:function(data){
							console.log(data);
							if(data.status == false){
								alert(data.msg);
								return false;
							}else{
								window.location.href="m.php?ctl=user";
							}
						}
					});
				}
			})
		})
		
	<?php echo '</script'; ?>
>
</html>
<?php }
}
