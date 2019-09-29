<?php /*a:4:{s:74:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\index\index.html";i:1568631204;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\layout\header.html";i:1567764346;s:74:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\layout\menu.html";i:1568972406;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\layout\footer.html";i:1567760429;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
<head>
    <title>首页</title>
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

        ::-webkit-scrollbar-track:vertical {
        }

        ::-webkit-scrollbar-thumb:vertical {
            background-color: rgba(136, 141, 152, 0.5) !important;
            border-radius: 10px !important;
            background-clip: content-box !important;
            border: 2px solid transparent !important;
        }

        ::-webkit-scrollbar-track:horizontal {
        }

        ::-webkit-scrollbar-thumb:horizontal {
            background-color: rgba(136, 141, 152, 0.5) !important;
            border-radius: 10px !important;
            background-clip: content-box !important;
            border: 2px solid transparent !important;
        }

        ::-webkit-resizer {
            display: none !important;
        }

        .addcar {
            font-style: normal !important;
            width: 92px;
            height: 28px;
            background-color: #4bdb57;
            border-radius: 2px;
            color: #fff;
            margin-left: 8px;

        }
    </style>
</head>
<body>
<div class="page-group">
    <div class="page page-current" id="home">
        <header class="bar bar-nav">
            <h1 class="title"><?php echo htmlentities($site['title']); ?></h1>
        </header>
        <div class="bar bar-tab bar-footer">
            <a class="tab-item external active" href="<?php echo url('index/index'); ?>">
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
<a class="tab-item external" href="<?php echo url('my_address/index'); ?>">
    <span class="icon icon-me"></span>
    <span class="tab-label">我的</span>
</a>

        </div>
        <div class="content native-scroll">
            <div class="content-inner">
                <div id="hotlist">
                    <?php foreach($data as $v): ?>
                    <div class="card">
                        <div class="card-content">
                            <div class="card-content-inner"><img src="<?php echo htmlentities($v['pic']); ?>"></div>
                        </div>
                        <div class="card-footer"><?php echo htmlentities($v['title']); ?>
                            <span class="disflex aic ">
										<i class="price disflex aic">￥<?php echo htmlentities($v['price']); ?>元</i>
                                        <?php if($site['status']==1): ?>
										<i class="addcar aic disflex  ju_c" onclick="addcar(<?php echo htmlentities($v['id']); ?>)">加入购物车</i>
                                        <?php endif; ?>
									</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="list-block media-list">
                            <ul id="productlist"></ul>
                        </div>
                    </div>
                </div>
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

<script>

    function addcar(id) {
        layer.open({
            title: '加入购物车',
            content: '是否加入购物车',
            icon: 3,
            btn: ['确认', '取消'],
            yes: function (index) {
            $.ajax({
                    type: "post",
                    url: "<?php echo url('cart/save'); ?>",
                    data: {id:id},
                    success: function(res) {
                        if(res.code===1){
                            layer.msg(res.msg);

                        }else{
                            layer.msg(res.msg);
                        }
                    },
                    error: function(err) {
                        layer.msg('提交失败')
                    }
                })
            },
            btn2: function (index) {

            }
        })
    }

</script>
<!-- <script src="images/js/app.js?1988290038"></script> -->

</body>
</html>
