<?php /*a:1:{s:73:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\my\dl_myxj.html";i:1568771679;}*/ ?>
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
		<title>我的下级代理</title>
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
		</style>
	</head>
	<body>
		<div class="webbox" id="webbox">
			<div class="bu_box disflex ju_b">
				<div class="flex1 disflex ju_c aic" 
				:class="bhtype==0?'cur':''" @click="bh_cur(0,id)">我的下级代理</div>
				<div class="flex1 disflex ju_c aic" 
				:class="bhtype==1?'cur':''" @click="bh_cur(1,id)">待审核列表</div>
				
			</div>
			<div class="table_d" v-if="bhtype==0">
				<table class="list_t"as border="1" cellpadding="0" cellspacing="0">
					<tr>
						<th>代理姓名</th>
						<th>级别</th>
						<th>状态</th>
						<th></th>
					</tr>
					<tr v-for="(item,index) in items">
						<td><a :href="'my_agency?id='+item.id">{{item.name}}</a></td>
						<td>{{item.agency}}</td>
						<td>{{item.status}}</td>
						<td>
							<div class="xq_btn disflex ju_c aic" @click="getxq(item.id)">详情</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="table_d" v-if="bhtype==1">
				<table class="list_t"as border="1" cellpadding="0" cellspacing="0">
					<tr>
						<th>代理姓名</th>
						<th>级别</th>
						<th>状态</th>
						<th></th>
					</tr>
					<tr v-for="(item,index) in items">
						<td><a :href="'my_agency?id='+item.id">{{item.name}}</a></td>
						<td>{{item.agency}}</td>
						<td v-if="item.status=='待审核'"><a href="javascript:void(0)" class="xq_btn disflex ju_c aic" style="background-color: crimson;font-size: 11px" @click="status(item.id)">{{item.status}}</a></td>
						<td v-if="item.status!='待审核'">{{item.status}}</td>
						<td>
							<div class="xq_btn disflex ju_c aic" @click="getxq(item.id)">详情</div>
						</td>
					</tr>
				</table>
			</div>

			<van-popup v-model="show">
				<div class="xqbox">
					<p class="disflex"><span class="xq_name">真实姓名</span>：{{details.real_name}}</p>
					 <p class="disflex"><span class="xq_name">代理级别</span>：{{details.title}}</p>
					<p class="disflex"><span class="xq_name">微信号</span>：{{details.wechatid}}</p>
					<p class="disflex"><span class="xq_name">电话</span>：{{details.phone}}</p>
					<p class="disflex"><span class="xq_name">审核状态</span>：{{details.status}}</p>
					<p class="disflex"><span class="xq_name">审核日期</span>：{{details.status_time}}</p>
				</div>
			</van-popup>
			<div class="cz_box disflex ju_b">
				<a class="sub_btn disflex ju_c aic" href="javascript:void(0)" onclick=location.href="<?php echo url('my/agency_generate'); ?>">代理生成</a>
				<a class="back_btn disflex ju_c aic" href="<?php echo url('my/index'); ?>">返回首页</a>
			</div>
		</div>
		<script>
            var vm=new Vue({
                el: '#webbox',
                data: {
                    show:false,
                    bhtype:0,
                    items:[],
					id:'',
                    details:[],
                },
                created: function () {
                    id = <?php echo htmlentities($id); ?>;
                    console.log(id);
                    this.send(0,this,id)
                },
                mounted () {
                },
                methods:{
                    send:function(num=0,_this,id,show){
                        $.ajax({
                            type: "get",
                            async: false,
                            url: "<?php echo url('my/my_agency'); ?>",
                            data: {filtrate:num,id:id,show:show},
                            success: function(res) {
                                if(res.code===1){
                                    _this.items = res.data;
                                    _this.id=res.id;
                                }else if(res.code===2){
                                    _this.details = res.data;
                                }else{
                                    layer.msg(res.msg);
                                }
                            },
                            error: function(err) {
                                layer.msg('提交失败')
                            }
                        })
                    },
                    bh_cur(num,id){
                        this.send(num,this,id);
                        this.bhtype=num
                    },
                    getxq(id){
                        this.send(0,this,0,id);
                        this.show=true;
                        // this.send(0,this,id)
                    },
					status:function(id){
                        layer.confirm('确认审核通过？',{icon:3,title:'审核确认'},function(index){
                            $.ajax({
                                type:'GET',
                                url:"<?php echo url('my/status'); ?>",
                                data:{id:id},
                                success:function(res){
                                    if(res.code===1){
										layer.msg(res.msg);
                                    }else{
                                        layer.msg(res.msg);
									}
                                },
								error:function(err){
                                    layer.msg('系统错误');
								},
                            });
                            layer.close(index);
						});
					}
                }
            })
		</script>
	</body>
</html>
