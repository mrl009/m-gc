<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>-->
<script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
<script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
<!--<script src="https://cdn.hcharts.cn/highstock/highstock.js"></script>-->

<div class="main">
    <span class="btn btn-info btn-xs" id="tb1" onclick="tubiao_display(1)">1.出入款數據</span>
    <!--btn-success-->
    <span class="btn btn-info btn-xs" id="tb2" onclick="tubiao_display(2)">2.存/提款筆數</span>
    <span class="btn btn-info btn-xs" id="tb3" onclick="tubiao_display(3)">3.存/提款人數</span>
    <span class="btn btn-info btn-xs" id="tb4" onclick="tubiao_display(4)">4.每日註冊綜合分析</span>
    <span class="btn btn-info btn-xs" id="tb5" onclick="tubiao_display(5)">5.返水數據</span>
</div>
<div class="clear"></div>
<div class="main">
<!--1.出入款數據-->
    <div class="panel-body">
        <div class="chart-filter">
            時間： <input onclick="laydate()" name="time_start" value="<?php echo date('Y-m-d')?>">
            查看天數： <input  name="day_num" value="30">
            <button class="btn-danger" style="width: 50px;" onclick="submitData()">查詢</button>
            <button class="btn-danger" style="width: 65px;height:21px;" onclick="del_redisData()">清除緩存</button>
            <span class="sum_span" style="float:right;margin-right: 30px;font-size: 12px;font-weight: bold;"></span>
        </div>
        <div id="areaChart" style="margin:15px">

        </div>
    </div>
    <script>
        var flag = 'in_out_price';
        submitData();

        //圖表顯示隱藏
        function tubiao_display(i) {
            if(i==1){
                $("#container").show();
                $("#container2").hide();
                $("#container3").hide();
                $("#container4").hide();
                $("#container5").hide();
                flag = 'in_out_price';
                submitData();
            }else if(i==2){
                $("#container").hide();
                $("#container2").show();
                $("#container3").hide();
                $("#container4").hide();
                $("#container5").hide();
                flag = 'in_out_num';
                submitData();
            }else if(i==3){
                $("#container").hide();
                $("#container2").hide();
                $("#container3").show();
                $("#container4").hide();
                $("#container5").hide();
                flag = 'in_out_peo';
                submitData();
            }else if(i==4){
                $("#container").hide();
                $("#container2").hide();
                $("#container3").hide();
                $("#container4").show();
                $("#container5").hide();
                flag = 'valid_user';
                submitData();
            }else if(i==5){
                $("#container").hide();
                $("#container2").hide();
                $("#container3").hide();
                $("#container4").hide();
                $("#container5").show();
                flag = 'valid_bet_price';
                submitData();
            }
        }

        //清除緩存
        function del_redisData(){
                var url = 'report/del_chart_redis';
            $.getJSON(url,function(data){
                Core.ok(data.msg);
            });
        }

        function submitData() {
            //alert(123);
            var time_start = $("input[name='time_start']").val();
            var day_num = $("input[name='day_num']").val();
            var url = 'report/get_chart';
            if (parseFloat(day_num) == day_num) {
                if (day_num > 31) {
                    Core.error("天數不能大於31");
                    return false;
                }
            }
            else {
                Core.error("天數請輸入數字");
                return false;
            }

            if(flag == 1){
                flag = 'in_out_price'
            }

            $.ajax({
                url: url,// 跳轉到 action
                data: {
                    flag: flag,
                    time_start:time_start,
                    day_num:day_num
                },
                type: 'post', //用post方法
                cache: false,
                dataType: 'json',
                success: function (data) {
                    var shuju = data.data;
                    var title1 = title2 = title3 = zhi = '';
                    switch(flag)
                    {
                        case 'in_out_price':
                            xuanran1(shuju);
                            zhi = ' 公司總入款:'+shuju.sum[0]+'&nbsp&nbsp&nbsp線上總入款:'+shuju.sum[1]
                                +'&nbsp&nbsp&nbsp彩豆總入款:'+shuju.sum[2]+'&nbsp&nbsp&nbsp人工總入款:'+shuju.sum[3]
                                + '&nbsp&nbsp&nbsp總入款：' +shuju.sum[4]+'&nbsp&nbsp&nbsp總出款：'+ shuju.sum[5]
                                +'&nbsp&nbsp&nbsp盈虧：'+shuju.sum[6];
                            $('.sum_span').html(zhi);
                            break;
                        case 'in_out_num':
                            title1 = '存提款筆數';title2 = '筆數';title3 = '筆';
                            xuanran2(shuju,title1,title2,title3,2);
                            zhi = ' 公司總存款筆數:'+shuju.sum[0]+'&nbsp&nbsp&nbsp線上總存款筆數:'+shuju.sum[1]
                                +'&nbsp&nbsp&nbsp彩豆總存款筆數:'+shuju.sum[2]+'&nbsp&nbsp&nbsp人工總存款筆數:'+shuju.sum[3]+'&nbsp&nbsp&nbsp存款總筆數：'
                                +shuju.sum[4]+'&nbsp&nbsp&nbsp銀行提款總筆數：'+shuju.sum[5]+'&nbsp&nbsp&nbsp人工提款總筆數：'+shuju.sum[6]
                                +'&nbsp&nbsp&nbsp總計：'+shuju.sum[7];
                            $('.sum_span').html(zhi);
                            break;
                        case 'in_out_peo':
                            title1 = '存提款人數';title2 = '人數';title3 = '人';
                            xuanran2(shuju,title1,title2,title3,3);
                            zhi = ' 公司入款總人數:'+shuju.sum[0]+'&nbsp&nbsp&nbsp線上入款總人數:'+shuju.sum[1]
                                +'&nbsp&nbsp&nbsp彩豆入款總人數:'+shuju.sum[2]+'&nbsp&nbsp&nbsp人工入款總人數:'+shuju.sum[3]
                                +'&nbsp&nbsp&nbsp人工出款總人數:'+shuju.sum[4]+'&nbsp&nbsp&nbsp出款總人數：'+shuju.sum[5];
                            $('.sum_span').html(zhi);
                            break;
                        case 'valid_user':
                            title1 = '有效會員分析';title2 = '人數';title3 = '';
                            xuanran2(shuju,title1,title2,title3,4);
                            $('.sum_span').html("");
                            break;
                        case 'valid_bet_price':
                            title1 = '有效總投註';title2 = '數量';title3 = '';
                            xuanran2(shuju,title1,title2,title3,5);
                            $('.sum_span').html("");
                            break;
                    }
                },
                error: function () {
                    Core.error('報表異常');
                }
            });

        }

        //渲染出入款數據圖標內容到頁面
        function xuanran1(sj)
        {
            $('#container').html("");//先清空
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '出入款數據'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: sj.categories,//數據綁定
                    crosshair: true
                },
                yAxis: {
                    min: -1,//允許負數
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} 元</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: sj.series //數據綁定
            });
        }

        function xuanran2(sj,t1,t2,t3,numm)
        {
            $('#container'+numm).html("");//先清空
            $('#container'+numm).highcharts({
                title: {
                    text: t1,
                    x: -20
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: sj.categories
                },
                yAxis: {
                    title: {
                        text: t2
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: t3
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: sj.series
            });
        }
    </script>
    <div id="container" style="min-width:90%;height:100%"></div>
    <div id="container2" style="min-width:90%;height:100%;display: none;"></div>
    <div id="container3" style="min-width:90%;height:100%;display: none;"></div>
    <div id="container4" style="min-width:90%;height:100%;display: none;"></div>
    <div id="container5" style="min-width:90%;height:100%;display: none;"></div>

</div>

<script type="text/javascript">

</script>
