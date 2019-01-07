<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_cash_list',
        fields:[[
            {field:'user_name',      title:'會員賬號', align: 'center', width:100, sortable:false},
            {field:'order_num',  title:'訂單號',   width:150, sortable:true},
            {field:'type',  title:'類型', align: 'center', width:80, sortable:true},
            {field:'is_io',title:'交易類別', align: 'center',width:100,  sortable:true ,formatter:function (v,r) {
                if (v== 1) return '<span style="color:green">存入</span>';
                if (v== 2) return '<span style="color:red">取出</span>';
            }},
            {field:'amount',title:'交易金額',align: 'center', width:120,  sortable:true,
                    styler:function(v){
                        return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                    }
                },
            {field:'balance',    title:'余額', align: 'center',width:120,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'';
                    }
                },
            {field:'addtime', title:'交易日期', align: 'center', width:160,  sortable:true},
            {field:'remark',  title:'備註（金額：元）',       width:400,  sortable:true}
        ]],
        tools:[
            {instant:false},      
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                   Core.ExportJs($("#<?php echo $id;?>"),'現金流水');
            }}, 
            {type:'combobox',text:'方式',width:130,name:'types',value:'', items:'<?php foreach($level as $v){echo "<option value=$v[sid]>$v[name]</option>"; }?>'
            },
            {type:'datebox', text:'交易日期', width:100,name:'time_start'},
            {type:'datebox', text:'-', width:100,name:'time_end'},
            {type:'textbox', text:'帳號', width:120,name:'f_username'},
            {type:'textbox', text:'訂單號', width:150,name:'f_ordernum'},          
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var order_num = $("#form_<?php echo $id?> input[name='f_ordernum']").val();
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (order_num == '' && start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        checkbox:false,
        footer:true
    });
</script>