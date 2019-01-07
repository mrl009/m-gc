<form method="POST" id="goodsForm">
	<input type="hidden" name="goods_id" value="<?php echo $rs['id']?>" />
	<div style="padding:15px;margin-bottom:40px">
		<h3><img src="../<?php echo array_pop(json_decode($rs['pictures'],true));?>" width="110" align="left" style="padding-right:8px;padding-bottom:15px" /><?php echo $rs['title']?></h3>
		<div style="clear:both"></div>
		<div class="form-group">
			<label>供应商</label>
			<select name="supplier_id" style="width:100%"><option value="0">选择供应商</option><?php foreach($supplier as $v){ echo "<option value='$v[id]' ".($rs['supplier_id']==$v['id']?'selected':'').">$v[name]</option>"; }?></select>
		</div>
		<div class="form-group">
			<label>付款状态</label>
			<select name="pay_status" style="width:100%"><option value="1">已付款</option><option value="2">未付款</option></select>
		</div>
		<div class="form-group">
			<label>价格</label>
			<input type="text" class="form-control easyui-validatebox" name="cost_price" data-options="required:true">
		</div>
		<div class="form-group">
			<label>数量</label>
			<input type="text" class="form-control easyui-validatebox" name="amount" data-options="required:true">
		</div>
	</div>
	<footer style="position:fixed;bottom:0;left:0;width:100%;">
		<button class="easyui-linkbutton c7" style="width:100%;border-radius:0;padding:6px;color:#fff;">确认新增库存</button>
	</footer>
</form>
<script>
//提交
$('#goodsForm').form({
	url: WEB+'warehouse/save',
	success: function(c){
		c=eval('('+c+')');
		if(c.status=='OK'){
			Core.init();
			$.messager.alert('温馨提示','新增库存成功！');
			$.mobile.back();
		}else{
			$.messager.alert('温馨提示','新增库存失败！');
		}
	}
});
</script>