<div class="itlist">
    <button type="button" class="btn btn-danger" onclick="Core.addTab('视讯註單','order/sxlist','',1)">AG视讯</button>
    <button type="button" class="btn btn-link" sn="dg">DG视讯</button>
</div>
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    var ctg = '<?php echo $ctg?>';
    $("#<?php echo $id;?>").DataSource({url:'order/getsxlist',
        fields:[[
            {field:'bet_time',     title:'投註時間',align:'center', width:140,sortable:false},
            {field:'bill_no',      title:'注單號',align:'center',   width:140,sortable:false},
            {field:'table_code',   title:'桌號',align:'center',     width:100,sortable:false},
            {field:'b',            title:'遊戲ID',align:'center',   width:90,sortable:false},
            {field:'data_type',    title:'下注結果',align:'center',  width:100,sortable:false},
            {field:'username',     title:'系統賬號',align:'center',  width:120,sortable:false},
            {field:'username',     title:'視訊賬號',align:'center', width:140,sortable:false},
            {field:'login_ip',     title:'投注IP',align:'center', width:100,sortable:false},
            {field:'bet_amount',   title:'總投注',align:'center', width:120,sortable:false},
            {field:'valid_betamount', title:'有效投注',align:'center', width:120,sortable:false},
            {field:'result',     title:'結果',align:'center', width:120,sortable:false,
                styler:function(v){
                    return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                }
            },
            {field:'device_type', title:'來源',align:'center', width:40,sortable:false,formatter:function(v){
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
            }}
        ]], tools:[
            {instant:false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                Core.ExportJs($("#<?php echo $id;?>"),'視訊注單');
            }},
            <?php }?>
            {text:"明細",iconCls:"icon-edit",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                $('#<?php echo $id?>').DataSource('edit',{title:'查看註單明細',get:'order/detail?order_num='+ d.order_num+'&account='+d.account,full:60});
            }},
            {type:'combobox',text:'類型',width:95,name:'gid',value:'',
                items:'<option value="">全部平台<option><?php foreach($games as $v){?><option value="<?php echo $v['id']?>"><?php echo $v['name']?></option><?php }?>'
            },
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'datebox', text:'日期', width:100,name:'from_time'},
            {type:'datebox', text:'-', width:100,name:'to_time'},
            {type:'textbox', text:'注單號', width:150,name:'order_num'},
            {type:'textbox', text:'帳號', width:120,name:'account'},
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
        $.messager.confirm('溫馨提示', '確定撤消'+account+'的注單:' + order_num, function(r){
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

</script>