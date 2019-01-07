<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_pay_types',
        fields:[
            [
                {field:'id',title:'編號',align:'center',width:30,sortable:true},
                {field:'pay_name',title:'名稱',align:'center',width:200,sortable:true}
            ]
        ], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增',get:'payset/edit_pay_setting',full:true});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'修改',get:'payset/edit_pay_setting',full:true});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'payset/delete_pay_setting'});
            }},
            <?php }?>
        ],
        footer:true,
        success:function(){

        }
    });
</script>