<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$('#<?php echo $id?>').DataSource({url:'content/get_article_list',fields:[[
	{field:'id',title:'ID',width:80},
	{field:'title',       title:'標題',   width:280},
	{field:'category_name', title:'所屬分類',width:80},
	{field:'add_time',    title:'發布時間',width:150}
    ]], tools:[
	{instant:false},
	<?php if(in_array('ADD',$auth)){?>
		{text:"新增",iconCls:"icon-add",handler:function(){
			$('#<?php echo $id?>').DataSource('add',{title:'新增內容',get:'content/editarticle',full:true});
		}},
	<?php }?>
	<?php if(in_array('EDIT',$auth)){?>
	{text:"編輯",iconCls:"icon-edit",handler:function(){
		$('#<?php echo $id?>').DataSource('edit',{title:'修改內容',get:'content/editarticle',full:true});
	}},
	<?php }?>
	<?php if(in_array('DELETE',$auth)){ ?>
	{text:"刪除",iconCls:"icon-remove",handler:function(){
		$('#<?php echo $id?>').DataSource('remove',{get:'content/delarticle'});
	}},
	<?php }?>
	'|',
		{type:'label',html:'分類：<span class="dropdown"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span id="text_cateName">頂級分類</span><i class="caret"></i></button><div class="dropdown-menu"><div id="text_cateTree" class="aciTree aciTreeFullRow" style="min-height:70px;"></div></div></span><input type="hidden" name="search_category_id"/>',width:150},
        {type: 'datebox', text: '日期', width: 100, name: 'time_start'},
        {type: 'datebox', text: '-', width: 100, name: 'time_end'},
		{type:'textbox',text:'關鍵詞',name:'keywords',width:150},
		{text:"搜索", iconCls:"icon-search", handler:function(){
            var start = $("#form_<?php echo $id?> input[name='time_start']").val();
            var end = $("#form_<?php echo $id?> input[name='time_end']").val();
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

$('#text_cateTree').aciTree({
	ajax: {url: 'content/getchannel?self=<?php echo $id?>&pid=<?php echo $pid?>'},
	selectable: true
	}).on('acitree', function(event,api, item, eventName, options){
		if(eventName=='selected'){
			var itemData = api.itemData(item);
			$('#text_cateName').text(itemData.label);
			$('[name=search_category_id]').val(itemData.id);
		}
	});
	$(".dropdown-menu").on("click", ".aciTreeButton", function(e) {
		e.stopPropagation();
});

</script>
