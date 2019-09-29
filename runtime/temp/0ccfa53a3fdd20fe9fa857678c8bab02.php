<?php /*a:1:{s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\cart\order_xq.html";i:1568614048;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0" />
		<meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
		<title>订单详情</title>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="/static/index/css/sm.min.css">
		<link rel="stylesheet" href="/static/index/css/sm-extend.min.css">
		<link rel="stylesheet" href="/static/index/css/app.css?349632766">
		<link rel="stylesheet" href="/static/index/js/layer/mobile/need/layer.css">
		<link rel="stylesheet" type="text/css" href="/static/index/css/style.css" />
		<!-- <link rel="stylesheet" type="text/css" href="/static/index/css/class.css" /> -->
		<link rel="stylesheet" href="http://at.alicdn.com/t/font_1218663_avyf5h8t28e.css">

		<script src="/static/index/js/jquery.min.js"></script>
		<script src="/static/index/js/vue.min.js"></script>
		<script src="/static/index/js/layer/layer.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
		<!--<script src="/static/index/js/app.js"></script>-->
		 <!--<script src="/static/index/js/IPurl.js"></script>-->
		<!-- <script src="../../script/font/iconfont.js"></script> -->

		<style>
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

			html,
			body {
				/* background-color: #f7f7f7; */
			}

			#wrap {
				height: auto;
				padding-bottom: 50px;
				flex-direction: column;
				background-color: #eee;
			}

			.goodslist {
				width: 100%;
				background-color: #f7f7f7;
			}

			.gone {
				width: 100%;
				height: 120px;
				padding: 20px 14px;
				background-color: #fff;
				/*margin-bottom: 12px;*/
				-ms-align-items: center;
				align-items: center;
			}

			.imgk {
				width: 80px;
				height: 80px;
			}

			.imgk>img {
				width: 80px;
				height: 80px;
			}

			.goodsmsg {
				height: 80px;
				margin-left: 10px;
				flex-direction: column;
				justify-content: center;
			}

			.zhekou {
				width: 55px;
				height: 18px;
				background-color: #ffa10e;
				margin-right: 10px;
				justify-content: center;
				-ms-align-items: center;
				align-items: center;
				border-radius: 5px;
			}

			/*steppera*/
			.steppera {
				width: 70px;
				height: 20px;
				border: 1px solid #dcdcdc;
				display: flex;
				overflow: hidden;
			}

			.steppera .vanipt {
				width: 30px;
				border-left: 1px solid #dcdcdc;
				border-right: 1px solid #dcdcdc;
				box-sizing: border-box;
				background-color: #fff;
				margin: 0;
				text-align: center;
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.steppera .vantjia,
			.steppera .vantjian {
				width: 20px;
				background-color: #fff;
				margin: 0;
				text-align: center;
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.iconjia,
			.iconjian {
				font-size: 12px !important;
			}

			.vbottom {
				width: 100%;
				height: 50px;
				position: fixed;
				bottom: 0;
				z-index: 99;
				background-color: #fff;
				display: flex;
				align-items: center;
			}

			.selecAll {
				padding-left: 14px;
				margin-right: 15px;
				display: flex;
				align-items: center;
				font-size: 12px;
				color: #fe0042;
			}

			.all.xuanze1 {
				margin-right: 4px;
			}

			.all.xuanze2 {

				border: 1px solid #FE0042;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			.heji {
				flex: 1;
				font-size: 14px;
				color: #333;
				font-weight: bold;
			}

			.jiesuan {
				width: 105px;
				height: 50px;
				background: #fe0042;
				color: #fff;
				font-size: 14px;
				display: flex;
				align-items: center;
				justify-content: center;
			}

			/*address*/
			.address {
				display: flex;
				width: 100%;
				height: 76px;
				padding: 0 14px;
				/*box-sizing: border-box;*/
				background-color: #fff;
				align-items: center;
			}

			.add_l {
				height: 80%;
				display: flex;
				flex-direction: column;
				justify-content: space-around;
				flex: 1;

			}

			.al_1 {
				font-size: 16px;
				color: #333;
			}

			.l_tel {
				margin-left: 24px;
			}

			.al_2 {
				font-size: 12px;
				color: #999;
			}

			.add_r {
				width: 12px;
				height: 20px;
			}

			.orderbder {
				width: 100%;
				height: 3px;
				display: flex;
			}

			.orderbder img {
				width: 100%;
				height: 3px;
			}


			.guige {
				width: 100%;
				height: 25px;
				padding: 0 5px;
				box-sizing: border-box;
				background-color: #fff;
				display: flex;
				justify-content: space-between;
				align-items: center;
				/* margin-bottom: 10px; */
			}

			.guige_l {
				display: flex;
				align-items: center;
				font-size: 14px;
				color: #333;
			}

			.guige_l_name {
				color: #999;
				margin-right: 12px;
			}

			.guige_r {
				width: 22px;
				height: 22px;
			}

			.wxicon {
				width: 20px;
				height: 20px;
				margin-right: 12px;
				background-color: #6bcc03;
				justify-content: center;
				-ms-align-items: center;
				align-items: center;
				border-radius: 50%;
			}


			.fixbottom {
				width: 100%;
				position: fixed;
				bottom: 0;
				left: 0;
				height: 50px;
				background-color: #fff;
				display: flex;
			}

			.fb_l {
				flex: 1;
				height: 50px;
				padding-left: 14px;
				font-size: 14px;
				color: #fe0042;
				display: flex;
				align-items: center;
				font-weight: bold;
			}

			.subbtn {
				width: 106px;
				height: 50px;
				background-color: #fe0042;
				color: #fff;
				font-size: 14px;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			.subbtn1 {
				background-color: #999;
			}

		</style>
	</head>
	<body>
		<div class="page-group">
			<div class="page page-current" id="myinfo">
				<header class="bar bar-nav"> <a class="button button-link button-nav pull-left back" href="javascript:history.go(-1);"> <span class="icon icon-left"></span>
						返回 </a>
					<h1 class="title">订单详情</h1>
				</header>
				<div class="content native-scroll">
					<div id="wrap" class="wrap disflex">

						<div class="address boxsiz">
							<div class="add_l">
								<div class="al_1"><?php echo htmlentities($address['consignee']); ?> <span class="l_tel"><?php echo htmlentities($address['phone']); ?></span></div>

								<div class="al_2 oh1">
									<?php echo htmlentities($address['address']); ?>
								</div>
								<!-- <div v-if="!address.Province">请先添加地址</div> -->
							</div>
							<div class="add_r">
								<!-- <i class="iconfont iconnext"></i> -->
							</div>
						</div>
						<div class="orderbder">

						</div>
						<div class="goodslist mb10">
							<?php foreach($product as $v): ?>
							<div class="gone disflex boxsiz">
								<div class="imgk">
									<img src="<?php echo htmlentities($v['pic']); ?>" alt="">
								</div>
								<div class="goodsmsg disflex">
									<div class="fz14 c3 oh1 mb5"><?php echo htmlentities($v['title']); ?></div>
									<div class="fz14 c6 dd">
										<span>￥<?php echo htmlentities($v['price']); ?></span><span style="margin-left:30px">数量：<?php echo htmlentities($v['num']); ?></span>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<div class="guige">
							<div class="guige_l">
							</div>
							<div class="fz14 c9">
								下单时间：<?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($order_info['create_time'])? strtotime($order_info['create_time']) : $order_info['create_time'])); ?>
							</div>
						</div>
						<div class="guige">
							<div class="guige_l">
							</div>
							<div class="fz14 c9">
								运费：￥<?php echo htmlentities($order_info['yunfei']); ?>
							</div>
						</div>
						<div class="guige">
							<div class="guige_l">
							</div>
							<div class="fz14 c9">
								优惠：￥<?php echo htmlentities($order_info['youhui']); ?>
							</div>
						</div>
						<div class="fixbottom" style="padding: 0;">
							<div class="fb_l">合计：<?php echo htmlentities($order_info['total_price']); ?></div>
							<div v-show="paykg" class="subbtn" @click="subbtn">付款</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!--  <script src="../../script/vconsole.min.js"></script>
<script>
var vConsole = new VConsole();
</script> -->
		<script>
			var Vindex = new Vue({
				el: '#wrap',
				data: {
					addresslist: '',
					shopxq: '',
					gid: '',
					login: '',
					usermsg: '',
					logintoken: '',
					address: {},
					xzbox: [1,1],
					all: false,
					sum: 0,
					type: 0,

					paykg: true,
					isLoading: false,
					val1: '',
					skip: 1
				},
				created: function() {},
				mounted() {},
				methods: {
					subbtn() {
					    no = "<?php echo htmlentities($order_info['no']); ?>"
					    layer.confirm('立即支付？',{icon:3,title:'支付'},function(index){
                            $.ajax({
                                type: "post",
                                url: "<?php echo url('cart/pay'); ?>",
                                data: {no:no},
                                success: function(res) {
                                    if (res.code == -1) {

                                    } else {
                                        if (res.msg) {
                                            layer.msg(res.msg)
                                        }
                                    }
                                },
                                error: function(err) {
                                    layer.msg('请求失败')
                                }
                            })
							layer.close(index);
						});

						}
					},
					// onNum(index, type) {
					// 	if (this.xzbox[index].num < 2 && type == '-') {
					// 		console.log('禁止')
					// 		return false;
					// 	}
					// 	if (type == '-') {
					// 		this.xzbox[index].num--
					// 	} else {
					// 		this.xzbox[index].num++
					// 	}
					// 	console.log(this.xzbox)
					// 	this.countpri()
					// },

			})

		</script>
	</body>
</html>
