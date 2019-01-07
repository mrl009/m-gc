<!DOCTYPE html>
<html>
<head>
    <meta name="renderer" content="webkit|ie-comp|ie-stand" />
    <meta charset="UTF-8">
    <title>歡迎登陸管理後臺 - 發發發</title>
    <link rel="stylesheet" href="static/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" type="text/css" href="static/js/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/js/layout/themes/bootstrap/easyui.css">
    <link rel="stylesheet" type="text/css" href="static/js/layout/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="static/css/buttons.css">
    <link rel="stylesheet" type="text/css" href="static/css/animate.css">
    <link rel="stylesheet" type="text/css" href="static/css/core.css">
    <link rel="stylesheet" type="text/css" href="static/css/themes/red.css" id="colorIn">
    <script type="text/javascript" src="static/js/jquery.min.js"></script>
    <script src="static/js/colpick.js" type="text/javascript"></script>
    <link rel="stylesheet" href="static/css/colpick.css" type="text/css"/>
    <script>
    var WEB = '<?php echo WEB?>';
    var MQ_HOST = '<?php echo MQ_HOST?>';
    var MQ_PORT = '<?php echo MQ_PORT?>';
    var USERNAME = '<?php echo $this->session->userdata('admin_name')?>';
    var SID = '<?php echo $this->session->userdata('sid')?>';
    </script>
    <script type="text/javascript" src="static/js/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="static/js/layout/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="static/js/layout/locale/easyui-lang-zh_CN.js"></script>
    <script type="text/javascript" src="static/js/core.js"></script>
    <style>
    .themes{padding:5px 10px 5px 5px;margin-left: 10px;}
    .zi{background: #5823CB;}
    .red{background: #F15757;}
    .huang{background: #FAAC3D;}
    .liu{background: #52B058;}
    .fa-telegram{color:#66CCFF}
</style>
</head>
<body class="easyui-layout">
    <div data-options="region:'north',border:false" style="height:110px;overflow: hidden;border:none;" class="animated bounceInDown">
        <div style="width: 100%; min-width: 1000px;">
            <div style="padding:5px;float:left; overflow: hidden;">
                <span class="glyphicon glyphicon-bullhorn"></span>&nbsp;公告:發發發!
                <!-- <span>
                <i class="fa fa-telegram"></i><a href="https://t.me/yicaiyunkefu" target="_blank"> 易彩客服</a>
                </span> -->
                <span>
                <i class="fa fa-telegram"></i><a href="https://t.me/caiwu1111
" target="_blank"> 易彩财务+855885198888</a>
                </span>
                <span>
                <i class="fa fa-telegram"></i><a href="https://t.me/boyou666" target="_blank">易彩业务+855885198888</a>
                </span>
                <!--<span>
                <i class="fa fa-telegram"></i><a href="https://t.me/boyou2" target="_blank"> 易彩客服2</a>
                </span>
                <span>
                <i class="fa fa-telegram"></i><a href="https://t.me/boyou3" target="_blank"> 易彩客服3</a>
                </span>
                <span>
                <i class="fa fa-telegram"></i><a href="https://t.me/boyou8" target="_blank"> 官方公告號(必加)</a>
                </span>-->

            </div>
            <div style="padding:5px; float: right;">
                <?php if($this->session->userdata('test')){?> 調試:
                <a target="_blank" href="<?php echo WEB.'test/'.$this->session->userdata('admin_name').'_post.html'?>">POST</a>&nbsp;&nbsp;
                <a target="_blank" href="<?php echo WEB.'test/'.$this->session->userdata('admin_name').'_get.html'?>">GET</a>&nbsp;&nbsp;
                <?php }?> 
<!-- <span>
                <a href="javascript:;" class="themes zi" onclick="change('zi')"></a>
                <a href="javascript:;" class="themes red" onclick="change('red')"></a>
                <a href="javascript:;" class="themes huang" onclick="change('huang')"></a>
                <a href="javascript:;" class="themes liu" onclick="change('liu')"></a>
                </span> -->
                
                <span id="Clock"></span>
                <audio id="auto_out_player" controls="controls" autoplay class="hidden">
                    <source src="static/audio/out.mp3"/>
                </audio>
                <audio id="auto_in_player" controls="controls" autoplay class="hidden">
                    <source src="static/audio/in.mp3"/>
                </audio>
                <span>在線人數:<b style="color:red" class="online">0</b>&nbsp;</span>
                <span>投注人數:<b style="color:red" class="bets_num">0</b>&nbsp;</span>
                <span>今日註冊:<b style="color:red" class="bank_name">0</b>&nbsp;</span>
                <a href="javascript:;" title="刷新在線人數" onclick="refreshUserCount()"><span class="glyphicon glyphicon-refresh"></span></a>
                <!-- <span>平臺額度：<b style="color:red"><?php echo $rs['credit']?></b>&nbsp;&nbsp;</span> -->
                <span>帳號：<?php echo $this->session->userdata('admin_name')?>&nbsp;
                        <a href="javascript:;" style="color:#069" onClick="Core.dialog('修改密碼','manager/password',function(){},true,false);">改密</a>&nbsp;&nbsp;
                        <a href="javascript:;" style="color:#069" onClick="Core.exit();">退出</a>
                </span>

            </div>
        </div>
        <div style="clear:both"></div>
        <div class="top-menu" id="menuList">
        </div>

        <div id="submenu"></div>
    </div>
    <div data-options="region:'center',title:''" class="animated rotateInDownRight">
        <div id="task" class="easyui-tabs" data-options="fit:true,tools:[{iconCls:'icon-reload',handler:function(){Core.refresh();}},{iconCls:'icon-no',handler:function(){Core.exit();}}]">
            <!--<div title="開始頁" data-options="href:'welcome/start',closable:false"></div>-->
            <!--welcome/start  stats/order-->
        </div>
    </div>
    <div id="mm" class="easyui-menu">
        <div onClick="Core.refresh()">刷新</div>
        <div onClick="Core.closeCurrent()">關閉當前頁面</div>
        <div onClick="Core.closeOthers()">關閉其他頁面</div>
        <div onClick="Core.closeAll()">關閉所有頁面</div>
    </div>
    <div id="cdlist" class="easyui-menu">
        <div><a href="#" class="durl" target="_blank">打開新窗口</a></div>
        
    </div>
    <div id="in" style="display: none"></div>
    <div id="out" style="display: none"></div>
    <script type='text/javascript'>
        function change(a){
            var css=document.getElementById('colorIn');
            css.setAttribute('href','static/css/themes/'+a+'.css');
        }
        function refreshUserCount() {
            $.getJSON(WEB+'login/user_count',function(c){
                if(c.code == 200){
                    $('.online').html('');
                    $('.bank_name').html('');
                    $('.bets_num').html('');
                    $('.sx_credit').html('');
                    $('.online').html(c.data['online']);
                    $('.bank_name').html(c.data['bank_name']);
                    $('.bets_num').html(c.data['bets_num']);
                    $('.sx_credit').html(c.data['sx_credit']);
                }
            });
        }
    </script>
    <SCRIPT language=JavaScript>
    function tick() {
        var years, months, days, hours, minutes, seconds;
        var intYears, intMonths, intDays, intHours, intMinutes, intSeconds;
        var today;
        today = new Date(); //系統當前時間
        intYears = today.getFullYear(); //得到年份,getFullYear()比getYear()更普適
        intMonths = today.getMonth() + 1; //得到月份，要加1
        intDays = today.getDate(); //得到日期
        intHours = today.getHours(); //得到小時
        intMinutes = today.getMinutes(); //得到分鐘
        intSeconds = today.getSeconds(); //得到秒鐘
        years = intYears + "-";
        if (intMonths < 10) {
            months = "0" + intMonths + "-";
        } else {
            months = intMonths + "-";
        }
        if (intDays < 10) {
            days = "0" + intDays + " ";
        } else {
            days = intDays + " ";
        }
        if (intHours == 0) {
            hours = "00:";
        } else if (intHours < 10) {
            hours = "0" + intHours + ":";
        } else {
            hours = intHours + ":";
        }
        if (intMinutes < 10) {
            minutes = "0" + intMinutes + ":";
        } else {
            minutes = intMinutes + ":";
        }
        if (intSeconds < 10) {
            seconds = "0" + intSeconds + " ";
        } else {
            seconds = intSeconds + " ";
        }
        timeString = years + months + days + hours + minutes + seconds;
        Clock.innerHTML = timeString;
        window.setTimeout("tick();", 1000);
    }
    window.onload = tick;
    </SCRIPT>
</body>
</html>
