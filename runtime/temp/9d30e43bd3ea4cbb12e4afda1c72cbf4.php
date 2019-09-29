<?php /*a:1:{s:73:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\my\address.html";i:1568972302;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的地址</title>
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
    </style>
    <style>
        #wrap {
            height: auto;
            padding-top: 10px;
            padding-bottom: 100px;
            flex-direction: column;
            background-color: transparent;
        }

        .addressOne {
            width: 100%;
            padding: 12px 14px 17px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #fff;
            margin-bottom: 10px;
        }

        .addp1 {
            font-size: 14px;
            color: #333;
            display: flex;
            justify-content: space-between;
        }

        .addp2 {
            font-size: 12px;
            color: #333333;
            height: 55px;
            display: flex;
            align-items: center;
        }

        .addsetting {
            width: 100%;
            display: flex;
            font-size: 12px;
            color: #b2b2b2;
            justify-content: space-between;
            -ms-align-items: center;
            align-items: center;
        }

        .setcz {
            display: flex;
            align-items: center;
        }

        .setting1 {
            width: 100px;
            height: 30px;
            display: flex;
            align-items: center;
        }

        .setting3 {
            margin-left: 20px;
        }

        .mricon {
            width: 12px;
            height: 12px;
            border: 1px solid #bababa;
            border-radius: 50%;
            margin-right: 10px;
            justify-content: center;
            -ms-align-items: center;
            align-items: center;
        }

        .mricon1 {
            border: 1px solid #fe0042;
            background: #fe0042;
        }

        .fixbottom {
            width: 100%;
            padding: 10px 14px;
            box-sizing: border-box;
            height: 64px;
            background-color: #eeeeee;
            position: fixed;
            bottom: 0;
            left: 0;
            display: flex;
        }

        .addbtn {
            width: 100%;
            height: 44px;
            background-color: #c49e85;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 14px;
        }

        .addicon {
            margin-right: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .iconiconjia {
            font-size: 12px;
        }

        .iconduigou1 {
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="page-group">
    <div class="page page-current" id="checkauth">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left back" href="javascript:history.go(-1);"> <span
                    class="icon icon-left"></span>
                返回 </a>
            <h1 class="title">我的地址</h1>
        </header>
        <div class="content native-scroll">
            <div id="wrap" class="wrap disflex">
                <style>
                    #wrap {
                        height: auto;
                        padding: 0 14px 100px;
                        flex-direction: column;
                        background-color: transparent;
                    }

                    .addmsg {
                        width: 100%;
                        height: 45px;
                        border-bottom: 1px solid #e8e8e8;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        font-size: 14px;
                        color: #333;
                    }

                    .msgtit {
                        width: 70px;
                    }

                    .msgsrk {
                        flex: 1;
                    }

                    .fixbottom {
                        width: 100%;
                        padding: 10px 14px;
                        box-sizing: border-box;
                        height: 64px;
                        background-color: #fff;
                        position: fixed;
                        bottom: 0;
                        left: 0;
                        display: flex;
                    }

                    .addbtn {
                        width: 100%;
                        height: 44px;
                        background-color: #c49e85;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        color: #fff;
                        font-size: 14px;
                    }

                    .addicon {
                        margin-right: 7px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                </style>
                <div v-if="loginmsg" class="addressOne" v-for="(item,index) in loginmsg">
                    <div class="addp1">
                        <span>{{item.name}}</span>
                        <span>{{item.phone}}</span>
                    </div>
                    <div class="addp2">
                        {{item.address}}
                    </div>
                    <div class="addsetting">
                        <div class="setting1" @click="selecmr(item.id,index)">
                            <div class="mricon disflex " :class="{'mricon1 cf':item.status==1}">
                                <i v-show="item.status==1" class="iconfont iconduigou1"></i>
                            </div>
                            默认地址
                        </div>
                        <div class="setcz">
                            <div class="setting2" @click="addressEdit(item.id)">编辑</div>
                            <div class="setting3" @click="addressDel(item.id,index)">删除</div>
                        </div>
                    </div>
                </div>
                <div class="fixbottom">
                    <div class="addbtn" @click="openadd()">
                        <div class="addicon">
                            <i class="iconfont iconiconjia"></i>
                        </div>
                        添加新地址
                    </div>
                </div>
                <script>
                    var Vindex = new Vue({
                        el: '#wrap',
                        data: {
                            loginmsg: [],
                            all: false,
                            sum: '0.00',
                            type: 0,
                            paykg: true,
                            isLoading: false,
                            val1: '',
                            skip: 1
                        },
                        created: function () {
                            this.address();
                        },
                        mounted() {
                        },
                        methods: {
                            address: function (_this = this) {
                                $.ajax({
                                    type: "post",
                                    url: "<?php echo url('my_address/address_index'); ?>",
                                    data: {},
                                    success: function (res) {
                                        if (res.code == 1) {
                                            _this.loginmsg = res.data
                                        } else {
                                            layer.msg(res.msg)
                                        }

                                    },
                                    error: function (err) {
                                        layer.msg('操作失败')
                                        console.log(err)
                                    }
                                });
                            },
                            addressEdit(id) {
                                window.location.href = "address_edit?id="+id;
                            },
                            openadd() {
                                window.location.href = "<?php echo url('my_address/address_add'); ?>"
                            },
                            selecmr: function (id, index) {
                                var that = this
                                url = "<?php echo url('my_address/address_index'); ?>";
                                c = 'default'
                                this.ajax(url,id,c,that)
                            },
                            addressDel(id,index){
                                var that = this
                                layer.confirm('确定要删除吗？',{icon:3,title:'提示'},function(index){
                                    url = "<?php echo url('my_address/address_index'); ?>";
                                    c = 'delete';
                                    that.ajax(url,id,c,that)
                                    layer.close(index);
                                })
                            },
                            ajax(url,id,c,that){
                                $.ajax({
                                    type: "post",
                                    url: url,
                                    data: {id: id, c: c},
                                    success: function (res) {
                                        that.paykg == true

                                        if (res.code == 1) {
                                            that.loginmsg = res.data
                                            // return res.data
                                        } else {
                                            layer.msg(res.msg)
                                        }

                                    },
                                    error: function (err) {
                                        that.paykg == true
                                        layer.msg('获取失败')
                                    }
                                })
                            }
                        }
                    })
                </script>
            </div>
        </div>
    </div>
</div>

<!-- <script src="/static/index/js/zepto.js"></script>
<script src="/static/index/js/sm.js"></script>
<script src="/static/index/js/sm-extend.js"></script>
<script src="/static/index/js/app.js?349632766"></script>
 -->
</body>
</html>
