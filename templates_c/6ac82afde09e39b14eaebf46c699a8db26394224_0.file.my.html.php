<?php
/* Smarty version 3.1.32, created on 2018-05-30 16:37:53
  from '/root/project/xcb/wap/view/my/my.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0e62e1a95736_40810609',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ac82afde09e39b14eaebf46c699a8db26394224' => 
    array (
      0 => '/root/project/xcb/wap/view/my/my.html',
      1 => 1527669467,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0e62e1a95736_40810609 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<?php echo '<script'; ?>
 src="/public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<link rel="stylesheet" href="public/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="public/css/media-100.css"/>
		<link rel="stylesheet" type="text/css" href="public/css/login-style.css"/>
		<style>
			.myHead img{
				width: 78px !important;		
				height: 78px !important;	
			}
			.sps-my-info-one #node{
				font-size: 10px;
			}
			.sps-my-info-one span:first-child{
				font-size: 14px;
			}
			.sps-my-info-two img{
				width: 15px !important;
			}
			#level{
				display: inline-block;
			    height: 15px;
			    line-height: 16px;
			    padding: 0 5px;
			    vertical-align: middle;
			}
		</style>
	</head>
	<body>
		<div class="sps-my">
			<div class="sps-my-title">
				<p>
					<a href="tel:40020080800"><img src="public/web/images/service.png"/> </a>
					<a href="index.php?ctl=setting"><img src="public/web/images/set.png"/> </a>
				</p>
				<div class="sps-my-head">
					<div class="myHead">
						<img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['user_avatar'];?>
" />
					</div>
				</div>
			</div>
			<div class="sps-my-info">
				<p class="sps-my-info-one">
					<span><?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['user_name'];?>
&nbsp;</span>
					<span id="level"></span>&nbsp;
					<span id="node">
						
					</span> 
				</p>
				<p class="sps-my-info-two">
					<img src="public/web/images/bi.png" style="vertical-align: middle;"/>
					<span style="vertical-align: middle;">&nbsp;当前sps商链价格=<?php echo $_smarty_tpl->tpl_vars['data']->value['coin_price'];?>
元</span>
				</p>
				<div class="sps-my-info-three">
					<table>
						<tr>
							<td><a href="index.php?ctl=user&act=consume_credits">
								<p>购物积分</p>
								<p style="font-size:21px;color: #FF8C06;"><?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['consume_credits'];?>
</p>
							</a></td>
							<td><a href="index.php?ctl=user&act=cz_sps">
								<p>可用SPS链</p>
								<p style="font-size:21px;color: #FF8C06;"><?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['cz_chain'];?>
</p>
							</a></td>
							<td><a href="index.php?ctl=user&act=my_sps">
								<p>SPS锁仓链</p>
								<p style="font-size:21px;color: #FF8C06;"><?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['sc_chain'];?>
</p>
							</a></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="sps-mylist-one">
				<ul class="mui-table-view">
		            <li class="mui-table-view-divider"></li>		           
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=total_benefit" class="">
		                    <span class="sps-mylist-left"><img src="public/web/images/total_earns.png" />&nbsp;&nbsp;&nbsp;总收益</span>	
		                    <span class="sps-mylist-right"><span id="static_dynamic"></span>&nbsp;<img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=total_consume" class="">
		                    <span class="sps-mylist-left"><img src="/public/web/images/team_performence.png" />&nbsp;&nbsp;&nbsp;团队总业绩</span>	
		                    <span class="sps-mylist-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['total_consume'];?>
&nbsp;<img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <li class="mui-table-view-divider"></li>
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=order&p=1&order_status=1" class="sps-mylist-item">
		                    <span class="sps-mylist-left"><img src="public/web/images/my_order.png" />&nbsp;&nbsp;&nbsp;我的订单</span>
		                    <span class="sps-mylist-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['order_num'];?>
&nbsp;<img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=suolian_benjin" class="">
		                    <span class="sps-mylist-left"><img src="public/web/images/voluntary_lock.png" />&nbsp;&nbsp;&nbsp;锁链本金</span>	
		                    <span class="sps-mylist-right"><img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=sc_sps" class="">
		                    <span class="sps-mylist-left"><img src="public/web/images/voluntary_lock.png" />&nbsp;&nbsp;&nbsp;主动锁SPS链</span>	
		                    <span class="sps-mylist-right"><img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <?php if ($_smarty_tpl->tpl_vars['data']->value['node_type'] == 0) {?>
		            <?php } else { ?>
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=share" class="">
		                    <span class="sps-mylist-left"><img src="public/web/images/share.png" />&nbsp;&nbsp;&nbsp;分享好友</span>	
		                    <span class="sps-mylist-right"><img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <?php }?>
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=account&act=account_gl" class="">
		                    <span class="sps-mylist-left"><img src="public/web/images/acc_manage.png" />&nbsp;&nbsp;&nbsp;账户管理</span>	
		                    <span class="sps-mylist-right"><img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		            <li class="mui-table-view-divider"></li>		           
		            <li class="mui-table-view-cell">
		                <a href="index.php?ctl=user&act=about" class="">
		                    <span class="sps-mylist-left"><img src="public/web/images/about.png" />&nbsp;&nbsp;&nbsp;关于SPS</span>	
		                    <span class="sps-mylist-right"><img src="public/web/images/step_in.png" /></span>		                    
		                </a>
		            </li>
		        </ul>
			</div>
			<div class="footer">
		        <table>
					<tr>
						<td>
							<a href="index.php?ctl=user&act=home">
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/home_dark.png"/></span>
		                    <div style="color: #D4C9B4;" class="bottomMenuWords">首页</div></a>
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
		                    <span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/mine_light.png"/></span>
		                    <div style="color: #00D1FF;" class="bottomMenuWords">我的</div></a>
						</td>
					</tr>
				</table>
			</div>
		<?php echo '<script'; ?>
 src="public/js/sps.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript">
			var lv = '<?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['user_level'];?>
';
			if(myLv(lv) == ''){
				$('#level').remove();
			}else{		
				$('#level').text(myLv(lv));
			}
			var nd = '<?php echo $_smarty_tpl->tpl_vars['data']->value['node_type'];?>
';
			$('#node').text(myNode(nd));
			var staticR = '<?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['static_reward'];?>
';
			var dynamicR = '<?php echo $_smarty_tpl->tpl_vars['data']->value['user_info']['dynamic_reward'];?>
';
			$('#static_dynamic').text((parseFloat(staticR)+parseFloat(dynamicR)).toFixed(2));
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
