<?php $id = "form_" . uniqid(); ?>
<form class="form-horizontal validate" role="form" method="post" action="#" style="height:400px;width:100%">
<table id="<?php echo $id; ?>"></table>
</form>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'member/get_agent_user_list?id=<?php echo $uid; ?>',
        fields: [[
            {field: 'id', title: 'ID', align: 'center', width: 80, sortable: true},
            {field: 'username', title: '用戶名', align: 'center', width: 100, sortable: true},
            {field: 'balance', title: '系統額度', align: 'center', width: 100,sortable: false},
            {field: 'addtime', title: '新增日期', width: 150, align: 'center', sortable: false}

        ]], tools: [
            {instant: false}
        ],
        edit: true,
        checkbox: false
    });
</script>