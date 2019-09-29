<?php /*a:3:{s:72:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\user\show.html";i:1568776850;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\header.html";i:1568690356;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\footer.html";i:1567395903;}*/ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name=”renderer” content=”webkit|ie-stand|ie-comp” />
<meta name="force-rendering" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>后台管理系统</title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="shortcut icon" href="<?php echo url('/public/favicon.ico','',''); ?>">
<link href="/static/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
<link href="/static/admin/css/animate.min.css" rel="stylesheet">
<link href="/static/admin/css/style.min.css" rel="stylesheet">
<!--[if lt IE 9]>
<meta http-equiv="refresh" content="0;ie.html" />
<![endif]-->
<script>
    // if(window.top!==window.self){window.top.location=window.location};
</script>

</head>
<body>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">最后更新：<i class="fa fa-clock-o"></i> <?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($user['update_time'])? strtotime($user['update_time']) : $user['update_time'])); ?></span>
                    <h2 class="label label-primary" style="height: 50px;width:90px">用户管理</h2>

                    <hr>
                    <div class="clients-list">
                        <ul class="nav nav-tabs">
                            <span class="pull-right small text-muted"><?php echo htmlentities($total); ?> 个产品</span>
                            <li class="active"><a data-toggle="tab" href="#tab-2" aria-expanded="true"><i
                                    class="fa fa-briefcase"></i> 代理产品</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-2" class="tab-pane active">
                                <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
                                    <div class="full-height-scroll" style="width: auto; ">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <tbody class="tbody product">
                                                <?php foreach($product as $val): ?>
                                                <tr>
                                                    <td><a data-toggle="tab" href="" class="client-link"
                                                           aria-expanded="false"><?php echo htmlentities($val['product']['title']); ?></a>
                                                    </td>
                                                    <td><?php echo htmlentities($val['num']); ?> 件/箱</td>
                                                    <td><img alt="image" width="50px" class="img-circle" src="<?php echo htmlentities($val['product']['pic']); ?>"></td>
                                                    <td class="client-status"><?php echo htmlentities($val['create_time']); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <div id="product" style="text-align:right;"><?php echo $page2; ?></div>
                                        </div>
                                    </div>
                                    <div class="slimScrollBar"
                                         style="background: rgb(0, 0, 0); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 365.112px;"></div>
                                    <div class="slimScrollRail"
                                         style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tab-content">
                        <div id="contact-1" class="tab-pane active">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <h2><?php echo htmlentities($user['real_name']); ?></h2>

                                    <div class="m-b-sm">
                                        <img alt="image" class="img-circle" src="<?php echo htmlentities($user['avatar']); ?>" style="width: 62px">
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-8">
                                    <div style="font-size: 20px;float: left;" class="label label-primary"><i
                                            class="fa fa-mobile-phone"></i> 手机号
                                    </div>
                                    <div style="font-size: 20px;float:right;" class="label label-primary"><i
                                            class="fa fa-mobile-phone"></i> 微信号
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="col-lg-8">
                                    <div style="float:left;padding-top:10px"><h3><?php echo htmlentities($user['phone']); ?></h3></div>

                                    <div style="float:right;padding-top:10px"><h3><?php echo htmlentities($user['wechatid']); ?></h3></div>
                                    <div style="clear:both"></div>
                                </div>
                                <hr>
                            </div>
                            <div class="client-detail">
                                <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
                                    <div class="full-height-scroll" style="width: auto; height: 100%;">
                                        <strong>其他信息</strong>
                                        <ul class="list-group clear-list">
                                            <li class="list-group-item fist-item">
                                                <span class="pull-right"> <?php echo htmlentities($user['nickname']); ?></span> 昵称
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> <?php echo htmlentities($user['agency']['title']); ?> </span> 代理级别
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> <?php if($user['status']==0): ?>审核中<?php elseif($user['status']==1): ?>已通过<?php else: ?>未通过<?php endif; ?> </span>
                                                审核状态
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> <?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($user['status_time'])? strtotime($user['status_time']) : $user['status_time'])); ?> </span>
                                                审核时间
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> <?php echo htmlentities($user['province']); ?> </span> 省份
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> <?php echo htmlentities($user['city']); ?> </span> 城市
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"> <?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($user['create_time'])? strtotime($user['create_time']) : $user['create_time'])); ?> </span>
                                                注册日期
                                            </li>
                                        </ul>
                                        <strong>备注</strong>
                                        <!--<p>-->
                                            <!--40亿影帝黄渤先生明明可以靠脸吃饭，可是他却偏偏靠才华，唱歌居然也这么好听！-->
                                        <!--</p>-->
                                        <hr>

                                    </div>
                                    <div class="slimScrollBar"
                                         style="background: rgb(0, 0, 0); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 356.256px;"></div>
                                    <div class="slimScrollRail"
                                         style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/static/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/static/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/static/admin/js/plugins/layer/layer.min.js"></script>
<script src="/static/admin/js/hplus.min.js?v=4.1.0"></script>
<script type="text/javascript" src="/static/admin/js/contabs.min.js"></script>
<script src="/static/admin/js/plugins/pace/pace.min.js"></script>
<script src="/static/admin/js/jquery.form.js"></script>
<script src="/static/admin/js/lunhui.js"></script>


<script>
    function show(title,url,id,w,h){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    $('#product .pagination').delegate('a','click',function(){
        var url = $(this).attr('href')+'&id='+<?php echo htmlentities($user['id']); ?>+'&product=1'; //将要访问的地址
        console.log(url)
        $.ajax({
            url:url,
            success:function(res){
                page1(res); //page方法用于替换数据
            }
        })
        return false; //阻止a标签默认跳转的行为
    });
    function page1(res){
        html = ''; //准备一个容器
        $('#product .pagination').html(res.page2); //请求到后台的数据，替换之前分页按钮
        delete res.page2;//删除之前返回的分页按钮 说一下为什么要删除这个吧.因为返回的json中,page也是其中的一个下标，也会进入for循环中，所以要提前删掉，不然会出现undefined的情况。
        delete res.code;//删除之前后台返回的状态码
        for(var k in res){
            //这里是拼接html标签
            html+='<tr>\n' +
                '<td><a data-toggle="tab" href="#company-1" class="client-link"\n' +
                'aria-expanded="false">'+res[k].product.title+'</a>\n' +
                '</td>\n' +
                '<td>'+res[k].num+' 件</td>\n' +
                '<td><img alt="image" width="46px" class="img-circle" src="'+res[k].product.pic+'"></td>\n' +
                '<td class="client-status">'+res[k].create_time+'</td>\n' +
                '</tr>';
            // tr+='<tr><td>'+res[k].username+'</td><td>'+res[k].realname+'</td><td>'+res[k].role_name+'</td><td>'+res[k].last_login_time+'</td><td>'+res[k].seller_hotel_name+'</td></tr>';
        }
        $('.product').html(html);//把数据覆盖到所需要填充数据的地方
    }

    $('#AjaxPage .pagination').delegate('a','click',function(){
        var url = $(this).attr('href')+'&id='+<?php echo htmlentities($user['id']); ?>; //将要访问的地址
        console.log(url)
        $.ajax({
            url:url,
            success:function(res){
                page(res); //page方法用于替换数据
            }
        })
        return false; //阻止a标签默认跳转的行为
    });
    function page(res){
        html = ''; //准备一个容器
        $('#AjaxPage .pagination').html(res.page1); //请求到后台的数据，替换之前分页按钮
        delete res.page1;//删除之前返回的分页按钮 说一下为什么要删除这个吧.因为返回的json中,page也是其中的一个下标，也会进入for循环中，所以要提前删掉，不然会出现undefined的情况。
        delete res.code;//删除之前后台返回的状态码
        for(var k in res){
            //这里是拼接html标签
            html+='<tr>'+
                '<td><a data-toggle="tab" href="" class="client-link"'+
            'aria-expanded="false">'+res[k].real_name+'</a>'+
            '</td>'+
            '<td>'+res[k].agency.title+'</td>'+
            '<td><img alt="image" width="50px" class="img-circle" src="'+res[k].avatar+'"></td>'+
                '<td>'+res[k].province+'·'+res[k].city+'</td>'+
            '<td class="client-status">'+res[k].create_time+'</td>'+
            '</tr>'
           // tr+='<tr><td>'+res[k].username+'</td><td>'+res[k].realname+'</td><td>'+res[k].role_name+'</td><td>'+res[k].last_login_time+'</td><td>'+res[k].seller_hotel_name+'</td></tr>';
        }
        $('.user').html(html);//把数据覆盖到所需要填充数据的地方
    }
</script>
</html>