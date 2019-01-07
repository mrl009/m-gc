<!-- 操作日誌 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'log/get_handle_log_list',
        fields:[[
            {field:'id',         title:'ID',align:'center',width:60,sortable:true},
            {field:'record_time',title:'日期',width:150,align: 'center',sortable:true},
            {field:'username',   title:'操作者',align: 'center',width:120,sortable:true},
            {field:'content',    title:'操作記錄', width:1000,sortable:true}
        ]], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'操作記錄');
            }},
            {type:'datebox', text:'日期', width:100,name:'from_time'},
            {type:'datebox', text:'-', width:100,name:'to_time'},
            {type:'textbox', text:'操作者', width:120,name:'account'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='from_time']").val();
                var end = $("#form_<?php echo $id?> input[name='to_time']").val();
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
        success:function(){
            $('#<?php echo $id?>').pagination({layout:['links','last'],showRefresh:false});
        }
    });
</script>