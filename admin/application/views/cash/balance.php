<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_balance_list?type=<?php echo $type?>',
        fields:[[
            {field:'balance',title:'遊戲額度',width:200, align:'center',sortable:false},
            {field:'enable',title:'啟用',      width:200, align:'center',sortable:true},
            {field:'disable',title:'停用',      width:200, align:'center',sortable:true},
            {field:'update_time',title:'更新時間',   width:200, align:'center', sortable:true},
            {field:'op',title:'操作', width:200,align:'center',sortable:false,formatter:function(v,r){
                return '<a herf="#" class="btn btn-danger btn-xs" onclick=udpate_balance(this)>立即更新</a>&nbsp;&nbsp;';
            }}
        ]],
        tools:[],
        checkbox:false
    });

    function udpate_balance(obj)
    {
        var refresh = 1;
        var url = 'cash/ajax_balance';

        $.ajax({
            url: url,// 跳轉到 action
            data: {
                refresh: refresh
            },
            type: 'post', //用post方法
            cache: false,
            dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
            success: function (data) {
                Core.ok('更新成功');
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                Core.error('異常'+XMLHttpRequest.status+' '+textStatus);
            }
        });
    }
</script>

