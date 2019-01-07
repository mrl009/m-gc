<!--子賬號 基本資料修改 -->
<form action="agent/add_top_agent" class="form-horizontal validate" role="form" method="post" id="edit_child">
    <div class="form-group">
        <label class="col-sm-3 control-label">试玩账号:</label>
        <div class="col-sm-9 pt7">
            <input name="is_demo" type="radio" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="is_demo" value="0" type="radio"  checked>否
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">賬號:</label>
        <div class="col-sm-9 pt7">
            <input type="text" class="form-control easyui-validatebox" 
            data-options="required:true" value=""  name="username" maxlength="12">
            <span class="c_red">*長度4-14個字符,只能數字和字母</span>
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
</form>
<script>
    $("input[name='is_demo']").click(function (e) {
        if ($(e.target).val()) {
            $("input[name='username']").val('guest01').attr('readonly',true);
        }
    });
</script>

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