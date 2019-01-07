<!doctype html>
<html>
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>全网通营销管理后台-移动版</title> 
	<link rel="stylesheet" href="static/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" type="text/css" href="static/js/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="static/js/layout/themes/bootstrap/easyui.css">  
    <link rel="stylesheet" type="text/css" href="static/js/layout/themes/mobile.css">  
    <link rel="stylesheet" type="text/css" href="static/js/layout/themes/icon.css">  
    <link rel="stylesheet" type="text/css" href="static/js/layout/themes/color.css">
    <script type="text/javascript" src="static/js/jquery.min.js"></script>  
	<script>var WEB='<?php echo WEB?>';var ACCOUNTS=<?php echo $accounts?json_encode($accounts):'[]'; ?>;</script>
    <script type="text/javascript" src="static/js/layout/jquery.easyui.min.js"></script> 
    <script type="text/javascript" src="static/js/layout/jquery.easyui.mobile.js"></script> 
	<script type="text/javascript" src="static/js/layout/locale/easyui-lang-zh_CN.js"></script>
	<style>
.tt-inner{display:inline-block;line-height:12px;padding-top:5px;}
.ico{font-size:22px;}
.tt-inner span{display:block;padding-top:5px}
.list-thumb{display:inline-block;height:30px;margin-right:5px}
.pagination li{margin-right:10px;}
.searchbar{position:relative;background:#f7f7f7;border-bottom:1px solid #cecece}
.searchbar b{padding:3px 10px}
.searchbar .easyui-textbox{width:80%}
.searchbar .textbox{border-radius:0;border-bottom:0;border-top:0}
.searchbar button{position:absolute;right:0;top:0;border-radius:0;width:21%;height:32px;float:right}
.loader{display:block;margin:80px auto}
</style>
</head>
<body>
<div class="easyui-navpanel">
	<header>
		<div class="m-toolbar">
			<div class="m-title">全网通营销平台</div>
		</div>
	</header>
	<div class="easyui-tabs" data-options="tabHeight:60,fit:true,tabPosition:'bottom',border:false,pill:true,narrow:true,justified:true">
		<div>
			<div class="panel-header tt-inner" onClick="Core.update('newsList','wap_news')"><i class="ico entypo-newspaper"></i><span>内容管理</span></div>
			<div class="info">
				<a href="javascript:;" onClick="Core.open('<?php echo WEB?>cellphone/edit_news','新建内容')" class="easyui-linkbutton c6" style="width:100%;border-radius:0;padding:5px"><i class="entypo-plus-circled"></i> 新建内容</a>
                <form action="<?php echo WEB.'cellphone/wap_news'?>" id="news_form">
					<div class="searchbar">
						<b>搜索：</b><input type="text" name="title" class="easyui-textbox">
						<button class="easyui-linkbutton c1" onClick="Core.ajaxSearch('newsList','news_form');" type="button">查询</button>
					</div>
					<div id="newsList"></div>
                </form>
			</div>
		</div>
		<div>
			<div class="panel-header tt-inner" onClick="Core.update('goodsList','wap_goods')"><i class="ico entypo-cloud"></i><span>商品管理</span></div>
			<div class="info">
				<a href="javascript:;" onClick="Core.open('<?php echo WEB?>cellphone/edit_goods','新建商品')" class="easyui-linkbutton c6" style="width:100%;border-radius:0;padding:5px"><i class="entypo-plus-circled"></i> 新建商品</a>
                <form action="<?php echo WEB.'cellphone/wap_goods'?>" id="goods_form">
					<div class="searchbar">
						<b>搜索：</b><input type="text" name="title" class="easyui-textbox">
						<button class="easyui-linkbutton c1" onClick="Core.ajaxSearch('goodsList','goods_form');" type="button">查询</button>
					</div>
					<div id="goodsList"></div>
                </form>
			</div>
		</div>
		<div>
			<div class="panel-header tt-inner" onClick="Core.update('orderList','wap_order')"><i class="ico entypo-box"></i><span>订单管理</span></div>
			<div class="info">
            	 <form action="<?php echo WEB.'cellphone/wap_order'?>" id="order_form">
					<div class="searchbar">
						<b>搜索：</b><input type="text" name="title" class="easyui-textbox">
						<button class="easyui-linkbutton c1" onClick="Core.ajaxSearch('orderList','order_form');" type="button">查询</button>
					</div>
					<div id="orderList"></div>
                </form>
			</div>
		</div>
		<div>
			<div class="panel-header tt-inner"><i class="ico entypo-cog"></i><span>设置</span></div>
			<div class="info">
			</div>
		</div>
	</div>
</div>
<div id="detailPage" class="easyui-navpanel">
	<header style="height:40px">
		<div class="m-toolbar">
			<span id="pTitle" class="m-title"></span>
			<div class="m-left">
				<a href="javascript:void(0)" class="easyui-linkbutton m-back" plain="true" outline="true" style="width:50px" onClick="$.mobile.back()">后退</a>
			</div>
			<div class="m-right">
				<a href="javascript:void(0)" id="tools" class="easyui-menubutton" style="display:none" data-options="iconCls:'icon-more',menu:'#mm',menuAlign:'right',hasDownArrow:false"></a>
			</div>
		</div>
    </header>
	<div id="mm" class="easyui-menu" style="width:150px;">
        <div id="actDel" data-options="iconCls:'icon-remove'">删除</div>
        <div id="actPush" data-options="iconCls:'icon-redo'">推送给粉丝</div>
    </div>
	<div id="pContent">
		
	</div>
</div>
</body>
</html>
<script>
var Core={
	open: function(s,title){
		$('#pTitle').html(title);
		$.mobile.go('#detailPage');
		$('#pContent').html('<img src="static/js/layout/themes/bootstrap/images/loading.gif" class="loader"/>');
		$('.loader').show();
		$.get(s+(s.indexOf('?')==-1?'?':'&')+'time='+new Date().getTime(),function(c){
			$('.loader').hide();
			$('#pContent').html(c);
			$.parser.parse('#pContent');
		});
	},
	init: function(page){
		$.get(WEB+'cellphone/wap_news?time='+new Date().getTime(),function(c){
			$('#newsList').html(c);
			Core.pagination('newsList','news_form');
		});
		/**$.get(WEB+'cellphone/wap_goods?time='+new Date().getTime(),function(c){
			$('#goodsList').html(c);
			Core.pagination('goodsList?time='+new Date().getTime(),'goods_form');
		});
		$.get(WEB+'cellphone/wap_order?time='+new Date().getTime(),function(c){
			$('#orderList').html(c);
			Core.pagination('orderList','order_form');
		});**/
	},
	update:function(c,d){
		$.get(WEB+'cellphone/'+d+'?time='+new Date().getTime(),function(e){
			$('#'+c).html(e);
			Core.pagination(c,$('#'+c).parent().attr('id'));
		});
	},
	//分页
	pagination: function(id,formid){
		if(formid!='no') var data=$("#"+formid).serialize(); else data='';
		$('body').on('click','#'+id+' .fenye a',function(){
				var url = $(this).attr("href");
        $.ajax({
          type: "POST",
          data: data+"&ajax=1",
          url: url,
          beforeSend: function(){
             $("#"+id).html('<center><div class="indicator"></div></center>');
          },
          success: function(msg){
            $("#"+id).html(msg);
          }
        });
        return false;
		});
	},
	//无刷新查询
	//formid 查询表单ID  id 刷新块ID
	ajaxSearch: function(id,formid,posturl){
		var data=$("#"+formid).serialize();
		data+="&ajax=1";
		if(posturl==null){
			posturl=$("#"+formid).attr('action');
		}
		$("#"+id).html('');
		$.ajax({
			type: "POST",
          	data: data,
         	url: posturl,
          	success: function(msg){	
				if(msg.indexOf("error:")!=-1){
					msg=msg.replace("error:",'');
					alert(msg);
					return false;
				}else{
					$("#"+id).html(msg);
				}
          	}	
		});
	},
	singleUploader: function(id,mime,maxSize,callback,resize){
		$('.fileList').remove();
		var fileList = $('<div class="fileList"></div>').appendTo($('#'+id).parent());
		var myUploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button : id,
			multi_selection:false,
			resize: resize,
			url : WEB+"static/js/plupload/upload.php",
			filters : {max_file_size : maxSize,mime_types: mime},
			flash_swf_url : WEB+'/static/js/plupload/Moxie.swf',
			silverlight_xap_url : WEB+'/static/js/plupload/Moxie.xap',
			init: {
				FilesAdded: function(up, files) {
					plupload.each(files, function(file) {
						fileList.html('<span id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></span>');
					});
					myUploader.start();
				},
		 
				UploadProgress: function(up, file) {
					fileList.find('b').html('<span>' + file.percent + "%</span>");
				},
		 
				Error: function(up, err) {
					Core.error("\nError #" + err.code + ": " + err.message);
				},
				FileUploaded: function(up, file, info){
					var rs = eval('('+info.response+')');
					if(rs.error!=undefined) Core.error(rs.error.message);
					else{
						if(typeof(callback)=='function') callback(rs);
					}
					$('.fileList').remove();
				}
			}
		});
		myUploader.init();
	}
};
$(function(){Core.init();});
$.extend({  
	includePath: '',  
	include: function(file) {  
        var files = typeof file == "string" ? [file]:file;  
        for (var i = 0; i < files.length; i++) {  
            var name = files[i].replace(/^\s|\s$/g, "");  
            var att = name.split('.');  
            var ext = att[att.length - 1].toLowerCase();  
            var isCSS = ext == "css";  
            var tag = isCSS ? "link" : "script";  
            var attr = isCSS ? " type='text/css' rel='stylesheet' " : " language='javascript' type='text/javascript' ";  
            var link = (isCSS ? "href" : "src") + "='" + $.includePath + name + "'";  
            if ($(tag + "[" + link + "]").length == 0) document.write("<" + tag + attr + link + "></" + tag + ">");  
        }  
	}  
}); 
$.include(['static/js/plupload/plupload.full.min.js','static/js/plupload/jquery.plupload.queue/jquery.plupload.queue.min.js','static/js/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css','static/js/plupload/i18n/zh_CN.js']);
</script>