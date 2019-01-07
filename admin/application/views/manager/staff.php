<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$('#<?php echo $id?>').DataSource({url:'manager/stafflist',fields:[[
	{field:'id',       title:'ID',  align:'center',   width:120},
	{field:'username', title:'登录名', align:'center', width:200},
	{field:'alias',    title:'姓名', align:'center',   width:200},
	{field:'role_name',title:'所属部门',align:'center', width:200},
	{field:'role_id',  title:'角色ID', align:'center', width:150}			   
    ]], tools:[
	{instant:false},
	<?php if(in_array('ADD',$auth)){?>
		{text:"新增",iconCls:"icon-add",handler:function(){
			$('#<?php echo $id?>').DataSource('add',{title:'新增员工',get:'manager/add?rid=',full:false});
		}},
	<?php }?>
	<?php if(in_array('EDIT',$auth)){?>
	{text:"编辑",iconCls:"icon-edit",handler:function(r){
		var row = $('#<?php echo $id?>').datagrid('getSelected');
		$('#<?php echo $id?>').DataSource('edit',{title:'修改员工',get:'manager/edit?rid='+row.role_id,full:false});
	}},
	<?php }?>
	<?php if(in_array('DELETE',$auth)){ ?>
	{text:"删除",iconCls:"icon-remove",handler:function(){
		$('#<?php echo $id?>').DataSource('remove',{get:'manager/delete'});
	}},
	<?php }?>
	'|',
		{type:'label',html:'分类：<span class="dropdown"><button class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="padding:2px 12px;font-size:12px;"><span id="admin_cateName">顶级分类</span><i class="caret"></i></button><div class="dropdown-menu"><div id="admin_cateTree" class="aciTree aciTreeFullRow" style="min-height:70px;"></div></div></span><input type="hidden" name="admin_role_id"/>',width:150},
		{type:'textbox',text:'用户名',name:'username',width:150},
		{text:"搜索", iconCls:"icon-search", handler:function(){
			$('#<?php echo $id?>').DataSource('search');
		}},
	'-'
	],
	footer:true
});

$('#admin_cateTree').aciTree({
	ajax: {url: 'manager/ajaxrole?pid='},
	selectable: true
	}).on('acitree', function(event,api, item, eventName, options){
		if(eventName=='selected'){
			var itemData = api.itemData(item);
			$('#admin_cateName').text(itemData.label);
			$('[name=admin_role_id]').val(itemData.id);
		}
	});
	$(".dropdown-menu").on("click", ".aciTreeButton", function(e) {
		e.stopPropagation();
});
</script>

