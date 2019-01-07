<!--目標層級-->
<form action="member/save_fc" class="form-horizontal validate" role="form" method="post" id="levelMove">
	<input type="hidden" name="id" value="<?php echo $id?>" />
	<span>目標層級：</span>
	<select class="form-control" name="level_id">
		<?php echo $level_id;foreach($level as $v){?>
		<option value="<?php echo $v['id']?>" <?php echo $level_id==$v['id']? 'selected':''?> ><?php echo $v['level_name']?></option>
		<?php }?>
	</select>
	<div class="checkbox">
	   	<label><input type="checkbox"  <?php echo $is_level_lock==1?'checked':''?> name="is_level_lock">鎖定</label>
	</div>
</form>

