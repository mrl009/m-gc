<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'sxset/getlist',
        fields:[[
            {field:'id',         title:'ID',      width:140},
            {field:'leval_name', title:'层级',     width:140, sortable:false},
            {field:'ag',         title:'AG視訊',   width:100, formatter:function(v){return v+'%'}},
            {field:'dg',         title:'DG視訊',   width:90,  formatter:function(v){return v+'%'}},
            {field:'mg',         title:'MG視訊',   width:120, formatter:function(v){return v+'%'}},
            {field:'lebo',       title:'LEBO視訊', width:140, formatter:function(v){return v+'%'}},
            {field:'pt',         title:'PT電子',   width:100, formatter:function(v){return v+'%'}},
            {field:'ky',         title:'开元棋牌',   width:100, formatter:function(v){return v+'%'}},
            {field:'limit_money',   title:'優惠上限',  width:120, sortable:false}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增',get:'sxset/editset'});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯',get:'sxset/editset'});
            }},
            <?php }?>
            {type:'combobox',text:'層級',width:95,name:'gid',value:'',
                items:'<option value="">全部平台<option>'
            },
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        footer:true,
        checkbox:false
    });
</script>