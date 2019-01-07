<?php $id="form_".uniqid();?>
<form class="form-horizontal" role="form" method="post" action="#" style="height:400px;width:520px">
    <table id="<?php echo $id;?>"></table>
</form>
<script>
    $("#<?php echo $id;?>").DataSource({url:'interactive/packet/get_packet_detail?id=<?=$rid?>',
        fields:[[
            {field:'id',      title:'编号', width:60, sortable:false},
            {field:'username',title:'抢红包者账号',align:'center',width:100, sortable:false},
            {field:'nickname', title:'昵称',align:'center',width:100, sortable:false},
            {field:'money', title:'金额',align:'center',width:100, sortable:false},
            {field:'addtime', title:'时间',align:'center',width:130, sortable:false}
        ]],
        tools:[{instant:false}],
        checkbox:false,
        footer:true,
        success:function(){console.log(88888)}
    });
</script>

