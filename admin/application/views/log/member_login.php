<!-- 會員登陸 -->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'log/get_member_login_list',
        fields:[
            [
                {field:'id',        title:'ID', align:'center',width:60,sortable:true},
                {field:'gcurl',       title:'網址',width:200,sortable:true},
                {field:'username',  title:'賬號',width:150,align: 'center',sortable:false},
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
                {field:'content',   title:'訊息',width:250,align: 'center',sortable:false},
                {field:'addtime',   title:'註冊時間',width:150, align: 'center', sortable:false},
                {field:'login_time',title:'登入時間',width:150, align: 'center', sortable:false},
                {field:'ip',        title:'IP位置',width:150, align: 'center', sortable:false,formatter:function(v){
                    return '<span onclick="get_ip_location(\''+v+'\')"><u>'+v+'</u></span>';
                }},
                {field:'is_black',  title:'是否IP黑名單',width:100, align: 'center', sortable:false,formatter:function(v){
                    return v == 1 ? '<span style="color: red">是</span>' : '否';
                }},
                {field:'op',        title:'操作',width:150, align: 'center', sortable:false,formatter:function(v, r){
                    var s = '';
                    if (r.is_black != 1) {
                        s = '<span class="btn label label-warning" onclick="add_member_login_black(\''+r.ip+'\')">添加到IP黑名單</span>';
                    } else {
                        s = '<span class="btn label label-success" onclick="del_member_login_black(\''+r.ip+'\')">移除IP黑名單</span>';
                    }
                    return s;
                }}
            ]
        ], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'會員登錄');
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
    
    function get_ip_location(ip) {
        var type = 1; // type等于1用百度接口，0 用淘宝接口
        $.get(WEB+'log/get_ip_location',{ip:ip,type:type},function(json){
            var c = JSON.parse(json);
            if (type == 1) {
                if (c.status == 0 && c.content != undefined) {
                    Core.ok(ip + '的IP地址是：' + c.content.address);
                } else {
                    Core.error('獲取IP地址失敗，請通過網絡查詢該IP地址');
                }
            } else {
                if (c.code == 0) {
                    Core.ok(ip + '的IP地址是：'+c.data.country+' '+c.data.area+' '+c.data.region+' '+c.data.city+' '+c.data.isp);
                } else {
                    Core.error('獲取IP地址失敗，請通過網絡查詢該IP地址');
                }
            }
        });
    }

    function add_member_login_black(ip) {
        $.post(WEB+'log/add_member_login_black',{ip:ip},function(json){
            var c = JSON.parse(json);
            if (c.status == 'OK') {
                $('#<?php echo $id?>').datagrid('reload');
            } else {
                Core.error('添加IP黑名單失敗');
            }
        });
    }

    function del_member_login_black(ip) {
        $.post(WEB+'log/del_member_login_black',{ip:ip},function(json){
            var c = JSON.parse(json);
            if (c.status == 'OK') {
                $('#<?php echo $id?>').datagrid('reload');
            } else {
                Core.error('移除IP黑名單失敗');
            }
        });
    }
</script>