<?php /*a:1:{s:88:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\exchange_goods\dl_diaohuo.html";i:1567967878;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta name="viewport"
          content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <link rel="stylesheet" href="/static/index/css/style.css">
    <link rel="stylesheet" href="http://at.alicdn.com/t/font_1218663_avyf5h8t28e.css">

    <script src="/static/index/js/jquery.min.js"></script>
    <script src="/static/index/js/vue.min.js"></script>
    <script src="/static/index/js/layer/layer.js"></script>
    <title>我要调货</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f0f0f0;
            min-height: 100vh;
        }

        .webbox {
            padding: 30px 6px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .mb10 {
            margin-bottom: 10px;
        }

        .w100 {
            width: 100%;
        }

        .f_box {
            margin-bottom: 16px;
        }

        .f_name {
            font-size: 14px;
            color: #141414;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .ints {
            width: 100%;
            height: 36px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border: 1px solid #c2c2c2;
            border-top: 3px solid #c2c2c2;
            border-radius: 6px;
            background-color: #efefef;
            padding: 0 14px;
        }

        .seles {
            width: 100%;
            height: 36px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border: 1px solid #c2c2c2;
            border-radius: 6px;
            background-color: #efefef;
            padding: 0 14px;
        }

        .bgfff {
            background-color: #fff;
        }

        .cz_box {

            justify-content: space-between;
            padding: 0 6px;
        }

        .back_btn {
            width: 55px;
            height: 34px;
            background-color: #5ac2dd;
            color: #fff;
            font-size: 15px;
            border-radius: 4px;
        }

        .sub_btn {
            width: 100px;
            height: 34px;
            background-color: #60b560;
            color: #fff;
            font-size: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="webbox" id="webbox">
    <div class="w100 f_box">
        <div class="f_name">选择调货产品</div>
        <select class="seles" name="goods_1" id="goods_1">
            <option value="0">请选择调货产品</option>
            <?php foreach($product as $v): ?>
            <option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['title']); ?></option>
            <?php endforeach; ?>
        </select>
        <!-- <input class="ints" type="text"  placeholder="请输入" v-model="danjia"/> -->
    </div>
    <div class="w100 f_box">
        <div class="f_name">库存</div>
        <input class="ints" type="text" disabled id="s_num_1" name="s_num_1" v-model="danjia"/>
    </div>
    <div class="w100 f_box">
        <div class="f_name">选择调货产品</div>
        <select class="seles" name="goods_2" id="goods_2">
            <option value="0">请选择调货产品</option>
            <?php foreach($product as $v): ?>
            <option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['title']); ?></option>
            <?php endforeach; ?>

        </select>
        <!-- <input class="ints" type="text"  placeholder="请输入" v-model="danjia"/> -->
    </div>
    <div class="w100 f_box">
        <div class="f_name">库存</div>
        <input class="ints" type="text" disabled id="s_num_2" name="s_num_2" v-model="xiangshu"/>
    </div>

    <div class="w100 f_box">
        <div class="f_name">调货数量</div>
        <input class="ints bgfff" type="text" name="num" id="num" value="" placeholder="请输入" v-model="heji"/>
    </div>
    <div class="w100 f_box">
        <p id="remark"></p>
    </div>
    <div class="cz_box disflex ju_b">
        <div class="sub_btn disflex ju_c aic" onclick="saveadd()">提交调货单</div>
        <a class="back_btn disflex ju_c aic" href="javascript:history.go(-1);">返回</a>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#goods_1").change(function () {
            pID = $("option:selected", this).val();//需求主键
            // console.log(1)
            if (pID === '0') {
                return false;
            }
            $('#num').val('');
            ajax("<?php echo url('exchange_goods/select_product'); ?>", pID, 1);
        });
        $("#goods_2").change(function () {
            pID = $("option:selected", this).val();//需求主键
            if (pID === '0') {
                return false;
            }
            $('#num').val('');
            ajax("<?php echo url('exchange_goods/select_product'); ?>", pID, 2);
        });

        $('#num').bind('input propertychange', function () {
            goods_1 = $('#goods_1').val();
            goods_2 = $('#goods_2').val();
            if (goods_1 === '0' || goods_2 === '0') {
                layer.msg('请选择货物');
                $('#num').val('');
                return false;
            }
            if (goods_1 === goods_2) {
                layer.msg('不能选择相同产品');
                $('#num').val('');
                return false;
            }
            num = $('#num').val();
            s_num_1 = $('#s_num_1').val();
            if ((/^(\+|-)?\d+$/.test(num)) && num > 0) {
                heji = s_num_1 - num;
                if (heji < 0) {
                    tishi();
                } else {
                    html = '您将从 【' + $('#goods_1').find("option:selected").text() +
                        '】 调取 ' + $('#num').val() + ' 件货物到 【' + $('#goods_2').find("option:selected").text() + ' 】';
                    $('#remark').empty();
                    $('#remark').append(html);
                }
            } else {
                layer.msg("数量输入错误，请输入正整数");
                return false;
            }
        });
    });

    function tishi() {
        layer.open({
            title: '补货',
            content: '当前货物数量不足',
            icon: 0,
            btn: ['立即补货', '取消'],
            yes: function (index) {
                location.href = "<?php echo url('replenish_goods/index'); ?>";
            },
            btn2: function (index) {
                close(index);
            }
        });
    }

    function ajax(url, id, s_num) {
        $.ajax({
            //请求方式
            type: "GET",
            //请求的媒体类型
            //请求地址
            url: url,
            //数据，json字符串
            data: {id: id},
            //请求成功
            success: function (result) {
                if (result.code === 1) {
                    if (s_num === 1) {
                        $('#s_num_1').val('');
                        $('#s_num_1').val(result.data);
                    } else {
                        $('#s_num_2').val('');
                        $('#s_num_2').val(result.data);
                    }
                } else if (result.code === 2) {
                    $('#num').val('');
                    $('#consignee').val('');
                    $('#phone').val('');
                    $('#address').val('');
                    $('#num').val(result.data.buy_num);
                    $('#consignee').val(result.data.name);
                    $('#phone').val(result.data.phone);
                    $('#address').val(result.data.address);
                } else {
                    layer.msg('查询失败')
                }
            },
            //请求失败，包含具体的错误信息
            error: function (e) {
                layer.msg('系统错误');
            }
        });
    }

    function saveadd() {

        var goods_1 = $("select[name='goods_1']").val()
        var goods_2 = $("select[name='goods_2']").val()

        var num = $('#num').val();
        if (goods_1 == '' || goods_1 == '0') {
            layer.msg("请选择货物")
            return
        }
        if (goods_2 == '' || goods_2 == '0') {
            layer.msg("请选择货物")
            return
        }
        if (num == '') {
            layer.msg("请输入数量")
            return
        }
        if (!(/^(\+|-)?\d+$/.test(num)) || num <= 0) {
            layer.msg("数量输入错误，请输入正整数");
            return false;
        }
        if ($('#s_num_1') - num <= 0) {
            tishi();
            return false;
        }

        layer.open({
            title: '下单',
            content: '确认无误后请下单',
            icon: 1,
            btn: ['确认', '取消'],
            yes: function (index) {
                $.ajax({
                    type: "post",
                    url: "<?php echo url('exchange_goods/save'); ?>",
                    data: {
                        'goods_1': goods_1,
                        'goods_2': goods_2,
                        'num': num,
                    },
                    success: function (res) {
                        if (res.code === 1) {
                            layer.msg(res.msg, function () {
                                history.go(-1)
                            });
                        } else {
                            layer.msg(res.msg);
                        }
                    },
                    error: function (err) {
                        layer.msg('提交失败')
                    }
                })
            },
            btn2: function (index) {
                close(index);
            }
        });
    }
</script>
</body>
</html>
