<?php /*a:3:{s:72:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\user\edit.html";i:1569555176;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\header.html";i:1568690356;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\footer.html";i:1567395903;}*/ ?>
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

<link href="/static/admin/js/plugins/webuploader/webuploader.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>编辑用户</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" name="userEdit" id="userEdit" method="post" action="<?php echo url('update'); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlentities($data['id']); ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">代理级别：</label>
                            <div class="input-group col-sm-4">
                                <select class="form-control" name="agency_id">
                                    <option value="0">取消代理</option>
                                    <?php foreach($agency as $v): ?>
                                    <option value="<?php echo htmlentities($v['id']); ?>" <?php echo $v['id']==$data['agency_id'] ? 'selected' : ''; ?>><?php echo htmlentities($v['title']); ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手机号：</label>
                            <div class="input-group col-sm-4">
                                <input id="price" type="text" class="form-control" name="phone" required="" aria-required="true" value="<?php echo !empty($data) ? htmlentities($data['phone']) : ''; ?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 保存</button>&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-danger" href="javascript:history.go(-1);"><i class="fa fa-close"></i> 返回</a>
                            </div>
                        </div>
                    </form>
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


<script type="text/javascript" src="/static/admin/js/plugins/webuploader/webuploader.min.js"></script>

<script type="text/javascript">

    //提交
    $(function(){
        $('#userEdit').ajaxForm({
            beforeSubmit: checkForm,
            success: complete,
            dataType: 'json'
        });

        function checkForm(){

        }


        function complete(data){
            if(data.code==1){
                layer.msg(data.msg, {icon: 6,time:1500,shade: 0.1}, function(index){
                    window.location.href="<?php echo url('user/index'); ?>";
                });
            }else{
                layer.msg(data.msg, {icon: 5,time:1500,shade: 0.1});
                return false;
            }
        }

    });
</script>
</html>