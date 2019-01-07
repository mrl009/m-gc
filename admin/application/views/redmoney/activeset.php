<!--<img src="https://www.guocaitupian.com/uploads//48d45d7b49715dccedc8f8404e480fc9.png"  alt="" />-->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'redmoney/get_activeset',
        fields:[[
            {field:'id',           title:'ID',align:'center',width:50,sortable:true},
            {field:'start_time',   title:'開始時間 ',align:'center',width:180,sortable:false},
            {field:'end_time',     title:'結束時間 ',align:'center',width:180,sortable:false},
            {field:'total',        title:'紅包總額 ',align:'center',width:150,sortable:false},
            {field:'current_total',title:'已搶金額 ',align:'center',width:150,sortable:false},
            {field:'count',        title:'已搶次數 ',align:'center',width:150,sortable:false,formatter:function(v, r){
                return v == 0 ? v : '<a onclick=red_order(' + r.id + ');><span class="btn label label-success">'+v+'</span></a>';
            }},
            {field:'status',       title:'狀態',align:'center',width:60,formatter:function(v){
                return v == 1 ? '<span class="c_red">未開始</span>' : v == 2 ? '<span class="c_green">正在進行</span>' : '已結束'
            }}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增紅包設置',get:'redmoney/add_activeset',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                var now = Date.parse(new Date());
                var d = $("#<?php echo $id;?>").datagrid('getSelected');
                if (d.start_time) {
                    var start = Date.parse(d.start_time);
                    var time = (start - now) / 1000 - 1800;
                    if (d.status != 1 || time < 0) {
                        Core.error('只有距離活動開始時間超過半小時的活動才能編輯');
                        return false;
                    }
                }
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯紅包設置',get:'redmoney/add_activeset',full:false});
            }},
            {text:'批量添加',iconCls:'icon-redo',handler:function(){
                Core.dialog('批量添加','redmoney/multiple_add_activeset?id=<?php echo $id?>',function(){
                    $('#<?php echo $id?>').datagrid('reload');
                },true,55,function(){},function(){},false,function(){},true);
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                var flag = true;
                var now = Date.parse(new Date());
                var rows = $('#<?php echo $id?>').datagrid('getSelections');
                for(var i=0; i<rows.length; i++){
                    var start = Date.parse(rows[i]['start_time']);
                    var time = (start - now) / 1000 - 1800;
                    if (rows[i]['status'] != 1 || time < 0) {
                        flag = false;
                        break;
                    }
                }
                if (!flag) {
                    Core.error('只有距離活動開始時間超過半小時的活動才能刪除');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('remove',{get:'redmoney/delete_activeset'});
            }},
            <?php }?>
            {type:'datebox', text:'日期', width:120,name:'start_time'},
            {type:'datebox', text:'-', width:120,name:'end_time'},
            {type:'combobox',text:'狀態',width:100,name:'status',value:'', items:'<option value="">全部</option><option value="1">未開始</option><option value="2">正在進行</option><option value="3">已結束</option>'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                var start = $("#form_<?php echo $id?> input[name='start_time']").val();
                var end = $("#form_<?php echo $id?> input[name='end_time']").val();
                if (start != '' && end != '' && Core.limitDay(start, end, 60)){
                    Core.error('查詢區間限制為兩個月');
                    return false;
                }
                $('#<?php echo $id?>').DataSource('search');
            }
            }
        ]
    });

    function red_order(rid) {
        Core.closeTab('訂單列表');
        Core.addTab('訂單列表', 'redmoney/orderlist?rid='+rid);
    }
</script>