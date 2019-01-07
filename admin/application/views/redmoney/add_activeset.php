<form action="redmoney/save_activeset" class="form-horizontal validate" role="form" method="post" id="saveActiveSet">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '';?>">
    <table class="table table-bordered info_set">
        <tr>
            <td class="first_line" >活動時間：</td>
            <td>
                <label>
                    <input type="datebox" class="easyui-datetimebox" name="start_time" value="<?php if ($start_time) echo $start_time?>" editable="false" style="width: 155px">~
                </label>
                <label>
                    <input type="datebox" class="easyui-datetimebox" name="end_time" value="<?php if ($end_time) echo $end_time?>" editable="false" style="width: 155px">&nbsp;&nbsp;
                </label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >紅包總額：</td>
            <td>
                <input type="number" name="price_total" value="<?php echo $total;?>" class="easyui-validatebox" data-options="required:true" style="width: 100px">
                <span style="margin-left: 20px">設置為0,無限額度</span>
            </td>
        </tr>
    </table>
</form>
<style>
    .first_line {
        text-align: right;
    }

    #saveActiveSet input[type=number] {
        -moz-appearance:textfield;
    }
    #saveActiveSet input[type=number]::-webkit-inner-spin-button,
    #saveActiveSet input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>