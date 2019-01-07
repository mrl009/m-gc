<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'reward/get_reward',
        fields:[[
            {field:'id',      title:'ID',align:'center',width:60,sortable:true},
            {field:'vip_id', title:'等級',align:'center', width:150,formatter: function (v) {return 'VIP'+ v}},
            {field:'d1_rate',title:'<?=$reward_day[0]?>+',align:'center', width:110,formatter: function (v) {return v + '%'}},
            {field:'d2_rate',title:'<?=$reward_day[1]?>+',align:'center', width:110,formatter: function (v) {return v + '%'}},
            {field:'d3_rate',title:'<?=$reward_day[2]?>+',align:'center', width:110,formatter: function (v) {return v + '%'}}
        ]], tools:[
            {instant:false},
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                $('#<?php echo $id?>').DataSource('edit',{
                    title:'VIP'+d.vip_id+'嘉奖比例修改',
                    get:'reward/edit_reward'});
            }},
            <?php }?>
        ],
        footer:true
    });
</script>