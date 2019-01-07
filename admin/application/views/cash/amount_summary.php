<!-- 會員登陸 -->
<style>
    button.btn.btn-danger{
        padding:0px 12px;
        margin-left:10px;
        font-size:12px;
    }
</style>
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_amount_summary_list',
        fields:[
            [
                {field:'in',title:'收入',align:'left',width:120,sortable:true},
                {field:'in_money',title:'收入金額',align:'left',width:310,sortable:true,
                    formatter:function(v,r){
                        return in_skip(v,r);
                    }
                },
                {field:'out',title:'支出',align:'left',width:120,sortable:true},
                {field:'out_detail',title:'支出明細',align:'left',width:310,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'';
                    },
                    formatter:function(v,r){
                        return out_skip(v,r);
                    }
                }
            ]

       ], tools:[
            {instant:false},
            {type:'datebox', text:'日期',  width:100,name:'time_start',value:''},
            {type:'datebox', text:'', width:100,name:'time_end',value:''},
//            {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'textbox', text:'賬號', width:120,name:'f_username'},
            {type:'label', html:'<button class="button button-primary summary_btn" type="button" data="today">今日</button>', width:50},
            {type:'label', html:'<button class="button button-primary summary_btn" type="button" data="yesterday">昨日</button>', width:50},
            {type:'label', html:'<button class="button button-primary summary_btn" type="button" data="theweek">本周</button>', width:50},
            {type:'label', html:'<button class="button button-primary summary_btn" type="button" data="lastweek">上周</button>', width:50},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
        '-'
        ],
        checkbox:false,
        edit:true,
        footer:true,
        success:function () {
            Core.agentLog('<?php echo $id?>');
        }
    });

    $(".summary_btn").click(function() {
        var dates = get_dates($(this).attr('data'));
        $('#form_<?php echo $id;?> #time_start').datebox("setValue", dates[0]);
        $('#form_<?php echo $id;?> #time_end').datebox("setValue", dates[1]);

    });

    var days = 0;

    function get_dates(type)
    {
        var startdate;
        var enddate;
        var now = new Date(); //當前日期
        var nowDayOfWeek = now.getDay(); //今天本周的第幾天
        var nowDay = now.getDate(); //當前日
        var nowMonth = now.getMonth(); //當前月
        var nowYear = now.getYear(); //當前年
        nowYear += (nowYear < 2000) ? 1900 : 0;

        if(nowDayOfWeek == 0){
            nowDayOfWeek = 7;
        }
        days++;

        switch(type) {
            case 'yesterday':
                startdate = format_date(new Date(nowYear, nowMonth, nowDay - days));
                enddate = format_date(new Date(nowYear, nowMonth, nowDay-days));
                break;
            case 'theweek':
                days = 0;
                startdate = format_date(new Date(nowYear, nowMonth, nowDay - nowDayOfWeek+1));
                enddate = format_date(new Date(nowYear, nowMonth, nowDay));
                break;
            case 'lastweek':
                days = 0;
                startdate = format_date(new Date(nowYear, nowMonth, nowDay - nowDayOfWeek-6));
                enddate = format_date(new Date(nowYear, nowMonth, nowDay-nowDayOfWeek));
                break;
            default:
                days = 0;
                startdate = enddate = format_date(new Date()); //當前日期
        }

        return [startdate, enddate];
    }

    function format_date(date) {
        var myyear = date.getFullYear();
        var mymonth = date.getMonth()+1;
        var myweekday = date.getDate();

        if(mymonth < 10){
            mymonth = "0" + mymonth;
        }
        if(myweekday < 10){
            myweekday = "0" + myweekday;
        }
        return (myyear+"-"+mymonth + "-" + myweekday);
    }

    function out_skip(v, r) {
        switch(r.out) {
            case '會員出款':
            return '<a onclick="skip_click(\'出款管理\', \'cash/payment\')">'+v+'</a>';
            break;
            case '給於優惠':
            return '<a onclick="skip_click(\'給予優惠\', \'Useranalyse/analysis_cash\',\'&impounded=1\')">'+v+'</a>';
            break;
            case '人工提出':
            return '<a onclick="skip_click(\'人工提出\', \'cash/deposit_withdraw_money\', \'&big_type=2\')">'+v+'</a>';
            break;
            case '給予反水':
            return '<a onclick="skip_click(\'反水分析\', \'useranalyse/privilege_analyse\')">'+v+'</a>';
            break;
            default:
            return v;
        }
    }

    function in_skip(v, r) {
        switch(r.in) {
            case '公司入款':
            return '<a onclick="skip_click(\'公司入款\',\'cash/index\')">'+v+'</a>';
            break;
            case '線上支付':
            return '<a onclick="skip_click(\'線上支付\', \'cash/income\')">'+v+'</a>';
            break;
            case '人工存入':
            return '<a onclick="skip_click(\'人工存入\', \'cash/deposit_withdraw_money\', \'&big_type=1\')">'+v+'</a>';
            break;
            case '會員出款被扣金額':
            return '<a onclick="skip_click(\'出款管理\', \'cash/payment\',\'&impounded=1\')">'+v+'</a>';
            break;
            default:
            return v;
        }
    }

    function skip_click(name, url, param) {
        Core.closeTab(name);
        var dates = get_dates($(this).attr('data'));
        var dates2 = $("[type=datebox]");
        if(dates2[0].value) {
            dates[0] = dates2[0].value;
        }
        if(dates2[1].value) {
            dates[1] = dates2[1].value;
        }
        var user = $("[name=f_username]")[0];
        var agent = $("[name=agent_id]")[0];
        var time = 5+Date.parse(new Date())/1000;
        $query = 'skip='+time+'&time_start='+dates[0]+'&time_end='+dates[1];
        if(param) {
            $query += param;
        }
        if(user.value) {
            $query += '&f_username='+user.value;
        }
        if(agent.value) {
            $query += '&agent_id='+agent.value;
        }
        Core.addTab(name, url+'?'+$query);
    }
</script>