<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'useranalyse/get_bet_list',
        fields:[
            [
                {field:'username', title:'會員賬號', align:'center',width:120,sortable:true},
                {field:'agent_name', title:'上級代理', align:'center',width:120,sortable:true},
                {field:'total_price',title:'總投註',align:'center', width:150, sortable:true},
                {field:'valid_price',title:'有效投註', align:'center',width:150, sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'lucky_price',title:'總派彩', align:'center' , width:150, sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'total_num',title:'總註數', align:'center', width:150,  sortable:true,},
                {field:'total_win_num',title:'贏（註）', align:'center',width:150,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'total_lose_num',title:'輸（註）', align:'center', width:150,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'win_lose_rate',title:'勝率', align:'center',width:80,  sortable:true},
                {field:'level', title:'等級', align:'center',width:60,sortable:false},
                {field:'diff_price', title:'結果', align:'center',width:120,sortable:false,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'addtime',title:'注册时间', align:'center',width:150,sortable:false}
            ]

        ], tools:[
            {instant:false},
            // <?php //if(in_array('ADD',$auth)){?>
            // {text:"新增層級",iconCls:"icon-add",handler:function(){
            //     $('#<?php //echo $id?>').DataSource('add',{title:'新增層級',get:'level/edituser?>',full:true});
            // }},
            // <?php //}?>  //為什麽放個新增層級這裏?
               {text:'導出',iconCls:'icon-large-chart',handler:function(){
                   Core.ExportJs($("#<?php echo $id;?>"),'下註分析');
                }},
                {type:'combobox',text:'類型',width:100,name:'games',value:'', items:'<option value="">全部</option><?php foreach($games as $k =>$v){echo "<option value=$k>$v</option>"; }?>'},
 //               {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
                {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
                {type:'datebox', text:'日期', width:100,name:'time_start'},
                {type:'datebox', text:'-', width:100,name:'time_end'},
                {type:'textbox', text:'會員賬號', width:120,name:'f_username'},
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

    function edit_pay_type()
    {
        Core.dialog('支付設定','level/pay_set',function(){},true,false);
    }
</script>