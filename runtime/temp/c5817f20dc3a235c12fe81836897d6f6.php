<?php /*a:3:{s:81:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\user\agency_client.html";i:1568783032;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\header.html";i:1568690356;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\footer.html";i:1567395903;}*/ ?>
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
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <!-- Panel Other -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>我的客户列表</h5>
        </div>
        <div class="ibox-content">
            <!--搜索框开始-->
            <!--搜索框结束-->
            <div class="hr-line-dashed"></div>
            <div class="example-wrap">
                <div class="example">
                    <table class="table table-bordered table-hover text-center" >
                        <thead>
                        <tr class="text-center">
                            <th width="10%">姓名</th>
                            <th width="10%">电话</th>
                            <th width="10%">生日</th>
                            <th width="10%">地址</th>
                            <th width="10%">购买时间</th>
                            <th width="10%">购买数量</th>
                        </tr>
                        </thead>
                        <tbody id="list-content">
                        <?php foreach($data as $v): ?>
                        <tr class="long-td">
                            <td><?php echo htmlentities($v['name']); ?></td>
                            <td><?php echo htmlentities($v['phone']); ?></td>
                            <td><?php echo $v['birthday']=='' ? '' : htmlentities(date('Y-m-d',!is_numeric($v['birthday'])? strtotime($v['birthday']) : $v['birthday'])); ?></td>
                            <td><?php echo htmlentities($v['address']); ?></td>
                            <td><?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($v['buy_time'])? strtotime($v['buy_time']) : $v['buy_time'])); ?></td>
                            <td><?php echo htmlentities($v['buy_num']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-danger" style="margin-top: 10px;float: right;margin-right: 5px;" href="javascript:history.go(-1);"> 返回</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 加载动画 -->


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

    // //编辑文章
    function edit(id){
        location.href = '/admin/user/jiesuan_edit/id/'+id+'.html';
    }
    // function exchange(id) {
    //     location.href = './exchange/id/' + id + '.html';
    // }
    // //删除文章
    function del(id){
        lunhui.confirm(id,'<?php echo url("jiesuan_destroy"); ?>');
    }
    // function show(title,url,id,w,h){
    //     var index = layer.open({
    //         type: 2,
    //         title: title,
    //         content: url
    //     });
    //     layer.full(index);
    // }

    // //文章状态
    // function status(id,cate) {
    //     if (cate === 1) {
    //         b = ['取消审核'];
    //         body = '确认取消审核？';
    //         status1 = 2;
    //     } else if (cate === 2) {
    //         b = ['通过'];
    //         body = '确认审核通过？';
    //         status1 = 1;
    //     } else {
    //         b = ['通过审核', '取消审核'];
    //         body = '请选择操作';
    //         status1 = 1;
    //         status2 = 2;
    //     }
    //     layer.open({
    //         type: 0,
    //         text: '发货',
    //         content: body,
    //         icon: 1,
    //         btn: b,
    //         yes: function () {
    //             lunhui.taxi_status(id, status1, cate, '<?php echo url("status"); ?>');
    //         },
    //         btn2: function () {
    //             lunhui.taxi_status(id, status2, cate, '<?php echo url("status"); ?>');
    //         },
    //     });
    // }
</script>

</body>
</html>