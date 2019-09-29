<?php /*a:1:{s:77:"D:\phpstudy_pro\WWW\www.agency.com\application\index\view\my\address_add.html";i:1568972301;}*/ ?>
<!DOCTYPE html>
<html class="pixel-ratio-1">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>新增地址</title>
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
		</style>
		<style>
			#wrap{
			  height: auto;
			  padding:0 14px;
			  flex-direction: column;
			  background-color: #ffffff;
			}
			.addmsg{
			  width: 100%;
			  height: 45px;
			  border-bottom: 1px solid #e8e8e8;
			  display: flex;
			  justify-content: space-between;
			  align-items: center;
			  font-size: 14px;
			  color: #333;
			}
			.msgtit{
			  width: 70px;
			}
			.msgsrk{
			  flex: 1;
			}
			.fixbottom{
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
			.addbtn{
			  width: 100%;
			  height: 44px;
			  background-color: #c49e85;
			  display: flex;
			  justify-content: center;
			  align-items: center;
			  color: #fff;
			  font-size: 14px;
			}
			.addicon{
			  margin-right: 7px;
			  display: flex;
			  justify-content: center;
			  align-items: center;
			}
		</style>
	</head>
	<body>
		<div class="page-group">
			<div class="page page-current" id="checkauth">
				<header class="bar bar-nav">
					<a class="button button-link button-nav pull-left back" href="javascript:history.go(-1);"> <span class="icon icon-left"></span>
						返回 </a>
					<h1 class="title">新增地址</h1>
				</header>
				<div class="content native-scroll">
					<div id="wrap" class="wrap disflex">
					  <div class="addmsg">
					    <div class="msgtit">收货人</div>
					    <input class="msgsrk" name="name" id="name" v-model="username" type="text" placeholder="请填写收货人姓名"/>
					  </div>
					  <div class="addmsg">
					    <div class="msgtit">手机号码</div>
					    <input class="msgsrk" name="phone" id="phone" v-model="usertel" type="text" placeholder="请填写收货人手机号"/>
					  </div>
					  <div class="addmsg" @click="sel_area()">
					    <div class="msgtit">所在地址</div>
					    <input class="msgsrk" readonly type="text" id="address1" name="address1" v-model="area" placeholder="请选择所在地址"/>
					  </div>
					  <div class="addmsg">
					    <div class="msgtit">详细地址</div>
					    <input class="msgsrk" name="address2" id="address2" v-model="useraddress" type="text" placeholder="街道、楼牌号等"/>
					  </div>
					  <van-popup v-model="show_area" position="bottom" :overlay="true">
					    <van-area :area-list="areaList" :columns-num="3" @confirm="conf" @cancel="cancelfun"/>
					  </van-popup>
					
					  <div class="fixbottom">
					    <div class="addbtn" @click="saveadd()">
					      保存
					    </div>
					  </div>
					</div>
					<script>
						var Vindex=new Vue({
						  el: '#wrap',
						  data: {
						    logintoken:'',
						    username:'',
						    usertel:'',
						    area: '',
						    areaarr: [],
						    useraddress:'',
						    show_area: false,
						    areaList: area_data,
						    address:{
						      name:'MISTERAYQU',
						      mobile:'183****0000',
						      province:'aaaa1',
						      city:'aaaa2',
						      county:'aaaa3',
						      address:'aaaa4',
						    },
						    addresslist:[
						      {default_add:0},
						      {default_add:1},
						      {default_add:0},
						      {default_add:0},
						    ],
						    type:0,
						    
						    paykg:true,
						    isLoading:false,
						    val1:'',
						    skip:1
						  },
						  created: function () {
						    // `this` 指向 vm 实例
						  },
						  mounted () {
						    // this.scroll(this.film);
						   // this.countpri()
						  },
						  methods:{
						    sel_area() {
						      this.show_area = true;
						    },
						    cancelfun(){
						      this.show_area = false;
						    },
						    conf(res) {
						      // alert( JSON.stringify( res ) )
						      this.show_area = false;
						      var area1=''
						      this.areaarr=['','','']
						      for(var i in res){
						        area1 +=res[i].name
						        if(res[i]&&res[i]!=null){
						          this.areaarr[i]=res[i].name
						        }
						        
						      }
						      this.area = area1
						    },
						    
						  }
						})
						function saveadd(){
							let name = $('#name').val();
							let phone =$('#phone').val();
							let address1 = $('#address1').val();
							let address2 = $('#address2').val();
						  if(name==''){
						    layer.msg("请输入收货人姓名")
						    return
						  }
						  if(phone=='' || !(/^1\d{10}$/.test(phone))){
						      layer.msg("手机号码有误")
						      return
						  }
						  if(address1==""){
						    layer.msg("请选择所在地区")
						    return
						  }
						  if(address2==''){
						    layer.msg("请输入收货人详细地址")
						    return
						  }
							$.ajax({
								type: "post",
								url: "<?php echo url('my_address/address_add'); ?>",
								data: {
									'name':name,
									'phone':phone,
									'address1':address1,
									'address2':address2,
								},
								success: function(res) {
									if(res.code===1){
										layer.msg(res.msg,function(){
										    history.go(-1);
										})
									}else{
										layer.msg(res.msg)
									}
								},
								error: function(err) {
									layer.msg('操作失败')
								}
							})
						}
					</script>
				</div>
			</div>
		</div>

		
		<!-- <script src="/static/index/js/zepto.js"></script>
		<script src="/static/index/js/sm.js"></script>
		<script src="/static/index/js/sm-extend.js"></script>
		<script src="/static/index/js/app.js?816390865"></script> -->
		
	</body>
</html>
