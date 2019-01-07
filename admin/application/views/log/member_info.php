<!-- 會員消息 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'log/get_member_info_list',
        fields:[
            [
                {field:'id',        title:'ID',align:'center',width:60,sortable:true},
                {field:'terminal',title:'發送終端',width:160,align:'center',sortable:true},
                {field:'title',     title:'標題',width:350,sortable:true},
                {field:'content',   title:'內容',width:350,sortable:true},
                {field:'addtime',   title:'發送日期',width:150,align:'center',sortable:true},
                // {field:'type',      title:'體系',width:120,align:'center',sortable:true},
                // {field:'msg_type',  title:'消息類型',width:120,align:'center',sortable:true}
            ]
        ], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'發送消息',get:'log/add_member_info?>',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'log/delete_member_info'});
            }},
            <?php }?>
            {type:'datebox', text:'日期', width:100,name:'from_time'},
            {type:'datebox', text:'-', width:100,name:'to_time'},
            {type:'combobox',text:'類型',width:60,name:'terminal',value:'', items:'<option value="">全部</option><option value="0">所有平臺</option><option value="1">IOS</option><option value="2">Android</option>'},
            /*{type:'combobox',text:'類型',width:60,name:'msg_type',value:'', items:'<option value="">全部</option><option value="0">普通通知</option><option value="1">優惠通知</option><option value="2">出入款通知</option><option value="3">推送廣播</option>'},
            {type:'textbox', text:'賬號', width:120,name:'account'},*/
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='from_time']").val();
                var end = $("#form_<?php echo $id?> input[name='to_time']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }}
        ],
        success:function(){
            $('#<?php echo $id?>').pagination({layout:['links','last'],showRefresh:false});
        }
    });
</script>