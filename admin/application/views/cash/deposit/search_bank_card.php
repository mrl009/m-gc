<?php $id = "form_" . uniqid(); ?>
<form class="form-horizontal" role="form" method="post" action="#" style="min-height:100px;text-align: center">
    <table class="table table-bordered" style="text-align: left">
        <?php for ($i = 0; $i < $num; $i++) { ?>
            <tr>
                <td>
                    <input type="checkbox" name="bank_card"
                           value="<?php echo $bank_card[$i * 2]['id'] ?>"
                           v-value="<?php echo $bank_card[$i * 2]['name'] ?>">
                    <?php echo $bank_card[$i * 2]['card_username'].'&nbsp;&nbsp;<span style = "color:red">'.$bank_card[$i * 2]['bank_name'].'</span><br>&nbsp;&nbsp;&nbsp;&nbsp;'.$bank_card[$i * 2]['name'] ?>
                </td>
                <td>
                    <input type="checkbox" name="bank_card"
                           class="<?php echo empty($bank_card[$i * 2 + 1]['id']) ? 'hidden' : ''?>"
                           value="<?php echo $bank_card[$i * 2 + 1]['id'] ?>"
                           v-value="<?php echo $bank_card[$i * 2 + 1]['name'] ?>">
                    <?php echo $bank_card[$i * 2 + 1]['card_username'].'&nbsp;&nbsp;<span style = "color:red">'.$bank_card[$i * 2+1]['bank_name'].'</span><br>&nbsp;&nbsp;&nbsp;&nbsp;'.$bank_card[$i * 2+1]['name'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <button class="btn btn-xs btn-success" type="button" onclick="confirm_bank()">确认</button>
</form>
<script>
    function confirm_bank() {
        var list = [], text = [];
        var form_id = '<?php echo $form_id;?>';
        $("input[name='bank_card']:checkbox:checked").each(function () {
            text.push($(this).attr('v-value'));
            list.push($(this).val());
        });
        $('#form_' + form_id + ' [name="bankCard"]').val(text.join(','));
        $('#form_' + form_id + ' [name="bank_card"]').val(list.join(','));
        resetFresh();
        $('#modal').modal('hide');
    }
    function resetFresh() {
        var rk = sessionStorage.getItem('rk');
        var rk_refresh = sessionStorage.getItem('rk_refresh');
        if (rk != 1 || rk_refresh != 1) {
            clearInterval(rkInterval);
            var time = $('#form_form_company_id input[name="rktimelong"]').val();
            time = time || 20;
            var rk_params = getRkParams();
            rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},time*1000);
        }
    }

    function getRkParams() {
        var level_id = $('#form_form_company_id input[name="level_id"]').val();
        var status = $('#form_form_company_id input[name="status"]').val();
        var froms = $('#form_form_company_id input[name="froms"]').val();
        var is_first = $('#form_form_company_id input[name="is_first"]').val();
        var bank_card = $('#form_form_company_id input[name="bank_card"]').val();
        return {
            'level_id': level_id,
            'status': status,
            'froms': froms,
            'is_first': is_first,
            'bank_card': bank_card
        };
    }
</script>