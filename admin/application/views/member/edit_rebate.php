<!--子賬號權限管理-->
<form class="form-horizontal validate" role="form" method="post" action="member/save_rebate" id="magForm">
	<input type="hidden" value="<?=$uid?>" name="uid">
	<input type="hidden" value="<?=$username?>" name="username">
    <?php $gnames = ['k3'=>'快3','ssc'=>'时时彩','11x5'=>'11选5','fc3d'=>'福彩3D','pl3'=>'排列3','pk10'=>'PK10','lhc'=>'六合彩','pcdd'=>'PC蛋蛋'];?>
	<table class="table table-bordered table-striped" id="management">
		<tr>
			<td colspan="2">
				<div class="manageInf">
                    <div class="form-group">
                        <label class="col-sm-3 control-label c_red">注意:</label>
                        <div class="col-sm-9 pt7 c_red ">
                            任意修改用户反点，将会造成计算反水错误，请谨慎操作！
                        </div>
                    </div>
					<div class="form-group">
					    <label class="col-sm-3 control-label">賬號:</label>
					    <div class="col-sm-9 pt7">
					      	<?=$username?>
					    </div>
				  	</div>
                    <?php foreach ($rebate as $k => $v) {?>
					<div class="form-group">
					    <label  class="col-sm-3 control-label"><?=$gnames[$k]?>:</label>
					    <div class="col-sm-9">
					      	<input type="number" class="form-control" class="easyui-combobox" max="<?=$max[$k]?>" min="<?=$min[$k]?>" value="<?=$v?>" name="<?=$k?>" step="0.1" onkeypress="javascript:return false;">
							<span class="c_red">&nbsp;&nbsp;*自身返点<?=$v?>，可修改范围 <?=$min[$k]?> - <?=$max[$k]?></span>
					    </div>
					</div>
                    <?php } ?>
				</div>	
			</td>
		</tr>
	</table>
</form>
<script>

</script>
<style>
	.f_group .r {width: 115px;padding-left: 0;border-right: 1px solid #cecece;}
	.f_group td {padding: 0;}
	.f_group td input {margin-left: 8px;margin-right: 5px;}
	.table {width: 100%;max-width: 100%;margin-bottom: 0;}
	.panel-heading {padding: 2px 8px}
</style>




