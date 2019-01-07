<!-- 活動管理 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$("#<?php echo $id;?>").DataSource({url:'setting/get_activity_list',
	fields:[[
		{field:'id',      title:'ID ',       width:40, sortable:false},
		{field:'img_base64', title:'縮略圖',     width:330,formatter:function(v){return v?'<img src="'+v+'" style="width:98%;height:80px">':'';}},
		{field:'title',   title:'標題 ',      width:250},
		{field:'show_way',title:'顯示終端', align:'center', width:120, sortable:true,formatter:function(v){
            if (v) {
                var s = v.split(','), r = '';
                $.each(s, function (i, d) {
                   if (d == 1) {
                       r += '<i class="fa fa-apple fa-lg"></i>&nbsp;&nbsp;'
                   } else if (d == 2) {
                       r += '<i class="fa fa-android fa-lg"></i>&nbsp;&nbsp;'
                   } else if (d == 3) {
                       r += '<i class="fa fa-desktop fa-lg"></i>&nbsp;&nbsp;'
                   } else if (d == 4) {
                       r += '<i class="fa fa-html5 fa-lg"></i>&nbsp;&nbsp;'
                   }
                });
                return r
            }
            return ''
        }},
		{field:'addtime',title:'發布時間', align:'center', width:110, sortable:true,formatter:function(v){return date('Y-m-d',v)}},
		{field:'start_time',title:'开始時間', align:'center', width:110, sortable:true,formatter:function(v){return v==0 ? '' : date('Y-m-d',v)}},
		{field:'expiration_time',title:'過期時間', align:'center',width:130, sortable:true,formatter:function(v){return date('Y-m-d',v)}},
		{field:'status',title:'狀態', align:'center',hidden:true},
		{field:'op', title:'操作', width:60,align:'center',sortable:false,formatter:function(v,r){
			if(r.id!=1001&&r.id!=1002){
				return '<a herf="#"  onclick="updateActiveStatus('+r.id+','+r.status+',\''+ r.title+ '\')">'+(r.status==2?'<span class="label label-danger">暫停</span>':'<span class="label label-success">開啟</span>')+'</a>';
			}else{
				return '<span class="label label-success"></span>';
			}
		}}
    ]],
    tools:[
        {instant:false},
        <?php if(in_array('ADD',$auth)){?>
        {text:"新增",iconCls:"icon-add",handler:function(){
            $('#<?php echo $id?>').DataSource('add',{title:'新增',get:'setting/activity_con_set',full:true});
        }},
        <?php }?>
        <?php if(in_array('EDIT',$auth)){?>
	    {text:"編輯",iconCls:"icon-edit",handler:function(){
	        $('#<?php echo $id?>').DataSource('edit',{title:'編輯',get:'setting/activity_con_set',full:true});
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
			$('#<?php echo $id?>').DataSource('remove',{get:'setting/delete_activity'});
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