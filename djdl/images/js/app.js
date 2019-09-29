var IPurp=''
$(function() {
	var cartData = [];//购物车初始化
	var buyLimit = 1;//下单限制初始化
	var totalNum;//购物车商品总数初始化
	var totalPrice;//购物车商品总金额初始化
	if (localStorage.cartData) {
		cartData = JSON.parse(localStorage.cartData);//获取历史购物车记录
	}
	cartUpdate();
	
	//添加到购物车
	function cartAdd(id,price,postment){
		var current = '{"id":' + id + ',"num":' + buyLimit + ',"price":"' + price + '","postment":' + postment + '}';
		cartData.push(JSON.parse(current));	
		cartUpdate();
	}
	
	//修改购物车数量
	function cartEdit(id,num){
		$.each(cartData,function(index, value) {
            if (value.id == id) {
				value.num = num;
                return
            }
        });		
		cartUpdate();
	}
	
	//从购物车删除
	function cartCancel(id){
		$.each(cartData,function(index, value) {
            if (value.id == id) {
                cartData.splice(index, 1);
                return
            }
        });	
		if (cartData.length == 0) {
			$('#cart .content-block').show();
			$('#cart .content-inner').hide();
		}
		cartUpdate();
	}
	
	//更新购物车
	function cartUpdate() {
		localStorage.cartData = JSON.stringify(cartData);
		totalNum = 0;
		totalPrice = 0;
		$.each(cartData,function(index, value) {
			totalNum += parseInt(value.num);
			totalPrice += parseFloat(value.price) * value.num
		});
		totalPrice = parseFloat(totalPrice.toFixed(2));
		$("#cart-tip").show();
		$("#cart-tip").html(totalNum);
		if (totalNum == 0) {
			$("#cart-tip").hide()
		};
		$(".cart-total").html(totalPrice);
	}
	
	//选择当前导航
	function navSelect(){
		var obj = window.location.pathname;
		$('.bar-footer').find("a[href='"+obj+"']").addClass('active');
	}
	
	//初始化首页
	$(document).on("pageInit", "#home",function(e, pageId, $page) {//获取产品列表
		navSelect();
		$('.bar-footer').find("a[href='/shop']").addClass('active');
		$.ajax({
			type: "post",
			url: "/Api/getProduct",
			success: function(data) {
				if (data) {
					if(data.type == 0){
						buyLimit = 10;
						hot = eval(data.hot);
						var html = "";
						$.each(hot,function(index, value) {
							html += '<div class="card"><div class="card-content"><div class="card-content-inner"><img src= '+value.image +'></div></div><div class="card-footer">'+value.name + value.unititem +'<i class="price">￥'+value.price +'元</i> <a href="javascript:void(0);" class="button button-fill button-success add-cart" data-id='+value.id+' data-postment='+value.postment+' data-price="'+value.price+'">加入购物车</a> </div></div>';
							});
						$("#hotlist").html(html);
					}else{
						//这里对普通客户做出特别提示
						hot = eval(data.hot);
						var html = "";
						$.each(hot,function(index, value) {
							html += '<div class="card"><div class="card-content"><div class="card-content-inner"><img src= '+value.image +'></div></div><div class="card-footer">'+value.name + value.unititem +'<i class="price">￥'+value.price +'元</i> </div></div>';
							});
						$("#hotlist").html(html);
					}
					list = eval(data.list);
					var newhtml = "";
					$.each(list,function(index, value) {
						newhtml += '<li class="item-content"><div class="item-media"><img src='+value.image +'></div><div class="item-inner"><div class="item-subtitle product-title">'+value.name + value.unititem +'</div><div class="item-subtitle product-desc">'+value.detail +'</div><div class="item-subtitle cart"> <i class="price">￥'+value.price +'元</i> <a href="javascript:void(0);" class="button button-fill button-success add-cart" data-id='+value.id+' data-postment='+value.postment+' data-price="'+value.price+'">加入购物车</a> </div></div></li>'
					});
					$("#productlist").html(newhtml);	
				}
			},
			beforeSend: function() {
				$.showIndicator();
			},
			complete: function() {
				$.hideIndicator();
				$(".add-cart").bind("click",function(e){
					if($(this).hasClass('button-success')){
						$(this).removeClass('button-success').addClass('button-danger').text('取出购物车');
						cartAdd($(this).data('id'),$(this).data('price'),$(this).data('postment'));
					}else{
						$(this).removeClass('button-danger').addClass('button-success').text('加入购物车');
						cartCancel($(this).data('id'));
					}	
				});
				$.each(cartData,function(index, value) {
					$(".content-inner").find('a[data-id="' + value.id + '"]').removeClass('button-success').addClass('button-danger').text('取出购物车');
				});
			}
		});
		
	});
	//购物车初始化
	/*$(document).on("pageInit", "#cart",function(e, pageId, $page) {
		navSelect();
		if (cartData.length == 0) {
			cartUpdate();
			$('#cart .content-block').show();
			$('#cart .content-inner').hide();
		} else {
			$.ajax({
				type: "post",
				url: "/Api/getPrice",
				data: {data:cartData},
				success: function(data) {
					if(data.type == 0){
						buyLimit = 10;
					}
					if(data.list){
						cartData = data.list;
						localStorage.cartData = JSON.stringify(cartData);
						cartUpdate();
						var html = "";
						$.each(cartData,function(index, value) {
							html += '<li class="item-content"><div class="item-media"><img src="'+value.image+'"></div><div class="item-inner"><div class="item-title"><span class="cart-title">' + value.name + value.unititem + '</span><span class="cart-price">' + value.price + '元x</span><span class="cart-number">' + value.num + '</span></div><div class="item-after"><input class="cart-picker" type="text" value="' + value.num + '" data-id=' + value.id + '><a href="javascript:void(0);" class="button button-fill button-danger cart-delete" data-id='+value.id+'>删除</a></div></div></li>';
						});
						$("#cart ul").html(html);
					}
				},
				complete: function() {
					$('#cart .content-block').hide();
					$('#cart .content-inner').show();
					var cart_number = [1]
					for (i = 0; i <= 100 - buyLimit; i++) {
						cart_number[i] = i + buyLimit;
					}
					$(".cart-picker").picker({
						cols: [{
							textAlign: 'center',
							values: cart_number,
						}],
						onClose: function(o) {
							o.input.parent().parent().find('.cart-number').html(o.value[0]);
							cartEdit(o.input.data('id'),o.value[0]);
						}
					});
					//删除购物车商品
					$('.cart-delete').bind('click',function(e) {
						var id = $(this).data('id');
						var obj = $(this);
						$(".cart-picker").picker("close");
						var delete_this = [{
							text: '确定删除',
							bold: true,
							bg: 'danger',
							onClick: function() {
								obj.parent().parent().parent().empty().hide();
								cartCancel(id);
							}
						}];
						var cancle = [{
							text: '取消',
						}];
						var groups = [delete_this, cancle];
						$.actions(groups);
					});
				}
			});
		}
		
		//购物车下一步
		$('.cart-submit').bind('click',function(e) {
			$(".cart-picker").picker("close");
			$.router.load('/submit', true)
		});
		
	});*/

	$(document).on("pageInit", "#submit",function(e, pageId, $page) {
		if (cartData.length == 0) {
			$.router.load('/index',true);//防止js出错导致页面被调用
			return;
		};
		navSelect();
		var payment;//支付方式初始化
		var send_ment = 0;//默认配送方式为快递
		var send_price = 0;//默认单件配送价格
		var total_send_price = 0;//默认总配送价格
		var total_price;//提交总价初始化 = 运费+订单价格
		var postment = 1;//初始化包邮设置,默认包邮
		var area = '';//初始化包邮设置,默认包邮
		//先查询购物车中是否有非包邮产品
		$.each(cartData,function(index, value) {
			if (value.postment == 0) {
				postment = 0;
			}
		});
		$.ajax({
			type: "post",
			url: "/Api/getContact",
			success: function(data){
				if(data){
					$("input[name='name']").val(data.name);
					$("input[name='phone']").val(data.phone);
					$("input[name='city']").val(data.city);
					$("textarea[name='address']").val(data.address);
					area = data.area;
				}
			},
			error: function(){
				initSend();
			},
			beforeSend: function(){
				//cartUpdate();
			},
			complete:function(){
				initSend();
			},
		});
		
		function initSend() {
			if(postment == 0){//不包邮开始计算邮费
				$("#send_ment").show();
				if (send_ment == 0) {//快递 获取价格
					$("input[name='send_ment']").prop('checked', false);
					$.ajax({
						type: 'post',
						url: '/Api/getSendprice',
						data: { area:area },
						success: function(data){
							send_price = parseFloat(data);//返回浮点数
							dispalySend();
						},
						error: function(){
							send_price = 200;//防止出错,设置单件运费200元
							dispalySend();
						}
					})
				} else {
					//物流,不获取价格
					$("input[name='send_ment']").prop('checked', true);
					send_price = 0;
					dispalySend();
				}
			}else{
				//包邮直接渲染页面
				dispalySend();
			}			
		};
		
		//渲染显示页面
		function dispalySend() {
			total_send_price = 0;
			$.each(cartData,function(index, value) {
				if (value.postment == 0) {
					total_send_price += value.num * send_price;
				}
			});
			$(".send_price").html(total_send_price); //显示运费
			$(".order_price").html(totalPrice); //显示订单金额
			total_price = totalPrice + parseFloat(total_send_price);//计算合计金额
			$(".total_price").html(total_price); //显示合计金额
		};

		//城市选择器
		$("input[name='city']").cityPicker({
			onClose: function(o) {
				area = o.value[0];
				initSend();
			}
		});
		//快递与物流的转化
		$("input[name='send_ment']").on('change',function(e) {
			if ($(this).is(":checked")) {
				send_ment = 1;
				$(this).val(1);
			} else {
				send_ment = 0;
				$(this).val(0);
			}
			initSend();
		});
		
		//订单检测
		function checkSubmit() {
			name = $("input[name='name']").val();
			phone = $("input[name='phone']").val();
			city = $("input[name='city']").val();
			address = $("textarea[name='address']").val();
			if(!total_price){
				$.alert('页面错误,请返回上级页面');
				return false;
			}			
			if (!area) {
				$.alert('请填写完整');
				return false;
			}
			if (!area) {
				$.alert('请填写完整');
				return false;
			}
			if (name.length == 0 || phone.length == 0 || city.length == 0 || area.length == 0 || address.length == 0) {
				$.alert('请填写完整');
				return false;
			}
			if (phone.length != 11) {
				$.alert('请填写11位手机号码，不要带空格和其他字符!');
				return false;
			}
			if (address.length < 10) {
				$.alert('请填写详细地址!');
				return false;
			}
		};
		
		//订单提交
		function orderSubmit() {
			$.ajax({
				type: "post",
				url: "/Api/addOrder",
				data: {
					name: name,
					phone: phone,
					area: area,
					city: city,
					address: address,
					send_ment: send_ment,
					sendprice: total_send_price,
					totalprice: total_price,
					payment: payment,
					cartData: cartData,
				},
				success: function(data) {
					if (data) {
						localStorage.orderInfo = JSON.stringify(data.orderinfo);
						$.router.load(data.url);
					}
				},
				beforeSend: function() {
					$.showIndicator();
				},
				complete: function() {
					//清空购物车
					cartData = [];
					cartUpdate();
					$.hideIndicator();
				}
			})
		};
		
		//选择付款方式
		$('#submit').on('click', '.order-submit',function() {
			if (checkSubmit() != false) {
				var obj = $(this);
				var buttons1 = [{
					text: '请选择支付方式',
					label: true
				},
				{

					text: '银行/网银转账',
					bold: true,
					color: 'danger',
					onClick: function() {
						payment = 0;
						orderSubmit();
					}
				},
				{
					text: '微信支付',
					onClick: function() {
						payment = 1;
						orderSubmit();
					}
				}];
				var buttons2 = [{
					text: '取消',
					bg: 'danger'
				}];
				var groups = [buttons1, buttons2];
				$.actions(groups);
			}
		});

	});
	
	//订单提交成功
	$(document).on("pageInit", "#success",function(e, pageId, $page) {
		if(localStorage.orderInfo){
			var orderInfo = JSON.parse(localStorage.orderInfo);
			localStorage.orderInfo = '';
			$('.order_id').text(orderInfo.orderid);
			$('.order_time').text(orderInfo.time);
			$('.order_money').text(orderInfo.totalprice);
			$('.order_sendment').text(orderInfo.send_ment);
			if(orderInfo.payment == 1){
				$('.order_payment').text('微信支付');
			}else{
				$('.order_payment').text('银行/网银转账');
				$('.bankinfo').show();
			}
			if(orderInfo.send_ment == 1){
				$('.order_sendment').text('物流到付');
			}else{
				$('.order_sendment').text('快递');
				if(parseFloat(orderInfo.send_price)){
					$('.order_sendprice').show();
					$('.order_sendprice span').text(orderInfo.send_price);
				}	
			}
			var html = '';
			$.each(eval(orderInfo.detail),function(index, value) {
				html += '<tr><td>'+value.name+'</td><td>'+value.num+'</td><td>'+value.price*value.num+'</td></tr>'
			});
			$("table tbody").html(html);
			$('.bar-footer').find("a[href='/order']").addClass('active');
		}else{
			$.router.load('/order',true);
		}
	});
	
	//订单中心初始化
	$(document).on("pageInit", "#order",function(e, pageId, $page) {
		navSelect();		
		$('.item-link').bind('click',function(e) {
			$.router.load('/Index/orderinfo?id='+$(this).data('id'), true)
		});
	});
	
	//订单详情初始化
	$(document).on("pageInit", "#orderinfo",function(e, pageId, $page) {
		
		$('.cancleOrder').bind('click',function(e) {
			var id = $(this).data('id');
			$.confirm('确定取消订单?', function () {
				$.ajax({
					type: "post",
					url: "/Api/cancleOrder",
					data: {
						id: id,
					},
					success: function(data) {
						$.alert(data.info, function () {
							$.router.load('/order',true);
						});
					},
					error: function(data) {
						$.router.load('/order',true);
					}
				})	
			});
		});	
	});
	
	//我的信息界面
	$(document).on("pageInit", "#my",function(e, pageId, $page) {
		navSelect();
	});
	
	//收货地址
	$(document).on("pageInit", "#myinfo",function(e, pageId, $page) {
		$.ajax({
			type: "post",
			url: "/Api/getContact",
			success: function(data){
				if(data){
					$("#name").text(data.name);
					$("#phone").text(data.phone);
					$("#area").text(data.area);
					$("#address").text(data.address);
				}else{
					// $.alert('请补全收货地址<br>收货信息可在提交订单时填写', function () {
					// 	$.router.back();
					// });
				}
			},
			error: function(){
				// $.router.back();
			}
		});		
	});
	
	//我要代理界面
	$(document).on("pageInit", "#joinus",function(e, pageId, $page) {
		//检测代理申请状态
		$.ajax({
			type: "post",
			url: "/Api/checkAuth",
			success: function(data){
				if(!data.status){
					$('.content').empty().html('<div class="content-block"><p>'+data.info+'</p></div>');
				}
			},
			error: function(){
				// $.router.back();
			},
			beforeSend: function() {
				$.showIndicator();
			},
			complete: function() {
				$.hideIndicator();
				$('.content').show();
			}
		});
		
		//提交代理申请
		$('#joinus').on('click', '.auth-submit',function() {
			$.ajax({
				type: "post",
				url: "/Api/submitAuth",
				data: {
					realname: $("input[name='realname']").val(),
					idcard: $("input[name='idcard']").val(),
					nickname: $("input[name='nickname']").val(),
					wx_number: $("input[name='wx_number']").val(),
					mobile: $("input[name='mobile']").val(),
					pid: $("input[name='pid']").val(),
				},
				success: function(data) {
					if(data.status){
						$.alert(data.info, function () {
							//$.router.back();
							$.router.load('/my', true)
						});
					}else{
						$.alert(data.info);
					}
				},
				error: function() {
					$.router.back();
				},
				beforeSend: function() {
					$.showIndicator();
				},
				complete: function() {
					$.hideIndicator();
				}
			})	
		});
					
	});
	
	//代理信息
	$(document).on("pageInit", "#moreinfo",function(e, pageId, $page) {
		$.ajax({
			type: "post",
			url: "/Api/moreInfo",
			success: function(data){
				if(data.status){
					$('#contract_id').html(data.contract_id);
					$('#level').html(data.level);
					$('#realname').html(data.realname);
					$('#idcard').html(data.idcard);
					$('#nickname').html(data.nickname);
					$('#wx_number').html(data.wx_number);
					$('#mobile').html(data.mobile);
					$('#id').html(data.id);
				}else{
					$.router.back();
				}
			},
			error: function(){
				$.router.back();
			},
			beforeSend: function() {
				$.showIndicator();
			},
			complete: function() {
				$.hideIndicator();
			}
		});
	});
	
	//检测代理真伪
	$(document).on("pageInit", "#checkauth",function(e, pageId, $page) {	
		$('#checkauth').on('click', '.auth-check',function() {
			var type = $("select[name='type'] option").not(function(){ return !this.selected }).val();
			var txt = $('input[name="value"]').val();
			if(!txt){
				$('input[name="value"]').focus();
				return;
			}
			$.ajax({
				type: "post",
				url: "/Api/searchAuth",
				data: {
					type:type,
					txt:txt
				},
				success: function(data) {
					if(data.status){
						$.photoBrowser({photos:[data.info,]}).open();
					}else{
						$.alert(data.info);
					}
				},
				error: function() {
					$.router.back();
				},
				beforeSend: function() {
					$.showIndicator();
				},
				complete: function() {
					$.hideIndicator();
				}
			})	
		});
				
	});


	//最后一步加载
	$.init();
});

function getpri(){
	
}