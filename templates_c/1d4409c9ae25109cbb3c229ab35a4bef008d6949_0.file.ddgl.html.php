<?php
/* Smarty version 3.1.32, created on 2018-05-29 16:42:40
  from '/root/project/xcb/admin/view/ddgl/ddgl.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d12803ec8f7_27875392',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d4409c9ae25109cbb3c229ab35a4bef008d6949' => 
    array (
      0 => '/root/project/xcb/admin/view/ddgl/ddgl.html',
      1 => 1527583351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d12803ec8f7_27875392 (Smarty_Internal_Template $_smarty_tpl) {
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
 src="/public/js/style.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/public/js/layui.js"><?php echo '</script'; ?>
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
					<button type="button">退出</button>
				</div>
			</div>
			<div class="leftNav">
				
				<ul>
					<li class="title">
						<p>
							<a href="m.php?ctl=index">首页</a>
							<a href="m.php?ctl=user">会员中心</a>
							<a href="m.php?ctl=incharge">会员充值</a>
							<a href="m.php?ctl=order" class="hui">订单中心</a>
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
					<button class="search_btn" type="button">搜索</button>
					<input type="text" placeholder="请输入关键字"/>
					<select name="" class="lm_s">
						<option value="">请选择搜索类目</option>
						<option value="order_sn">订单号</option>
						<option value="user_id">会员ID</option>
						<option value="user_name">会员昵称</option>
						<option value="express_num">快递编号</option>
					</select>
					
					</div>
					<table border="0" border-co cellspacing="0" cellpadding="0">
						<tr>
							<th>编号</th>
							<th>订单号</th>
							<th>商品ID</th>
							<th>商品名称</th>
							<th>会员ID</th>
							<th>会员昵称</th>
							<th>订单金额</th>
							<th>下单时间</th>
							<th>快递单号</th>
							<th>发货状态</th>
							<th>操作</th>
						</tr>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['orders_info'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
						<tr>
							<td class="fh_id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
</td>
							<td class="order_sn"><?php echo $_smarty_tpl->tpl_vars['item1']->value['order_sn'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['item1']->value['deal_id'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['item1']->value['deal_name'];?>
</td>
							<td class="user_id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['user_id'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['item1']->value['user_name'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['item1']->value['price'];?>
</td>
							<td class="time"><?php echo $_smarty_tpl->tpl_vars['item1']->value['end_time'];?>
</td>
							<td><input class="express_num" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['express_num'];?>
"/></td>
							<td class="sp_status"><?php echo $_smarty_tpl->tpl_vars['item1']->value['order_status'];?>
</td>
							<td>
								<button class="bj_btn" style="width: auto;height: auto;padding: 0 10px;">发货</button>
								<button class="del_btn" style="width: auto;height: auto;padding: 0 10px;">删除</button>
							</td>
						</tr>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</table>
					<button type="button" class="dc_btn">导出</button>
					<div id="demo2"></div>
				</div>
			</div>
		</div>
	</body>
	<style>
	.dc_btn{
		float: right;
	    width: 50px;
	    height: 30px;
	    line-height: 30px;
	    text-align: center;
	    border: none;
	    outline: none;
	    background: #FF5722;
	    color: #fff;
	    font-size: 16px;
	    border-radius: 5px;
	    margin: 15px 15px;
	    cursor: pointer;
	}
	</style>
	<?php echo '<script'; ?>
>
		//发货状态
		$(window).ready(function(e){
			fh_status(e);
		});
		
		//发货
		$(".bj_btn").click(function(e){
			go_fh(e);
		})
		
		//删除订单
		$(".del_btn").click(function(e){
			del_dd(e);
		})
		
		//搜索
		$('.search_btn').click(function(e){
			sp_search(e);
		})
		
		//分页
		layui.use(['laypage','layer'],function(){
			var laypage = layui.laypage,
			layer = layui.layer;
			laypage.render({
				elem:'demo2',
				count:<?php echo $_smarty_tpl->tpl_vars['total_order_count']->value;?>
,
				curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取  
		            var p = location.search.match(/p=(\d+)/);  
		            return p ? p[1] : 1;  
		        }(),
				jump: function(obj,first){//点击页码出发的事件  
		            if(first!=true){//是否首次进入页面  
		                var currentPage = obj.curr;//获取点击的页码   
		                window.location.href ="m.php?ctl=order&p="+currentPage;  
		            }  
		        }  
			})
		})
		jQuery(function($){
			var time = document.getElementsByClassName('time');
			for(var i=0;i<time.length;i++){
				time[i].innerText = date(time[i].innerText);
			}
	    })
		
		//导出
		$(document).on("click",".dc_btn",function(){
			window.location.href="m.php?ctl=order&act=do_export";
		})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
