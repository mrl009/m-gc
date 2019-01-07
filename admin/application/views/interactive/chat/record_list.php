<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'interactive/chat/get_record_list',
        fields: [[
            {field:'id',title:'ID',width:60,sortable:true},
            {field:'type',title:'Type',width:80,align:'center',
                formatter:function(v,r){
                    return '<span>'+ v +'</span>';
                }
            },
            {field:'username',title:'账户',width:80,align:'center',
            editor:'text'},
            {field:'msg',title:'内容',width:300,align:'center'},
            {field:'time',title:'发送时间',width:150,align:'center',
            sortable:false},
            {field:'to',title:'对象',width:100,align:'center',sortable:false}
        ]],
        tools:[
            {instant:false},
            //管理员发房间消息
            {text:"发送消息",iconCls:"icon-add",handler:function(){
                $("#<?php echo $id;?>").DataSource('add',{
                    title: '发送消息',
                    get: 'interactive/chat/msg_send',
                    full: false
                });
            }},
            //编辑过滤敏感词
            {text:"敏感词过滤",iconCls:"icon-add",handler:function(){
                $("#<?php echo $id;?>").DataSource('add',{
                    title:'敏感词过滤',
                    get: 'interactive/chat/msg_filter',
                    full:false
                });
            }},
            //删除按钮
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $("#<?php echo $id;?>").DataSource('remove',{
                    get: 'interactive/chat/record_delete'
                });
            }},
            {type:'datebox', text:'发送日期', width:98,name:'start'},
            {type:'datebox', text:'-', width:98,name:'end'},
            {type:'textbox', text:'账户', width:120,name:'tj_txt'},
            {type:'button',text:"搜索", iconCls:"icon-search",handler:function(){
                var end = $("#<?php echo $id;?> input[name='end']").val();
                var start = $("#<?php echo $id;?> input[name='start']").val();
                var tj_txt = $("#<?php echo $id;?> input[name='tj_txt']").val();
                if (('' == tj_txt) && ('' != start) && ('' != end) 
                    && (Core.limitDay(start, end, 60))){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $("#<?php echo $id;?>").DataSource('search');
            }}
        ],
        edit:false,
        footer:true,
        success:function(){}
    });
</script>