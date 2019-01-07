<!-- 層級  支付設定 -->
<form action="payset/edit_pay_setting_do" class="form-horizontal validate" role="form" method="post" id="levelPay">
    <table class="table table-bordered table-striped" id="paySet">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''?>">
        <tr class="tec">
            <td class="ter">入款設定</td>
            <td colspan="2">線上入款</td>
            <td colspan="2">公司入款</td>
            <td rowspan="12" class="tel levelFont vet" style="vertical-align: top!important">
                <span class="c_red">優惠標準:</span>會員單筆存款金額達到優惠標準，始可享有存款優惠。</br>
                <span class="c_red">優惠百分比:</span>會員達到優惠標準後，依所設定的百分比給與存款優惠。</br>
                <span class="c_red">最高存款金額:</span>會員存款不可超過所設定的金額，公司存入時僅爲柔性勸導，並無實質限制。</br>
                <span class="c_red">最低存款金額:</span>會員存款不可低於所設定的金額，公司存入時僅爲柔性勸導，並無實質限制。</br>
                <span class="c_red">優惠上限金額:</span>會員存款不可低於所設定的金額，公司存入時僅爲柔性勸導，並無實質限制。</br>
                <span class="c_red">1</span>.若會員存款金額超過所設定的金額，則以所設定的金額給予優惠。</br>
                <span class="c_red">2</span>.若設定 0 則爲不限制。</br>
                <span class="c_red">例</span>:假設 優惠上限金額 設定爲 10000,優惠百分比爲 15%,當會員的優惠金額超過10000元時, 存款優惠金額為10000。</br>
                <span class="c_red">出款設定:</span>達到有效投註額，是否免手續費,若選擇"是",免收手續費次數設置為"5",就是達到有效投註額了之後,出款成功5次之後就要收手續費.
            </td>
        </tr>
        <tr>
            <td class="ter">名稱:</td>
            <td class="" colspan="4">
                <input type="text" style="width: 100%" class="form-control easyui-validatebox" data-options="required:true" placeholder="" name="pay_name" value="<?php echo $pay_name;?>">
            </td>
        </tr>
        <tr>
            <td class="ter">存款優惠</td>
            <td colspan="2">
                <div class="radio">
                    <label><input type="radio" value="2" name="ol_deposit" <?php echo $ol_deposit == 2 ? 'checked' : ''?>>首次</label>
                </div>
                <div class="radio">
                    <label><input type="radio" value="1" name="ol_deposit" <?php echo $ol_deposit == 1 ? 'checked' : ''?>>每次</label>
                </div>
                <div class="checkbox">
                    <label class="c_red"><input type="checkbox" value="1"  name="ol_is_give_up" <?php echo $ol_is_give_up == 1 ? 'checked' : ''?>>可放棄優惠[復選]</label>
                </div>
            </td>
            <td colspan="2">
                <div class="radio">
                    <label><input type="radio" value="2" name="line_deposit" <?php echo $line_deposit == 2 ? 'checked' : ''?>>首次</label>
                </div>
                <div class="radio">
                    <label><input type="radio" value="1" name="line_deposit" <?php echo $line_deposit == 1 ? 'checked' : ''?>>每次</label>
                </div>
                <div class="checkbox">
                    <label class="c_red"><input type="checkbox" value="1"  name="line_is_give_up" <?php echo $line_is_give_up == 1 ? 'checked' : ''?>>可放棄優惠[復選]</label>
                </div>
            </td>
        </tr>
        <tr>
            <td class="ter">優惠標準(元):</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="100" name="ol_discount_num" value="<?php echo $ol_discount_num;?>">
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="line_discount_num" value="<?php echo $line_discount_num;?>">
            </td>
        </tr>
        <tr>
            <td class="ter">優惠百分比(%):</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="8.00" name="ol_discount_per" value="<?php echo $ol_discount_per;?>">%
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="line_discount_per" value="<?php echo $line_discount_per;?>">%
            </td>
        </tr>
        <tr>
            <td class="ter">單次最高存款金額:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="500000" name="ol_catm_max" value="<?php echo $ol_catm_max;?>">
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="500000" name="line_catm_max" value="<?php echo $line_catm_max;?>">
            </td>
        </tr>
        <tr>
            <td class="ter">單次最低存款金額:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="ol_catm_min" value="<?php echo $ol_catm_min;?>">
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="100" name="line_catm_min" value="<?php echo $line_catm_min;?>">
            </td>
        </tr>
        <tr>
            <td class="ter">優惠上限金額:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="1000" name="ol_discount_max" value="<?php echo $ol_discount_max;?>">
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="1000" name="line_discount_max" value="<?php echo $line_discount_max;?>">
            </td>
        </tr>
        <tr>
            <td class="ter">常態性稽核:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="100" name="ol_ct_audit" value="<?php echo $ol_ct_audit;?>">%
                <div class="checkbox" style="margin-left:3px;">
                    <label><input type="checkbox" value="1" name="ol_is_ct_audit" <?php echo $ol_is_ct_audit == 1 ? 'checked' : ''?>>開啟,100%是壹倍</label>
                </div>
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="100" name="line_ct_audit" value="<?php echo $line_ct_audit;?>">%
                <div class="checkbox" style="margin-left:3px;">
                    <label><input type="checkbox" value="1" name="line_is_ct_audit" <?php echo $line_is_ct_audit == 1 ? 'checked' : ''?>>開啟,100%是壹倍</label>
                </div>
            </td>
        </tr>
        <tr>
            <td class="ter">常態性稽核放寬額度:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="ol_ct_fk_audit" value="<?php echo $ol_ct_fk_audit;?>">元
                <span class="c_red">建议设置为0.</span>
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="line_ct_fk_audit" value="<?php echo $line_ct_fk_audit;?>">元
                <span class="c_red">建议设置为0.</span>
            </td>
        </tr>
        <tr>
            <td class="ter">常態性稽核行政費率:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="ol_ct_xz_audit" value="<?php echo $ol_ct_xz_audit;?>">%
                <span class="c_red">建议设置为20%以上.</span>
            </td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="10" name="line_ct_xz_audit" value="<?php echo $line_ct_xz_audit;?>">%
                <span class="c_red">建议设置为20%以上.</span>
            </td>
        </tr>
        <tr>
            <td class="ter">第三方入款風控額度:</td>
            <td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="50000" name="online_risk" value="<?php echo $online_risk?>"> <span class="c_red">超過當前金額需要人工確認入款</span>
            </td>
            <td class="tel" colspan="2">
            </td>
        </tr>
        <tr>
            <td colspan="6" class="tec">出款設定</td>
        </tr>
        <tr>
            <td class="ter">出款手續費:</td>
            <td colspan="3" class="tec">達到有效投註額，是否免手續費:
                <div class="radio">
                    <label><input type="radio" value="1" name="is_counter" <?php echo $is_counter == 1 ? 'checked' : ''?>>是</label>
                </div>
                <div class="radio">
                    <label><input type="radio" value="0" name="is_counter" <?php echo $is_counter == 0 ? 'checked' : ''?>>否</label>
                </div>
            </td>
            <td class="tec">当日内免收手續費次數:
                <input type="text" class="form-control" placeholder="100" name="counter_num" value="<?php echo $counter_num;?>">
                出款手續費金額:
                <input type="text" class="form-control" placeholder="100" name="counter_money" value="<?php echo $counter_money;?>">
            </td>
            <td class="tec">
            </td>
        </tr>
        <tr>
            <td class="ter">銀行卡單次出款上限:</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="50000" name="out_max" value="<?php echo $out_max;?>"> <span class="c_red">如果為0則關閉該出款方式</span>
            </td>

            <!--<td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="" name="zfb_max" value="<?php /*echo $zfb_max?$zfb_max:0;*/?>">支付寶單次出款上限, <span class="c_red">如果為0則關閉該出款方式</span>
            </td>-->

        </tr>
        <tr>
            <td class="ter">單次出款下限:</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="100" name="out_min" value="<?php echo $out_min;?>">
            </td>

               <!--<td class="tel" colspan="2">
                <input type="text" class="form-control" placeholder="" name="wx_max" value="<?php /*echo $wx_max?$wx_max:0;*/?>">微信單次出款上限, <span class="c_red">如果為0則關閉該出款方式</span>
            </td>-->

        </tr>
    </table>
</form>

<style>
    /*層級  支付設定*/
    #paySet.table>tbody>tr>td:first-child{
        max-width:150px;
    }

    #levelPay.form-horizontal .radio, #levelPay.form-horizontal .checkbox{
        display: inline-block;
        padding-top:0;
        min-height: auto;
    }

    #levelPay .form-control{
        width:64px;
        display: inline-block;
        padding:0px 2px;
        height:auto;
        margin-right:4px;
    }

    #paySet.table>tbody>tr>td.levelFont{
        max-width:200px;
        padding:12px;
    }

    #paySet.table>tbody>tr>td{
        padding:3px;
        vertical-align: middle;
        height:30px!important;
    }

    #paySet input[type=checkbox],#paySet input[type=radio]{
        margin:2px -18px;
    }
</style>
<script type="text/javascript">
    var _ol_deposit = $('input[name="ol_deposit"]:checked').val();
    if (_ol_deposit != 2 && _ol_deposit != 1) {
        $('input[name="ol_deposit"]').attr('checked', '1');
    }

    var _line_deposit = $('input[name="line_deposit"]:checked').val();
    if (_line_deposit != 2 && _line_deposit != 1) {
        $('input[name="line_deposit"]').attr('checked', '1');
    }
</script>