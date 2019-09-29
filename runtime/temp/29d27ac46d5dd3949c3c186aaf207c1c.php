<?php /*a:1:{s:73:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\cart\order.html";i:1568972343;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>订单</title>
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
		<!-- <link rel="stylesheet" type="text/css" href="/static/index/css/class.css" /> -->
		<link rel="stylesheet" href="http://at.alicdn.com/t/font_1218663_avyf5h8t28e.css">
		<script src="/static/index/js/jquery.min.js"></script>
		<script src="/static/index/js/vue.min.js"></script>
    <script src="/static/index/js/vant.js"></script>
    <script src="/static/index/js/Area.js"></script>
		<script src="/static/index/js/layer/layer.js"></script>
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
			 .gone{
        width: 100%;
        /*height: 120px;*/
        padding: 20px 14px;
        background-color: #fff;
        margin-bottom: 12px;
       /* -ms-align-items: center;
        align-items: center;*/
				position: relative;
      }
      .gone1{
        -ms-align-items: center;
        align-items: center;
				/* position: relative; */
      }
			.o_status{
				position: absolute;
				top:10px;
				right: 10px;
			}
      .imgk{
        width: 80px;
        height: 80px;
      }
      .imgk>img{
        width: 100%;
        height: 100%;
      }
      .goodsmsg{
        height: 80px;
        margin-left: 10px;
        flex-direction: column;
        justify-content: center;
      }
			.cfe0042{
				color: #fe0042;
			}
			.subbtn{
			  width: 106px;
			  height: 50px;
			  background-color: #fe0042;
			  color:#fff;
			  font-size: 14px;
			  display: flex;
			  justify-content: center;
			  align-items: center;
			}
			.subbtn1{
			  background-color: #999;
			}
			.iconshanchu{
			  font-size: 24px;
			}
			.caoz{
			  /*padding: 0 14px;*/
			  justify-content: flex-end;
			}
			.czbtn{
			  width: 90px;
			  height: 32px;
			  border:1px solid #999;
			  border-radius: 16px;
			  justify-content: center;
			  -ms-align-items: center;
			  align-items: center;
			}
			.czbtn1{
			  border:1px solid #fe0042;
			  margin-left: 16px;
			}
			.wuliu{
			  margin-top: 10px;
			  width: 100%;
			  padding-top: 5px;
			  border-top: 1px solid #ddd;
			  -ms-align-items: center;
			  align-items: center;
			}
			.heji {
				font-size: 14px;
			}

		</style>
	</head>
	<body>
		<div class="page-group">
			<div class="page page-current" id="order">
				<header class="bar bar-nav">
					<h1 class="title">订单</h1>
				</header>
				<div class="bar bar-tab bar-footer">
					<a class="tab-item external " href="<?php echo url('index/index'); ?>">
						<span class="icon icon-home"></span>
						<span class="tab-label">商品</span>
					</a>
					<a class="tab-item external" href="<?php echo url('cart/index'); ?>">
						<span class="icon icon-cart"></span>
						<span class="tab-label">购物车</span>
						<span class="badge" id="cart-tip" style="display: none;">0</span>
					</a>
					<a class="tab-item external active" href="<?php echo url('cart/order_index'); ?>">
						<span class="icon icon-menu"></span>
						<span class="tab-label">订单</span>
					</a>
					<a class="tab-item external" href="<?php echo url('my_address/index'); ?>">
						<span class="icon icon-me"></span>
						<span class="tab-label">我的</span>
					</a>
				</div>
				<div class="content native-scroll">
					<div class="buttons-tab"> 
						<a href="#tab1" id="ta1" class="tab-link active button" onclick="clicked(1)">已发货</a>
						<a href="#tab2" id="ta2" class="tab-link button" onclick="clicked(2)">待付款</a>
						<a href="#tab3" id="ta3" class="tab-link button" onclick="clicked(3)">待发货</a>
						<a href="#tab4" id="ta4" class="tab-link button" onclick="clicked(4)">已取消</a>
					</div>
					<div class="tabs">
						<div class="tab active list-block"  id="tab1">
							<ul>
								<?php foreach($order_yi as $v): ?>
								<div class="gone boxsiz" >
									<?php foreach($v['product'] as $item): ?>
								  <div class="gone1 disflex boxsiz">
										<div class="fz14 o_status">已完成</div>
								    <div class="imgk">
								      <img src="<?php echo htmlentities($item['pic']); ?>" alt="">
								    </div>
								    <div class="goodsmsg flex1 disflex">
								      <div class="fz14 c3 oh1 mb5" ><?php echo htmlentities($item['title']); ?> <span>x<?php echo htmlentities($item['num']); ?></span></div>
								      <div class="fz14 c6">

								        <span class=" fz14 cfe0042">￥<?php echo htmlentities($item['price']); ?>元</span>
								      </div>
								    </div>
								  </div>
									<?php endforeach; ?>
								   <div class="wuliu" style="font-size: 15px;">
								     <div class=" c9 mr20">物 &nbsp&nbsp&nbsp流：<?php echo htmlentities($v['logistics']); ?></div>
								     <div class=" c9">运单号：<?php echo htmlentities($v['waybill_no']); ?></div>
								  </div>
									<div class="caoz disflex aic ">
										<div class="heji"> 合计：￥<?php echo htmlentities($v['total_price']); ?>元</div>
									</div>
								  <div class="caoz disflex boxsiz mt10">
									  <?php if($v['closed']!=2): ?>
								    <div class="czbtn czbtn1 fz14 cfe0042 disflex" onclick="shouhuo(<?php echo htmlentities($v['id']); ?>)">确认收货</div>
									  <?php endif; ?>
								  </div>
								</div>
								<hr>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="tab list-block" id="tab2">
							<ul>

							</ul>
						</div>
						<div class="tab list-block" id="tab3">
							<ul>

							</ul>
						</div>
						<div class="tab list-block" id="tab4">
							<ul>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <script src="/static/index/js/zepto.js"></script> -->
		<!-- <script src="/static/index/js/sm.js"></script>
		<script src="/static/index/js/sm-extend.js"></script> -->
		<!-- <script src="/static/index/js/app.js"></script> -->
		<script>
            function clicked(num){
                wei = 'tab-link active';
                xuan = "button";
                tab1 = $('#tab1');
                tab2 = $('#tab2');
                tab3 = $('#tab3');
                tab4 = $('#tab4');
                ta1 = $('#ta1');
                ta2 = $('#ta2');
                ta3 = $('#ta3');
                ta4 = $('#ta4');
				if(num==1){
                    url = "<?php echo url('cart/order_index'); ?>";
                    let obj = $('#tab1 ul');
                    ajax(url,this,obj,'yi');
                    ta1.addClass('active');
                    ta3.removeClass('active');
                    ta4.removeClass('active');
                    ta2.removeClass('active');
				    tab2.hide();
				    tab3.hide();
				    tab4.hide();
					tab1.show();
				}else if(num==2){
				    url = "<?php echo url('cart/order_wei_pay'); ?>";
				    let obj = $('#tab2 ul');
					ajax(url,this,obj,'wei');
                    ta1.removeClass('active');
                    ta3.removeClass('active');
                    ta4.removeClass('active');
                    ta2.addClass('active');
                    tab2.show();
                    tab3.hide();
                    tab4.hide();
                    tab1.hide();
				}else if(num==3){
                    url = "<?php echo url('cart/order_dai_fa'); ?>";
                    let obj = $('#tab3 ul');
                    ajax(url,this,obj,'dai');
                    ta1.removeClass('active');
                    ta3.addClass('active');
                    ta4.removeClass('active');
                    ta2.removeClass('active');
                    tab2.hide();
                    tab3.show();
                    tab4.hide();
                    tab1.hide();
				}else if(num==4){
                    url = "<?php echo url('cart/order_cancel'); ?>";
                    let obj = $('#tab4 ul');
                    ajax(url,this,obj,'qu');
                    ta1.removeClass('active');
                    ta4.addClass('active');
                    ta3.removeClass('active');
                    ta2.removeClass('active');
                    tab2.hide();
                    tab3.hide();
                    tab4.show();
                    tab1.hide();
				}else if(num==5){

				}
			}

			function ajax(url,_this,obj,filde){
                $.ajax({
                    url: url,
                    success: function(res) {
                        if (res.code ===1) {
                            _this.page(res.data,obj,filde);
                        }
                    },
                    error: function(err) {
                        layer.msg('请求失败')
                    }
                })
			}

			function page(res,obj,filde){
                let html='';
                for(let i in res){
                    html+= '<div class="gone boxsiz" >';
                    for(let h in res[i].product){
                        html+='<div class="gone1 disflex boxsiz">\n';
                        if(filde=='yi'){
                            html+='<div class="fz14 o_status">已完成</div>\n';
						}
                        if(filde=='wei'){
                            html+='<div class="fz14 o_status">待付款</div>\n';
						}
						if(filde =='dai'){
                            html+='<div class="fz14 o_status">待发货</div>\n';
						}
                        if(filde =='qu'){
                            html+='<div class="fz14 o_status">以取消</div>\n';
                        }

                        html+='<div class="imgk">\n' +
                        '<img src="'+res[i].product[h].pic+'" alt="">\n' +
                        '</div>\n' +
                        '<div class="goodsmsg flex1 disflex">\n' +
                        '<div class="fz14 c3 oh1 mb5" >'+res[i].product[h].title+'<span>'+res[i].product[h].num+'</span></div>\n' +
                        '<div class="fz14 c6">\n' +
                        '\n' +
                        '<span class=" fz14 cfe0042">￥'+res[i].product[h].price+'元</span>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>\n';
                    }
                   html+= '<div class="wuliu" style="font-size: 15px;">\n';
                    if(filde=='yi'){
                        html+='<div class=" c9 mr20">物 &nbsp&nbsp&nbsp流：'+res[i].logistics+'</div>\n' +
                            '<div class=" c9">运单号：'+res[i].waybill_no+'</div>\n';
					}
                    html+='</div>\n' +
                    '<div class="caoz disflex aic ">\n' +
                    '<div class="heji"> 合计：￥'+res[i].total_price+'元</div>\n' +
                    '</div>\n' +
                    '<div class="caoz disflex boxsiz mt10">\n';
                    if(filde=='wei'){
                        html+='<div class="czbtn czbtn1 fz14 cfe0042 disflex" onclick="pay('+res[i].id+')">在线支付</div>\n';
					}
                    if(res[i].closed!=2&&filde=='yi'){
                        html+='<div class="czbtn czbtn1 fz14 cfe0042 disflex" onclick="shouhuo('+res[i].id+')">确认收货</div>';
                    }
                    html+= '</div>\n' + '</div>\n' + '<hr>\n';
                }
                obj.empty();
				obj.append(html);
            }

			function shouhuo(id){
                layer.confirm('确认收货？',{icon:3,title:'收货'},function(index){
                    $.ajax({
                        type: "get",
                        url: "<?php echo url('cart/take_goods'); ?>",
                        data: {id:id},
                        success: function(res) {
                            if (res.code ===1) {
								layer.msg(res.msg,function(){
                                    location.reload();
								})
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
			function pay(id){
                layer.confirm('立即支付？',{icon:3,title:'支付'},function(index){
                    $.ajax({
                        type: "post",
                        url: '{}',
                        data: {},
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
		</script>
	</body>
</html>
