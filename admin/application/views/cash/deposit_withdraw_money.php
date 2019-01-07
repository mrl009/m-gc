<style>
    #deposit_withdraw_money .mult:{
        display: none;
    }
</style>
<!-- 存取款 -->
<div class="row">
    <div class="button-group">
        <button type="button" class="button button-primary" name="dep_and_with" onclick="oper_form_display()">存款與取款</button>
        <?php if ($this->session->userdata('admin_id') == 1) { ?>
        <button type="button" class="button button-primary" name="mul_dep" onclick="oper_ext_form_display()">批量存款</button>
        <?php } ?>
        <button type="button" class="button button-primary" name="history" onclick="oper_table_display(1)">存款歷史</button>
        <button type="button" class="button button-primary" name="history" onclick="oper_table_display(2)">取款歷史</button>
        <div class="col-lg-2">
            <div class="input-group search_group">
                <input type="text" class="form-control" placeholder="輸入用戶名" id="input_user">
                <span class="input-group-btn">
                <button class="button button-primary" id="serBtn" type="button" onclick="searchUser()">查詢</button>
                </span>
            </div>
        </div>  
    </div>
</div>
<form class="form" onsubmit="getElementById('sureBtn').disabled=true;return true;">
    <table class="table table-bordered" id="deposit_withdraw_money">
        <tr class="active">
            <td colspan="4" style="text-align: center;">人工存取款</td>
        </tr>
        <tr class="mult">
            <td>批量方式</td>
            <td>
                <select class="form-control reType" name="mult_method" onchange="mult_method_fun()">
                    <option value="1">按賬號</option>
                    <option value="2">按層級</option>
                </select>
            </td>
        </tr>
        <tr class="mult">
            <td class="username_selector">賬號</td>
            <td class="username_selector">
                <textarea type="text" class="form-control" placeholder="輸入的多個賬號請用,號隔開。" id="mult_username" name="mult_username"></textarea>
            </td>
            <td class="level_selector">層級</td>
            <td class="level_selector">
                <select class="form-control reType" name="level_select"></select>
            </td>
        </tr>
        <tr class="single">
            <td>賬號</td>
            <td>
                <input type="text" class="form-control" placeholder="" name="account" style="border-radius: 3px">
            </td>
            <td class="username">姓名</td>
            <td>
                <input type="text" class="form-control" placeholder="" id="username" name="username">
            </td>
        </tr>
        <tr class="single">
            <td>系統余額</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="" name="balance">
            </td>
        </tr>
        <tr id="radio_tr">
            <td>操作類型</td>
            <td colspan="3">
                <input name="op_type" type="radio" value="1" checked="" class="op_type">&nbsp&nbsp存款 &nbsp;
                <input name="op_type" type="radio" value="2" class="op_type">&nbsp&nbsp取款
            </td>
        </tr>
        <tr class="deposit" id="deposit_price">
            <td>存款金額</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="" name="deposit_num" value="0" onchange="sum_check_num_count()">
            </td>
        </tr>
        <tr class="deposit" id="discount_price">
            <td>優惠金額</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="" name="coupon_num" value="0" onchange="sum_check_num_count()">
            </td>
        </tr>
        <tr class="deposit">
            <td>常態性稽核</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="" name="check_num" value="1" onchange="sum_check_num_count()">
            </td>
        </tr>
        <tr class="deposit">
            <td>綜合打碼量稽核</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="0" name="sum_check_num">
            </td>
        </tr>
        <tr class="deposit">
            <td>存款項目</td>
            <td colspan="3">
                <select class="form-control reType" name="deposit_summaryRet" onchange="dep_select_onchange()">
                    <option value="1">人工存入</option>
                    <option value="2">取消出款</option>
                    <option value="3">存款優惠</option>
                    <option value="4">返水優惠</option>
                    <option value="5">活動優惠</option>
                </select>
            </td>
        </tr>
        <tr class="withdraw" style="display: none;">
            <td>取款金額</td>
            <td colspan="3">
                <input type="text" class="form-control" placeholder="0" name="withdraw_num">
            </td>
        </tr>
        <tr class="withdraw" style="display: none;">
            <td>取款項目</td>
            <td colspan="3">
                <select class="form-control reType" name="withdraw_summaryRet">
                    <option value="1">重復出款</option>
                    <option value="2">公司入款誤存</option>
                    <option value="3">公司負數回沖</option>
                    <option value="4">手工申請出款</option>
                    <option value="5">扣除非法下註派彩</option>
                    <option value="6">放棄存款優惠</option>
                    <option value="7">其它</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>備註</td>
            <td colspan="3">
                <textarea class="form-control" name="remark" placeholder=""></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center" style="text-align: center;">
                <button class="btn btn-default" type="button" id="sureBtn" onclick="dataSubmit()">確定</button>
                <button class="btn btn-default" type="reset">重置</button>
            </td>
        </tr>
    </table>
</form>
<div class="listbidg" style="height: 100%">
    <?php $id = "form_" . uniqid(); ?>
    <table id="<?php echo $id; ?>" class="cqklist"></table>
</div>
<script>
   function show_table(big_type, type) {
       $("#<?php echo $id;?>").DataSource({url:'cash/get_deposit_withdraw_money_list?big_type='+big_type+'<?php echo $skip?$skip:''; ?>',
           fields:[[
               {field:'id',      title:'ID',  align:'center',      width:80,sortable:true},
               {field:'username',      title:'會員 ', align:'center',width:130, sortable:false},
               {field:'type_name',  title:'操作類型', align:'center',  width:120, sortable:true},
               {field:'price',title: big_type==1?'存款金額':'出款金額', align:'center',   width:150,  sortable:true,
                    styler:function(v){
                        return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                    }
                },
               {field:'discount_price',title:'優惠金額', align:'center',   width:150,  sortable:true},
               {field:'balance',title:'余額', align:'center',   width:150,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'';
                    }
                },
               {field:'auth_dml',title:'綜合打碼量', align:'center',     width:150,  sortable:true},
               {field:'auth_multiple',title:'常態性稽核', align:'center',     width:90,  sortable:true},
               {field:'addtime',title:'交易日期',align:'center',width:200,  sortable:true},
               {field:'remark',title:'備註',align:'center',width:200,  sortable:true}
           ]], tools:[
               {instant:false},
               {text:'導出',iconCls:'icon-large-chart',handler:function(){
                  Core.ExportJs($("#<?php echo $id;?>"),'人工存取款歷史查詢');
               }},
               {type:'datebox', text:'日期',   width:100,name:'time_start'},
               {type:'datebox', text:'-',     width:100,name:'time_end'},
               {type:'combobox',text:'類型',width:130,name:'type',value:'', items:type},
               {type:'textbox', text:'賬號', width:120,name:'username'},
               {type:'textbox', text:'操作員', width:120,name:'operator'},
               {text:"搜索", iconCls:"icon-search", handler:function(){
                   $('#<?php echo $id?>').DataSource('search');
               }},
               {text:"監控", color:'red',handler:function(){
                   $('#<?php echo $id?>').DataSource('search');
               }}
           ],
           footer:true,
           checkbox:false,
           edit:true
       });
   }
</script>

<script type="text/javascript">
    var flag = 1;
    var uid = null; //用戶id
    var bank_name = null; //姓名
    var balance_val = null; //賬戶余額
    var mult_flag = 0;//是否是批量存款

    $("document").ready(function () {
        $("#username").attr("disabled", true);
        $("#deposit_withdraw_money input[name='account']").attr("disabled", true);
        $("input[name='balance']").attr("disabled", true);
        $("input[name='sum_check_num']").attr("disabled", true);
        $('.listbidg .datagrid').hide();
        setDisabled(true);
        $(".mult").hide();
        $(".level_selector").hide();
        $("#radio_tr").show();
    });
    $('.op_type').click(op_type_change);
    function op_type_change() {
        var withdraw = $('input:radio[name="op_type"]:checked').val();
        if (withdraw == 1) {
            $('.deposit').show();
            $('.withdraw').hide();
            dep_select_onchange();
            flag = 1;
        } else if (withdraw == 2) {
            $('.deposit').hide();
            $('.withdraw').show();
            flag = 2;
        }
    }

    //提交
    function dataSubmit() {
        var remark = $("textarea[name='remark']").val();
        var mult_select_dep_flag = $("select[name='mult_method']").val();
        var mult_username = $("#mult_username").val();

        //存款
        if (flag == 1) {
            var url = WEB + 'cash/ajax_deposit_money';
            var deposit_num = $("input[name='deposit_num']").val();
            var coupon_num = $("input[name='coupon_num']").val();
            var check_num = $("input[name='check_num']").val();
            var deposit_summaryRet = $("select[name='deposit_summaryRet']").val();
            var level_id =  $("select[name='level_select']").val();
            var sum_check_num = $("input[name='sum_check_num']").val();
            if (deposit_summaryRet == 1 || deposit_summaryRet == 2) {
                if (deposit_num == 0) {
                    Core.error('請輸入存款金額');
                    return false;
                }
            } else {
                if (coupon_num == 0) {
                    Core.error('請輸入優惠金額');
                    return false;
                }
            }
            if (parseFloat(deposit_num) == deposit_num) {
                deposit_num = Number(deposit_num).toFixed(2);
            } else {
                Core.error("存款金額，請輸入數字");
                return false;
            }
            if (parseFloat(coupon_num) == coupon_num) {
                coupon_num = Number(coupon_num).toFixed(2);
            } else {
                Core.error("優惠金額，請輸入數字");
                return false;
            }
            if (parseFloat(check_num) == check_num) {
                check_num = Number(check_num).toFixed(2);
            } else {
                Core.error("常態稽核，請輸入數字");
                return false;
            }
            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    uid: uid,
                    mult_flag:mult_flag,   //批量存款標識
                    level_id:level_id, //層級id
                    mult_select_dep_flag: mult_select_dep_flag,//批量存款選擇標簽值
                    mult_username:mult_username,//批量存款用戶名標簽值
                    sum_check_num:sum_check_num,//綜合打碼量稽核
                    price: deposit_num,//存款
                    discount_price: coupon_num,//優惠金額
                    auth_multiple: check_num,//常態性稽核
                    type: deposit_summaryRet,//存取款類型
                    remark: remark //備註
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                beforeSend: function () {
                    // 禁用按鈕防止重復提交
                    $("#sureBtn").attr({ disabled: "disabled" });
                },
                success: function (data) {
                    Core.ok(data.msg);
                    Core.refresh();
                    $('#sureBtn').attr('disabled',true);
                },
                complete: function () {
                    $("#sureBtn").removeAttr("disabled");
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Core.error('異常1'+XMLHttpRequest.status+' '+textStatus);
                }
            });
        } else if (flag == 2) {
            //取款
            var url = WEB + 'cash/ajax_withdraw_money';
            var withdraw_num = $("input[name='withdraw_num']").val();
            var withdraw_summaryRet = $("select[name='withdraw_summaryRet']").val();
            var balance =  $("input[name='balance']").val();

            if (withdraw_num == 0) {
                Core.error('請輸入出款金額');
                return false;
            }

            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    uuid: uid,
                    price: withdraw_num,
                    type: withdraw_summaryRet,
                    remark: remark,
                    balance:balance
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                beforeSend: function () {
                    // 禁用按鈕防止重復提交
                    $("#sureBtn").attr({ disabled: "disabled" });
                },
                success: function (data) {
                    Core.ok(data.msg);
                    Core.refresh();
                    $('#sureBtn').attr('disabled','disabled');
                },
                complete: function () {
                    $("#sureBtn").removeAttr("disabled");
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Core.error('異常2'+XMLHttpRequest.status+' '+textStatus);
                }
            });
        }
    }

    //查詢用戶
    function searchUser() {
        $('#serBtn').attr('disabled','disabled');
        var username = $("#input_user").val();
        var url = WEB + 'cash/ajax_search_user';
        $.ajax({
            url: url,// 跳轉到 action
            data: {
                username: username
            },
            type: 'post', //用post方法
            cache: false,
            dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
            success: function (data) {
                setTimeout(function(){
                    $('#serBtn').removeAttr("disabled");
                },2000)
                if (data.code == 200) {
                    data = data.data;
                }else if(data.code == 421) {
                    Core.error('此賬號不存在');
                    return false;
                }else if(data.code == 304) {
                    Core.error('操作频繁');
                    return false;
                }
                if(data != null){
                    uid = data.uid;
                    bank_name = data.bank_name;
                    balance_val = data.balance;
                    if(uid!=null){
                        $("#username").val(data.bank_name);
                        $("#deposit_withdraw_money input[name='account']").val(data.username);
                        $("input[name='balance']").val(data.balance);
                        //只有查詢到用戶才能激活相應的輸入控件
                        setDisabled(false);
                    }
                }else{
                    setDisabled(true);
                    $("#deposit_withdraw_money input[name='account']").val('');
                    $("input[name='balance']").val('');
                    $("#username").val('');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                Core.error('異常3'+XMLHttpRequest.status+' '+textStatus);
            }
        });
    }

    //根據三個輸入款的輸入變化自動計算綜合打碼量稽核
    function sum_check_num_count() {
        var deposit_num = $("input[name='deposit_num']").val();
        var coupon_num = $("input[name='coupon_num']").val();
        var check_num = $("input[name='check_num']").val();

        if (deposit_num && coupon_num && check_num) {
            if (parseFloat(deposit_num) == deposit_num) {
                deposit_num = parseFloat(Number(deposit_num).toFixed(2));
            } else {
                Core.error("存款金額，請輸入數字");
                $("input[name='sum_check_num']").val(0);
                return
            }
            if (parseFloat(coupon_num) == coupon_num) {
                coupon_num = parseFloat(Number(coupon_num).toFixed(2));
            } else {
                Core.error("存款優惠金額，請輸入數字");
                $("input[name='sum_check_num']").val(0);
                return
            }
            if (parseFloat(check_num) == check_num) {
                check_num = parseFloat(Number(check_num).toFixed(2));
            } else {
                Core.error("常態稽核，請輸入數字");
                $("input[name='sum_check_num']").val(0);
                return
            }
            var sum = (deposit_num + coupon_num) * check_num;
            $("input[name='sum_check_num']").val(parseFloat(Number(sum).toFixed(2)));
        } else {
            $("input[name='sum_check_num']").val(0);
        }
    }

    //存取款表單顯示
    function oper_form_display() {
        $("select[name='deposit_summaryRet']").val(1);
        $("select[name='withdraw_summaryRet']").val(1);
        $(".mult").hide();
        $(".single").show();
        //searchUser();
        $("#radio_tr").show();
        $(".form").show();
        $('.listbidg .datagrid').hide();
        $(".search_group").show();
        op_type_change();
        mult_flag = 0;
    }

    //批量存款表單顯示
    function oper_ext_form_display() {

        $("select[name='deposit_summaryRet']").val(1);
        $('.deposit').show();
        $('.withdraw').hide();

        $(".mult").show();
        $(".single").hide();
        setDisabled(false);
        $("#radio_tr").hide();
        $(".form").show();
        $('.listbidg .datagrid').hide();
        $(".search_group").show();

        flag = 1;
        mult_flag = 1;
    }

    function oper_table_display(big_type){
        $(".form").hide();
        if (big_type == 1) {
            var type = '<option value="">全部</option><option value="1">人工存入</option><option value="2">取消出款</option>' +
                '<option value="3">存款優惠</option><option value="4">返水優惠</option><option value="5">活動優惠</option>' ;
        } else if(big_type == 2) {
            var type = '<option value="">全部</option><option value="8">重復出款</option><option value="9">公司入款誤存</option>' +
                '<option value="10">公司負數回沖</option><option value="11">手工申請出款</option>' +
                '<option value="12">扣除非法下註派彩</option><option value="13">放棄存款優惠</option><option value="14">其它取款</option>'
        }
        show_table(big_type,type);
        $('.listbidg .datagrid').show();
        $(".search_group").hide();
    }

    //存款類型選擇標簽，選擇於優惠存款的項，隱藏存款金額，並置0，計算綜合打碼量稽核
    function dep_select_onchange() {
        var deposit_summaryRet = $("select[name='deposit_summaryRet']").val();
        if(deposit_summaryRet == 3 || deposit_summaryRet == 4 || deposit_summaryRet == 5){
            $("#deposit_price").hide();
            $("#discount_price").show();
            $("input[name='deposit_num']").val(0);
            var coupon_num = $("input[name='coupon_num']").val();
            var check_num = $("input[name='check_num']").val();

            if (coupon_num && check_num) {
                if (parseFloat(coupon_num) == coupon_num) {
                    coupon_num = parseFloat(Number(coupon_num).toFixed(2));
                } else {
                    Core.error("存款優惠金額，請輸入數字");
                    $("input[name='sum_check_num']").val(0);
                    return
                }
                if (parseFloat(check_num) == check_num) {
                    check_num = parseFloat(Number(check_num).toFixed(2));
                } else {
                    Core.error("常態稽核，請輸入數字");
                    $("input[name='sum_check_num']").val(0);
                    return
                }
                var sum = coupon_num * check_num;
                $("input[name='sum_check_num']").val(parseFloat(Number(sum).toFixed(2)));
            } else {
                $("input[name='sum_check_num']").val(0);
            }
        }else if(deposit_summaryRet == 2){
            $("input[name='deposit_num']").val(0);
            $("input[name='coupon_num']").val(0);
            $("input[name='check_num']").val(0);
            $("input[name='sum_check_num']").val(0);
            $("#deposit_price").show();
            $("#discount_price").hide();
        }else{
            $("input[name='deposit_num']").val(0);
            $("input[name='coupon_num']").val(0);
            $("input[name='check_num']").val(0);
            $("input[name='sum_check_num']").val(0);
            $("#deposit_price").show();
            $("#discount_price").show();
        }
    }

    //設置相關控件的可編輯狀態
    function setDisabled(flag) {
        $("input[name='deposit_num']").attr("disabled", flag);
        $("input[name='coupon_num']").attr("disabled", flag);
        $("input[name='check_num']").attr("disabled", flag);
        $("select[name='deposit_summaryRet']").attr("disabled", flag);
        $("input[name='withdraw_num']").attr("disabled", flag);
        $("select[name='withdraw_summaryRet']").attr("disabled", flag);
        $("textarea[name='remark']").attr("disabled", flag);
        $("#sureBtn").attr("disabled", flag);
    }

    //批量存款批量選擇選項-選擇層級調取接口，並將用戶輸入控件替換成level_id選擇控件
    function mult_method_fun() {
        var mult_method_val = $("select[name='mult_method']").val();
        if(mult_method_val == 1){
            $(".level_selector").hide();
            $(".username_selector").show();
        }else if(mult_method_val ==2){
            $(".username_selector").hide();
            $(".level_selector").show();
            $.ajax({
                url: WEB + 'cash/ajax_get_level_list',// 跳轉到 action
                data: {
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                success: function (data) {
                    var text = null;
                    for(var i=0; i<data.length; i++){
                        text += '<option value=\"' + data[i].id + '\">'+ data[i].level_name + '</option>';
                    }
                    $("select[name='level_select']").append(text);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Core.error('異常4'+XMLHttpRequest.status+' '+textStatus);
                }
            });
        }
    }

    //存款類型選擇標簽，選擇於優惠存款的項，隱藏存款金額，並置0，計算綜合打碼量稽核
    function clearAll() {
        $("input").val('');
        $("textarea");
        uid = null;
        Core.refresh();
    }
</script>
<?php
if(!empty($skip)) {
    echo '<script>oper_table_display('.$big_type.')</script>';
}
?>