<form action="setting/save_domain" class="form-horizontal validate" role="form" method="post" onkeydown="if(event.keyCode==13)return false;">
	<input type="hidden" name="is_binding" value="1" />
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	<div class="form-group">
		<label class="col-sm-2 control-label">類型：</label>
		<div class="col-sm-10">
			<select name="type">
                <?php if (!in_array(4, $type) || $rs['type']==4){?>
				<option value="4" <?php echo $rs['type']==4?'selected':''?>>主PC域名(只能設置一條)</option>
                <?php }?>
                <?php if (!in_array(4, $type) || $rs['type']==3){?>
				<option value="3" <?php echo $rs['type']==3?'selected':''?>>主手機域名(只能設置一條)</option>
                <?php }?>
				<option value="6" <?php echo $rs['type']==6?'selected':''?>>其他手機域名(可多條)</option>
                <option value="7" <?php echo $rs['type']==7?'selected':''?>>其他電腦域名(可多條)</option>
				<option value="2" <?php echo $rs['type']==2?'selected':''?>>支付域名(可多條)</option>

			</select>	
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">域名：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control easyui-validatebox w250" data-options="required:true" validtype="url" invalidMessage="url格式不正確必須帶http或https" name="domain" value="<?php echo $rs['domain']?>">
			<span class="c_red">*必須帶http://或https://</span>
		</div>
	</div>
	<div class="form-group">
				<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
			    注意事項:主PC域名和主手機端域名只能設置一個而且必須設置,設置多個會造成網站打不開.主PC域名作用如果用電腦打開手機版域名就跳轉到這個主PC域名,主手機版域名如果用手機打開電腦版域名跳轉到這個主手機域名.其他域名只要用自己對應的終端打開不會跳轉.

		</div>
	</div>

    <div class="form-group">
        <label class="col-sm-2 control-label">邀请码：</label>
        <div class="col-sm-10">
            <input type="text" class="form-control w250" name="invite_code" value="<?php echo $rs['invite_code'] ?>">
            <span class="c_red">*非必填</span>
        </div>
    </div>
</form>