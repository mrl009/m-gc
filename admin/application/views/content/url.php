<?php $id=uniqid();?>
<ul class="nav nav-tabs">
	<li class="active"><a href="#pc-<?php echo $id?>" data-toggle="tab">PC版</a></li>
	<li><a href="#wx-<?php echo $id?>" data-toggle="tab">微信版</a></li>
	<li><a href="#h5-<?php echo $id?>" data-toggle="tab">手機版</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="pc-<?php echo $id?>" style="padding:8px">
		<input type="text" class="form-control" value="<?php echo $pc?>" />
	</div>
	<div class="tab-pane" id="wx-<?php echo $id?>" style="padding:8px">
		<?php foreach($wx as $v){?>
		<div class="form-group">
			 <label><?php echo $v['name']?></label>
			 <input type="text" class="form-control" value="<?php echo $v['url']?>" />
		</div>
		<?php }?>
	</div>
	<div class="tab-pane" id="h5-<?php echo $id?>" style="padding:8px">
		<input type="text" class="form-control" value="<?php echo $h5?>" />
	</div>
</div>