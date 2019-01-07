<?php $id = "form_income_id"; ?>
<table id="<?php echo $id; ?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'cash/get_income_list_new?<?php echo $skip; ?>',
        fields: [[
            {field: 'order_num', title: '訂單號 ', align: 'left', width: 140, sortable: false,formatter:function(v, r){
                if(r.status == 4){
                    return '<span class="btn label label-danger">'+v+'</span>';
                }else{
                    return v;
                }
            }},
            {field: 'leve_name', title: '層級', align: 'center', width: 100, sortable: true},
            {field: 'user_name',title: '會員帳號',align: 'center',width: 80,sortable: true,
                formatter: function (v, r) {
                    if (!r.user_name) {
                        return '筆數:' + r.in_online_num;
                    }
                    return r.user_name
                }
            },
            {field: 'agent_name', title: '上級代理', align: 'center', width: 100, sortable: true},
            {
                field: 'income_info',
                title: '存款金額',
                align: 'center',
                width: 180,
                sortable: true,
                formatter: function (v, r) {
                    return '提交金額:' + r.price + '<br/>存款/優惠:' + r.price + '/' + r.discount_price;
                }
            },
            {
                field: 'total_price',
                title: '存入總額',
                align: 'center',
                width: 150,
                sortable: true,
                formatter: function (v, r) {
                    return '存入總額:' + r.total_price;
                }
            },
            {
                field: 'status', title: '狀態', align: 'center', width: 150, sortable: true, formatter: function (v, r) {
                /*if (! r.user_name) {
                 return null;
                 }*/
                var str = '';
                if (r.status == 1 || r.status == 4) {
                    // str += '<span class="label label-default">未支付</span>';
                    str += '<a onclick=income_cancel(' + r.id + ');><span class="btn label label-danger">不再提示</span></a>&nbsp;' +
                        '<a onclick=income_confirm(' + r.id + ');><span class="btn label label-success">確認入款</span></a>&nbsp;';
                } else if (r.status == 2) {
                    str = '<span class="label label-success">已支付</span>';
                } else if (r.status == 3) {
                    str = '<span class="label label-danger">已取消</span>';
                } else {

                }
                return str;
            }
            },
            {
                field: 'pay_type',
                title: '存入銀行帳戶',
                align: 'center',
                width: 130,
                sortable: true,
                formatter: function (v, r) {
                    if (!r.user_name) {
                        return null;
                    }
                    return r.pay_name;
                }
            },
            {
                field: 'is_first', title: '首存', align: 'center', width: 50, sortable: true, formatter: function (v, r) {
                if (!r.user_name) {
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
            {field: 'admin_name', title: '操作者', align: 'center', width: 80, sortable: true},
            {field:'from_way',title:'來源',align: 'center',width:35,formatter:function(v,r){
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
            {
                field: 'datetime', title: '時間', align: 'center', width: 200, sortable: true, formatter: function (v, r) {
                if (!r.user_name) {
                    return null;
                }
                return '系統時間：' + r.addtime + '<br/>操作時間：' + r.update_time;
            }
            }
        ]], tools: [
            {instant: false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'線上入款');
            }},
            <?php }?>
            {type:'combobox',text:'層級',width:90,name:'level_id',value:'', items:'<option value="">全部</option><?php foreach($level as $v){echo "<option value=$v[id]>$v[level_name]</option>"; }?>'},
            {
                type: 'combobox',
                text: '狀態',
                width: 20,
                name: 'status',
                value: '',
                items: '<option value="" selected>全部</option><option value="1">未確認</option><option value="2">已確認</option><option value="3">已取消</option>'
            },
                        {
                type: 'combobox',
                text: '入款设备',
                width: 20,
                name: 'froms',
                value: '',
                items: '<option value="">全部</option><option value="1">IOS端</option><option value="2">安卓</option><option value="3">PC端</option><option value="4">WAP</option><option value="5">未知</option>'
            },
            {
                type: 'combobox',
                text: '入款商戶',
                width: 50,
                name: 'payId',
                value: '',
                items: '<?php foreach ($banks as $v) {
                    echo "<option value=$v[id]>$v[name]</option>";
                }?>'
            },
            {
                type: 'combobox',
                text: '直通车入款商戶',
                width: 50,
                name: 'online_id',
                value: '',
                items: '<?php foreach ($fasts as $v) {
                    echo "<option value=$v[id]>$v[name]</option>";
                }?>'
            },
            {type: 'combobox',text: '首存',width: 20,name: 'is_first',value: '',
                items:'<option value="">全部</option><option value="0">否</option><option value="1">是</option>'
            },
//            {type:'textbox', text: '所屬代理', width: 50, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'combobox',text:'时间',width:90,name:'time_type',items:'<option value="1">系统时间</option><option value="2">操作时间</option>'},
            {type: 'datebox', text: '日期', width: 95, name: 'time_start'},
            {type: 'datebox', text: '', width: 95, name: 'time_end'},
            {type: 'textbox', text: '金額', width: 50, name: 'price_start'},
            {type: 'textbox', text: '', width: 50, name: 'price_end'},

            {type: 'textbox', text: '賬號', width: 75, name: 'f_username'},
            {type: 'textbox', text: '訂單號', width: 130, name: 'f_ordernum'},
            {type: 'textbox', text: '操作者', width: 130, name: 'f_admin'},
            {text: "搜索", iconCls: "icon-search", handler: function () {
                var order_num = $("#form_<?php echo $id?> input[name='f_ordernum']").val();
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                var czz = $("#form_<?php echo $id?> input[name='f_admin']").val();
                if (order_num == '' && start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }
            },


            {type:'combobox',text:'提示間隔',width:60, name:'se_tt',value:'30',
                items:'<option value="10">10秒</option><option value="20">20秒</option><option value="30">30秒</option><option value="40">40秒</option>'},
            /*{type: 'label', html:'&nbsp;&nbsp;關閉提示音：<input type="checkbox" id="ck_tohes" />'},*/
            {type: 'label', html:'&nbsp;&nbsp;關閉刷新：<input type="checkbox" id="ck_refresh" />'}
        ],
        success:function(r,d){
            
        },
        footer: true,
        checkbox: false,
        edit: true,
        success:function(){
            Core.agentLog('<?php echo $id?>');
        }
    });

    function income_cancel(id) {
        var url = '/cash/ajax_income_ignore';
        //發送http請求
        $.messager.confirm('溫馨提示', '確定不再提示嗎？', function(r){
            if (r){

                $.ajax({
                    url: url,// 跳轉到 action
                    data: {
                        id: id
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
            }
        });
    }

    function income_confirm(id) {
        var url = '/cash/ajax_income_confirm';
        //發送http請求
        $.messager.confirm('溫馨提示', '確定確認入款嗎？', function(r){
            if (r){

                $.ajax({
                    url: url,// 跳轉到 action
                    data: {
                        id: id
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
            }
        });
    }

    $(function () {
        var formId = 'form_<?php echo $id; ?>';
        var $sett  = $('#'+ formId +' input[name="se_tt"]');
        var tt = $sett.val();
        /*
        var ckTohes = $(formId +' #ck_tohes');
        var ckTohesSe = sessionStorage.getItem(formId + '_ck_tohes') ? true : false;
        if ( ckTohesSe ) ckTohes.prop('checked', true);
        ckTohes.change(function () {
            if ( ckTohes.isChecked(0)) {
                console.debug('ckTohes checked!');
                sessionStorage.setItem(formId + '_ck_tohes', 1);
            }else {
                console.debug('ckTohes uncheck!');
                sessionStorage.removeItem(formId + '_ck_tohes');
            }
        });
        */

        var _sit = 0;
        var F_refresh = function () {
            clearInterval(_sit);
            _sit = setInterval(function(){
                //console.info('reload ...');
                $('#<?php echo $id?>').datagrid('reload');
            }, tt*1000);
        };

        var ckRefresh = $('#'+ formId +' #ck_refresh');
        var ckRefreshSe = sessionStorage.getItem(formId +'_ck_refresh') ? true : false;
        if ( ckRefreshSe ) {
            ckRefresh.prop('checked', true);
        } else {
            F_refresh();
        }

        ckRefresh.change(function () {
            if ( ckRefresh.is(':checked') ) {
                //console.info('ckRefresh checked!');
                ckRefreshSe = true;
                sessionStorage.setItem(formId + '_ck_refresh', 1);

                clearInterval(_sit);
            }else {
                //console.info('ckRefresh uncheck!');
                ckRefreshSe = false;
                sessionStorage.removeItem(formId + '_ck_refresh');
                F_refresh();
            }
        });

        $('#se_tt').combobox({
            onChange:function(n){
                tt = n;
                if ( ckRefreshSe ) return;

                clearInterval(_sit);

                F_refresh();
            }
        });
    });
</script>


