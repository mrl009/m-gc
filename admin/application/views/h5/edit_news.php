<form method="POST" id="newsForm">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	<div style="padding:15px;margin-bottom:40px">
		<div class="form-group">
			<label>资讯标题</label>
			<input class="form-control easyui-validatebox" name="title" value="<?php echo $rs['title']?>" data-options="required:true" />
		</div>
		<div class="form-group">
			<label>URL自定义</label>
			<input class="form-control easyui-validatebox" name="en_title" value="<?php echo $rs['en_title']?>" style="font-style:italic"
            data-options="required:true,validType:{remote:['<?php echo WEB.'content/ispinyin?id='.$rs['id']?>','en_title']},invalidMessage:'URL已存在，请修改'">
		</div>
		<div class="form-group">
			<label>图片相册</label><br>
			<a class="btn btn-info" id="uploadBtn" style="width:100%">上传图片</a>
			<ul class="picList">
				<?php if($rs['thumb']){foreach(json_decode($rs['thumb'],true) as $v){ ?>
				<li>
					<input type="hidden" name="thumb[]" value="<?php echo $v?>">
					<div><img src="../<?php echo $v.'?time='.uniqid();?>"></div>
					<a href="javascript:;" onclick="$(this).parent().remove()" class="btn btn-primary" role="button">删除 <i class="entypo-cancel"></i></a>
				</li>
				<?php }}?>
			</ul>
		</div>
		<div class="form-group">
			<label>所属分类</label><br>
			<select name="category_id" style="width:100%;padding:5px"></select>
		</div>
		<div class="form-group">
			<label>跳转连接</label>
			<input type="text" class="form-control easyui-validatebox" name="direct" data-validate="url" value="<?php echo $rs['direct']?>">
		</div>
		<div class="form-group">
			<label>摘要</label>
			<input type="text" class="form-control easyui-validatebox" name="remark"  value="<?php echo $rs['remark']?>">
		</div>
		<div class="form-group">
			<label>详细内容</label>
			<textarea class="form-control" name="content"><?php echo $rs['content']?></textarea>
		</div>
	</div>
	<footer style="position:fixed;bottom:0;left:0;width:100%;">
		<button class="easyui-linkbutton c7" style="width:100%;border-radius:0;padding:6px;color:#fff;">保存内容</button>
	</footer>
</form>
<script>
$('#tools').show();
//删除
$('#actDel').unbind('click').bind('click',function(){
	$.messager.confirm('温馨提示', '确实要删除该内容吗？', function(r){
		if (r){
			$.post(WEB+'content/delarticle',{id:'<?php echo $rs['id']?>'},function(){
				Core.update('newsList','wap_news');
				$.mobile.back();
				//$.messager.alert('温馨提示','成功删除数据！');
			});
		}
	});
	
});
//推送
$('#actPush').unbind('click').bind('click',function(){
	var id='<?php echo $rs['id']?>';
	if(id!=''){
		$.post(WEB+'push_news/save?type=custom',{news_id:'["'+id+'"]',},function(c){
			c=eval('('+c+')');
			$.get(WEB+'push_news/send?type=custom&ids='+id+'&task='+c.id,function(c){
				$.messager.alert('温馨提示','成功推送资讯！');
			});
		});
	}
});
//分类
$.getJSON(WEB+'content/getchannel?pid=',function(c){
	$.each(c,function(i,d){
		$('[name=category_id]').append('<option value="'+d.id+'" '+('<?php echo $rs['category_id']?>'==d.id?'selected':'')+'>'+d.label.substr(0,d.label.indexOf('('))+'</option>');
	});
});
//上传
Core.singleUploader('uploadBtn',[{title : "Image files", extensions : "jpg,gif,png"}],'10mb',function(rs){
	$('.picList').append('<li><input type="hidden" name="thumb[]" value="'+rs.result+'"><div><img src="'+WEB+'../'+rs.result+'"></div><a href="javascript:;" onclick="$(this).parent().remove()" class="btn btn-primary" role="button">删除 <i class="entypo-cancel"></i></a></li>');
},{width:500,height:400,quality:100,crop: false});
//提交
$('#newsForm').form({
	url: WEB+'content/savearticle',
	success: function(c){
		c=eval('('+c+')');
		if(c.status=='OK'){
			Core.init();
			$.messager.alert('温馨提示','保存数据成功！');
			$.mobile.back();
		}else{
			$.messager.alert('温馨提示','保存数据失败！');
		}
	}
});
$('[name=title]').blur(function(){
	var v=$(this).val();
	if(v!=''){							
		$.post(WEB+'content/pinyin',{word:v},function(c){
			$('[name=en_title]').val(c);											  
		});
	}
});
</script>
<style>
.picList{margin:0;margin-top:10px;padding:0}
.picList li{display:inline-block;width:30%;border:1px solid #cecece;padding:3px;border-radius:3px;margin-right:6px;margin-bottom:10px;text-align:center}
.picList li div{width:100%;height:50px;overflow:hidden;margin-bottom:5px}
.picList li div img{width:100%}
.picList li a{width:100%}
</style>