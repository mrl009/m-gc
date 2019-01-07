<?php $id="form_".uniqid();?>
<form class="form-horizontal" role="form" method="post" action="#" style="min-height:520px;width:100%">
    <table id="<?php echo $id;?>" ></table>
</form>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_payment_list?uid=<?php echo $uid?>',
        fields:[[
            {field:'order_num',     title:'訂單號',width:150,sortable:false},
            {field:'leve_name',   title:'層級', align:'center', width:80, sortable:true},
            {field:'user_name',title:'會員賬號',align:'center', width:100,sortable:true},
 //           {field:'agent_name',   title:'所屬代理', align:'center', width:80, sortable:true},
            {field:'addtime',  title:'出款日期',align:'center', width:130,  sortable:true},
            {field:'remark',  title:'備註', align:'left', width:410,  sortable:true},
        ]], tools:[
            {instant:false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                Core.ExportJs($("#<?php echo $id;?>"),'出款管理');
            }},
            <?php }?>
            {type:'datebox', text:'日期',   width:100,name:'time_start'},
            {type:'datebox', text:'-',     width:100,name:'time_end'},

            {text:"搜索", iconCls:"icon-search", handler:function(){
              
                $('#<?php echo $id?>').DataSource('search');
            }}
        ]
    });
</script>