<?php $form_id=uniqid();?>
<form class="form-horizontal validate"  role="form" method="post" action="content/savearticle">
	<input type="hidden" name="id" value="<?php echo $id?>">
	<input type="hidden" name="no_edit" value="<?php echo $no_edit?>">
	<div class="tab-content">
		<div class="tab-pane active" id="basic">
        	<div class="form-group">
				<label class="col-sm-2 control-label">所屬分類</label>
				<input type="hidden" name="category_id" value="<?php echo $category_id?>">
				<div class="col-sm-8">
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span id="cateName"><?php echo $cateName?$cateName:'無分類';?></span> <span class="caret"></span>
                        </button>
						<div class="dropdown-menu">
							<div class="scrollable" data-height="150" data-width="300">
								<div id="cateTree" class="aciTree aciTreeFullRow" style="min-height: 70px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">標題：</label>
				<div class="col-sm-10">
					<input type="text" class="form-control easyui-validatebox" name="title" value="<?php echo $title?>" data-options="required:true">
				</div>
			</div>
            <div class="form-group">
                <label class="col-sm-2 control-label">摘要：</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="remark" value="<?php echo $remark?>">
                </div>
            </div>
			<div class="form-group">
				<label class="col-sm-2 control-label">排序:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control easyui-validatebox" name="orderby" value="<?php echo $orderby?>">
					<span style="color:red">*註：倒序排序，數據越大越靠前</span>
				</div>
			</div>
            <div class="form-group">
                <label class="col-sm-2 control-label">內容:</label>
                <div class="col-sm-10">
                    <textarea id="<?php echo $form_id?>" style="height:300px;width: 100%" name="content"><?php echo $content?></textarea>
                </div>
            </div>
		</div>
    </div>
</form>
<script>
var ue=UE.getEditor('<?php echo $form_id?>',{
    toolbars:[['source','bold','italic','link', 'unlink','underline','fontborder','forecolor','backcolor','simpleupload','fontsize','fontfamily','justifyleft','justifycenter','indent']],

    elementPathEnabled: false,//刪除元素路徑
    wordCount: false    //刪除字數統計
});
/*Core.singleUploader('uploadBtn',[{title : "Image files", extensions : "jpg,gif,png"}],'1mb',function(rs){
	$('.gallery-env').append('<div class="col-sm-2 col-xs-4"><article class="image-thumb"><a href="#" class="image"><input type=hidden name="thumb[]" value="'+rs.result+'"><img src="'+WEB+'../'+rs.result+'" /></a><div class="image-options"><a href="javascript:;" class="edit" onclick="Core.editPhoto(\''+rs.result+'\')"><i class="entypo-pencil"></i></a><a href="#" class="delete"><i class="entypo-cancel"></i></a></div></article></div>');
	news_sort();
},{width:500,height:400,quality:100,crop: true});*/
$('#cateTree').aciTree({
    ajax: {url: 'content/getchannel?pid='},
    selectable: true
}).on('acitree', function(event, api, item, eventName, options){
	if(eventName=='selected'){
		var itemData = api.itemData(item);
		$('#cateName').text(itemData.label);
		$('[name=category_id]').val(itemData.id);
		event.preventDefault();
	}
});
$(".dropdown-menu").on("click", ".aciTreeButton", function(e) {
    e.stopPropagation();
});
$(".gallery-env").on("click", ".image-thumb .image-options a.delete", function(ev){
	ev.preventDefault();
	var $image = $(this).parents('.col-sm-2');
	$image.remove();
});
function news_sort(){
	$('.gallery-env').sortable();
}
news_sort();
</script>