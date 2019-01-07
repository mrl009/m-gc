<!--註單詳情-->
<form class="form-horizontal" role="form" method="post" action="" style="height:500px;width: 100%;">
    <div class="form-group" style="margin: 15px 40px;">
        <div class="form-group">
            <label  class="col-sm-2 control-label">賬號:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $account?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">期號:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $issue?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">彩種:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $g_name?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">玩法:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $g_play?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">註單號:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $order_num?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">投註時間:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $bet_time?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">投註賠率:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $rate?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">投註數量:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $counts?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">單註總額:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $price?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">投註總額:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $price_sum?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">返水比率:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $rebate?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">返水金額:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $rebate_num?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">結算時間:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $open_time?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">中獎金額:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $win_num?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">追號:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $info_status == 4 ? '是' : '否'?>" disabled>
            </div>
            <label  class="col-sm-2 control-label">追號中獎後停止:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $end_time ? $end_time : '-'?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">投註號碼:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo $names?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">開獎號碼:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo $number?>" disabled>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">中獎內容:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value='<?php echo $win_contents?>' disabled>
            </div>
        </div>
    </div>
</form>