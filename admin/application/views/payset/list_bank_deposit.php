<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_bank_deposit_list<?php echo "?bankCard=".$bankCard;?>',
        fields:[[
            {field:'order_num',title:'訂單號',align:'left',width:140,sortable:false},
            {field:'leve_name',title:'層級',align:'center',width:90,sortable:true},
            {field:'loginname',title:'會員帳號',align:'center',width:80,sortable:true},
            {field:'loginname',title:'所屬代理',align:'center',width:80,sortable:true},
            {field:'deposit_info',title:'存款人與時間',align:'left',width:160,sortable:true,formatter:function(v,r) {
                if (!r.loginname) {
                    return '筆數：' + r.total;
                }
                return '存款人:' + r.user_name + '<br/>時間:' + r.addtime;
            }},
            {field:'have_in',title:'存入金額與優惠',align:'left',width:180,sortable:true,formatter:function(v,r){
                if (!r.loginname) {
                    return '存入金額:' + r.price + '<br/>存款/優惠:' + r.discount_price;
                }
                return '存入金額:' + r.price + '<br/>存款/優惠:' + r.total_price + '/' + r.discount_price + '<br/>銀行:' + r.bank_name + '<br/>方式:' + r.bank_style;
            }},
            {field:'total_in',title:'存入總額與備註',align:'left',width:150,sortable:true,formatter:function(v,r){
                if (!r.loginname) {
                    return '存入總金額:' + r.total_price;
                }
                if( r.confirm == 0){
                        return '確認碼: - <br/>' +'存入總額:' + r.total_price + '<br/>備註:' + r.remark;
                    }else{
                        return '確認碼:'+ r.confirm +'<br/>存入總額:' + r.total_price + '<br/>備註:' + r.remark;
                    }
            }},
            {field:'bank_account',title:'存入銀行帳戶',align:'left',width:190,sortable:true,formatter:function(v,r) {
                if (!r.loginname) {
                    return null;
                }
                return '卡主:' + r.card_name + '<br/> 卡號:' + r.card_num + '<br/>' + '銀行:' + r.bank_name;
            }},
            {field:'status',title:'狀態',align:'center',width:150,sortable:true,formatter:function(v,r){
                if (!r.loginname) {
                    return null;
                }
                var str = '';
                if (r.status == '2') {
                    str += '<span class="label label-success">已確認</span>';
                } else if (r.status == '3') {
                    str += '<span class="label label-danger">已取消</span>';
                } else {
                    str += '<a onclick=deposit_cancel(' + r.id + ');><span class="btn label label-default">取消存款</span></a>&nbsp;' +
                        '<a onclick=deposit_confirm(' + r.id + ');><span class="btn label label-primary">確認入款</span></a>&nbsp;';
                }
                return str;
            }},
            {field:'is_first',title:'首存',align:'center',width:40,sortable:true,formatter:function(v,r) {
                if (!r.loginname) {
                    return null;
                }
                return r.is_first == '1' ? '<span style="color:red">是</span>' : '否';
            }},
            {field:'admin_name',title:'操縱者',align:'center',width:75,sortable:true},
            {field:'from_way',title:'來源',align:'center',width:35,formatter:function(v){
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
            {field:'update_time',title:'時間',align:'left',width:140,sortable: true}
        ]], tools:[
            {instant:false},
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
               Core.ExportJs($("#<?php echo $id;?>"),'銀行存款記錄');
            }},
            <?php //if(in_array('ADD',$auth)){?>
//            {text:"新增入款銀行",iconCls:"icon-add",handler:function(){
//                $('#<?php //echo $id?>//').DataSource('add',{title:'新增銀行卡',get:'payset/edit_bank',full:false});
//            }},
            <?php //}?>
            {type:'datebox', text:'日期', width:100,name:'time_start'},
            {type:'datebox', text:'-', width:100,name:'time_end'},
            {type:'textbox', text:'訂單號', width:150,name:'f_ordernum'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }}
        ],
        checkbox:false,
        success:function(){

        }
    });
</script>