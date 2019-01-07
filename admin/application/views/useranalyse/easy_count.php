<!--會員統計-->
<div style="margin-top: 15px;height: 300px;width:100%;">
    <div class="form-group">
        <label  class="col-sm-2 control-label">賬戶余額:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $balance?>" disabled>
        </div>
        <label  class="col-sm-2 control-label">優惠總額:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $discount?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">存款總額:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $in_t_totl?>" disabled>
        </div>
        <label  class="col-sm-2 control-label">提款總額:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $out_t_totl?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">存款次數:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $in_t_num?>" disabled>
        </div>
        <label  class="col-sm-2 control-label">提款次數:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $out_t_num?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">最大存款:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $max_in?>" disabled>
        </div>
        <label  class="col-sm-2 control-label">最大提款:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $max_out?>" disabled>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">登陸次數:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $login_num?>" disabled>
        </div>
        <label  class="col-sm-2 control-label">盈利總額:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $profit?>" disabled>
        </div>
    </div>

        <div class="form-group">
        <label  class="col-sm-2 control-label">會員頭銜:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" value="<?php echo $rs['title']?>" disabled>
        </div>
        <label  class="col-sm-2 control-label">會員等級:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" 
            value="<?php echo $rs['dengji'] ? 'VIP'.$rs['dengji']:''?>" disabled>
        </div>
    </div>
</div>