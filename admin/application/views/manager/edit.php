<?php $id=uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="manager/save" id="<?php echo $id?>">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	<input type="hidden" name="role_id" value="<?php echo $role['id']?>">
	<ul class="nav nav-tabs bordered" style="margin-top:0">
		<li class="active"><a href="#staff-basic1" data-toggle="tab"><span class="hidden-xs">基本信息</span></a></li>
		<?php if($parent['is_config_menu']==2){?>
		<li><a href="#staff-public1" data-toggle="tab"><span class="hidden-xs">公共權限</span></a></li>
		<li><a href="#staff-pc1" data-toggle="tab"><span class="hidden-xs">PC網站權限</span></a></li>
		<li><a href="#staff-wechat1" data-toggle="tab"><span class="hidden-xs">微信權限</span></a></li>
		<li><a href="#staff-app1" data-toggle="tab"><span class="hidden-xs">APP客戶端權限</span></a></li>
		<li><a href="#staff-market1" data-toggle="tab"><span class="hidden-xs">營銷中心權限</span></a></li>
		<?php }?>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="staff-basic1">
			<div class="form-group">
				<label class="col-sm-2 control-label">所屬部門:</label>
				<div class="col-sm-10">
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span id="cateName"><?php echo $role['name']?></span> <span class="caret"></span></button>
						<div class="dropdown-menu">
							<div class="scrollable" data-height="150" data-width="300">
								<div id="cateTree" class="aciTree aciTreeFullRow" style="min-height: 70px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">登錄名：</label>
				<div class="col-sm-10">
					<input type="text" <?php echo $rs['id']?'readOnly':''?> class="form-control" name="username" value="<?php echo $rs['username']?>" data-validate="required" data-message-required="用戶名不能為空">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">名稱：</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="alias" value="<?php echo $rs['alias']?>" data-validate="required" data-message-required="員工姓名不能為空">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">郵箱:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="email"  data-validate="required,email"  value="<?php echo $rs['email']?>" 
					data-message-required="郵箱不能為空" data-message-email="郵箱格式不正確">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">下屬權限:</label>
				<div class="col-sm-10">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default active"><input type="radio" name="is_config_menu" value="2" checked>允許分配</label>
						<label class="btn btn-default"><input type="radio" name="is_config_menu" value="1" <?php echo $rs['is_config_menu']==1?'checked':''?>>不允許分配</label>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">密碼:</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="password" AUTOCOMPLETE="off" <?php echo !$rs['id']?'data-validate="required" data-message-required="密碼不能為空"':'';?>>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">重復密碼:</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="conf_pwd" AUTOCOMPLETE="off" <?php echo !$rs['id']?'data-validate="required" data-message-required="重復密碼不能為空"':'';?>>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="staff-pc1">
			<span id="menu-pc1"></span>
		</div>
		<div class="tab-pane" id="staff-wechat1">
				<span id="menu-wechat1"></span>
				<div class="form-group">
					<label class="col-sm-2 control-label">管轄微信:</label>
					<div class="col-sm-10">
						<?php foreach($wechat as $v){?>
							<div style="width:120px; float:left;"><input type="checkbox" name="scope_site[]" <?php echo in_array($v['id'],$scope_site)?'checked':''?> value="<?php echo $v['id']?>" /> <?php echo $v['name']?></div>
						<?php }?>
					</div>
				</div>
		</div>
		<div class="tab-pane" id="staff-app1">
				<span id="menu-app1"></span>
		</div>
		<div class="tab-pane" id="staff-public1">
				<span id="menu-public1"></span>
		</div>
		<div class="tab-pane" id="staff-market1">
				<span id="menu-market1"></span>
		</div>
	</div>
</form>
<style>
.f_group td input{margin-left:18px;margin-right:5px;}
.f_group td{padding:5px 2px;}
.f_group table{margin:0;}
.f_group .panel-body{padding:0;}
.f_group .r{width:105px;padding-left:0;border-right:1px solid #cecece}
</style>
<script>
var current_auth=<?php echo $rs['privileges']?$rs['privileges']:'[]'?>;
function getRoleAuth(id){
	$.getJSON('manager/roleauth?id='+id,function(c){
		$('#menu-public1').authMenu({type:'public', data:c.public, auth:current_auth});
		$('#menu-pc1').authMenu({type:'pc', data:c.pc, auth:current_auth});
		$('#menu-wechat1').authMenu({type:'wechat', data:c.wechat, auth:current_auth});
		$('#menu-app1').authMenu({type:'app', data:c.app, auth:current_auth});
		$('#menu-market1').authMenu({type:'market', data:c.market, auth:current_auth});
	});
}
$('#cateTree').aciTree({
    ajax: {url: 'manager/ajaxrole?pid='},
    selectable: true
}).on('acitree', function(event, api, item, eventName, options){
	if(eventName=='selected'){
		var itemData = api.itemData(item);
		$('#<?php echo $id?> #cateName').text(itemData.label);
		$('#<?php echo $id?> [name=role_id]').val(itemData.id);
		getRoleAuth(itemData.id);
	}
});
getRoleAuth(<?php echo $role['id']?>);
$(".dropdown-menu").on("click", ".aciTreeButton", function(e) {
    e.stopPropagation();
});
</script>