<?php $id=uniqid();?>
<table class="table table-bordered datatable" id="<?php echo $id?>"></table>
<script type="text/javascript">
$('#<?php echo $id?>').datagrid({
	url:"../manager/getlist",
	columns:[
		{mData:'id',sTitle:'ID'},
		{mData:'username',sTitle:'用户名',sWidth:100},
		{mData:'role_id',sTitle:'角色',sWidth:300},
		{mData:'email',sTitle:'邮箱'}
	],
	tools:[
		{type:'button',text:'新增',icon:'entypo-plus',handler:function(){
			$('#<?php echo $id?>').datagrid('add',{title:'新增内容',get:'../manager/edit',full:false,before:function(){
				if($('[name=password]').val()!=$('[name=conf_pwd]').val()){Core.error('两次密码输入不一致');return false;}	else return true;																							
			 }
			});
		}},
		{type:'button',text:'编辑',icon:'entypo-pencil',handler:function(){
			$('#<?php echo $id?>').datagrid('edit',{title:'修改内容',get:'../manager/edit',full:false,before:function(){
				if($('[name=password]').val()!=''){
					if($('[name=password]').val()!=$('[name=conf_pwd]').val()){Core.error('两次密码输入不一致');return false;}	else return true;	
				}else return true;																								 
			 }
			});
		}},
		{type:'button',text:'删除',icon:'entypo-trash',handler:function(){
			$('#<?php echo $id?>').datagrid('remove',{get:'../manager/delete'});
		}},
		{type:'datebox',text:'开始日期',width:100,name:'startDate'},
		{type:'datebox',text:'结束日期',width:100,name:'endDate'},
		{type:'textbox',text:'关键词',name:'keywords',width:150},
		{type:'button',text:'搜索',icon:'entypo-search',handler:function(){
			$('#<?php echo $id?>').datagrid('search');
		}}
	]
});
</script>