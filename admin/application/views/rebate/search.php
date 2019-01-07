<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'rebate/get_search_list?report_date=<?php echo $report_date;?>',
        fields:[[
            {field:'id',         title:'ID',align:'center',width:60,sortable:true},
            {field:'report_date',title:'期數',align:'center',width:150,sortable:true},
            {field:'username',   title:'代理賬號',width:150,align: 'center',sortable:true},
            {field:'bank_name',  title:'姓名',align: 'center',width:120,sortable:true},
            {field:'valid_user', title:'有效會員',align:'center',width:120,sortable:true},
            {field:'now_price',  title:'當前新增有效打碼量',align:'center',width:120,sortable:true},
            {field:'rate',       title:'退傭比例(%)',align:'center',width:120,sortable:true},
            {field:'rate_price', title:'可獲退傭',align:'center',width:120,sortable:true},
            {field:'status_name',     title:'狀態',align:'center',width:120,sortable:true,formatter:function(v,r){
                if (r.rate_price == 0) {
                    return '條件未達到';
                } else {
                    return r.status == 1 ? v :'<span class="btn label label-info" onclick="agent_rebate('+r.id+')">'+'確認返傭</span>';
                }
            }}
        ]], tools:[
            {instant:false},
            {text:"批量返傭",iconCls:"icon-redo",handler:function(){
                var ss = [];
                var rows = $('#<?php echo $id?>').datagrid('getSelections');
                if(rows.length==0){
                    Core.error('請選擇要批量返傭的數據');
                    return false;
                }
                for(var i=0; i<rows.length; i++){
                    var row = rows[i];
                    if (row.status == 2) {
                        ss.push(row.id);
                    }
                }
                if (ss == '') {
                    Core.error('沒有需要返傭的數據');
                    return false;
                }
                agent_rebate(ss.join());
            }},
            {type: 'datebox', text: '期數', width: 98, name: 'time_start'},
            {type: 'datebox', text: '-', width: 98, name: 'time_end'},
            {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'combobox',text:'狀態',width:100,name:'status',value:'', items:'<option value="">全部</option><option value="1">已返代理</option><option value="2">未返</option>'},
            {text: "搜索", iconCls: "icon-search", handler: function () {
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            {type:'label', html:'<span style="color:red;">&nbsp;&nbsp;默認獲取昨天代理數據</span>', width:100}
        ],
        success:function () {
            Core.agentLog('<?php echo $id?>');
        }
    });
    function agent_rebate(id){
        $.messager.confirm('溫馨提示', '確定返傭麽', function(r){
            if (r){
                $.post(WEB+'rebate/agent_rebate',{id:id},function(json){
                    var c = JSON.parse(json);
                    if (c.code == 200) {
                        Core.ok('確定返傭成功');
                    }
                    $('#<?php echo $id?>').datagrid('reload');
                });
            }
        });
    }
</script>