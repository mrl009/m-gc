<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
$("#<?php echo $id;?>").DataSource({url:'member/getlist/2',
	fields:[[
		{field:'id',      title:'推廣ID',align:'center',width:60,sortable:true},
		{field:'online',      title:'代理狀態',width:100,align:'center',formatter:function(v,r){
            if (!r.id){
                return '';
            }
			return v==1?'<a herf="javascript:;" onclick="Member.userOut('+r.id+',\''+r.username+'\')"><span class="btn label label-success">在線</span></a>':'<a herf="javascript:;"><span class="label label-default">離線</span></a>';
		}},
		{field:'username', title:'帳號',align:'center', width:150,editor:'text'},
		{field:'bank_name',title:'姓名', align:'center',width:110},
        {field:'code',title:'来源邀请码', align:'center',width:110},
		{field:'off_sum',title:'會員數',align:'center', width:110},
		{field:'from_way',title:'來源', align:'center', width:50,formatter:function(v,r){
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
		{field:'addtime', title:'新增日期', align:'center',width:130,  sortable:true},
        {field:'status',  title:'s', align:'center', width:70,hidden:true},
		{field:'status_str',      title:'狀態',align:'center',width:50,formatter:function(v,r){
            if (r.id && r.status==4) {
                return '<a herf="#" class="warning"><span class="btn disabled label label-danger">试玩</span></a>';
            }
			return r.id?'<a herf="#" class="'+(r.status==1?'danger':'success')+'" onclick="Member.updateStatus('+r.id+','+r.status+',\''+r.username+'\')")>'+(r.status==1?'<span class="btn label label-info">正常</span>':'<span class="btn label label-warning">停用</span>')+'</a>':'';
		}},
        {field:'ban',  title:'反水狀態',align:'center',width:70,formatter:function(v,r){
            return r.id?'<a herf="#" class="'+(r.ban==1?'danger':'success')+'" onclick="Member.updateRebateStatus('+r.id+','+r.ban+',\''+r.username+'\')")>'+(r.ban==1?'<span class="btn label label-danger">禁止反水</span>':'<span class="btn label label-info">正常反水</span>')+'</a>':'';
        }}
    ]], tools:[
	{instant:false},
    <?php if(in_array('ADD',$auth)){?>
    {text:"新增",iconCls:"icon-add",handler:function(){
        $('#<?php echo $id?>').DataSource('add',{title:'添加顶级代理账号',get:'agent/add',full:false});
    }},
    <?php }?>
	<?php if(in_array('EXPORT',$auth)){?>
	{text:'導出',iconCls:'icon-large-chart',handler:function(){
       Core.ExportJs($("#<?php echo $id;?>"),'列表');
   	}},
   	<?php }?>
	<?php if(in_array('EDIT',$auth)){?>
	{text:"編輯",iconCls:"icon-edit",handler:function(){
		$('#<?php echo $id?>').DataSource('edit',{title:'查看代理',get:'member/edit_agent',full:70});
	}},
	<?php }?>
		{type:'combobox',text:'狀態',width:50,name:'status',value:'', items:'<option value="">全部</option><option value="1">正常</option><option value="2">停用</option><option value="4">试玩</option>'},
		{type:'combobox',text:'來源',width:50,name:'from_way',value:'', items:'<option value="">全部</option><option value="1">IOS</option><option value="2">安卓</option><option value="3">PC</option><option value="4">wap</option><option value="5">未知</option>'},
		{type:'datebox', text:'註冊日期', width:98,name:'start'},
		{type:'datebox', text:'-', width:98,name:'end'},
		{type:'combobox',text:'',width:50,name:'tj',items:'<option value="1">帳號</option><option value="2">註冊IP</option><option value="3">登陸IP</option><option value="4">姓名</option><option value="5">手機</option><option value="6">銀行卡</option>'},
		{type:'textbox', text:'', width:120,name:'tj_txt'},
		{type:'button',text:"搜索", iconCls:"icon-search", handler:function(){
            var start = $("#form_<?php echo $id?> input[name='start']").val();
            var end = $("#form_<?php echo $id?> input[name='end']").val();
            if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                Core.error('查詢區間限制為兩個月');
                return false;
            }
            $('#<?php echo $id?>').DataSource('search');
		}},
	'-'
	],
	footer:true,
	success:function(){	
		
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
    updateRebateStatus:function(id,status,username){
        $.messager.confirm('溫馨提示', '確定'+(status==1?'恢复':'禁止')+'該帳號反水嗎', function(r){
            if (r){
                $.post(WEB+'member/update_rebate_status',{id:id,status:status,username:username},function(c){
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