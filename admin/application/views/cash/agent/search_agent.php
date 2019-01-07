<?php $id1="form_".uniqid();?>
<form class="form-horizontal" role="form" method="post" action="#" style="height:400px;width:350px">
    <table id="<?php echo $id1;?>" ></table>
</form>
<style>
    .modal-content{
        width: 400px;
    }
</style>
<script>
    $("#<?php echo $id1;?>").DataSource({url:'cash/get_search_agent_list',
        fields:[[
            {field:'id',        title:'ID', width:100, sortable:true},
            {field:'agent_name',title:'代理名',width:150, sortable:false}
        ]],
        tools:[
            {instant:false},
            {type:'textbox', text:'代理名', width:100,name:'agent_name'},
            {type:'button', text:'清除代理檢索', handler: function () {
                agent_select();
            }},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id1?>').DataSource('search');
            }},
            '-'
        ],
        checkbox:false,
        footer:true,
        onClickRow:function (i,r) {
            agent_select(r);
        }
    });
    function agent_select(r) {
        var form_id = '<?php echo $from_id;?>';
        var id=r?r.id:'';
        var agent_name=r?r.agent_name:'';
        if (form_id=='report') {
            $('#'+form_id+' [name="agent_name"]').val(agent_name);
            $('#'+form_id+' [name="agent_id"]').val(id);
        } else {
            $('#form_'+form_id+' [name="agent_name"]').val(agent_name);
            $('#form_'+form_id+' [name="agent_id"]').val(id);
        }
        $('#modal').modal('hide');
    }
</script>
