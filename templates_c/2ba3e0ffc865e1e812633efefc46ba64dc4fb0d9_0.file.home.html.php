<?php
/* Smarty version 3.1.32, created on 2018-05-29 19:25:31
  from '/root/project/xcb/wap/view/home.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0d38abb298b1_48886991',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ba3e0ffc865e1e812633efefc46ba64dc4fb0d9' => 
    array (
      0 => '/root/project/xcb/wap/view/home.html',
      1 => 1527593126,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0d38abb298b1_48886991 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<?php echo '<script'; ?>
 src="/public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<link rel="stylesheet" href="/public/css/mui.min.css">
		<link rel="stylesheet" href="/public/css/media-100.css"/>
		<link rel="stylesheet" href="/public/css/login-style.css"/>
		<style>
			.lunbo-img a img{
				height: 214px;
			}
			#first a img{
				height: 214px;
			}
			#last a img{
				height: 214px;
			}
			.word a:link{
				color: #00D1FF;
			}
		</style>
	</head>
	<body>
		<div class="home">
			<div id="slider" class="mui-slider" >
				<div class="mui-slider-group mui-slider-loop">
					<!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
					<div id="first" class="mui-slider-item mui-slider-item-duplicate">
						<a href="#">
							<img src="" />
						</a>
					</div>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['carousel'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
					<div class="mui-slider-item lunbo-img">
						<a href="<?php echo $_smarty_tpl->tpl_vars['item1']->value['link'];?>
">
							<img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img'];?>
" />
						</a>
					</div>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
					<div id="last" class="mui-slider-item mui-slider-item-duplicate">
						<a href="#">
							<img src="" />
						</a>
					</div>
				</div>
				<div class="mui-slider-indicator">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['carousel'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
					<div style="width: 2rem;height: 6px;border-radius: 25px;opacity: 0.8;" class="mui-indicator mui-active"></div>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</div>
			</div>				
			<div class="title">
				<span class="title-C"></span><br />
				<span class="title-E"></span>
			</div>
			<div class="paomadeng">
				<img src="/public/web/images/trumpet.png" />
				<div class="word">
					<a href="index.php?ctl=user&act=notice"><marquee behavior="scroll"><?php echo $_smarty_tpl->tpl_vars['data']->value['notice'][0]['detail'];?>
</marquee></a>
				</div>
			</div>
			<div class="mui-content">
		        <ul class="mui-table-view mui-grid-view mui-grid-9">
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="index.php?ctl=mall">
		                    <span class="mui-icon"><img src="/public/web/images/sps_market.png"/> </span>
		                    <div class="mui-media-body">SPS商城</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/check_folk.png"/></span>
		                    <div class="mui-media-body">防伪溯源平台</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/alliance.png"/></span>
		                    <div class="mui-media-body">联盟商家</div></a></li>
		            <!--<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="index.php?ctl=trade&act=index">
		                    <span class="mui-icon"><img src="/public/web/images/property_anounce.png"/></span>
		                    <div class="mui-media-body">资产发布</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="index.php?ctl=trade&act=asset_trading_pt_buy">
		                    <span class="mui-icon"><img src="/public/web/images/transfer_plat.png"/></span>
		                    <div class="mui-media-body">资产交易平台</div></a></li>-->
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/property_anounce.png"/></span>
		                    <div class="mui-media-body">资产发布</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/transfer_plat.png"/></span>
		                    <div class="mui-media-body">资产交易平台</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/transfer.png"/></span>
		                    <div class="mui-media-body">区块链教育</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="index.php?ctl=user&act=myinfo">
		                    <span class="mui-icon"><img src="/public/web/images/my_acc.png"/></span>
		                    <div class="mui-media-body">我的账户</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/others.png"/></span>
		                    <div class="mui-media-body">第三方服务</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/pay.png"/></span>
		                    <div class="mui-media-body">SPS支付</div></a></li>
		            <!--<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="index.php?ctl=translate">
		                    <span class="mui-icon"><img src="/public/web/images/pay.png"/></span>
		                    <div class="mui-media-body">SPS支付</div></a></li>-->
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('没有更多！')">
		                    <span class="mui-icon"><img src="/public/web/images/more.png"/></span>
		                    <div class="mui-media-body">更多</div></a></li>        
		        </ul> 
			</div>
			<div class="application-scenarios">
				<div class="application-scenarios-title">
					<div class="application-scenarios-square"></div>
					<span>应用场景</span>
				</div>
				<ul class="mui-table-view mui-grid-view mui-grid-9">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['navigation'], 'item1');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item1']->value) {
?>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="<?php echo $_smarty_tpl->tpl_vars['item1']->value['link'];?>
">
		                    <span class="mui-icon"><img src="<?php echo $_smarty_tpl->tpl_vars['item1']->value['img'];?>
"/> </span>
		                    <div class="mui-media-body"><?php echo $_smarty_tpl->tpl_vars['item1']->value['name'];?>
</div></a></li>
		            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>        
		            <!--<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/feixiaohao.png"/></span>
		                    <div class="mui-media-body">非小号</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/juhuasuan.png"/></span>
		                    <div class="mui-media-body">聚划算</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/bide.png"/></span>
		                    <div class="mui-media-body">币得</div></a></li>
		            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="javascript:;" onclick="alert('暂未开放！')">
		                    <span class="mui-icon"><img src="/public/web/images/weipinhui.png"/></span>
		                    <div class="mui-media-body">即将开放</div></a></li>  -->    
		        </ul>
			</div>
			<div class="footer">
		        <table>
					<tr>
						<td>
							<a href="index.php?ctl=user&act=home">
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/home_light.png"/></span>
		                    <div style="color: #00D1FF;" class="bottomMenuWords">首页</div></a>
						</td>
						<td>
							<a href="index.php?ctl=mall">
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/market_dark.png"/></span>
		                    <div style="color: #D4C9B4;" class="bottomMenuWords">SPS商城</div></a>
						</td>
						<td>
							<a href="index.php?ctl=mall&act=cart_detail">
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/shoppingcar_dark.png"/></span>
		                    <div style="color: #D4C9B4;" class="bottomMenuWords">购物车</div></a>
						<!--<td>
							<a href="index.php?ctl=translate">
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/pay_dark.png"/></span>
		                    <div style="color: #D4C9B4;" class="bottomMenuWords">SPS支付</div></a>
						</td>-->
						<td>
							<a href="index.php?ctl=user&act=myinfo">
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/mine_dark.png"/></span>
		                    <div style="color: #D4C9B4;" class="bottomMenuWords">我的</div></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php echo '<script'; ?>
 src="/public/js/mui.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/public/js/sps.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" charset="utf-8">
			var slider = mui("#slider");
			window.onload = function(){	
				slider.slider({
					interval: 1000
				});
			}
			var d1 = document.getElementsByClassName('lunbo-img')[0];
			var a1 = d1.getElementsByTagName('a')[0];
			var i1 = a1.getElementsByTagName('img')[0];
			$('#last a').attr('href',a1.getAttribute('href'));
			$('#last a img').attr('src',i1.getAttribute('src'));
			var d2 = document.getElementsByClassName('lunbo-img');
			var d2 = d2[d2.length-1];
			var a2 = d2.getElementsByTagName('a')[0];
			var i2 = a2.getElementsByTagName('img')[0];
			$('#first a').attr('href',a2.getAttribute('href'));
			$('#first a img').attr('src',i2.getAttribute('src'));
			
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
