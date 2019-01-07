<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_out_pay_setting',
        fields:[[
            {field:'id',        title:'ID', align:'center',width:60,sortable:false},
            {field:'online_name',title:'平臺', align:'center', width:100,sortable:false},
            {field:'out_id',    title:'商戶ID', align:'center', width:200, sortable:false},
            {field:'out_domain',title:'回调域名',align:'center', width:200, sortable:false},
            // {field:'total_amount',title:'停用金額',align:'center', width:200, sortable:false},
            // {field:'status',    title:'狀態', align:'center',  width:45,  sortable:false, formatter:function(v, r){
            //     return r.status == 1 ? '<span class="label label-success">啟用</span>' : '<span class="label label-danger">停用</span>';
            // }},
            {field:'aa',        title:'狀態', align:'center',width:45,sortable:false,formatter:function(v,r){
                return '<a herf="#" class="btn label label-'+(r.status==1?'success':'danger')+' btn-xs" onclick=updateStatus('+r.id+','+r.status+')>'+(r.status==1?'開啟':'停用')+'</a>';
            }}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增自动出款通道',get:'payset/edit_out_info',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯自动出款通道',get:'payset/edit_out_info',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'payset/del_online_out_setting'});
            }},
            <?php }?>
            {text:"自动出款記錄",iconCls:"icon-payment",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                if(d==null){
                    Core.error('請選擇出款平臺');
                    return false;
                }
                Core.addTab('自动出款記錄', 'payset/online_out_list?payId='+d.o_id);
            }},
            {type:'combobox',text:'狀態',width:100,name:'status',value:'', items:'<option value="">全部</option><option value="1">啟用</option><option value="2">停用</option>'},
            {type:'combobox',text:'第三方平臺',width:100,name:'bank_o_id',value:'', items:'<option value="">全部</option><?php foreach($platform as $v){echo "<option value=$v[id]>$v[out_online_name]</option>"; }?>'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                 $('#<?php echo $id?>').DataSource('search');
            }}
        ],
        footer:true,
        edit:true
    });
    function updateStatus(id,status){
        $.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該自动出款使用嗎', function(r){
            if (r){
                $.post(WEB+'payset/edit_online_out_setting_status',{id:id,status:status},function(c){
                    $('#<?php echo $id?>').datagrid('reload');
                });
            }
        });
    }
</script>