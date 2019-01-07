<?php $id="form_auto_payment_id";?>
<table id="<?php echo $id;?>"></table>
<script>
    var auto_out_flag = false;
    var auto_out_process = false;
    var auto_out_timer = false;
    var auto_out_data = {};
    var tools = [
        {instant:false},
        {type:'textbox', text:'金額',   width:80,name:'price_start',value:'1'},
        {type:'textbox', text:'--',     width:80,name:'price_end',value:'500'},
        {type:'combobox',text:'代付通道',width:80,name:'apay_channel', value:'<?=$apay_channels[0]['doapay_api']?>', items:'<?php foreach($apay_channels as $k => $v){
                echo '<option value="'.htmlspecialchars($v['doapay_api']).'" '. ($k==0?'selected>':'>') . $v['out_online_name'] .'</option>';
            }
            ?>' },
        {type:'combobox',text:'发起时间',width:80,name:'addtime',value:'10', items:'<option value="10" selected>10分钟内</option><option value="30">30分钟内</option><option value="60">1小时内</option>'},
        {type: 'label', id:'fee_stop', html:'&nbsp;&nbsp;&nbsp;&nbsp;<input  type="checkbox" name="fee_stop">有行政费/手续费时不自动出款&nbsp;&nbsp;&nbsp;&nbsp;'},
        {type: 'label', id:'is_first', html:'<input  type="checkbox" name="is_first">首次出款不自动出款&nbsp;&nbsp;&nbsp;&nbsp;'},
        {type:'textbox', text:'指定人工备注出款',width:80,name:'people_remark',styler:function(){
            return 'padding-left:0px;';
        }},
        {type:'combobox',text:'刷新间隔',width:80,name:'cool_time',value:'10', items:'<option value="10" selected>10秒</option><option value="20">20秒</option><option value="30">30秒</option>'},
        {text:"搜索", iconCls:"icon-search", handler:function(){
            $('#<?php echo $id?>').DataSource('search');
            $('#<?php echo $id?>').datagrid('options').queryParams = {};
        }},
        '|'
    ];
    tools.push({type: 'label', html:'&nbsp;&nbsp;开始自动出款：<input type="checkbox" name="start_out" onchange="start_auto_out(this);">'});
    $("#<?php echo $id;?>").DataSource({url:'cash/get_auto_payment_list',
        fields:[[
            // {field:'id',      title:'ID',width:40,sortable:true},
            {field:'order_num',     title:'訂單號',width:150},
            {field:'user_name',title:'會員賬號',align:'center', width:100},
            {field:'bank_name',   title:'会员姓名', align:'center', width:80},
            {field:'is_first',   title:'首次', align:'center', width:80,formatter:function(v, r){
                if (v == undefined || v == '') {
                    return '';
                }
                if (r.is_first == '0') {
                    return '否';
                }else if(r.is_first == '1'){
                    return '<span style="color:red">是</span>';
                }
            }},
            {field:'balance',  title:'賬戶余額', align:'center', width:80,
                styler:function(v){
                    return v<=0?'color:#FF0000;':'';
                }
            },
            {field:'price',    title:'提款金額', align:'center', width:80},
            {field:'hand_fee', title:'手續費', align:'center', width:80},
            {field:'admin_fee',  title:'行政費',align:'center', width:80},
            {field:'actual_price',title:'實際出款金額',align:'center',width:90,
            styler:function(v){
                return v>=0?'background:#F8F8F8;color:#FF0000;':'';
            },formatter:function(v, r){
                if (r.o_status == 3 && r.status == 4) {
                    return '<span class="btn label label-danger" id="y_'+ r.id +'" onclick="get_base_info(this,'+r.id+','+r.uid+','+v+',\''+r.order_num+'\')">'+v+'</span>';
                } else {
                    return v;
                }
            }},
            {field:'status',  title:'狀態', align:'center', width:220,  sortable:true, formatter:function(v, r){
                var str = '';
                if (r.o_status != 0) {
                    if (r.o_status == 1) {
                        str += '<span class="label label-primary">代付出款中</span>&nbsp;'+
                            '<a herf="#" onclick=payment_doquery('+ r.index +',\''+r.order_num+'\',\''+r.queryapi+'\')><span class="btn label label-warning">查询</span></a>&nbsp;';
                    } else if (r.o_status == 3) {
                        str += '<span class="btn label label-warning">代付出款失败</span>&nbsp;'+
                            '<a herf="#" onclick=payment_unlock('+ r.index +',\''+r.order_num+'\')><span class="btn label label-warning">解锁</span></a>&nbsp;';
                    } else if (r.o_status == 2) {
                        str += '<span class="label label-success">已出款</span>';
                    } else if (r.o_status == 4) {
                        str += '<a herf="#" onclick=payment_doapay('+ r.index +',\''+r.order_num+'\')><span class="btn label label-danger">发起代付</span></a>&nbsp;'+
                            '<a herf="#" onclick=payment_unlock('+ r.index +',\''+r.order_num+'\')><span class="btn label label-warning">解锁</span></a>&nbsp;';
                    }
                } else {
                    if (r.status == '2') {
                        str += '<span class="label label-success">已出款</span>';
                    } else if (r.status == '5') {
                        str += '<span class="label label-danger">已取消</span>';
                    } else if (r.status == '4') {
                        str += '<a herf="#" onclick=payment_doapay('+ r.index +',\''+r.order_num+'\')><span class="btn label label-danger">发起代付</span></a>&nbsp;';
                    } else if(r.status == '3'){
                        str += '<span class="btn label label-warning">已拒絕</span>';
                    } else if(r.status == '1'){
                        str += '<a herf="#" onclick=payment_cancel('+ r.index +','+r.id+')><span class="btn label label-danger">取消</span></a>&nbsp;'+
                            '<a herf="#" onclick=payment_refuse('+ r.index +','+r.id+')><span class="btn label label-warning">拒絕</span></a>&nbsp;';
                    }
                }
                return str;
              }},
            {field:'admin_name',  title:'操作者', align:'center', width:80},
            {field:'addtime',  title:'出款日期',align:'center', width:200,  sortable:true, formatter: function (v, r) {
                if (v == undefined) {
                    return '';
                }
                return '系統時間：' + r.addtime + '<br/>操作時間：' + r.updated;
            }},
            {field:'people_remark',  title:'人工備註', align:'left', width:95},
            {field:'remark',  title:'備註', align:'left', width:550},
        ]],
        rows:500,
        tools: tools,
        footer:false,
        checkbox:false,
        success:function (e,data) {
            auto_out_data = data;
            start_auto_out();
        }
    });


    function start_auto_out(e) {
        if (e) {
            auto_out_flag = e.checked;
        }
        if (auto_out_timer) {
            clearTimeout(auto_out_timer);
        }
        if (auto_out_process) {
            auto_out_process = !auto_out_process;
            if (!auto_out_flag) $('#form_<?php echo $id; ?> .button-primary').removeAttr("disabled");
            return false;
        }
        if (auto_out_flag) {
            $('#form_<?php echo $id; ?> .button-primary').attr("disabled","disabled");
            auto_out_process = true;
            parment_auto_out();
            var auto_out_cd = $('#form_<?php echo $id; ?> input[name="cool_time"]').val();
            auto_out_timer = setTimeout(function () {
                $('#<?php echo $id?>').DataSource('search');
            },auto_out_cd*1000);
        } else {
            $('#form_<?php echo $id; ?> .button-primary').removeAttr("disabled");
        }
    }


    function parment_auto_out() {
        if (!auto_out_flag)return false;
        if (!auto_out_data.total)return false;
        var formId = 'form_<?php echo $id; ?>';
        var price_min = $('#'+ formId +' input[name="price_start"]').val();
        var price_max = $('#'+ formId +' input[name="price_end"]').val();
        var apay_query_time = parseInt((new Date()).getTime()/1000) - 600;//超过10分钟的走代付查询接口
        for(var i=0;i<auto_out_data.total;i++) {
            var item = auto_out_data.rows[i];
            if (auto_out_flag === true) {
                if (item['status']==4 && item['o_status']==4 && item['actual_price'] >= price_min && item['actual_price'] <= price_max) {
                    // 预备出款&&代付状态锁定&&符合金额范围
                    payment_doapay(i,item['order_num']);
                } else if (item['status']==4 && item['o_status']==1 && item['apay_at']<apay_query_time) {
                    // 预备出款&&代付出款中&&距离代付发起时间超过10分钟
                    payment_doquery(i,item['order_num'],item['queryapi']);
                }
            }

        }

    }

    function payment_doapay(index,order_num) {
        var formId = 'form_<?php echo $id; ?>';
        var apay_api = $('#'+ formId +' input[name="apay_channel"]').val();
        var query_api = apay_api.replace('doapay', "doquery");
        $.ajax({
            url: WEB + 'cash/ajax_auto_doapay',
            data: {
                order_num: order_num,
                doapay_api:apay_api
            },
            type: 'post',
            cache: false,
            async: false,
            dataType: 'json',
            success: function (data) {
                Core.ok(data.msg);
                if (data.code == 200) {
                    $("#<?php echo $id?>").datagrid("updateRow",{
                        index:index,
                        row:{
                            status:4,
                            o_status:1,
                            queryapi:query_api
                        }
                    });
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                    $('#<?=$id?>').html(XMLHttpRequest.responseText);
                } else {
                    Core.error('接口請求異常 '+XMLHttpRequest.status+' '+textStatus);
                }
            }
        });

    }

    function payment_doquery(index,order_num,doquery_api) {
        if (!doquery_api) return false;
        $.ajax({
            url: WEB + 'cash/ajax_auto_doquery',
            data: {
                order_num: order_num,
                doquery_api:doquery_api
            },
            type: 'post',
            cache: false,
            async: false,
            dataType: 'json',
            success: function (data) {
                Core.ok(data.msg);
                if (data.code == 200) {
                    $("#<?php echo $id?>").datagrid("updateRow",{
                        index:index,
                        row:{
                            status:2,
                            o_status:2
                        }
                    });
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                    $('#<?=$id?>').html(XMLHttpRequest.responseText);
                } else {
                    Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                }
            }
        });

    }

    function payment_unlock(index,order_num) {
        var formId = 'form_<?php echo $id; ?>';
        $('#'+ formId +' input[name="start_out"]').attr("checked",false);
        $.ajax({
            url: WEB + 'cash/ajax_unlock_apay',
            data: {
                order_num: order_num
            },
            type: 'post',
            cache: false,
            async: false,
            dataType: 'json',
            success: function (data) {
                Core.ok(data.msg);
                $("#<?php echo $id?>").DataSource("search");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                    $('#<?=$id?>').html(XMLHttpRequest.responseText);
                } else {
                    Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                }
            }
        });

    }

    function payment_cancel(index,id)
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
                        if (data.code == 200) {
                            $("#<?php echo $id?>").datagrid("updateRow",{
                                index:index,
                                row:{
                                    status:4,
                                    o_status:0
                                }
                            });
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                            $('#<?=$id?>').html(XMLHttpRequest.responseText);
                        } else {
                            Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                        }
                    }
                });
        },true,false);
    }


    function payment_refuse(index,id)
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
                    if (data.code == 200) {
                        $("#<?php echo $id?>").datagrid("updateRow",{
                            index:index,
                            row:{
                                status:3,
                                o_status:0
                            }
                        });
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                        $('#<?=$id?>').html(XMLHttpRequest.responseText);
                    } else {
                        Core.error('接口請求異常 '+XMLHttpRequest.status+' '+textStatus);
                    }
                }
            });
        },true,false);
    }

</script>