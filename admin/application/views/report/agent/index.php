<?php $id = "form_" . uniqid(); ?>
<table id="<?php echo $id; ?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource(
        {
            url: 'agent/getlist',
            fields: [[
                //{field: 'id', title: 'ID', width: 40, sortable: true},
                {field: 'username', title: '账号', width: 110, align: 'center',formatter:function(v, r){if(v == undefined || v == ''){return '';}return '<a herf="#" onclick="show_user('+r.id+')">'+v+'</a>';}},
                {field: 'register_num', title: '注册人数', align: 'center', width: 70,formatter:function(v, r) {return v > 0 ? '<span class="btn label label-warning" onclick="new_register(\''+ r.report_date +'\',\''+ r.report_date +'\','+r.id+',\''+ r.username +'\')"><u>'+v+'</u></span>' : v}},
                {field: 'bet_num', title: '投注人数', align: 'center', width: 70,sortable:true,formatter:function(v, r) {return v > 0 ? '<span class="btn label label-warning" onclick="bet_user(\''+ r.report_date +'\',\''+ r.report_date +'\','+r.id+',\''+ r.username +'\')"><u>'+v+'</u></span>' : v}},
                {field: 'first_charge_num', title: '首充人数', align: 'center', width: 70,sortable:true,formatter:function(v, r) {return v > 0 ? '<span class="btn label label-warning" onclick="first_charge(\''+ r.report_date +'\',\''+ r.report_date +'\','+r.id+',\''+ r.username +'\')"><u>'+v+'</u></span>' : v}},
                {field: 'bet_money', title: '投注金额', align: 'center', width: 120,sortable:true},
                {field: 'prize_money', title: '中奖金额', align: 'center', width: 120},
                {field: 'gift_money', title: '活动礼金', align: 'center', width: 110},
                {field: 'team_rebates', title: '团队返点', align: 'center', width: 120},
                {field: 'charge_money', title: '充值金额', align: 'center', width: 120,sortable:true},
                {field: 'withdraw_money', title: '提现金额', align: 'center', width: 120,sortable:true},
                {field: 'team_profit', title: '团队盈利', align: 'center', width: 100},
                {field: 'agent_rebates', title: '代理返点', align: 'center', width: 90},
                {field: 'report_date', title: '报表日期', align: 'center', width: 90},
                {field:'aa',  title:'功能',align:'center', width:100,sortable:false,formatter:function(v,r){
                    return '<a herf="#" onclick=get_child('+r.id+',\''+r.username+'\');><span class="btn label label-primary">查看下级</span></a>';
                }}
            ]],
            rows:500,
            sort:'bet_num',
            tools:[
                {instant:false},
                <?php if(in_array('EXPORT',$auth)){?>
                {text:'導出',iconCls:'icon-large-chart',handler:function(){
                    Core.ExportJs($("#<?php echo $id;?>"),'代理报表');
                }},
                <?php }?>
                {type:'textbox', text: '代理账号', width: 100, name: 'username'},
                {type:'textbox', text: '所属上级', width: 100, name: 'agent'},
                {type:'label', html:'<input type="hidden" name="agent_type" value="username">'},
                {type:'datebox', text:'报表日期', width:98,name:'start',value:'<?=$start?>'},
                {type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
                    var start = $("#form_<?php echo $id?> input[name='start']").val();
                    var date = new Date();
                    var end = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDay();
                    if (Core.limitDay(start, end, 60)){
                        Core.error('只支持查询兩個月内数据');
                        return false;
                    }
                    $('#<?php echo $id?>').DataSource('search');
                }},
                '-'
            ],

            footer: true,
            success: function () {
                Core.agentLog('<?php echo $id?>');
            },
            checkbox: false

        });
    function get_child(id,username) {
        $("#form_<?php echo $id?> input[name='agent']").val(id);
        $("#form_<?php echo $id?> input[name='agent_type']").val('id');
        $('#<?php echo $id?>').DataSource('search');
        $("#form_<?php echo $id?> input[name='agent']").val(username);
        $("#form_<?php echo $id?> input[name='agent_type']").val('username');
    }
    function show_user(id){
        Core.dialog('會員信息','member/edit_member?id='+id,function(){},true,70);
    }
    function new_register(start,end,uid,username) {
        if (!start || !end || !uid) {
            return false;
        }
        Core.dialog(username+'代理团队新注冊會員','agent/new_register?start='+start+'&end='+end+'&agent_id='+uid,
            function(){},true,35,function(){},function(){},false,function(){},true);
    }
    function first_charge(start,end,uid,username) {
        if (!start || !end || !uid) {
            return false;
        }
        Core.dialog(username+'代理团队首充會員','agent/first_charge?start='+start+'&end='+end+'&agent_id='+uid,
            function(){},true,38,function(){},function(){},false,function(){},true);
    }
    function bet_user(start,end,uid,username) {
        if (!start || !end || !uid) {
            return false;
        }
        Core.dialog(username+'代理团队投注會員','agent/bet_user?start='+start+'&end='+end+'&agent_id='+uid,
            function(){},true,38,function(){},function(){},false,function(){},true);
    }
</script>