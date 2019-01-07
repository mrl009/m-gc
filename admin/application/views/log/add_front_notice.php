<!--修改前臺信息 -->
<form action="log/save_front_notice" class="form-horizontal validate" role="form" method="post" id="save_front_notice">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '';?>">
    <input type="hidden" name="admin_id" value="<?php echo isset($admin_id) ? $admin_id : '';?>">

    <div class="form-group">
        <label class="col-sm-3 control-label">顯示位置:</label>
        <div class="col-sm-9">
            <select class="form-control all_member" name="show_location">
                <?php foreach ($showLocation as $k => $v){?>
                    <option value="<?php echo $k;?>" <?php if (isset($show_location) && $show_location == $k) echo 'selected'?>><?php echo $v;?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">顯示類型:</label>
        <div class="col-sm-9">
            <select class="form-control all_member" name="notice_type">
                <?php foreach ($noticeType as $k => $v){?>
                    <option value="<?php echo $k;?>" <?php if (isset($notice_type) && $notice_type == $k) echo 'selected'?>><?php echo $v;?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">層級:</label>
        <div class="col-sm-9">
            <select class="form-control all_member" name="level_id">
                <option value="-1">全部</option>
                <?php foreach ($level as $v){?>
                    <option value="<?php echo $v['id'];?>" <?php if (isset($level_id) && $level_id == $v['id']) echo 'selected'?>><?php echo $v['level_name'];?></option>
                <?php }?>
            </select>
        </div>
    </div>
        <div class="form-group">
        <label class="col-sm-3 control-label">標題:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control easyui-validatebox"  style="width: 80%;" data-options="required:true" value="<?php echo isset($title) ? $title : ''?>"  name="title">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">顯示內容:</label>
        <div class="col-sm-9">
            <textarea name="content" style="width: 80%;height: 160px!important;" class="form-control easyui-validatebox" data-options="required:true"><?php echo isset($content) ? $content : '';?></textarea>
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