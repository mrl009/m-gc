<form>
    <textarea maxlength="100" class="form-control" id="remark" onkeydown='if(event.keyCode==32){event.preventDefault();<?php if(in_array($status, [3,5])){?>payment_key_refuse(<?php echo $id;?>,<?php echo $status;?>)<?php }?>}'><?php echo isset($people_remark)?$people_remark:'' ?></textarea>
</form>