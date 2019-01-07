<!DOCTYPE html>
<html>
<head>
<meta name="renderer" content="webkit|ie-comp|ie-stand" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta charset="UTF-8">
<title>国彩管理后台</title>
<link rel="stylesheet" href="<?php echo WEB?>static/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB?>static/js/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB?>static/js/layout/themes/bootstrap/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB?>static/js/layout/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB?>static/css/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB?>static/css/core.css">
<script type="text/javascript" src="<?php echo WEB?>static/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo WEB?>static/js/core.js"></script>
<script>var WEB='<?php echo WEB?>';</script>
<script type="text/javascript" src="<?php echo WEB?>static/js/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo WEB?>static/js/layout/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo WEB?>static/js/layout/locale/easyui-lang-zh_CN.js"></script>
</head>
<body class="easyui-layout">
<center><br>
<textarea class="form-control" rows="3" name="name" style="width:96%"></textarea><br>	
<input type="button" id="aa" class="btn btn-primary" value="发送">
</center>
</body>
<script type="text/javascript">
	$('#aa').click(function(){
		$.post(WEB+'api/push',{name:$('[name=name]').val()},function(c){
			Core.ok('发送成功');
		});
	});
</script>
</html>