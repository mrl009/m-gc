<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'interactive/packet/get_packet_list',
        fields: [[
            {field:'id',title:'ID',width:60,sortable:true},
            {field:'username',title:'帳號',width:150,align:'center'},
            {field:'nickname',title:'昵称',width:110,align:'center'},
            {field:'addtime',title:'发送时间',width:110,align:'center'},
            {field:'money',title:'红包金额',width:110,align:'center'},
            {field:'num',title:'红包个数',width:110,align:'center'},
            {field:'grab_money',title:'被抢金额',width:110,align:'center'},
            {field:'is_refund',title:'是否退款',width:110,align:'center'},
            {field:'balance',title:'退款金额',width:110,align:'center'},
            {field:'refund_time',title:'退款时间',width:110,align:'center'}
        ]],
        tools:[
            {instant:false},
            {text:"红包详情",iconCls:"icon-edit",handler:function(){
                    $("#<?php echo $id;?>").DataSource('edit',{
                        title: '红包详情',
                        get: 'interactive/packet/packet_detail',
                        full: false
                    });
                }},
            {type:'datebox', text:'发送日期', width:98,name:'start'},
            {type:'datebox', text:'-', width:98,name:'end'},
            {type:'textbox', text:'用户', width:120,name:'username'},
            {type:'button',text:"搜索", iconCls:"icon-search",handler:function(){
                var end = $("#<?php echo $id;?> input[name='end']").val();
                var start = $("#<?php echo $id;?> input[name='start']").val();
                var username = $("#<?php echo $id;?> input[name='username']").val();
                if (('' == username) && ('' != start) && ('' != end)
                    && (Core.limitDay(start, end, 60))){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $("#<?php echo $id;?>").DataSource('search');
            }}
        ],
        edit:false,
        footer:false,
        success:function(){}
    });
</script>