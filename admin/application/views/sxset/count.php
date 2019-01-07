<table id="sx_report" class="fl table table-striped table-bordered" style="width: 80%;margin-top: 10px;">
    <form action="" id="sx_reportForm">
        <tr class="active">
            <td>日期區間</td>
            <td colspan="2" class="tal">
               
                <input type="datebox" class="easyui-datebox" name="time_start" id="startTime" editable="false">&nbsp;~
                <input type="datebox" class="easyui-datebox" name="time_end" id="endTime" editable="false">
                <!--<button class="button button-primary report_summary_btn" type="button" data="today">今日</button>-->
                <button class="button button-primary sx_report_summary_btn" type="button" data="yesterday">昨日</button>
                <!--<button class="button button-primary report_summary_btn" type="button" data="thisWeek">本周</button>
                <button class="button button-primary report_summary_btn" type="button" data="lastWeek">上周</button>
                <button class="button button-primary report_summary_btn" type="button" data="thisMonth">本月</button>
                <button class="button button-primary report_summary_btn" type="button" data="lastMonth">上月</button>
                <span style="color:red">【请勿跨月份查询】</span>-->
            </td>
        </tr>
        
        <tr>
            <td>層級篩選</td>
            <td class="tal" colspan="2">
                <?php foreach($level as $v){ ?>
                   <span>
                    <input type="checkbox" name="level_id" value="<?php echo $v['id']?>">
                   <?php echo $v['level_name']?>&nbsp;&nbsp;&nbsp;</span>
                <?php }?>
                <br><br>
                <p>* 不選默認全部層級</p>
            </td>
        </tr>
        
        <tr>
            <td colspan="3" style="text-align: center">
                <button type="submit" class="btn button button-primary" onClick="sxCalSubmit()">搜索</button>
            </td>
        </tr>
    </form>

</table>
<script type="text/javascript">
    // 點擊查詢，跳轉頁面
    function sxCalSubmit() {
        var time_start = $("#sx_report input[name='time_start']").val();
        var time_end = $("#sx_report input[name='time_end']").val();
        var level_id = []
        $.each($('#sx_report input[name="level_id"]:checkbox:checked'),function(){
            level_id.push($(this).val())
        });
        if (time_start == '') {
            Core.error('请选择开始时间');
            return false;
        }
        if (time_end == '') {
            Core.error('请选择结束时间');
            return false;
        }
        if (Core.limitDay(time_start, time_end, 0)) {
            Core.error('查询天数跨度不能大于一天');
            return false;
        }
        if (Date.parse(new Date(time_start)) > new Date().setHours(0,0,0,0)) {
            Core.error('只能查询昨天之前的数据');
            return false;
        }
        Core.closeTab('優惠详情');
        Core.addTab('優惠详情', 'sxset/fs_report?time=' + time_start + '&level_id=' + level_id.join(','));
        
    }

    // 點擊事件
    $(".sx_report_summary_btn").click(function () {
        var dates = report_get_dates($(this).attr('data'));
        $('#sx_report #startTime').datebox("setValue", dates[0]);
        $('#sx_report #endTime').datebox("setValue", dates[1]);
    });

    var days = 0;
    var month = 0;

    function report_get_dates(type) {
        var startdate;
        var enddate;
        var now = new Date(); //當前日期
        var nowDayOfWeek = now.getDay(); //今天本周的第幾天
        var nowDay = now.getDate(); //當前日
        var nowMonth = now.getMonth(); //當前月
        var nowYear = now.getYear(); //當前年
        var lastMonthDay = new Date(nowYear, nowMonth - month, 0).getDate();// 上月天數
        var nowMonthDay = new Date(nowYear, nowMonth + 1, 0).getDate();// 本月天數
        nowYear += (nowYear < 2000) ? 1900 : 0;
        if (nowDayOfWeek == 0) {
            nowDayOfWeek = 7;
        }
        days++;
        switch (type) {
            case 'yesterday':
                month = 0;
                startdate = report_format_date(new Date(nowYear, nowMonth, nowDay - days));
                enddate = report_format_date(new Date(nowYear, nowMonth, nowDay - days));
                break;
            case 'thisWeek':
                days = 0;
                month = 0;
                startdate = report_format_date(new Date(nowYear, nowMonth, nowDay - nowDayOfWeek + 1));
                enddate = report_format_date(new Date(nowYear, nowMonth, nowDay));
                break;
            case 'lastWeek':
                days = 0;
                month = 0;
                startdate = report_format_date(new Date(nowYear, nowMonth, nowDay - nowDayOfWeek - 6));
                enddate = report_format_date(new Date(nowYear, nowMonth, nowDay - nowDayOfWeek));
                break;
            case 'thisMonth':
                days = 0;
                month = 0;
                startdate = report_format_date(new Date(nowYear, nowMonth, 1));
                enddate = report_format_date(new Date(nowYear, nowMonth, nowMonthDay));
                break;
            case 'lastMonth':
                days = 0;
                startdate = report_format_date(new Date(nowYear, nowMonth - 1 - month, 1));
                enddate = report_format_date(new Date(nowYear, nowMonth - 1 - month, lastMonthDay));
                month++;
                break;
            default:
                days = 0;
                month = 0;
                startdate = enddate = report_format_date(new Date()); //當前日期
        }
        return [startdate, enddate];
    }

    function report_format_date(date) {
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
