<form class="form">
    <table class="table table-bordered">
        <tr class="active">
            <td colspan="13" style="text-align: center;">公司入款</td>
        </tr>
        <tr class="mult">
            <td>訂單號</td>
            <td>層級</td>
            <td>會員帳號</td>
            <td>所屬代理</td>
            <td>存款人與時間</td>
            <td>存入金額與優惠</td>
            <td>存入總額與備註</td>
            <td>存入銀行帳戶</td>
            <td>狀態</td>
            <td>首存</td>
            <td>操縱者</td>
            <td>來源</td>
            <td>時間</td>
        </tr>
        <?php if (!empty($deposit_list)) { ?>
            <?php foreach ($deposit_list as $v) { ?>
                <tr>
                    <td><?php echo $v['order_num'] ?></td>
                    <td><?php echo $v['leve_name'] ?></td>
                    <td><?php echo $v['loginname'] ?></td>
                    <td><?php echo $v['agent_name'] ?></td>
                    <td>
                        <?php
                        if ($v['loginname']) {
                            echo '存款人:'.$v['user_name'].'<br>時間:'.$v['addtime'];
                        } else {
                            echo '筆數:' . $v['in_company_num'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($v['loginname']) {
                            echo '提交金額'.$v['price'].'<br>存款/優惠:'.$v['price'].'/'.$v['discount_price'].'<br>銀行:'.$v['bank_name'].'<br>方式:'.$v['bank_style'];
                        } else {
                            echo '提交金額:'.$v['price'].'<br/>存款/優惠:'.$v['discount_price'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($v['loginname']) {
                            if ($v['confirm'] == 0) {
                                echo '確認碼:-'.'<br>存入總額:'.$v['total_price'].'<br>備註:'.$v['remark'];
                            } else {
                                echo '確認碼:'.$v['confirm'].'<br>存入總額:'.$v['total_price'].'<br>備註:'.$v['remark'];
                            }
                        } else {
                            echo '存入總金額:'.$v['total_price'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo '卡主:'.$v['card_name'].'<br>銀行:'.$v['bank_name'].'<br>'.'卡號:'.$v['card_num']; ?>
                    </td>
                    <td>
                        <?php
                        if ($v['status'] == 2) {
                            echo '<span class="label label-success">已確認</span>';
                        } elseif ($v['status'] == 3) {
                            echo '<span class="label label-danger">已取消</span>';
                        } else {
                            echo '<span class="label label-info">未處理</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $v['is_first'] == 1 ? '<span style="color:red">是</span>' : '否'?>
                    </td>
                    <td><?php echo $v['admin_name'] ?></td>
                    <td>
                        <?php
                        if ($v['from_way'] == 1) {
                            echo '<i class="fa fa-apple fa-lg"></i>';
                        } elseif ($v['from_way'] == 2) {
                            echo '<i class="fa fa-android fa-lg"></i>';
                        } elseif ($v['from_way'] == 3) {
                            echo '<i class="fa fa-desktop fa-lg"></i>';
                        } elseif ($v['from_way'] == 4) {
                            echo '<i class="fa fa-html5 fa-lg"></i>';
                        } else {
                            echo '<i class="fa fa-info-circle fa-lg"></i>';
                        }
                        ?>
                    </td>
                    <td><?php echo $v['update_time'] ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        <?php if (empty($deposit_list)) { ?>
            <tr>
                <td colspan="13" style="text-align: center;"><span class="c_red">沒有數據@！</span></td>
            </tr>
        <?php } ?>
    </table>
</form>
<form class="form">
    <table class="table table-bordered">
        <tr class="active">
            <td colspan="12" style="text-align: center;">線上入款</td>
        </tr>
        <tr class="mult">
            <td>訂單號</td>
            <td>層級</td>
            <td>會員帳號</td>
            <td>所屬代理</td>
            <td>存款金額</td>
            <td>存入總額</td>
            <td>狀態</td>
            <td>存入銀行帳戶</td>
            <td>首存</td>
            <td>操作者</td>
            <td>來源</td>
            <td>時間</td>
        </tr>
        <?php if (!empty($income_list)) { ?>
            <?php foreach ($income_list as $v) { ?>
                <tr>
                    <td>
                        <?php
                            if ($v['status'] == 4) {
                                echo '<span class="label label-danger">'.$v['order_num'].'</span>';
                            } else {
                                echo $v['order_num'];
                            }
                        ?>
                    </td>
                    <td><?php echo $v['leve_name'] ?></td>
                    <td>
                        <?php
                            if ($v['user_name']) {
                                echo $v['user_name'];
                            } else {
                                echo '筆數:'.$v['in_online_num'];
                            }
                        ?>
                    </td>
                    <td><?php echo $v['agent_name'] ?></td>
                    <td>
                        <?php echo '提交金額:'.$v['price'].'<br/>存款/優惠:'.$v['price'].'/'.$v['discount_price']; ?>
                    </td>
                    <td>
                        <?php echo '存入總額:'.$v['total_price']; ?>
                    </td>
                    <td>
                        <?php
                            if ($v['status'] == 2) {
                                echo '<span class="label label-success">已支付</span>';
                            } elseif ($v['status'] == 3) {
                                echo '<span class="label label-danger">已取消</span>';
                            } else {
                                echo '<span class="label label-info">未處理</span>';
                            }
                        ?>
                    </td>
                    <td><?php echo $v['pay_name'] ?></td>
                    <td>
                        <?php echo $v['is_first'] == 1 ? '<span style="color:red">是</span>' : '否'?>
                    </td>
                    <td><?php echo $v['admin_name'] ?></td>
                    <td>
                        <?php
                            if ($v['from_way'] == 1) {
                                echo '<i class="fa fa-apple fa-lg"></i>';
                            } elseif ($v['from_way'] == 2) {
                                echo '<i class="fa fa-android fa-lg"></i>';
                            } elseif ($v['from_way'] == 3) {
                                echo '<i class="fa fa-desktop fa-lg"></i>';
                            } elseif ($v['from_way'] == 4) {
                                echo '<i class="fa fa-html5 fa-lg"></i>';
                            } else {
                                echo '<i class="fa fa-info-circle fa-lg"></i>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php echo '系統時間'.$v['addtime'].'<br>操作時間:'.$v['update_time'];?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        <?php if (empty($income_list)) { ?>
            <tr>
                <td colspan="12" style="text-align: center;"><span class="c_red">沒有數據@！</span></td>
            </tr>
        <?php } ?>
    </table>
</form>
<form class="form">
    <table class="table table-bordered">
        <tr class="active">
            <td colspan="16" style="text-align: center;">出款管理</td>
        </tr>
        <tr class="mult">
            <td>訂單號</td>
            <td>層級</td>
            <td>會員帳號</td>
            <td>所屬代理</td>
            <td>賬戶余額</td>
            <td>首存</td>
            <td>提款金額</td>
            <td>手續費</td>
            <td>行政費</td>
            <td>稽核</td>
            <td>實際出款金額</td>
            <td>狀態</td>
            <td>操縱者</td>
            <td>來源</td>
            <td>出款日期</td>
            <td>備註</td>
        </tr>
        <?php if (!empty($payment_list)) { ?>
            <?php foreach ($payment_list as $v) { ?>
                <tr>
                    <td><?php echo $v['order_num'] ?></td>
                    <td><?php echo $v['leve_name'] ?></td>
                    <td><?php echo $v['user_name'] ?></td>
                    <td><?php echo $v['agent_name'] ?></td>
                    <td>
                        <?php echo $v['balance'] > 0 ? $v['balance'] : '<span style="color:#ff0000">'.$v['balance'].'</span>'?>
                    </td>
                    <td>
                        <?php echo $v['is_first'] == 1 ? '<span style="color:red">是</span>' : '否'?>
                    </td>
                    <td><?php echo $v['price'] ?></td>
                    <td><?php echo $v['hand_fee'] ?></td>
                    <td><?php echo $v['admin_fee'] ?></td>
                    <td>
                        <?php
                            if($v['status'] == 1){
                                echo '<span class="label label-danger">稽核</span>';
                            }else{
                                echo '-';
                            }
                        ?>
                    </td>
                    <td>
                        <?php echo $v['actual_price'] >= 0 ? $v['actual_price'] : '<span style="background:#F8F8F8;color:#FF0000;">'.$v['actual_price'].'</span>'?>
                    </td>
                    <td>
                        <?php
                            if ($v['status'] == 2) {
                                echo '<span class="label label-success">已出款</span>';
                            } elseif ($v['status'] == 5) {
                                echo '<span class="label label-danger">已取消</span>';
                            } elseif ($v['status'] == 4) {
                                echo '<span class="label label-primary">正在出款</span>';
                            } elseif ($v['status'] == 3) {
                                echo '<span class="label label-warning">已拒絕</span>';
                            } elseif ($v['status'] == 1) {
                                echo '<span class="label label-info">未處理</span>';
                            }
                        ?>
                    </td>
                    <td><?php echo $v['admin_name'] ?></td>
                    <td>
                        <?php
                            if ($v['from_way'] == 1) {
                                echo '<i class="fa fa-apple fa-lg"></i>';
                            } elseif ($v['from_way'] == 2) {
                                echo '<i class="fa fa-android fa-lg"></i>';
                            } elseif ($v['from_way'] == 3) {
                                echo '<i class="fa fa-desktop fa-lg"></i>';
                            } elseif ($v['from_way'] == 4) {
                                echo '<i class="fa fa-html5 fa-lg"></i>';
                            } else {
                                echo '<i class="fa fa-info-circle fa-lg"></i>';
                            }
                        ?>
                    </td>
                    <td><?php echo $v['addtime'] ?></td>
                    <td><?php echo $v['remark'] ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        <?php if (empty($payment_list)) { ?>
            <tr>
                <td colspan="16" style="text-align: center;"><span class="c_red">沒有數據@！</span></td>
            </tr>
        <?php } ?>
    </table>
</form>