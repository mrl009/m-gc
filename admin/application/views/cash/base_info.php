<form action="#" class="form-horizontal" role="form" method="post">
    <div class="tab-content">
        <div class="tab-pane active"><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">真实姓名:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control copy-bank-name" value="<?php echo $rs['bank_name'] ?>"
                           name="bank_name" readonly
                           onclick="copy('.copy-bank-name')" data-clipboard-action="copy"
                           data-clipboard-target=".copy-bank-name"
                    >
                </div>
                <label class="col-sm-2 control-label">取款银行:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control copy-bank-id" value="<?php echo $bank ?>" name="bank_id"
                           readonly
                           onclick="copy('.copy-bank-id')" data-clipboard-action="copy"
                           data-clipboard-target=".copy-bank-id"
                    >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">收款账号:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control copy-bank-num" value="<?php echo $bank_num ?>"
                           name="bank_num" readonly
                           onclick="copy('.copy-bank-num')" data-clipboard-action="copy"
                           data-clipboard-target=".copy-bank-num"
                    >
                </div>

                <label class="col-sm-2 control-label">开户行地址:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control copy-address" value="<?php echo $address ?>" name="address"
                           readonly
                           onclick="copy('.copy-address')" data-clipboard-action="copy"
                           data-clipboard-target=".copy-address"
                    >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">出款金额:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control copy-actual-price" value="<?php echo $actual_price ?>"
                           name="actual_price" readonly
                           onclick="copy('.copy-actual-price')" data-clipboard-action="copy"
                           data-clipboard-target=".copy-actual-price"
                    >
                </div>

                <label class="col-sm-2 control-label <?php echo $qrcode ? '' : 'hidden'; ?>">收款二维码:</label>
                <div class="col-sm-3 <?php echo $qrcode ? '' : 'hidden'; ?>">
                    <img src="<?php echo $qrcode; ?>" style="width:100px;height: 100px;"
                         class="<?php echo $qrcode ? '' : 'hidden'; ?>">
                </div>
            </div>
            <div class="form-group">
                <span class="col-sm-4"></span>
                <span style="margin-left:40px;" class="btn btn-success btn-sm"
                      onclick="payment_edit(<?php echo $id ?>)">确认出款</span>
                <span class="btn btn-info btn-sm" onclick="payment_cancel(<?php echo $id ?>)">取消出款</span>
                <span class="btn btn-warning btn-sm" onclick="payment_refuse(<?php echo $id ?>)">拒绝出款</span>
            </div>
        </div>
    </div>
</form>
<script type="application/javascript">
    function copy(obj) {
        Core.copy(obj)
    }

    // 确认
    function payment_edit(id) {
        $.messager.confirm('温馨提示', '确定要出款吗？', function (r) {
            if (r) {
                $.ajax({
                    url: WEB + 'cash/ajax_company_do',
                    data: {
                        id: id,
                        status: 2
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.ok(data.msg);
                        if (data.code == 200) {
                            $('#modal').modal('hide');
                            $('#<?php echo $form_id?>').datagrid('reload');
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        Core.error('異常'+XMLHttpRequest.status+' '+textStatus);
                    }
                });
            }
        });
    }

    // 取消
    function payment_cancel(id) {
        $('#modal').modal('hide');
        $(".modal-backdrop").remove();
        Core.dialog('取消备注(不超过100个字)', 'cash/payment_cancel?status=5&id='+id, function () {
            $.ajax({
                url: WEB + 'cash/ajax_company_do',
                data: {
                    id: id,
                    status: 5,
                    remark: $("#remark").val()
                },
                type: 'post',
                cache: false,
                dataType: 'json',
                success: function (data) {
                    Core.ok(data.msg);
                    $('#modal').modal('hide');
                    $('#<?php echo $form_id?>').datagrid('reload');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Core.error('異常'+XMLHttpRequest.status+' '+textStatus);
                }
            });

        }, true, false);
    }

    // 拒绝
    function payment_refuse(id) {
        $('#modal').modal('hide');
        $(".modal-backdrop").remove();
        Core.dialog('拒绝备注(不超过100个字)', 'cash/payment_cancel?status=3&id='+id, function () {
            $.ajax({
                url: WEB + 'cash/ajax_company_do',
                data: {
                    id: id,
                    status: 3,
                    remark: $("#remark").val()
                },
                type: 'post',
                cache: false,
                dataType: 'json',
                success: function (data) {
                    Core.ok(data.msg);
                    $('#modal').modal('hide');
                    $('#<?php echo $form_id?>').datagrid('reload');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Core.error('異常'+XMLHttpRequest.status+' '+textStatus);
                }
            });
        }, true, false);
    }
</script>