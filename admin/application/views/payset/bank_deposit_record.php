<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'payset/get_bank_deposit_record',
        fields:[[
            {field:'id',         title:'序號',          width:100,  sortable:true},
            {field:'order_num',  title:'訂單號',        width:150,  sortable:false},
            {field:'money',      title:'存款金額/元',   width:150,  sortable:true},
            {field:'date',       title:'存款日期',      width:150,  sortable:true},
            {field:'username',   title:'會員賬號',      width:100,  sortable:true},
            {field:'remark',     title:'備註', width:300,  sortable:true}
        ]], tools:[
            {instant:false},
            <?php //if(in_array('ADD',$auth)){?>
            {text:"新增入款銀行",iconCls:"icon-add",handler:function(){
                $('#<?php echo $id?>').DataSource('add',{title:'新增銀行卡',get:'payset/edit_bank',full:false});
            }},
            <?php //}?>
            {text:"銀行存款記錄",iconCls:"icon-edit",handler:function(){
                $('#<?php echo $id?>').DataSource('edit',{title:'查看會員',get:'member/edituser',full:false});
            }},
            {type:'textbox', text:'訂單號', width:100,name:'order_no'},
            {type:'datebox', text:'日期', width:100,name:'sdate'},
            {type:'datebox', text:'-', width:100,name:'edate'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }},
        ],
        footer:true,
        edit:true,
        success:function(){

        }
    });
</script>