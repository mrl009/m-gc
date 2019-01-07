<!-- 基本资料设定 -->
<form action="level/save" class="form-horizontal validate" role="form" method="post" id="levelForm">
    <input name="id" type="hidden" value="<?php echo isset($id) ? $id : '';?>">
    <table class="table table-bordered info_set">
        <tr>
            <td class="first_line" >公司账户</td>
            <td colspan="18">
                <?php foreach ($bank as $v){?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="<?php echo $v['id']?>" name="bank_id[]" <?php echo $v['is_checked'] == 1 ? 'checked' : '';?>>
                            <?php echo $v['card_num'].'('.$v['card_username'].')';?>
                        </label>
                    </div>
                <?php }?>
            </td>
        </tr>
        <?php $count = 1;foreach ($online as $k => $v){?>
        <tr>
            <?php if ($count == 1){?>
            <td class="first_line" rowspan="<?php echo count($online);?>">第三方支付:</td>
            <?php }?>
            <td class="tdr"><?php echo $v['name']. 'ID:'. $k;?></td>
            <td>
                <div class="tdw">
                    <?php if (isset($v[1])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>1" name="online_id[]" <?php echo $v[1]['check'] == 1 ? 'checked' : '';?>>微信扫码支付(web跳转)</label>
                    <?php }?>
                </div>
        
                <div class="tdw">
                    <?php if (isset($v[2])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>2" name="online_id[]" <?php echo $v[2]['check'] == 1 ? 'checked' : '';?>>微信WAP</label>
                    <?php }?>
                </div>
     
                <div class="tdw">
                    <?php if (isset($v[33])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>33" name="online_id[]" <?php echo $v[33]['check'] == 1 ? 'checked' : '';?>>微信公众号二维码</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[34])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>34" name="online_id[]" <?php echo $v[34]['check'] == 1 ? 'checked' : '';?>>微信公众号WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[40])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>40" name="online_id[]" <?php echo $v[40]['check'] == 1 ? 'checked' : '';?>>微信条形码</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[8])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>8" name="online_id[]" <?php echo $v[8]['check'] == 1 ? 'checked' : '';?>>QQ钱包扫码支付(web跳转)</label>
                    <?php }?>
                </div>
        
                <div class="tdw">
                    <?php if (isset($v[12])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>12" name="online_id[]" name="online_id[]" <?php echo $v[12]['check'] == 1 ? 'checked' : '';?>>QQ钱包WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[16])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>16" name="online_id[]" name="online_id[]" <?php echo $v[16]['check'] == 1 ? 'checked' : '';?>>QQ钱包公众号二维码</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[28])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>28" name="online_id[]" name="online_id[]" <?php echo $v[28]['check'] == 1 ? 'checked' : '';?>>QQ钱包公众号WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[22])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>22" name="online_id[]" name="online_id[]" <?php echo $v[22]['check'] == 1 ? 'checked' : '';?>>财付通扫码支付(web跳转)</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[23])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>23" name="online_id[]" name="online_id[]" <?php echo $v[23]['check'] == 1 ? 'checked' : '';?>>财付通WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[24])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>24" name="online_id[]" name="online_id[]" <?php echo $v[24]['check'] == 1 ? 'checked' : '';?>>财付通公众号二维码</label>
                    <?php }?>
                </div>
            </td>
            <td>
                <div class="tdw">
                    <?php if (isset($v[4])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>4" name="online_id[]" <?php echo $v[4]['check'] == 1 ? 'checked' : '';?>>支付宝扫码支付(web跳转)</label>
                    <?php }?>
                </div>
         
                <div class="tdw">
                    <?php if (isset($v[5])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>5" name="online_id[]" <?php echo $v[5]['check'] == 1 ? 'checked' : '';?>>支付宝WAP</label>
                    <?php }?>
                </div>
          
                <div class="tdw">
                    <?php if (isset($v[36])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>36" name="online_id[]" <?php echo $v[36]['check'] == 1 ? 'checked' : '';?>>支付宝公众号二维码</label>
                    <?php }?>
                </div>

                <div class="tdw">
                    <?php if (isset($v[37])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>37" name="online_id[]" <?php echo $v[37]['check'] == 1 ? 'checked' : '';?>>支付宝公众号WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[41])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>41" name="online_id[]" <?php echo $v[41]['check'] == 1 ? 'checked' : '';?>>支付宝条形码</label>
                    <?php }?>
                </div>
            </td>
            <td>
                <div class="tdw">
                    <?php if (isset($v[7])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>7" name="online_id[]" <?php echo $v[7]['check'] == 1 ? 'checked' : '';?>>网银支付</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[27])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>27" name="online_id[]" <?php echo $v[27]['check'] == 1 ? 'checked' : '';?>>网银wap</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[25])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>25" name="online_id[]" <?php echo $v[25]['check'] == 1 ? 'checked' : '';?>>快捷支付/信用卡(web跳转)</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[26])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>26" name="online_id[]" <?php echo $v[26]['check'] == 1 ? 'checked' : '';?>>收银台/聚合付(web跳转)</label>
                    <?php }?>
                </div>
            </td>
            <td>
                <div class="tdw">
                    <?php if (isset($v[9])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>9" name="online_id[]" <?php echo $v[9]['check'] == 1 ? 'checked' : '';?>>京东钱包扫码支付(web跳转)</label>
                    <?php }?>
                </div>
          
                <div class="tdw">
                    <?php if (isset($v[13])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>13" name="online_id[]" name="online_id[]" <?php echo $v[13]['check'] == 1 ? 'checked' : '';?>>京东钱包WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[15])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>15" name="online_id[]" name="online_id[]" <?php echo $v[15]['check'] == 1 ? 'checked' : '';?>>京东钱包公众号二维码</label>
                    <?php }?>
                </div>
  
                <div class="tdw">
                    <?php if (isset($v[17])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>17" name="online_id[]" name="online_id[]" <?php echo $v[17]['check'] == 1 ? 'checked' : '';?>>云闪付/银联钱包扫码支付(web跳转)</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[18])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>18" name="online_id[]" name="online_id[]" <?php echo $v[18]['check'] == 1 ? 'checked' : '';?>>云闪付/银联钱包WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[19])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>19" name="online_id[]" name="online_id[]" <?php echo $v[19]['check'] == 1 ? 'checked' : '';?>>云闪付/银联钱包公众号二维码</label>
                    <?php }?>
                </div>

                <div class="tdw">
                    <?php if (isset($v[10])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>10" name="online_id[]" name="online_id[]" <?php echo $v[10]['check'] == 1 ? 'checked' : '';?>>百度钱包扫码支付(web跳转)</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[20])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>20" name="online_id[]" name="online_id[]" <?php echo $v[20]['check'] == 1 ? 'checked' : '';?>>百度钱包WAP</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[21])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>21" name="online_id[]" name="online_id[]" <?php echo $v[21]['check'] == 1 ? 'checked' : '';?>>百度钱包公众号二维码</label>
                    <?php }?>
                </div>
                <div class="tdw">
                    <?php if (isset($v[38])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>38" name="online_id[]" <?php echo $v[38]['check'] == 1 ? 'checked' : '';?>>苏宁钱包扫码支付(web跳转)</label>
                    <?php }?>
                </div>

                <div class="tdw">
                    <?php if (isset($v[39])) {?>
                        <label><input type="checkbox" value="<?php echo $k. '-'?>39" name="online_id[]" name="online_id[]" <?php echo $v[39]['check'] == 1 ? 'checked' : '';?>>苏宁钱包WAP</label>
                    <?php }?>
                </div>
            </td>
        </tr>
        <?php ++$count;}?>
        <tr>
            <td class="first_line" >支付配置：</td>
            <td colspan="18">
                <select class="form-control paySet" name="pay_id">
                    <?php foreach ($pay_move as $v){?>
                        <option value="<?php echo $v['id'];?>" <?php echo $v['is_check'] == 1 ? 'selected' : '';?>><?php echo $v['pay_name'];?></option>
                    <?php }?>
                </select>
                <span class="c_red">&nbsp;&nbsp;*必选一个支付设定</span>
            </td>
        </tr>
        <tr>
            <td class="first_line" >层级ID：</td>
            <td colspan="18">
                <label>
                    <span style="width:130px;height:auto;display: inline-block;"><?php echo $id;?></span>
                    <span class="c_red">&nbsp;&nbsp;*固定编号不能修改，自增level</span>
                </label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >层级名称：</td>
            <td colspan="18">
                <label>
                    <input style="width: 130px;" type="text" name="level_name" value="<?php echo $level_name;?>"
                           validType="filterSpecial" invalidMessage="请勿使用特殊字符" class="easyui-validatebox" data-options="required:true">
                    <span class="c_red">&nbsp;&nbsp;*必填请勿使用特殊字符</span>
                </label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >存款次数：</td>
            <td colspan="18">
                <label><input type="number" name="total_num" value="<?php echo $total_num;?>">&nbsp;&nbsp;<span class="c_red">*该层级单个会员总存款次数(达到存款次数的会员才能加入),0无限制</span></label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >存款总额：</td>
            <td colspan="18">
                <label><input type="number" name="total_deposit" value="<?php echo $total_deposit;?>">&nbsp;&nbsp;<span class="c_red">*该层级单个会员总存款金额(达到存款总额的会员才能加入),0无限制</span></label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >备注：</td>
            <td colspan="18">
                <label><input type="text" name="remark" value="<?php echo $remark;?>"></label>
            </td>
        </tr>
    </table>
</form>
<style>
/*    .tdw{
        width: 70px;
    }*/
    .first_line{
        width: 80px!important;
    }
    .modal-dialog{
        width: 95%!important;
    }
</style>
