<!--修改出款信息-->
<form action="cash/save_payment" class="form-horizontal validate" role="form" method="post" id="save_payment">
    <input type="hidden" name="id" value="<?php echo $id?>" />
    <div class="form-group">
        <label class="col-sm-5 control-label">出款手續費:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" value="<?php echo $hand_fee;?>"  name="hand_fee">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-5 control-label">行政費用:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" value="<?php echo $admin_fee;?>"  name="admin_fee">
        </div>
    </div>
</form>
<style>
    #save_payment.form-horizontal .form-control{
        padding:2px 5px!important;
        height:auto!important;
        display: inline-block;
        width:135px;
        margin-right:4px;
    }
</style>