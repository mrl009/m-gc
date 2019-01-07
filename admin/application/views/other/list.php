<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$("#<?php echo $id;?>").DataSource({url:'order/getlist',
	fields:[[
		{field:'id',      title:'ID',        width:40,sortable:true},
		{field:'xz',      title:'下註/結算 ', width:130, sortable:false},
		{field:'kithe',   title:'期數 ',      width:100, sortable:true},	
		{field:'upline',  title:'所屬上線',   width:80, sortable:true},
		{field:'order_sn',title:'註單號',    width:150,  sortable:true},	
		{field:'username',title:'帳號',      width:100,  sortable:true},	
		{field:'type',    title:'類型',      width:100,  sortable:true},	
		{field:'content', title:'內容',      width:180,  sortable:true},
		{field:'money',   title:'下註金額',  width:80,  sortable:true},	
		{field:'rebate',  title:'返水',       width:80,  sortable:true},	
		{field:'lucky_price',title:'可贏金額',width:80,  sortable:true},	
		{field:'result',  title:'結果',       width:60,  sortable:true},	
		{field:'pc',      title:'派彩',       width:60,  sortable:true}
		
    ]], tools:[
		{instant:false},
		<?php if(in_array('EDIT',$auth)){?>
		{text:"編輯",iconCls:"icon-edit",handler:function(){
			$('#<?php echo $id?>').DataSource('edit',{title:'查看',get:'member/edituser?type=<?php echo $type?>',full:false});
		}},
		<?php }?>
		{type:'combobox',text:'類型',width:100,name:'verify_status',value:'', items:'<option value="">所有彩種</option><option value="1">PC蛋蛋</option>'},
		{type:'combobox',text:'狀態',width:100,name:'verify_status',value:'', items:'<option value="">全部</option><option value="1">已結算</option><option value="1">未結算</option>'},
		{type:'textbox', text:'帳號', width:100,name:'username'},
		{type:'textbox', text:'註單號', width:100,name:'username'},
		{type:'datebox', text:'日期', width:100,name:'qaddtime'},
		{type:'datebox', text:'-', width:100,name:'zaddtime'},
		{type:'combobox',text:'來源',width:100,name:'verify_status',value:'', items:'<option value="">全部</option><option value="1">PC端</option><option value="1">WAP端</option>'},
		{text:"搜索", iconCls:"icon-search", handler:function(){
			$('#<?php echo $id?>').DataSource('search');
		}},
	'-'
	],
	footer:true,
	success:function(){

	}
});
</script>