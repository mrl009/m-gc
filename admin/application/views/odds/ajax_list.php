<?php foreach($odds as $k=>$v){?>
	<div class="panel panel-primary" style="margin:10px;">
		 <div class="panel-heading">
		  	<ul class="playname oneplaylist" id="<?php echo $v['id']?>">
				<li>玩法:<span><?php echo $v['name']?></span></li>
				<li>最大賠率:<span><?php echo $v['rate']?></span></li>
				<li>最小賠率:<span><?php echo $v['rate_min']?></span></li>
				<li>最大退水:<span><?php echo $v['rebate']?></span></li>
				<li class="fr"><button type="button" class="btn btn-warning btn-sm">編輯</button></li>
			</ul>
			<div class="clearfix"></div>
		</div>
  		<div class="panel-body">
			<?php if(empty($v['balls'])){?>
				<div class="content_title"><ul class="ball_title"><li>號碼</li><li>最大賠率</li><li>最小賠率</li><li>最大退水</li></ul></div>
				<div class="content_body">
					<ul class="ball">
				  		<li><?php echo empty($v['name'])?'手輸':$v['name']?></li>
				  		<li class="ball_color"><?php echo $v['rate']?></li>
				  		<li class="ball_color"><?php echo $v['rate_min']?></li>
				  		<li class="ball_color"><?php echo $v['rebate']?></li>
				  </ul>
				</div>
			<?php }else if(empty($v['balls'][0]['child'])){?>
				<?php for($i=0;$i<=4;$i++){?>
					 <ul class="ball_title"><li>號碼</li><li>最大賠率</li><li>最小賠率</li><li>最大退水</li></ul>
				<?php }?>
				<div class="content_body">
				<?php foreach($v['balls'] as $s){?>
						<ul class="ball <?php echo $v['sname']=='hz'?'hzball':''?>" id="<?php echo $s['id']?>">
					  		<li><span><?php echo $s['name']?></span></li>
					  		<li class="ball_color"><span><?php echo $v['sname']=='hz'?$s['rate']:$v['rate']?></span></li>
					  		<li class="ball_color"><span><?php echo $v['sname']=='hz'?$s['rate_min']:$v['rate_min']?></span></li>
					  		<li class="ball_color"><span><?php echo $v['sname']=='hz'?$s['rebate']:$v['rebate']?></span></li>
					  </ul>
				<?php }?>
				</div>
			<?php }else{?>
				<?php foreach($v['balls'] as $s){?>
					<div class="content_head text-center"><b><?php echo $s['name']?></b></div>
					<div class="content_title">
						<?php for($i=0;$i<=4;$i++){?>
					  	<ul class="ball_title"><li>號碼</li><li>最大賠率</li><li>最小賠率</li><li>最大退水</li></ul>
					  	<?php }?>
				  	</div>
					<div class="content_body">
					<?php foreach($s['child'] as $t){?>
						<ul class="ball" id="<?php echo $t['id']?>">
					  		<li><span><b><?php echo $t['name']?></b></span></li>
					  		<li class="ball_color"><span><?php echo $v['rate']?></span></li>
					  		<li class="ball_color"><span><?php echo $v['rate_min']?></span></li>
					  		<li class="ball_color"><span><?php echo $v['rebate']?></span></li>
					  	</ul>
					<?php }?>
					</div>
				<?php }?>
			<?php }?>
		</div>
		 </div>
		<?php }?>
<style>
	.panel-heading{height: 45px;}
	.playname{padding-top:3px;}
	.playname li{float: left; width: 200px; font-size: 14px;}
</style>