<!-- 會員統計 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'useranalyse/get_member_statistics_list',
        fields:[
            [
                {field:'bank_name',title:'姓名',align:'center',width:60,sortable:true},
                {field:'username',title:'會員賬號',align:'center',width:100,sortable:true},
                {field:'addtime',title:'註冊時間',align:'center',width:130,sortable:true},
                {field:'login',title:'最後登錄/IP', align:'center', width:240,  sortable:true},
                {field:'login_num',title:'登錄次數',align:'center',width:60,sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'in_t_num',title:'存款次數',align:'center',width:60,sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'in_t_totl',title:'存款總額',align:'center',width:140,sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'max_in',title:'最大存款', align:'center', width:140,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                },
                {field:'out_t_num',title:'提款次數',align:'center',width:60,sortable:true},
                {field:'out_t_totl',title:'提款總額',align:'center',width:140,sortable:true,
                    styler:function(v){
                        return v<=0?'color:#009900;':'color:#FF0000;';
                    }
                },
                {field:'max_out',title:'最大提款',align:'center',width:140,sortable:true},
                {field:'profit',title:'盈利', align:'center', width:140,  sortable:true,
                    styler:function(v){
                        return v<=0?'color:#FF0000;':'color:#009900;';
                    }
                }
             ]
       ], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'會員統計');
            }},
            {type:'combobox',text:'層級',width:40,name:'level_id',value:'', items:'<option value="">所有記錄</option><?php foreach($level as $v){echo "<option value=$v[id]>$v[level_name]</option>"; }?>'},
//            {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'datebox', text:'日期', width:100,name:'start'},
            {type:'datebox', text:'-', width:100,name:'end'},
            {type:'textbox', text:'會員賬號', width:120,name:'username'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start']").val();
                var end = $("#form_<?php echo $id?> input[name='end']").val();
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
            $('#<?php echo $id?>').pagination({layout:['links','last'],showRefresh:false});
        }
    });

</script>