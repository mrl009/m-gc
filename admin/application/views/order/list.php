<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    var ctg = '<?php echo $ctg?>';
    $("#<?php echo $id;?>").DataSource({url:'order/getlist<?php echo '?ctg='.$ctg;?><?php echo '&from_time='.$from_time.'&to_time='.$to_time;?><?php echo $uid ? '&uid='.$uid : '';?>',
        fields:[[
            {field:'game',          title:'彩種',align:'center', width:75,sortable:false},
            <?php if ($ctg == 'gc') {?>
            {field:'issue',         title:'期數',align:'center', width:90,sortable:false},
            <?php }else{?>
            {field:'issue',         title:'期數',align:'center', width:100,sortable:false,formatter:function(v, r){
                    if (r.status == undefined) return;
                    if (r.status != 4 && r.status != 3 && r.gid != 3 && r.gid != 4 && r.gid != 24 && r.gid != 25) {
                        return '<span class="label label-danger" onclick="win_content(\''+r.order_num+'\')">'+v+'</span>';
                    }
                    return v;
                }},
            <?php }?>
            {field:'order_num',     title:'訂單號',align:'center', width:140,sortable:false},
            {field:'account' ,      title:'帳號',align:'center',  width:85,sortable:false},
            {field:'agent_name' ,   title:'所屬代理',align:'center',  width:80,sortable:false},
            {field:'tname',         title:'玩法',align:'center', width:140,sortable:false},
            {field:'names',         title:'投註內容',align:'center', width:150,sortable:false},
            {field:'rate',          title:'賠率',align:'center', width:70,sortable:false},
            // {field:'price_return',  title:'返水金額',align:'center', width:60,sortable:false},
            {field:'price_sum',     title:'下註總額',align:'center', width:95,sortable:false},
            {field:'win_price',     title:'中獎金額',align:'center', width:80,sortable:false,formatter:function(v){return v ? v : 0;}},
            {field:'price_diff',    title:'實際輸贏',align:'center', width:80,sortable:false,
                styler:function(v){
                    return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                }
            },
            {field:'op',title:'操作',align:'center', width:55,sortable:false,formatter:function(v, r){
                return r.status=='4' ? '<span class="btn label label-danger" onclick="cancel_order(\''+r.order_num+'\''+',\''+r.account+'\')">撤單</span>' : '-';
            }},
            {field:'status',        title:'狀態',align:'center', width:55,sortable:false,formatter:function(v){
                var r = '';
                if (v == '1') {
                    r='<span class="label label-success">中獎</span>';
                } else if(v == 2) {
                    r='<span class="label label-info">和局</span>';
                } else if(v == 3) {
                    r='<span class="label label-default">撤單</span>';
                } else if(v == 4) {
                    r='<span class="label label-primary">待開獎</span>';
                } else if(v == 5) {
                    r='<span class="label label-danger">未中獎</span>';
                }
                return r;
            }},
            {field:'bet_time',      title:'投註時間',align:'center', width:135,sortable:false},
            {field:'src',           title:'來源',align:'center', width:40,sortable:false,formatter:function(v){
                var r = '';
                if (v == '1') {
                    r = '<i class="fa fa-apple fa-lg"></i>';
                } else if(v == 2) {
                    r = '<i class="fa fa-android fa-lg"></i>';
                } else if(v == 3) {
                    r = '<i class="fa fa-desktop fa-lg"></i>';
                } else if(v == 4) {
                    r = '<i class="fa fa-html5 fa-lg"></i>';
                } else if(v == 5) {
                    r = '<i class="fa fa-info-circle fa-lg"></i>';
                }
                return r;
            }},
            {field:'info_status', title:'追號',align:'center', width:40,sortable:false,formatter:function(v, r){
                if (v == '4') {
                    return r.end_time ? '<span style="color:red">是</span>' : '是'
                } else {
                    return '否'
                }
            }}
        ]], tools:[
            {instant:false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                Core.ExportJs($("#<?php echo $id;?>"),'彩票註單');
            }},
            <?php }?>
            {text:"明細",iconCls:"icon-edit",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                $('#<?php echo $id?>').DataSource('edit',{title:'查看註單明細',get:'order/detail?order_num='+ d.order_num+'&account='+d.account,full:60});
            }},
            {type:'combobox',text:'彩種',width:95,name:'gid',value:'',
                items:'<option value="">全部彩種<option><?php foreach($games as $v){?><option value="<?php echo $v['id']?>"><?php echo $v['name']?></option><?php }?>'
            },
            {type:'combobox',text:'狀態',width:30,name:'status1',value:'', items:'<option value="">全部</option><option value="1">中獎</option><option value="2">和局</option><option value="3">撤單</option><option value="4">待開獎</option><option value="5">未中獎</option>'},
            {type:'textbox', text: '所屬代理', width: 60, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'datebox', text:'日期', width:100,name:'from_time'},
            {type:'datebox', text:'-', width:100,name:'to_time'},
            //{type:'combobox',text:'來源',width:30,name:'src',value:'', items:'<option value="">全部</option><?php //foreach($from_type as $k => $v){echo "<option value=$k>$v</option>"; }?>//'},
            {type:'textbox', text:'註單號', width:130,name:'order_num'},
            {type:'textbox', text:'期數', width:80,name:'issue'},
            {type:'textbox', text:'帳號', width:110,name:'account'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='from_time']").val();
                var end = $("#form_<?php echo $id?> input[name='to_time']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        footer:true,
        checkbox:false,
        success:function(){
            Core.agentLog('<?php echo $id?>');
            $("#status").combobox('setValue',0);
        }
    });
    function cancel_order(order_num,account) {
        $.messager.confirm('溫馨提示', '確定撤消'+account+'的訂單:' + order_num, function(r){
            if (r){
                $.post(WEB+'order/cancel_order',{order_num:order_num,ctg:ctg},function(c){
                    var t = JSON.parse(c)
                    if (t.status == 'OK') {
                        Core.ok('撤消訂單成功')
                        $('#<?php echo $id?>').datagrid('reload');
                    } else {
                        Core.error(t.msg)
                    }
                });
            }
        });
    }
    function win_content(order_num) {
        Core.dialog('开奖情况','order/win_content?order_num='+order_num,function(){},true,false);
    }
</script>