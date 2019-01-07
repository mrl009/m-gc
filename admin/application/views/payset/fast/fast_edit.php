<!-- 修改銀行卡 -->
<style>
.numberbox, .numberbox .textbox-text
{
    width: 200px !important;
    height: 26px !important;
    line-height: 26px;
    padding-left: 6px !important;
    border-radius: 0 !important;
    font-size: 14px;
    margin-right: 4px; 
}
</style>
<form action="pay/fast/fast_save" class="form-horizontal validate" role="form" method="post" id="pay_revise">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''?>">
    <table class="table table-bordered" id="pay_table">
        <tr>
            <td class="ter">平臺名稱:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="platform_name" data-options="required:true"
                value="<?php echo $platform_name;?>">
            </td>
        </tr>
        <tr>
            <td class="ter">回調域名:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="pay_domain" data-options="required:true" 
                value="<?php echo $pay_domain;?>">
                <span class="c_red">*發起支付和回調域名,以http開頭</span>
            </td>
        </tr>
        <tr>
            <td class="ter">支付網關:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="pay_gateway" data-options="required:true"
                value="<?php echo $pay_gateway;?>">
                <span class="c_red">*接入方支付網關地址,以http開頭</span>
            </td>
        </tr>
        <!-- 添加信息時 不顯示內容 -->
        <?php if(!empty($merch)){ ?>
        <tr>
            <td class="ter">商戶號:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="merch" data-options="required:true"
                value="<?php echo $merch;?>" disabled>
                <span class="c_red">*由系統生成,不得修改</span>
            </td>
        </tr>
        <tr>
            <td class="ter">商戶秘鑰:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="pay_key" data-options="required:true"
                value="<?php echo $pay_key;?>" disabled>
                <span class="c_red">*由系統生成,不得修改</span>
            </td>
        </tr>
        <tr>
            <td class="ter">商戶公鑰:</td>
            <td>
                <textarea class="form-control" cols="30" rows="10" data-options="required:true" name="pay_public_key" disabled><?php echo $pay_public_key;?> </textarea><br >
                <span class="c_red">*由系統生成,不得修改</span>
            </td>
        </tr>
        <?php }?>
        <!-- <tr>
            <td class="ter">服務端公鑰:</td>
            <td>
                <textarea class="form-control" cols="30" rows="10" 
                name="pay_server_key"><?php echo $pay_server_key;?></textarea><br >
                <span class="c_red">*由接入方提供,和接入方保持一致</span>
            </td>
        </tr> -->
        <!-- IP白名單 -->
        <tr>
            <td class="ter">白名單IP:</td>
            <td>
                <textarea class="form-control" cols="30" rows="10" 
                name="validate_ip"><?php echo $validate_ip;?></textarea><br >
                <span class="c_red">
                    *多個IP使用逗號隔開,如：127.0.0.1, 192.168.2.1<br >
                    *不設置白名單IP,本系統將不能正常回調,無法自動上分
                </span>
            </td>
        </tr>
        <!-- 設置固定金額 -->
        <tr>
            <td class="ter">國定金額:</td>
            <td>
                <textarea class="form-control" cols="30" rows="10" 
                name="fixed_amount"><?php echo $fixed_amount;?></textarea><br >
                <span class="c_red">
                    *多個國定金額使用逗號隔開,如：10,50,100,300,500<br >
                    *當設置固定金額時,使用小數設置將不再生效<br >
                    *當設置固定金額時,充值金額不在設定值中,將不能充值
                </span>
            </td>
        </tr>
        <tr>
            <td class="ter">支付方式:</td>
            <td>
                <label><input type="checkbox" value="1" name="pay_code[]" checked disabled>&nbsp;微信&nbsp;</label>
                <label><input type="checkbox" value="4" name="pay_code[]" checked disabled>&nbsp;支付寶&nbsp;</label>
                <label><input type="checkbox" value="7" name="pay_code[]" checked disabled>&nbsp;銀行卡&nbsp;</label><br >
                <span class="c_red">
                    *前端不展示支付方式,實際支付方式以接入方為準
                </span>
            </td>
        </tr>  
        <tr>
            <td class="ter">使用小數:</td>
            <td>
                <label><input type="radio" value="1" name="is_use_decimal" 
                    <?php echo (empty($is_use_decimal) || (1 == $is_use_decimal)) ? 'checked' : '';?>>
                &nbsp;是&nbsp;</label>
                <label><input type="radio" value="2" name="is_use_decimal" 
                    <?php echo (2 == $is_use_decimal) ? 'checked' : '';?>>
                &nbsp;否&nbsp;</label><br >
                <span class="c_red">
                    *為減少風控,本系統默認使用2位小數的金額進行充值<br >
                    *默認在充值金額基礎上隨機增加 0.01 - 0.99<br >
                    *當設定固定金額時,本設置無效,以固定金額為主
                </span>
            </td>
        </tr>
        <tr>
            <td class="ter">接入方提示標題:</td>
            <td>
                <input class="form-control" name="title" 
                value="<?php echo $title;?>">
                <span class="c_red">*接入方顯示標題</span>
            </td>
        </tr>
        <tr>
            <td class="ter">接入方提示备注:</td>
            <td>
                <input class="form-control" name="prompt" 
                value="<?php echo $prompt;?>">
                <span class="c_red">*接入方顯示顯示小字提示</span>
            </td>
        </tr>
        <tr>
            <td class="ter">最低金額:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="min_amount" value="<?php echo $min_amount;?>">
                <span class="c_red">*單次充值允許最低金額,最低1元</span>
            </td>
        </tr>
        <tr>
            <td class="ter">最高金額:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="max_amount" value="<?php echo $max_amount;?>">
                <span class="c_red">*單次充值允許最高金額,最高50000元</span>
            </td>
        </tr>
        <tr>
            <td class="ter">支付限額:</td>
            <td>
                <input class="form-control easyui-validatebox" 
                name="block_amount" value="<?php echo $block_amount;?>">
                <span class="c_red">*累計充值限額,到達該限額自動停用</span>
            </td>
        </tr>
        <tr>
            <td class="ter">排序权重:</td>  
            <td>
                <input class="form-control easyui-validatebox" name="re_order" 
                value="<?php echo isset($re_order) ? $re_order : 0;?>">
                <span class="c_red">*排序越大前端显示越靠前</span>
            </td>
        </tr>
    </table>
</form>
<script>
$("[name=min_amount]").numberbox({min:1});
$("[name=max_amount]").numberbox({min:1,max:50000});
$("[name=block_amount]").numberbox({min:0});
$("[name=re_order]").numberbox({min:0});
</script>