<?php $form_id="form_".uniqid();?>
<form action="reward/save_reward" class="form-horizontal validate" role="form" method="post" id="<?php echo $form_id?>">
    <input type="hidden" name="id" value="<?php echo $data['id']?>">
    <div class="form-group">
        <label  class="col-sm-3 control-label">第一区间:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox"  name="d1_rate" data-options="required:true" value="<?php echo $data['d1_rate']?>" maxlength="3">
            <span class="c_red">*例：填入0.1表示比例0.1%</span>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">第二区间:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox"  name="d2_rate" data-options="required:true" value="<?php echo $data['d2_rate']?>" maxlength="3">
            <span class="c_red">*例：填入0.2表示比例0.2%</span>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">第三区间:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox"  name="d3_rate" data-options="required:true" value="<?php echo $data['d3_rate']?>" maxlength="3">
            <span class="c_red">*例：填入0.3表示比例0.3%</span>
        </div>
    </div>
</form>

<style>
    #<?php echo $form_id?>.form-horizontal .form-control{
        padding:2px 5px!important;
        height:auto!important;
        display: inline-block;
        width:135px;
        margin-right:4px;
    }
    #<?php echo $form_id?>.form-horizontal .form-group{
        margin-bottom:4px!important;
    }
</style>