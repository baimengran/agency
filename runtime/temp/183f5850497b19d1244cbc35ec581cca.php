<?php /*a:3:{s:68:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\my\my.html";i:1568972523;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\layout\header.html";i:1567764346;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\layout\footer.html";i:1567760429;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
	<head>

		<title>我的</title>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">

<link rel="stylesheet" href="/static/index/css/sm.min.css">
<link rel="stylesheet" href="/static/index/css/sm-extend.min.css">
<link rel="stylesheet" href="/static/index/css/app.css?349632766">
<link rel="stylesheet" href="/static/index/css/vantIndex.css">
<link rel="stylesheet" href="/static/index/css/style.css">
<link rel="stylesheet" href="/static/index/js/layer/mobile/need/layer.css">
<!-- <link rel="stylesheet" type="text/css" href="images/css/class.css" /> -->
<link rel="stylesheet" href="http://at.alicdn.com/t/font_1218663_avyf5h8t28e.css">
		<style id="__WXWORK_INNER_SCROLLBAR_CSS">
			::-webkit-scrollbar {
				width: 12px !important;
				height: 12px !important;
			}

			::-webkit-scrollbar-track:vertical {}

			::-webkit-scrollbar-thumb:vertical {
				background-color: rgba(136, 141, 152, 0.5) !important;
				border-radius: 10px !important;
				background-clip: content-box !important;
				border: 2px solid transparent !important;
			}

			::-webkit-scrollbar-track:horizontal {}

			::-webkit-scrollbar-thumb:horizontal {
				background-color: rgba(136, 141, 152, 0.5) !important;
				border-radius: 10px !important;
				background-clip: content-box !important;
				border: 2px solid transparent !important;
			}

			::-webkit-resizer {
				display: none !important;
			}
		</style>
	</head>
	<body>
		<div class="page-group">
			<div class="page page-current" id="my">
				<header class="bar bar-nav">
					<h1 class="title">我的</h1>
				</header>
				<div class="bar bar-tab bar-footer">
					<a class="tab-item external" href="<?php echo url('index/index'); ?>">
						<span class="icon icon-home"></span>
						<span class="tab-label">商品</span>
					</a>
					<a class="tab-item external" href="<?php echo url('cart/index'); ?>">
						<span class="icon icon-cart"></span>
						<span class="tab-label">购物车</span>
						<span class="badge" id="cart-tip" style="display: none;">0</span>
					</a>
					<a class="tab-item external" href="<?php echo url('cart/order_index'); ?>">
						<span class="icon icon-menu"></span>
						<span class="tab-label">订单</span>
					</a>
					<a class="tab-item external active" href="<?php echo url('my_address/index'); ?>">
						<span class="icon icon-me"></span>
						<span class="tab-label">我的</span>
					</a>
				</div>
				<div class="content native-scroll">
					<div class="list-block media-list userinfo">
						<ul>
							<li>
								<div class="item-content">
									<div class="item-media"><img src="<?php echo htmlentities($user['avatar']); ?>"></div>
									<div class="item-inner">
										<div class="item-subtitle"><?php echo htmlentities($user['nickname']); ?></div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="list-block media-list">
						<ul>
							<li> 
								<a href="<?php echo url('my_address/address_index'); ?>" class="item-link item-content">
									<div class="item-inner">
										<div class="item-title">收货地址</div>
									</div>
								</a> 
							</li>
							<!-- <li> 
								<a href="myinfo.html" class="item-link item-content">
									<div class="item-inner">
										<div class="item-title">收货地址</div>
									</div>
								</a> 
							</li> -->
						</ul>
					</div>
					<div class="list-block media-list">
						<ul>
							<li> <a href="<?php echo url('agency/select_agency'); ?>" class="item-link item-content">
								<div class="item-inner">
									<div class="item-title">代理查询</div>
								</div>
							</a> </li>
							<?php if($user['agency_id']==0||$user['status']!=1): ?>
							<li> <a href="javascript:void(0)" onclick="i_wart()" class="item-link item-content">
								<div class="item-inner">
									<div class="item-title">我要代理</div>
								</div>
							</a> </li>
							<?php else: ?>
							<li> <a href="javascript:void(0)" onclick="daili()" class="item-link item-content">
								<div class="item-inner">
									<div class="item-title">代理中心</div>
								</div>
							</a> </li>
							<?php endif; ?>
							<li class="tel"> <a href="tel:400-960-9188" class="item-link item-content">
									<div class="item-inner">
										<div class="item-title">联系我们</div>
										<div class="item-after"><?php echo htmlentities($site['contact_us']); ?></div>
									</div>
								</a> </li>
						</ul>
					</div>
					<div class="list-block media-list" style="display:none">
						<ul>
							<li> <a href="/logout" class="item-link item-content external">
									<div class="item-inner">
										<div class="item-title">清空session</div>
									</div>
								</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<script src="/static/index/js/jquery.min.js"></script>
<script src="/static/index/js/vue.min.js"></script>
<script src="/static/index/js/vant.js"></script>
<script src="/static/index/js/Area.js"></script>
<script src="/static/index/js/layer/layer.js"></script>
<script src="/static/index/js/zepto.js"></script>
<!--<script src="/static/index/js/sm.js"></script>-->
<!--<script src="/static/index/js/sm-extend.js"></script>-->
<script type="text/javascript">
    function daili(){
        $.ajax({
            type:'POST',
            url:"<?php echo url('agency/index'); ?>",
            data:{},
            success:function(res){
                if(res.code===1){
                    location.href="<?php echo url('agency/index'); ?>";
                }else{
                    layer.msg(res.msg)
                }
            },
            error:function(err){
                layer.msg('系统错误');
            }
        });
    }

    function i_wart(){
        $.ajax({
            type:'POST',
            url:"<?php echo url('agency/i_want'); ?>",
            data:{field:'i_wart'},
            success:function(res){
                if(res.code===1){
                    location.href="<?php echo url('agency/i_want'); ?>";
                }else if(res.code===2){
                    location.href="<?php echo url('agency/index'); ?>";
				}
                else{
                    layer.msg(res.msg)
                }
            },
            error:function(err){
                layer.msg('系统错误');
            }
        });
    }
</script>
	</body>
</html>
