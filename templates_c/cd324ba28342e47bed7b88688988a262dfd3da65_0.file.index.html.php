<?php
/* Smarty version 3.1.32, created on 2018-05-19 10:08:35
  from '/root/project/xcb/admin/view/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5aff8723c551d9_48136267',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd324ba28342e47bed7b88688988a262dfd3da65' => 
    array (
      0 => '/root/project/xcb/admin/view/index.html',
      1 => 1526646038,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5aff8723c551d9_48136267 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="/public/css/style.css"/>
		<link rel="stylesheet" href="/public/css/layui.css" />
		<?php echo '<script'; ?>
 src="/public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/public/js/layui.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/public/js/style.js"><?php echo '</script'; ?>
>
	</head>
	<style type="text/css">
		.xt_con a{
			display: inline-block;
			width: 300px;
			height: 45px;
			background: #01a8ff4f;
			line-height: 45px;
			padding: 0 20px;
			color: #333;
			margin: 50px;
			text-decoration: none;
			border-radius: 5px;
		}
		.xt_con a:hover{
			background-color: #01a8ff;
			color: #fff;
			box-shadow: 0 0 5px #ddd;
		}
		.xt_con a input{
			border: none;
			height: 45px;
			color: #333;
			background: rgba(0,0,0,.0);
			text-align: center;
		}
		.xt_con a:hover input{
			color: #fff;
		}
	</style>
	<body style="width: 100%;min-width: 1300px;max-width: 100%;">
		<div class="indexCon">
			<div class="nav">
				<div class="logo"><img src="/public/images/logo_a.png"/></div>
				<div class="info">
					<!--<p style="color: #666;line-height: 40px;font-size:17px">欢迎 <span> 李小二 </span> [HD88]</p>
					<p style="color: #333;font-size: 14px;line-height: 25px;"> <span> 2018-02-07 18:06 </span> PM</p>-->
				</div>
				<div class="right">
					<button type="button" onclick="back()">退出</button>
				</div>
			</div>
			<div class="leftNav">
				
				<ul>
					<li class="title">
						<p>
							<a href="m.php?ctl=index" class="hui">首页</a>
							<a href="m.php?ctl=user">会员中心</a>
							<a href="m.php?ctl=order">订单中心</a>
							<a href="m.php?ctl=deal">商品管理</a>
							<a href="m.php?ctl=type">分类管理</a>
							<a href="m.php?ctl=conf&act=navagation">系统设置</a> 
						</p>
					</li>
				</ul>
				
			</div>
			<div class="rightCon">
				<div class="hyzx">
					<div class="xt_nav">
						<a class="type_sz xt_nav_active" href="javascript:;">首页</a>
					</div>
					<div class="xt_con">
						<a href="javascript:;">省代理总人数<input type="text" value="0"/></a>
						<a href="javascript:;">市代理总人数<input type="text" value="0"/></a>
						<a href="javascript:;">县代理总人数<input type="text" value="0"/></a>
						<a href="javascript:;">总业绩<input type="text" value="0"/></a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }
}
