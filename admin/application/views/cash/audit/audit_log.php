<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_audit_log',
        fields:[[
            {field: 'id', title: '編號', width: 50, sortable: true},
            {field: 'username', title: '會員', width: 130, sortable: false},
            {field: 'content', title: '內容', width: 400, sortable: false},
            {field: 'addtime', title: '更新日期', align: 'center', width: 200, sortable: false}
        ]], tools:[
            {instant:false},
            {type:'datebox', text:'日期', width:100,name:'start_date'},
            {type:'datebox', text:'-', width:100,name:'end_date'},
            {type:'textbox', text:'帳號', width:120,name:'username'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start_date']").val();
                var end = $("#form_<?php echo $id?> input[name='end_date']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        //checkbox:false,
        footer:true,
        success:function(){

        }
    });
</script>