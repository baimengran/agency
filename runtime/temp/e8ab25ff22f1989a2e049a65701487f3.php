<?php /*a:1:{s:79:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\agency\checkauth.html";i:1569562767;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>代理查询</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <script src="/static/index/js/jquery.min.js"></script>
    <script src="/static/index/js/vue.min.js"></script>
    <script src="/static/index/js/layer/layer.js"></script>
    <script src="/static/index/js/vant.js"></script>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/index/css/sm.min.css">
    <link rel="stylesheet" href="/static/index/css/sm-extend.min.css">
    <link rel="stylesheet" href="/static/index/css/app.css?349632766">
    <link rel="stylesheet" href="/static/index/css/style.css">
    <link rel="stylesheet" href="/static/index/js/layer/mobile/need/layer.css">
    <link rel="stylesheet" href="/static/index/css/vantIndex.css">

    <style id="__WXWORK_INNER_SCROLLBAR_CSS">::-webkit-scrollbar {
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
    .xqbox{
        width: 320px;
        height: 260px;
        border-radius: 8px;
        padding: 50px 30px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .xqbox p{
        margin-bottom: 8px;
        font-size: 16px;
        color: #484848;
    }
    </style>
</head>
<body>
<div class="page-group">
    <div class="page page-current" id="checkauth">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left back" onclick="check(0)"> <span class="icon icon-left"></span> 返回 </a>
            <h1 class="title">代理查询</h1>
        </header>
        <div class="content native-scroll" id="webbox">
            <div class="list-block">
                <ul>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title label" style="width: 25%">输入</div>
                                <div class="item-input">
                                    <input name="value" value="" id="real_phone" type="text" placeholder="输入代理商ID或手机号">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <van-popup v-model="show">
                <div class="xqbox">
                    <p class="disflex"><span class="xq_name">上级代理</span>：{{details.p_user}}</p>
                    <p class="disflex"><span class="xq_name">代理ID</span>：{{details.id}}</p>
                    <p class="disflex"><span class="xq_name">姓名</span>：{{details.real_name}}</p>
                     <p class="disflex"><span class="xq_name">代理级别</span>：{{details.title}}</p>
                    <p class="disflex"><span class="xq_name">电话</span>：{{details.phone}}</p>
                    <p class="disflex"><span class="xq_name">微信号</span>：{{details.wechatid}}</p>
                    <p class="disflex"><span class="xq_name">状态</span>：{{details.status}}</p>
                    <p class="disflex"><span class="xq_name">审核时间</span>：{{details.status_time}}</p>
                </div>
            </van-popup>
            <div class="content-block">
                <div class="row">
                    <div class="col-50">
                        <a class="button button-big button-fill button-danger back" @click="check(0)">取消</a>
                    </div>
                    <div class="col-50">
                        <a href="javascript:void(0);"
                                           class="button button-big button-fill button-success auth-check" @click="check(1)">查询</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/static/index/js/zepto.js"></script>

<!-- <script src="/static/index/js/sm.js"></script>
<script src="/static/index/js/sm-extend.js"></script>
<script src="/static/index/js/app.js?349632766"></script> -->
<script>
    function check(num){
        if(num===0){
            history.go(-1);
        }
    }
    var vm=new Vue({
        el: '#webbox',
        data: {
            show: false,
            details: [],
        },
        created: function () {
        },
        mounted() {
        },
        methods: {
            check:function(num,_this=this){
                if(num===0){
                    history.go(-1);
                }else{
                    keyword = $('#real_phone').val();

                    if(keyword===''){
                        layer.msg('请输入代理商姓名或手机号');
                        return false;
                    }
                    $.ajax({
                        type: "get",
                        url: "<?php echo url('agency/select_agency'); ?>",
                        data: {keyword:keyword},
                        success: function(res) {
                            if(res.code===1){
                                console.log(res.data)
                                _this.details=res.data;
                            _this.show=true;
                            }else{
                                layer.msg(res.msg);
                            }
                        },
                        error: function(err) {
                            layer.msg('提交失败')
                        }
                    })
                }
        }
        }
    });

</script>

</body>
</html>
