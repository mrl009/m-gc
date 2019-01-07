	<?php foreach($vv as $kkk=>$vvv){
		foreach($vvv['balls'] as $kkkk=>$vvvv){		
	?>
	<fieldset>
    		<legend><?php echo $kk.'--'.$vvv['name']?></legend>
			<?php foreach($vvvv['child'] as $a=>$b){?>
			<div class="listInfo" style="padding-right: 20px;margin-bottom:15px">
			<div class="form-group">
				<input type="hidden" value="<?php echo $b['id']?>" class="setid" />
				<label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $b['name']?></label>
				<label class="col-sm-1 control-label">最大賠率：</label>
				<div class="col-sm-2">
					<input type="text" class="form-control rate" value="<?php echo $b['rate']?>" onkeyup="Oddss.yz(this)" maxlength="8">
				</div>
				<label class="col-sm-1 control-label">最小賠率：</label>
				<div class="col-sm-2">
					<input type="text" class="form-control  rate_min" value="<?php echo $b['rate_min']?>" onkeyup="Oddss.yz(this)" maxlength="8">
				</div>
				<label class="col-sm-1 control-label">最大退水：</label>
				<div class="col-sm-2 input-group" style="float: left !important;">
					<input type="text" class="form-control rebate" value="<?php echo $b['rebate']?>" onkeyup="Oddss.yz(this)" maxlength="6">
				    <div class="input-group-addon">%</div>
				</div>
				<label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="Oddss.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
			</div>
			</div>
			<div class="clearfix"></div>
			<?php }?>
		</fieldset>
		<?php }}?>