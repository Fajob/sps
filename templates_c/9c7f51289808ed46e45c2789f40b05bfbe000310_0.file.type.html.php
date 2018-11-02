<?php
/* Smarty version 3.1.32, created on 2018-05-29 16:42:41
  from '/root/project/xcb/admin/view/spgl/type.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d1281874157_72546761',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c7f51289808ed46e45c2789f40b05bfbe000310' => 
    array (
      0 => '/root/project/xcb/admin/view/spgl/type.html',
      1 => 1527583351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d1281874157_72546761 (Smarty_Internal_Template $_smarty_tpl) {
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
							<a href="m.php?ctl=type" class="hui">分类管理</a>
							<a href="m.php?ctl=conf&act=navagation">系统设置</a> 
						</p>
					</li>
					
					
				</ul>
				
			</div>
			<div class="rightCon">
				<div class="hyzx">
					<div class="xt_nav">
						<a class="type_sz xt_nav_active" href="javascript:;">分类设置</a>
					</div>
					<div class="xt_con">
						<!--导航内容-->
						
						<div class="dh_con">
							<p class="add_sp">
								<button type="button" class="add_btn">
									<i class="layui-icon">&#xe654;</i>添加分类
								</button>
							</p>
							<table border="0">
								<tr>
									<th>id</th>
									<th>类目编号</th>
									<th>类目名称</th>
									<th>操作</th>
								</tr>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
								<tr>
									<td class="id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
</td>
									<td><input class="id_index" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['id_index'];?>
" disabled="true"/></td>
									<td><input class="types" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['type'];?>
" disabled="true"/></td>
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
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
		<!--新增导航栏-->
		<div class="add_con none">
			<div class="add_content" style="height: 330px;">
				<i class="layui-icon close">&#x1007;</i>
				<h2 style="float: left;margin-top: 50px;">添加分类</h2>
				<p><span>类目编号</span><input type="text" id="id_index" placeholder="请输入类目编号"/></p>
				<p><span>类目名称</span><input type="text" id="type" placeholder="请输入类目名称"/></p>
				<p style="margin-top: 40px;"><button type="button" class="sub_btn">确认</button></p>
			</div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
	//编辑类目
	$(".bj_btn").click(function(e){
		edit(e);
	});
	
	//关闭类目弹窗
	$('.close').click(function(e){
		close(e);
	})
	//打开增加类目
	$('.add_btn').click(function(){
		open();
	})
	
	

	
	
	

	
	
	
	//编辑类目提交
	$(".wc_btn").click(function(){
		var id = $(this).parents("tr").find(".id").text();
		var id_index = $(this).parents("tr").find(".id_index").val();
		var type = $(this).parents("tr").find(".types").val();
		$.post("m.php?ctl=type&act=do_update",{"id":id,"id_index":id_index,"type":type},function(data){
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
	})
	
	//删除类目
	$('.del_btn').click(function(){
		id = $(this).parents("tr").find(".id").text();
		if(confirm("确认删除吗？？？"))
		{
			$.post("m.php?ctl=type&act=do_del",{"id":id},function(data){
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
	
	
	//增加类目
	$(".sub_btn").click(function(){
		var id_index = $("#id_index").val();
		var type = $("#type").val();
		$.post("m.php?ctl=type&act=do_add",{"id_index":id_index,"type":type},function(data){
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
	})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
