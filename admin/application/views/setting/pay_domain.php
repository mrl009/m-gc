<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'setting/get_site_domain_list',
        fields:[[
            {field:'id',      title:'ID',  align:'center',      width:80,sortable:true},
            {field:'is_main',   title:'主域名',align:'center',      width:150, sortable:true},
            {field:'is_bind',  title:'是否綁定',align:'center',   width:150, sortable:true},
            {field:'domain',  title:'域名',align:'center',   width:150, sortable:true},
            {field:'cname',title:'CNAME',align:'center',    width:150,  sortable:true},
            {field:'add_date',title:'添加日期', align:'center',     width:150,  sortable:true},
            {field:'op',  title:'進行設定',align:'center', width:150, sortable:false,formatter:function(v,r){
                if (r.can_edit) {
                    var str = '<a herf="#" class="btn btn-danger btn-xs" onclick=Core.dialog(\'基本資料設定\',\'payset/edit_pay_setting\',function(){},true,true);>編輯</a>&nbsp;&nbsp;';
//                if (r.can_del) {
                    str += '<a herf="#" class="btn btn-danger btn-xs" onclick="del_domain();">刪除</a>&nbsp;';
//                }
                    return str;
                }
            }}
        ]], tools:[
            {instant:false},
            {text:"API域名",iconCls:"icon-web",handler:function(){
                Core.addTab('API域名', 'setting/site_domain');
            }},
            {text:"支付域名",iconCls:"icon-payment",handler:function(){
                Core.addTab('支付域名', 'setting/pay_domain');
            }},
            {text:"手機域名",iconCls:"icon-payment",handler:function(){
                Core.addTab('支付域名', 'setting/pay_domain');
            }},
            {text:"添加",iconCls:"icon-add", handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'添加站點域名',get:'setting/add_domain',full:false});
            }},
            '|',
            {type:'textbox', text:'域名', width:100,name:'domain'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        footer:true,
        checkbox:false,
        success:function(){

        }
    });

    function del_domain()
    {
        Core.confirm("<?php echo $id;?>",1,"asd","確定刪除該會員嗎?");
    }
</script>