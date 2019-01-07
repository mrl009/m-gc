<!--註冊會員優惠設定 -->
<form action="" class="form-horizontal" id="memberDis">
	<div class="form-group">
	    <label class="col-sm-3 control-label">註冊會員贈送優惠:</label>
	    <div class="col-sm-9">
	    	<div class="restrict">
		    	<input type="number" class="form-control"  placeholder="0" name="send">
		    </div>
		    <span class="c_red">&nbsp;&nbsp;*默認未0,為0時加入會員不贈送優惠</span>
	    </div>
  	</div>
	<div class="form-group">
	    <label class="col-sm-3 control-label">優惠打碼量:</label>
	    <div class="col-sm-9">
		    <div class="restrict">
		    	<input type="number" class="form-control"  placeholder="0" name="send">倍
		    </div>
		    <span class="c_red">&nbsp;&nbsp;*默認未0,不做計算</span>
	    </div>
  	</div>
	<div class="form-group">
	    <label  class="col-sm-3 control-label">是否限制IP:</label>
	    <div class="col-sm-9">
	      	<div class="radio">
			   	<label><input type="radio" value="" name="restrictIP"checked>啟用</label>
				<label><input type="radio" value="" name="restrictIP">停用</label>
			</div>
			<span class="c_red">&nbsp;&nbsp;*啟用的時候壹個IP只能註冊壹次,停用不做限制</span>
	    </div>
	</div>
	<div class="form-group">
	    <label  class="col-sm-3 control-label">是否清除下級設定:</label>
	    <div class="col-sm-9">
	      	<div class="radio">
			   	<label><input type="radio" value="" name="clear">是</label>
			   	<label><input type="radio" value="" name="clear" checked>否</label>
			</div>
			<span class="c_red">&nbsp;&nbsp;*默認不清除下級設定</span>
	    </div>
	</div>
</form>
