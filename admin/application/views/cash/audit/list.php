<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>

    $("#<?php echo $id;?>").DataSource({url:'cash/get_audit_list',
        fields:[
            [
                {field:'username',title:'存款日期與時間',rowspan:2,align:'center',width:180,sortable:true,formatter:function(v, r) {
                    return '起始：'+r.start_date + '<br/>'+'結束：'+r.end_date;
                }},
                {field:'total_price',title:'存款金額',rowspan:2,align:'center',width:100,sortable:true},
                {field:'discount_price',title:'優惠金額',rowspan:2,align:'center',width:100,sortable:true},
                {title:'實際有效投註',colspan:1},
                {title:'常態打碼',colspan:5}
            ],
            [
                {field:'dml',title:'打碼量',width:85,align:'center',sortable:true},
                {field:'auth_dml',title:'常態打碼',width:85,align:'center',sortable:true},
                {field:'limit_dml',title:'放寬額度',width:85,align:'center',sortable:true},
                {field:'is_pass',title:'通過',width:85,align:'center',sortable:true,formatter:function(v, r) {
                    if(r.is_pass == 1){
                        return '<span style="color:green">通過</span>';
                    }else{
                        return '<span style="color:red">不通過</span>';
                    }
                }},
                {field:'is_ratio',title:'需扣除行政費用',width:100,align:'center',sortable:true,formatter:function(v, r) {
                    if(r.is_pass == 1){
                        return '<span style="color:green">不需要稽核</span>';
                    }else{
                        return '<span style="color:red">是</span>';
                    }
                }},
                {field:'ratio_price',title:'需扣除金額',width:85,align:'center',sortable:true,formatter:function(v, r) {
                    if(r.ratio_price){
                        return r.ratio_price;
                    }else{
                        return '0';
                    }
                }}
            ]
        ], tools:[
            {instant:false},
            {type:'textbox', text:'賬號', width:120,name:'username'},
            {text:"搜索", iconCls:"icon-search", handler:function(){
                $('#<?php echo $id?>').DataSource('search');
            }},
            '-'
        ],
        checkbox:false,
        edit:true,
        footer:true,
        success:function(id,data){

            var index = 0;
            var rowspan = 1;

            if(data.total) {
                for (var i = 0; i < data['rows'].length; i++) {
                    if (data['rows'][i]['dml'] != 0) {
                        index++;
                    } else {
                        rowspan++;
                    }
                }

                var merges = [{
                    index: index,
                    rowspan: rowspan
                }];
                for (var i = 0; i < merges.length; i++) {
                    $("#<?php echo $id;?>").datagrid('mergeCells', {
                        index: merges[i].index,
                        field: 'dml',
                        rowspan: merges[i].rowspan
                    });
                }
                //for (var i = 0; i < merges.length; i++) {
                //    $("#<?php //echo $id;?>//").datagrid('mergeCells', {
                //        index: merges[i].index,
                //        field: 'is_pass',
                //        rowspan: merges[i].rowspan
                //    });
                //}
                //for (var i = 0; i < merges.length; i++) {
                //    $("#<?php //echo $id;?>//").datagrid('mergeCells', {
                //        index: merges[i].index,
                //        field: 'is_ratio',
                //        rowspan: merges[i].rowspan
                //    });
                //}
            }
        }
    });
</script>