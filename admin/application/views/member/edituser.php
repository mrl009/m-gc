<?php $id = uniqid(); ?>
<form action="member/save_member" class="form-horizontal validate" role="form" method="post">
    <input type="hidden" name="id" value="<?php echo $rs['id'] ?>">
    <ul class="nav nav-tabs bordered" style="margin-top:0;padding-top:0" id="goods_tab">
        <li><a href="#member-basic" data-toggle="tab"><span class="hidden-xs">基本信息</span></a></li>
        <li class="active"><a href="#bank" data-toggle="tab"><span class="hidden-xs">設置銀行資料</span></a></li>
        <li><a href="#count" data-toggle="tab" class="memberItem" type="count"><span>會員統計資料</span></a></li>
        <li><a href="#cash_list" data-toggle="tab" class="memberItem" type="cash_list"><span
                        class="hidden-xs">現金記錄</span></a></li>
        <li><a href="#order" data-toggle="tab" class="memberItem" type="order"><span class="hidden-xs">投註列表</span></a>
        </li>
        <li><a href="#log" data-toggle="tab" class="memberItem" type="log"><span class="hidden-xs">日誌列表</span></a></li>
        <li><a href="#audit" data-toggle="tab" class="memberItem" type="audit"><span class="hidden-xs">稽核查詢</span></a>
        </li>
        <li><a href="#payment_list" data-toggle="tab" class="memberItem" type="payment_list"><span class="hidden-xs">出款記錄</span></a>
        </li>
        <li><a href="#payment" data-toggle="tab" class="memberItem <?php echo $is_actual ? '' : 'hidden' ?>"
               type="payment"><span class="hidden-xs">出款管理</span></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="member-basic"><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">賬號:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['username'] ?>" disabled>
                </div>
                <label class="col-sm-2 control-label">出生日期:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control easyui-datebox" value="<?php if ($rs['birthday']) {
                        echo date('Y-m-d', $rs['birthday']);
                    } ?>" name="birthday" style="width:220px;height: 35px">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">昵稱:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['nickname'] ?>" disabled>
                </div>
                <label class="col-sm-2 control-label">性別:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['sex'] ?>" disabled>
                </div>
            </div> 
            <div class="form-group">
                <label class="col-sm-2 control-label">身份證號:</label>
                <div class="col-sm-3">
                    <input type="text" class="easyui-validatebox form-control" validType='idcared'
                           value="<?php echo $rs['idcard'] ?>" name="idcard" invalidMessage="請輸入正確的身份證">
                </div>
                <label class="col-sm-2 control-label">手機:</label>
                <div class="col-sm-3">
                <?php if(in_array('MOBILE', $auth)){?>
                    <input type="text" class="easyui-textbox form-control" value="<?php echo $rs['phone'] ?>"
                           validType="phoneRex" name="phone" invalidMessage="請輸入正確的手機號" maxlength="11"
                           style="height: 35px;width:220px">
                <?php }else{
                    echo '***********';
                }?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">qq:</label>
                <div class="col-sm-3">
                <?php if(in_array('QQ', $auth)){?>
                    <input type="text" class="easyui-numberbox form-control" value="<?php echo $rs['qq'] ?>" name="qq">
                <?php }else{
                    echo '***********';
                }?>
                </div>
                <label class="col-sm-2 control-label">郵箱:</label>
                <div class="col-sm-3">
                <?php if(in_array('EMAIL', $auth)){?>
                    <input type="text" class="easyui-textbox form-control" value="<?php echo $rs['email'] ?>"
                           validType='email' name="email" invalidMessage="請輸入正確的郵箱" style="height: 35px;width:220px">
                <?php }else{
                    echo '***********';
                }?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">取款密碼:</label>
                <div class="col-sm-3">
                <?php if(in_array('BANK_PWD', $auth)){?>
                    <input type="text" class="form-control" value="<?php echo $rs['bank_pwd'] ?>" name="bank_pwd"
                           maxlength="6" onkeyup="this.value=this.value.replace(/\D/g,'')">
                <?php } else {?>
                    <input type="text" class="form-control" value="******" disabled>
                <?php }?>
                </div>
                <label class="col-sm-2 control-label">登陸密碼:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['pwd'] ?>" name="pwd">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">層級:</label>
                <div class="col-sm-3">
                    <select name="level_id" class="easyui-combobox" style="width:220px; height: 35px">
                        <?php foreach ($level as $v) { ?>
                            <option value="<?php echo $v['id'] ?>" <?php echo $v['id'] == $rs['level_id'] ? 'selected' : '' ?>><?php echo $v['level_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-sm-2 control-label">備註:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['remark'] ?>" name="remark">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">註冊IP:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['addip'] ?>" disabled>
                </div>
                <label class="col-sm-2 control-label">註冊時間:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['addtime'] ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">最後登錄IP:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['loginip'] ?>" disabled>
                </div>
                <label class="col-sm-2 control-label">最後登錄時間:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['logintime'] ?>" disabled>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">每日出款次數上限:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['out_num'] ?>" name="out_num">
                </div>
                <label class="col-sm-2 control-label">每期遊戲最大限額:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['max_game_price'] ?>"
                           name="max_game_price">
                </div>
            </div>
        </div>
        <div class="tab-pane active" id="bank"><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">真實姓名:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['bank_name'] ?>" name="bank_name"
                        <?php /*echo $this->session->userdata('admin_id') != 1 ? 'readonly' : '' ; */echo !in_array('BANK_NAME',$auth) ? 'readonly' : ''; ?> >
                </div>
                <label class="col-sm-2 control-label">取款銀行:</label>
                <div class="col-sm-3">
                    <select class="form-control deposit_bank" name="bank_id">
                        <?php foreach ($platform as $v) { ?>
                            <option value="<?php echo $v['id']; ?>" <?php echo $rs['bank_id'] == $v['id'] ? 'selected' : '' ?>><?php echo $v['bank_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">收款賬號:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['bank_num'] ?>" name="bank_num">
                </div>

                <label class="col-sm-2 control-label">開戶行地址:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['address'] ?>" name="address">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">微信賬號:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['wechat'] ?>" name="wechat" <?php echo $this->session->userdata('admin_id') != 1?'readonly':'';?>>
                </div>
                <label class="col-sm-2 control-label">微信收款二維碼:</label>
                <div class="col-sm-3">
                    <div class="panel panel-default" data-collapsed="0" style="">
                        <div class="panel-heading <?php echo $this->session->userdata('admin_id') != 1?'hidden':'';?>" style="padding:0;width:134px;height:28px;">
                            <div class="panel-title">
                                <button class="btn label label-success" id="logo_uploadBtn_wx"><i
                                            class="entypo-upload"></i> 上傳微信收款二維碼
                                </button>
                            </div>
                        </div>
                        <div class="panel-body-wx <?php echo $rs['wechat_qrcode'] ? '' : 'hidden'; ?>"
                             style="height: 100px;">
                            <img <?php if ($rs['wechat_qrcode']) echo "src='" . $rs['wechat_qrcode'] . "'" ?>
                                    class="qrcode_thumb img-rounded logo_thumb_wx"
                                    style="width:50%;height: 100px;">
                            <input type="hidden" name="wechat_qrcode" value="<?php echo $rs['wechat_qrcode']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">支付寶賬號:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['alipay'] ?>" name="alipay" <?php echo $this->session->userdata('admin_id') != 1?'readonly':'';?>>
                </div>
                <label class="col-sm-2 control-label">支付寶收款二維碼:</label>
                <div class="col-sm-3">
                    <div class="panel panel-default" data-collapsed="0" style="">
                        <div class="panel-heading <?php echo $this->session->userdata('admin_id') != 1?'hidden':'';?>" style="padding:0;width:134px;height:28px;">
                            <div class="panel-title">
                                <button class="btn label label-success" id="logo_uploadBtn_zfb"><i
                                            class="entypo-upload"></i> 上傳支付寶收款二維碼
                                </button>
                            </div>
                        </div>
                        <div class="panel-body-zfb <?php echo $rs['alipay_qrcode'] ? '' : 'hidden'; ?>"
                             style="height: 100px;">
                            <img <?php if ($rs['alipay_qrcode']) echo "src='" . $rs['alipay_qrcode'] . "'" ?>
                                    class="qrcode_thumb img-rounded logo_thumb_zfb"
                                    style="width:50%;height: 100px;">
                            <input type="hidden" name="alipay_qrcode" value="<?php echo $rs['alipay_qrcode']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="count">正在加載....</div>
        <div class="tab-pane" id="cash_list">正在加載....</div>
        <div class="tab-pane" id="order">正在加載....</div>
        <div class="tab-pane" id="log">正在加載....</div>
        <div class="tab-pane" id="audit">正在加載....</div>
        <div class="tab-pane" id="payment_list">正在加載....</div>
        <div class="tab-pane <?php echo $is_actual ? '' : 'hidden' ?>" id="payment">正在加載....</div>
    </div>
</form>
<script type="text/javascript">
    $.extend($.fn.validatebox.defaults.rules, {   
                phoneRex: { //验证手机号  
                    validator: function(value, param){
                     return /^1[3-9]+\d{9}$/.test(value);
                    },   
                    message: '请输入正确的手机号码。'  
                }
            });
    $('.memberItem').unbind('click').bind('click', function () {
        var type = $(this).attr('type');
        if (type == 'cash_list') {
            url = 'member/get_cash?uid=<?php echo $rs['id']?>';
        } else if (type == 'order') {
            url = 'member/get_order?uid=<?php echo $rs['id']?>';
        } else if (type == 'log') {
            url = 'member/get_log?uid=<?php echo $rs['id']?>';
        } else if (type == 'count') {
            url = 'member/get_count?uid=<?php echo $rs['id']?>';
        } else if (type == 'audit') {
            url = 'member/get_audit?uid=<?php echo $rs['id']?>';
        } else if (type == 'payment_list') {
            url = 'member/get_payment_list?uid=<?php echo $rs['id']?>';
        } else if (type == 'payment') {
            url = 'member/get_payment?form_id=<?php echo $form_id;?>&uid=<?php echo $rs['id']?>&id=<?php echo $payment_id?>&actual_price=<?php echo $actual_price?>&order_num=<?php echo $order_num?>';
        }
        if ($('#' + type).text() == '正在加載....') {
            $.get(WEB + url, function (c) {
                $('#' + type).html(c);
            });
        }
    });

    var actual_price = '<?php echo $actual_price; ?>';
    if (actual_price != '') {
        $('.memberItem[type="payment"]').click();
    }

    var is_audit = '<?php echo $is_audit; ?>';
    if (is_audit == 1) {
        $('.memberItem[type="audit"]').click();
    }

    var id = '<?php echo $_GET['id']; ?>';
    if (id != '') {
        $('a[href="#member-basic"]').click();
    }

    /**微信收款二維碼****/
    Core.singleUploader('logo_uploadBtn_wx',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.logo_thumb_wx').attr('src',rs.result);
        $('[name=wechat_qrcode]').val(rs.result);
        $('.panel-body-wx').removeClass('hidden');
    });
    /**支付寶收款二維碼**/
    Core.singleUploader('logo_uploadBtn_zfb',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.logo_thumb_zfb').attr('src',rs.result);
        $('[name=alipay_qrcode]').val(rs.result);
        $('.panel-body-zfb').removeClass('hidden');
    });
</script>