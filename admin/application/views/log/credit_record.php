<!-- 额度流水 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'log/get_credit_record?admin_id=<?php echo $admin_id?>',
        fields:[
            [
                {field:'id',        title:'ID',align:'center',width:60,sortable:true},
                {field:'platform',     title:'平台',width:350,sortable:true},
                {field:'credit',   title:'额度',width:300,sortable:true},
                {field:'user',   title:'用户',width:300,sortable:true},
                {field:'remark',   title:'操作类型',width:300,sortable:true},
                {field:'time',   title:'日期',width:150,align:'center',sortable:true},
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
            {type:'datebox', text:'日期', width:100,name:'start_time'},
            {type:'datebox', text:'-', width:100,name:'end_time'},
            {type:'combobox',text:'平臺',width:60,name:'platform',value:'', items:'<option value="">全部</option><option value="admin">超级后台</option><option value="ag">ag</option><option value="dg">dg</option><option value="ky">ky</option>'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start_time']").val();
                var end = $("#form_<?php echo $id?> input[name='end_time']").val();
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