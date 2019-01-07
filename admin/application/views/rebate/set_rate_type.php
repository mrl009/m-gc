<form action="rebate/save_rate_type" class="form-horizontal validate" role="form" method="post" id="levelForm">
    <input name="id" type="hidden" value="<?php echo $id?>">
    <table class="table table-bordered info_set">
        <tr>
            <td class="first_line" >退傭模式：</td>
            <td>
                <select class="form-control paySet" name="rate_type" style="width: 150px">
                    <option value="1" <?php echo $rate_type=='1'?'selected':'';?>>按交收總盈利模式</option>
                    <option value="2" <?php echo $rate_type=='2'?'selected':'';?>>按非交收總盈利模式</option>
                    <option value="3" <?php echo $rate_type=='3'?'selected':'';?>>按打碼量</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span>
                    1:有效打碼量模式退傭,是根據會員昨天有效投註量來計算返傭,每天為壹期,當天返昨天.<br>
                    2:總盈利模式退傭,是根據報表上月總盈利來計算返傭,每月為壹期,當月返上月.<br>
                    3:交收模式是只有選擇了盈利模式才可選,如選中交收模式,每月盈利要抵消反水金額,送優惠金額.<br>
                    4:壹經選擇,如果修改下期生效.
                </span>
            </td>
        </tr>
    </table>
</form>
