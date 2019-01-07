<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'log/get_front_notice_list',
        fields:[[
            {field:'id',           title:'ID',align:'center',width:50,sortable:true},
            {field:'notice_type',  title:'顯示類型',align:'center',width:100},
            {field:'level_name',   title:'層級',width:100,align:'center',sortable:false},
            {field:'content',      title:'顯示內容 ',width:750,sortable:false},
            {field:'username',     title:'發布者',width:80,align:'center',sortable:false},
            {field:'show_location',title:'顯示位置',align:'center',width:60},
            {field:'addtime',      title:'發布時間 ',align:'center',width:150,sortable:false},
            {field:'op',           title:'功能', align:'center',width:60,sortable:false,formatter:function(v,r){
                return '<a herf="#" onclick=updateStatus('+r.id+','+r.status+')>'+(r.status==1?'<span class="btn label label-success">開啟</span>':'<span class="btn label label-danger">暫停</span>')+'</a>';
            }}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'發布公告',get:'log/add_front_notice?admin_id=<?php echo $admin_id?>',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'修改公告',get:'log/add_front_notice',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'log/delete_front_notice'});
            }},
            <?php }?>
            {type:'datebox', text:'日期', width:100,name:'from_time'},
            {type:'datebox', text:'-', width:100,name:'to_time'},
            {type:'combobox',text:'狀態',width:100,name:'status',value:'', items:'<option value="">全部</option><option value="0">停用</option><option value="1">啟用</option>'},
            {type:'textbox', text:'內容查詢', width:100,name:'content'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='from_time']").val();
                var end = $("#form_<?php echo $id?> input[name='to_time']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }
            }
        ]
    });
    function updateStatus(id,status){
        $.messager.confirm('溫馨提示', '確定'+(status==1?'暫停':'開啟')+'該公告使用嗎', function(r){
            if (r){
                $.post(WEB+'log/update_front_notice_status',{id:id,status:status},function(c){
                    $('#<?php echo $id?>').datagrid('reload');
                });
            }
        });
    }
</script>