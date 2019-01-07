<form  class="form-horizontal validate">
    <?php foreach($odds as $k=>$v){?>
        <div class="oddslist">
            <h4><?php echo $k?></h4>
            <?php foreach($v as $kk=>$vv){
                $a=explode('-',$kk);
                $flag = 0;
                $arr = ['s_ssc', 's_pk10', 's_kl10', 's_k3', 's_yb', 's_11x5'];
                if (!in_array($tmp, $arr)) {
                    $flag = 0;
                } else if ($tmp == 's_11x5' && in_array($a[1], array('rx', 'zx', 'zhx'))) {
                    $flag = 1;
                } else if ($tmp == 's_kl10' && $a[1] == 'lma') {
                    $flag = 1;
                } else {
                    $flag = 2;
                }
            ?>
                <fieldset>
                        <legend><?php echo $kk?></legend>
                        <div class="oddslistInfo">
                            <?php foreach($vv as $kkk=>$vvv){
                                if($vvv['sname']=='hz'){
                                    
                                        ?>
                                        <?php
                                        if ($flag == 0){
                                            foreach($vvv['balls'] as $kkkk=>$vvvv){
                                            ?>
                                            <div class="listInfo" style="margin-bottom:15px">
                                                <div class="form-group" style="padding: 0;">
                                                    <input type="hidden" value="<?php echo $vvvv['id']?>" class="setid" />
                                                    <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvvv['name']?></label>
                                                    <label class="col-sm-1 control-label">1最大賠率：</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control rate"  value="<?php echo $vvvv['rate']?>">
                                                    </div>
                                                    <label class="col-sm-1 control-label">最小賠率：</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control  rate_min" value="<?php echo $vvvv['rate_min']?>" maxlength="8" onkeyup="OddsSs.yz(this)">
                                                    </div>
                                                    <label class="col-sm-1 control-label">最大退水：</label>
                                                    <div class="col-sm-2 input-group" style="float: left !important;">
                                                        <input type="text" class="form-control rebate" value="<?php echo $vvvv['rebate']?>" onkeyup="OddsSs.yz(this)" maxlength="6">
                                                        <div class="input-group-addon">%</div>
                                                    </div>
                                                    <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                                </div>
                                            </div>
                                            <?php }?>
                                            <div class="clearfix"></div>
                                        <?php }else{?>
                                            <?php foreach($vvv['balls'] as $kkkk=>$vvvv){?>
                                                <div class="listInfo" style="margin-bottom:15px">
                                                    <div class="form-group">
                                                        <input type="hidden" value="<?php echo $vvvv['id']?>" class="setid" />
                                                        <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvvv['name']?></label>
                                                        <label class="col-sm-1 control-label">2最大賠率：</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control rate"  value="<?php echo $vvvv['rate']?>">
                                                        </div>
                                                        <label class="col-sm-1 control-label">最小賠率：</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control  rate_min" value="<?php echo $vvvv['rate_min']?>" maxlength="8" onkeyup="OddsSs.yz(this)">
                                                        </div>
                                                        <label class="col-sm-1 control-label">最大退水：</label>
                                                        <div class="col-sm-2 input-group" style="float: left !important;">
                                                            <input type="text" class="form-control rebate" value="<?php echo $vvvv['rebate']?>" onkeyup="OddsSs.yz(this)" maxlength="6">
                                                            <div class="input-group-addon">%</div>
                                                        </div>
                                                        <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <div class="clearfix"></div>
                                        <?php }?>
                                    <?php }else{?>
                                    <?php
                                    if ($flag == 0){?>
                                        <div class="listInfo" style="margin-bottom:15px">
                                            <div class="form-group">
                                                <input type="hidden" value="<?php echo $vvv['id']?>" class="setid" />
                                                <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvv['name']?></label>
                                                <label class="col-sm-1 control-label">3最大賠率：</label>
                                                <div class="col-sm-3">
                                                    <?php
                                                    $arr=explode(',',$vvv['rate']);
                                                    if(count($arr)>1){
                                                        foreach($arr as $av){
                                                            echo '<input type="text" class="fl form-control easyui-validatebox ratelist"  onkeyup="OddsSs.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px" maxlength="8">';
                                                        }
                                                    }else{
                                                        echo '<input type="text" class="form-control easyui-validatebox rate"  onkeyup="OddsSs.yz(this)" value="'.$vvv['rate'].'"  maxlength="8">';
                                                    }
                                                    ?>

                                                </div>
                                                <label class="col-sm-1 control-label">最小賠率：</label>
                                                <div class="col-sm-3">
                                                    <?php
                                                    $arr=explode(',',$vvv['rate_min']);
                                                    if(count($arr)>1){
                                                        foreach($arr as $av){
                                                            echo '<input type="text" class="fl form-control easyui-validatebox rate_minlist"  onkeyup="OddsSs.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px"  maxlength="8">';
                                                        }
                                                    }else{
                                                        echo '<input type="text" class="form-control easyui-validatebox rate_min"  onkeyup="OddsSs.yz(this)" value="'.$vvv['rate_min'].'"  maxlength="8">';
                                                    }
                                                    ?>
                                                </div>
                                                <label class="col-sm-1 control-label">最大退水：</label>
                                                <div class="col-sm-1 input-group" style="float: left !important;">
                                                    <input type="text" class="form-control rebate"  onkeyup="OddsSs.yz(this)" value="<?php echo $vvv['rebate']?>" maxlength="6">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                                <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    <?php }else if ($flag == 1){?>
                                        <div class="listInfo" style="margin-bottom:15px">
                                            <div class="form-group">
                                                <input type="hidden" value="<?php echo $vvv['id']?>" class="setid" />
                                                <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvv['name']?></label>
                                                <label class="col-sm-1 control-label">4最大賠率：</label>
                                                <div class="col-sm-3">
                                                    <?php
                                                    $arr=explode(',',$vvv['rate']);
                                                    if(count($arr)>1){
                                                        foreach($arr as $av){
                                                            echo '<input type="text" class="fl form-control easyui-validatebox ratelist"  onkeyup="OddsSs.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px" maxlength="8">';
                                                        }
                                                    }else{
                                                        echo '<input type="text" class="form-control easyui-validatebox rate"  onkeyup="OddsSs.yz(this)" value="'.$vvv['rate'].'"  maxlength="8">';
                                                    }
                                                    ?>

                                                </div>
                                                <label class="col-sm-1 control-label">最小賠率：</label>
                                                <div class="col-sm-3">
                                                    <?php
                                                    $arr=explode(',',$vvv['rate_min']);
                                                    if(count($arr)>1){
                                                        foreach($arr as $av){
                                                            echo '<input type="text" class="fl form-control easyui-validatebox rate_minlist"  onkeyup="OddsSs.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px"  maxlength="8">';
                                                        }
                                                    }else{
                                                        echo '<input type="text" class="form-control easyui-validatebox rate_min"  onkeyup="OddsSs.yz(this)" value="'.$vvv['rate_min'].'"  maxlength="8">';
                                                    }
                                                    ?>
                                                </div>
                                                <label class="col-sm-1 control-label">最大退水：</label>
                                                <div class="col-sm-1 input-group" style="float: left !important;">
                                                    <input type="text" class="form-control rebate"  onkeyup="OddsSs.yz(this)" value="<?php echo $vvv['rebate']?>" maxlength="6">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                                <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    <?php }else{?>
                                        <?php foreach($vvv['balls'] as $kkkk=>$vvvv){?>
                                            <div class="listInfo" style="margin-bottom:15px">
                                                <div class="form-group">
                                                    <input type="hidden" value="<?php echo $vvvv['id']?>" class="setid" />
                                                    <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvvv['name']?></label>
                                                    <label class="col-sm-1 control-label">最大賠率：</label>
                                                    <div class="col-sm-3">
                                                        <?php
                                                        $arr=explode(',',$vvvv['rate']);
                                                        if(count($arr)>1){
                                                            foreach($arr as $av){
                                                                echo '<input type="text" class="fl form-control easyui-validatebox ratelist"  onkeyup="OddsSs.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px" maxlength="8">';
                                                            }
                                                        }else{
                                                            echo '<input type="text" class="form-control easyui-validatebox rate"  onkeyup="OddsSs.yz(this)" value="'.$vvvv['rate'].'"  maxlength="8">';
                                                        }
                                                        ?>

                                                    </div>
                                                    <label class="col-sm-1 control-label">最小賠率：</label>
                                                    <div class="col-sm-3">
                                                        <?php
                                                        $arr=explode(',',$vvvv['rate_min']);
                                                        if(count($arr)>1){
                                                            foreach($arr as $av){
                                                                echo '<input type="text" class="fl form-control easyui-validatebox rate_minlist"  onkeyup="OddsSs.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px"  maxlength="8">';
                                                            }
                                                        }else{
                                                            echo '<input type="text" class="form-control easyui-validatebox rate_min"  onkeyup="OddsSs.yz(this)" value="'.$vvvv['rate_min'].'"  maxlength="8">';
                                                        }
                                                        ?>
                                                    </div>
                                                    <label class="col-sm-1 control-label">最大退水：</label>
                                                    <div class="col-sm-1 input-group" style="float: left !important;">
                                                        <input type="text" class="form-control rebate"  onkeyup="OddsSs.yz(this)" value="<?php echo $vvvv['rebate']?>" maxlength="6">
                                                    </div>
                                                    <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <div class="clearfix"></div>
                                    <?php }?>
                                <?php }}?>
                        </div>
                    </fieldset>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    <?php }?>
</form>