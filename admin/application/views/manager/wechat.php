<?php $id=uniqid();?>
<table id="<?php echo $id?>"></table>
<script type="text/javascript">
$("#<?php echo $id;?>").DataSource({url:'manager/getsites',fields:[[
	{field:'id',        title:'ID'},
	{field:'name',      title:'站点名称',width:180},
	{field:'wechat_id', title:'微信号',  width:120},
	{field:'wechat_oid',title:'原始ID',  width:150},
	{field:'status',    title:'状态',    width:120,formatter:function(v){return v==1?'<font style="color:green">已启用</font>':'<font style="color:red">已停用</font>'}}
    ]], tools:[
	{instant:false},
	{text:"新增",iconCls:"icon-add",handler:function(){
		$('#<?php echo $id?>').DataSource('add',{title:'新增公众号',get:'manager/edit_sites',full:false});
	}},
	{text:"编辑",iconCls:"icon-edit",handler:function(){
		$('#<?php echo $id?>').DataSource('edit',{title:'编辑公众号',get:'manager/edit_sites',full:false});
	}},
	{text:"删除",iconCls:"icon-remove",handler:function(){
		$('#<?php echo $id?>').DataSource('remove',{get:'manager/delete_sites'});
	}},
	{text:"搜索", iconCls:"icon-search", handler:function(){
		$('#<?php echo $id?>').DataSource('search');
	}}
	]
});
</script>