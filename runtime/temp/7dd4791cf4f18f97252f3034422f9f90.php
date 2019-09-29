<?php /*a:3:{s:80:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\user\agency_xiaji.html";i:1568779093;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\header.html";i:1568690356;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\footer.html";i:1567395903;}*/ ?>
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
            <h5>下级代理列表</h5>
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
                            <th>姓名</th>
                            <th>微信号</th>
                            <th>电话</th>
                            <th>级别</th>
                            <th>状态</th>
                            <th>审核日期</th>
                        </tr>
                        </thead>
                        <tbody id="list-content">
                        <?php foreach($data as $v): ?>
                        <tr class="long-td">
                            <td style="text-align: left"><a href="javascript:void(0)" onclick="xiaji(<?php echo htmlentities($v['id']); ?>)"><?php echo htmlentities($v['name']); ?></a></td>
                            <td><?php echo htmlentities($v['wechatid']); ?></td>
                            <td><?php echo htmlentities($v['phone']); ?></td>
                            <td><?php echo htmlentities($v['agency']); ?></td>
                            <td><?php echo htmlentities($v['status']); ?></td>
                            <td><?php echo $v['status_time']==0 ? '' : htmlentities(date('Y-m-d H:i:s',!is_numeric($v['status_time'])? strtotime($v['status_time']) : $v['status_time'])); ?></td>
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
    function xiaji(id){
        location.href="./xiaji_index/id/"+id+".html";
    }
</script>

</body>
</html>