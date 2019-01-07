<style>
#set_pwd{
    margin:20px auto!important;
    width:50%!important;
}

#set_pwd input.form-control{
    display:inline-block;
    width:235px;
}
</style>
<form class="form-horizontal validate" role="form" method="post" id="set_pwd" action="manager/save_pwd"> <!---->
    <div class="form-group">
        <label class="col-sm-4 control-label">舊密碼：</label>
        <div class="col-sm-8">
            <input type="password" class="form-control easyui-validatebox" name="old_pwd"
                   data-options="required:true" invalidMessage="密碼長度6-18位,不能包含中文和空格">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">新密碼：</label>
        <div class="col-sm-8">
            <input type="password" class="form-control easyui-validatebox" name="pwd"
                   data-options="required:true" invalidMessage="密碼長度6-18位,不能包含中文和空格">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">確認新密碼：</label>
        <div class="col-sm-8">
            <input type="password" class="form-control easyui-validatebox" name="two_pwd"
                   data-options="required:true" invalidMessage="密碼長度6-18位,不能包含中文和空格">
        </div>
    </div>
</form>