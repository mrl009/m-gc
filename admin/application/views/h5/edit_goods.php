<form method="POST" id="goodsForm">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>" />
	<input type="hidden" name="goods_status" value="1" />
	<?php if($rs['id']){?>
	<button class="easyui-linkbutton c6" type="button" style="width:100%;border-radius:0;padding:6px;color:#fff;" onclick="addAmount(<?php echo $rs['id']?>)">为当前商品新增库存</button>
	<?php }?>
	<div style="padding:15px;margin-bottom:40px">
		<div class="form-group">
			<label>商品名称</label>
			<input type="text" class="form-control easyui-validatebox" name="title" value="<?php echo $rs['title']?>" data-options="required:true">
		</div>
		<div class="form-group">
			<label>URL自定义</label>
			<input type="text" class="form-control easyui-validatebox"  name="en_title" value="<?php echo $rs['en_title']?>" 
            data-options="required:true,validType:{remote:['<?php echo WEB.'goods/ispinyin?id='.$rs['id']?>','en_title']},invalidMessage:'URL已存在，请修改'">
		</div>
		<div class="form-group">
			<label>小标题</label>
			<input type="text" class="form-control" name="subtitle" value="<?php echo $rs['subtitle']?>">
		</div>
		<div class="form-group">
			<label>商品分类</label>
			<select name="category_id" style="width:100%"></select>
		</div>
		<div class="form-group">
			<label>现价</label>
			<input type="text" class="form-control easyui-validatebox" name="price" value="<?php echo $rs['price']?>" data-options="required:true,validType:'number'" />
		</div>
		<div class="form-group">
			<label>市场价</label>
			<input type="text" class="form-control easyui-validatebox" name="market_price" value="<?php echo $rs['market_price']?>" data-options="required:true,validType:'number'" />
		</div>
		<div class="form-group">
			<label>商品相册</label><br>
			<a class="btn btn-info" id="uploadBtn" style="width:100%">上传图片</a>
			<ul class="picList">
				<?php if($rs['pictures']){foreach(json_decode($rs['pictures'],true) as $v){ ?>
				<li>
					<input type="hidden" name="thumb[]" value="<?php echo $v?>">
					<div><img src="../<?php echo $v.'?time='.uniqid();?>"></div>
					<a href="javascript:;" onclick="$(this).parent().remove()" class="btn btn-primary" role="button">删除 <i class="entypo-cancel"></i></a>
				</li>
				<?php }}?>
			</ul>
		</div>
		<div class="form-group">
			<label>商品描述</label>
			<textarea id="<?php echo $id?>" class="form-control" name="content"><?php echo $rs['content']?></textarea>
		</div>
	</div>
	<footer style="position:fixed;bottom:0;left:0;width:100%;">
		<button class="easyui-linkbutton c7" style="width:100%;border-radius:0;padding:6px;color:#fff;">保存商品</button>
	</footer>
</form>
<script>
$('#tools').show();
//删除
$('#actDel').unbind('click').bind('click',function(){
	$.messager.confirm('温馨提示', '确实要删除该商品吗？', function(r){
		if (r){
			$.post(WEB+'goods/delgoods',{id:'<?php echo $rs['id']?>'},function(c){
				Core.update('goodsList','wap_goods');
				$.mobile.back();
				//$.messager.alert('温馨提示','成功删除数据！');
			});
		}
	});
});
//推送
$('#actPush').unbind('click').bind('click',function(){
	alert(1);
});
//分类
$.getJSON(WEB+'goods/get_category?pid=',function(c){
	$.each(c,function(i,d){
		$('[name=category_id]').append('<option value="'+d.id+'" '+('<?php echo $rs['category_id']?>'==d.id?'selected':'')+'>'+d.label+'</option>');
	});
});
//上传
Core.singleUploader('uploadBtn',[{title : "Image files", extensions : "jpg,gif,png"}],'10mb',function(rs){
	$('.picList').append('<li><input type="hidden" name="thumb[]" value="'+rs.result+'"><div><img src="'+WEB+'../'+rs.result+'"></div><a href="javascript:;" onclick="$(this).parent().remove()" class="btn btn-primary" role="button">删除 <i class="entypo-cancel"></i></a></li>');
},{width:500,height:400,quality:100,crop: false});
//提交
$('#goodsForm').form({
	url: WEB+'goods/save_goods',
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
//增加库存
function addAmount(id){
	Core.open('<?php echo WEB?>cellphone/add_goods_amount?id='+id,'新增库存')
}
</script>
<style>
.picList{margin:0;margin-top:10px;padding:0}
.picList li{display:inline-block;width:30%;border:1px solid #cecece;padding:3px;border-radius:3px;margin-right:6px;margin-bottom:10px;text-align:center}
.picList li div{width:100%;height:50px;overflow:hidden;margin-bottom:5px}
.picList li div img{width:100%}
.picList li a{width:100%}
</style>