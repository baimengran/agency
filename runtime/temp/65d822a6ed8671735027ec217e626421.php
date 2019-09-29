<?php /*a:3:{s:75:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\config\index.html";i:1568178654;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\header.html";i:1568690356;s:76:"D:\phpstudy_pro\WWW\www.agency.com\application\admin\view\layout\footer.html";i:1567395903;}*/ ?>
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

<style type="text/css">
/* TAB */
.nav-tabs.nav>li>a {
    padding: 10px 25px;
    margin-right: 0;
}
.nav-tabs.nav>li>a:hover,
.nav-tabs.nav>li.active>a {
    border-top: 3px solid #1ab394;
    padding-top: 8px;
    border-bottom: 1px solid #FFFFFF;
}
.nav-tabs>li>a {
    color: #A7B1C2;
    font-weight: 500;  
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 0;
}
</style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>网站配置</h5>
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
                    <div class="panel blank-panel">
                        <div class="panel-heading">                     
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">基本配置</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <form action="<?php echo url('save'); ?>" method="post" id="site" class="form-horizontal">
                                        <div class="hr-line-dashed"></div>                                
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">网站标题：</label>
                                            <div class="input-group col-sm-4">                                              
                                                <input type="text" class="form-control" name="title" value="<?php echo !empty($site['title']) ? htmlentities($site['title']) : ''; ?>">
                                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 网站标题</span>                                           
                                            </div>
                                        </div>                                 
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">商城开关：</label>
                                            <div class="input-group col-sm-4">
                                                <div class=" i-checks">
                                                    <input type="radio" name='status' value="1" <?php if(!empty($site) AND $site['status']==1): ?>checked<?php endif; ?> />开启&nbsp;&nbsp;
                                                    <input type="radio" name='status' value="0" <?php if(empty($site)): ?>checked<?php elseif($site['status']==0): ?>checked<?php endif; ?>/>关闭
                                                </div>
                                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 关闭后普通用户将不能在商城购物</span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">优惠：</label>
                                            <div class="input-group col-sm-4">
                                                <input type="text" class="form-control" name="youhui" value="<?php echo !empty($site['youhui']) ? htmlentities($site['youhui']) : ''; ?>">
                                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 普通用户下单优惠</span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">运费：</label>
                                            <div class="input-group col-sm-4">
                                                <input type="text" class="form-control" name="yunfei" value="<?php echo !empty($site['yunfei']) ? htmlentities($site['yunfei']) : ''; ?>">
                                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 普通用户下单运费</span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">联系我们：</label>
                                            <div class="input-group col-sm-4">
                                                <input type="text" class="form-control" name="contact_us" value="<?php echo !empty($site['contact_us']) ? htmlentities($site['contact_us']) : ''; ?>">
                                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 联系方式</span>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-3">
                                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 保存信息</button>&nbsp;&nbsp;&nbsp;
                                                <a class="btn btn-danger" href="javascript:history.go(-1);"><i class="fa fa-close"></i> 返回</a>
                                            </div>
                                        </div>                               
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>         
                </div>
            </div>
        </div>
    </div>
</div>
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



<script type="text/javascript">
    $(function () {
        $('#site').ajaxForm({
            //beforeSubmit: checkForm, // 此方法主要是提交前执行的方法，根据需要设置
            success: complete, // 这是提交后的方法
            dataType: 'json'
        });

        function complete(data) {
            // console.log(11)
            if (data.code == 1) {
                layer.msg(data.msg, {icon: 6, time: 1500, shade: 0.1}, function (index) {
                    window.location.href = "<?php echo url('config/index'); ?>";
                });
            } else {
                layer.msg(data.msg, {icon: 5, time: 1500});
                return false;
            }
        }

    });
</script>
</body>
</html>
