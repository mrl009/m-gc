<!-- 設置內容 -->
<?php $id=uniqid();?>
<div class="content">
    <form name="myFORM" action="setting/save_activity_blacklist" method="post" class="form-horizontal validate" id="activity_set_form">
        <input type="hidden" value="<?php echo $rs['id']?>" name="id" class='id'>
        <table style='width:100%;' class="table table-bordered">
            <tbody>
            <tr>
                <td align="center">会员名称</td>
                <td><input type="text" class="form-control easyui-validatebox"
                           data-options="required:true" value="<?php echo $rs['user_name']?>"  name="user" <?php if($rs['user_name']) echo 'disabled' ;?>></td>
            </tr>
                <tr >
                    <td align="center">活动平台</td>
                    <td>
                        <?php foreach ($activity_lists as $key => $value){?>
                        <label class="fwn"><input type="checkbox" name="show_way[]" value="<?php echo $value['id']?>" <?php if (in_array($value['id'], $rs['activity_id'])) echo 'checked';?>>&nbsp;<?php echo $value['title'] ;?>&nbsp;</label>
                        <?php };?>
                        &nbsp; &nbsp; &nbsp;
                        <p style="color: red">提示:必须选择一个活动,该会员在所选择的活动中无法获取奖励！</p>
                    </td>
                </tr>
                <tr>
                    <td align="center">备注</td>
                    <td><input name="comment" type="text" value="<?php echo $rs['comment']?>" class="form-control"></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript">
    var id = $('.id').val();
</script>