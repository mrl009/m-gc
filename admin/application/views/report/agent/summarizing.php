<?php $id = "form_" . uniqid(); ?>
<table id="<?php echo $id; ?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource(
        {
            url: 'agent/getsummarizinglist',
            fields: [[
                //{field: 'id', title: 'ID', width: 40, sortable: true},
                {field: 'username', title: '账号', width: 120, align: 'center',formatter:function(v, r){if(v == undefined || v == ''){return '';}return '<a herf="#" onclick="show_user('+r.id+')">'+v+'</a>';}},
                {field: 'register_num', title: '注册人数', align: 'center', width: 80,sortable:true},
                /*{field: 'bet_num', title: '投注人数', align: 'center', width: 60},*/
                {field: 'first_charge_num', title: '首充人数', align: 'center', width: 80,sortable:true},
                {field: 'level', title: '代理等级', align: 'center', width: 120,sortable:true},
                {field: 'bet_money', title: '投注金额', align: 'center', width: 120,sortable:true},
                {field: 'prize_money', title: '中奖金额', align: 'center', width: 120,sortable:true},
                {field: 'gift_money', title: '活动礼金', align: 'center', width: 100,sortable:true},
                {field: 'team_rebates', title: '团队返点', align: 'center', width: 100,sortable:true},
                {field: 'charge_money', title: '充值金额', align: 'center', width: 120,sortable:true},
                {field: 'withdraw_money', title: '提现金额', align: 'center', width: 120,sortable:true},
                {field: 'team_profit', title: '团队盈利', align: 'center', width: 120,sortable:true},
                {field: 'agent_rebates', title: '代理返点', align: 'center', width: 100,sortable:true},
                {field:'aa',  title:'功能',align:'center', width:100,sortable:false,formatter:function(v,r){
                    return '<a herf="#" onclick=get_child('+r.id+',\''+r.username+'\');><span class="btn label label-primary">查看下级</span></a>';
                }}
            ]],
            rows:500,
            sort:'bet_money',
            tools:[
                {instant:false},
                <?php if(in_array('EXPORT',$auth)){?>
                {text:'導出',iconCls:'icon-large-chart',handler:function(){
                    Core.ExportJs($("#<?php echo $id;?>"),'代理报表汇总');
                }},
                <?php }?>
                {type:'textbox', text: '代理账号', width: 100, name: 'username',formatter:function(v, r){if(v == undefined || v == ''){return '';}return '<a herf="#" onclick="show_user('+r.id+')">'+v+'</a>';}},
                {type:'textbox', text: '所属上级', width: 100, name: 'agent'},
                {type:'label', html:'<input type="hidden" name="agent_type" value="username">'},
                {type:'datebox', text:'报表日期', width:98,name:'start',value:'<?=$start?>'},
                {type:'datebox', text:'-', width:98,name:'end',value:'<?=$end?>'},
                {type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
                    var tj_txt = $("#form_<?php echo $id?> input[name='username']").val();
                    var start = $("#form_<?php echo $id?> input[name='start']").val();
                    var date = new Date();
                    var _end = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDay();
                    var end = $("#form_<?php echo $id?> input[name='end']").val();
                    if (end == _end){
                        Core.error('代理汇总报表不支持查询今日数据');
                        return false;
                    }
                    if (tj_txt == '' && start != '' && end != '' && Core.limitDay(start, end, 60)){
                        Core.error('查詢區間限制為兩個月');
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
    if (typeof(show_user) !== 'function') {
        var show_user = function(id){
            Core.dialog('會員信息','member/edit_member?id='+id,function(){},true,70);
        }
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
</script>