<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'interactive/vip/get_access_list',
        fields: [[
            {field:'id',title:'ID',width:60,sortable:true},
            {field:'vip_name',title:'vip类型',width:100,align:'center',
                sortable:true
            },
            {field:'is_speak',title:'是否有发言权限',width:100,align:'center',
                formatter:function(v,r)
                {
                    return 0 == v ? '否' : '是';
                }
            },
            {field:'is_share',title:'是否有分享权限',width:100,align:'center',
                formatter:function(v,r)
                {
                    return 0 == v ? '否' : '是';
                }
            },
            {field:'record_num',title:'每分钟发言条数',width:100,align:'center',sortable:true},
            {field:'red_grab_num',title:'抢红包次数',width:100,align:'center',sortable:true},
            {field:'red_send_num',title:'发红包次数',width:100,align:'center',sortable:true}
        ]],
        tools:[
            {instant:false},
            //编辑权限
            {text:"编辑",iconCls:"icon-edit",handler:function(){
                $("#<?php echo $id;?>").DataSource('edit',{
                    title: 'vip权限设置',
                    get: 'interactive/vip/access_edit',
                    full: false
                });
            }}
        ],
        edit:true,
        footer:true,
        success:function(){}
    });
</script>