<table id="report" class="fl table table-striped table-bordered" style="width: 35%;margin-top: 10px;">
    <tr>
        <td colspan="3">平臺抽成</td>
    </tr>
    <tr>
        <td colspan="1">平臺盈利／月</td>
        <td colspan="2">抽成百分比</td>
    </tr>
    <tr>
        <td colspan="1">1萬-200萬</td>
        <td colspan="2">7%</td>
    </tr>
    <tr>
        <td colspan="1">200萬以上-400萬</td>
        <td colspan="2">6%</td>
    </tr>
    <tr>
        <td colspan="1">400萬以上-600萬</td>
        <td colspan="2">5%</td>
    </tr>
    <tr>
        <td colspan="1">600萬以上-1000萬</td>
        <td colspan="2">4%</td>
    </tr>
    <tr>
        <td colspan="1">1000萬以上</td>
        <td colspan="2">3%</td>
    </tr>
    <tr>
        <td colspan="3">案例壹</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: left;">
            损益200萬，抽成计算公式：200*7%=14萬<br>
            损益400萬，抽成计算公式：200*7%+200*6%=26萬<br>
            损益600萬，抽成计算公式：200*7%+200*6%+200*5%=36萬<br>
            损益1000萬，抽成计算公式：200*7%+200*6%+200*5%+400*4%=52萬<br>
        </td>
    </tr>
    <!--<tr>
        <td colspan="3">案例貳</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: left;padding-bottom:25px">
            本月輸贏報表800萬，則本月合作分成計算方式如下：<br>
            第壹階梯：100萬*6%=6萬（100萬RMB占成6%）<br>
            第貳階梯：200萬*5%=10萬（100萬RMB-300萬RMB占成5%）<br>
            第叁階梯：300萬*4.5%=13.5萬（300萬RMB-600萬RMB占成4.5%）<br>
            第肆階梯：200萬*4%=8萬（600萬RMB以上占成4%）<br>
            本月合計：6萬+10萬+13.5萬+8萬=37.5萬
        </td>
    </tr>-->
</table>
<table class="fl table table-bordered" style="width: 64%;text-align: center;margin-top: 10px;">
    <tr class="active">
        <?php foreach ($qi_shu_key as $v) { ?>
            <td colspan="5"><?php echo $v; ?>年月帳期數</td>
        <?php } ?>
    </tr>
    <tr>
        <?php foreach ($qi_shu_key as $v) { ?>
            <td>期數</td>
            <td>期間</td>
            <td>輸贏</td>
            <td>平臺抽成</td>
            <td>支付狀態</td>
        <?php } ?>
    </tr>
    <?php
    for ($i = 0; $i <= 11; $i++) { ?>
        <tr id="refresh-<?php echo $i ?>">
            <?php foreach ($qi_shu_key as $key => $v) { ?>
                <td><?php echo '第' . ($i + 1) . '期'; ?></td>
                <td><?php echo $qi_shu_data[$v][$i]['nper'] == ($i + 1) ? $qi_shu_data[$v][$i]['period'] : ''; ?></td>
                <td><?php echo $qi_shu_data[$v][$i]['nper'] == ($i + 1) ? $qi_shu_data[$v][$i]['total'] : ''; ?></td>
                <td><?php echo $qi_shu_data[$v][$i]['nper'] == ($i + 1) ? $qi_shu_data[$v][$i]['rebate'] : ''; ?></td>
                <td>
                    <?php
                    if ($qi_shu_data[$v][$i]['nper'] == ($i + 1)) {
                        if ($qi_shu_data[$v][$i]['pay_status'] == 0) {
                            echo '<a href="javascript:;" onclick="refresh(' . $v . ',' . $i . ',' . $key . ')"><span class="glyphicon glyphicon-refresh"></span></a>';
                        } else if ($qi_shu_data[$v][$i]['pay_status'] == 1) {
                            echo '已支付';
                        } else if ($qi_shu_data[$v][$i]['pay_status'] == 2) {
                            echo '<span class="c_red">未支付</span>';
                        } else {
                            echo '';
                        }
                    }
                    ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
    <?php if ($this->session->userdata('sid') != 'a32') { ?>
        <tr>
            <td colspan="10">
                註：帳單對帳日期每月1至5日,請認準本易彩平臺官方唯壹材務tetegram:<i class="fa fa-telegram"></i><a href="https://t.me/boyoucaiwu"
                                                                                       target="_blank"> boyoucaiwu</a>,郵箱:boyoucaiwu@gmail.com,電話:+855(0)885198888
            </td>
        </tr>
    <?php } ?>
</table>
<script type="text/javascript">
    function refresh(year, month, key) {
        var tid = 'refresh-' + month;
        month = month + 1;
        $.get(WEB + 'report/report_refresh', {year: year, month: month}, function (json) {
            var c = JSON.parse(json);
            if (c.code == '200') {
                if (key == 0) {
                    $('#' + tid).find('td').eq(2).html(c.data.total);
                    $('#' + tid).find('td').eq(3).html(c.data.rebate)
                } else {
                    $('#' + tid).find('td').eq(7).html();
                    $('#' + tid).find('td').eq(8).html()
                }
            }
            Core.error(c.msg);
        });
    }
</script>
