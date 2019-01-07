<?php $id="form_".uniqid();?>
<?php $form_id="form_".uniqid();?>
<table id="<?php echo $id;?>" class="fl table text-center" style="margin-bottom: 0;margin-top: 10px">
    <tr>
        <td rowspan="2" bgcolor="#f2f2f2">公司申请入款列表</td>
        <td>
            订单号：<span class="l_order_num"></span><br>
            存款人：<span class="l_people"></span><br>
            存款金额：<span class="l_money"></span>
        </td>
        <td>
            <button type="button" class="btn btn-danger" onclick="c_relate_company_auto()">公司关联入款</button>
        </td>
        <td>
            存款人：<span class="r_people"></span><br>
            存款金额：<span class="r_money"></span>
        </td>
        <td rowspan="2" bgcolor="#f2f2f2">银行处理信息核对列表</td>
    </tr>
</table>
<div style="width: 50%;height: 530px" class="fl">
    <table id="c_form_company_id"></table>
</div>
<div style="width: 50%;height: 530px" class="fl">
    <table id="<?php echo $form_id;?>"></table>
</div>
<script>
    var limit_time = '<?php echo $limit_time?>';

    $("#c_form_company_id").DataSource({url:'cash/get_auto_deposit_list?status=1',
        fields:[[
            {field:'loginname', title:'会员账号', align: 'center', width:80, sortable:false},
            {field:'agent_name', title:'存款人与时间',   width:150, sortable:false,formatter: function (v, r) {
                return '存款人:' + r.user_name + '<br/>時間:' + r.addtime + '<br/>订单号:' + r.order_num;
            }},
            {field:'order_num',  title:'存入金額與優惠',   width:150, sortable:false,formatter: function (v, r) {
                return '提交金額:' + r.price + '<br/>存款/優惠:' + r.price + '/' + r.discount_price + '<br/>銀行:' + r.bank_name + '<br/>方式:' + r.bank_style;
            }},
            {field:'type',  title:'存入銀行帳戶', align: 'center', width:160, sortable:false,formatter: function (v, r) {
                return '卡主:' + r.card_name + '<br/> 銀行:' + r.bank_name + '<br/>' + '卡號:' + r.card_num;
            }},
            {field: 'status', title: '操作', align: 'center', width: 160, sortable: false, formatter: function (v, r) {
                var str = '';
                if (r.status == '2') {
                    str += '<span class="label label-success">已確認</span>';
                } else if (r.status == '3') {
                    str += '<span class="label label-danger">已取消</span>';
                } else {
                    if(r.limit < 0){
                        str += '<span class="label label-success">暂时无法操作</span>';
                    }else{
                        str += '<a onclick=c_deposit_cancel(' + r.id + ',' + r.timestamp + ');><span class="btn label label-default">取消存款</span></a>&nbsp;' +
                            '<a onclick=c_deposit_confirm(' + r.id + ',' + r.timestamp + ');><span class="btn label label-primary">確認入款</span></a>&nbsp;';
                    }
                }

                return str;
            }}
        ]],
        tools:[
            {instant:false},
            {type:'datebox',text:'提交时间',width: 98, name: 'time_start'},
            {type:'datebox',text:'',width: 98, name: 'time_end'},
            {type:'textbox',text:'金額',width: 50, name: 'price_start'},
            {type:'textbox',text:'',width: 50, name: 'price_end'},
            {type:'textbox',text:'會員帳號',width:120,name:'f_username'},
            {type:'combobox',text:'狀態',width: 30,name: 'status',value: '', items: '<option value="" selected>全部</option><option value="1">未確認</option><option value="2">已確認</option><option value="3">已取消</option>'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#c_form_company_id').DataSource('search');
            }},
            '-'
        ],
        edit:true,
        footer:false,
        onClickRow: function (i, d) {
            $('#<?php echo $id?> .l_order_num').html(d.order_num)
            $('#<?php echo $id?> .l_people').html(d.user_name)
            $('#<?php echo $id?> .l_money').html(d.price)
        }
    });

    $("#<?php echo $form_id;?>").DataSource({url:'cash/get_auto_list',
        fields:[[
            {field:'r_money',title:'存入金额/方式',width:180,align: 'center',sortable:false,formatter: function (v, r) {
                return '存款:' + r.pay_amount + '<br/>時間:' + r.pay_time + '<br/>订单号:' + r.order_num;
            }},
            {field:'t_money',title:'用户银行账户',width:180,align: 'center',sortable:false,formatter: function (v, r) {
                return '卡主:' + r.pay_card_name + '<br/>卡號:' + r.pay_card_num;
            }},
            {field:'p_money',title:'收款银行账户',width:180,align: 'center',sortable:false,formatter: function (v, r) {
                return '卡號:' + r.card_num + '<br/>方式:' + r.pay_channel;
            }},
            {field: 'status', title: '操作', align: 'center', width: 150, sortable: false, formatter: function (v, r) {
                var str = '';
                if (r.status == '1') {
                    str += '<span class="label label-success">已确认入款</span>';
                } else if (r.status == '2') {
                    str += '<span class="label label-default">出帐</span>';
                } else if (r.status == '3') {
                    str += '<span class="label label-default">无法核对</span>';
                } else {
                    str += '<a onclick=c_auto_confirm(' + r.id + ');><span class="btn label label-info">确认入款</span></a>&nbsp;' +
                        '<a onclick=c_auto_cancel(' + r.id + ');><span class="btn label label-primary">无法核对</span></a>&nbsp;';
                }
                return str;
            }}
        ]], tools:[
            {instant:false},
            {type:'combobox',text:'狀態',width: 30,name: 'status',value: '', items: '<option value="" selected>全部</option><option value="0">未入款</option><option value="1">已入账</option><option value="3">不作处理</option>'},
            {type:'textbox',text:'存款人姓名',width:120,name:'pay_card_name'},
            {type:'datebox',text:'收款时间',width: 98, name: 'time_start'},
            {type:'datebox',text:'',width: 98, name: 'time_end'},
            {type:'textbox',text:'金額',width: 50, name: 'price_start'},
            {type:'textbox',text:'',width: 50, name: 'price_end'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                    $('#<?php echo $form_id?>').DataSource('search');
                }},
            '-'
        ],
        edit:true,
        footer:true,
        onClickRow: function (i, d) {
            $('#<?php echo $id?> .r_people').html(d.pay_card_name)
            $('#<?php echo $id?> .r_money').html(d.pay_amount)
        }
    });

    $(function () {
        clearInterval(cInterval);
        cInterval = setInterval(function () {
            Core.c_user_in()
        }, 300 * 1000);
    });

    function c_deposit_cancel(id, timestamp) {
        var date = new Date().getTime() - timestamp * 1000;
        var minute = Math.floor(date / (60 * 1000))
        if (limit_time != 0 && minute < limit_time) {
            Core.error(limit_time + '分钟内不能操作');
            return false;
        }
        Core.dialog('取消備註(不超過100個字)', 'cash/payment_cancel', function () {
            var remark = $("#remark").val();
            $.ajax({
                url: '/cash/ajax_deposit_operation',
                data: {
                    id: id,
                    status: 3,
                    remark: remark
                },
                type: 'post',
                cache: false,
                dataType: 'json',
                success: function (data) {
                    Core.ok(data.msg);
                    $('#c_form_company_id').datagrid('reload');
                },
                error: function (data) {
                    Core.error(data.msg);
                }
            });

        }, true, false);
    }

    function c_deposit_confirm(id, timestamp) {
        var date = new Date().getTime() - timestamp * 1000;
        var minute = Math.floor(date / (60 * 1000))
        if (limit_time != 0 && minute < limit_time) {
            Core.error(limit_time + '分钟内不能操作');
            return false;
        }
        $.messager.confirm('溫馨提示', '確定要確認存款嗎？', function (r) {
            if (r) {
                $.ajax({
                    url: '/cash/ajax_deposit_operation',
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
                        $('#c_form_company_id').datagrid('reload');
                    },
                    error: function (data) {
                        Core.error(data.msg);
                    }
                });
            }
        });


    }

    function c_auto_cancel(id) {
        $.messager.confirm('溫馨提示', '确定无法核对审核信息？', function (r) {
            if (r) {
                $.ajax({
                    url: '/cash/ajax_auto_confirm',
                    data: {
                        id: id,
                        status: 3,
                        remark: ''
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.ok(data.msg);
                        $('#<?php echo $form_id?>').datagrid('reload');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        Core.error('異常'+XMLHttpRequest.status+' '+textStatus);
                    }
                });
            }
        });
    }

    function c_auto_confirm(id) {
        $.messager.confirm('溫馨提示', '確定要確認存款嗎？', function (r) {
            if (r) {
                $.ajax({
                    url: '/cash/ajax_auto_confirm',
                    data: {
                        id: id,
                        status: 1,
                        remark: ''
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.ok(data.msg);
                        $('#<?php echo $form_id?>').datagrid('reload');
                    },
                    error: function (data) {
                        Core.error(data.msg);
                    }
                });
            }
        });
    }

    function c_relate_company_auto() {
        var d = $("#c_form_company_id").datagrid('getSelected');
        var t = $("#<?php echo $form_id;?>").datagrid('getSelected');
        if (d == null || t == null) {
            Core.error('请选择需要关联的数据');
            return false;
        }
        if (d.status != 1 || t.status != 0) {
            Core.error('已经处理过的数据不需要再处理');
            return false;
        }

        var date = new Date().getTime() - d.timestamp * 1000;
        var minute = Math.floor(date / (60 * 1000))
        if (limit_time != 0 && minute < limit_time) {
            Core.error(limit_time + '分钟内不能操作');
            return false;
        }

        $.messager.confirm('溫馨提示', '確定要关联公司入款嗎？', function (r) {
            if (r) {
                $.ajax({
                    url: '/cash/ajax_relate_auto_confirm',
                    data: {
                        id: d.id,
                        aid: t.id,
                        remark: ''
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.ok(data.msg);
                        $('#c_form_company_id').datagrid('reload');
                        $('#<?php echo $form_id?>').datagrid('reload');
                    },
                    error: function (data) {
                        Core.error(data.msg);
                    }
                });
            }
        });
    }
</script>