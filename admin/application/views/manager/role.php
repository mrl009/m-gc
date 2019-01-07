<?php $id=uniqid();?>
<table class="table table-bordered datatable" id="<?php echo $id?>"></table>
<script type="text/javascript">
$('#<?php echo $id?>').datagrid({
	url:"../manager/getrole",
	columns:[
		{mData:'id',sTitle:'ID'},
		{mData:'name',sTitle:'角色名'}
	],
	tools:[
		{type:'button',text:'新增',icon:'entypo-plus',handler:function(){
			$('#<?php echo $id?>').datagrid('add',{title:'新增内容',get:'../manager/edit_role',full:false});
		}},
		{type:'button',text:'编辑',icon:'entypo-pencil',handler:function(){
			$('#<?php echo $id?>').datagrid('edit',{title:'修改内容',get:'../manager/edit_role',full:false});
		}},
		{type:'button',text:'删除',icon:'entypo-trash',handler:function(){
			$('#<?php echo $id?>').datagrid('remove',{get:'../manager/delete_role'});
		}},
		{type:'textbox',text:'角色名',name:'name',width:150},
		{type:'button',text:'搜索',icon:'entypo-search',handler:function(){
			$('#<?php echo $id?>').datagrid('search');
		}}
	]
});
</script>