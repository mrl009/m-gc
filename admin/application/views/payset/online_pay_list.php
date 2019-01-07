<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_online_pay_list<?php echo "?payId=".$payId;?>',
        fields:[[
            {field:'order_num',title:'訂單號',align:'left',width:140,sortable: false},
            {field:'leve_name',title:'層級',align:'left',width:100,sortable: true},
            {field:'user_name',title:'會員帳號',align:'left',width:80,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return '筆數：' + r.total;
                }
                return r.user_name;
            }},
            {field:'income_info',title:'存款金額',align:'left',width:180,sortable:true,formatter:function(v,r){
                    return '存入金額：' + r.price + '<br/>存款/其他優惠：' + r.discount_price;
            }},
            {field:'total_price',title:'存入總額',align:'left',width:180,ortable:true,formatter:function(v,r){
                    return '存入總額：' + r.total_price;
            }},
            {field:'status',title:'狀態',align:'center',width:200,sortable:true,formatter:function(v,r){
                var str = '';
                if (r.status == 1) {
                    str += '<a onclick=income_cancel(' + r.id + ');><span class="btn label label-danger">不再提示</span></a>&nbsp;' +
                        '<a onclick=income_confirm(' + r.id + ');><span class="btn label label-success">確認入款</span></a>&nbsp;';
                } else if (r.status == 2) {
                    str = '<span class="label label-success">已支付</span>';
                } else if (r.status == 3) {
                    str = '<span class="label label-danger">已取消</span>';
                }
                return str;
            }},
            {field:'pay_type',title:'存入銀行帳戶',align:'center',width:150,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return null;
                }
                return r.pay_name;
            }},
            {field:'is_first',title:'首存',align:'center',width:80,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return null;
                }
                return r.is_first == '1' ? '<span style="color:red">是</span>' : '否';
            }},
            {field:'admin_name',title:'操作者',align:'left',width:80,sortable:true},
            {field:'from_way',title:'來源',width:35,formatter:function(v){
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
            {field: 'datetime',title:'時間',align:'left',width:200,sortable:true,formatter:function(v,r){
                if (!r.user_name) {
                    return null;
                }
                return '系統時間：' + r.addtime + '<br/>操作時間：' + r.update_time;
            }}
        ]], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'線上支付存款記錄');
            }},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增入款銀行",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增銀行卡',get:'payset/edit_bank',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'查看會員',get:'member/edituser?type=<?php echo $type?>',full:false});
            }},
            <?php }?>
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