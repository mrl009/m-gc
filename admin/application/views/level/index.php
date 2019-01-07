<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'level/getlist',
        fields:[
            [
                {field:'id',         title:'ID',     rowspan:2, align:'center',width:40,sortable:true},
                {field:'level_name', title:'名稱',    rowspan:2,align:'center',width:100,sortable:true},
                {                    title:'層級詳情',colspan:2},
                {                    title:'加入條件',colspan:2},
                {field:'user_num',   title:'會員人數',rowspan:2,align:'center', width:100,  sortable:true},
                {field:'bank_num',   title:'收款賬戶數',rowspan:2, align:'center',width:100,  sortable:true},
                {field:'online_num', title:'支付賬戶數', rowspan:2, align:'center', width:100,  sortable:true},
                {field:'remark',     title:'備註', align:'center',  width:150, rowspan:2, sortable:true}
            ],[
                {field:'use_times',    title:'存款次數',align:'center',width:150,sortable:true},
                {field:'use_total',    title:'存款總額',width:150,align:'center'},
                {field:'total_num',    title:'存款次數',align:'center',width:150,sortable:true},
                {field:'total_deposit',title:'存款總額',width:150,align:'center'}
            ]

       ], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增層級',get:'level/edituser',full:true});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯層級',get:'level/edituser',full:true});
            }},

            {text:"移動層級",iconCls:"icon-redo",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                if(d==null){
                    Core.error('請選擇要移動的層級');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('edit',{title:'移動層級',get:'level/edit_level?id='+ d.id,full:60});
            }}
            <?php }?>
        ],
      
        footer:true,
        edit:true,
        success:function(){
        }
    });
</script>