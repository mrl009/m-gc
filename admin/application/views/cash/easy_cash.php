<?php $id="form_".uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="#" style="height:400px;width:100%">
<table id="<?php echo $id;?>" ></table>
</form>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_cash_list?uid=<?php echo $uid?>',
        fields:[[
            {field:'user_name',      title:'會員賬號', width:100, sortable:false},
//            {field:'agent_name',  title:'所屬代理',   width:80, sortable:true},
            {field:'order_num',  title:'訂單號',   width:150, sortable:true},
            {field:'type',  title:'類型',   width:80, sortable:true},
            {field:'is_io',title:'交易類別',    width:100,  sortable:true ,formatter:function (v,r) {
                if (v== 1) return '<span style="color:green">存入</span>';
                if (v== 2) return '<span style="color:red">取出</span>';
            }},
            {field:'amount',title:'交易金額',      width:100,  sortable:true},
            {field:'balance',    title:'余額',      width:100},
            {field:'addtime', title:'交易日期',      width:150,  sortable:true},
            {field:'remark',  title:'備註（金額：元）',width:200}
        ]],
        tools:[
            {instant:false},
            {type:'textbox', text:'訂單號', width:100,name:'f_ordernum'},
            {type:'datebox', text:'存入日期', width:100,name:'time_start'},
            {type:'datebox', text:'-', width:100,name:'time_end'},
            {type:'combobox',text:'方式',width:130,name:'types',value:'', items:'<?php foreach($level as $v){echo "<option value=$v[sid]>$v[name]</option>"; }?>'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        checkbox:false,
        footer:true,
        success:function(id,data){

        }
    });
</script>