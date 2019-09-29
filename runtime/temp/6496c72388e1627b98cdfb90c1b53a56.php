<?php /*a:1:{s:71:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\cart\car.html";i:1568972406;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>购物车</title>
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

        #wrap {
            height: auto;
            padding-bottom: 50px;
        }

        .goodslist {
            width: 100%;
            /* background-color: #f7f7f7; */
        }

        .gone {
            width: 100%;
            height: 120px;
            padding: 20px 14px;
            background-color: #fff;
            margin-bottom: 12px;
            -ms-align-items: center;
            align-items: center;
            position: relative;
        }

        .car_del {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #f1f1f1;
        }

        .car_del img {
            width: 15px;
            height: 15px;
        }

        .xuanze {
            width: 22px;
            height: 22px;
            margin-right: 5px;
            /* padding: 20px 15px 20px 0; */

        }

        .xuanze1 {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 1px solid #ddd;
            justify-content: center;
            -ms-align-items: center;
            align-items: center;

        }

        .xuanze2 {
            border: 0;
            background-color: #fe0042;
            color: #fff;
        }

        .iconduigou1 {
            font-size: 16px;
        }

        .imgk {
            width: 80px;
            height: 80px;
        }

        .imgk > img {
            width: 100%;
            height: 100%;
        }

        .goodsmsg {
            min-height: 80px;
            margin-left: 10px;
            flex-direction: column;
            justify-content: space-between;
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

        .steppera .vantjia, .steppera .vantjian {
            width: 20px;
            background-color: #fff;
            margin: 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .iconjia, .iconjian {
            font-size: 12px !important;
        }

        .vbottom {
            width: 100%;
            height: 50px;
            position: fixed;
            bottom: 50px;
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
            text-align: right;
            padding-right: 10px;
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

        .sj3 {
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="page-group">
    <div class="page page-current" id="cart">
        <header class="bar bar-nav">
            <h1 class="title">购物车</h1>
        </header>
        <div class="bar bar-tab bar-footer">
            <a class="tab-item external" href="<?php echo url('index/index'); ?>">
                <span class="icon icon-home"></span>
                <span class="tab-label">商品</span>
            </a>
            <a class="tab-item external active" href="<?php echo url('cart/index'); ?>">
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
            <?php if(empty($count)): ?>
            <div v-if="carlist.length==0" class="content-block" style="display: block;">
                <p>购物车空空如也,去选购点商品吧~</p>
                <p><a href="<?php echo url('index/index'); ?>" class="button button-fill button-round external">前往选购</a></p>
            </div>
            <?php else: ?>
            <div v-if="carlist.length>0" id="wrap" class="wrap disflex">
                <div class="goodslist">
                    <div class="gone disflex boxsiz" v-for="(item,index) in carlist">
                        <div class="car_del" @click="car_del(index,item.id)">
                            <img src="/static/index/img/car_del.png">
                        </div>
                        <div class="xuanze" @click="select(index)">
                            <div v-if="carlist" class="xuanze1 disflex"
                                 :class="{'xuanze2':xzbox[index].xuan==true}">
                                <!-- <icon  type="success" color="#fe0042" /> -->
                                <i v-show="xzbox[index].xuan==true" class="iconfont iconduigou1"></i>
                            </div>
                        </div>
                        <div class="imgk">
                            <img :src="item.pic" alt="">
                        </div>
                        <div class="goodsmsg flex1 disflex">
                            <div class="fz14 c3 oh1" v-html="item.title"></div>
                            <div class="disflex">
                                <!-- <span class="zhekou fz12 cf disflex">商家自营</span> -->
                                <!-- <span class="fz12 c9">库存：500件</span> -->
                            </div>
                            <div class="sj3">
                                <!-- <div> -->
                                <span class="fz18 cfe0042">￥{{item.price}}</span>
                                <!-- <s class="fz12 c9" v-html="getpri(item.addprice)">￥236.00</s> -->
                                <!-- </div> -->

                            </div>
                            <div class="vstepper steppera flexend">
                                <div @click="onNum(index,'-')" class="vantjian">
                                    <i class="iconfont iconjian c6"></i>
                                </div>
                                <input class="vanipt" disabled :value="xzbox[index].num"/>
                                <div @click="onNum(index,'+')" class="vantjia">
                                    <i class="iconfont iconjia c6"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="vbottom">
                    <div class="selecAll" @click="selecAll">
                        <!-- <div class="xuanze1 all " :class="{'xuanze2':all==true}">
                          <icon  wx:if="{{all==true}}" type="success" color="#fe0042" />
                        </div> -->
                        <div class="xuanze1 all disflex" :class="{'xuanze2':all==true}">
                            <!-- <icon  type="success" color="#fe0042" /> -->
                            <i v-show="all==true" class="iconfont iconduigou1"></i>
                        </div>
                        全选
                    </div>
                    <div v-show="guanli" class="heji" v-html="'合计:'+heji">
                    </div>
                    <div v-show="guanli" class="jiesuan" @click="openOrder">去结算</div>
                    <div v-show="!guanli" class="heji"></div>
                    <div v-show="!guanli" class="jiesuan" @click="del()">删除</div>
                </div>
            </div>
            <?php endif; ?>
            <!-- <div class="content-inner" style="display: none;">
                <div class="list-block">
                    <ul>

                    </ul>
                </div>
                <div class="content-block-title">合计:<span class="cart-total">0</span>元</div>
                <div class="content-block-title"><a href="javascript:void(0);" class="button button-fill button-success cart-submit">下一步</a></div>
            </div> -->
        </div>
    </div>
</div>

<script>
    var vm = new Vue({
        el: '#wrap',
        data: {
            carlist: [],
            xzbox: [],
            all: false,
            sum: '0.00',
            guanli: 1,
            fenleicur: 0,
            film: [],
            isLoading: false,
            val1: '',
            skip: 1,
            heji: 0,
        },
        created: function () {
            // `this` 指向 vm 实例
            this.getcar(this);
            // fnInitEvent()
            // fnInitData()
        },
        mounted() {
        },
        methods: {
            //获取购物车
            getcar(_this) {
                $.ajax({
                    type: "post",
                    url: "<?php echo url('cart/index'); ?>",
                    data: {
                        // id:id
                    },
                    success: function (res) {
                        console.log($.parseJSON(res.xuan))
                        if (res.code === 1) {
                            _this.xzbox = $.parseJSON(res.xuan);
                            _this.carlist = res.data;

                        } else {
                            if (res.msg) {
                                layer.msg(res.msg)
                            } else {
                                layer.msg('获取失败')
                            }
                        }

                    },
                    error: function (err) {
                        layer.msg('获取失败')
                        console.log(err)
                    }
                })
            },
            //修改数量
            onNum(index, type) {
                var that = this
                if (that.xzbox[index].num < 2 && type == '-') {
                    console.log('禁止')
                    return false;
                }
                if (that.xzbox[index].num > 98 && type == '+') {
                    console.log('禁止')
                    return false;
                }
                /*
                  { "apipage": "shopcar", "op": "num", "tokenstr": userinfo.logintoken.tokenstr, "id": id, "num": num }
                */
                var nnum = that.xzbox[index].num
                var nnum1
                var id = that.xzbox[index].o_id
                if (type == '-') {
                    nnum1 = nnum - 1
                } else {
                    nnum1 = nnum - 1 + 2
                }
                that.xzbox[index].num = nnum1
                $.ajax({
                    type: "post",
                    url: "<?php echo url('cart/order_place'); ?>",
                    data: {id:id,num:nnum1},
                    success: function(res) {
                        if (res.code == 1) {

                        } else {
                            if (res.msg) {
                                layer.msg(res.msg)
                            } else {
                                layer.msg('操作失败')
                            }
                        }

                    },
                    error: function(err) {
                        layer.msg('操作失败')
                        console.log(err)
                    }
                });

                this.countpri()
            },
            countpri() {
                var heji = 0
                var var2 = this.xzbox
                // console.log(this.xzbox)
                // console.log(JSON.stringify(this.xzbox))
                for (let i in var2) {
                    if (var2[i].xuan == true) {
                        heji += var2[i].num * var2[i].pri
                        this.heji = heji.toFixed(2);
                    }else{
                        heji += var2[i].num * 0
                        this.heji = heji.toFixed(2);
                    }
                }
                this.sum = heji
                // console.log("321:"+this.sum)
            },
            select(index) {
                var that = this
                if (this.xzbox[index].xuan == false) {
                    this.xzbox[index].xuan = true

                } else {
                    this.xzbox[index].xuan = false

                }
                let qx = true
                for (let i in this.xzbox) {
                    if (this.xzbox[i].xuan == false) {
                        qx = false
                        break
                    }
                }
                // console.log("339："+qx)
                //触发全选
                if (qx == true) {
                    this.all = true
                } else {
                    this.all = false
                }
                //计算总价
                this.countpri()
            },
            openOrder(id) {
                var that = this
                var xuanG = that.xzbox
                var ids = [];
                let num= '';
                var msgarr = []
                for (let i in xuanG) {
                    if (xuanG[i].xuan) {
                        var msg1 = ''
                        ids[i]=xuanG[i].o_id;
                    }
                }
                // console.log(ids_num)
                if (ids.length===0) {
                    layer.msg('请选择商品')
                } else {
                    location.href="order_place?ids="+ids+"&field=ti";
                }

            },
            car_del(index,id,_this=this) {
                var that = this
                $.ajax({
                    type: "post",
                    url: "<?php echo url('cart/delete'); ?>",
                    data: {id: id},
                    success: function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg)
                            _this.carlist.splice(index,1);
                        } else {
                            layer.msg(res.msg)
                        }
                    },
                    error: function (err) {
                        layer.msg('操作失败')
                    }
                })

            },
            selecAll() {
                // let kg
                // if(this.all==false){
                //   kg=true
                // }else{
                //   kg=false
                // }
                this.all = !this.all
                // this.data.goods_sele[sid].xuan=true
                for (let i in this.xzbox) {
                    this.xzbox[i].xuan = this.all
                }
                //计算总价
                this.countpri()
            },

        }
    })
</script>
<!-- <script src="/static/index/js/sm.js"></script>
<script src="/static/index/js/sm-extend.js"></script>
<script src="/static/index/js/sm-city-picker.min.js"></script>
<script src="/static/index/js/app.js?1182126340"></script> -->

</body>
</html>
