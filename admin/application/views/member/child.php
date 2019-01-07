<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$("#<?php echo $id;?>").DataSource({url:'member/getchild',
	fields:[[
		{field:'id',      title:'ID', width:60,sortable:true},
		{field:'online',title:'狀態 ', align:'center', width:50, sortable:false,formatter:function (v,r) {
            if (v== 1) return '<span class="label label-success">在線</span>';
            if (v== 2) return '<span class="label label-default">離線</span>';
        }},
        {field:'username', title:'帳號',align:'center',width:120,},
		{field:'name',     title:'名稱 ',align:'center',width:100,},	
		{field:'update_time',title:'最後登錄時間',align:'center',width:160,formatter:function(v){return date('Y-m-d H:i:s',v)}},	
		{field:'ip',  title:'最後登錄IP',align:'center',width:160},	
		{field:'addtime',  title:'新增日期',align:'center',width:150,  sortable:true,formatter:function(v){return date('Y-m-d H:i:s',v)}},
		{field:'status',   title:'狀態',align:'center', width:50,  sortable:true,formatter:function (v,r) {
            if (v== 1) return '<span class="label label-info">正常</span>';
            if (v== 2) return '<span class="label label-warning">停用</span>';
            if (v== 3) return '<span class="label label-danger">鎖定</span>';
        }}<?php if($this->session->userdata('admin_id')==1) echo ',';?>
        <?php if($this->session->userdata('admin_id')==1){?>
		{field:'aa',  title:'功能',align:'center', width:115,sortable:false,formatter:function(v,r){
			return (r.id!=1?'<a herf="#" onclick=Core.dialog("子賬號權限管理","member/get_power?id='+r.id+'",function(){},true,false);><span class="btn label label-primary">權限設置</span></a>'+'<a herf="#" onclick=updateStatus('+r.id+','+r.status + ',"' + r.username +'")>'+(r.status==2?'<span class="btn label label-success">開啟</span>':'<span class="btn label label-warning">暫停</span>')+'</a>&nbsp;&nbsp;':'');
		}}
		<?php }?>
    ]], tools:[
	{instant:false},
	<?php if(in_array('ADD',$auth)){?>
	{text:"新增",iconCls:"icon-add",handler:function(){
		$('#<?php echo $id?>').DataSource('add',{title:'新增子賬號',get:'member/editchild',full:false});
	}},
	<?php }?>
    <?php if(in_array('EDIT',$auth)){?>
    {text:"編輯",iconCls:"icon-edit",handler:function(){
    	<?php if($this->session->userdata('admin_id')==1){?>
        $('#<?php echo $id?>').DataSource('edit',{title:'查看子賬號',get:'member/editchild',full:false});
        <?php }else{?>
        	Core.error('您沒有操作權限');
        <?php }?>
    }},
    <?php }?>
	<?php if(in_array('DELETE',$auth)){ ?>
	{text:"刪除",iconCls:"icon-remove",handler:function(){
		var rows = $('#<?php echo $id?>').datagrid('getSelections');
		var flag = false;
		$.each(rows,function(i,d){
		    if (d.id==1) {
                Core.error('超級管理員不能刪除');
		        flag = true;
            }
		});
		if (!flag) {
            $('#<?php echo $id?>').DataSource('remove',{get:'member/delete_user'});
        }
	}},
	<?php }?>
		{type:'textbox', text:'帳號', width:120,name:'username'},
		{type:'textbox', text:'名稱', width:120,name:'name'},
		{text:"搜索", iconCls:"icon-search", handler:function(){
			$('#<?php echo $id?>').DataSource('search');
		}},
	'-'
	],
	edit:false,
	success:function(){

	}
});
function updateStatus(id,status,username){
	$.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該帳號使用嗎', function(r){
		if (r){
			$.post(WEB+'member/update_status',{id:id,status:status,username:username},function(c){
				$('#<?php echo $id?>').datagrid('reload');
			});
		}
	});
}
</script>

