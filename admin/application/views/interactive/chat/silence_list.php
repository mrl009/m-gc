<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({
        url: 'interactive/chat/get_silence_list',
        fields: [[
            {field:'id',title:'ID',width:60,sortable:true},
            {field:'online',title:'在线狀態',align:'center',width:100,
                formatter:function(v,r)
                {
                    return 1==v ? '<a herf="javascript:;" onclick="Member.userOut('+r.id+',\''+r.username+'\')"><span class="btn label label-success">在線</span></a>':'<a herf="javascript:;"><span class="label label-default">離線</span></a>';
                }
            },
            {field:'username',title:'帳號',width:150,align:'center',
            editor:'text'},
            {field:'nickname',title:'昵称',width:110,align:'center'},
            {field:'vip_id',title:'VIP等級',width:80,align:'center',
                formatter:function(v)
                {
                    return v?'VIP'+v:'';
                }
            },
            {field:'silence_name',title:'禁言狀態',width:110,align:'center',
                formatter:function(v,r)
                {
                    var st = r.silence_type;
                    if (st && ((2 == st) || (3 == st) || (4 == st)))
                    {
                        return r.silence_name; 
                    } else {
                        return '正常';
                    }
                }
            },
            {field:'start_silence_time',title:'禁言時間',width:180,align:'center',
                formatter:function(v,r)
                {
                    var st = r.silence_type;
                    var nt = r.start_silence_time;
                    if (st && ((2 == st) || (3 == st) || (4 == st))) 
                    {
                       return '<span style="color:red">'+ nt +'</span>'; 
                    } 
                }
            },
            {field:'end_silence_time',title:'解禁時間',width:180,align:'center',
                formatter:function(v,r)
                {
                    var st = r.silence_type;
                    var nt = r.end_silence_time;
                    if (st && ((2 == st) || (3 == st) || (4 == st))) 
                    {
                       return '<span style="color:red">'+ nt +'</span>'; 
                    } 
                }
            }
        ]],
        tools:[
            {instant:false},
            {text:"设置禁言",iconCls:"icon-edit",handler:function(){
                 $("#<?php echo $id;?>").DataSource('edit',{
                    title: '禁言设置',
                    get: 'interactive/chat/silence_edit',
                    full: false
                });
            }},
            {type:'combobox',text:'禁言狀態',width:90,name:'status',value:'', items:'<option value="">全部</option><option value="2">禁言24小时</option><option value="3">禁言30天</option><option value="4">永久禁言</option>'},
            {type:'datebox', text:'禁言日期', width:98,name:'start'},
            {type:'datebox', text:'-', width:98,name:'end'},
            {type:'textbox', text:'用户', width:120,name:'tj_txt'},
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
        edit:true,
        footer:true,
        success:function(){}
    });
    var Member={
        userOut:function(id,username){
            $.messager.confirm('溫馨提示', '確定踢出該賬號', function(r){
                if (r){
                    $.post(WEB+'member/user_out',{id:id,username:username},function(c){
                        $('#<?php echo $id;?>').datagrid('reload');
                    });
                }
            });
        }
    };
</script>