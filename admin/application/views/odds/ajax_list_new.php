<form  class="form-horizontal validate">
    <?php foreach($odds as $k=>$v){?>
        <div class="oddslist">
            <h4><?php echo $k?></h4>
            <?php foreach($v as $kk=>$vv){
                $a=explode('-',$kk);
                if($a[1]=='lh'){
                    $this->load->view('odds/ajax_lh',array('vv'=>$vv,'kk'=>$a[0]));
                }else{
                    ?>
                    <fieldset>
                        <legend><?php echo $kk?></legend>
                        <div class="oddslistInfo">
                            <?php foreach($vv as $kkk=>$vvv){
                                if($vvv['sname']=='hz'){
                                    foreach($vvv['balls'] as $kkkk=>$vvvv){
                                        ?>
                                        <div class="listInfo" style="margin-bottom:15px">
                                            <div class="form-group" style="padding: 0;">
                                                <input type="hidden" value="<?php echo $vvvv['id']?>" class="setid" />
                                                <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvvv['name']?></label>
                                                <label class="col-sm-1 control-label">最大賠率：</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control rate"  value="<?php echo $vvvv['rate']?>">
                                                </div>
                                                <label class="col-sm-1 control-label">最小賠率：</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control  rate_min" value="<?php echo $vvvv['rate_min']?>" maxlength="8" onkeyup="Oddss.yz(this)">
                                                </div>
                                                <label class="col-sm-1 control-label">最大退水：</label>
                                                <div class="col-sm-2 input-group" style="float: left !important;">
                                                    <input type="text" class="form-control rebate" value="<?php echo $vvvv['rebate']?>" onkeyup="Oddss.yz(this)" maxlength="6">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                                <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="Oddss.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    <?php }}else{?>
                                    <div class="listInfo" style="margin-bottom:15px">
                                        <div class="form-group">
                                            <input type="hidden" value="<?php echo $vvv['id']?>" class="setid" />
                                            <label class="col-sm-1 control-label" style="font-size: 14px"><?php echo $vvv['name']?></label>
                                            <label class="col-sm-1 control-label">最大賠率：</label>
                                            <div class="col-sm-3">
                                                <?php
                                                $arr=explode(',',$vvv['rate']);
                                                if(count($arr)>1){
                                                    foreach($arr as $av){
                                                        echo '<input type="text" class="fl form-control easyui-validatebox ratelist"  onkeyup="Oddss.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px" maxlength="8">';
                                                    }
                                                }else{
                                                    echo '<input type="text" class="form-control easyui-validatebox rate"  onkeyup="Oddss.yz(this)" value="'.$vvv['rate'].'"  maxlength="8">';
                                                }
                                                ?>

                                            </div>
                                            <label class="col-sm-1 control-label">最小賠率：</label>
                                            <div class="col-sm-3">
                                                <?php
                                                $arr=explode(',',$vvv['rate_min']);
                                                if(count($arr)>1){
                                                    foreach($arr as $av){
                                                        echo '<input type="text" class="fl form-control easyui-validatebox rate_minlist"  onkeyup="Oddss.yz(this)" value="'.$av.'" style="width:60px;padding-left:1px"  maxlength="8">';
                                                    }
                                                }else{
                                                    echo '<input type="text" class="form-control easyui-validatebox rate_min"  onkeyup="Oddss.yz(this)" value="'.$vvv['rate_min'].'"  maxlength="8">';
                                                }
                                                ?>
                                            </div>
                                            <label class="col-sm-1 control-label">最大退水：</label>
                                            <div class="col-sm-1 input-group" style="float: left !important;">
                                                <input type="text" class="form-control rebate"  onkeyup="Oddss.yz(this)" value="<?php echo $vvv['rebate']?>" maxlength="6">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                            <label class="col-sm-1"><button class="btn btn-success btn-icon" onclick="Oddss.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                <?php }}?>
                        </div>
                    </fieldset>
                <?php }}?>
        </div>
        <div class="clearfix"></div>
    <?php }?>
</form>