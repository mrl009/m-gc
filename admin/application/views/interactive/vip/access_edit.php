<!-- 修改銀行卡 -->
<form action="interactive/vip/access_save" class="form-horizontal validate" role="form" method="post" id="bank_revise">
    <div class="form-group">
        <label class="col-sm-3 control-label">VIP类型:</label>
        <div class="col-sm-6 pt7">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" value="<?php echo $vip_name;?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">发言条数:</label>
        <div class="col-sm-6" id="record_box">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" name="record_num" value="<?php echo $record_num;?>" <?php echo $is_speak == 0 ? 'disabled' : ''?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">抢红包次数:</label>
        <div class="col-sm-6" id="record_box">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" name="red_grab_num" value="<?php echo $red_grab_num;?>" <?php echo $is_speak == 0 ? 'disabled' : ''?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">发红包次数:</label>
        <div class="col-sm-6" id="record_box">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" name="red_send_num" value="<?php echo $red_send_num;?>" <?php echo $is_speak == 0 ? 'disabled' : ''?>>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">发言权限:</label>
        <div class="col-sm-6 status pt7">
            <label><input type="radio" value="1" name="is_speak" <?php echo $is_speak == 1 ? 'checked' : ''?>>&nbsp;是&nbsp;</label>
            <label><input type="radio" value="0" name="is_speak" <?php echo $is_speak == 0 ? 'checked' : ''?>>&nbsp;否</label>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">分享权限:</label>
        <div class="col-sm-6 status pt7" id="share_box">
            <label><input type="radio" value="1" name="is_share" <?php echo $is_share == 1 ? 'checked' : ''?> <?php echo $is_speak == 0 ? 'disabled' : ''?>>&nbsp;是&nbsp;</label>
            <label><input type="radio" value="0" name="is_share" <?php echo $is_share == 0 ? 'checked' : ''?> <?php echo $is_speak == 0 ? 'disabled' : ''?>>&nbsp;否</label>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">备注说明:</label>
        <div class="col-sm-6 status pt7">
            <font color="red">
            1.&nbsp;&nbsp;发言权限为是时, 默认有分享权限<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发言权限为否时, 默认无分享权限<br />
            2.&nbsp;&nbsp;设置该Vip等级不能发言时<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;低于该Vip等级的自动默认不能发言<br />
            3.&nbsp;&nbsp;设置该Vip等级可以发言时<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高于该Vip等级默认继承低等级权限<br />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;只继承发言分享权限;不包括发言条数
            </font>
        </div>
    </div>
</form>
<script>
    //初始化默認值
    
    //選擇發言權限時更改分享權限
    $("[name=is_speak]").bind("change",function(){
        var type = $(this).val();
        //發言權限為否時 發言條數為0,分享權限為否
        if (0 == type)
        {
            //發言框
            var mt = '<input type="text" class="form-control easyui-validatebox" data-options="required:true" name="record_num" value="0" disabled>';
            //分享框
            var it = '<input type="radio" value="1" name="is_share" disabled>';
            var nt = '<input type="radio" value="0" name="is_share" checked disabled>';
            var html = '<label>'+ it +'&nbsp;是&nbsp;&nbsp;</label><label>'+ nt +'&nbsp;否</label>';
        } else {
            //發言框
            var mt = '<input type="text" class="form-control easyui-validatebox" data-options="required:true" name="record_num" value="0">';
            //分享框
            var it = '<input type="radio" value="1" name="is_share" checked>';
            var nt = '<input type="radio" value="0" name="is_share">';
            var html = '<label>'+ it +'&nbsp;是&nbsp;&nbsp;</label><label>'+ nt +'&nbsp;否</label>';
        }
        $("#record_box").html(mt);
        $("#share_box").html(html);
    });
</script>
