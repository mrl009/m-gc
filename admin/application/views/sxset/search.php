<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'sxset/get_rebate_report_list',
        fields:[
            [
                {field:'id',title:'ID',align:'center',width:30,sortable:false},
                {field:'event',title:'事件',align:'center',width:300,sortable:false,formatter:function(v, r){
                        return r.start_date + '~' + r.end_date;
                }},
                {field:'start_date',title:'返水區間(起)',align:'center',width:150,sortable:true},
                {field:'end_date',title:'返水區間(迄)',align:'center',width:150,sortable:true},
                {field:'bets_num',title:'人數/金額',align:'center',width:150,sortable:true,formatter:function(v, r){
                        return r.sum + '/' + r.total;
                }},
                {field:'createtime',title:'創建日期',align:'center',width:150,sortable:true,formatter:function(v){
                        return date('Y-m-d H:i:s', v);
                }},
                {field:'createadmin',title:'創建者',align:'center',width:80,sortable:true},
                {field:'dmlbs',title:'综合打码倍数',align:'center',width:100,sortable:true},
                {field:'op',title:'查詢明細',align:'center',width:60,formatter:function(v, r){
                    return '<a href="#" onclick="rebateDetail('+r.id + ',' + '\'' + r.start_date+'\')">明细</a>';
                }}
             ]
       ], tools:[
            {instant:false},
            {type:'datebox', text:'开始日期', width:98,name:'start'},
            {type:'datebox', text:'结束日期', width:98,name:'end'},
            {type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
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
        footer:true
    });

    function rebateDetail(rebate_id, time) {
        Core.closeTab('优惠明细');
        Core.addTab('优惠明细', 'sxset/rebate_detail?rebate_id=' + rebate_id + '&time=' + time);
    }
</script>