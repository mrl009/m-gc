<!-- 會員統計 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'interactive/packet/get_statistics_list',
        fields:[
            [
                {field:'nickname',title:'姓名',align:'center',width:60,sortable:true},
                {field:'username',title:'會員賬號',align:'center',width:100,sortable:true},
                {field:'addtime',title:'註冊時間',align:'center',width:130,sortable:true},
                {field:'packet_in',title:'红包收入',align:'center',width:120,sortable:true},
                {field:'packet_out',title:'红包支出',align:'center',width:120,sortable:true},
                {field:'packet_refund',title:'红包退回',align:'center',width:120,sortable:true},
                {field:'packet_profit',title:'红包盈利',align:'center',width:120,sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }}
            ]
        ], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                    Core.ExportJs($("#<?php echo $id;?>"),'會員統計');
                }},
            {type:'datebox', text:'日期', width:100,name:'start'},
            {type:'datebox', text:'-', width:100,name:'end'},
            {type:'textbox', text:'會員賬號', width:120,name:'username'},
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
        edit:false,
        footer:true,
        success:function(){
            Core.agentLog('<?php echo $id?>');
            $('#<?php echo $id?>').pagination({layout:['links','last'],showRefresh:false});
        }
    });

</script>