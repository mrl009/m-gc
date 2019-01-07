<ul class="m-list" >
<?php foreach($rs as $v){?>
<li>
	<a href="javascript:void(0)"  onclick="Core.open('<?php echo WEB?>cellphone/edit_news?id=<?php echo $v['id']?>','编辑内容')">
		<?php if($v['thumb']){?><div style="display:inline-block;width:50px;overflow:hidden"><img class="list-thumb img-rounded" src="../<?php echo $v['thumb']?>"/></div><?php } echo $v['title']?>
	</a>
</li>
<?php }?>
</ul>
<div class="fenye" style="text-align:center;"><?php echo $pagination;?></div>