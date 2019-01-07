<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'setting/get_site_domain_list',
        fields:[[
            {field:'id',        title:'ID',      width:40,sortable:true},
            {field:'type',      title:'域名類型',align:'center',width:200, formatter:function(v){
                if(v==1)
                    return '<span class="label label-info">API域名(多條)</span>';//系統使用隐藏不可见
                else if(v==2)
                    return '<span class="label label-default">支付域名(多條)</span>';//網站支付域名可多個
                else if(v==3)
                    return '<span class="label label-default">主手機域名(一條)</span>';//電腦跳轉手機專用
                else if(v==4)
                    return '<span class="label label-default">主PC域名(一條)</span>';//手機跳轉電腦專用
                else if(v==5)
                    return '<span class="label label-default">API固定域名(多條)</span>';//系統使用隐藏不可见
               else if(v==6)
                    return '<span class="label label-default">其他手機域名(多條)</span>';//手機可以直接打開
               else if(v==7)
                    return '<span class="label label-default">其他電腦域名(多條)</span>';//電腦可以直接打開
            }},
            {field:'is_main',   title:'主域名',align:'center',width:50, formatter:function(v){
                return v==1?'<span class="label label-primary">備</span>':'<span class="label label-danger">主</span>'}},
            {field:'is_binding',title:'是否綁定',align:'center',width:80, formatter:function(v){return v==1?'<span class="label label-warning">未綁</span>':'<span class="label label-success">已綁</span>'}},
            {field:'invite_code',title:'邀请码',align:'center',width:100},
            {field:'domain',    title:'域名',align:'center',width:250},
            {field:'cname',     title:'CNAME',align:'center', width:250},
            // {field:'addtime',   title:'添加日期',align:'center',width:200,  sortable:true,formatter:function(v){return date('Y-m-d',v)}}
        ]], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'域名配置');
            }},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增',get:'setting/edit_domain',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                    var row = $('#<?php echo $id?>').datagrid('getSelected');
                    if(row.is_main==2){
                        Core.error('主域名不能修改');
                        return false;
                    }else{
                        $('#<?php echo $id?>').DataSource('edit',{title:'修改',get:'setting/edit_domain',full:false});
                    }
                
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'setting/delete_domain'});
            }},
            <?php }?>

            {type:'textbox', text:'域名', width:150,name:'domain'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ]
        //footer:true,
        //checkbox:false,
    });
</script>