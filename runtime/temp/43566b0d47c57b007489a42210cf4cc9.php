<?php /*a:1:{s:73:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\my\dl_myjs.html";i:1568684391;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit" />
		<meta name="force-rendering" content="webkit" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
		<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
		<link rel="stylesheet" href="/static/index/css/style.css">
		<link rel="stylesheet" href="/static/index/js/layer/mobile/need/layer.css">
		<link rel="stylesheet" href="/static/index/css/vantIndex.css">
		<link rel="stylesheet" href="http://at.alicdn.com/t/font_1218663_avyf5h8t28e.css">
		
		<script src="/static/index/js/jquery.min.js"></script>
		<script src="/static/index/js/vue.min.js"></script>
		<script src="/static/index/js/vant.js"></script>
		<script src="/static/index/js/layer/layer.js"></script>
		<title>我的结算记录</title>
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
				padding-bottom: 80px;
			}
			.bu_box{
				width: 100%;
				height: 40px;
			}
			.bu_box>div{
				border: 1px solid transparent;
				border-bottom: 1px solid #dcdcdc;
			}
			.bu_box>div.cur{
				border: 1px solid #dcdcdc;
				border-bottom: 1px solid transparent;
			}
			.table_d{
				width: 100%;
				padding: 24px 9px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.list_t{
				width: 100%;
				border: 1px solid #dadada;
				text-align: center;
			}
			.list_t th,.list_t td{
				border: 1px solid #DADADA;
				font-size: 12px;
				height: 40px;
			}
			.list_t th{
				height: 35px;
			}
			.xq_btn{
				width: 35px;
				height: 24px;
				background-color: #60b560;
				color: #fff;
				font-size: 15px;
				border-radius: 4px;
				margin: 0 auto;
				font-size: 12px;
			}
			.cz_box{
				justify-content: space-between;
				padding: 0 6px;
				width: 100%;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				position: fixed;
				bottom: 10px;
			}
			.back_btn{
				width: 85px;
				height: 34px;
				background-color: #5ac2dd;
				color: #fff;
				font-size: 15px;
				border-radius: 4px;
			}
			.sub_btn{
				width: 85px;
				height: 34px;
				background-color: #60b560;
				color: #fff;
				font-size: 15px;
				border-radius: 4px;
			}
			.van-popup{
				border-radius: 8px;
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
			.xq_name{
				width: 4em;
				text-align:justify;          
				text-justify:distribute-all-lines;  
				text-align-last:justify;     
			}
			.js_znum{
				width: 100%;
				height: 42px;
				background-color: #fff;
				padding: 0 16px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				border: 1px solid #dadada;
				border-radius: 4px;
				margin-bottom: 20px;
				font-size: 15px;
				color: #1e1e1e;
			}
		</style>
	</head>
	<body>
		<div class="webbox" id="webbox">
			<div class="bu_box disflex ju_b">
				<div class="flex1 disflex ju_c aic" 
				:class="bhtype==0?'cur':''" @click="bh_cur(0)">本月结算记录</div>
				<div class="flex1 disflex ju_c aic" 
				:class="bhtype==1?'cur':''" @click="bh_cur(1)">上月结算记录</div>
				
			</div>
			<div class="table_d" v-if="bhtype==0">
				<div class="js_znum disflex aic">本月结算总金额：{{num}}元</div>
				<table class="list_t"as border="1" cellpadding="0" cellspacing="0">
					<tr>
						<th></th>
						<th>奖励来源</th>
						<th>奖励百分比</th>
						<th>结算</th>
						<th></th>
					</tr>
					<tr v-for="(item,index) in items">
						<td v-html="index+1"></td>
						<td>{{item.source}}</td>
						<td>{{item.percent}}</td>
						<td>{{item.money}}</td>
						<td>

					</tr>
				</table>
			</div>
			<div class="table_d" v-if="bhtype==1">
				<div class="js_znum disflex aic">本月结算总金额：{{num}}元</div>
				<table class="list_t"as border="1" cellpadding="0" cellspacing="0">
					<tr>
						<th></th>
						<th>奖励来源</th>
						<th>奖励百分比</th>
						<th>结算</th>
						<th></th>
					</tr>
					<tr v-for="(item,index) in items">
						<td v-html="index+1"></td>
						<td>{{item.source}}</td>
						<td>{{item.percent}}</td>
						<td>{{item.money}}</td>

					</tr>
				</table>
			</div>

			<div class="cz_box disflex ju_b">
				<div></div>
				<a class="back_btn disflex ju_c aic" href="javascript:history.go(-1);">返回首页</a>
			</div>
		</div>
		<script>
            var vm=new Vue({
                el: '#webbox',
                data: {
                    bhtype:0,
                    items:[],
					num:0,
                },
                created: function () {

                },
                mounted () {
                    this.send(0,this)
                },
                methods:{
                    send:function(num=0,_this){
                        $.ajax({
                            type: "get",
                            async: false,
                            url: "<?php echo url('my/my_earnings'); ?>",
                            data: {filtrate:num},
                            success: function(res) {
                                if(res.code===1){
                                    _this.items = res.data;
                                    _this.num = res.num;
                                }else if(res.code===2){

                                }else{
                                    layer.msg(res.msg);
                                }
                            },
                            error: function(err) {
                                layer.msg('提交失败')
                            }
                        })
                    },
                    bh_cur(num){
                        this.send(num,this);
                        this.bhtype=num
                    },
                    getxq(id){

                    }
                }
            })

		</script>
	</body>
</html>
