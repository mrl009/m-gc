<?php $id=uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="push_news/save?type=<?php echo $type?>" style="height:300px;width:540px">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	
	<table id="<?php echo $id?>"></table>
</form>
<script>
$("#<?php echo $id;?>").DataSource({url:'order/getlist',fields:[[
	{field:'id',       title:'ID',      width:80},
	{field:'kithe',    title:'期數',width:80},
	{field:'order_sn', title:'訂單號',width:280}
    ]], tools:[
	{instant:false},
		//{type:'datebox',text:'開始日期',width:100,name:'qaddtime'},
		//{type:'datebox',text:'結束日期',width:100,name:'zaddtime'},'|',
		{type:'textbox',text:'關鍵詞',name:'keywords',width:150},
		{text:"搜索", iconCls:"icon-search", handler:function(){
			$('#<?php echo $id?>').DataSource('search');
		}},
]
});