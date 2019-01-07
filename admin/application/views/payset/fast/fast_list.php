<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'pay/fast/get_fast_list',
        fields:[[
            {field:'id', title:'編號',align:'center',width:60,sortable:false},
            {field:'platform_name', title:'平台名稱',align:'center',width:160,sortable:false},
            {field:'merch',title:'商戶號', align:'center',width:130,sortable:false},
            {field:'min_amount',title:'允許充值金額範圍', align:'center',width:160,sortable:false,formatter:function(v, r)
                {
                    return r.min_amount + '&nbsp;&nbsp;-&nbsp;&nbsp;' + r.max_amount;
                }
            },
            {field:'block_amount',title:'停用金額', align:'center',width:130,sortable:false,formatter:function(v, r)
                {
                    if (0 < r.block_amount)
                    {
                        return r.block_amount;
                    }
                }
            },
            {field:'fixed_amount',title:'固定金額', align:'center',width:260,sortable:false},
            {field:'re_order',title:'排序',  align:'center', width:60,  sortable:true},
            {field:'status',title:'狀態', align:'center', width:100,  sortable:false, formatter:function(v, r){
                return '<a herf="#" class="btn label label-'+(r.status==1?'success':'danger')+' btn-xs" onclick=checkStatus('+r.id+','+r.status+')>'+(r.status==1?'開啟':'停用')+'</a>';
            }}
        ]], 
        tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{
                    title:'新增接入平台',
                    get:'pay/fast/fast_edit',
                    full:false
                });
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{
                    title:'編輯平台信息',
                    get:'pay/fast/fast_edit',
                    full:false
                });
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{
                    get:'pay/fast/fast_delete'
                });
            }},
            <?php }?>
        ],
        edit:true,
        footer:true,
        success:function(){}
    });
    function checkStatus(id,status){
        $.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該接入平台嗎', function(r){
            if (r){
                $.post(WEB+'pay/fast/update_status',{id:id,status:status},function(c){
                    $('#<?php echo $id?>').datagrid('reload');
                });
            }
        });
    }
</script>