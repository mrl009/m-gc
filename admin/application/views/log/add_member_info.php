<!-- 推送消息 -->
<form action="log/save_member_info" class="form-horizontal validate" role="form" method="post" id="save_member_info">
    <input type="hidden" name="admin_id" value="<?php echo $admin_id;?>">
    <div class="form-group">
        <label class="col-sm-3 control-label">推送廣播:</label>
        <div class="col-sm-9 pt7">
            <select id="terminal" class="form-control" name="terminal">
                <option value="" selected>所有平臺</option>
                <option value="1">IOS</option>
                <option value="2">Android</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">標題:</label>
        <div class="col-sm-9">
            <input class="form-control easyui-validatebox" data-options="required:true" type="text" value="" name="title" style="width: 80%">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">內容:</label>
        <div class="col-sm-9">
            <textarea name="content" style="width: 80%;height: 160px!important" class="form-control easyui-validatebox" data-options="required:true"></textarea>
        </div>
    </div>
</form>
<style>
    .form-control{
        padding:2px 5px!important;
        display: inline-block;
        width:135px;
        margin-right:4px;
        float: left;
    }
    #child_info.form-horizontal .form-group{
        margin-bottom:4px!important;
    }
</style>
