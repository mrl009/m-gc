<form action="sxset/save_rebate" class="form-horizontal validate" role="form" method="post" id="levelForm">
    <input name="id" type="hidden" value="<?php echo $rs['id']?>">
    <table class="table table-bordered rebate_set">
        <tr>
            <td class="first_line" >层级选择</td>
            <td>
                <select class="form-control paySet" name="level_id" style="width: 150px">
                <?php foreach($level as $v){?>
                <option value="<?php echo $v['id']?>" 
                    <?php echo $rs['level_id']==$v['id']? 'selected':''?> >
                    <?php echo $v['level_name']?>
                </option>
                <?php }?>
                    
                </select>
            </td>
        </tr>
        <tr>
            <td>有效總投注</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="yx_bet" value="<?php echo $rs['yx_bet'];?>">
                <span class="col-sm-1 input-group-addon bfh">元</span>
            </td>
        </tr>
        <tr>
            <td>AG視訊優惠</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="ag" value="<?php echo $rs['ag'];?>">
                <span class="col-sm-1 input-group-addon bfh">%</span>
            </td>
        </tr>
        <tr>
            <td>DG視訊優惠</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="dg" value="<?php echo $rs['dg'];?>">
                <span class="col-sm-1 input-group-addon bfh">%</span>
            </td>
        </tr>
        <tr>
            <td>MG視訊優惠</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="mg" value="<?php echo $rs['mg'];?>">
                <span class="col-sm-1 input-group-addon bfh">%</span>
            </td>
        </tr>
        <tr>
            <td>LEBO視訊優惠</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="lebo" value="<?php echo $rs['lebo'];?>">
                <span class="col-sm-1 input-group-addon bfh">%</span>
            </td>
        </tr>
        <tr>
            <td>PT電子優惠</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="pt" value="<?php echo $rs['pt'];?>">
                <span class="col-sm-1 input-group-addon bfh">%</span>
            </td>
        </tr>
        <tr>
            <td>开元棋牌</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="10" data-options="required:true" name="ky" value="<?php echo $rs['ky'];?>">
                <span class="col-sm-1 input-group-addon bfh">%</span>
            </td>
        </tr>
        <tr>
            <td>優惠上限</td>
            <td>
                <input type="text" class="form-control easyui-validatebox"data-options="required:true" name="limit_money" value="<?php echo $rs['limit_money'];?>">
                <span class="col-sm-1 input-group-addon bfh">元</span>
            </td>
        </tr>
        
    </table>
    <style type="text/css">
        .rebate_set .form-control{
            width: 80%;float: left;
        }
        .rebate_set .bfh{float: left;width: 10%;height: 30px}
    </style>
</form>
