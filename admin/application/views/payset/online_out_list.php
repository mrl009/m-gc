<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_online_out_list<?php echo "?outId=".$outId;?>',
        fields:[[
            {field:'order_num',title:'訂單號',align:'left',width:140,sortable: false},
            {field:'user_name',title:'會員帳號',align:'left',width:80,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return '筆數：' + r.out_online_num;
                }
                return r.user_name;
            }},
            {field:'income_info',title:'出款金額',align:'left',width:180,sortable:true,formatter:function(v,r){
                    return '出款金額：' + r.price;
            }},
            {field:'status',title:'狀態',align:'center',width:200,sortable:true,formatter:function(v,r){
                var str = '';
                if (r.status == 1) {
                    str += '<a onclick=income_cancel(' + r.id + ');><span class="btn label label-danger">不再提示</span></a>&nbsp;' +
                        '<a onclick=income_confirm(' + r.id + ');><span class="btn label label-success">確認出款</span></a>&nbsp;';
                } else if (r.status == 2) {
                    str = '<span class="label label-success">已出款</span>';
                } else if (r.status == 3) {
                    str = '<span class="label label-danger">出款失败</span>';
                }
                return str;
            }},
            {field:'out_type',title:'出款第三方',align:'center',width:150,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return null;
                }
                return r.out_name;
            }},
            {field:'admin_name',title:'操作者',align:'left',width:80,sortable:true},
            {field: 'datetime',title:'時間',align:'left',width:200,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return null;
                }
                return '系統時間：' + r.addtime + '<br/>操作時間：' + r.updated;
            }}
        ]], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'線上出款記錄');
            }},
            {type:'datebox', text:'日期', width:100,name:'time_start'},
            {type:'datebox', text:'-', width:100,name:'time_end'},
            {type:'textbox', text:'訂單號', width:150,name:'f_ordernum'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }},
        ],
        checkbox:false,
        footer:true,
        edit:true,
        success:function(){

        }
    });
</script>