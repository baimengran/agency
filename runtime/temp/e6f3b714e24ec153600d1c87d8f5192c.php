<?php /*a:1:{s:74:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\agency\mydl.html";i:1569560268;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit" />
		<meta name="force-rendering" content="webkit" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
		<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
		<link rel="stylesheet" href="/static/index/css/style.css">
		<link rel="stylesheet" href="http://at.alicdn.com/t/font_1218663_avyf5h8t28e.css">

		<script src="/static/index/js/vue.min.js"></script>
		<title>代理中心</title>
		<style>
			*{
				margin: 0;
				padding: 0;
			}
			body{
				background-color: #f0f0f0;
			}
			.mb10{
				margin-bottom: 10px;
			}
			.header{	
				width: 100%;
				height: 100px;
				padding: 0 6px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				background-color: #32702b;
				display: flex;
				align-items: center;
			}
			.dl_tx{
				width: 70px;
				height: 70px;
				border-radius: 50%;
				margin-right: 8px;
			}
			.dl_msg{
				flex: 1;
				height: 70px;
				display: flex;
				flex-direction: column;
				justify-content: space-between;
			}
			.dl_name{
				color: #fff;
				font-size: 18px;
			}
			.dl_sf{
				font-size: 13px;
				color: #fff;
			}
			.dl_id{
				font-size: 13px;
				color: #fff;
			}
			.mycaoz{
				display: flex;
				height: 45px;
				color: #4e4e4e;
				font-size: 18px;
				padding: 0 25px 0 15px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				align-items: center;
				justify-content: space-between;
				background-color: #fff;
			}
			.iconnext{
				font-size: 12px;
				color: #5a5a5a;
			}
			.cz_name{
				display: flex;
				align-items: center;
			}
			.czicon{
				width: 20px;
				height: auto;
				margin-right: 10px;
			}
		</style>
	</head>
	<body>
		<div class="webbox">
			<div class="header mb10">
				<img class="dl_tx" src="<?php echo htmlentities($user['avatar']); ?>" alt="">
				<div class="dl_msg">
					<p class="dl_name"><?php echo htmlentities($user['nickname']); ?></p>
					<p class="dl_sf"><?php echo htmlentities($user['title']); ?></p>
					<p class="dl_id"><?php echo htmlentities($user['wechatid']); ?></p>
				</div>
				<div style="margin-right:5px;font-size:10px">
					<p style="color: #D91600;"><strong>推荐人： <?php echo htmlentities($real_name); ?></strong></p>
					<p style="color: #D91600;"><strong>代理ID： <?php echo htmlentities($user['id']); ?></strong></p>
				</div>
			</div>
			<a class="mycaoz" href="<?php echo url('reserve_goods/index'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我要订货</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a href="<?php echo url('reserve_goods/order_list'); ?>" class="mycaoz mb10">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我的订货记录</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz" href="<?php echo url('replenish_goods/index'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我要补货</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz mb10" href="<?php echo url('replenish_goods/order_list'); ?>" >
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我的补货记录</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz" href="<?php echo url('exchange_goods/index'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我要调货</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a href="<?php echo url('exchange_goods/order_list'); ?>" class="mycaoz mb10">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我的调货记录</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz" href="<?php echo url('deliver_goods/index'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我要发货</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a href="<?php echo url('deliver_goods/order_list'); ?>" class="mycaoz mb10">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我的发货记录</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz" href="<?php echo url('my/my_agency'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_10.jpg" alt="">
					<span>我的下级代理</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz mb10" href="<?php echo url('my/agency_generate'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_12.jpg" alt="">
					<span>下级代理生成</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz mb10" href="<?php echo url('my/my_earnings'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_10.jpg" alt="">
					<span>我的结算记录</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz mb10" href="<?php echo url('my/my_client'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我的顾客</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
			<a class="mycaoz mb10" href="<?php echo url('my/my'); ?>">
				<div class="cz_name">
					<img class="czicon" src="/static/index/img/mydl_07.jpg" alt="">
					<span>我的信息</span>
				</div>
				<i class="iconfont iconnext"></i>
			</a>
		</div>
	</body>
</html>
