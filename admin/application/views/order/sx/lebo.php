<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'order/get_lebo',
        fields:[[
            {field:'start_time',       title:'投註時間',align:'center', width:140,sortable:false},
            {field:'round_no',      title:'注單號',align:'center', width:180,sortable:false},
            {field:'game_id',   title:'游戲號',align:'center', width:100,sortable:false},
            //{field:'game_type',    title:'遊戲ID',align:'center', width:90,sortable:false},
            //{field:'data_type',    title:'下注結果',align:'center',  width:100,sortable:false},
            {field:'gcuser',     title:'系統賬號',align:'center',  width:120,sortable:false},
            {field:'user_name',     title:'視訊賬號',align:'center', width:140,sortable:false},
            //{field:'login_ip',     title:'投注IP',align:'center', width:100,sortable:false},
            {field:'total_bet_score',   title:'總投注',align:'center', width:120,sortable:false},
            {field:'valid_bet_score_total', title:'有效投注',align:'center', width:120,sortable:false},
            {field:'total_win_score',     title:'結果',align:'center', width:120,sortable:false,
                styler:function(v){
                    return v<=0?'background-color:#F8F8F8;color:#FF0000;':'background-color:#F8F8F8;color:#009900;';
                }
            }
        ]], tools:[
            {instant:false},
            {type:'textbox', text:'注單號', width:150,name:'bill_no'},
            {type:'textbox', text:'会员名', width:150,name:'username'},
            {type:'datebox', text:'日期', width:100,name:'start_time'},
            {type:'datebox', text:'-', width:100,name:'end_time'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start_time']").val();
                var end = $("#form_<?php echo $id?> input[name='end_time']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        footer:true,
        checkbox:false
    });
</script>