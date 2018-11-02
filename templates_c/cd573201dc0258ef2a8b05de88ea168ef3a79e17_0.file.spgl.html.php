<?php
/* Smarty version 3.1.32, created on 2018-05-29 16:42:40
  from '/root/project/xcb/admin/view/spgl/spgl.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d1280dd3bd7_89170068',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd573201dc0258ef2a8b05de88ea168ef3a79e17' => 
    array (
      0 => '/root/project/xcb/admin/view/spgl/spgl.html',
      1 => 1527583351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d1280dd3bd7_89170068 (Smarty_Internal_Template $_smarty_tpl) {
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
		.hyzx table tr td select{
			border: none;
			appearance: none;
		    -moz-appearance: none;
		    -webkit-appearance: none;
		}
		.hyzx table tr td span{
			overflow: hidden;
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
							<a href="m.php?ctl=index">首页</a>
							<a href="m.php?ctl=user">会员中心</a>
							<a href="m.php?ctl=incharge">会员充值</a>
							<a href="m.php?ctl=order">订单中心</a>
							<a href="m.php?ctl=deal" class="hui">商品管理</a>
							<a href="m.php?ctl=type">分类管理</a>
							<a href="m.php?ctl=conf&act=navagation">系统设置</a> 
						</p>
					</li>
					
					
				</ul>
				
			</div>
			<div class="rightCon">
				<div class="hyzx">
					<p class="add_sp" style="width: 30%">
						<button type="button" class="add_btn">
							<i class="layui-icon">&#xe654;</i>新增商品
						</button>
					</p>
					<p style="float: left;line-height: 55px;margin-right: 10px;">选择类别:</p>
					<div class="type">
						<span class="type_name" style="float: left;width: 100%;height: 100%;text-align: center;line-height: 35px;">请选择</span>
						<ul>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['type_info'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
							<li><a href="m.php?ctl=deal&type=<?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
" id=<?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
><?php echo $_smarty_tpl->tpl_vars['item1']->value['type'];?>
</a></li>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</ul>
					</div>
					<table border="0" border-co cellspacing="0" cellpadding="0">
						<tr>
							<th>商品ID</th>
							<th>商品名称</th>
							<th>商品图片</th>
							<th>商品价格(元)</th>
							<th>商品数量</th>
							<th>商品类型</th>
							<th>商品详情</th>
							<th>详情图(最多张)</th>
							<th>商品销量</th>
							<th>是否有效</th>
							<th>操作</th>
						</tr>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['deals_info'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
						<tr>
							<td class="user_id"><?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
</td>
							<td><input type="text" class="deal_name" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['deal_name'];?>
" disabled="true"/></td>
							<td>
								<span>
									<img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img'];?>
"/>
									<img class="img" src="" alt="" />
									<input type="file" class="file" disabled="true"/>
								</span>
							</td>
							<td><input class="current_price" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['current_price'];?>
" disabled="true"/></td>
							<td><input class="stock" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['stock'];?>
" disabled="true"/></td>
							<td>
								<select class="type_name" disabled="true">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['type_info'], 'item2');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item2']->value) {
?>
									<?php if ($_smarty_tpl->tpl_vars['item1']->value['type'] == $_smarty_tpl->tpl_vars['item2']->value['id']) {?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['item2']->value['id'];?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['item2']->value['type'];?>
</option>
									<?php } else { ?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['item2']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item2']->value['type'];?>
</option>
									<?php }?>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</select>
							</td>
							<td><input class="brief" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['brief'];?>
" disabled="true"/></td>
							<td>
								<span style="width: 33.333%;overflow: hidden;">
									<img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img1'];?>
"/>
									<img class="img1" src="" alt="" />
									<input type="file" class="file" disabled="true"/>
								</span>
								<span style="width: 33.333%;overflow: hidden;">
									<img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img2'];?>
"/>
									<img class="img2" src="" alt="" />
									<input type="file" class="file" disabled="true"/>
								</span>
								<span style="width: 33.333%;overflow: hidden;">
									<img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img3'];?>
"/>
									<img class="img3" src="" alt="" />
									<input type="file" class="file" disabled="true"/>
								</span>
							</td>
							<td><input class="" type="text" value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['stock'];?>
" disabled="true"/></td>
							<?php if ($_smarty_tpl->tpl_vars['item1']->value['is_effect'] == 0) {?>
							<td><input class="is_effect" type="text" value="否" disabled="true"/></td>
							<?php } else { ?>
							<td><input class="is_effect" type="text" value="是" disabled="true"/></td>
							<?php }?>
							<td style="display: flex;flex-direction: row;align-items: center;padding: 10px 4px;">
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
					<!--<button type="button" class="dc_btn">导出</button>-->
					<div id="demo2"></div>
				</div>
			</div>
			<!--新增商品内容-->
			<div class="add_con none">
				<div class="add_content" style="height: 570px;">
					<i class="layui-icon close">&#x1007;</i>
					<h2>添加商品</h2>
					<p><span>商品名称:</span><input type="text" class="deal_name" placeholder="请输入商品名称"/></p>
					<p style="height: 60px;">
						<span>商品图片:</span>
						<span class="look_img">
							<img id="img" src="/public/images/up_img.png" alt="" />
							<input class="up-img" type="file"/>
						</span>
						<span style="margin-left: 40px;">详情图(最多3张):</span>
						<span class="look_img">
							<img id="img1" src="images/up_img.png" alt="" />
							<input class="up-img" type="file"/>
						</span>
						<span class="look_img">
							<img id="img2" src="images/up_img.png" alt="" />
							<input class="up-img" type="file"/>
						</span>
						<span class="look_img">
							<img id="img3" src="images/up_img.png" alt="" />
							<input class="up-img" type="file"/>
						</span>
					</p>
					<p><span>商品价格:</span><input class="current_price" type="text" placeholder="请输入商品价格"/></p>
					<p><span>商品数量:</span><input class="stock" type="text" placeholder="请输入商品数量"/></p>
					<p>
						<span>商品类型:</span>
						<select class="type_name">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['type_info'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['item1']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item1']->value['type'];?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</select>
					</p>
					<p><span>商品详情:</span><input type="text" placeholder="请输入商品详情"/></p>
					<p><span>商品销量:</span><input class="xl" type="text" placeholder="请输入商品销量"/></p>
					<p style="margin-top: 25px;"><button type="button" class="sub_btn">确认</button></p>
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
		//编辑商品信息
		$(".bj_btn").click(function(e){
			edit(e);
		});
		
		//提交编辑商品信息
		$(".wc_btn").click(function(e){
			submit_sp(e);
		})
		
		//关闭增加商品弹窗
		$('.close').click(function(e){
			close(e);
		})
		
		//打开增加商品弹窗
		$('.add_btn').click(function(){
			open();
		})
		
		//添加商品中上传图片
		$(".up-img").change( add_img );
		
		//编辑商品更换图片
		$(".file").change( add_img );
		
		//提交商品
		$('.sub_btn').click(function(e){
			add_sp(e);
		})
		
		//删除商品
		$(".del_btn").click(function(e){
			del_sp(e);
			window.location.reload();
		})
		//分页
		layui.use(['laypage','layer'],function(){
			var laypage = layui.laypage,
			layer = layui.layer;
			laypage.render({
				elem:'demo2',
				count:<?php echo $_smarty_tpl->tpl_vars['total_deal_count']->value;?>
,
				curr: function(){ //通过url获取当前页，也可以同上（pages）方式获取  
		            var p = location.search.match(/p=(\d+)/);  
		            return p ? p[1] : 1;  
		        }(),
				jump: function(obj,first){//点击页码出发的事件  
		            if(first!=true){//是否首次进入页面  
		                var currentPage = obj.curr;//获取点击的页码   
		                window.location.href ="m.php?ctl=deal&p="+currentPage;  
		            }  
		        }  
			})
		})
		
		$(".hyzx").on("click",".type>span",function(event){
			$(this).next().toggleClass("ul_xs");
			event.stopPropagation();
		})
		$(document).click(function(){
			$(".type ul").removeClass("ul_xs");
		})
		$(document).on("click",".type ul li",function(){
			var id = $(this).children().attr("id");
			var type = $(this).children().text();
			$(this).parent().prev().val(type)
		})
	<?php echo '</script'; ?>
>
</html>
<?php }
}
