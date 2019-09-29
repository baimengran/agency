<?php /*a:1:{s:87:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\reserve_goods\dl_dinghuo.html";i:1568801345;}*/ ?>
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
		<title>我要订货</title>
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
				padding: 30px 6px;
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
				<div class="f_name">选择订货产品</div>
				<select class="seles" name="goods" id="ding">
					 <option value="0">请选择订货产品</option>
					<?php foreach($product as $v): ?>
					<option style="font-size: 10px" data-first="<?php echo htmlentities($v['first_boxful_num']); ?>" value="<?php echo htmlentities($v['product_id']); ?>">
						<?php echo htmlentities($v['title']); ?> 首次需订购<?php echo htmlentities($v['first_boxful_num']); ?><?php echo $v['type']==0 ? '箱' : '台'; ?> 补货需<?php echo htmlentities($v['again_boxful_num']); ?><?php echo $v['type']==0 ? '箱' : '台'; ?>
					</option>
					<?php endforeach; ?>
				</select>
				<!-- <input class="ints" type="text"  placeholder="请输入" v-model="danjia"/> -->
			</div>
			<div class="w100 f_box">
				<input type="hidden" id="type" name="type" value="">
				<div class="f_name">单价(元)</div>
				<input class="ints" type="text" id="danjia" value="" disabled placeholder="请输入" v-model="danjia"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">箱价(元)</div>
				<input class="ints" type="text" id="xiangjia" value="" disabled placeholder="请输入" v-model="danjia"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">数量（箱/台）</div>
				<input class="ints bgfff" type="text" value="" id="num"  placeholder="请输入" v-model="xiangshu"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">合计金额(元)</div>
				<input class="ints" type="text" id="heji" value="" disabled  placeholder="请输入" v-model="heji"/>
			</div>
			<div class="w100 f_box">
				<div class="f_name">备注信息</div>
				<input class="ints bgfff" type="text" id="beizhu" value=""  placeholder="打款说明等信息,可不填" v-model="beizhu"/>
			</div>
			<div>
				<input id="agency" type="hidden" name="agency" value=""/>
			</div>
			<div class="cz_box disflex ju_b">
				<div class="sub_btn disflex ju_c aic" onclick="saveadd()">提交订货单</div>
				<a class="back_btn disflex ju_c aic" href="javascript:history.go(-1);">返回</a>
			</div>
		</div>
		<script>
			$(document).ready(function(){
			    let agency = $('#agency').val();
                $("#ding").change(function(){
                    pID = $("option:selected",this).val();//需求主键
					if(pID==='0'){
					    return false;
					}
                    $.ajax({
                        //请求方式
                        type : "GET",
                        //请求的媒体类型
                        //请求地址
                        url : "<?php echo url('reserve_goods/select_product'); ?>",
                        //数据，json字符串
                        data : {id:pID},
                        //请求成功
                        success : function(result) {
							if(result.code===1){
							    $('#num').val('');
                                $('#heji').val('');
							    $('#danjia').val('');
                                $('#xiangjia').val('');
                                $('#type').val('');
                                $('#type').val(result.data.type);
							    $('#danjia').val(result.data.agency_price);
                                $('#xiangjia').val(result.data.agency_box_price);
                                $('#num').val(result.data.first_boxful_num);
                                num = $("#num").val();
                                xiangjia = $('#xiangjia').val();
                                danjia = $('#danjia').val();
                                if(result.data.type==0){
                                    heji = (num*xiangjia);
								}else{
                                    heji = (num*danjia);
								}
                                heji = heji.toFixed(2);
                                $('#heji').val(heji)
							}else{
							    layer.msg('商品查询失败')
							}
                        },
                        //请求失败，包含具体的错误信息
                        error : function(e){
                            layer.msg('系统错误');
                        }
                    });
                });

                $('#num').bind('input propertychange', function() {
                    num = $('#num').val();
                    first_num = $("#ding").find("option:selected").attr("data-first");
                    danjia = $('#danjia').val();
                    xiangjia = $('#xiangjia').val();
                    if((/^(\+|-)?\d+$/.test(num))&&num>0){
                        if(num-first_num<0){
                            layer.msg("当前代理等级订购产品数量不能少于"+first_num);
                            return false;
                        }
                        type = $('#type').val();
                        if(type=='0'){
                            heji = (num*xiangjia);
                        }else{
                            heji = (num*danjia);
                        }
                        heji = heji.toFixed(2);
                        $('#heji').val(heji)
                    }else{
                        layer.msg("数量输入错误，请输入正整数");
                        return false;
                    }
                });
			});

			function saveadd(){

				 var goods=$("select[name='goods']").val()
				 var danjia = $('#danjia').val();
				 var num = $('#num').val();
				 var heji = $('#heji').val();
				 var beizhu = $('#beizhu').val();
				 var type = $('#type').val();
				 if(goods==''||goods==0){
					layer.msg("请选择订货产品")
					return
				 }
			  if(danjia==''){
			    layer.msg("请输入单价")
			    return
			  }
                num = $('#num').val();
                first_num = $("#ding").find("option:selected").attr("data-first");
                xiangjia = $('#xiangjia').val();
			  if((/^(\+|-)?\d+$/.test(num))&&num>0){
                  if(num-first_num<0){
                      layer.msg("当前代理等级订购产品数量不能少于"+first_num);
                      return false;
                  }
                }else{
                    layer.msg("数量输入错误，请输入正整数");
                    return false;
                }
			  if(num==""){
			    layer.msg("请输入数量")
			    return
			  }
			  if(heji==''){
			    layer.msg("请输入合计金额")
			    return
			  }

			  layer.open({
				  title:'下单方式',
				  content:'请选择下单方式',
				  icon:0,
				  btn:['在线支付','线下支付'],
				  yes:function(index){
                      $.ajax({
                          type: "post",
                          url: "<?php echo url('reserve_goods/save'); ?>",
                          data: {
                              'product_id':goods,
                              'price':danjia,
							  'box_price':xiangjia,
                              'num':num,
                              'total_price':heji,
                              'remark':beizhu,
                              'type':type,
							  'pay':1,
                          },
                          success: function(res) {
                              if(res.code===1){
                                      <!--通过config接口注入权限验证配置-->
                                      wx.config({
                                          debug: true, // 开启调试模式
                                          appId: res.config_sign.appId, // 公众号的唯一标识
                                          timestamp: res.config_sign.timestamp, // 生成签名的时间戳
                                          nonceStr: res.config_sign.nonceStr, // 生成签名的随机串
                                          signature: res.config_sign.signature,// 签名
                                          jsApiList: ['chooseWXPay'] // 填入需要使用的JS接口列表，这里是先声明我们要用到支付的JS接口
                                      });

                                      <!-- config验证成功后会调用ready中的代码 -->
                                      wx.ready(function(){
                                              //弹出支付窗口
                                              wx.chooseWXPay({
                                                  timestamp: '${payMap.timeStamp}', // 支付签名时间戳，
                                                  nonceStr: '${payMap.nonceStr}', // 支付签名随机串，不长于 32 位
                                                  package: '${payMap.packageStr}', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=xxxx）
                                                  signType: '${payMap.signType}', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                                                  paySign: '${payMap.paySign}', // 支付签名
                                                  success: function (res) {
                                                      // 支付成功后的回调函数
                                                      layer.msg('支付成功',function(index){
                                                          history.go(1)
													  });
                                                  }
                                          })
                                      });

                              }else{
                                  layer.msg(res.msg);
                              }
                          },
                          error: function(err) {
                              layer.msg('提交失败')
                          }
                      })
				  },
				  btn2:function(index){
                      $.ajax({
                      type: "post",
                      url: "<?php echo url('reserve_goods/save'); ?>",
                      data: {
                          'product_id':goods,
                          'price':danjia,
                          'box_price':xiangjia,
                          'num':num,
                          'total_price':heji,
                          'remark':beizhu,
						  'box_type':type,
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
