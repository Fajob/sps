<?php
/* Smarty version 3.1.32, created on 2018-05-29 20:08:04
  from '/root/project/xcb/admin/view/xtgl/xtgl_k.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d42a4b40e72_12509847',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b541495ae4f041e2e38c0b25b4f507c89580b82a' => 
    array (
      0 => '/root/project/xcb/admin/view/xtgl/xtgl_k.html',
      1 => 1527595682,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d42a4b40e72_12509847 (Smarty_Internal_Template $_smarty_tpl) {
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
		<?php echo '<script'; ?>
 src="/public/js/wwt_style.js"><?php echo '</script'; ?>
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
						<a class="cs_sz" href="m.php?ctl=conf&act=argument">参数设置</a>
						<a class="banner_sz" href="m.php?ctl=conf&act=carousel">轮播图设置</a>
						<a class="k_sz xt_nav_active" href="m.php?ctl=conf&act=kline">K线设置</a>
						<a class="k_sz" href="m.php?ctl=conf&act=share">分享设置</a>
						<a class="k_sz" href="m.php?ctl=log">系统日志</a>
					</div>
					<div class="xt_con">
						<!--导航内容-->
						
						<div class="dh_con">
							<p class="add_sp">
								<button type="button" class="add_btn">
									<i class="layui-icon">&#xe654;</i>添加K线
								</button>
							</p>
							<table border="0">
								<tr>
									<th>id</th>
									<th>时间</th>
									<th>价格</th>
									<th>操作</th>
								</tr>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
								<tr id="<?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
">
									<td class="id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
</td>
									<td class="time"><?php echo $_smarty_tpl->tpl_vars['item1']->value['date'];?>
</td>
									<td><input class="price" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['price'];?>
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
							<div id="demo2"></div>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
		<!--新增导航栏-->
		<div class="add_con none">
			<div class="add_content" style="height: 430px;">
				<i class="layui-icon close">&#x1007;</i>
				<h2 style="float: left;margin-top: 50px;">添加K线</h2>
				<p><span>K线价格</span><input type="text" id="price" placeholder="请输入K线价格"/></p>
				<p><span>K线日期</span><input type="text" id="date" placeholder="请输入K线时间"/></p>
				<p><span>K线时间</span><input type="text" id="test4" placeholder="请输入K线时间"/></p>
				<p style="margin-top: 40px;"><button type="button" class="sub_btn">确认</button></p>
			</div>
		</div>
	</body>
	<?php echo '<script'; ?>
>
	//编辑K线
	$(".bj_btn").click(function(e){
		edit(e);
	});
	
	//关闭K线弹窗
	$('.close').click(function(e){
		close(e);
	})
	//打开增加K线
	$('.add_btn').click(function(){
		open();
	})
	
	
	//时间
	layui.use('laydate', function(){
	    var laydate = layui.laydate;
	    laydate.render({
	    	elem: '#date' //指定元素
	    });
	    laydate.render({
	    elem: '#test4'
	    ,type: 'time'
	  });
	});
	

	
	
	

	//分页
	layui.use(['laypage','layer'],function(){
		var laypage = layui.laypage,
		layer = layui.layer;
		laypage.render({
			elem:'demo2',
			count:<?php echo $_smarty_tpl->tpl_vars['total_kline_count']->value;?>
,
			curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取  
	            var p = location.search.match(/p=(\d+)/);  
	            return p ? p[1] : 1;  
	        }(),
			jump: function(obj,first){//点击页码出发的事件  
	            if(first!=true){//是否首次进入页面  
	                var currentPage = obj.curr;//获取点击的页码   
	                window.location.href ="m.php?ctl=conf&act=kline&p="+currentPage;  
	            }  
	        }  
		})
	})
	
	
	//编辑K线提交
	$(".wc_btn").click(function(){
		var id = $(this).parents("tr").find(".id").text();
		var price = $(this).parents("tr").find(".price").val();
		$.post("m.php?ctl=conf&act=do_update_kline",{"id":id,"price":price},function(data){
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
	
	//删除K线
	$('.del_btn').click(function(){
		var id = $(this).parents("tr").attr("id");
		if(confirm("确认删除吗？？？"))
		{
			$.post("m.php?ctl=conf&act=do_del_kline",{"id":id},function(data){
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
	
	
	//增加K线
	$(".sub_btn").click(function(){
		var price = $("#price").val();
		var date2 = $("#date").val();
		var date1 = $("#test4").val();
		var data = date2+" "+date1;
		var timestamp2 = Date.parse(new Date(data));
		timestamp2 = timestamp2 / 1000;
//		var timestamp1 = Date.parse(new Date(date1));
//		timestamp1 = timestamp1 / 1000;
//		var timestamp = timestamp1+timestamp2
		$.post("m.php?ctl=conf&act=do_add_kline",{"price":price,"date":timestamp2},function(data){
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
	
	
	jQuery(function($){
		var time = document.getElementsByClassName('time');
		for(var i=0;i<time.length;i++){
			time[i].innerText = date(time[i].innerText);
		}
    })
	<?php echo '</script'; ?>
>
</html>
<?php }
}
