<!--子賬號 基本資料修改 -->
<form action="member/save_child" class="form-horizontal validate" role="form" method="post" id="edit_child">
    <input type="hidden" name="admin_id" value="<?php echo $rs['id']?>">
    <div class="form-group">
        <label class="col-sm-3 control-label">賬號:</label>
        <div class="col-sm-9 pt7">
            <input type="text" class="form-control easyui-validatebox" 
            data-options="required:true" value="<?php echo $rs['username']?>"  name="username" maxlength="12">
            <span class="c_red">*長度5-12個字符,只能數字和字母</span>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">密碼:</label>
        <div class="col-sm-9">
            <input type="password" class="form-control easyui-validatebox"  AUTOCOMPLETE="off" name="pwd" data-options="required:true" maxlength="12">
            <span class="c_red">*6-18位，且至少包含壹個字母和壹個數字</span>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">確認密碼:</label>
        <div class="col-sm-9">
            <input type="password" class="form-control easyui-validatebox"  AUTOCOMPLETE="off" name="two_pwd" data-options="required:true" maxlength="12">
            <span class="c_red">*6-18位，且至少包含壹個字母和壹個數字</span>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">名稱:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" value="<?php echo $rs['name']?>" name="name" maxlength="12">
            <span class="c_red">*中文或字母a-z長度2-12位</span>
        </div>
    </div>
</form>

<style>
    #edit_child.form-horizontal .form-control{
        padding:2px 5px!important;
        height:auto!important;
        display: inline-block;
        width:135px;
        margin-right:4px;
    }
    #child_info.form-horizontal .form-group{
        margin-bottom:4px!important;
    }
    .form-control::-webkit-input-placeholder {
    color: #999 !important;
    -webkit-transition: color.5s !important;
    }
    .form-control:focus::-webkit-input-placeholder, .form-control:hover::-webkit-input-placeholder {
    color: #c2c2c2 !important;
    -webkit-transition: color.5s !important;
    } 
</style>