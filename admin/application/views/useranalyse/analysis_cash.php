<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'useranalyse/get_analysis_cash?<?php echo $skip; ?>',
        fields:[
            [
                {field:'username',title:'會員賬號',rowspan:2,align:'center',width:100,sortable:true},
                {title:'公司入款',colspan:3},
                {title:'線上入款',colspan:3},
                {title:'人工入款',colspan:3},
                {title:'彩豆充值',colspan:2},
                {title:'人工出款',colspan:2},
                {title:'線上出款',colspan:2},
                {title:'註冊',colspan:1},
                {title:'紅包/VIP晋级',colspan:2}
            ],
            [
                {field:'agent_user_name',title:'上级代理账号',width:90,align:'center',sortable:true},
                {field:'in_company_total',title:'總金額',width:105,align:'center',sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'in_company_discount',title:'優惠金額',width:90,align:'center',sortable:true},
                {field:'in_company_num',title:'筆數',width:50,align:'center'},

                {field:'in_online_total',title:'總金額',width:105,align:'center',sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'in_online_discount',title:'優惠金額',width:90,align:'center',sortable:true,},
                {field:'in_online_num',title:'筆數',width:50,align:'center'},

                {field:'in_people_total',title:'總金額',width:105,align:'center',sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'in_people_discount',title:'優惠金額',width:90,align:'center',sortable:true},
                {field:'in_people_num',title:'筆數',width:50,align:'center'},

                {field:'in_card_total',title:'總金額',width:105,align:'center',sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'in_card_num',title:'筆數',width:50,align:'center'},

                {field:'out_people_total',title:'總金額',width:105,align:'center',sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'out_people_num',title:'筆數',width:50,align:'center'},

                {field:'out_company_total',title:'總金額',width:105,align:'center',sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'out_company_num',title:'筆數',width:50,align:'center'},
                {field:'in_register_discount',title:'註冊優惠金額',align:'center',width:100,sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'activity_total',title:'活動優惠金額',width:100,align:'center'},
                {field:'activity_num',title:'優惠活動筆數',width:100,align:'center'}
            ]


        ], tools:[
            {instant:false},
            <?php if(in_array('EDIT',$auth)){?>
                {text:"編輯",iconCls:"icon-edit",handler:function(){
                    $('#<?php echo $id?>').DataSource('edit',{
                        title:'查看會員',
                        get:'member/edit_member?auth=<?php echo implode(',',$auth)?>',
                        full:70});
                }},
            <?php }?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'出入款分析');
            }},
//            {type:'textbox', text: '所屬代理', width: 120, name: 'agent_name'},
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
        success:function(){
            Core.agentLog('<?php echo $id?>');
//            $('.datagrid-header-row')[0].cells[1].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[0].cells[2].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[0].cells[3].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[0].cells[4].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[0].cells[5].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[0].cells[6].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[0].cells[7].bgColor = '#f1f2fe'
//
//            $('.datagrid-header-row')[1].cells[0].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[1].cells[1].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[1].cells[2].bgColor = '#f1f2fe'
//
//            $('.datagrid-header-row')[1].cells[3].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[1].cells[4].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[1].cells[5].bgColor = '#fff3ec'
//
//            $('.datagrid-header-row')[1].cells[6].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[1].cells[7].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[1].cells[8].bgColor = '#f1f2fe'
//
//            $('.datagrid-header-row')[1].cells[9].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[1].cells[10].bgColor = '#fff3ec'
//
//            $('.datagrid-header-row')[1].cells[11].bgColor = '#f1f2fe'
//            $('.datagrid-header-row')[1].cells[12].bgColor = '#f1f2fe'
//
//            $('.datagrid-header-row')[1].cells[13].bgColor = '#fff3ec'
//            $('.datagrid-header-row')[1].cells[14].bgColor = '#fff3ec'
//
//            $('.datagrid-header-row')[1].cells[15].bgColor = '#f1f2fe'
        }
    });
</script>