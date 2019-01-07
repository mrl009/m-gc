<br/>
<div class="panel panel-default" data-collapsed="0" style="margin:0 20px">	
	<div class="panel-heading" style="min-height:50px;border:1px solid #cecece">
		<div class="panel-title"><span><a href="javascript:editChannel();" class="btn btn-primary"><i class="entypo-plus"></i>新增分類</a></span> </div>
	</div>
	<div class="panel-body no-padding channels" style="padding: 5px 0;padding-top:0">
		<div id="channel_tree" class="aciTree aciTreeFullRow" style="min-height: 70px;"></div>
	</div>
</div>
<script>
$('.channels').on('dblclick','.aciTreeEntry',function(){
	eval($(this).find('a.btn-default').attr('href'))
});
initTree();
function initTree(){
	$('#channel_tree').aciTree({
        ajax: {url: 'content/getchannel?pid='},
        fullRow: true,
        columnData: [{props: 'type'},{props: 'size'},{props:'action'}]
    }).on('acitree', function(event, api, item, eventName, options){
		if(eventName=='init'){
            api.open(api.first(), {
				success: function(item) {this.select(this.first(item));}
            });
			$('#channel_tree').focus();
        }
    });
}
function rebuildTree(){
	var api = $('#channel_tree').aciTree('api');
	api.unload(null, {success: function(){
        this.ajaxLoad(null);
        initTree();
    }});
}
function editChannel(id){
    var name = id ? '修改分類' : '新增分類';
	Core.dialog(name,'content/editchannel'+(id==undefined?'':'?id='+id),function(){
		rebuildTree();
	},true,false);
}
function delChannel(id){
	Core.dialog('溫馨提示','<i class="entypo-info-circled"></i>即將執行不可逆操作，確實要刪除此分類及其所屬所有子分類嗎？',function(dlg){
		$.get('content/removechannel',{id:id},function(){
			dlg.modal('hide');
			Core.ok('成功刪除分類！');
			rebuildTree();
		});
	},false,false);
}
</script>
<style>
.channels .aciTree .aciTreeEntry{padding-top:3px;padding-bottom:3px;padding-right:12px;}
.channels .aciTree .aciTreeText{font-size:13px}
</style>