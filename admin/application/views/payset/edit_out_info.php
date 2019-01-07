<!-- 修改自动出款信息 -->
<style>
    span.combo {height: 30px !important;}
    .combo a {height: 28px !important;}
    .combo input {height: 28px !important;font-size: 14px !important;}
</style>
<form action="payset/edit_online_out_setting" class="form-horizontal validate" method="post" id="pay_revise">
	<table class="table table-bordered" id="pay_table">
        <input type="hidden" name="status" value="<?php echo isset($status) ? $status : 0?>">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0?>">
		<tr>
			<td class="ter">代付平臺:</td>
			<td>
                <input id="pay_type" name="o_id" class="pay_platform easyui-combobox" value="">
			</td>
		</tr>
		<tr>
			<td class="ter">回调域名:</td>
			<td>
				<input type="text" class="form-control" name="out_domain" value="<?php echo $out_domain;?>">
		      	<span class="c_red">*代付域名，需要填寫http</span>
			</td>
		</tr>
		<tr>
			<td class="ter">商戶ID:</td>
			<td>
				<input type="text" class="form-control easyui-validatebox" data-options="required:true" name="out_id" value="<?php echo $out_id;?>">
		      	<span class="c_red">*請輸入商戶id</span>
			</td>
		</tr>
		<tr id="key1" class="even <?php echo in_array(1, $is_box) ? '' : 'hidden';?>">
			<td class="ter un_wechat_pay">商戶密鑰:</td>
			<td>
				<input type="text" class="form-control" name="out_key" value="<?php echo $out_key;?>">
			</td>
		</tr>
		<tr id="key2" class="even <?php echo in_array(2, $is_box) ? '' : 'hidden';?>">
			<td class="ter" >商戶私鑰:</td>
			<td>
				<textarea class="form-control" name="out_private_key" id="private_key" cols="30" rows="10"><?php echo $out_private_key;?></textarea>
				<span class="c_red">*請不要修改格式,"-----BEGIN PRIVATE KEY-----"開頭</span>
			</td>
		</tr>
		<tr id="key3" class="even <?php echo in_array(3, $is_box) ? '' : 'hidden';?>">
			<td class="ter">商戶公鑰:</td>
			<td>
				<textarea class="form-control" name="out_public_key" id="public_key" cols="30" rows="10"><?php echo $out_public_key;?></textarea>
				<span class="c_red">*請不要修改格式</span>
			</td>
		</tr>
		<tr id="key4" class="even <?php echo in_array(4, $is_box) ? '' : 'hidden';?>">
			<td class="ter un_wechat_pay">服務端公鑰:</td>
			<td>
				<textarea class="form-control" name="out_server_key" id="server__key" cols="30" rows="10"><?php echo $out_server_key;?></textarea>
				<span class="c_red un_wechat_pay ">*請不要修改格式,"-----BEGIN PUBLIC KEY-----"開頭</span>
			</td>
		</tr>
		<tr id="key5" class="even <?php echo in_array(5, $is_box) ? '' : 'hidden';?>">
			<td class="ter">終端號:</td>
			<td>
				<input type="text" class="form-control" name="out_server_num" value="<?php echo $out_server_num;?>" id="terminal">
		      	<span class="c_red">*請不要修改格式</span>
			</td>
		</tr>
        <tr>
            <td class="ter">数据签名盐值:</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="out_secret" id="pay_limit" value="<?php echo $out_secret;?>">
                <span class="c_red">*签名盐值</span>
            </td>
        </tr>
        <tr>
			<td class="ter">最大限制金额:</td>
			<td>
				<input type="text" class="form-control" placeholder="" name="max_amount"  value="<?php echo $max_amount;?>" maxlength="11">
		      	<span class="c_red">*代付最大限制金额</span>
			</td>
		</tr>
		<tr>
			<td class="ter">最小限制金额:</td>
			<td>
				<input type="text" class="form-control" placeholder="" name="min_amount"  value="<?php echo $min_amount;?>" maxlength="11">
		      	<span class="c_red">*代付最小限制金额</span>
			</td>
		</tr>
		<tr class="hidden">
			<td class="ter">代付总限额:</td>
			<td>
				<input type="text" class="form-control" placeholder="" name="total_amount" id="pay_limit" value="<?php echo $total_amount;?>" maxlength="11">
		      	<span class="c_red">*到達出款限額自動停用</span>
			</td>
		</tr>
	</table>
</form>
<script>
    var pay_data = [<?php foreach ($platform as $k => $v){?>{'show_type':"<?=$v['is_box']?>",'id':"<?=$v['id']?>",'out_online_name':"<?=$v['out_online_name']?>"<?php if ($v['id']==$o_id)echo ',"selected":true'?>}<?php if ($k<count($platform)-1){echo ',';}}?>];
    $("#pay_type").combobox({
        valueField: 'id',
        textField: 'out_online_name',
        data:pay_data,
        onSelect: function (record) {
            pay_show.init();
            pay_show.show(record);
            pay_describe.init();
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