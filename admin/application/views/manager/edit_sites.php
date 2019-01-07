<?php $id=uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="manager/save_sites">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	
    <div class="form-group">
		<label class="col-sm-2 control-label">站点名称：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox" name="name" value="<?php echo $rs['name']?>" data-options="required:true">
		</div>
	</div>
	 <div class="form-group">
		<label class="col-sm-2 control-label">状态：</label>
		<div class="col-sm-10">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-white <?php echo $rs['status']==1 || $rs['status']==''?'active':''?>"><input type="radio" name="status" value="1" <?php echo $rs['status']==1 || $rs['status']==''?'checked':''?>>启用</label>
				<label class="btn btn-white <?php echo $rs['status']==2?'active':''?>"><input type="radio" name="status" value="2" <?php echo $rs['status']==2?'checked':''?>>停用</label>
			</div>
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2 control-label">微信号：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox" name="wechat_id" value="<?php echo $rs['wechat_id']?>" data-options="required:true">
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2 control-label">原始ID：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox" name="wechat_oid" value="<?php echo $rs['wechat_oid']?>" data-options="required:true">
		</div>
	</div>
    <div class="form-group">
		<label class="col-sm-2 control-label">开发者ID：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox" name="app_id" value="<?php echo $rs['app_id']?>" data-options="required:true">
		</div>
	</div>
     <div class="form-group">
		<label class="col-sm-2 control-label">开发者KEY：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox" name="app_key" value="<?php echo $rs['app_key']?>" data-options="required:true">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label">密钥:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox" name="sn"  data-options="required:true" value="<?php echo $rs['sn']?>" disabled="disabled">
		</div>
	</div>
</form>