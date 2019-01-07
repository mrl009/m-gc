<!-- 分類報表 -->
<div id="fs_report">
    事件名稱：&nbsp;&nbsp;<input type="text" value="<?php echo $time. '~'. $time?>" name="remark" id="remark" class="za_text" size="30">&nbsp;&nbsp;&nbsp;
              綜合打碼量：&nbsp;&nbsp;<input type="text" name="zhbet" id="normality" class="za_text" style="min-width: 50px; width: 50px">倍&nbsp;&nbsp;&nbsp;
              <input type="submit" name="submit" id="dis_submit" class="za_button" value="存入" onclick="sxRebateSubmit()"><font color="red">【請確認退水比例，一旦存入就以當前退水比例計算，如需重新計算，請沖銷】</font>
</div>
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'sxset/get_sx_rebate_list?time=<?php echo $time. '&level_id=' .$level_id;?>',
        fields:[
            [
                {field:'id',title:'ID',rowspan:2,align:'center',width:60,sortable:false},
                {field:'username',title:'會員',rowspan:2,align:'center',width:130,sortable:false},
                {field:'level',title:'層級',rowspan:2,align:'center',width:85,sortable:true},
                {field:'bet_total',title:'總有效',rowspan:2,align:'center',width:85,sortable:true},
                {title:'有效投注',colspan:4,align:'center',width:130},
                {title:'返點',colspan:4,align:'center',width:130},
                {field:'rebate_total',title:'返點小计',rowspan:2,align:'center',width:85,sortable:true}
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
        ],
        footer:true,
        success:function(){
            $('.datagrid-view').height($('.datagrid-wrap').height()-60);
        }
    });
    
    function sxRebateSubmit() {
        var time = '<?php echo $time?>';
        var zhbet = $("#fs_report input[name='zhbet']").val();
        var d = $("#<?php echo $id;?>").datagrid('getSelections');
        var data = [];
        $.each(d, function (i, x) {
            data.push(x.id + '-' + x.rebate_total)
        })
        if (data.length == 0) {
            Core.error('请选择要存入的会员');
            return false;
        }
        $.messager.confirm('溫馨提示', '確定存入？', function(r){
            if (r){
                $.ajax({
                    url: '/sxset/ajax_rebate_do',
                    data: {
                        time: time,
                        zhbet: zhbet,
                        data: data.join(',')
                    },
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        Core.closeTab('優惠详情');
                    },
                    error: function (data) {
                        Core.error(data.msg);
                    }
                });
            }
        });
    }
</script>
