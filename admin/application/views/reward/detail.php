<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'reward/get_detail',
        fields:[[
            {field:'id',      title:'ID',align:'center',width:60,sortable:true},
            {field:'username', title:'會員',align:'center', width:150,editor:'text'},
            {field:'vip_id',title:'晋级后等級',align:'center', width:80,formatter:function(v){
                return v?'VIP'+v:'';
            }},
            {field:'money',title:'晉級獎勵',align:'center', width:110},
            {field:'reward_date', title:'晋级时间', align:'center',width:130,  sortable:true},
            {field:'update_time', title:'領取时间', align:'center',width:130,formatter:function(v){
                return v>0?date('Y-m-d H:i:s',v):'';
            }},
            {field:'status', title:'是否領取', align:'center',width:100,formatter:function(v){
                if (v == 1) {
                    return '未领取';
                } else if(v == 2) {
                    return '<span style="color:red">已领取</span>'
                } else {
                    return '<span style="color:green">已过期</span>'
                }
            }}
        ]], tools:[
            {instant:false},
            {type:'datebox', text:'嘉獎时间', width:98,name:'start'},
            {type:'datebox', text:'-', width:98,name:'end'},
            {type:'textbox', text:'帳號', width:120,name:'username'},
            {type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
                    var start = $("#form_<?php echo $id?> input[name='start']").val();
                    var end = $("#form_<?php echo $id?> input[name='end']").val();
                    if (start != '' && end != '' && Core.limitDay(start, end, 31)){
                        Core.error('查詢區間限制為一個月');
                        return false;
                    }
                    $('#<?php echo $id?>').DataSource('search');
                }},
            '-'
        ],
        footer:true
    });
</script>