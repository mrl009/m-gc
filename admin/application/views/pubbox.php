<!DOCTYPE html>
<html>
<head>
    <meta name="renderer" content="webkit|ie-comp|ie-stand" />
    <meta charset="UTF-8">
    <title><?php echo $name?></title>
    <link rel="stylesheet" href="/static/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" type="text/css" href="/static/js/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/static/js/layout/themes/bootstrap/easyui.css">
    <link rel="stylesheet" type="text/css" href="/static/js/layout/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/static/css/buttons.css">
    <link rel="stylesheet" type="text/css" href="/static/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/static/css/core.css">
    <link rel="stylesheet" type="text/css" href="/static/css/themes/red.css" id="colorIn">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script>
    var WEB = '<?php echo WEB?>';
    var MQ_HOST = '<?php echo MQ_HOST?>';
    var MQ_PORT = '<?php echo MQ_PORT?>';
    var USERNAME = '<?php echo $this->session->userdata('admin_name')?>';
    var SID = '<?php echo $this->session->userdata('sid')?>';
    </script>
    <script type="text/javascript" src="/static/js/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/js/layout/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/static/js/layout/locale/easyui-lang-zh_CN.js"></script>
    <script type="text/javascript" src="/static/js/core.js"></script>
    <style>
    .themes{padding:5px 10px 5px 5px;margin-left: 10px;}
    .zi{background: #5823CB;}
    .red{background: #F15757;}
    .huang{background: #FAAC3D;}
    .liu{background: #52B058;}
</style>
</head>
<body class="easyui-layout">
    <div data-options="region:'center',title:''" class="animated rotateInDownRight">
        <div id="task" class="easyui-tabs" data-options="fit:true,tools:[{iconCls:'icon-reload',handler:function(){Core.refresh();}},{iconCls:'icon-no',handler:function(){Core.exit();}}]">
            <div title="<?php echo $name?>" data-options="href:'/<?php echo $url?>',closable:false"></div>
            <!--welcome/start  stats/order-->
        </div>
    </div>
    
    <div id="in" style="display: none"></div>
    <div id="out" style="display: none"></div>
    
</body>
</html>
