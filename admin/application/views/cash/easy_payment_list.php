<?php $id="form_".uniqid();?>
<form class="form-horizontal" role="form" method="post" action="#" style="height:400px;width:100%">
    <table id="<?php echo $id;?>" ></table>
</form>
<script>
    $("#<?php echo $id;?>").DataSource({url:'cash/get_payment_list?uid=<?php echo $uid?>',
        fields:[[
            {field:'order_num',     title:'訂單號',width:150,sortable:false},
            {field:'leve_name',   title:'層級', align:'center', width:80, sortable:true},
            {field:'user_name',title:'會員賬號',align:'center', width:100,sortable:true},
 //           {field:'agent_name',   title:'所屬代理', align:'center', width:80, sortable:true},
            {field:'balance',  title:'賬戶余額', align:'center', width:80,  sortable:true,
                styler:function(v){
                    return v<=0?'color:#FF0000;':'';
                }
            },
            {field:'is_first',title:'首次', align:'center', width:50,  sortable:true,formatter:function(v, r){
                if(r.is_first == 1){
                    return '<span style="color:red">是</span>';
                }else{
                    return '否';
                }
            }},
            {field:'price',    title:'提款金額', align:'center', width:80,sortable:true},
            {field:'hand_fee', title:'手續費', align:'center', width:80, sortable:true},
            {field:'admin_fee',  title:'行政費',align:'center', width:80,  sortable:true},
            {field:'is_pass',  title:'稽核', align:'center',width:60,  sortable:true,formatter:function(v, r){
                if(r.status == 1){
                    return '稽核';
                }else{
                    return '-';
                }
            }},
            {field:'actual_price',title:'實際出款金額',align:'center',width:90, sortable:true,
                styler:function(v){
                    return v>=0?'background:#F8F8F8;color:#FF0000;':'';
                }
            },
            {field:'status',  title:'狀態', align:'center', width:220,  sortable:true, formatter:function(v, r){
                var str = '';
                if (r.status == '2') {
                    str += '<span class="label label-success">已出款</span>';
                } else if (r.status == '5') {
                    str += '<span class="label label-danger">已取消</span>';
                } else if (r.status == '4') {
                    str += '<span class="label label-primary">正在出款</span>';
                } else if(r.status == '3'){
                    str += '<span class="label label-warning">已拒絕</span>';
                } else if(r.status == '1'){
                    str += '<span class="label label-info">未處理</span>';
                }
                return str;
            }},
            {field:'admin_name',  title:'操作者', align:'center', width:80},
            {field:'from_way',title:'來源', align:'center', width:35,formatter:function(v){
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
            {field:'addtime',  title:'出款日期',align:'center', width:130,  sortable:true},
            {field:'remark',  title:'備註', align:'left', width:550},
        ]], tools:[
            {instant:false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                Core.ExportJs($("#<?php echo $id;?>"),'出款管理');
            }},
            <?php }?>
            {type:'combobox',text:'狀態',width:80,name:'status',value:'', items:'<option value="" selected>全部</option><option value="1">未確認</option><option value="2">已確認</option><option value="3">已拒絕</option><option value="4">預備出款</option><option value="5">已取消</option>'},
            {type:'datebox', text:'日期',   width:100,name:'time_start'},
            {type:'datebox', text:'-',     width:100,name:'time_end'},
            {type:'textbox', text:'金額',   width:50,name:'price_start'},
            {type:'textbox', text:'-',     width:50,name:'price_end'},
            {type:'combobox',text:'出款來源',width:80,name:'froms',value:'', items:'<option value="">全部</option><option value="1">IOS端</option><option value="2">Android端</option><option value="3">PC端</option><option value="4">WAP</option><option value="5">未知</option>'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='time_start']").val();
                var end = $("#form_<?php echo $id?> input[name='time_end']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }}
        ],
        edit:true,
        footer:true,
        checkbox:false
    });
</script>