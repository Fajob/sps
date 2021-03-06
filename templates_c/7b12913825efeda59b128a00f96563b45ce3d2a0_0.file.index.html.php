<?php
/* Smarty version 3.1.32, created on 2018-05-30 11:13:17
  from '/root/project/xcb/wap/view/mall/index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b0e16cd83d066_48113384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b12913825efeda59b128a00f96563b45ce3d2a0' => 
    array (
      0 => '/root/project/xcb/wap/view/mall/index.html',
      1 => 1527649992,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b0e16cd83d066_48113384 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<?php echo '<script'; ?>
 src="public/js/jquery-2.1.4.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="public/js/layer/layer.js"><?php echo '</script'; ?>
>
		<link rel="stylesheet" href="/public/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="/public/css/media-100.css" />
		<link rel="stylesheet" type="text/css" href="/public/css/market-style.css" />
		<style>
			.bottomMenuWords {
				font-size: 14px;
			}
			
			.saleNo {
				font-size: 12px;
				color: #7D7D7D;
			}
			
			.sps-market-bar table tr td {
				width: 33.3%;
			}
			
			.active {
				color: red !important;
			}
			
			.sps-content .mui-table-view .mui-media-object{
				width: 100px;
				max-width: 100px;
			}
		</style>
	</head>

	<body>
		<div class="sps-market">
			<div class="sps-search">
				<div class="sps-search-box">
					<img src="/public/web/images/search.png" />
					<input id="searchInput" value="" type="text" />
					<span id="search">搜索</span>
				</div>
				<div class="sps-market-bar">
					<table>
						<tr>
							<td>
								<a id="xl" href="javascript:;">销量</a>
							</td>
							<td style="text-align: center;">
								<a id="xp" href="javascript:;">新品</a>
							</td>
							<td style="text-align: right;">
								<a id="jg" href="javascript:;">价格<img src="/public/web/images/default_price.png" /></a>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="sps-content">
				<ul class="mui-table-view">

				</ul>
			</div>
			<div class="footer">
				<table>
					<tr>
						<td>
							<a href="index.php?ctl=user&act=home">
								<span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/home_dark.png"/></span>
								<div style="color: #D4C9B4;" class="bottomMenuWords">首页</div>
							</a>
						</td>
						<td>
							<a href="index.php?ctl=mall">
								<span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/market_light.png"/></span>
								<div style="color: #00D1FF;" class="bottomMenuWords">SPS商城</div>
							</a>
						</td>
						<td>
							<a href="index.php?ctl=mall&act=cart_detail">
								<span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/shoppingcar_dark.png"/></span>
								<div style="color: #D4C9B4;" class="bottomMenuWords">购物车</div>
							</a>
							<!--<td>
								<a href="index.php?ctl=translate">
									<span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/pay_dark.png"/></span>
									<div style="color: #D4C9B4;" class="bottomMenuWords">SPS支付</div>
								</a>
							</td>-->
							<td>
								<a href="index.php?ctl=user&act=myinfo">
									<span><img class="bottomMenuIcon" style="height: 25px;" src="/public/web/images/mine_dark.png"/></span>
									<div style="color: #D4C9B4;" class="bottomMenuWords">我的</div>
								</a>
							</td>
					</tr>
				</table>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			var j = 0; //商品个数
			var p = 1; //页数
			//默认
			$.post('api/index.php?ctl=order&act=get_deal_list&p=1', function(data) {
				if(data) {
					var obj = eval('(' + data + ')')
					if(obj.status == true) {
						for(var i = 0; i < obj.deal_list.length; i++) {
							$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
							$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
							$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
							$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
							$('#d' + j).append('<p id="p' + j + '"></p>');
							$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
							$('#s' + j).after('<button>点击购买</button>');
							$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
							j++;
						}
					} else {
						layer.msg(obj.msg, function() {

						});
					}
				} else {
					alert('服务器返回一个错误')
				}
			})
			//销量
			$('#xl').click(function() {
				$('.mui-table-view').empty();
				j = 0;
				p = 1;
				$('#xl').addClass('active');
				$('#xp').removeClass('active');
				$('#jg').removeClass('active');
				$('#jg img').attr('src', '/public/web/images/default_price.png');
				$.post('api/index.php?ctl=order&act=get_deal_list&p=1&key1=xl', function(data) {
					if(data) {
						var obj = eval('(' + data + ')')
						if(obj.status == true) {
							for(var i = 0; i < obj.deal_list.length; i++) {
								$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
								$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
								$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
								$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
								$('#d' + j).append('<p id="p' + j + '"></p>');
								$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
								$('#s' + j).after('<button>点击购买</button>');
								$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
								j++;
							}
						} else {
							layer.msg(obj.msg, function() {

							});
						}
					} else {
						alert('服务器返回一个错误')
					}
				})
			})
			//新品
			$('#xp').click(function() {
				$('.mui-table-view').empty();
				j = 0;
				p = 1;
				$('#xl').removeClass('active');
				$('#xp').addClass('active');
				$('#jg').removeClass('active');
				$('#jg img').attr('src', '/public/web/images/default_price.png');
				$.post('api/index.php?ctl=order&act=get_deal_list&p=1&key1=xp', function(data) {
					if(data) {
						var obj = eval('(' + data + ')')
						if(obj.status == true) {
							for(var i = 0; i < obj.deal_list.length; i++) {
								$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
								$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
								$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
								$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
								$('#d' + j).append('<p id="p' + j + '"></p>');
								$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
								$('#s' + j).after('<button>点击购买</button>');
								$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
								j++;
							}
						} else {
							layer.msg(obj.msg, function() {

							});
						}
					} else {
						alert('服务器返回一个错误')
					}
				})
			})
			$('#jg').click(function() {
				if($('#jg img').attr('src') == '/public/web/images/to_high.png') { //价格降
					$('.mui-table-view').empty();
					j = 0;
					p = 1;
					$('#xl').removeClass('active');
					$('#xp').removeClass('active');
					$('#jg').addClass('active');
					$('#jg img').attr('src', '/public/web/images/to_low.png');
					$.post('api/index.php?ctl=order&act=get_deal_list&p=1&key1=jg1', function(data) {
						if(data) {
							var obj = eval('(' + data + ')')
							if(obj.status == true) {
								for(var i = 0; i < obj.deal_list.length; i++) {
									$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
									$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
									$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
									$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
									$('#d' + j).append('<p id="p' + j + '"></p>');
									$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
									$('#s' + j).after('<button>点击购买</button>');
									$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									j++;
								}
							} else {
								layer.msg(obj.msg, function() {

								});
							}
						} else {
							alert('服务器返回一个错误')
						}
					})
				} else { //价格升
					$('.mui-table-view').empty();
					j = 0;
					p = 1;
					$('#xl').removeClass('active');
					$('#xp').removeClass('active');
					$('#jg').addClass('active');
					$('#jg img').attr('src', '/public/web/images/to_high.png');
					$.post('api/index.php?ctl=order&act=get_deal_list&p=1&key1=jg2', function(data) {
						if(data) {
							var obj = eval('(' + data + ')')
							if(obj.status == true) {
								for(var i = 0; i < obj.deal_list.length; i++) {
									$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
									$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
									$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
									$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
									$('#d' + j).append('<p id="p' + j + '"></p>');
									$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
									$('#s' + j).after('<button>点击购买</button>');
									$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									j++;
								}
							} else {
								layer.msg(obj.msg, function() {

								});
							}
						} else {
							alert('服务器返回一个错误')
						}
					})
				}
			})
			//搜索
			$('#search').click(function() {
				$('.mui-table-view').empty();
				$('#xl').removeClass('active');
				$('#xp').removeClass('active');
				$('#jg').removeClass('active');
				$('#jg img').attr('src', '/public/web/images/default_price.png');
				var searchInput = $('#searchInput').val();
				j = 0;
				p = 1;
				$.post('api/index.php?ctl=order&act=get_deal_list&p=1&key=' + searchInput, function(data) {
					if(data) {
						var obj = eval('(' + data + ')')
						if(obj.status == true) {
							for(var i = 0; i < obj.deal_list.length; i++) {
								$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
								$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
								$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
								$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
								$('#d' + j).append('<p id="p' + j + '"></p>');
								$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
								$('#s' + j).after('<button>点击购买</button>');
								$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
								j++;
							}
						} else {
							layer.msg(obj.msg, function() {

							});
						}
					} else {
						alert('服务器返回一个错误')
					}
				})
			})
			$(window).on('scroll', function() {
				var searchInput = $('#searchInput').val();
				if($(window).scrollTop() >= $(document).height() - $(window).height()) {
					p++;
					if($('#xl').hasClass('active')) {
						$.post('api/index.php?ctl=order&act=get_deal_list&p=' + p + '&key1=xl', function(data) {
							if(data) {
								var obj = eval('(' + data + ')')
								if(obj.status == true) {
									for(var i = 0; i < obj.deal_list.length; i++) {
										$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
										$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
										$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
										$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
										$('#d' + j).append('<p id="p' + j + '"></p>');
										$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
										$('#s' + j).after('<button>点击购买</button>');
										$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									}
								} else {
									layer.msg(obj.msg, function() {

									});
								}
							} else {
								alert('服务器返回一个错误')
							}
						})
					} else if($('#xp').hasClass('active')) {
						$.post('api/index.php?ctl=order&act=get_deal_list&p=' + p + '&key1=xp', function(data) {
							if(data) {
								var obj = eval('(' + data + ')')
								if(obj.status == true) {
									for(var i = 0; i < obj.deal_list.length; i++) {
										$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
										$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
										$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
										$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
										$('#d' + j).append('<p id="p' + j + '"></p>');
										$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
										$('#s' + j).after('<button>点击购买</button>');
										$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									}
								} else {
									layer.msg(obj.msg, function() {

									});
								}
							} else {
								alert('服务器返回一个错误')
							}
						})
					} else if($('#jg img').attr('src') == '/public/web/images/to_high.png') {
						$.post('api/index.php?ctl=order&act=get_deal_list&p=' + p + '&key1=jg2', function(data) {
							if(data) {
								var obj = eval('(' + data + ')')
								if(obj.status == true) {
									for(var i = 0; i < obj.deal_list.length; i++) {
										$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
										$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
										$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
										$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
										$('#d' + j).append('<p id="p' + j + '"></p>');
										$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
										$('#s' + j).after('<button>点击购买</button>');
										$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									}
								} else {
									layer.msg(obj.msg, function() {

									});
								}
							} else {
								alert('服务器返回一个错误')
							}
						})
					} else if($('#jg img').attr('src') == '/public/web/images/to_low.png') {
						$.post('api/index.php?ctl=order&act=get_deal_list&p=' + p + '&key1=jg1', function(data) {
							if(data) {
								var obj = eval('(' + data + ')')
								if(obj.status == true) {
									for(var i = 0; i < obj.deal_list.length; i++) {
										$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
										$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
										$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
										$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
										$('#d' + j).append('<p id="p' + j + '"></p>');
										$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
										$('#s' + j).after('<button>点击购买</button>');
										$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									}
								} else {
									layer.msg(obj.msg, function() {

									});
								}
							} else {
								alert('服务器返回一个错误')
							}
						})
					} else if(searchInput) {
						$.post('api/index.php?ctl=order&act=get_deal_list&p=' + p + '&key=' + searchInput, function(data) {
							if(data) {
								var obj = eval('(' + data + ')')
								if(obj.status == true) {
									for(var i = 0; i < obj.deal_list.length; i++) {
										$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
										$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
										$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
										$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
										$('#d' + j).append('<p id="p' + j + '"></p>');
										$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
										$('#s' + j).after('<button>点击购买</button>');
										$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									}
								} else {
									layer.msg(obj.msg, function() {

									});
								}
							} else {
								alert('服务器返回一个错误')
							}
						})
					} else {
						$.post('api/index.php?ctl=order&act=get_deal_list&p=' + p, function(data) {
							if(data) {
								var obj = eval('(' + data + ')')
								if(obj.status == true) {
									for(var i = 0; i < obj.deal_list.length; i++) {
										$('.mui-table-view').append('<li id="l' + j + '"class="mui-table-view-cell mui-media"></li>');
										$('#l' + j).append('<a id="a' + j + '"href="index.php?ctl=mall&act=deal_detail&deal_id=' + obj.deal_list[i].id + '"></a>');
										$('#a' + j).append('<img id="i' + j + '"class="mui-media-object mui-pull-left" src="' + obj.deal_list[i].img + '">');
										$('#i' + j).after('<div id="d' + j + '"class="mui-media-body mui-ellipsis">' + obj.deal_list[i].deal_name + '</div>');
										$('#d' + j).append('<p id="p' + j + '"></p>');
										$('#p' + j).append('<span id="s' + j + '">￥' + obj.deal_list[i].current_price + '&nbsp;</span>');
										$('#s' + j).after('<button>点击购买</button>');
										$('#s' + j).append('<span class="saleNo">销量：' + obj.deal_list[i].sale_amount + '</span>');
									}
								} else {
									layer.msg(obj.msg, function() {

									});
								}
							} else {
								alert('服务器返回一个错误')
							}
						})
					}
				}
			})
		<?php echo '</script'; ?>
>
	</body>

</html><?php }
}
