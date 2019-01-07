<form action="redmoney/save_lavelset" class="form-horizontal validate" role="form" method="post" id="saveLevelSet">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '';?>">
    <table class="table table-bordered info_set">
        <tr>
            <td class="first_line" >等級範圍：</td>
            <td>
                <label><input type="number" name="start_recharge" value="<?php echo $start_recharge?>" class="easyui-validatebox" data-options="required:true">~</label>
                <label><input type="number" name="end_recharge" value="<?php echo $end_recharge?>" class="easyui-validatebox" data-options="required:true">&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="first_line" >獎金範圍：</td>
            <td>
                <label><input type="number" name="start_total" value="<?php echo $start_total?>" class="easyui-validatebox" data-options="required:true">~</label>
                <label><input type="number" name="end_total" value="<?php echo $end_total?>" class="easyui-validatebox" data-options="required:true">&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="first_line" >個人抽獎次數：</td>
            <td>
                <input type="number" name="count" value="<?php echo $count;?>" class="easyui-validatebox" data-options="required:true">
            </td>
        </tr>
    </table>
</form>

<style>
    #saveLevelSet input[type=number] {
        -moz-appearance:textfield;
    }
    #saveLevelSet input[type=number]::-webkit-inner-spin-button,
    #saveLevelSet input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>