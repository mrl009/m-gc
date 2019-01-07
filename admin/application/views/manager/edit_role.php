<?php $id=uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="manager/save_role">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	<input type="hidden" name="pid" value="<?php echo $rs['pid']?>">
	<ul class="nav nav-tabs bordered" style="margin-top:0">
		<li class="active"><a href="#staff-basic" data-toggle="tab"><span class="hidden-xs">部门</span></a></li>
		<?php if($role_pid==0){?>
		<li><a href="#staff-public" data-toggle="tab"><span class="hidden-xs">公共</span></a></li>
		<li><a href="#staff-pc" data-toggle="tab"><span class="hidden-xs">PC网站</span></a></li>
		<li><a href="#staff-wechat" data-toggle="tab"><span class="hidden-xs">微信</span></a></li>
		<li><a href="#staff-app" data-toggle="tab"><span class="hidden-xs">APP客户端</span></a></li>
		<li><a href="#staff-market" data-toggle="tab"><span class="hidden-xs">营销中心</span></a></li>
		<li><a href="#staff-worker" data-toggle="tab"><span class="hidden-xs">员工</span></a></li>
		<?php }?>
	</ul>
	<div class="tab-content" style="padding:0">
		<div class="tab-pane active" id="staff-basic" style="padding:10px">
			<div class="form-group">
				<label class="col-sm-2 control-label">名称：</label>
				<div class="col-sm-10">
					<input type="text" class="form-control easyui-validatebox" name="name" value="<?php echo $rs['name']?>" data-options="required:true">
				</div>
			</div>
		</div>
		<div class="tab-pane" id="staff-pc" style="padding:10px">
			<span id="menu-pc"></span>
		</div>
		<div class="tab-pane" id="staff-wechat" style="padding:10px">
			<span id="menu-wechat"></span>
		</div>
		<div class="tab-pane" id="staff-app" style="padding:10px">
			<span id="menu-app"></span>
		</div>
		<div class="tab-pane" id="staff-public" style="padding:10px">
			<span id="menu-public"></span>
		</div>
		<div class="tab-pane" id="staff-market" style="padding:10px">
			<span id="menu-market"></span>
		</div>
		<div class="tab-pane" id="staff-worker">
			<div id="<?php echo $id?>_box" style="height:280px;width:536px">
				<table id="<?php echo $id;?>" data-options="{border:true}"></table>
			</div>
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
$('#menu-public').authMenu({type:'public', data: <?php echo $public_auth?>, auth: <?php echo $rs['privileges']?$rs['privileges']:'[]'?>});
$('#menu-pc').authMenu({type:'pc', data: <?php echo $pc_auth?>, auth: <?php echo $rs['privileges']?$rs['privileges']:'[]'?>});
$('#menu-wechat').authMenu({type:'wechat', data: <?php echo $wechat_auth?>, auth: <?php echo $rs['privileges']?$rs['privileges']:'[]'?>});
$('#menu-app').authMenu({type:'app', data: <?php echo $app_auth?>, auth: <?php echo $rs['privileges']?$rs['privileges']:'[]'?>});
$('#menu-market').authMenu({type:'market', data: <?php echo $market_auth?>, auth: <?php echo $rs['privileges']?$rs['privileges']:'[]'?>});
<?php if($rs['id']){?>
setTimeout(function(){
	$("#<?php echo $id;?>").DataSource({url:'manager/getusers?rid=<?php echo $rs['id']?$rs['id']:'-1'?>',fields:[[
		{field:'id',       title:'ID',     width:80},
		{field:'username', title:'员工名称',  width:80},
		{field:'alias',    title:'别名',    width:80}	   
		]], tools:[
		{instant:false},
		
			{text:"新增",iconCls:"icon-add",handler:function(){
				$("#<?php echo $id;?>").DataSource('add',{title:'新增员工',get:'manager/add?rid=<?php echo $rs['id']?>',full:true,dlgId:'editrole'});
			}},
		
		{text:"编辑",iconCls:"icon-edit",handler:function(r){
			$("#<?php echo $id;?>").DataSource('edit',{title:'修改员工',get:'manager/edit?rid=<?php echo $rs['id']?>',full:true,dlgId:'editrole'});
		}},
		
		{text:"删除",iconCls:"icon-remove",handler:function(){
			$('#<?php echo $id?>').DataSource('remove',{get:'manager/delete'});
		}},

		'|',
			{type:'textbox',text:'关键词',name:'keywords',width:150},
			{text:"搜索", iconCls:"icon-search", handler:function(){
				$("#<?php echo $id;?>").DataSource('search');
			}},
		'-'
		],
		footer:true
	});
},1500);
<?php }?>
</script>

