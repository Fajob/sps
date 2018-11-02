<?php
/* Smarty version 3.1.32, created on 2018-05-29 16:42:42
  from '/root/project/xcb/admin/view/xtgl/xtgl_dh.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d12822f1d91_61351072',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b0f66392ed747c2b904b0c49bf739a685a29ef29' => 
    array (
      0 => '/root/project/xcb/admin/view/xtgl/xtgl_dh.html',
      1 => 1527583351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d12822f1d91_61351072 (Smarty_Internal_Template $_smarty_tpl) {
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
						<a class="dh_sz xt_nav_active" href="m.php?ctl=conf&act=navagation">导航栏设置</a>
						<a class="gg_sz" href="m.php?ctl=conf&act=notice">公告设置</a>
						<a class="cs_sz" href="m.php?ctl=conf&act=argument">参数设置</a>
						<a class="banner_sz" href="m.php?ctl=conf&act=carousel">轮播图设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=kline">K线设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=share">分享设置</a>
						<a class="k_sz" href="m.php?ctl=log">系统日志</a>
					</div>
					<div class="xt_con">
						<!--导航内容-->
						
						<div class="dh_con">
							<p class="add_sp">
								<button type="button" class="add_btn">
									<i class="layui-icon">&#xe654;</i>添加导航
								</button>
							</p>
							<table border="0">
								<tr>
									<th>顺序</th>
									<th>图标</th>
									<th>名称</th>
									<th>链接</th>
									<th>操作</th>
								</tr>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
								<tr id="<?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
">
									<td><input class="id_index" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['id_index'];?>
" disabled="true"/></td>
									<td>
										<span>
											<img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img'];?>
"/>
											<img class="img" src="" alt="" />
											<input type="file" class="file" disabled="true"/>
										</span>
									</td>
									<td><input class="nav_name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['name'];?>
" disabled="true"/></td>
									<td><input class="link" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['link'];?>
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
			<div class="add_content">
				<i class="layui-icon close">&#x1007;</i>
				<h2 style="float: left;margin-top: 50px;">添加导航</h2>
				<p><span>导航编号</span><input type="text" id="id_index" placeholder="请输入导航编号"/></p>
				<p><span>导航名称</span><input type="text" id="nav_name" placeholder="请输入导航名称"/></p>
				<p><span>导航链接</span><input type="text" id="link" placeholder="请输入导航链接"/></p>
				<p style="height: 60px;">
					<span>导航图片</span>
					<span class="look_img">
						<img id="img" src="/public/images/up_img.png" alt="" />
						<input class="up-img" type="file"/>
					</span>
				</p>
				<p style="margin-top: 40px;"><button type="button" class="sub_btn">确认</button></p>
			</div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
	//编辑导航信息
	$(".bj_btn").click(function(e){
		edit(e);
	});
	
	//关闭导航弹窗
	$('.close').click(function(e){
		close(e);
	})
	//打开增加导航弹窗
	$('.add_btn').click(function(){
		open();
	})
		
	//提交导航图片
	$(".up-img").change( add_img );
	
	//编辑导航更换图片
	$(".file").change( add_img );
	
	

	
	
	//添加导航
	
	//编辑导航提交
	$(".wc_btn").click(function(){
		var id = $(this).parents("tr").attr("id");
		var id_index = $(this).parents("tr").find(".id_index").val();
		var img = $(this).parents("tr").find(".img").attr("src");
		var name = $(this).parents("tr").find(".nav_name").val();
		var link = $(this).parents("tr").find(".link").val();
		$.post("m.php?ctl=conf&act=do_update_navigation",{"id":id,"id_index":id_index,"name":name,"img":img,"link":link},function(data){
			if(data){
				var obj = eval("("+data+")");
				if(obj.status == true){
					alert(obj.msg);
					window.location.reload();
				}
			}
		})
	})
	
	//删除导航栏
	$('.del_btn').click(function(){
		var id = $(this).parents("tr").attr("id");
		if(confirm("确认删除吗？？？"))
		{
			$.post("m.php?ctl=conf&act=do_del_navigation",{"id":id},function(data){
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
	
	
	//增加导航栏
	$(".sub_btn").click(function(){
		var id_index = $("#id_index").val();
		var name = $("#nav_name").val();
		var img = $("#img").attr("src");
		var link = $("#link").val();
		$.post("m.php?ctl=conf&act=do_add_navigation",{"id_index":id_index,"name":name,"img":img,"link":link},function(data){
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
