<!--<div class="itlist" style="height: 30px;">-->
<!--    <button type="button" class="btn btn-link" onclick="Core.addTab('视讯註單','order/sxlist','',1)">AG视讯</button>-->
<!--    <button type="button" class="btn btn-danger" sn="dg" onclick="Core.addTab('视讯註單','order/dglist','',1)">DG视讯</button>-->
<!--</div>-->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'order/get_dg',
        fields:[[
            {field:'sx_id',       title:'游戏编号',align:'center', width:140,sortable:false},
            {field:'lobbyId',      title:'游戏大厅',align:'center', width:140,sortable:false,
                formatter:function(v){
                    return v==1?'旗舰厅':'竞咪厅';
                }
            },
            {field:'tableId',   title:'台桌名称',align:'center', width:100,sortable:false},
            {field:'calTime',   title:'结算时间',align:'center', width:150,sortable:false},
            {field:'platUsername',    title:'用户名',align:'center', width:90,sortable:false},
            {field:'userName',     title:'游戏账号',align:'center',  width:120,sortable:false},
            {field:'result',     title:'游戏结果',align:'center', width:140,sortable:false},
            {field:'betPoints',     title:'下注金额',align:'center', width:100,sortable:false},
            {field:'availableBet',   title:'有效下注金额',align:'center', width:120,sortable:false},
            {field:'resultMoney',     title:'結果',align:'center', width:120,sortable:false,
                styler:function(v){
                    return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                }
            }
        ]], tools:[
            {instant:false},
            // {type:'combobox',text:'類型',width:95,name:'gid',value:'',
            //     items:'<option value="">全部平台<option>'
            // },
            {type:'textbox', text:'注單號', width:150,name:'sx_id'},
            {type:'textbox', text:'会员名', width:150,name:'username'},
            {type:'datebox', text:'日期', width:100,name:'start_time'},
            {type:'datebox', text:'-', width:100,name:'end_time'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start_time']").val();
                var end = $("#form_<?php echo $id?> input[name='end_time']").val();
                var start_a = start.split('-');
                var end_a = end.split('-');
                if (start != '' && end !='' && start_a[0] != end_a[0]){
                    Core.error('请不要跨月查询');
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
            //$('.datagrid-view').height($('.datagrid-wrap').height()-110);
        }
    });
</script>