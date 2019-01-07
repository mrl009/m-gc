<?php $id="form_payment_id";?>
<table id="<?php echo $id;?>"></table>
<script>
    var ck = sessionStorage.getItem('ck');
    var ck_refresh = sessionStorage.getItem('ck_refresh');
    var tools = [
        {instant:false},
        <?php if(in_array('EXPORT',$auth)){?>
        {text:'導出',iconCls:'icon-large-chart',handler:function(){
            Core.ExportJs($("#<?php echo $id;?>"),'出款管理');
        }},
        <?php }?>
        {type:'combobox',text:'層級',width:100,name:'levels',value:'', items:'<option value="">所有層級</option><?php foreach($level as $v){echo "<option value=$v[id]>$v[level_name]</option>"; }?>'},
        {type:'combobox',text:'狀態',width:80,name:'status',value:'', items:'<option value="" selected>全部</option><option value="1">未確認</option><option value="2">已出款</option><option value="3">已拒絕</option><option value="4">正在出款</option><option value="5">已取消</option>'},
        {type: 'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
        {type: 'label', html:'<input type="hidden" name="agent_id" value="">'},
        {type:'combobox',text:'时间',width:90,name:'time_type',items:'<option value="1">系统时间</option><option value="2">操作时间</option>'},
        {type:'datebox', text:'日期',   width:100,name:'time_start'},
        {type:'datebox', text:'-',     width:100,name:'time_end'},
        {type:'textbox', text:'金額',   width:50,name:'price_start'},
        {type:'textbox', text:'-',     width:50,name:'price_end'},
        {type:'combobox',text:'出款來源',width:80,name:'froms',value:'', items:'<option value="">全部</option><option value="1">IOS端</option><option value="2">Android端</option><option value="3">PC端</option><option value="4">WAP</option><option value="5">未知</option>'},
        {type: 'combobox',text: '首存',width: 30,name: 'is_first',value: '',
            items:'<option value="">全部</option><option value="0">否</option><option value="1">是</option>'
        },
        {type:'textbox', text:'賬號',     width:90,name:'f_username'},
        {type: 'textbox', text: '操作者', width: 80, name: 'f_admin'},
        {text:"搜索", iconCls:"icon-search", handler:function(){
            var start = $("#form_<?php echo $id?> input[name='time_start']").val();
            var end = $("#form_<?php echo $id?> input[name='time_end']").val();
            if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                Core.error('查詢區間限制為兩個月');
                return false;
            }
            $('#<?php echo $id?>').DataSource('search');
        }},
        '|',
        {type:'combobox',text:'提示間隔',width:60,name:'cktimelong',value:'',
            items:'<option value="10">10秒</option><option value="20">20秒</option><option value="30">30秒</option><option value="40">40秒</option>'},
    ];
    if (ck) {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉提示音：<input type="checkbox" id="close-ck" onclick="closeCk()" checked>'})
    } else {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉提示音：<input type="checkbox" id="close-ck" onclick="closeCk()">'})
    }
    if (ck_refresh) {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉刷新：<input type="checkbox" id="close-ck-refresh" onclick="closeCkRefresh()" checked>'})
    } else {
        tools.push({type: 'label', html:'&nbsp;&nbsp;關閉刷新：<input type="checkbox" id="close-ck-refresh" onclick="closeCkRefresh()">'})
    }
    $("#<?php echo $id;?>").DataSource({url:'cash/get_payment_list?<?php echo $skip; ?>',
        fields:[[
            // {field:'id',      title:'ID',width:40,sortable:true},
            {field:'order_num',     title:'訂單號',width:150,sortable:false},
            {field:'leve_name',   title:'層級', align:'center', width:80, sortable:true},
            {field:'user_name',title:'會員賬號',align:'center', width:100,sortable:true,formatter:function(v, r){
                if (v == undefined || v == '') {
                    return '';
                }
               return '<span class="label label-danger" ondblclick="get_audit('+r.uid+',0)">'+v+'</span>';
            }},
            {field:'bank_name',   title:'会员姓名', align:'center', width:80},
            {field:'agent_name',   title:'所屬代理', align:'center', width:80, sortable:true},
            {field:'balance',  title:'賬戶余額', align:'center', width:80,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'';
                    }
                },
            {field:'is_first',title:'首次', align:'center', width:50,  sortable:true,formatter:function(v, r){
                    if (v == undefined || v == '') {
                        return '';
                    }
                    if (r.is_first == '0') {
                        return '否';
                    }else if(r.is_first == '1'){
                        return '<span style="color:red">是</span>';
                    }
            }},
            {field:'price', title:'提款金額', align:'center', width:80,sortable:true,
                formatter:function(v, r)
                {
                    return '<span style="font-size:15px;">'+ r.price + '</span>';
                }
            },
            {field:'hand_fee', title:'手續費', align:'center', width:80, sortable:true,formatter:function(v,r){
                if (r.o_status != 1 && (r.status==1 || r.status==4)) {
                    return '<span class="btn label label-primary" onclick="edit_payment('+r.id+','+r.hand_fee+','+r.admin_fee+')"><u>'+v+'</u></span>'
                }
                return v;
            }},
            {field:'admin_fee',  title:'行政費',align:'center', width:80,  sortable:true,formatter:function(v,r){
                if (r.o_status != 1 && (r.status==1 || r.status==4)) {
                    return '<span class="btn label label-primary" onclick="edit_payment('+r.id+','+r.hand_fee+','+r.admin_fee+')"><u>'+v+'</u></span>'
                }
                return v;
            }},
            {field:'is_pass',  title:'稽核', align:'center',width:60,  sortable:true,formatter:function(v, r){
                if (v == undefined) {
                    return '';
                }
                if(r.status == 1){
                    return '<span class="btn label label-danger" onclick="get_audit('+r.uid+',1)">稽核</span>';
                }else{
                    return '-';
                }
            }},
            {field:'actual_price',title:'實際出款金額',align:'center',width:90, sortable:true,
            styler:function(v){
                return v>=0?'background:#F8F8F8;color:#FF0000;':'';
            },formatter:function(v, r){
                if (r.o_status != 1 && r.status == '4') {
                    return '<span style="font-size:15px;" class="btn label label-danger" id="y_'+ r.id +'" onclick="get_base_info(this,'+r.id+','+r.uid+','+v+',\''+r.order_num+'\')">'+v+'</span>';
                } else {
                    return '<span style="font-size:15px;">'+ v + '</span>';
                }
            }},
            {field:'status',  title:'狀態', align:'center', width:220,  sortable:true, formatter:function(v, r){
                var str = '';
                if (r.status == '1') {
                    str += '<a herf="#" onclick=payment_pre('+r.id+','+r.uid+','+r.actual_price+',\''+r.order_num+'\');><span class="btn label label-info">預備出款</span></a>&nbsp;'+
                        '<a herf="#" onclick=payment_cancel('+r.id+')><span class="btn label label-danger">取消</span></a>&nbsp;'+
                        '<a herf="#" onclick=payment_refuse('+r.id+')><span class="btn label label-warning">拒絕</span></a>&nbsp;';
                } else if (r.status == '2') {
                    if (r.o_status > 0) {
                        str += r.admin_name.toLocaleLowerCase() == 'syszdchukuan' ? '<span class="label label-success">代付已出款</span>' : '<span class="label label-success">已出款</span>';
                    } else {
                        str += '<span class="label label-success">已出款</span>';
                    }
                } else if (r.status == '3') {
                    str += '<span class="label label-warning">已拒絕</span>';
                } else if (r.status == '4') {
                    if ( r.o_status == 0 ) {
                        str += '<span class="label label-primary">正在出款</span>';
                    } else if (r.o_status == 1) {
                        str += '<span class="label label-primary">代付出款中</span>';
                    } else if (r.o_status == 3) {
                        str += r.admin_name.toLocaleLowerCase() == 'syszdchukuan' ? '<span class="label label-danger">代付出款失败</span>' : '<span class="label label-primary">正在出款</span>';
                    } else if (r.o_status == 4) {
                        str += '<span class="label label-success">自动出款锁定</span>';
                    }
                } else if (r.status == '5') {
                    str += '<span class="label label-danger">已取消</span>';
                }
                return str;
              }},
            {field:'admin_name',  title:'操作者', align:'center', width:80,  sortable:true},
            {field:'from_way',title:'來源', align:'center', width:35,formatter:function(v,r){
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
            {field:'addtime',  title:'出款日期',align:'center', width:200,  sortable:true, formatter: function (v, r) {
                if (v == undefined) {
                    return '';
                }
                return '系統時間：' + r.addtime + '<br/>操作時間：' + r.updated;
            }},
            {field:'people_remark',  title:'人工備註', align:'left', width:95,
 formatter: function (v, r) {
                if (v == undefined) {
                    return '';
                }
                return '<div title="单击编辑备注" style="height: 100%" onclick=payment_remark('+r.id+',\''+v+'\')>&nbsp;<span>'+ v +'</span>&nbsp;</div>';
            }},
            {field:'remark',  title:'備註', align:'left', width:550,  sortable:true},
        ]], tools: tools,
        footer:true,
        checkbox:false,
        success:function () {
            Core.agentLog('<?php echo $id?>');
        }
    });

    function payment_pre(id,uid,price,order_num)
    {
        var url = '/cash/ajax_company_do';
        var status = 4;
        //發送http請求
        $.messager.confirm('溫馨提示', '確定要預備出款嗎？', function(r){
            if (r){
                $.ajax({
                    url: url,// 跳轉到 action
                    data: {
                        id: id,
                        status:status
                    },
                    type: 'post', //用post方法
                    cache: false,
                    dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                    success: function (data) {
                        if (data.code == 200) {
                            $('#<?php echo $id?>').datagrid('reload');
                            get_base_info(undefined,id,uid,price,order_num);
                        } else {
                            Core.error(data.msg);
                        }
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


    function payment_cancel(id)
    {
        var url = '/cash/ajax_company_do';
        var status = 5;

        Core.dialog('取消備註(不超過100個字)','cash/payment_cancel',function(){
            var remark = $("#remark").val();
            $.ajax({
                    url: url,// 跳轉到 action
                    data: {
                        id: id,
                        status:status,
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

    function payment_refuse(id)
    {
        var url = '/cash/ajax_company_do';
        var status = 3;
        Core.dialog('拒絕備註(不超過100個字)','cash/payment_cancel',function(){
            var remark = $("#remark").val();
            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    id: id,
                    status:status,
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


    function payment_remark(id,str)
    {
        var url = '/cash/ajax_remark_do';
        Core.dialog('人工備註(不超過100個字)','cash/payment_cancel?people_remark='+str,function(){
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

    function edit_payment(id,hand_fee,admin_fee){
        Core.dialog('修改出款訂單','cash/edit_payment?id='+id+'&hand_fee='+hand_fee+'&admin_fee='+admin_fee,function(){
            $('#<?php echo $id?>').datagrid('reload');
        },true,false);
    }
    function get_audit(uid, is_audit){
        Core.dialog('修改出款訂單', 'member/edit_member?tab=audit&uid=' + uid + '&is_audit=' + is_audit, function () {
            $('#<?php echo $id?>').datagrid('reload');
        },true,70);
    }
    function get_base_info(e,id,uid,actual_price,order_num) {
        e?e.onclick=null:undefined;
        var url = '/cash/ajax_admin_match_do';
        $.ajax({
                    url: url,// 跳轉到 action
                    data: {
                        id: id,
                    },
                    type: 'post', //用post方法
                    cache: false,
                    dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                    success: function (data) {
                        if (data.code == 200) {
                            $(".modal-backdrop").remove();
                            Core.dialog('修改出款訂單','member/edit_member?tab=payment&form_id=<?php echo $id;?>&uid='+uid+'&payment_id='+id+'&actual_price='+actual_price+'&order_num='+order_num+'&is_actual=1',function(){$('#<?php echo $id?>').datagrid('reload');},true,70,undefined,undefined,undefined,undefined,true);
                            //Core.dialog('修改出款订单','member/get_payment?form_id=<?php //echo $id;?>//&uid='+uid+'&id='+id+'&actual_price='+actual_price+'&order_num='+order_num,function(){$('#<?php //echo $id?>//').datagrid('reload');},true,70,undefined,undefined,undefined,undefined,true);
                        } else {
                            Core.error(data.msg);
                        }
                        e?e.onclick=function(){get_base_info(e,id,uid,actual_price,order_num);}:undefined;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                            $('#<?php echo $id;?>').html(XMLHttpRequest.responseText);
                        } else {
                            Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                        }
                        e?e.onclick=function(){get_base_info(e,id,uid,actual_price,order_num);}:undefined;
                    }
                });
    }
    $(function(){
        //30秒出款
        if (ck != 1 || ck_refresh != 1) {
            clearInterval(ckInterval);
            var ck_params = getCkParams();
            ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params);}, 30*1000);
        }
        $('#form_form_payment_id #cktimelong').combobox({
            onChange:function(n){
                ck = sessionStorage.getItem('ck');
                ck_refresh = sessionStorage.getItem('ck_refresh');
                if (ck != 1 || ck_refresh != 1) {
                    clearInterval(ckInterval);
                    var ck_params = getCkParams();
                    ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},n*1000);
                }
            }
        });
        $('#form_form_payment_id #status').combobox({
            onChange:function(n){
                ck = sessionStorage.getItem('ck');
                ck_refresh = sessionStorage.getItem('ck_refresh');
                if (ck != 1 || ck_refresh != 1) {
                    clearInterval(ckInterval);
                    var time = $('#form_form_payment_id input[name="cktimelong"]').val();
                    time = time || 30;
                    var ck_params = getCkParams();
                    ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},time*1000);
                }
            }
        });
        $('#form_form_payment_id #levels').combobox({
            onChange:function(n){
                ck = sessionStorage.getItem('ck');
                ck_refresh = sessionStorage.getItem('ck_refresh');
                if (ck != 1 || ck_refresh != 1) {
                    clearInterval(ckInterval);
                    var time = $('#form_form_payment_id input[name="cktimelong"]').val();
                    time = time || 30;
                    var ck_params = getCkParams();
                    ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},time*1000);
                }
            }
        });
        // $('#form_form_payment_id #froms').combobox({
        //     onChange:function(n){
        //         ck = sessionStorage.getItem('ck');
        //         ck_refresh = sessionStorage.getItem('ck_refresh');
        //         if (ck != 1 || ck_refresh != 1) {
        //             clearInterval(ckInterval);
        //             var time = $('#form_form_payment_id input[name="cktimelong"]').val();
        //             time = time || 30;
        //             var ck_params = getCkParams();
        //             ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},time*1000);
        //         }
        //     }
        // });
        // $('#form_form_payment_id #is_first').combobox({
        //     onChange:function(n){
        //         ck = sessionStorage.getItem('ck');
        //         ck_refresh = sessionStorage.getItem('ck_refresh');
        //         if (ck != 1 || ck_refresh != 1) {
        //             clearInterval(ckInterval);
        //             var time = $('#form_form_payment_id input[name="cktimelong"]').val();
        //             time = time || 30;
        //             var ck_params = getCkParams();
        //             ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},time*1000);
        //         }
        //     }
        // });
    });
    function closeCk() {
        clearInterval(ckInterval);
        ck = sessionStorage.getItem('ck') ? 0 : 1;
        ck_refresh = sessionStorage.getItem('ck_refresh');
        if (ck == 1) {
            sessionStorage.setItem('ck', 1);
        } else {
            sessionStorage.removeItem('ck');
        }
        if (ck != 1 || ck_refresh != 1) {
            var n = $("#form_<?php echo $id?> input[name='cktimelong']").val();
            n = n ? n : 30
            var ck_params = getCkParams();
            ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},n*1000);
        }
    }

    function closeCkRefresh() {
        clearInterval(ckInterval);
        ck = sessionStorage.getItem('ck');
        ck_refresh = sessionStorage.getItem('ck_refresh') ? 0 : 1;
        if (ck_refresh == 1) {
            sessionStorage.setItem('ck_refresh', 1);
        } else {
            sessionStorage.removeItem('ck_refresh');
        }
        if (ck != 1 || ck_refresh != 1) {
            var n = $("#form_<?php echo $id?> input[name='cktimelong']").val();
            n = n ? n : 30
            var ck_params = getCkParams();
            ckInterval = setInterval(function(){Core.user_out(ck,ck_refresh,ck_params)},n*1000);
        }
    }

    function getCkParams() {
        var status = $('#form_form_payment_id input[name="status"]').val();
        var levels = $('#form_form_payment_id input[name="levels"]').val();
        var froms = $('#form_form_payment_id input[name="froms"]').val();
        var is_first = $('#form_form_payment_id input[name="is_first"]').val();
        var time_type = $('#form_form_payment_id input[name="time_type"]').val();
        return {
            'levels': levels,
            'status': status,
            'froms': froms,
            'is_first': is_first,
            'time_type': time_type
        };
    }
</script>