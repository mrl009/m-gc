<?php $id="form_".uniqid();?>
<form class="form-horizontal" role="form" method="post" action="#" style="height:400px;width:450px">
    <table id="<?php echo $id;?>" ></table>
</form>
<script>
    $("#<?php echo $id;?>").DataSource({url:'agent/get_new_register?start=<?=$start?>&end=<?=$end?>&agent_id=<?=$agent_id?>',
        fields:[[
            {field:'id',      title:'ID', width:100, sortable:false},
            {field:'username',title:'用戶名',align:'center',width:150, sortable:true},
            {field:'addtime', title:'註冊時間',align:'center',width:200, sortable:true}
        ]],
        tools:false,
        checkbox:false,
        footer:true,
        dbclick:function (i,r) {
            user_select(r);
        }
    });
    function user_select(r) {
        $('#modal').modal('hide');
        $('.modal-backdrop').remove();
        Core.dialog('會員信息','member/edit_member?id='+r.id,function(){},true,70);
    }
</script>
