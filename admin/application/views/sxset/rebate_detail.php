<div class="text-center">
    <span>日期：<?php echo $time. ' ~ '. $time?></span>&nbsp;&nbsp;
    <button type="button" class="btn btn-success site_button" onclick="saveCx(<?php echo $rebate_id;?>)">冲销</button>
</div>
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'sxset/get_rebate_detail_list?rebate_id=<?php echo $rebate_id;?>',
        fields:[
            [
                {field:'username',title:'會員',rowspan:2,align:'center',width:130,sortable:false},
                {field:'level',title:'層級',rowspan:2,align:'center',width:85,sortable:true},
                {field:'bet_total',title:'總有效',rowspan:2,align:'center',width:85,sortable:true},
                {title:'有效投注',colspan:4,align:'center',width:130},
                {title:'返點',colspan:4,align:'center',width:130},
                {field:'rebate_total',title:'返點小计',rowspan:2,align:'center',width:85,sortable:true},
                {field:'op',title:'返水状态',rowspan:2,align:'center',width:85,sortable:true,formatter:function(){
                        return '优惠冲销';
                }}
            ],[
                {field:'ag_bet',title:'AG视讯',align:'center',width:120},
                {field:'dg_bet',title:'DG视讯',align:'center',width:120},
                {field:'ky_bet',title:'开元棋牌',align:'center',width:120},
                {field:'lebo_bet',title:'LEBO',align:'center',width:120},
                {field:'ag_rebate',title:'AG视讯',align:'center',width:120},
                {field:'dg_rebate',title:'DG视讯',align:'center',width:120},
                {field:'ky_rebate',title:'开元棋牌',align:'center',width:120},
                {field:'lebo_rebate',title:'LEBO',align:'center',width:120}
            ]
        ], tools:[
            {instant:false},
            '-'
        ],
        footer:true,
        checkbox:false
    });
    function saveCx(rebate_id) {
        var time = '<?php echo $time?>';
        $.messager.confirm('溫馨提示', '确定冲销？', function(r){
            if (r){
                $.ajax({
                    url: '/sxset/ajax_rebate_cx',
                    data: {
                        time: time,
                        rebate_id: rebate_id,
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.closeTab('优惠明细');
                    },
                    error: function (data) {
                        Core.error(data.msg);
                    }
                });
            }
        });
    }
</script>