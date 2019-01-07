<!-- 管理登陸 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'log/get_manage_login_list',
        fields:[
            [
                {field:'id',        title:'ID',align:'center',width:60,sortable:true},
                {field:'gcurl',       title:'網址',width:200,sortable:true},
                {field:'username',  title:'賬號',width:150,align: 'center',sortable:true},
                {field:'from_way',title:'來源',  width:35,align: 'center',formatter:function(v,r){
                    var r = '';
                        if (v == '1') {
                            r = '<i class="fa fa-apple fa-lg"></i>';
                        } else if(v == 2) {
                            r = '<i class="fa fa-android fa-lg"></i>';
                        } else if(v == 3) {
                            r = '<i class="fa fa-desktop fa-lg"></i>';
                        } else if(v == 4) {
                            r = '<i class="fa fa-html5 fa-lg"></i>';
                        } else if(v == 5) {
                            r = '<i class="fa fa-info-circle fa-lg"></i>';
                        }

                    return r;
                }},
                {field:'content',   title:'訊息',width:300,align: 'center',sortable:true},
                {field:'login_time',title:'登入時間',width:180, align: 'center', sortable:true},
                {field:'ip',        title:'IP位置',width:180, align: 'center', sortable:true},
                {field:'is_black',  title:'是否IP黑名單',width:100, align: 'center', sortable:false,formatter:function(v){
                    return v == 1 ? '<span style="color: red">是</span>' : '否';
                }},
                {field:'op',        title:'操作',width:150, align: 'center', sortable:false,formatter:function(v, r){
                    var s = '';
                    if (r.is_black != 1) {
                        s = '<span class="btn label label-warning" onclick="add_manage_login_black(\''+r.ip+'\')">添加到IP黑名單</span>';
                    } else {
                        s = '<span class="btn label label-success" onclick="del_manage_login_black(\''+r.ip+'\')">移除IP黑名單</span>';
                    }
                    return s;
                }}
            ]
        ], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'管理登陸');
            }},
            {type:'datebox', text:'登陸日期', width:100,name:'from_time'},
            {type:'datebox', text:'-', width:100,name:'to_time'},
            {type:'textbox', text:'IP', width:120,name:'ip'},
            {type:'combobox',text:'登陸是否成功',width:40,name:'is_success',value:'', items:'<option value="">全部</option><option value="1">成功</option><option value="2">失敗</option>'},
            {type:'textbox', text:'賬號', width:120,name:'account'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='from_time']").val();
                var end = $("#form_<?php echo $id?> input[name='to_time']").val();
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
            $('#<?php echo $id?>').pagination({layout:['links','last'],showRefresh:false});
        }
    });

    function add_manage_login_black(ip) {
        $.post(WEB+'log/add_manage_login_black',{ip:ip,is_admin:1},function(json){
            var c = JSON.parse(json);
            if (c.status == 'OK') {
                $('#<?php echo $id?>').datagrid('reload');
            } else {
                Core.error('添加IP黑名單失敗');
            }
        });
    }

    function del_manage_login_black(ip) {
        $.post(WEB+'log/del_manage_login_black',{ip:ip,is_admin:1},function(json){
            var c = JSON.parse(json);
            if (c.status == 'OK') {
                $('#<?php echo $id?>').datagrid('reload');
            } else {
                Core.error('移除IP黑名單失敗');
            }
        });
    }
</script>