<!--<img src="https://www.guocaitupian.com/uploads//b2418d22994bfb462273dc575df4513f.png"  alt="" />-->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'redmoney/get_orderlist<?php echo $rid?'?rid='.$rid:'';?>',
        fields:[[
            {field:'username',title:'會員賬號 ',align:'center',width:120,sortable:false},
            {field:'total',  title:'紅包總額 ',align:'center',width:120,sortable:false},
            {field:'add_time',title:'搶包時間',align:'center',width:180},
            {field:'bag_id',title:'紅包ID',align:'center',width:100},
            {field:'src',title:'來源',  width:35,align: 'center',formatter:function(v){
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
            {field:'ip',title:'IP',align:'center',width:100}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增紅包設置',get:'redmoney/add_activeset',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯紅包設置',get:'redmoney/add_activeset',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'redmoney/delete_activeset'});
            }},
            <?php }?>
            {type:'datebox', text:'時間', width:120,name:'start_time'},
            {type:'datebox', text:'-', width:120,name:'end_time'},
            {type:'textbox', text:'用戶名', width:100,name:'username'},
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
        ],
        checkbox:false,
        footer:true
    });
</script>