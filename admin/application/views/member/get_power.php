<!--子賬號權限管理-->
<form class="form-horizontal validate" role="form" method="post" action="member/save_power" id="magForm">
	<input type="hidden" value="<?php echo $rs['id']?>" name="admin_id">
	<input type="hidden" value="<?php echo $rs['username']?>" name="username">
	<table class="table table-bordered table-striped" id="management">
		<tr>
			<td colspan="2">
				<div class="manageInf"> 
					<div class="form-group">
					    <label class="col-sm-3 control-label">賬號:</label>
					    <div class="col-sm-9 pt7">
					      	<?php echo $rs['username']?>
					    </div>
				  	</div>
					<div class="form-group">
					    <label  class="col-sm-3 control-label">在線存提款最大金額:</label>
					    <div class="col-sm-9">
					      	<input type="number" class="form-control" value="<?php echo $rs['max_credit_out_in']?>" name="max_credit_out_in">
							<span class="c_red">&nbsp;&nbsp;*設置0表示不限制公司線上入款、出款金額</span>
					    </div>
					</div>
					<div class="form-group">
					    <label  class="col-sm-3 control-label">人工存取款最大金額:</label>
					    <div class="col-sm-9">
					      	<input type="number" class="form-control" value="<?php echo $rs['max_credit_in_people']?>" name="max_credit_in_people">
							<span class="c_red">&nbsp;&nbsp;*設置0表示不限制人工存取款金額</span>
					    </div>
					</div>
				</div>	
			</td>
		</tr>
	</table>
	<div id="menu-public"></div>
</form>
<script>
	$('#menu-public').authMenu({type:'public', data:<?php echo $public?>, auth:<?php echo $rs['privileges']?>,all:'<?php echo $all?>'});
</script>
<style>
	.f_group .r {width: 115px;padding-left: 0;border-right: 1px solid #cecece;}
	.f_group td {padding: 0;}
	.f_group td input {margin-left: 8px;margin-right: 5px;}
	.table {width: 100%;max-width: 100%;margin-bottom: 0;}
	.panel-heading {padding: 2px 8px}
</style>




