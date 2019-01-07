<form class="form-horizontal validate" role="form" method="post" action="content/savechannel">
	<input type="hidden" name="id" value="<?php echo $id?>">
	<input type="hidden" name="no_edit" value="<?php echo $no_edit?>">
	<div class="form-group">
		<label class="col-sm-2 control-label">名稱</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="name" value="<?php echo $name?>" data-validate="required" data-message-required="分類名稱不能為空">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">上級分類</label>
		<input type="hidden" name="parent_id" value="<?php echo $parent_id?>" />
		<div class="col-sm-10">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span id="cateName"><?php echo $cateName?$cateName:'頂級分類';?></span> <span class="caret"></span></button>
				<div class="dropdown-menu">
					<div class="scrollable" data-height="150" data-width="300">
						<div id="cateTree" class="aciTree aciTreeFullRow" style="min-height: 70px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
$('#cateTree').aciTree({
    ajax: {url: 'content/getchannel?self=<?php echo $id?>&pid=<?php echo $parent_id?>'},
    selectable: true
}).on('acitree', function(event, api, item, eventName, options){
	if(eventName=='selected'){
		var itemData = api.itemData(item);
		$('#cateName').text(itemData.label);
		$('[name=parent_id]').val(itemData.id);
	}
});
$(".dropdown-menu").on("click", ".aciTreeButton", function(e) {
    e.stopPropagation();
});
</script>