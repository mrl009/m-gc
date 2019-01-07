<?php $id = "form_" . uniqid(); ?>
<table id="<?php echo $id; ?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'member/get_agent_audit_list',
        fields: [[
            {field: 'id', title: 'ID', align: 'center', width: 50, sortable: true},
            {field: 'user_id', title: '賬號', align: 'center', width: 100},
            {field: 'name', title: '姓名', width: 100, align: 'center', sortable: false},
            {field: 'phone', title: '電話', width: 100, align: 'center', sortable: false},
            {field: 'email', title: '郵箱', width: 100, align: 'center', sortable: false},
            {field: 'qq', title: 'QQ/微信', width: 100, align: 'center', sortable: false},
            {
                field: 'userid',
                title: '推廣ID',
                width: 100,
                align: 'center',
                sortable: false,
                formatter: function (v, r) {
                    if (r.status != 4) {
                        return '';
                    } else {
                        return r.userid;
                    }
                }
            },
            {field: 'domain', title: '推廣網址', width: 200, align: 'center', sortable: false},
            {field: 'user_memo', title: '申請說明', width: 200, align: 'center', sortable: false},
            {
                field: 'op', title: '狀態', align: 'center', width: 100, sortable: false, formatter: function (v, r) {

                if (r.status == 1) {
                    return '<span class="btn label label-primary">提交審核</span>';
                } else if (r.status == 2) {
                    return '<span class="btn label label-primary">補充資料</span>';
                } else if (r.status == 3) {
                    return '<span class="btn label label-danger">已拒絕</span>';
                } else if (r.status == 4) {
                    return '<span class="btn label label-success">審核通過</span>';
                } else {

                }
            }
            },
            {field: 'addtime', title: '申請時間', width: 150, align: 'center', sortable: false}
        ]], tools: [
            {instant: false},
            <?php if(in_array('EDIT', $auth)){?>
            {
                text: "編輯", iconCls: "icon-edit", handler: function () {
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                if (d.status != 4) {
                    $('#<?php echo $id?>').DataSource('edit', {
                        title: '審核',
                        get: 'member/agent_submit_form',
                        full: true
                    });
                }
            }
            },
            <?php }?>
            {
                type: 'combobox',
                text: '狀態',
                width: 100,
                name: 'status',
                value: '',
                items: '<option value="">全部</option><option value="1">提交審核</option><option value="4">審核通過</option><option value="2">補充資料</option><option value="3">已拒絕</option>'
            },
            {type: 'datebox', text: '日期', width: 98, name: 'time_start'},
            {type: 'datebox', text: '-', width: 98, name: 'time_end'},
            {type: 'textbox', text: '賬號', width: 100, name: 'name'},
            {text: "搜索", iconCls: "icon-search", handler: function () {
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }
            }
        ],
        edit: true,
        checkbox: false
    });


</script>