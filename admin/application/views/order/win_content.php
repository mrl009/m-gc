<form class="form-horizontal" role="form" method="post" action="">
    <div class="form-group" style="margin: 15px 40px;">
        <?php foreach ($data as $k => $v) {?>
            <div class="form-group">
                <label  class="col-sm-2 control-label"><?php echo $k?>:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?php echo is_array($v) ? implode(',', $v) : $v?>" disabled>
                </div>
            </div>
        <?php }?>
    </div>
</form>
