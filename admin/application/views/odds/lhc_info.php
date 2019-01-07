<div id="revise_odds">
	<form name="myFORM" action="odds/save_lhc_odds" method="post" class="form-horizontal validate">
		<input type="hidden" value="<?php echo $id?>" name="tid" />
		<input type="hidden" class="form-control" value="0" name="rate_min">
		<table class="table table-bordered">
			<tr>
				<td align="center">賠率</td>
				<td><input type="number" class="form-control" value="<?php echo $rate?>" name="rate"></td>
			</tr>
			<tr>
				<td align="center">最大退水</td>
				<td>
					<div class="input-group">
				      <input type="number" class="form-control" value="<?php echo $rebate?>" name="rebate">
				      <div class="input-group-addon">%</div>
				    </div>
				</td>
			</tr>
		</table>
	</form>
</div>
<style>
	div#revise_odds{
	width:70%;
	margin: 0 auto;
}
#revise_odds .table{
	margin-bottom:0;
}
</style>