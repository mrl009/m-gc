<?php $id=uniqid();?>
<form class="form-horizontal validate oform" role="form" method="post" action="orderlist/save" id="orderForm">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
    <input type="hidden" name="order_sn" value="<?php echo $rs['order_sn']?>">
	<div class="form-group">
		<div class="w"><label class="b">订单号：</label><?php echo $rs['order_sn']?></div>
        <div class="w"><?php if($rs['order_status']==2){?>
        付款状态：<font color="#390">已付款</font><input type="hidden" name="order_status" value="<?php echo $rs['order_status']?>" />
        <?php }else{?>
        	<select name="order_status" class="selectboxit" data-first-option="true"  <?php if($rs['order_status']==2 || $rs['order_status']==4) echo 'disabled';?>>
				<option value="1" <?php if($rs['order_status']==1) echo 'selected';?>>等待付款</option>
                <option value="2" <?php if($rs['order_status']==2) echo 'selected ';?>>已付款</option>
                <option value="4" <?php if($rs['order_status']==4) echo 'selected';?>>已取消</option>
			</select>
        <?php }?>
       </div>
	</div>
    <div class="form-group">
    	<div class="w"><label class="b">总价：</label><?php echo $rs['total_price']?></div>
        <div class="w"><label class="b">运费：</label><?php echo $rs['freight']?></div>
		<div class="w"><label class="b">成本价：</label><?php echo $rs['cost_price']?></div>
        <div class="w"><label class="b">利润：</label><?php echo $rs['total_price']-$rs['cost_price']?></div>
        <div class="w"><label class="b">数量：</label><?php echo $rs['amount']?></div>
      
        <div class="w"><label class="b">发货状态：</label><?php 
		if($rs['ship_status']==1){
			echo'<font color="#390">已发货</font>';
		}elseif($rs['ship_status']==3){
			echo '<b color="#390">已收货</b>';
		}else{
			echo '<font color="red">未发货</font>';	
		}
		?>
        </div>
	</div>
    <div class="form-group">
		<div class="w"><label class="b">支付方式：</label>
       <?php if($rs['pay_ment']==1) echo '支付宝';else if($rs['pay_ment']==2) echo '银联支付';else if($rs['pay_ment']==3) echo '微信支付';else if($rs['pay_ment']==4) echo '货到付款';?>
        </div>
        <div class="w">
        	<label class="b">状态：</label><?php if($rs['order_status']==1) echo '等侍付款';else if($rs['order_status']==2) echo '已付款';else if($rs['order_status']==3) echo '挂帐';else if($rs['order_status']==4) echo '<font color="red">已取消</font>';?>
    	</div>
        
        <div class="w"><label class="b">删除状态：</label><?php echo $rs['is_del']==1?'正常':'删除'?></div>
        <div class="w">操作记录： <a href="#log" onclick="readLog()" style="color:#06F">查看</a></div>
       
	</div>
	
    <div >
		<label class="b">明细：</label>
        	<table class="table table-bordered">
            <tr class="active"><th>名称</th><th>数量</th><th>价格</th><th>成本价</th><th>利润</th><th>状态</th></tr>
            <?php foreach($rs['detail'] as $v){?>
              <tr>
              	<td><?php echo $v['goods_title']?>&nbsp;</td>
                <td><?php echo $v['goods_amount']?>&nbsp;</td>
                <td><?php echo $v['goods_price']?>&nbsp;</td>
                <td><?php echo $v['goods_cost_price']?>&nbsp;</td>
                <td><?php echo $v['goods_price']-$v['goods_cost_price']?>&nbsp;</td>
                <td><?php echo $v['goods_status']?>&nbsp;</td>
              </tr>
            <?php } ?>
            </table>
	</div>
     <?php if($rs['order_status']==2 || $rs['pay_ment']==4){?>
     <div class="form-group">
		<label class="control-label">发货信息：</label>

        	<table class="table table-bordered">
              <tr>
              	<td class="active">快递公司</td>
              	<td>
                <?php if($rs['express_ment']=='' || $rs['express_ment']==0){?>
                <select name="express_ment" >
                    <option value="">选择快递公司</option>
                    <option value="1" <?php echo $rs['express_ment']==1?'selected':''?>>顺风快递</option>
                    <option value="2" <?php echo $rs['express_ment']==2?'selected':''?>>EMS</option>
                    <option value="3" <?php echo $rs['express_ment']==3?'selected':''?>>圆通快递</option>
                    <option value="4" <?php echo $rs['express_ment']==4?'selected':''?>>申通快递</option>
                    <option value="5" <?php echo $rs['express_ment']==5?'selected':''?>>天天快递</option>
                    <option value="6" <?php echo $rs['express_ment']==6?'selected':''?>>京东快递</option>
				</select>
                <?php }else{?>
                <?php if($rs['express_ment']==1) echo '顺风快递';else if($rs['express_ment']==2) echo 'EMS';else if($rs['express_ment']==3) echo '圆通快递';else if($rs['express_ment']==4) echo '申通快递';else if($rs['express_ment']==5) echo '天天快递';else if($rs['express_ment']==6) echo '京东快递';?>
                <input type="hidden" value="<?php echo $rs['express_ment'];?>" name="express_ment" readonly="readonly" />
                <?php }?>
                </td>
              </tr>
              <tr>
              	<td  class="active">快递单号</td>
                <td><input type="text" class="form-control" name="express_number" style="width:180px;" value="<?php echo $rs['express_number']?>" <?php echo $rs['express_number']?'readonly':''?>  data-validate="required" data-message-required="快递单号不能为空"></td>
              </tr>
              <tr>
              	<td  class="active">快递时间</td>
                <td><input type="input" class="form-control easyui-datebox" style="width:180px;" name="express_time" <?php echo $rs['express_time']?'readonly':''?> value="<?php echo $rs['express_time']?date('Y-m-d H:i:s',$rs['express_time']):''?>"></td>
              </tr>
            </table>
	</div>
    
    
   <?php }?>
   <div class="form-group" id="log"></div>
   
   <footer style="position:fixed;bottom:0;left:0;width:100%;">
		<button class="easyui-linkbutton c7" style="width:100%;border-radius:0;padding:6px;color:#fff;">保存订单</button>
	</footer>
		
</form>
<script>
$('#tools').show();
//删除
$('#actDel').unbind('click').bind('click',function(){
	$.messager.confirm('温馨提示', '确实要删除该订单吗？', function(r){
		if (r){
			$.post(WEB+'orderlist/del',{id:'<?php echo $rs['id']?>'},function(){
				Core.update('orderList','wap_order');
				$.mobile.back();
				//$.messager.alert('温馨提示','成功删除数据！');
			});
		}
	});
	
});
//推送
$('#actPush').unbind('click').bind('click',function(){
	var id='<?php echo $rs['id']?>';
	if(id!=''){
		$.post(WEB+'push_news/save?type=custom',{news_id:'["'+id+'"]',},function(c){
			c=eval('('+c+')');
			$.get(WEB+'push_news/send?type=custom&ids='+id+'&task='+c.id,function(c){
				$.messager.alert('温馨提示','成功推送资讯！');
			});
		});
	}
});

//提交
$('#orderForm').form({
	url: WEB+'orderlist/save',
	success: function(c){
		c=eval('('+c+')');
		if(c.status=='OK'){
			Core.init();
			$.messager.alert('温馨提示','保存数据成功！');
			$.mobile.back();
		}else{
			$.messager.alert('温馨提示','保存数据失败！');
		}
	}
});

function readLog(){
		$.get(WEB+'orderlist/log',{sn:'<?php echo $rs['order_sn']?>'},function(c){$('#log').html(c)});	
}

</script>
<style>
.w{width:49%; float:left}
.b{font-weight:bold;}
.oform{}
.form-group{border-bottom:1px solid #999;padding:20px;}
</style>