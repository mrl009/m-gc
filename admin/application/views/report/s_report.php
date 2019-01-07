<?php $start="form_".uniqid();?>
<?php $end="form_".uniqid();?>
<?php $id="form_".uniqid();?>
<?php $id1="form_".uniqid();?>
<?php $id2="form_".uniqid();?>
<table id="<?php echo $id?>" class="fl table table-striped table-bordered" style="margin-top: 10px;margin-bottom: 10px !important;">
    <tr class="active">
        <td>
            <button class="button button-primary s_report_summary_btn" type="button" data="today">今日</button>
            <button class="button button-primary s_report_summary_btn" type="button" data="yesterday">昨日</button>
            <button class="button button-primary s_report_summary_btn" type="button" data="thisMonth">本月</button>
            <button class="button button-primary s_report_summary_btn" type="button" data="lastMonth">上月</button>&nbsp;&nbsp;
            开始时间：<input type="datebox" class="easyui-datebox" name="time_start" id="<?php echo $start?>" editable="false">&nbsp;&nbsp;
            结束时间：<input type="datebox" class="easyui-datebox" name="time_end" id="<?php echo $end?>" editable="false">
            <button type="submit" class="btn button button-primary" onClick="accountSubmit()">搜索</button>
        </td>
    </tr>
</table>
<table id="<?php echo $id1?>" class="fl table table-striped" style="margin-bottom: 10px !important;">
    <tr style="height: 80px;text-align: center">
        <td>
            <div class="s_report_left">
                <img src="static/images/total_win.jpg" class="img-circle">
            </div>
            <div class="s_report_right">
                <span class="f-sty-t">盈利</span><br>
                <span class="c_red f-sty-b win_price"><?php echo $win_price?></span>
            </div>
        </td>
        <td>
            <div class="s_report_left">
                <img src="static/images/total_rate.jpg" class="img-circle">
            </div>
            <div class="s_report_right">
                <span class="f-sty-t">盈率</span><br>
                <span class="c_red f-sty-b win_rate"><?php echo $win_rate?>%</span>
            </div>
        </td>
        <td>
            <div class="s_report_left">
                <img src="static/images/total_bet.jpg" class="img-circle">
            </div>
            <div class="s_report_right">
                <span class="f-sty-t">下注金额</span><br>
                <span class="c_red f-sty-b bet_money"><?php echo $rs['bet_money'] == null ? '0.000' : $rs['bet_money']?></span>
            </div>
        </td>
        <td>
            <div class="s_report_left">
                <img src="static/images/total_price.jpg" class="img-circle">
            </div>
            <div class="s_report_right">
                <span class="f-sty-t">中奖金额</span><br>
                <span class="c_red f-sty-b prize_money"><?php echo $rs['prize_money'] == null ? '0.000' : $rs['prize_money']?></span>
            </div>
        </td>
    </tr>
</table>
<div id="<?php echo $id2?>">
    <table  class="fl table table-striped table-bordered" style="width: 32%;margin-right: 1%">
        <tr>
            <td>
                <span class="f-w">提现金额</span>：<span class="c_red withdraw_money"><?php echo $rs['withdraw_money'] == null ? '0.000' : $rs['withdraw_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">提现人数</span>：<span class="c_red withdraw_user_num"><?php echo $rs['withdraw_user_num'] == null ? 0 : $rs['withdraw_user_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">反水金额</span>：<span class="c_red rebate_money"><?php echo $rs['rebate_money'] == null ? '0.000' : $rs['rebate_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">反水笔数</span>：<span class="c_red rebate_num"><?php echo $rs['rebate_num'] == null ? 0 : $rs['rebate_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">反水人数</span>：<span class="c_red rebate_user_num"><?php echo $rs['rebate_user_num'] == null ? 0 : $rs['rebate_user_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">活动金额</span>：<span class="c_red activity_money"><?php echo $rs['activity_money'] == null ? '0.000' : $rs['activity_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">活动人数</span>：<span class="c_red activity_user_num"><?php echo $rs['activity_user_num'] == null ? 0 : $rs['activity_user_num']?></span>
            </td>
        </tr>
    </table>
    <table  class="fl table table-striped table-bordered" style="width: 32%;margin-right: 1%">
        <tr>
            <td>
                <span class="f-w">充值笔数</span>：<span class="c_red charge_num"><?php echo $rs['charge_num'] == null ? 0 : $rs['charge_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">提现笔数</span>：<span class="c_red withdraw_num"><?php echo $rs['withdraw_num'] == null ? 0 : $rs['withdraw_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">人工提出金额</span>：<span class="c_red out_people_money"><?php echo $rs['out_people_money'] == null ? '0.000' : $rs['out_people_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">出款被扣金额</span>：<span class="c_red refuse_money"><?php echo $rs['refuse_money'] == null ? '0.000' : $rs['refuse_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">注册人数</span>：<span class="c_red register_num"><?php echo $rs['register_num'] == null ? 0 : $rs['register_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">首充人数</span>：<span class="c_red first_charge_num"><?php echo $rs['first_charge_num'] == null ? 0 : $rs['first_charge_num']?></span>
            </td>
        </tr>
    </table>
    <table  class="fl table table-striped table-bordered" style="width: 33%">
        <tr>
            <td>
                <span class="f-w">充值金额</span>：<span class="c_red charge_money"><?php echo $rs['charge_money'] == null ? '0.000' : $rs['charge_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">充值人数</span>：<span class="c_red charge_user_num"><?php echo $rs['charge_user_num'] == null ? 0 : $rs['charge_user_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">下注笔数</span>：<span class="c_red bet_num"><?php echo $rs['bet_num'] == null ? 0 : $rs['bet_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">中奖笔数</span>：<span class="c_red prize_num"><?php echo $rs['prize_num'] == null ? 0 : $rs['prize_num']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">撤单金额</span>：<span class="c_red cancel_money"><?php echo $rs['cancel_money'] == null ? '0.000' : $rs['cancel_money']?></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="f-w">撤单笔数</span>：<span class="c_red cancel_num"><?php echo $rs['cancel_num'] == null ? 0 : $rs['cancel_num']?></span>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    // 點擊查詢
    function accountSubmit() {
        var start = $("#<?php echo $id?> input[name='time_start']").val();
        var end = $("#<?php echo $id?> input[name='time_end']").val();
        if (start != '' && end != '' && Core.limitDay(start, end, 60)){
            Core.error('查詢區間限制為兩個月');
            return false;
        }
        $.ajax({
            url: WEB + 'report/ajax_s_report',
            data: {
                start: start,
                end:end
            },
            type: 'post',
            cache: false,
            async: false,
            dataType: 'json',
            success: function (data) {
                $("#<?php echo $id1?> .win_price").html(data.win_price);
                $("#<?php echo $id1?> .win_rate").html(data.win_rate + '%');
                $("#<?php echo $id1?> .bet_money").html(data.rs.bet_money);
                $("#<?php echo $id1?> .prize_money").html(data.rs.prize_money);
                $("#<?php echo $id2?> .withdraw_money").html(data.rs.withdraw_money);
                $("#<?php echo $id2?> .withdraw_user_num").html(data.rs.withdraw_user_num);
                $("#<?php echo $id2?> .rebate_money").html(data.rs.rebate_money);
                $("#<?php echo $id2?> .rebate_num").html(data.rs.rebate_num);
                $("#<?php echo $id2?> .rebate_user_num").html(data.rs.rebate_user_num);
                $("#<?php echo $id2?> .activity_money").html(data.rs.activity_money);
                $("#<?php echo $id2?> .activity_user_num").html(data.rs.activity_user_num);
                $("#<?php echo $id2?> .charge_num").html(data.rs.charge_num);
                $("#<?php echo $id2?> .withdraw_num").html(data.rs.withdraw_num);
                $("#<?php echo $id2?> .out_people_money").html(data.rs.out_people_money);
                $("#<?php echo $id2?> .refuse_money").html(data.rs.refuse_money);
                $("#<?php echo $id2?> .register_num").html(data.rs.register_num);
                $("#<?php echo $id2?> .first_charge_num").html(data.rs.first_charge_num);
                $("#<?php echo $id2?> .charge_money").html(data.rs.charge_money);
                $("#<?php echo $id2?> .charge_user_num").html(data.rs.charge_user_num);
                $("#<?php echo $id2?> .bet_num").html(data.rs.bet_num);
                $("#<?php echo $id2?> .prize_num").html(data.rs.prize_num);
                $("#<?php echo $id2?> .cancel_money").html(data.rs.cancel_money);
                $("#<?php echo $id2?> .cancel_num").html(data.rs.cancel_num);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                    $('#<?=$id?>').html(XMLHttpRequest.responseText);
                } else {
                    Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                }
            }
        });
    }

    // 點擊事件
    $(".s_report_summary_btn").click(function () {
        var dates = s_report_get_dates($(this).attr('data'));
        $('#<?php echo $start?>').datebox("setValue", dates[0]);
        $('#<?php echo $end?>').datebox("setValue", dates[1]);
    });
    var days = 0;
    var month = 0;
    function s_report_get_dates(type) {
        var startdate;
        var enddate;
        var now = new Date(); //當前日期
        var nowDay = now.getDate(); //當前日
        var nowMonth = now.getMonth(); //當前月
        var nowYear = now.getYear(); //當前年
        var lastMonthDay = new Date(nowYear, nowMonth - month, 0).getDate();// 上月天數
        var nowMonthDay = new Date(nowYear, nowMonth + 1, 0).getDate();// 本月天數
        nowYear += (nowYear < 2000) ? 1900 : 0;
        days++;
        switch (type) {
            case 'yesterday':
                month = 0;
                startdate = s_report_format_date(new Date(nowYear, nowMonth, nowDay - days));
                enddate = s_report_format_date(new Date(nowYear, nowMonth, nowDay - days));
                break;
            case 'thisMonth':
                days = 0;
                month = 0;
                startdate = s_report_format_date(new Date(nowYear, nowMonth, 1));
                enddate = s_report_format_date(new Date(nowYear, nowMonth, nowMonthDay));
                break;
            case 'lastMonth':
                days = 0;
                startdate = s_report_format_date(new Date(nowYear, nowMonth - 1 - month, 1));
                enddate = s_report_format_date(new Date(nowYear, nowMonth - 1 - month, lastMonthDay));
                month++;
                break;
            default:
                days = 0;
                month = 0;
                startdate = enddate = s_report_format_date(new Date()); //當前日期
        }
        return [startdate, enddate];
    }
    function s_report_format_date(date) {
        var myyear = date.getFullYear();
        var mymonth = date.getMonth() + 1;
        var myweekday = date.getDate();

        if (mymonth < 10) {
            mymonth = "0" + mymonth;
        }
        if (myweekday < 10) {
            myweekday = "0" + myweekday;
        }
        return (myyear + "-" + mymonth + "-" + myweekday);
    }
</script>
<style>
    .s_report_left {
        float: left;
        margin-left: 20px;
    }
    .s_report_right {
        margin-top: 20px;
    }
    .s_report_right .f-sty-t {
        font-size: 25px;
        font-weight: bold;
    }
    .s_report_right .f-sty-b {
        font-size: 20px;
        font-weight: bold;
    }
    #<?php echo $id2?> .f-w {
        font-weight: bold;
    }
    #<?php echo $id2?> table tr {
        height: 40px;
    }
</style>