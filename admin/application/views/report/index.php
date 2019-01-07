<table id="report" class="fl table table-striped table-bordered" style="width: 80%;margin-top: 10px;">
    <form action="" id="reportForm">
        <tr class="active">
            <td>日期區間</td>
            <td colspan="2" class="tal">
                <!--<input type="hidden" name="time_start" id="startTime" value="<?php /*echo date('Y-m-d')*/ ?>" >
                <input type="hidden" name="time_end" id="endTime" value="<?php /*echo date('Y-m-d')*/ ?>" >
                <input type="text" class="form-control date-picker" id="dateTimeRange" value="" />-->
                <input type="datebox" class="easyui-datebox" name="time_start" id="startTime" editable="false">&nbsp;~
                <input type="datebox" class="easyui-datebox" name="time_end" id="endTime" editable="false">
                <button class="button button-primary report_summary_btn" type="button" data="today">今日</button>
                <button class="button button-primary report_summary_btn" type="button" data="yesterday">昨日</button>
                <button class="button button-primary report_summary_btn" type="button" data="thisWeek">本周</button>
                <button class="button button-primary report_summary_btn" type="button" data="lastWeek">上周</button>
                <button class="button button-primary report_summary_btn" type="button" data="thisMonth">本月</button>
                <button class="button button-primary report_summary_btn" type="button" data="lastMonth">上月</button>
            </td>
        </tr>
        <tr>
            <td>報表類型</td>
            <td class="tal" colspan="2">
                <div class="radio">
                    <label><input type="radio" value="1" name="form_type">會員報表</label>
                </div>
                <div class="radio">
                    <label><input type="radio" value="2" name="form_type" checked>彩票報表</label>
                </div>
                <div class="radio <?php echo $is_sx ? '' : 'hidden'?>">
                    <label><input type="radio" value="3" name="form_type" >会员视讯報表</label>
                </div>
                <div class="radio <?php echo $is_sx ? '' : 'hidden'?>">
                    <label><input type="radio" value="4" name="form_type" >视讯報表</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>層級篩選</td>
            <td class="tal" colspan="2">
                <select class="form-control" name="level_id">
                    <option value="0">全部</option>
                    <?php foreach($level as $v){ ?>
                        <option value="<?php echo $v['id']?>"><?php echo $v['level_name']?></option>
                    <?php }?>
                </select>
                <span>* 默認不選擇為查詢所有層級</span>
            </td>
        </tr>
        <tr>
            <td>代理賬號</td>
            <td class="tal" colspan="2">
                <input name="agent_name" style="width:300px;border:1px solid #cecece;padding:2px;height:30px;">
                <input name="agent_id" type="hidden" value="">
                <span>* 為空默認查詢所有</span>
            </td>
        </tr>
        <tr>
            <td>會員賬號</td>
            <td class="tal" colspan="2">
                <input name="username" style="width:300px;border:1px solid #cecece;padding:2px;height:30px;">
                <span>* 為空默認查詢所有,逗號分隔可查詢多個會員</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <button type="submit" class="btn button button-primary" onClick="accountSubmit()">搜索</button>
            </td>
        </tr>
    </form>
    <tr class="fwb">
        <td>日期</td>
        <td>今日</td>
        <td>昨日</td>
    </tr>
    <tr>
        <td>已結算</td>
        <td class="c_red"><?php echo $settlement_finish['today']; ?></td>
        <td class="c_red"><?php echo $settlement_finish['yesterday']; ?></td>
    </tr>
    <tr>
        <td>未結算(包含已撤單)</td>
        <td class="c_red"><?php echo $settlement_unfinished['today']; ?></td>
        <td class="c_red"><?php echo $settlement_unfinished['yesterday']; ?></td>
    </tr>
    <tr>
        <td>輸贏</td>
        <td class="c_red"><?php echo isset($win_lose['today']) ? $win_lose['today'] : 0; ?></td>
        <td class="c_red"><?php echo isset($win_lose['yesterday']) ? $win_lose['yesterday'] : 0; ?></td>
    </tr>
    <tr>
        <td>盈利最多的彩票</td>
        <td class="c_red">
            <?php echo isset($win['today']) ? $win['today'] : 0; ?>
        </td>
        <td class="c_red">
            <?php echo isset($win['yesterday']) ? $win['yesterday'] : 0; ?>
        </td>
    </tr>
    <tr>
        <td>虧損最多彩票</td>
        <td class="c_red">
            <?php echo isset($lose['today']) ? $lose['today'] : 0; ?>
        </td>
        <td class="c_red">
            <?php echo isset($lose['yesterday']) ? $lose['yesterday'] : 0; ?>
        </td>
    </tr>
</table>
<script type="text/javascript">
    // 點擊查詢，跳轉頁面
    function accountSubmit() {
        var submitType = $("input[name='form_type']:checked").val();
        var time_start = $("#report input[name='time_start']").val();
        var time_end = $("#report input[name='time_end']").val();
        var level_id = $("select[name='level_id']").val();
        var username = $("input[name='username']").val();
        var agent_id = $("input[name='agent_id']").val();
        if (time_start != '' && time_end != '' && Core.limitDay(time_start, time_end, 60)) {
            Core.error('查詢區間限制為兩個月');
            return false;
        }
        if (submitType == '1') {
            Core.closeTab('會員報表');
            Core.addTab('會員報表', 'report/settlement_report?time_start=' + time_start + '&time_end=' + time_end + '&form_type=' + submitType + '&level_id=' + level_id + '&username=' + username + '&agent_id=' + agent_id);
        } else if (submitType == '2') {
            Core.closeTab('彩票報表');
            Core.addTab('彩票報表', 'report/classify_report?time_start=' + time_start + '&time_end=' + time_end + '&form_type=' + submitType + '&level_id=' + level_id + '&username=' + username + '&agent_id=' + agent_id);
        } else if (submitType == '3') {
            Core.closeTab('會員视讯報表');
            Core.addTab('會員视讯報表', 'report/user_sx_report?time_start=' + time_start + '&time_end=' + time_end + '&form_type=' + submitType + '&level_id=' + level_id + '&username=' + username + '&agent_id=' + agent_id);
        } else if (submitType == '4') {
            Core.closeTab('视讯報表');
            Core.addTab('视讯報表', 'report/sx_report?time_start=' + time_start + '&time_end=' + time_end + '&form_type=' + submitType + '&level_id=' + level_id + '&username=' + username + '&agent_id=' + agent_id);
        }
    }

    $(function () {
        /*$('#dateTimeRange').daterangepicker({
         applyClass : 'btn-sm btn-success',
         cancelClass : 'btn-sm btn-default',
         "alwaysShowCalendars": true,
         ranges : {
         //'最近1小時': [moment().subtract('hours',1), moment()],
         '今日': [moment().startOf('day'), moment()],
         '昨日': [moment().subtract('days', 1).startOf('day'), moment().subtract('days', 1).endOf('day')],
         '最近7日': [moment().subtract('days', 6), moment()],
         '最近30日': [moment().subtract('days', 29), moment()],
         '本月': [moment().startOf("month"),moment().endOf("month")],
         '上個月': [moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]
         },
         opens : 'right',    // 日期選擇框的彈出位置
         separator : ' 至 ',
         showWeekNumbers : true,     // 是否顯示第幾周
         //timePicker: true,
         //timePickerIncrement : 10, // 時間的增量，單位為分鐘
         //timePicker12Hour : false, // 是否使用12小時制來顯示時間
         //maxDate : moment(),           // 最大時間
         format: 'YYYY-MM-DD',
         locale : {
         format: 'YYYY-MM-DD',
         applyLabel : '確定',
         cancelLabel : '取消',
         fromLabel : '起始時間',
         toLabel : '結束時間',
         customRangeLabel : '自定義',
         daysOfWeek : [ '日', '壹', '二', '三', '四', '五', '六' ],
         monthNames : [ '壹月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十壹月', '十二月' ],
         firstDay : 1
         }
         }, function(start, end, label) { // 格式化日期顯示框
         $('#startTime').val(start.format('YYYY-MM-DD'));
         $('#endTime').val(end.format('YYYY-MM-DD'));
         })
         .next().on('click', function(){
         $(this).prev().focus();
         });*/
        // 代理
        $('#report [name="agent_name"]').click(function () {
            Core.dialog('代理查詢', 'cash/search_agent?id=report', function () {
            }, true, false);
        })
    });

    // 點擊事件
    $(".report_summary_btn").click(function () {
        var dates = report_get_dates($(this).attr('data'));
        $('#startTime').datebox("setValue", dates[0]);
        $('#endTime').datebox("setValue", dates[1]);
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
