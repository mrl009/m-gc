<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'member/getlist/1',
        fields:[[
            {field:'id',      title:'ID',width:60,sortable:true},
            {field:'online',      title:'狀態',width:50,align:'center',formatter:function(v,r){
                if (!r.id){
                    return '';
                }
                return v==1?'<a herf="javascript:;" onclick="Member.userOut('+r.id+',\''+r.username+'\')"><span class="btn label label-success">在線</span></a>':'<a herf="javascript:;"><span class="label label-default">離線</span></a>';
            }},
            {field:'username', title:'帳號',align:'center', width:150,editor:'text'},
            {field:'bank_name',title:'姓名', align:'center',width:110},
            {field:'type',title:'类型', align:'center',width:90},
            {field:'agent_name',title:'所屬代理',align:'center', width:80},
            {field:'code',title:'来源邀请码', align:'center',width:90},
            {field:'title',title:'頭銜',align:'center', width:80},
            {field:'dengji',title:'等級',align:'center', width:80,formatter:function(v){
                return v?'VIP'+v:'';
            }},
            {field:'level_name', title:'層級',align:'center',  width:120,formatter:function(v,r){
                return r.id?'<span class="btn label label-info" onclick="fc('+r.id+')"><u>'+v+'</u></span>':'';
            }},
            {field:'balance', title:'系統額度',align:'center',  width:130,sortable:true,
                styler:function(v){
                    return v<=0?'color:#FF0000;':'';
                }
            },
            {field:'from_way',title:'來源', align:'center', width:30,formatter:function(v,r){
                var r = '';
                if (v == '1') {
                    r = '<i class="fa fa-apple fa-lg"></i><span style="display: none">Ios</span>';
                } else if(v == 2) {
                    r = '<i class="fa fa-android fa-lg"></i><span style="display: none">Android</span>';
                } else if(v == 3) {
                    r = '<i class="fa fa-desktop fa-lg"></i><span style="display: none">PC</span>';
                } else if(v == 4) {
                    r = '<i class="fa fa-html5 fa-lg"></i><span style="display: none">Wap</span>';
                } else if(v == 5) {
                    r = '<i class="fa fa-info-circle fa-lg"></i><span style="display: none">未知</span>';
                }
                return r;
            }},
            {field:'addtime', title:'新增日期', align:'center',width:130,  sortable:true},
            {field:'status_str',      title:'狀態',align:'center',width:50,formatter:function(v,r){
                if (r.id && r.status==4) {
                    return '<a herf="#" class="warning"><span class="btn disabled label label-danger">试玩</span></a>';
                }
                return r.id?'<a herf="#" class="'+(r.status==1?'danger':'success')+'" onclick="Member.updateStatus('+r.id+','+r.status+',\''+r.username+'\')")>'+(r.status==1?'<span class="btn label label-info">正常</span>':'<span class="btn label label-warning">停用</span>')+'</a>':'';
            }},
            {field:'rebate',title:'返点', align:'center',width:110}
            <?php if ($this->session->userdata('admin_id') == 1) { ?>,
            {field:'aa',  title:'功能',align:'center', width:100,sortable:false,formatter:function(v,r){
                return ((r.rebate && r.level>1)?'<a herf="#" onclick=Core.dialog("修改会员返点","member/edit_rebate?id='+r.id+'",function(){},true,false);><span class="btn label label-primary">返点設置</span></a>&nbsp;&nbsp;':'<a herf="javascript:void(0);"><span class="btn disabled label label-default">返点設置</span></a>&nbsp;&nbsp;');
            }}
            <?php } ?>
        ]], tools:[
            {instant:false},
            <?php if(in_array('EXPORT',$auth)){?>
            {text:'導出',iconCls:'icon-large-chart',handler:function(){
                Core.ExportJs($("#<?php echo $id;?>"),'會員列表');
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{
                    title:'查看會員',
                    get:'member/edit_member?auth=<?php echo implode(',',$auth)?>',
                    full:70});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){ ?>
            {text:'移動層級',iconCls:'icon-redo',handler:function(){
                var ss = [];
                var rows = $('#<?php echo $id?>').datagrid('getSelections');
                if(rows.length==0){
                    Core.error('請選擇要移動層級的會員');
                    return false;
                }
                for(var i=0; i<rows.length; i++){
                    var row = rows[i];
                    ss.push(row.id);
                }
                Core.dialog('分層','member/getfc?id='+ss.join(),function(){
                    $('#<?php echo $id?>').datagrid('reload');
                },true,false);
            }},
            <?php }?>
            {type:'combobox',text:'層級',width:90,name:'is_level',value:'', items:'<option value="">全部</option><?php foreach($level as $v){echo "<option value=$v[id]>$v[level_name]</option>"; }?>'},
            {type:'textbox', text: '所屬代理', width: 80, name: 'agent_name'},
            {type:'label', html:'<input type="hidden" name="agent_id" value="">'},
            {type:'combobox',text:'狀態',width:50,name:'status',value:'', items:'<option value="">全部</option><option value="1">正常</option><option value="2">停用</option><option value="3">在線</option><option value="4">试玩</option>'},
            {type:'combobox',text:'來源',width:50,name:'from_way',value:'', items:'<option value="">全部</option><option value="1">IOS</option><option value="2">安卓</option><option value="3">PC</option><option value="4">wap</option><option value="5">未知</option>'},
            {type:'datebox', text:'註冊日期', width:98,name:'start'},
            {type:'datebox', text:'-', width:98,name:'end'},
            {type:'combobox',text:'其他',width:90,name:'tj', items:'<option value="1">帳號</option><option value="2">註冊IP</option><option value="3">登陸IP</option><option value="4">姓名</option><option value="5">手機</option><option value="6">銀行卡</option><option value="7">VIP等級</option><option value="8">代理等級</option><option value="9">来源邀请码</option>'},
            {type:'textbox', text:'', width:120,name:'tj_txt'},
            {type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
                var tj_txt = $("#form_<?php echo $id?> input[name='tj_txt']").val();
                var start = $("#form_<?php echo $id?> input[name='start']").val();
                var end = $("#form_<?php echo $id?> input[name='end']").val();
                if (tj_txt == '' && start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        footer:true,
        success:function(){
            Core.agentLog('<?php echo $id?>');
        }
    });
    function fc(v){
        Core.dialog('分層','member/getfc?id='+v,function(){
            $('#<?php echo $id?>').datagrid('reload');
        },true,false);
    }
    var Member={
        updateStatus:function(id,status,username){
            $.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該帳號使用嗎', function(r){
                if (r){
                    $.post(WEB+'member/update_member_status',{id:id,status:status,username:username},function(c){
                        $('#<?php echo $id?>').datagrid('reload');
                    });
                }
            });
        },
        userOut:function(id,username){
            $.messager.confirm('溫馨提示', '確定踢出該賬號', function(r){
                if (r){
                    $.post(WEB+'member/user_out',{id:id,username:username},function(c){
                        $('#<?php echo $id?>').datagrid('reload');
                    });
                }
            });
        }
    };
    $(function(){
        $("#tj").combobox('setValue',1);
    });
</script>