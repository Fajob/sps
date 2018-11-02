<?php
/* Smarty version 3.1.32, created on 2018-05-30 10:30:44
  from '/root/project/xcb/admin/view/hygl/hygl.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0e0cd456f044_38484410',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '428c2da64b0844f17900be91ef9b9f39256f10ba' => 
    array (
      0 => '/root/project/xcb/admin/view/hygl/hygl.html',
      1 => 1527646794,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0e0cd456f044_38484410 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
		<link rel="stylesheet" type="text/css" href="/public/css/style.css"/>
		<link rel="stylesheet" href="public/css/layui.css" />
		<?php echo '<script'; ?>
 src="public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="public/js/layui.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="public/js/style.js"><?php echo '</script'; ?>
>
	</head>
	<body style="width: 100%;min-width: 1300px;max-width: 100%;">
		<div class="indexCon">
			<div class="nav">
				<div class="logo"><img src="public/images/logo_a.png"/></div>
				<div class="info">
					<!--<p style="color: #666;line-height: 40px;font-size:17px">欢迎 <span> 李小二 </span> [HD88]</p>
					<p style="color: #333;font-size: 14px;line-height: 25px;"> <span> 2018-02-07 18:06 </span> PM</p>-->
				</div>
				<div class="right">
					<button type="button" class="back_btn">退出</button>
				</div>
			</div>
			<div class="leftNav">
				
				<ul>
					<li class="title">
						<p>
							<a href="m.php?ctl=index">首页</a>
							<a href="m.php?ctl=user" class="hui">会员中心</a>
							<a href="m.php?ctl=incharge">会员充值</a>
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
					<div class="search">
						<button type="button" class="dc_btn">导出</button>
						<button type="button" class="search_btn">搜索</button>
						<input type="text" class="search_name" placeholder="输入要查询的真是姓名"/>
						<input type="text" class="search_id" placeholder="输入要查询的id"/>
						<input type="text" class="search_p_id" placeholder="输入要查询的推荐人id"/>
						<input type="text" class="search_mobile" placeholder="输入要查询的手机号"/>
					</div>
					<table border="0" border-co cellspacing="0" cellpadding="0" id="tab">
						<tr>
							<th>id</th>
							<th>昵称</th>
							<th>会员等级</th>
							<th>真实姓名</th>
							<th>手机</th>
							<th>推荐人ID</th>
							<th>购物积分</th>
							<th>持币算力</th>
							<th>推广算力</th>
							<th>可用sps链</th>
							<th>锁仓链</th>
							<th>趴点</th>
							<th>是否有效</th>
							<th>操作</th>
						</tr>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['users_info'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
							<tr>
							<td style="width: 50px;" class="user_id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
</td>
							<td><input type="text" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['user_name'];?>
" disabled="true"/></td>
							<td><input type="text" name="user_level" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['user_level'];?>
" disabled="true"/></td>
							<td><input type="text" name="real_name" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['real_name'];?>
" disabled="true"/></td>
							<td><input type="text" name="phone_number" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['phone_number'];?>
" disabled="true"/></td>
							<td class="p_id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['p_id'];?>
</td>
							<td class="consume_credits"><?php echo $_smarty_tpl->tpl_vars['item1']->value['consume_credits'];?>
</td>
							<td class="static_reward"><?php echo $_smarty_tpl->tpl_vars['item1']->value['static_reward'];?>
</td>
							<td class="dynamic_reward"><?php echo $_smarty_tpl->tpl_vars['item1']->value['dynamic_reward'];?>
</td>
							<td class="cz_chain"><?php echo $_smarty_tpl->tpl_vars['item1']->value['cz_chain'];?>
</td>
							<td class="sc_chain"><?php echo $_smarty_tpl->tpl_vars['item1']->value['sc_chain'];?>
</td>
							<td><input type="text" name="p_rate" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['p_rate'];?>
" disabled="true"/></td>
							<td><input type="text" class="xg" name="is_valid" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['is_valid'];?>
" disabled="true"/></td>
							<td style="width: 120px;">
								<button type="button" class="bj_btn">编辑</button>
								<button type="button" class="wc_btn none">确认</button>
								<button type="button" class="del_btn">删除</button>
							</td>
							</tr>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</table>
					
					<div id="demo2"></div>
				</div>
			</div>
		</div>
	</body>
	<style>
	.dc_btn{
		float: right;
	    width: 70px;
	    height: 30px;
	    line-height: 30px;
	    text-align: center;
	    border: none;
	    outline: none;
	    background: #01a8ff;
	    color: #fff;
	    font-size: 16px;
	    border-radius: 5px;
	    margin: 6px 15px;
	    cursor: pointer;
	}
	</style>
	<?php echo '<script'; ?>
>
		//编辑会员信息
		$(".bj_btn").click(function(e){
			edit(e);
		});
		
		//提交会员
		$(".wc_btn").click(function(e){
			submit(e);
		})
		
		//删除会员
		$(".del_btn").click(function(e){
			del_user_info(e);
		})
		
		//退出
		$(".back_btn").click(function(){
			back();
		})
		$(window).ready(function(){
			tihuan();
		})
		//搜索会员
		$('.search_btn').click(function(){
			search();
		})
		
		//分页 
		layui.use(['laypage','layer'],function(){
			var laypage = layui.laypage,
			layer = layui.layer;
			laypage.render({
				elem:'demo2',
				count:<?php echo $_smarty_tpl->tpl_vars['total_user_count']->value;?>
,
				curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取  
		            var p = location.search.match(/p=(\d+)/);  
		            return p ? p[1] : 1;  
		        }(),
				jump: function(obj,first){//点击页码出发的事件  
		            if(first!=true){//是否首次进入页面  
		                var currentPage = obj.curr;//获取点击的页码   
		                window.location.href ="m.php?ctl=user&p="+currentPage;  
		            }  
		        }  
			})
		})
		
		
		//导出
		$(document).on("click",".dc_btn",function(){
			window.location.href="m.php?ctl=user&act=do_export";
		})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
