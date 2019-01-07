<!-- 修改支付信息 -->
<style>
    span.combo {height: 30px !important;}
    .combo a {height: 28px !important;}
    .combo input {height: 28px !important;font-size: 14px !important;}
</style>
<form action="payset/edit_online_pay_setting" class="form-horizontal validate" method="post" id="pay_revise">
	<table class="table table-bordered" id="pay_table">
        <input type="hidden" name="status" value="<?php echo isset($status) ? $status : 0?>">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0?>">
		<tr>
			<td class="ter">支付平臺:</td>
			<td>
                <input id="pay_type" name="bank_o_id" class="pay_platform easyui-combobox" value="">
			</td>
		</tr>
		<tr>
			<td class="ter">是否為點卡:</td>
			<td>
				<select class="form-control point_card" name="is_card">
		      		<option value="1" <?php echo $is_card == 1 ? : 'selected'?>>是</option>
                    <option value="0" <?php echo $is_card == 1 ? : 'selected'?>>否</option>
		      	</select>
		      	<span class="c_red">*默認為否</span>
			</td>
		</tr>
		<tr>
			<td class="ter">支付域名:</td>
			<td>
				<input type="text" class="form-control" name="pay_domain" value="<?php echo $pay_domain;?>">
		      	<span class="c_red">*支付域名，需要填寫http</span>
			</td>
		</tr>
		<tr>
			<td class="ter">返回地址:</td>
			<td>
				<input type="text" class="form-control" name="pay_return_url" value="<?php echo $pay_return_url;?>">
		      	<span class="c_red">*充值成功返回的地址，需要填寫http</span>
			</td>
		</tr>
		<tr>
			<td class="ter">支付网关:</td>
			<td>
				<input type="text" class="form-control easyui-validatebox" data-options="required:true" name="shopurl" value="<?php echo $shopurl;?>">
		      	<span class="c_red">*第三方支付网关地址,需要填寫http</span>
			</td>
		</tr>

		<tr>
			<td class="ter">商戶ID:</td>
			<td>
				<input type="text" class="form-control easyui-validatebox" data-options="required:true" name="pay_id" value="<?php echo $pay_id;?>">
		      	<span class="c_red">*請輸入商戶id</span>
			</td>
		</tr>
		<tr id="key1" class="even <?php echo in_array(1, $is_box) ? '' : 'hidden';?>">
			<td class="ter un_wechat_pay <?php echo $bank_o_id == 83 ? 'hidden' : ''?>">商戶密鑰:</td>
			<td class="ter wechat_pay <?php echo $bank_o_id != 83 ? 'hidden' : ''?>">微信APPID:</td>
			<td>
				<input type="text" class="form-control" name="pay_key" value="<?php echo $pay_key;?>">
		      	<span class="c_red un_wechat_pay <?php echo $bank_o_id == 83 ? 'hidden' : ''?>">*選擇智付跟銀邦時自動隱藏</span>
			</td>
		</tr>
		<tr id="key2" class="even <?php echo in_array(2, $is_box) ? '' : 'hidden';?>">
			<td class="ter" >商戶私鑰:</td>
			<td>
				<textarea class="form-control" name="pay_private_key" id="private_key" cols="30" rows="10"><?php echo $pay_private_key;?></textarea>
				<span class="c_red">*請不要修改格式,"-----BEGIN PRIVATE KEY-----"開頭</span>
			</td>
		</tr>
		<tr id="key3" class="even <?php echo in_array(3, $is_box) ? '' : 'hidden';?>">
			<td class="ter">商戶公鑰:</td>
			<td>
				<textarea class="form-control" name="pay_public_key" id="public_key" cols="30" rows="10"><?php echo $pay_public_key;?></textarea>
				<span class="c_red">*請不要修改格式</span>
			</td>
		</tr>
		<tr id="key4" class="even <?php echo in_array(4, $is_box) ? '' : 'hidden';?>">
			<td class="ter un_wechat_pay <?php echo $bank_o_id == 83 ? 'hidden' : ''?>">服務端公鑰:</td>
            <td class="ter wechat_pay <?php echo $bank_o_id != 83 ? 'hidden' : ''?>">微信密鑰:</td>
			<td>
				<textarea class="form-control" name="pay_server_key" id="server__key" cols="30" rows="10"><?php echo $pay_server_key;?></textarea>
				<span class="c_red un_wechat_pay <?php echo $bank_o_id == 83 ? 'hidden' : ''?>">*請不要修改格式,"-----BEGIN PUBLIC KEY-----"開頭</span>
			</td>
		</tr>
		<tr id="key5" class="even <?php echo in_array(5, $is_box) ? '' : 'hidden';?>">
			<td class="ter">終端號:</td>
			<td>
				<input type="text" class="form-control" name="pay_server_num" value="<?php echo $pay_server_num;?>" id="terminal">
		      	<span class="c_red">*請不要修改格式</span>
			</td>
		</tr>
		<tr>
			<td class="ter">支付限額:</td>
			<td>
				<input type="text" class="form-control" placeholder="" name="max_amount" id="pay_limit" value="<?php echo $max_amount;?>" maxlength="11">
		      	<span class="c_red">*到達支付限額自動停用</span>
			</td>
		</tr>
        <tr>
            <td class="ter">最小限制金额:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="min_limit_price"  value="<?php echo $min_limit_price;?>" maxlength="11">
                <span class="c_red">*支付最小限制金额</span>
            </td>
        </tr>
        <tr>
            <td class="ter">最大限制金额:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="max_limit_price"  value="<?php echo $max_limit_price;?>" maxlength="11">
                <span class="c_red">*支付最大限制金额</span>
            </td>
        </tr>
        <tr class="describe <?php echo $is_describe ? '' : 'hidden';?>">
            <td class="ter">第三方標題:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="title" value="<?php echo $title;?>">
                <span class="c_red">*第三方顯示標題</span>
            </td>
        </tr>
        <tr class="describe <?php echo  $is_describe ? '' : 'hidden';?>">
            <td class="ter">第三方小字提示:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="prompt" value="<?php echo $prompt;?>">
                <span class="c_red">*第三方顯示小字提示</span>
            </td>
        </tr>
        <tr class="describe <?php echo  $is_describe ? '' : 'hidden';?>">
            <td class="ter">排序权重:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="re_order" value="<?php echo $re_order;?>">
                <span class="c_red">*排序越大前端显示越靠前</span>
            </td>
        </tr>
        <!--<tr class="describe2 <?php /*echo  $is_zfb ? '' : 'hidden';*/?>">
            <td class="ter">支付寶標題:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="zfb_title" value="<?php /*echo $zfb_title;*/?>">
                <span class="c_red">*支付寶app顯示小字提示</span>
            </td>
        </tr>
        <tr class="describe2 <?php /*echo  $is_zfb ? '' : 'hidden';*/?>">
            <td class="ter">支付寶小字提示:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="zfb_Prompt" value="<?php /*echo $zfb_Prompt;*/?>">
                <span class="c_red">*支付寶app顯示小字提示</span>
            </td>
        </tr>-->
	</table>
</form>
<script>
    var pay_data = [<?php foreach ($platform as $k => $v){?>{'show_type':"<?=$v['is_box']?>",'id':"<?=$v['id']?>",'pay_code':"<?=$v['pay_code']?>",'online_bank_name':"<?=$v['online_bank_name']?>"<?php if (isset($bank_o_id)&&$bank_o_id==$v['id'])echo ',"selected":true'?>}<?php if ($k<count($platform)-1){echo ',';}}?>];
    $("#pay_type").combobox({
        valueField: 'id',
        textField: 'online_bank_name',
        data:pay_data,
        onSelect: function (record) {
            pay_show.init();
            pay_show.show(record);
            pay_describe.init();
            pay_describe.show(record);
        }
    });

    var pay_show  = {
        init : function () {
            $('.even').addClass('hidden');
        },
        show : function (data) {
            var _show_type;
            var show_type = data.show_type;
            var id = data.id;
            _show_type = show_type.split(',');
            _show_type.forEach(function (v) {
                _id = '#key' + v;
                $(_id).removeClass('hidden');
            });
            if (id == 83) {
                $('.wechat_pay').removeClass('hidden');
                $('.un_wechat_pay').addClass('hidden');
            } else {
                $('.un_wechat_pay').removeClass('hidden');
                $('.wechat_pay').addClass('hidden');
            }
        }
    };

    var pay_describe = {
        init : function () {
            $('.describe').addClass('hidden');
        },
        show : function (data) {
            var pay_code = data.pay_code;
            var _pay_code = pay_code.split(',');
            _pay_code.forEach(function (v) {
                if (v != 7) {
                    $('.describe').removeClass('hidden');
                }
            });
        }
    };
</script>