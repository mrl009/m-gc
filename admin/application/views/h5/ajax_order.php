<ul class="m-list" >
<?php foreach($rs as $v){?>
<li>
	<a href="javascript:void(0)"  onclick="Core.open('<?php echo WEB?>cellphone/edit_order?id=<?php echo $v['id']?>','编辑内容')">
		<img class="list-thumb img-rounded" src="http://img2.126.net/xoimages/mbuy/20150501/gy/mqj/300x250.jpg"/><?php echo $v['order_sn']?>
	</a>
	<div class="m-right" style="padding-right:20px;padding-top:15px"><?php if($v['order_status']==1) echo '等侍付款';else if($v['order_status']==2) echo '<font color="green">已付款</font>';else if($v['order_status']==3) echo '挂帐';else if($v['order_status']==4) echo '<font color="red">已取消</font>';?></div>
</li>
<?php }?>
</ul>
<div class="fenye" style="text-align:center;"><?php echo $pagination;?></div>