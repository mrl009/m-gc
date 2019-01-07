<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'rebate/get_set_list',
        fields:[[
            {field:'id',            title:'ID',align:'center',width:50,sortable:true},
            {field:'name',          title:'級別',align:'center',width:100},
            /*{field:'profit_amount', title:'盈利金額',width:100,align:'center',sortable:false},*/
            {field:'bet_amount',    title:'有效打碼量',width:100,align:'center',sortable:false},
            /**{field:'user_sum',      title:'有效會員',width:100,align:'center',sortable:false},**/
            {field:'rate',          title:'退傭比例[彩票]',width:100,align:'center',sortable:false,formatter:function(v){
                return v + '%';
            }},
            {field:'op',            title:'操作', align:'center',width:60,sortable:false,formatter:function(v,r){
                return '<a herf="#" onclick=updateStatus('+r.id+','+r.status+')>'+(r.status==1?'<span class="btn label label-success">開啟</span>':'<span class="btn label label-danger">暫停</span>')+'</a>';
            }}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增退傭模式',get:'rebate/add_set',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"修改",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'修改退傭模式',get:'rebate/add_set',full:false});
            }},
            <?php }?>
            {type:'label', html:'<span style="color:red;">傭金模式:按打碼量</span>', width:100}
            /*{text:'設置傭金模式',iconCls:'icon-redo',handler:function(){
                Core.dialog('設置傭金模式','rebate/set_rate_type',function(){
                },true,false);
            }}*/
        ],
        edit:true,
        checkbox:false
    });
    function updateStatus(id,status){
        $.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該代理退傭設定嗎', function(r){
            if (r){
                $.post(WEB+'rebate/update_set_status',{id:id,status:status},function(){
                    $('#<?php echo $id?>').datagrid('reload');
                });
            }
        });
    }
</script>