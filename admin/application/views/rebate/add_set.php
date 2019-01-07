<!--修改前臺信息 -->
<form action="rebate/save_set" class="form-horizontal validate" role="form" method="post" id="save_front_notice">
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <input type="hidden" name="rate_type" value="<?php echo $rate_type;?>">

    <div class="form-group">
        <label class="col-sm-3 control-label">級別:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox" maxlength="12"  style="width: 80%;" data-options="required:true" name="name" value="<?php echo $name;?>">
        </div>
    </div>
    <div class="form-group <?php //echo $rate_type==3?'':'hidden';?>">
        <label class="col-sm-3 control-label">有效打碼量:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox" maxlength="12" style="width: 80%;" data-options="<?php echo $rate_type==3?'required:true':'';?>" name="bet_amount" value="<?php echo $bet_amount;?>">
        </div>
    </div>
    <!--<div class="form-group">
        <label class="col-sm-3 control-label">有效會員:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox" maxlength="12"  style="width: 80%;" data-options="required:true" name="user_sum" value="<?php echo $user_sum;?>">
        </div>
    </div>-->
    <div class="form-group">
        <label class="col-sm-3 control-label">退傭比例[彩票]:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control easyui-validatebox" maxlength="12"  style="width: 80%;float: left;margin-right:0" data-options="required:true" name="rate" value="<?php echo $rate;?>">
            <span class="col-sm-1 input-group-addon" style="float: left;width: 10%;height: 26px">%</span>
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
</style>