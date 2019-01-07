<!-- 修改銀行卡 -->
<form action="payset/save_bank" class="form-horizontal validate" role="form" method="post" id="bank_revise">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''?>">
    <div class="form-group">
        <label class="col-sm-3 control-label">銀行名稱:</label>
        <div class="col-sm-6 pt7">
            <select class="form-control bank_id" name="bank_id">
                <?php foreach ($platform as $v){?>
                    <option qr_code="<?php echo $v['is_qcode'] == 1 ? 'qr_code' : '';?>" value="<?php echo $v['id'];?>"
                        <?php echo $bank_id == $v['id'] ? 'selected' : ''?>><?php echo $v['bank_name'];?></option>
                <?php }?>
            </select>
        </div>
        <label id="promptData" class="btn btn-green c_red <?php echo $is_qcode == 1 ? 'hidden' : '';?>" onclick="promptData()" style="margin-top: 0.4rem;">放到支付寶</label>
    </div>
    <div id="qr_code" class="form-group <?php echo $is_qcode != 1 ? 'hidden' : '';?>">
        <label  class="col-sm-3 control-label">支付二維碼:</label>
        <div class="col-sm-6">
            <div class="panel panel-default" data-collapsed="0" style="">
                <div class="panel-heading" style="padding:0;width:134px;height:28px;">
                    <div class="panel-title">
                        <button class="btn label label-success" id="logo_uploadBtn"><i class="entypo-upload"></i> 上傳支付二維碼</button>
                    </div>
                </div>
                <div class="panel-body <?php echo $qrcode ? '' : 'hidden';?>" style="height: 100px;">
                    <img <?php if($qrcode) echo "src='$qrcode'"?> class="qrcode_thumb img-rounded logo_thumb" style="width:50%;height: 100px;">
                    <input type="hidden" name="qrcode" value="<?php echo $qrcode;?>">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group app_described <?php echo empty($is_qcode) ? 'hidden' : '';?>">
        <label  class="col-sm-3 control-label">APP支付標題:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control shroff_account" value="<?php echo $title ? $title : '';?>" name="title">
        </div>
    </div>
    <div class="form-group app_described <?php echo empty($is_qcode) ? 'hidden' : '';?>">
        <label  class="col-sm-3 control-label">APP支付小字提示:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control shroff_account" value="<?php echo $prompt ? $prompt : '';?>" name="prompt">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">收款賬號:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control shroff_account" value="<?php echo $card_num;?>" name="card_num">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">開戶行:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control opening_bank easyui-validatebox" data-options="required:true" name="card_address" value="<?php echo $card_address;?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">收款人:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" name="card_username" value="<?php echo $card_username;?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">停用金額:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" name="max_amount" value="<?php echo $max_amount;?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">排序权重:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control easyui-validatebox" data-options="required:true" name="re_order" value="<?php echo $re_order;?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">狀態:</label>
        <div class="col-sm-6 status pt7">
            <label><input type="radio" value="1" name="status" class="" <?php echo $status == 1 ? 'checked' : ''?>>&nbsp;啟用&nbsp;</label>
            <label><input type="radio" value="2" name="status" class="" <?php echo $status == 2 ? 'checked' : ''?>>&nbsp;停用</label>
        </div>
    </div>
    <!--<div id="is_confirm" class="form-group <?php /*echo $is_qcode != 1 ? 'hidden' : '';*/?>">
        <label  class="col-sm-3 control-label">是否需要商戶訂單號:</label>
        <div class="col-sm-6 status pt7">
            <label><input type="radio" value="1" name="is_confirm" class="" <?php /*echo $is_confirm == 1 ? 'checked' : ''*/?>>&nbsp;是&nbsp;</label>
            <label><input type="radio" value="0" name="is_confirm" class="" <?php /*echo $is_confirm == 0 ? 'checked' : ''*/?>>&nbsp;否</label>
        </div>
    </div>-->
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">備註:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputEmail3" value="<?php echo $remark;?>" name="remark">
        </div>
    </div>
</form>
<script>
    var _status = $('input[name="status"]:checked').val();
    if (_status != 1 && _status != 2) {
        $('input[name="status"]').attr('checked', '1');
    }
    $('#max_amount').numberbox({
        min:0,
        precision:2
    });

    $('.bank_id').change(function () {
        var qr_code = $(".bank_id").find("option:selected").attr("qr_code");
        if (qr_code == 'qr_code') {
            $('#qr_code').removeClass('hidden');
            $('#is_confirm').removeClass('hidden');
            $('.app_described').removeClass('hidden');
            $('#promptData').addClass('hidden');
        } else {
            $('#qr_code').addClass('hidden');
            $('#promptData').removeClass('hidden');
            $('#is_confirm').addClass('hidden');
            $('.app_described').addClass('hidden');
        }
    });

    /**第三方支付增加二維碼上傳*/
    Core.singleUploader('logo_uploadBtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.logo_thumb').attr('src',rs.result);
        $('[name=qrcode]').val(rs.result);
        $('.panel-body').removeClass('hidden');
    });
    /**銀行卡額外信息*/
    function promptData() {
        var _ = $('.app_described');
        if (_.hasClass('hidden')) {
            _.removeClass('hidden')
        } else {
            _.addClass('hidden')
            var e = _.find('input')
            $.each(e, function (i, d) {
                $(d).val('')
            })
        }
    }
</script>
