<?php
/* Smarty version 3.1.32, created on 2018-05-29 16:42:47
  from '/root/project/xcb/admin/view/xtgl/xtgl_cs.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d1287be0b68_65924807',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '83733c8809a6a5e062e1a5ac35a24a4490e030e6' => 
    array (
      0 => '/root/project/xcb/admin/view/xtgl/xtgl_cs.html',
      1 => 1527583351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d1287be0b68_65924807 (Smarty_Internal_Template $_smarty_tpl) {
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
							<a href="m.php?ctl=index">首页</a>
							<a href="m.php?ctl=user">会员中心</a>
							<a href="m.php?ctl=incharge">会员充值</a>
							<a href="m.php?ctl=order">订单中心</a>
							<a href="m.php?ctl=deal">商品管理</a>
							<a href="m.php?ctl=type">分类管理</a>
							<a href="m.php?ctl=conf&act=navagation" class="hui">系统设置</a> 
						</p>
					</li>
					
					
				</ul>
				
			</div>
			<div class="rightCon">
				<div class="hyzx">
					<div class="xt_nav">
						<a class="dh_sz" href="m.php?ctl=conf&act=navagation">导航栏设置</a>
						<a class="gg_sz" href="m.php?ctl=conf&act=notice">公告设置</a>
						<a class="cs_sz xt_nav_active" href="m.php?ctl=conf&act=argument">参数设置</a>
						<a class="banner_sz" href="m.php?ctl=conf&act=carousel">轮播图设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=kline">K线设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=share">分享设置</a>
						<a class="k_sz" href="m.php?ctl=log">系统日志</a>
					</div>
					<div class="xt_con">
						<!--导航内容-->
						<form id="form">
							<div class="cs_con">
								<div class="first_ceng">
									<p><input name="node_1_coins_money" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_1_coins_money'];?>
"/><span>普通节点持币量总价值</span></p>
									<p><input name="node_2_coins_money" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_2_coins_money'];?>
"/><span>优质节点持币量总价值</span></p>
									<p><input name="node_3_coins_money" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_3_coins_money'];?>
"/><span>极速节点持币量总价值</span></p>
									<p><input name="node_4_coins_money" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_4_coins_money'];?>
"/><span>超级节点持币量总价值</span></p>
									<p><input name="node_1_get_generations" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_1_get_generations'];?>
"/><span>普通节点拿多少代的收益</span></p>
									<p><input name="node_2_get_generations" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_2_get_generations'];?>
"/><span>优质节点拿多少代的收益</span></p>
									<p><input name="node_3_get_generations" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_3_get_generations'];?>
"/><span>极速节点拿多少代的收益</span></p>
									<p><input name="node_4_get_generations" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['node_4_get_generations'];?>
"/><span>超级节点拿多少代的收益</span></p>
								</div>
								<div class="two_ceng">
									<!--<p><input name="" value="" type="text" /><span>币价</span></p>-->
									<p><input name="static_rate" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['static_rate'];?>
" type="text" /><span>静态收益率</span></p>
									<p><input name="sc_days" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['sc_days'];?>
" type="text" /><span>锁仓链锁定期</span></p>
									<p><input name="sc_release_days" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['sc_release_days'];?>
" type="text" /><span>每几天释放</span></p>
									<p><input name="sc_release_rate" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['sc_release_rate'];?>
" type="text" /><span>每次释放剩余的百分比</span></p>
								</div>
								<div class="three_ceng">
									<p>前<input name="dynamic_generation_1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['dynamic_generation_1'];?>
"/>代动态收益率:<input name="dynamic_rate_1" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['dynamic_rate_1'];?>
"/></p>
									<p>前<input name="dynamic_generation_2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['dynamic_generation_2'];?>
"/>代动态收益率:<input name="dynamic_rate_2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['dynamic_rate_2'];?>
"/></p>
								</div>
								<div class="four_ceng">
									<h3>代理商中心</h3>
									<div class="xian_dl">
										<div class="xian_dl_con">
											<p class="dl_title">县代理</p>
											<span>团队最低业绩:<input name="proxy_1_consume_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_1_consume_min'];?>
" type="text" /></span>
											<span>最少直推用户数:<input name="proxy_1_direct_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_1_direct_min'];?>
" type="text" /></span>
											<span>直推用户最低业绩要求（含伞下）:<input name="proxy_1_direct_consume_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_1_direct_consume_min'];?>
" type="text" /></span>
										</div>
									</div>
									<div class="shi_dl">
										<div class="xian_dl_con">
											<p class="dl_title">市代理</p>
											<span>团队最低业绩:<input name="proxy_2_consume_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_2_consume_min'];?>
" type="text" /></span>
											<span>最少直推用户数:<input name="proxy_2_direct_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_2_direct_min'];?>
" type="text" /></span>
											<span>线下最低县代理数:<input name="proxy_2_proxy1__min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_2_proxy1__min'];?>
" type="text" /></span>
										</div>
									</div>
									<div class="sheng_dl">
										<div class="xian_dl_con">
											<p class="dl_title">省代理</p>
											<span>团队最低业绩:<input name="proxy_3_consume_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_3_consume_min'];?>
" type="text" /></span>
											<span>最少直推用户数:<input name="proxy_3_direct_min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_3_direct_min'];?>
" type="text" /></span>
											<span>线下最低市代理数:<input name="proxy_3_proxy2__min" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['proxy_3_proxy2__min'];?>
" type="text" /></span>
										</div>
									</div>
								</div>
								<button class="gx_btn" type="button">更新</button>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
		$(".gx_btn").click(function(){
			var obj = $("#form").serialize();
			$.post("m.php?ctl=conf&act=do_update_argument",obj,function(data){
				if(data){
					var obj1 = eval("("+ data +")");
					if("obj1.status == true"){
						alert(obj1.msg);
					}else{
						alert(obj1.msg);
						return false;
					}
				}
			})
		})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
