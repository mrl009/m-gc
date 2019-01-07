<!-- 詳細資料設定 -->
<form class="form-horizontal" action="member/detail_info" method="post" id="detail_info">
    <div class="form-group">
        <label  class="col-sm-3 control-label">賬號:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="account" value="<?php echo ($account ? $account : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">真實姓名:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="real_name" value="<?php echo ($real_name ? $real_name : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">生日:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="birthday" value="<?php echo ($birthday ? $birthday : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">地區:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="region" value="<?php echo ($region ? $region : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">身份證號:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="id_card" value="<?php echo ($id_card ? $id_card : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">手機:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="phone" value="<?php echo ($phone ? $phone : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">QQ/微信:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="qq" value="<?php echo ($qq ? $qq : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">E-Mail:</label>
        <div class="col-sm-9">
            <input type="email" class="form-control opening_bank"  placeholder="" name="email" value="<?php echo ($email ? $email : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">取款銀行:</label>
        <div class="col-sm-9 pt7">
            <select class="form-control" name="bank_name" class="bank_name">
                <option v-for="bank in banks" v-bind:value="bank.id">{{bank.name}}</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">銀行賬號:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="bank_account" value="<?php echo ($bank_account ? $bank_account : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">取款密碼:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="bank_password" value="<?php echo ($bank_password ? $bank_password : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">備註:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="remark" value="<?php echo ($remark ? $remark : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">註冊IP:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="register_ip" value="<?php echo ($register_ip ? $register_ip : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">註冊時間:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="register_time" value="<?php echo ($register_time ? $register_time : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">最後登陸時間:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="last_login_time" value="<?php echo ($last_login_time ? $last_login_time : '');?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-3 control-label">最後登陸IP:</label>
        <div class="col-sm-9">
            <input type="text" class="form-control opening_bank"  placeholder="" name="last_login_ip" value="<?php echo ($last_login_ip ? $last_login_ip : '');?>">
        </div>
    </div>
</form>
<script>
    app = new Vue({
        'el':'#detail_info',
        'data': {
            banks: [
                {id: 1, name: '中國銀行'},
                {id: 2, name: '中國建設銀行'},
                {id: 3, name: '中國工商銀行'}
            ]
        },
        methods: {
            get_bank_list: function() {
                axios.post('payset/get_bank_list', {
                    id: 1335
                }).then(function (response) {
                    console.log(response);
                }).catch(function (error) {
                });
            }
        },
        created: function() {
            this.get_bank_list();
        }
    });
</script>
