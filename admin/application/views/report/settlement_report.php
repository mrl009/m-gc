<!-- 彩票報表 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'report/get_search_report_list?time_start=<?php echo $time_start. '&time_end='.$time_end .'&form_type=' .$form_type. '&level_id=' .$level_id. '&username=' .$username. '&gid=' .$gid. '&agent_id=' .$agent_id;?>',
        fields:[
            [
                {field:'name',title:'會員名稱',rowspan:2,align:'center',width:130,sortable:false},
                {field:'total_num',title:'總筆數',rowspan:2,align:'center',width:85,sortable:true},
                {field:'bets_num',title:'註單量',rowspan:2,align:'center',width:85,sortable:true},
                {field:'total_price',title:'總下註',rowspan:2,align:'center',width:130,sortable:true},
                {field:'valid_price',title:'總下註有效金額',rowspan:2, align:'center', width:130,  sortable:true},
                {field:'return_price',title:'返水',rowspan:2,align:'center',width:130,  sortable:true,
                    styler:function(v){
                        return v>0?'background-color:#F8F8F8;color:#009900;':'';
                    }
                },
                {field:'lucky_price',title:'總派彩', rowspan:2,align:'center', width:130,  sortable:true},
                {field:'diff_price',title:'會員實際盈虧',rowspan:2,align:'center',width:130,  sortable:true,
                    styler:function(v){
                        return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                    }
                },
                {title:'公司交收(紅色代表虧損,綠色代表盈利,反水沒有計算到盈虧1)',colspan:3,align:'center',width:130, sortable:true}
             ],[
                {field:'cor_valid_price',title:'總有效下註',align:'center',width:120,  sortable:false},
                // {field:'cor_return_price',title:'公司返水',align:'center',width:120,  sortable:false,
                //     styler:function(v){
                //         return v<0?'background-color:#F8F8F8;color:#FF0000;':'';
                //     }
                // },
                {field:'cor_lucky_price',title:'公司派彩',align:'center',width:120,  sortable:false},
                {field:'cor_diff_price',title:'公司實際盈虧',align:'center',width:120,  sortable:false,
                    styler:function(v){
                        return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                    }
                }
            ]

       ], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'會員報表');
            }},
            {text:"進入",iconCls:"icon-edit",handler:function(){
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                if(d==null){
                    Core.error('請選擇要進入');
                    return false;
                }
                //Core.addTab('彩票報表', 'report/classify_report?time_start=<?php $form_type=$form_type==1?2:1; echo $time_start. '&time_end='.$time_end .'&form_type=' .$form_type. '&level_id=' .$level_id.'&username=' .$username.'&agent_id=' .$agent_id. '&uid=';?>'+d.uid);
                Core.addTab('彩票註單', 'order/index?from_time=<?php echo $time_start. '&to_time='.$time_end. '&uid=';?>'+d.uid);
                //Core.closeTab('會員報表');
            }},

            {text:"返回", iconCls:"icon-back",handler:function(){
                Core.addTab('報表', 'report/index');
            }},
        '-'
        ],
        checkbox:false,
        edit:true,
        footer:true
    });
</script>
