<?php /*a:3:{s:80:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\user\agency_index.html";i:1569555144;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\header.html";i:1568690356;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\footer.html";i:1567395903;}*/ ?>
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
            <h5>用户列表</h5>
        </div>
        <div class="ibox-content">
            <!--搜索框开始-->
            <div class="row">
                <div class="col-sm-12">
                    <form name="admin_list_sea" class="form-search" method="post" action="<?php echo url('index'); ?>">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" id="key" class="form-control" name="key" value="<?php echo htmlentities($val); ?>"
                                       placeholder="输入需查询的用户昵称或真实姓名名称"/>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-search"></i> 搜索</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--搜索框结束-->
            <div class="hr-line-dashed"></div>
            <div class="example-wrap">
                <div class="example">
                    <table class="table table-bordered table-hover text-center" >
                        <thead>
                        <tr class="text-center">
                            <th width="10%">昵称</th>
                            <th width="10%">真实姓名</th>
                            <th width="10%">电话</th>
                            <th width="10%">代理级别</th>
                            <th width="10%">头像</th>
                            <th width="10%">代理审核</th>
                            <th width="20%">操作</th>
                        </tr>
                        </thead>

                        <script id="list-template" type="text/html">

                        </script>
                        <tbody id="list-content">
                        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <tr class="long-td">
                            <td><?php echo htmlentities($v['nickname']); ?></td>
                            <td><?php echo htmlentities($v['real_name']); ?></td>
                            <td><?php echo htmlentities($v['phone']); ?></td>
                            <td><?php echo htmlentities($v['agency']['title']); ?></td>
                            <td>
                                <!--<a href="" class="pull-left">-->
                                    <img alt="image" width="50px" class="img-circle" src="<?php echo htmlentities($v['avatar']); ?>">
                                <!--</a>-->
                            </td>
                            <td>
                                <?php if($v['status']==1): ?>
                                <a href="javascript:;">
                                    <div id="zd<?php echo htmlentities($v['id']); ?>"><span class="label label-info">已审核</span></div>
                                </a>
                                <?php elseif($v['status']==0): if($v['pid']!=0): ?>
                                <a href="javascript:;" onclick="status(<?php echo htmlentities($v['id']); ?>,<?php echo htmlentities($v['status']); ?>);">
                                    <div id="zd<?php echo htmlentities($v['id']); ?>"><span class="label label-danger">待上级代理审核</span></div>
                                </a>
                                <?php else: ?>
                                <a href="javascript:;" onclick="status(<?php echo htmlentities($v['id']); ?>,2);">
                                    <div id="zd<?php echo htmlentities($v['id']); ?>"><span class="label label-danger">待审核</span></div>
                                </a>
                                <?php endif; elseif($v['status']==2): ?>
                                <a href="javascript:;" onclick="status(<?php echo htmlentities($v['id']); ?>,<?php echo htmlentities($v['status']); ?>);">
                                    <div id="zd<?php echo htmlentities($v['id']); ?>"><span class="label label-warning">上级代理已审核,待总部审核</span></div>
                                </a>
                                <?php else: ?>
                                <a href="javascript:;">
                                    <div id="zd<?php echo htmlentities($v['id']); ?>"><span class="label label-default">已取消</span></div>
                                </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="javascript:;" onclick="show('<?php echo htmlentities($v['nickname']); ?>','show?id=<?php echo htmlentities($v->id); ?>',)" class="btn btn-primary btn-xs btn-outline">
                                    <i class="fa fa-paste"></i> 详情</a>&nbsp;
                                <a href="javascript:;" onclick="client(<?php echo htmlentities($v['id']); ?>)" class="btn btn-primary btn-xs btn-outline">
                                    <i class="fa fa-paste"></i> 查看客户</a>&nbsp;
                                <a href="javascript:;" onclick="xiaji(<?php echo htmlentities($v['id']); ?>)" class="btn btn-primary btn-xs btn-outline">
                                    <i class="fa fa-paste"></i> 查看下级代理</a>&nbsp;
                                <a href="javascript:;" onclick="edit(<?php echo htmlentities($v['id']); ?>)" class="btn btn-primary btn-xs btn-outline">
                                    <i class="fa fa-paste"></i> 编辑</a>&nbsp;
                                <a href="javascript:;" onclick="exchange(<?php echo htmlentities($v['id']); ?>)" class="btn btn-primary btn-xs btn-outline">
                                    <i class="fa fa-paste"></i> 调货</a>&nbsp;
                                <a href="javascript:;" onclick="jiesuan(<?php echo htmlentities($v['id']); ?>)" class="btn btn-primary btn-xs btn-outline">
                                    <i class="fa fa-paste"></i> 结算</a>&nbsp;
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                        </tbody>
                    </table>
                    <div id="AjaxPage" style="text-align:right;"><?php echo $data; ?></div>

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

    //编辑文章
    function edit(id){
        location.href = './edit/id/'+id+'.html';
    }

    function client(id){
        location.href="./client_index/id/"+id+'.html';
    }

    function xiaji(id){
        location.href="./xiaji_index/id/"+id+".html";
    }

    function jiesuan(id){
        location.href="./jiesuan/id/"+id;
    }
    function exchange(id) {
        location.href = './exchange/id/' + id + '.html';
    }
    //删除文章
    function del(id){
        lunhui.confirm(id,'<?php echo url("destroy"); ?>');
    }
    function show(title,url,id,w,h){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    //文章状态
    function status(id,cate) {
        if (cate === 1) {
            b = ['取消审核'];
            body = '确认取消审核？';
            status1 = 2;
        } else if (cate === 2) {
            b = ['通过'];
            body = '确认审核通过？';
            status1 = 1;
        } else if(cate===0) {
            b = ['通过'];
            body = '直属上级还没审核，是否后台强制审核';
            status1 = 1;
        }
        layer.open({
            type: 0,
            text: '发货',
            content: body,
            icon: 3,
            btn: b,
            yes: function () {
                lunhui.taxi_status(id, status1, cate, '<?php echo url("status"); ?>');
            },
            btn2: function () {
                lunhui.taxi_status(id, status2, cate, '<?php echo url("status"); ?>');
            },
        });
    }
</script>

</body>
</html>