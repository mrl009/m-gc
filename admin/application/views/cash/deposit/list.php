<?php $id = "form_company_id"; ?>
<table id="<?php echo $id; ?>"></table>
<script>
    var rk = sessionStorage.getItem('rk');
    var rk_refresh = sessionStorage.getItem('rk_refresh');
    var tools = [
        {instant: false},
        <?php if(in_array('EXPORT',$auth)){?>
        {text:'導出',iconCls:'icon-large-chart',handler:function(){
            Core.ExportJs($("#<?php echo $id;?>"),'公司入款');
        }},
        <?php }?>
        {type:'combobox',text:'層級',width:90,name:'level_id',value:'', items:'<option value="">全部</option><?php foreach($level as $v){echo "<option value=$v[id]>$v[level_name]</option>"; }?>'},
        {type: 'combobox',text: '狀態',width: 30,name: 'status',value: '',
            items: '<option value="" selected>全部</option><option value="1">未確認</option><option value="2">已確認</option><option value="3">已取消</option>'
        },
        {type: 'combobox',text: '入款來源',width: 30,name: 'froms',value: '',
            items:'<option value="">全部</option><option value="1">IOS端</option><option value="2">安卓</option><option value="3">PC端</option><option value="4">WAP</option><option value="5">未知</option>'
        },
        {type: 'combobox',text: '首存',width: 30,name: 'is_first',value: '',
            items:'<option value="">全部</option><option value="0">否</option><option value="1">是</option>'
        },
        {type: 'textbox', text: '收款帳號', width: 110, name: 'bankCard'},
        {type: 'label', html:'<input type="hidden" name="bank_card" value="">'},
        {type:'combobox',text:'时间',width:90,name:'time_type',items:'<option value="1">系统时间</option><option value="2">操作时间</option>'},
        {type: 'datebox', text: '日期', width: 98, name: 'time_start'},
        {type: 'datebox', text: '', width: 98, name: 'time_end'},
        {type: 'textbox', text: '金額', width: 50, name: 'price_start'},
        {type: 'textbox', text: '', width: 50, name: 'price_end'},
        {type: 'textbox', text: '賬號', width: 100, name: 'f_username'},
        {type: 'textbox', text: '訂單號', width: 120, name: 'f_ordernum'},
        {type: 'textbox', text: '操作者', width: 130, name: 'f_admin'},
        {text: "搜索", iconCls: "icon-search", handler: function () {
            var order_num = $("#form_<?php echo $id?> input[name='f_ordernum']").val();
            var start = $("#form_<?php echo $id?> input[name='time_start']").val();
            var end = $("#form_<?php echo $id?> input[name='time_end']").val();
            if (order_num == '' && start != '' && end != '' && Core.limitDay(start, end, 60)){
                Core.error('查詢區間限制為兩個月');
                return false;
            }
            $('#<?php echo $id?>').DataSource('search');
        }
        },
        {type:'combobox',text:'提示間隔',width:60,name:'rktimelong',value:'',
            items:'<option value="10">10秒</option><option value="20">20秒</option><option value="30">30秒</option><option value="40">40秒</option>'}
    ];
    if (rk) {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉提示音：<input type="checkbox" id="close-rk" onclick="closeRk(this)" checked>'})
    } else {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉提示音：<input type="checkbox" id="close-rk" onclick="closeRk(this)">'})
    }
    if (rk_refresh) {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉刷新：<input type="checkbox" id="close-rk-refresh" onclick="closeRkRefresh()" checked>'})
    } else {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉刷新：<input type="checkbox" id="close-rk-refresh" onclick="closeRkRefresh()">'})
    }
    $("#<?php echo $id;?>").DataSource({
        url: 'cash/get_deposit_list?<?php echo $skip; ?>',
        fields: [[
            {field: 'order_num', title: '訂單號', align: 'left', width: 140},
            {field: 'leve_name', title: '層級', align: 'center', width: 90, sortable: true},
            {field: 'loginname', title: '會員帳號', align: 'center', width: 80},
            {field: 'u_bank_name', title: '會員姓名', align: 'center', width: 80},
            {
                field: 'deposit_info',
                title: '存款人與時間',
                align: 'left',
                width: 160,
                sortable: true,
                formatter: function (v, r) {
                    if (!r.loginname) {
                        return '筆數:' + r.in_company_num;
                    }
                    return '存款人:' + r.user_name + '<br/>時間:' + r.addtime;
                }
            },
            {
                field: 'have_in',
                title: '存入金額與優惠',
                align: 'left',
                width: 180,
                formatter: function (v, r) {
                    if (!r.loginname) {
                        return '提交金額:' + r.price + '<br/>存款/優惠:' + r.discount_price;
                    }
                    return '提交金額:' + r.price + '<br/>存款/優惠:' + r.price + '/' + r.discount_price + '<br/>銀行:' + r.bank_name + '<br/>方式:' + r.bank_style;
                }
            },
            {
                field: 'total_in',
                title: '存入總額與備註',
                align: 'left',
                width: 130,
                sortable: true,
                formatter: function (v, r) {
                    if (!r.loginname) {
                        return '存入總金額：' + r.total_price;
                    }
                    if( r.confirm == 0){
                        return '確認碼: - <br/>' +'存入總額:' + r.total_price + '<br/>備註:' + r.remark;
                    }else{
                        return '確認碼:'+ r.confirm +'<br/>存入總額:' + r.total_price + '<br/>備註:' + r.remark;
                    }

                }
            },
            {
                field: 'bank_account',
                title: '存入銀行帳戶',
                align: 'left',
                width: 150,
                formatter: function (v, r) {
                    if (!r.loginname) {
                        return null;
                    }
                    return '卡主:' + r.card_name + '<br/> 銀行:' + r.bank_name + '<br/>' + '卡號:' + r.card_num;
                }
            },
            {
                field: 'status', title: '狀態', align: 'center', width: 150, formatter: function (v, r) {
                if (!r.loginname) {
                    return null;
                }
                var str = '';
                if (r.status == '2') {
                    str += '<span class="label label-success">已確認</span>';
                } else if (r.status == '3') {
                    var date = new Date().getTime() - new Date(r.update_time).getTime();
                    var hour = Math.floor((date%(24*3600*1000))/(3600*1000))
                    if (hour <= 4) {
                        str += '<a onclick=deposit_revoke(' + r.id + ');><span class="btn label label-danger">撤消訂單取消</span></a>';
                    } else {
                        str += '<span class="label label-danger">已取消</span>';
                    }
                } else {
                    if(r.limit < 0){
                        str += '<span class="label label-success">暂时无法操作</span>';
                    }else{
                        str += '<a onclick=deposit_cancel(' + r.id + ');><span class="btn label label-default">取消存款</span></a>&nbsp;' +
                            '<a onclick=deposit_confirm(' + r.id + ');><span class="btn label label-primary">確認入款</span></a>&nbsp;';
                    }
                }
                return str;
            }
            },
            {field:'remark',  title:'人工備註', align:'left', width:95,formatter:function(v, r){
                if (v == undefined) {
                    return '';
                }
                return '<div title="单击编辑备注" style="line-height: 4" onclick=payment_remark('+r.id+')>&nbsp;<span>'+ v +'</span>&nbsp;</div>';
            }
            },
            {
                field: 'is_first', title: '首存', align: 'center', width: 40, formatter: function (v, r) {
                if (!r.loginname) {
                    return null;
                }else{
                    if (r.is_first == '0') {
                        return '否';
                    }else if(r.is_first == '1'){
                        return '<span style="color:red">是</span>';
                    }else{
                        return '全部'
                    }
                }
            }
            },
            {field: 'admin_name', title: '操縱者', align: 'center', width: 75},
            {field:'from_way',title:'來源',align: 'center', width:35,formatter:function(v,r){
            var r = '';
                if (v == '1') {
                    r = '<i class="fa fa-apple fa-lg"></i>';
                } else if(v == 2) {
                    r = '<i class="fa fa-android fa-lg"></i>';
                } else if(v == 3) {
                    r = '<i class="fa fa-desktop fa-lg"></i>';
                } else if(v == 4) {
                    r = '<i class="fa fa-html5 fa-lg"></i>';
                } else if(v == 5) {
                    r = '<i class="fa fa-info-circle fa-lg"></i>';
                }
            return r;
          }},
            {field: 'update_time', title: '時間', align: 'center', width: 140, sortable: true}
        ]], tools: tools,
        footer: true,
        edit: false,
        checkbox: false,
        success:function () {
            var id = '<?php echo $id?>';
            var _ = $("#form_<?php echo $id?> input[name='bankCard']");
            var url = 'cash/search_bank_card?form_id=' + id;
            Core.searchDialog(_, '收款帳號', url);
        }
    });

    function deposit_cancel(id)
    {
        var url = '/cash/ajax_deposit_operation';
        Core.dialog('取消備註(不超過100個字)','cash/payment_cancel?status=3&id='+id,function(){
            var remark = $("#remark").val();
            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    id: id,
                    status:3,
                    remark:remark
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                success: function (data) {
                    Core.ok(data.msg);
                    $('#<?php echo $id?>').datagrid('reload');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                        $('#<?php echo $id;?>').html(XMLHttpRequest.responseText);
                    } else {
                        Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                    }
                }
            });

        },true,false);
    }

    function deposit_revoke(id) {

        var url = '/cash/ajax_deposit_revoke';

        $.messager.confirm('溫馨提示', '確定要撤消訂單取消嗎？', function (r) {
            if (r) {
                $.ajax({
                    url: url,
                    data: {
                        id: id
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.ok(data.msg);
                        $('#<?php echo $id?>').datagrid('reload');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                            $('#<?php echo $id;?>').html(XMLHttpRequest.responseText);
                        } else {
                            Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                        }
                    }
                });
            }
        });

    }

    //.空格件直接取消直接拒绝
    function payment_key_refuse(id,status)
    {
        var url = '/cash/ajax_deposit_operation';
        var remark = $("#remark").val();
        document.body.removeChild(document.getElementsByClassName("modal")[0]);
        document.body.removeChild(document.getElementsByClassName("modal-backdrop")[0]);
            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    id: id,
                    status:3,
                    remark:remark
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                success: function (data) {
                    Core.ok(data.msg);
                    $('#<?php echo $id?>').datagrid('reload');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Core.error('異常'+XMLHttpRequest.status+' '+textStatus);
                }
            });

    }
    function payment_remark(id)
    {
        var url = '/cash/ajax_deposit_remark_do';
        Core.dialog('人工備註(不超過100個字)','cash/payment_cancel',function(){
            var remark = $("#remark").val();
            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    id: id,
                    remark:remark
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                success: function (data) {
                    Core.ok(data.msg);
                    $('#<?php echo $id?>').datagrid('reload');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                        $('#<?php echo $id;?>').html(XMLHttpRequest.responseText);
                    } else {
                        Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                    }
                }
            });

        },true,false);

    }

    function deposit_confirm(id) {
        var url = '/cash/ajax_deposit_operation';

        $.messager.confirm('溫馨提示', '確定要確認存款嗎？', function (r) {
                if (r) {
                    $.ajax({
                        url: url,
                        data: {
                            id: id,
                            status: 2,
                            remark: ''
                        },
                        type: 'post',
                        cache: false,
                        dataType: 'json',
                        success: function (data) {
                            Core.ok(data.msg);
                            $('#<?php echo $id?>').datagrid('reload');
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                                $('#<?php echo $id;?>').html(XMLHttpRequest.responseText);
                            } else {
                                Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                            }
                        }
                    });
                }
        });


    }

    $(function(){
        //20秒公司入款
        if (rk != 1 || rk_refresh != 1) {
            clearInterval(rkInterval);
            var rk_params = getRkParams();
            rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},20*1000);
        }
        $('#form_form_company_id #rktimelong').combobox({
            onChange:function(n){
                rk = sessionStorage.getItem('rk');
                rk_refresh = sessionStorage.getItem('rk_refresh');
                if (rk != 1 || rk_refresh != 1) {
                    clearInterval(rkInterval);
                    var rk_params = getRkParams();
                    rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},n*1000);
                }
            }
        });
        $('#form_form_company_id #status').combobox({
            onChange:function(n){
                rk = sessionStorage.getItem('rk');
                rk_refresh = sessionStorage.getItem('rk_refresh');
                if (rk != 1 || rk_refresh != 1) {
                    clearInterval(rkInterval);
                    var time = $('#form_form_company_id input[name="rktimelong"]').val();
                    time = time || 20;
                    var rk_params = getRkParams();
                    rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},time*1000);
                }
            }
        });
        $('#form_form_company_id #level_id').combobox({
            onChange:function(n){
                rk = sessionStorage.getItem('rk');
                rk_refresh = sessionStorage.getItem('rk_refresh');
                if (rk != 1 || rk_refresh != 1) {
                    clearInterval(rkInterval);
                    var time = $('#form_form_company_id input[name="rktimelong"]').val();
                    time = time || 20;
                    var rk_params = getRkParams();
                    rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},time*1000);
                }
            }
        });
        // $('#form_form_company_id #froms').combobox({
        //     onChange:function(n){
        //         rk = sessionStorage.getItem('rk');
        //         rk_refresh = sessionStorage.getItem('rk_refresh');
        //         if (rk != 1 || rk_refresh != 1) {
        //             clearInterval(rkInterval);
        //             var time = $('#form_form_company_id input[name="rktimelong"]').val();
        //             time = time || 20;
        //             var rk_params = getRkParams();
        //             rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},time*1000);
        //         }
        //     }
        // });
        // $('#form_form_company_id #is_first').combobox({
        //     onChange:function(n){
        //         rk = sessionStorage.getItem('rk');
        //         rk_refresh = sessionStorage.getItem('rk_refresh');
        //         if (rk != 1 || rk_refresh != 1) {
        //             clearInterval(rkInterval);
        //             var time = $('#form_form_company_id input[name="rktimelong"]').val();
        //             time = time || 20;
        //             var rk_params = getRkParams();
        //             rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},time*1000);
        //         }
        //     }
        // });
    });
    function closeRk() {
        clearInterval(rkInterval);
        rk = sessionStorage.getItem('rk') ? 0 : 1;
        rk_refresh = sessionStorage.getItem('rk_refresh');
        if (rk == 1) {
            sessionStorage.setItem('rk', 1);
        } else {
            sessionStorage.removeItem('rk');
        }
        if (rk != 1 || rk_refresh != 1) {
            var n = $("#form_<?php echo $id?> input[name='rktimelong']").val();
            n = n ? n : 20;
            var rk_params = getRkParams();
            rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},n*1000);
        }
    }

    function closeRkRefresh() {
        clearInterval(rkInterval);
        rk = sessionStorage.getItem('rk');
        rk_refresh = sessionStorage.getItem('rk_refresh') ? 0 : 1;
        if (rk_refresh == 1) {
            sessionStorage.setItem('rk_refresh', 1);
        } else {
            sessionStorage.removeItem('rk_refresh');
        }
        if (rk != 1 || rk_refresh != 1) {
            var n = $("#form_<?php echo $id?> input[name='rktimelong']").val();
            n = n ? n : 20;
            var rk_params = getRkParams();
            rkInterval = setInterval(function(){Core.user_in(rk,rk_refresh,rk_params)},n*1000);
        }
    }

    function getRkParams() {
        var level_id = $('#form_form_company_id input[name="level_id"]').val();
        var status = $('#form_form_company_id input[name="status"]').val();
        var froms = $('#form_form_company_id input[name="froms"]').val();
        var is_first = $('#form_form_company_id input[name="is_first"]').val();
        var bank_card = $('#form_form_company_id input[name="bank_card"]').val();
        return {
            'level_id': level_id,
            'status': status,
            'froms': froms,
            'is_first': is_first,
            'bank_card': bank_card
        };
    }
</script>