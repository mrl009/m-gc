<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_bank_list',
        fields:[[
            {field:'id',           title:'編號',align:'center',width:40,sortable:false},
            {field:'bank_name',    title:'銀行類型', align:'center',width:170,sortable:false},
            {field:'card_address', title:'開戶行', align:'center',  width:250, sortable:false},
            {field:'card_num',     title:'銀行賬號',align:'center', width:170, sortable:false},
            {field:'card_username',title:'開戶姓名',  align:'center', width:170, sortable:false},
            {field:'max_amount',   title:'停用金額',  align:'center', width:170,  sortable:false},
            {field:'re_order',   title:'排序权重',  align:'center', width:170,  sortable:true},
            {field:'status',       title:'狀態', align:'center', width:45,  sortable:false, formatter:function(v, r){
                return r.status==1 ? '<span class="label label-success">啟用</span>' : '<span class="label label-danger">停用</span>';
            }},
            {field:'remark',title:'備註',align:'center', width:170,  sortable:false}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增銀行卡',get:'payset/edit_bank',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯銀行卡',get:'payset/edit_bank',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'payset/delete_bank'});
            }},
            <?php }?>
            {text:"銀行存款記錄",iconCls:"icon-payment",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                if(d==null){
                    Core.error('請選擇存款銀行');
                    return false;
                }
                Core.addTab('銀行存款記錄', 'payset/list_bank_deposit?bankCard'+d.card_num);
            }}
        ],
        edit:true,
        footer:true,
        success:function(){

        }
    });
</script>