<?php $id="form_".uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="#" style="height:400px;width:100%">
<table id="<?php echo $id;?>"></table>
</form>
<script>
$("#<?php echo $id;?>").DataSource({url:'order/getlist?uid=<?php echo $uid?>',
    fields:[[
        {field:'game',          title:'彩種',width:75,sortable:false},
        {field:'issue',         title:'期數',width:100,sortable:false},
        {field:'order_num',     title:'訂單號',width:150,sortable:false},
        {field:'account' ,      title:'帳號', width:85,sortable:false},
        {field:'agent_name' ,      title:'所屬代理', width:80,sortable:false},
        {field:'tname',         title:'玩法',width:150,sortable:false},
        {field:'names',         title:'投註內容',align:'center', width:150,sortable:false},
        {field:'price_sum',     title:'下註總額',width:95,sortable:false},
        {field:'win_price',     title:'中獎金額',width:80,sortable:false,formatter:function(v){return v ? v : 0;}},
        {field:'price_diff',    title:'實際輸贏',width:80,sortable:false,
                    styler:function(v){
                        return v<=0?'background-color:#F8F8F8;color:#009900;':'background-color:#F8F8F8;color:#FF0000;';
                    }
                },
        {field:'rate',          title:'賠率',width:60,sortable:false},
        // {field:'price_return',  title:'返水金額',width:60,sortable:false},
        // {field:'rebate',        title:'返水比例',width:55,sortable:false},
        {field:'status',        title:'狀態',width:55,sortable:false,formatter:function(v){
            var r = '';
            if (v == '1') {
                r='<span class="label label-success">中獎</span>';
            } else if(v == 2) {
                r='<span class="label label-info">和局</span>';
            } else if(v == 3) {
                r='<span class="label label-default">撤單</span>';
            } else if(v == 4) {
                r='<span class="label label-primary">待開獎</span>';
            } else if(v == 5) {
                r='<span class="label label-danger">未中獎</span>';
            }
            return r;
        }},
        {field:'bet_time',      title:'投註時間',width:135,sortable:false},
        {field:'src',           title:'來源',width:30,sortable:false,formatter:function(v){
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
        {field:'info_status',title:'追號',width:40,sortable:false,formatter:function(v){
            return v == '4' ? '是' : '否'
        }}
    ]], tools:[
        {instant:false},
        // {text:"註單明細",iconCls:"icon-edit",handler:function(){
        //     var d = $("#<?php echo $id;?>").datagrid('getSelected');
        //     $('#<?php echo $id?>').DataSource('edit',{title:'查看註單明細',get:'order/detail?order_num='+ d.order_num,full:60});
        // }},
        {type:'combobox',text:'彩種',width:90,name:'gid',value:'',
            items:'<option value="">全部彩種<option><?php foreach($games as $v){?><option value="<?php echo $v['id']?>"><?php echo $v['name']?></option><?php }?>'
        },
        {type:'combobox',text:'狀態',width:30,name:'status',value:'', items:
        '<option value="">全部</option><option value="1">中獎</option><option value="2">和局</option><option value="3">撤單</option>' +
        '<option value="4">待開獎</option><option value="5">未中獎</option>'
        },
        {type:'datebox', text:'日期', width:90,name:'from_time'},
        {type:'datebox', text:'-', width:90,name:'to_time'},
        {type:'combobox',text:'來源',width:30,name:'src',value:'', items:'<option value="">全部</option><?php foreach($from_type as $k => $v){echo "<option value=$k>$v</option>"; }?>'},
        {type:'textbox', text:'單號', width:90,name:'order_num'},
        {type:'textbox', text:'帳號', width:90,name:'account'},
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
    footer:true,
    checkbox:false,
    success:function(){

    }
});
</script>