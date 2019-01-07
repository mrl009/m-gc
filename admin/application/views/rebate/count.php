<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'rebate/get_count_list',
        fields:[[
            {field:'report_date',       title:'期數',align:'center',width:150,sortable:true},
            {field:'agent_num',         title:'代理數',align:'center',width:150,align: 'center',sortable:true},
            {field:'total_user',        title:'有效會員',align: 'center',width:120,sortable:true},
            {field:'total_now_price',   title:'當前新增有效打碼量',align:'center',width:120,sortable:true},
            {field:'rebate_price',      title:'已返傭金',align:'center',width:120,sortable:true},
            {field:'un_rebate_price',   title:'未返傭金',align:'center',width:120,sortable:true},
            {field:'rebate_num',        title:'已返代理數',align:'center',width:120,sortable:true},
            {field:'un_rebate_num',     title:'未返代理數',align:'center',width:120,sortable:true,formatter:function(v,r){
                return '<span class="btn label label-info" onclick="jump(\''+r.report_date+'\')"><u>'+v+'</u></span>';
            }}
        ]], tools:[
            {instant:false}
        ],
        checkbox:false,
        edit:true,
        footer:true
    });
    function jump(report_date) {
        Core.closeTab('退傭查詢');
        Core.addTab('退傭查詢','rebate/search?report_date='+report_date)
    }
</script>