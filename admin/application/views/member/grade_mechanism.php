<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$("#<?php echo $id;?>").DataSource({url:'member/get_grade_list',
	fields:[[
		{field:'id',      title:'ID',align:'center',width:60,sortable:true},
		{field:'adm', title:'等級',align:'center', width:150,formatter: function (v, r) {return 'VIP'+r.id}},
		{field:'title',title:'頭銜', align:'center',width:110},
		{field:'integral',title:'成長積分',align:'center', width:110},
		{field:'jj_money',title:'晉級獎勵(元)',align:'center', width:110},
		{field:'tj_money',title:'跳級獎勵(元)',align:'center', width:110},
		{field:'user_sum',title:'會員數(人)',align:'center', width:110},
		{field:'t',title:'刷新會員數',align:'center', width:110,formatter:function(v,r){
			return '<a href="javascript:;" onclick="sum_user('+r.id+')">刷新</a>';
		}}
	
    ]], tools:[
	{instant:false}
	],
	footer:true,
	success:function(){	
		
	}
});

function sum_user(id){
	if(id){
		Core.loading();
		$.post('member/sum_user',{id:id},function(c){
			Core.hideloading();
			c=eval('('+c+')');
			if(c.status=='OK'){
				Core.ok('操作成功');
				$("#<?php echo $id;?>").datagrid('reload');
			}else{
				Core.error(c.msg);
			}
		});
	}
}

</script>