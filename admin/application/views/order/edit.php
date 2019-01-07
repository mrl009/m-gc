<?php $id=uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="push_news/save?type=custom" style="height:300px;width:560px">
    <input type="hidden" name="dgId" value="<?php echo $id?>" />
	<table id="<?php echo $id?>"></table>
</form>
<script>
$("#<?php echo $id;?>").DataSource({url:'order/getlist',
	fields:[[
		{field:'id',      title:'ID',        width:40,sortable:true},
		{field:'xz',      title:'下註/結算 ', width:130, sortable:false},
		{field:'kithe',   title:'期數 ',      width:100, sortable:true},	
		{field:'upline',  title:'所屬上線',   width:80, sortable:true}
		
    ]], tools:[
		{instant:false},
		{type:'datebox', text:'日期', width:100,name:'qaddtime'},
		{type:'datebox', text:'-', width:100,name:'zaddtime'},
		{text:"搜索", iconCls:"icon-search", handler:function(){
			$('#<?php echo $id?>').DataSource('search');
		}},
	'-'
	],
	success:function(){

	}
});
</script>