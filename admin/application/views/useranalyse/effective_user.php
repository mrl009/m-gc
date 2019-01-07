<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'useranalyse/get_effective_user',
        fields:[
            [
                {field:'id', title:'排序', align:'center',width:60,sortable:true},
                {field:'report_date',title:'日期', align:'center', width:100, sortable:false},
                {field:'total',title:'今日人數', align:'center',width:90, sortable:true,formatter:function(v, r) {
                    return r.report_date && v > 0 ? '<span class="btn label label-warning" onclick="date_effective(\''+r.report_date+'\',0'+')"><u>'+v+'</u></span>' : v
                }},
                {field:'added',title:'新增人數', align:'center' , width:90, sortable:true,formatter:function(v, r) {
                    return r.report_date && v > 0 ? '<span class="btn label label-warning" onclick="date_effective(\''+r.report_date+'\',1'+')"><u>'+v+'</u></span>' : v
                }},
                {field:'man_in',title:'人工入款（元）/筆', align:'center', width:160,  sortable:false,formatter:function(v, r) {
                    return r.in_people_total+'/'+r.in_people_num;
                }},
                {field:'com_in',title:'公司入款（元）/筆', align:'center',width:160,  sortable:false,formatter:function(v, r) {
                    return r.in_company_total+'/'+r.in_company_num;
                }},
                {field:'online_in',title:'線上入款（元）/筆', align:'center',width:160,  sortable:false,formatter:function(v, r) {
                    return r.in_online_total+'/'+r.in_online_num;
                }},
                {field:'card_in',title:'彩豆入款（元）/筆', align:'center',width:160,  sortable:false,formatter:function(v, r) {
                    return r.in_card_total+'/'+r.in_card_num;
                }},
                {field:'man_out',title:'人工取款（元）/筆', align:'center', width:160,  sortable:false,formatter:function(v, r) {
                    return r.out_people_total+'/'+r.out_people_num;
                }},
                {field:'online_out',title:'線上取款（元）/筆', align:'center',width:160,  sortable:false,formatter:function(v, r) {
                    return r.out_company_total+'/'+r.out_company_num;
                }},
                {field:'res', title:'結果', align:'center',width:100,sortable:false,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
            ]

        ], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'有效會員');
            }},
//            {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'datebox', text:'日期', width:100,name:'start'},
            {type:'datebox', text:'-', width:100,name:'end'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start']").val();
                var end = $("#form_<?php echo $id?> input[name='end']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        checkbox:false,
        edit:true,
        footer:true,
        success:function () {
            Core.agentLog('<?php echo $id?>');
        }
    });

    function edit_pay_type()
    {
        Core.dialog('支付設定','level/pay_set',function(){},true,false);
    }
    
    function date_effective(date, is_one_pay) {
        var agent_id = $('#form_<?php echo $id?> [name="agent_id"]').val();
        agent_id = agent_id == undefined ? 0 : agent_id
        Core.dialog('有效會員','useranalyse/date_effective?date='+date+'&is_one_pay='+is_one_pay+'&agent_id='+agent_id,
            function(){},true,40,function(){},function(){},false,function(){},true);
    }
</script>