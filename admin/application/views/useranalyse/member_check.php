<!-- 會員查詢 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'useranalyse/get_member_check_list',
        fields:[
            [
                {field:'addtime',title:'註冊日期',align:'center',width:150,sortable:true},
                {field:'username',title:'賬號',align:'center',width:150,sortable:true},
                {field:'agent_name',title:'上級代理',align:'center',width:150,sortable:true},
                {field:'bank_name',title:'真實姓名', align:'center', width:150,  sortable:true},
                {field:'balance',title:'余額',align:'center',width:150,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'addip',title:'國家',align:'center',width:150,sortable:true},
                <?php if(in_array('MOBILE', $auth)){?>
                {field:'phone',title:'電話號碼', align:'center', width:180,  sortable:true},
                <?php }?>
                <?php if(in_array('EMAIL', $auth)){?>
                {field:'email',title:'電子郵箱',align:'center',width:180,  sortable:true},
                <?php }?>
                <?php if(in_array('QQ', $auth)){?>
                {field:'qq',title:'QQ',align:'center',width:150,  sortable:true},
                <?php }?>
                {field:'',title:'',align:'center',width:1, hide:true}
             ]

       ], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增層級",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增層級',get:'level/edituser?>',full:true});
            }},
            <?php }?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'會員查詢');
            }},
//            {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
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