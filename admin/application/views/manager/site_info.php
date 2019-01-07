<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-2 control-label">接口URL：</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo str_replace('/admin/','/wechat',WEB)."/api/index?sn=$rs[sn]"; ?>" readOnly>
		</div>
		<div class="col-sm-2">
		
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">TOKEN：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" value="hstimes" readOnly>
		</div>
	</div>
</div>