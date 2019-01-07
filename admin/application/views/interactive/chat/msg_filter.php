<!--修改前臺信息 -->
<form action="interactive/chat/msg_filter_save" class="form-horizontal validate" role="form" method="post" id="save_front_notice">
    <div class="form-group">
        <label  class="col-sm-3 control-label">敏感词设置:</label>
        <div class="col-sm-9">
            <textarea name="data_filter" style="width: 80%;height: 260px!important;" class="form-control easyui-validatebox" data-options="required:true"><?php echo $rs;?></textarea>
            <br>以换行区分每个词句
        </div>
    </div>
</form>
<style>
    #save_front_notice.form-horizontal .form-control{
        padding:2px 5px!important;
        height:auto!important;
        display: inline-block;
        width:135px;
        margin-right:4px;
    }
    #child_info.form-horizontal .form-group{
        margin-bottom:4px!important;
    }
</style>