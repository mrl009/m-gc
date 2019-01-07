<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'pay/qrcode/get_qrcode_list',
        fields:[[
            {field:'id', title:'編號', align:'center', width:60, sortable:false},
            {field:'bank_name', title:'賬戶類型', align:'center', width:150, 
                sortable:false
            },
            {field:'code_num', title:'收款賬號', align:'center', width:170, 
                sortable:false
            },
            {field:'code_username', title:'賬戶姓名',  align:'center', width:100, sortable:false
            },
            {field:'qrcode', title:'二維碼圖片',  align:'center', width:170,
                sortable:false,formatter:function(v, r)
                {
                    return '<img src="'+ r.qrcode +'" width="50px" height="50px">';
                }
            },
            {field:'max_amount',   title:'停用金額',  align:'center', width:100,  sortable:false},
            {field:'re_order',   title:'排序权重',  align:'center', width:100,  sortable:true},
            {field:'status',       title:'狀態', align:'center', width:100,  sortable:false, formatter:function(v, r){
                return r.status==1 ? '<span class="label label-success">啟用</span>' : '<span class="label label-danger">停用</span>';
            }},
            {field:'remark',title:'備註',align:'center', width:200,  sortable:false}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增二維碼',get:'pay/qrcode/qrcode_edit',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯二維碼',get:'pay/qrcode/qrcode_edit',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'pay/qrcode/qrcode_delete'});
            }},
            <?php }?>
            {text:"二维码存款記錄",iconCls:"icon-payment",handler:function(){
                Core.addTab('二维码存款記錄', 'pay/qrcode/qrcode_deposit_list');
            }}
        ],
        edit:true,
        footer:true,
        success:function(){}
    });
</script>