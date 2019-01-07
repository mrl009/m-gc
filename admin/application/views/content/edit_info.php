<?php $id=uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="content/textSave" style="overflow-x:hidden">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
    <input type="hidden" name="title" value="<?php echo $rs['title']?>">
	<input type="hidden" name="en_title" value="<?php echo $rs['en_title']?>">
    <input type="hidden" name="category_id" value="<?php echo $rs['category_id']?>" />
    <div class="form-group"></div>

	<div class="form-group">
		<label class="col-sm-1 control-label">內容:</label>
		<div class="col-sm-10">
			<textarea id="<?php echo $id?>" style="height:300px" name="content"><?php echo $rs['content']?></textarea>
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-1 control-label"></label>
        <div class="col-sm-10">
            <button class="btn btn-green btn-icon save" type="button" onclick="saveinfo(this)">保存修改 <i class="entypo-check"></i></button>
        </div>
	</div>
</form>
<script>
var ue = UE.getEditor('<?php echo $id?>');
function saveinfo(e){
	$(e).parents('form').form('submit',{
		ajax:true,
		url:'content/savearticle',
		onSubmit: function(){
			return $(this).form('enableValidation').form('validate');
		},
		success:function(c){
			c=eval('('+c+')');
			switch(c.status){
				case "ERROR": Core.error('沒有修改任何信息','error'); break;
				case 'OK': Core.ok('基礎信息修改成功'); break;
				default: Core.error(c); 
			}
		}
	});
}
</script>