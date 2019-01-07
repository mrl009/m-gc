<!-- 優惠分析 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'useranalyse/get_privilege_analyse_list?<?php echo $skip; ?>',
        fields:[
            [
                {field:'username',title:'會員',align:'center',width:200,sortable:true,formatter:function(v, r) {
                    if (! r.level_name) {
                        return '總計：'+r.total;
                    }
                    return r.username;
                }},
                {field:'agent_name',title:'上級代理',align:'center',width:150,sortable:true},
                {field:'level_name',title:'層級',align:'center',width:200,sortable:true},
                {field:'out_return_water',title:'彩票打碼量',align:'center',width:200,sortable:true,formatter:function(v, r) {
                    if (! r.level_name) {
                        return '打碼量總計：'+r.out_return_water;
                    }
                    return r.out_return_water;
                }},
                {field:'xiaoji',title:'返水小計', align:'center', width:200,  sortable:true,formatter:function(v, r) {
                    if (! r.level_name) {
                        return '返水總計：'+r.xiaoji;
                    }
                    return r.xiaoji;
                }}
             ]

       ], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增層級",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增層級',get:'level/edituser?>',full:true});
            }},
            <?php }?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'反水分析');
            }},
 //           {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
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
            {type:'label', html:'<span style="color:red;">【查詢區間限制為兩個月】</span>', width:100},
        '-'
        ],
        checkbox:false,
        edit:true,
        footer:true,
        success:function(){
            Core.agentLog('<?php echo $id?>');
            $('#<?php echo $id?>').pagination({layout:['links','last'],showRefresh:false});
        }
    });

</script>