<form class="form-inline">
    <?php foreach ($odds as $k => $v) { ?>
        <div class="oddslist">
            <?php foreach ($v as $kk => $vv) { ?>
                <fieldset>
                    <legend><?php echo array_shift(explode('-', $vv['name'])) ?></legend>
                    <div class="oddslistInfo">
                        <?php
                        if ($vv['sname'] == 'tmb3') {
                            ?>
                            <div class="fl listInfo" style="padding-right: 20px;margin-bottom:15px">
                                <div class="form-group" style="width:90px;">
                                    <input type="hidden" value="<?php echo $vv['id'] ?>" class="setid"/>
                                    <h5 style="text-align: center;height: 20px;"><?php echo $vv['name'] ?></h5>
                                </div>
                                <div class="form-group">
                                    <label>最大賠率:</label>
                                    <input type="text" class="form-control easyui-validatebox rate" value="<?php echo $vv['rate'] ?>" onkeyup="OddsSs.yz(this)">
                                </div>
                                <div class="form-group">
                                    <label>最小賠率:</label>
                                    <input type="text" class="form-control easyui-validatebox rate_min" value="<?php echo $vv['rate_min'] ?>" onkeyup="OddsSs.yz(this)">
                                </div>
                                <div class="form-group">
                                    <label class="fl" style="padding-top:10px">&nbsp;&nbsp;最大退水:</label>
                                    <input type="text" class="form-control rebate fl" style="width: 90px;" value="<?php echo $vv['rebate'] ?>" onkeyup="OddsSs.yz(this)">
                                    <div class="input-group-addon fl" style="width: 35px;height: 30px;padding-top:8px">%</div>
                                </div>
                                <label>
                                    <button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button>
                                </label>
                            </div>
                        <?php } else {
                            foreach ($vv['balls'] as $kkk => $vvv) {
                                ?>
                                <div class="fl listInfo" style="padding-right: 20px;margin-bottom:15px">
                                    <div class="form-group" style="width:90px;">
                                        <input type="hidden" value="<?php echo $vvv['id'] ?>" class="setid"/>
                                        <h5 style="text-align: center;height: 20px;"><?php echo $vvv['name'] ?></h5>
                                    </div>
                                    <div class="form-group">
                                        <label>最大賠率:</label>
                                        <input type="text" class="form-control rate" value="<?php echo $vvv['rate'] ?>" onkeyup="OddsSs.yz(this)">
                                    </div>
                                    <div class="form-group">
                                        <label>最小賠率:</label>
                                        <input type="text" class="form-control rate_min" value="<?php echo $vvv['rate_min'] ?>" onkeyup="OddsSs.yz(this)">
                                    </div>
                                    <div class="form-group">
                                        <label class="fl" style="padding-top:10px">&nbsp;&nbsp;最大退水:</label>
                                        <input type="text" class="form-control rebate fl" style="width: 90px;" value="<?php echo $vvv['rebate'] ?>" onkeyup="OddsSs.yz(this)">
                                        <div class="input-group-addon fl" style="width: 35px;height: 30px;padding-top:8px">%
                                        </div>
                                    </div>
                                    <label>
                                        <button class="btn btn-success btn-icon" onclick="OddsSs.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button>
                                    </label>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </fieldset>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
</form>