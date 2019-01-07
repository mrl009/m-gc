<!-- 基本資料設定 -->
<form action="member/form_save" class="form-horizontal validate" role="form" method="post" id="member_form_save">
    <input name="id" type="hidden" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">
    <input name="user_id" type="hidden" value="<?php echo isset($data['user_id']) ? $data['user_id'] : ''; ?>">
    <input name="status_id" type="hidden" value="<?php echo isset($data['status']) ? $data['status'] : ''; ?>">

    <div class="form-group">
        <label class="col-sm-3 control-label">ID:</label>
        <div class="col-sm-9">
            <input type="text" style="width: 80%;" class="form-control easyui-validatebox" data-options="required:true"
                   name="id" value="<?php echo $data['id'] ?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">賬號:</label>
        <div class="col-sm-9">
            <input type="text" style="width: 80%;" class="form-control easyui-validatebox" data-options="required:true"
                   name="username" value="<?php echo $data['username'] ?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">姓名:</label>
        <div class="col-sm-9">
            <input type="text" style="width: 80%;" class="form-control easyui-validatebox" data-options="required:false"
                   name="name" value="<?php echo $data['name'] ?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">電話:</label>
        <div class="col-sm-9">
            <input type="text" style="width: 80%;" class="form-control easyui-validatebox" data-options="required:true"
                   name="phone" value="<?php echo $data['phone'] ?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">郵箱:</label>
        <div class="col-sm-9">
            <input type="text" style="width: 80%;" class="form-control easyui-validatebox" data-options="required:true"
                   name="email" value="<?php echo $data['email'] ?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">QQ/微信:</label>
        <div class="col-sm-9">
            <input type="text" style="width: 80%;" class="form-control easyui-validatebox" data-options="required:true"
                   name="qq" value="<?php echo $data['qq'] ?>" disabled>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">申請理由:</label>
        <div class="col-sm-9">
            <textarea name="user_memo" style="width: 80%;height: 100px!important;"
                      class="form-control easyui-validatebox" data-options="required:false"
                      disabled><?php echo $data['user_memo'] ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">操作:</label>
        <div class="col-sm-9" style="margin-top: 5px">
        <?php if($data['status']==4){?>
            <label style="margin-right: 3px;">審核通過</label>
        <?php }else{?>
            <label style="margin-right: 3px;"><input type="radio" style="margin-right: 3px;" class="easyui-validatebox"
                                                     value="1" name="status" <?php echo $data['status']==1?'checked':''?> onclick="clickStatus(1)">提交審核</label>
            <label style="margin-right: 3px;"><input type="radio" style="margin-right: 3px;" class="easyui-validatebox"
                                                     value="4" name="status" <?php echo $data['status']==4?'checked':''?>  onclick="clickStatus(4)">審核通過</label>
            <label style="margin-right: 3px;"><input type="radio" style="margin-right: 3px;" class="easyui-validatebox"
                                                     value="3" name="status" <?php echo $data['status']==3?'checked':''?>  onclick="clickStatus(3)">拒絕</label>
            <label style="margin-right: 3px;"><input type="radio" style="margin-right: 3px;" class="easyui-validatebox"
                                                     value="2" name="status" <?php echo $data['status']==2?'checked':''?>  onclick="clickStatus(2)">補充資料</label>
        <?php }?>
            

        </div>
    </div>
    <div class="form-group remark">
        <label class="col-sm-3 control-label">備註:</label>
        <div class="col-sm-9">
            <textarea name="memo" style="width: 80%;height: 100px!important;" class="form-control easyui-validatebox"
                      data-options="required:false"><?php echo $data['memo'] ?></textarea>
        </div>
    </div>

</form>

<script>

    if($('[name=status_id]').val()==1 || $('[name=status_id]').val()==4){
        $('.form-group.remark').hide();
    }
    function clickStatus(i) {
        if (i == 1 || i == 4) {
            $('.form-group.remark').hide();
        } else {
            $('.form-group.remark').show();
        }
    }
</script>
