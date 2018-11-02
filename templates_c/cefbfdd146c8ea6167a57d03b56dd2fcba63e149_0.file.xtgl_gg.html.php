<?php
/* Smarty version 3.1.32, created on 2018-05-29 16:42:47
  from '/root/project/xcb/admin/view/xtgl/xtgl_gg.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d1287352d07_88396054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cefbfdd146c8ea6167a57d03b56dd2fcba63e149' => 
    array (
      0 => '/root/project/xcb/admin/view/xtgl/xtgl_gg.html',
      1 => 1527583351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d1287352d07_88396054 (Smarty_Internal_Template $_smarty_tpl) {
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
						<a class="gg_sz xt_nav_active" href="m.php?ctl=conf&act=notice">公告设置</a>
						<a class="cs_sz" href="m.php?ctl=conf&act=argument">参数设置</a>
						<a class="banner_sz" href="m.php?ctl=conf&act=carousel">轮播图设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=kline">K线设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=share">分享设置</a>
						<a class="k_sz" href="m.php?ctl=log">系统日志</a>
					</div>
					<div class="xt_con">
						<!--公告内容-->
						<p class="add_sp">
							<button type="button" class="add_btn">
								<i class="layui-icon">&#xe654;</i>添加公告
							</button>
						</p>
						<table border="0">
							<tr>
								<th>标题</th>
								<th>内容</th>
								<th>操作</th>
							</tr>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
							<tr id="<?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
">
								<td><input type="text" class="title" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['title'];?>
" disabled="true"/></td>
								<td><textarea class="detail" type="text" disabled="true"/><?php echo $_smarty_tpl->tpl_vars['item1']->value['detail'];?>
</textarea></td>
								<td>
									<button class="bj_btn">编辑</button>
									<button class="wc_btn none">确认</button>
									<button class="del_btn">删除</button>
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
		</div>
		<!--新增公告-->
		<div class="add_con none">
			<div class="add_content">
				<i class="layui-icon close">&#x1007;</i>
				<h2 style="float: left;margin-top: 50px;">添加公告</h2>
				<p><span>公告标题</span><input type="text" id="title" placeholder="请输入公告标题"/></p>
				<p style="height: 220px;">
					<span>公告内容</span>
					<textarea id="wenben" type="text" placeholder="请输入公告内容"/></textarea>
				</p>
				<p style="margin-top: 40px;"><button type="button" class="sub_btn">确认</button></p>
			</div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
		//编辑公告信息
		$(".bj_btn").click(function(e){
			edit(e);
			
		});
	
		//关闭新增公告弹窗
		$('.close').click(function(e){
			close(e);
		})
		
		//打开新增公告弹窗
		$('.add_btn').click(function(){
			open();
		})
		//分页
		layui.use(['laypage','layer'],function(){
			var laypage = layui.laypage;
			var laydate = layui.laydate;
			layer = layui.layer;
			laypage.render({
				elem:'demo2',
				count:<?php echo $_smarty_tpl->tpl_vars['total_notice_count']->value;?>
,
				curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取  
		            var p = location.search.match(/p=(\d+)/);  
		            return p ? p[1] : 1;  
		        }(),
				jump: function(obj,first){//点击页码出发的事件  
		            if(first!=true){//是否首次进入页面  
		                var currentPage = obj.curr;//获取点击的页码   
		                window.location.href ="m.php?ctl=conf&act=notice&p="+currentPage;  
		            }  
		        }  
			})
		})
		
		//添加公告
		$(".sub_btn").click(function(){
			var detail = $("#wenben").val();
			var title = $("#title").val();
			$.post("m.php?ctl=conf&act=do_add_notice",{"detail":detail,"title":title},function(data){
				if(data){
					var obj = eval("("+ data +")");
					if(obj.status == true){
						alert(obj.msg);
						window.location.reload();
					}else{
						alert(obj.msg);
						return false;
					}
				}
			})
		})
		
	//编辑公告提交
	$(".wc_btn").click(function(){
		var id = $(this).parents("tr").attr("id");
		var title = $(this).parents("tr").find(".title").val();
		var detail = $(this).parents("tr").find(".detail").val();
		$.post("m.php?ctl=conf&act=do_update_notice",{"id":id,"detail":detail,"title":title},function(data){
			if(data){
				var obj = eval("("+ data +")");
				if(obj.status == true){
					alert(obj.msg);
					window.location.reload();
				}else{
					alert(obj.msg);
					return false;
				}
			}
		})
	})
	//删除导航栏
	$('.del_btn').click(function(){
		var id = $(this).parents("tr").attr("id");
		if(confirm("确认删除吗？？？"))
		{
			$.post("m.php?ctl=conf&act=do_del_notice",{"id":id},function(data){
				if(data){
					var obj = eval("("+data+")");
					if(obj.status == true){
						alert(obj.msg);
						window.location.reload();
					}else{
						alert(obj.msg);
						return false;
					}
				}
			})
		}
	})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
