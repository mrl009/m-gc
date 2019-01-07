<!-- 活動管理 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'setting/get_activity_blacklist',
        fields:[[
            {field:'id',      title:'ID ',       width:40, sortable:false},
            {field:'user_name', title:'账号',     width:130},
            {field:'vip_level',   title:'等级',      width:50,formatter:function(v){
                return v?'VIP'+v:'';
            }},
            {field:'activity_title',title:'黑名单列表', align:'center', width:800, sortable:true},
            {field:'add_time',title:'添加時間', align:'center', width:210, sortable:true,formatter:function(v){return date('Y-m-d H:i:s',v)}},
            {field:'comment',title:'备注', align:'center', width:110},
            {field:'status',title:'狀態', align:'center',hidden:true},
        ]],
        tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增',get:'setting/activity_black_set',full:true});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯',get:'setting/activity_black_set',full:true});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                // d = $("#<?php echo $id;?>").datagrid('getSelected');
                rows =$("#<?php echo $id;?>").datagrid('getSelections');
                var id=[], __ = this;
                $.each(rows,function(i,d){id.push(d.id)});
                if($.inArray('1001',id)>=0||$.inArray('1002',id)>=0){
                    uableDelete();
                    return false;
                }
                $('#<?php echo $id?>').DataSource('remove',{get:'setting/delete_activity_blacklist'});
            }},
            <?php }?>
            '-'
        ],
        success:function(){
            $('#<?php echo $id?>').datagrid('enableDnd');
        }
    });
    function updateActiveStatus(id,status,title){
        $.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該活動嗎', function(r){
            if (r){
                $.post(WEB+'setting/update_status',{id:id,status:status,title:title},function(c){
                    $('#<?php echo $id?>').datagrid('reload');
                });
            }
        });
    }

    function uableDelete(){
        $.messager.confirm('溫馨提示：', '每日嘉奖或者晋级奖励不能删除', function(){
        });
    }
</script>