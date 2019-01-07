<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$("#<?php echo $id;?>").DataSource({url:'member/get_promotion_list',
	fields:[[
		{field:'id',      title:'ID',align:'center',width:60,sortable:true},
		{field:'username', title:'會員',align:'center', width:150,editor:'text'},
		{field:'before_id',title:'晋级前等級',align:'center', width:80,formatter:function(v){
			return v?'VIP'+v:'';
		}},
		{field:'grade_id',title:'晋级后等級',align:'center', width:80,formatter:function(v){
			return v?'VIP'+v:'';
		}},
        {field:'title',title:'晉級爵位', align:'center',width:110},
		{field:'jj_money',title:'晉級獎勵',align:'center', width:110},
		{field:'integral',title:'成長積分',align:'center', width:110},
		{field:'is_tj',title:'是否跳級', align:'center', width:80,formatter:function(v,r){
            var r = '';
            if (v == '1') {
            	r = '否';
            } else if(v == 2) {
                r = '<span style="color:red">是</span>';
            }
            return r;
        }},
		{field:'add_time', title:'晋级时间', align:'center',width:130,  sortable:true},
		{field:'update_time', title:'領取时间', align:'center',width:130,formatter:function(v){
			return v>0?date('Y-m-d H:i:s',v):'';
		}},
		{field:'is_receive', title:'是否領取', align:'center',width:100,formatter:function(v){
			return v==2?'<span style="color:red">是</span>':'否';
		}}
		
    ]], tools:[
	{instant:false},
		{type:'datebox', text:'晋级时间', width:98,name:'start_date'},
		{type:'datebox', text:'-', width:98,name:'end_date'},
		{type:'textbox', text:'帳號', width:120,name:'username'},
		{type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
            var start = $("#form_<?php echo $id?> input[name='start_date']").val();
            var end = $("#form_<?php echo $id?> input[name='end_date']").val();
            if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                Core.error('查詢區間限制為兩個月');
                return false;
            }
            $('#<?php echo $id?>').DataSource('search');
		}},
	'-'
	],
	footer:true,
	success:function(){	
		
	}
});
</script>