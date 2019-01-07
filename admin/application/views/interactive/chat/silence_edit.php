<!-- 设置禁言 -->
<form action="interactive/chat/silence_save" class="form-horizontal validate" role="form" method="post" id="bank_revise">
    <div class="form-group">
        <label class="col-sm-3 control-label">用户名:</label>
        <div class="col-sm-6 pt7">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" value="<?php echo $username;?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">禁言时间:</label>
        <div class="col-sm-6 pt7">
            <select class="form-control bank_id" name="status">
                <option value="2" <?php echo (2 == $silence_type) ? 'selected' : ''?>>禁言24小时</option>
                <option value="3" <?php echo (3 == $silence_type) ? 'selected' : ''?>>禁言30天</option>
                <option value="4" <?php echo (4 == $silence_type) ? 'selected' : ''?>>永久禁言</option>
                <option value="1" <?php echo (1 == $silence_type) ? 'selected' : ''?>>解禁</option>
            </select>
        </div>
    </div>
</form>

