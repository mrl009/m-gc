<?php $id = "form_" . uniqid(); ?>
<table id="<?php echo $id; ?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'cash/getlist',
        fields: [[
            {field: 'id', title: 'ID', align: 'center', width: 100, sortable: true},
            {
                field: 'user', title: '用戶名', align: 'center', width: 150, sortable: true, formatter: function (v, r) {
                if(r.username == "" ||r.username == null ){
                    return '-';
                }else{
                    return r.username;
                }

            }
            },
            {field: 'pwd', title: '彩豆密', align: 'center', width: 150, sortable: true},
            {field: 'price', title: '卡片金額', align: 'center', width: 150, sortable: true},
            {field: 'use_time', title: '充值日期', align: 'center', width: 150, sortable: true,formatter: function (v, r) {
                if(r.use_time != 0){
                    return r.use_time;
                }else{
                    return '-';
                }

            }},
            {
                field: 'charge_ip',
                title: '充值IP【次數】',
                align: 'center',
                width: 150,
                sortable: true,
                formatter: function (v, r) {

                    var ip = r.ip;
                    var ip_count = r.ip_count;
                    if(r.ip == null){
                        return '- ';
                    }else{
                        if(r.ip_count == null){
                            ip_count = 0;
                        }
                        return '<span onclick="get_ip_location(\''+ip+'\')"><u>'+ip + '[' + ip_count + ']'+'</u></span>';
                    }


                }
            },
            {field:'from_way',title:'來源', align: 'center', width:35,formatter:function(v,r){
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
                field: 'op', title: '操作', width: 250, align: 'center', sortable: true, formatter: function (v, r) {


                if(r.is_used == 1){
                    var text = null;
                    if (r.ip_status == 1) {
                        text = '<a herf="#" onclick=ip_op(2,' + r.uid + ')><span class="btn label label-danger">封IP</span></a>&nbsp;&nbsp;';
                    } else {
                        text = '<a herf="#" onclick=ip_op(1,' + r.uid + ')><span class="btn label label-success">解封IP</span></a>&nbsp;&nbsp;';
                    }

                    if (r.is_card == 1) {
                        text += '<a herf="#" onclick=user_op(2,' + r.uid + ')><span class="btn label label-warning">封用戶</span></a>&nbsp;&nbsp;';
                    } else {

                        text += '<a herf="#" onclick=user_op(1,' + r.uid + ')><span class="btn label label-info">解封用戶</span></a>&nbsp;&nbsp;';
                    }
                    return text;
                }else{
                    return '<span class="label label-default">未使用</span>';
                }


                }
            }

        ]], tools: [
            {instant: false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'彩豆入款');
            }},
            <?php }?>
            <?php if(in_array('EDIT', $auth)){?>
            {
                text: "設置", iconCls: "icon-edit", handler: function () {
                Core.dialog('彩豆設置', 'cash/coupon_edit', function () {
                }, true, '20%');
            }
            },
            <?php } ?>
            
            
            /*{
                type: 'combobox',
                text: '使用情況',
                width: 100,
                name: 'use',
                value: '1',
                items: '<option value="1">已使用</option><option value="2">未使用</option>'
            },*/
            {
                type: 'combobox', text: '編號', width: 100, name: 'ymt', value: '', items: '<?php foreach ($level as $v) {
                echo "<option value=$v>$v</option>";
            }?>'
            },
 //           {type: 'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type: 'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type: 'datebox', text: '充值日期', width: 100, name: 'time_start'},
            {type: 'datebox', text: '-', width: 100, name: 'time_end'},
            {
                type: 'combobox',
                text: '類型',
                width: 100,
                name: 'type',
                value: '2',
                items: '<option value="1">用戶名</option><option value="2">彩豆密</option><option value="3">充值過的IP</option>'
            },
            {type: 'textbox', text: '', width: 150, name: 'chaxun'},
            {type: 'textbox', text: '操作者', width: 130, name: 'f_admin'},
            {text: "搜索", iconCls: "icon-search", handler: function () {
                var chaxun = $("#form_<?php echo $id?> input[name='chaxun']").val();
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (chaxun == '' && start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }
            },
            '-'
        ],
        checkbox: false,
        footer: true,
        success: function () {
            Core.agentLog('<?php echo $id?>');
        }
    });

    function user_op(n, uid) {
        var is_card = n;
        var uid_val = uid;
        var url = 'cash/ajax_op_user';

        if (n == 1) {
            $.messager.confirm('溫馨提示', '確定解封用戶嗎', function (r) {
                if (r) {
                    $.ajax({
                        url: url,// 跳轉到 action
                        data: {
                            is_card: is_card,
                            uid: uid_val
                        },
                        type: 'post', //用post方法
                        cache: false,
                        dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                        success: function (data) {
                            if(data.code == 200){
                                Core.ok(data.data.msg);
                                Core.refresh();
                            }else{
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
        } else if (n == 2) {
            $.messager.confirm('溫馨提示', '確定封鎖用戶嗎？', function (r) {
                if (r) {
                    $.ajax({
                        url: url,// 跳轉到 action
                        data: {
                            is_card: is_card,
                            uid: uid_val
                        },
                        type: 'post', //用post方法
                        cache: false,
                        dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                        success: function (data) {
                            if(data.code == 200){
                                Core.ok(data.data.msg);
                                Core.refresh();
                            }else{
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
        else {

        }
    }

    function ip_op(n, uid, ip) {

        var ip_status = n;
        var uid_val = uid;
        var url = 'cash/ajax_op_ip';


        if (n == 2) {
            $.messager.confirm('溫馨提示', '確定封鎖該IP嗎', function (r) {
                if (r) {
                    $.ajax({
                        url: url,// 跳轉到 action
                        data: {
                            ip_status: ip_status,
                            uid: uid_val
                        },
                        type: 'post', //用post方法
                        cache: false,
                        dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                        success: function (data) {

                            if(data.code == 200){
                                Core.ok(data.data.msg);
                                Core.refresh();
                            }else{
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

        } else if (n == 1) {
            $.messager.confirm('溫馨提示', '確定解除封鎖該IP嗎？', function (r) {
                if (r) {
                    $.ajax({
                        url: url,// 跳轉到 action
                        data: {
                            ip_status: ip_status,
                            uid: uid_val
                        },
                        type: 'post', //用post方法
                        cache: false,
                        dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
                        success: function (data) {
                            if(data.code == 200){
                                Core.ok(data.data.msg);
                                Core.refresh();
                            }else{
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
        } else {

        }

    }

    function get_ip_location(ip) {
        var type = 1; // type等于1用百度接口，0 用淘宝接口
        $.get(WEB+'log/get_ip_location',{ip:ip,type:type},function(json){
            var c = JSON.parse(json);
            if (type == 1) {
                if (c.status == 0 && c.content != undefined) {
                    Core.ok(ip + '的IP地址是：' + c.content.address);
                } else {
                    Core.error('獲取IP地址失敗，請通過網絡查詢該IP地址');
                }
            } else {
                if (c.code == 0) {
                    Core.ok(ip + '的IP地址是：'+c.data.country+' '+c.data.area+' '+c.data.region+' '+c.data.city+' '+c.data.isp);
                } else {
                    Core.error('獲取IP地址失敗，請通過網絡查詢該IP地址');
                }
            }
        });
    }
    
</script>