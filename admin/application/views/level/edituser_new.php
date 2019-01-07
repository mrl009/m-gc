<!-- 基本资料设定 -->
<form action="level/save_new" class="form-horizontal validate" role="form" 
method="post" id="levelForm">
    <input name="id" type="hidden" value="<?php echo isset($id) ? $id : '';?>">
    <table class="table table-bordered info_set">
        <!-- 公司入款賬戶 -->
        <?php if (!empty($bank)){ ?>
          <tr>
            <td class="first_line" >公司账户:</td>
            <td colspan="18">
                <?php foreach ($bank as $v){?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="<?php echo $v['id']?>" name="bank_id[]" <?php echo $v['check'];?>>
                            <?php echo $v['num'].'('.$v['name'].')';?>
                        </label>
                    </div>
                <?php }?>
            </td>
        </tr>
        <?php }?>
        <!-- 第三方支付數據 start-->
        <?php   
            $count_online = count($online);
            if (!empty($online)) {
               foreach($online as $key => $val) {
        ?>
        <tr>
            <?php if(0 == $key) { ?>
            <td class="first_line" rowspan="<?php echo $count_online;?>">
            第三方支付:</td> 
            <?php }?>
            <td class="tdr"><?php echo $val['name']. 'ID:'. $val['id'];?></td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[1,2,8,12,16,22,23,24,28,33,34,40])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="online_id[]" <?php echo $v['check'];?>>
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>  
            </td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[4,5,36,37,41])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="online_id[]" <?php echo $v['check'];?>>
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>
            </td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[7,25,26,27])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="online_id[]" <?php echo $v['check'];?>>
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>
            </td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[9,10,13,17,18,19,21,38,39])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="online_id[]" <?php echo $v['check'];?>>
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>
            </td>
        </tr>
        <?php }}?>
        <!-- 第三方支付數據 end -->

        <!-- 代付直通車數據 start-->
        <?php   
            $count_fast = count($fast);
            if (!empty($fast)) {
               foreach($fast as $key => $val) {
        ?>
        <tr>
            <?php if(0 == $key) { ?>
            <td class="first_line" rowspan="<?php echo $count_fast;?>">代付直通車:</td> 
            <?php }?>
            <td class="tdr"><?php echo $val['name']. 'ID:'. $val['id'];?></td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[1,2,8,12,16,22,23,24,28,33,34,40])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="fast_id[]" checked onclick="return false;">
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>  
            </td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[4,5,36,37,41])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="fast_id[]" checked onclick="return false;">
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>
            </td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[7,25,26,27])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="fast_id[]" checked onclick="return false;">
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>
            </td>
            <td>
                <?php
                    foreach($val['code'] as $k => $v) {
                        if (in_array($k,[9,10,13,17,18,19,21,38,39])){
                ?>
                <div class="tdw">
                    <label><input type="checkbox" value="<?php echo $val['id'].'-'.$v['code'];?>" name="fast_id[]" checked onclick="return false;">
                        <?php echo $v['name'];?>
                    </label>
                </div>
                <?php }}?>
            </td>
        </tr>
        <?php }}?>
        <!-- 代付直通車 end -->
        <tr>
            <td class="first_line" >支付配置：</td>
            <td colspan="18">
                <select class="form-control paySet" name="pay_id">
                    <?php foreach ($pay_move as $v){?>
                        <option value="<?php echo $v['id'];?>" <?php echo $v['is_check'] == 1 ? 'selected' : '';?>><?php echo $v['pay_name'];?></option>
                    <?php }?>
                </select>
                <span class="c_red">&nbsp;&nbsp;*必选一个支付设定</span>
            </td>
        </tr>
        <tr>
            <td class="first_line" >层级ID：</td>
            <td colspan="18">
                <label>
                    <span style="width:130px;height:auto;display: inline-block;"><?php echo $id;?></span>
                    <span class="c_red">&nbsp;&nbsp;*固定编号不能修改，自增level</span>
                </label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >层级名称：</td>
            <td colspan="18">
                <label>
                    <input style="width: 130px;" type="text" name="level_name" value="<?php echo $level_name;?>"
                           validType="filterSpecial" invalidMessage="请勿使用特殊字符" class="easyui-validatebox" data-options="required:true">
                    <span class="c_red">&nbsp;&nbsp;*必填请勿使用特殊字符</span>
                </label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >存款次数：</td>
            <td colspan="18">
                <label><input type="number" name="total_num" value="<?php echo $total_num;?>">&nbsp;&nbsp;<span class="c_red">*该层级单个会员总存款次数(达到存款次数的会员才能加入),0无限制</span></label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >存款总额：</td>
            <td colspan="18">
                <label><input type="number" name="total_deposit" value="<?php echo $total_deposit;?>">&nbsp;&nbsp;<span class="c_red">*该层级单个会员总存款金额(达到存款总额的会员才能加入),0无限制</span></label>
            </td>
        </tr>
        <tr>
            <td class="first_line" >备注：</td>
            <td colspan="18">
                <label><input type="text" name="remark" value="<?php echo $remark;?>"></label>
            </td>
        </tr>
    </table>
</form>
<style>
/*    .tdw{
        width: 70px;
    }*/
    .first_line{
        width: 80px!important;
    }
    .modal-dialog{
        width: 95%!important;
    }
</style>
