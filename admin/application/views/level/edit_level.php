<!--移動層級-->
<form action="level/save_level" class="form-horizontal validate" role="form" method="post" id="levelMove">
    <input type="hidden" name="id" value="<?php echo $level_id?>" />
    <span>目標層級：</span>
    <select class="form-control" name="new_id">
        <?php echo $level_id;foreach($level as $v){?>
            <option value="<?php echo $v['id']?>" <?php echo $level_id==$v['id']? 'selected':''?> ><?php echo $v['level_name']?></option>
        <?php }?>
    </select>
</form>