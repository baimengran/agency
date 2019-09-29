<?php /*a:1:{s:85:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\deliver_goods\dl_fahuo.html";i:1568975576;}*/ ?>
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
		
		<script src="/static/index/js/jquery.min.js"></script>
		<script src="/static/index/js/vue.min.js"></script>
		<script src="/static/index/js/layer/layer.js"></script>
		<title>我要发货</title>
		<style>
			*{
				margin: 0;
				padding: 0;
			}
			body{
				background-color: #f0f0f0;
				min-height: 100vh;
			}
			.webbox{
				padding: 30px 6px 80px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.mb10{
				margin-bottom: 10px;
			}
			.w100{
				width: 100%;
			}
			.f_box{
				margin-bottom: 16px;
			}
			.f_name{
				font-size: 14px;
				color: #141414;
				font-weight: bold;
				margin-bottom: 4px;
			}
			.ints{
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
			.seles{
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
			.bgfff{
				background-color: #fff;
			}
			.cz_box{
				position: fixed;
				left: 0;
				bottom: 10px;
				width: 100%;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				justify-content: space-between;
				padding: 0 6px;
			}
			.back_btn{
				width: 55px;
				height: 34px;
				background-color: #5ac2dd;
				color: #fff;
				font-size: 15px;
				border-radius: 4px;
			}
			.sub_btn{
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
				<div class="f_name">选择发货产品</div>
				<select class="seles" id="ding" name="goods" >
					 <option value="0">请选择发货产品</option>
					<?php foreach($product as $v): ?>
					<option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['title']); ?></option>
					<?php endforeach; ?>
				</select>
				<!-- <input class="ints" type="text"  placeholder="请输入" v-model="danjia"/> -->
			</div>
			<div class="w100 f_box">
				<div class="f_name">选择客户</div>
				<select class="seles" id="client" name="client" >
					<option value="0">请选择客户</option>
					<?php foreach($client as $v): ?>
					<option value="<?php echo htmlentities($v['id']); ?>"><?php echo htmlentities($v['name']); ?></option>
					<?php endforeach; ?>
				</select>

			</div>
			<div class="w100 f_box">
				<div class="f_name">剩余库存(台)</div>
				<input class="ints" type="text" id="s_num" name="s_num" value="" disabled  v-model="kucun"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">发货台数</div>
				<input class="ints bgfff" type="text" id="num" name="num" value=""  placeholder="请输入发货台数" v-model="xiangshu "/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">收货人</div>
				<input class="ints bgfff" type="text" id="consignee" name="consignee" value=""  placeholder="请输入收货人姓名" v-model="name"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">联系方式</div>
				<input class="ints bgfff" type="text" id="phone" name="phone" value=""  placeholder="请输入联系方式" v-model="tel"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">收货地址</div>
				<input class="ints bgfff" type="text" id="address" name="address" value=""  placeholder="请输入收货地址" v-model="address"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">备注信息</div>
				<input class="ints bgfff" type="text" id="remark" name="remark" value=""  placeholder="可不填" v-model="beizhu"/>
			</div>
			<div class="cz_box disflex ju_b">
				<div class="sub_btn disflex ju_c aic" onclick="saveadd()">提交发货单</div>
				<a class="back_btn disflex ju_c aic" href="javascript:history.go(-1);">返回</a>
			</div>
		</div>
		<script>
            $(document).ready(function(){
                $("#ding").change(function(){
                    pID = $("option:selected",this).val();//需求主键
					// console.log(1)
                    if(pID==='0'){
                        return false;
                    }
                    ajax("<?php echo url('deliver_goods/select_product'); ?>",pID);
                });
                $("#client").change(function(){
                    pID = $("option:selected",this).val();//需求主键
                    if(pID==='0'){
                        return false;
                    }
                    ajax("<?php echo url('deliver_goods/select_client'); ?>",pID);
                });

                $('#num').bind('input propertychange', function() {
                    num = $('#num').val();
                    s_num = $('#s_num').val();
                    if((/^(\+|-)?\d+$/.test(num))&&num>0){
                        heji = s_num-num;
                        if(heji<0){

                            tishi();
						}
                    }else{
                        layer.msg("数量输入错误，请输入正整数");
                        return false;
                    }
                });
            });
			function tishi(){
                layer.open({
                    title:'补货',
                    content:'当前货物数量不足',
                    icon:0,
                    btn:['立即补货','取消'],
                    yes:function(index){
                        location.href="<?php echo url('replenish_goods/index'); ?>";
                    },
                    btn2:function(index){
                        return close(index);
                    }
                });
			}
            function ajax(url,id){
                $.ajax({
                    //请求方式
                    type : "GET",
                    //请求的媒体类型
                    //请求地址
                    url : url,
                    //数据，json字符串
                    data : {id:id},
                    //请求成功
                    success : function(result) {
                        if(result.code===1){
                            $('#s_num').val('');
                            $('#s_num').val(result.data);
                        }else if(result.code===2){
                            $('#num').val('');
                            $('#consignee').val('');
                            $('#phone').val('');
                            $('#address').val('');
                            $('#num').val(result.data.buy_num);
                            $('#consignee').val(result.data.name);
                            $('#phone').val(result.data.phone);
                            $('#address').val(result.data.address);
						}else if(result.code==0){
                            tishi();
						}
						else{
                            layer.msg('查询失败')
                        }
                    },
                    //请求失败，包含具体的错误信息
                    error : function(e){
                        layer.msg('系统错误');
                    }
                });
            }
            function saveadd(){

                var goods=$("select[name='goods']").val()
                var s_num=$('#s_num').val();
                var num = $('#num').val();
                var consignee = $('#consignee').val();
                var phone = $('#phone').val();
                var address = $('#address').val();
                var remark = $('#remark').val();
                if(goods==''||goods==0){
                    layer.msg("请选择订货产品")
                    return
                }
                if(num==''){
                    layer.msg("请输入数量")
                    return
                }
                if(!(/^(\+|-)?\d+$/.test(num))||num<=0){
                    layer.msg("数量输入错误，请输入正整数");
                    return false;
                }
                if(s_num==""){
                    layer.msg("库存错误")
                    return
                }
                if(s_num-num<0){
                    tishi();
                    return false;
                }
                if(consignee==''){
                    layer.msg("请输入收件人")
                    return
                }
                if(phone==''){
                    layer.msg("请输入联系方式")
                    return
                }
                if(!(/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/.test(phone))){
                    layer.msg('顾客电话填写错误')
                    return;
                }
                if(address==''){
                    layer.msg("请输入收货地址")
                    return
                }

                layer.open({
                    title:'下单方式',
                    content:'请选择下单方式',
                    icon:0,
                    btn:['在线支付','线下支付'],
                    yes:function(index){
                        layer.msg('敬请期待')
                    },
                    btn2:function(index){
                        $.ajax({
                            type: "post",
                            url: "<?php echo url('deliver_goods/save'); ?>",
                            data: {
                                'id':goods,
                                's_num':s_num,
                                'num':num,
                                'consignee':consignee,
                        		'phone':phone,
                        		'address':address,
                                'remark':remark,
                            },
                            success: function(res) {
                                if(res.code===1){
                                    layer.msg(res.msg,function(){
                                        history.go(-1)
                                    });

                                }else{
                                    layer.msg(res.msg);
                                }
                            },
                            error: function(err) {
                                layer.msg('提交失败')
                            }
                        })
                    }
                });
            }
		</script>
	</body>
</html>
