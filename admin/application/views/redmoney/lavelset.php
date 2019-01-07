<!--<img src="https://www.guocaitupian.com/uploads//7d37a69826e07f8d1db82e9f57340438.png"  alt="" />-->
<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'redmoney/get_lavelset',
        fields:[[
            {field:'id',title:'ID',rowspan:2,align:'center',width:50,sortable:true},
            {title:'充值範圍',colspan:2,align:'center',width:130},
            {title:'獎金範圍',colspan:2,align:'center',width:130},
            {field:'count',title:'個人抽獎次數',rowspan:2, align:'center', width:130, sortable:true}
        ],[
            {field:'start_recharge',title:'起始充值金額',align:'center',width:120, sortable:false},
            {field:'end_recharge',title:'結束充值金額',align:'center',width:120,  sortable:false},
            {field:'start_total',title:'起始獎金',align:'center',width:120, sortable:false},
            {field:'end_total',title:'結束獎金',align:'center',width:120,  sortable:false}
        ]], tools:[
            {instant:false},
            <?php if(in_array('ADD',$auth)){?>
            {text:"新增",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增等級設置',get:'redmoney/add_lavelset',full:false});
            }},
            <?php }?>
            <?php if(in_array('EDIT',$auth)){?>
            {text:"編輯",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'編輯等級設置',get:'redmoney/add_lavelset',full:false});
            }},
            <?php }?>
            <?php if(in_array('DELETE',$auth)){ ?>
            {text:"刪除",iconCls:"icon-remove",handler:function(){
                $('#<?php echo $id?>').DataSource('remove',{get:'redmoney/delete_lavelset'});
            }},
            <?php }?>
            {type:'textbox', text:'個人抽獎次數', width:100,name:'count'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }
            }
        ]
    });
</script>