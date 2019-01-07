<!-- 彩种管理 -->
<style>
    .tabs li.tabs-selected {border-bottom: none;}
</style>
<?php $id="form_".uniqid();$id2="form_".uniqid();?>
<div class="easyui-tabs" data-options="tabHeight:45,fit:true,tabPosition:'top',border:false,pill:true,narrow:true,justified:true" >
    <div title="彩種列表" style="padding:10px;">
        <table id="<?php echo $id;?>"></table>
        <script>
            $("#<?php echo $id;?>").DataSource({url:'game/get_list?ctg=gc',
                fields:[[
                    {field:'id',    title:'ID ',width:40, sortable:false},
                    {field:'name',  title:'彩种名字',width:100,align:'center'},
                    {field:'tname', title:'展示分类',width:100,align:'center'},
                    {field:'img',   title:'缩略图',  width:50,align:'center',formatter:function(v){if(!v) return '';return '<img src="'+v+'" height=30>'}},
                    {field:'home',  title:'上首页', width:60,align:'center',formatter:function(v){return v!=0?'<font color="green">是</font>':'<font color="red">否</font>';}},
                    {field:'open',  title:'状态',width:60,align:'center',formatter:function(v){return v==1?'<font color="green">正常</font>':'<font color="red">下架</font>';}},
                    {field:'op',    title:'操作(拖动列表可以排序)', width:150,align:'center',sortable:false,formatter:function(v,r){
                        return '<a herf="#"  onclick=updateGcGameStatus('+r.id+','+r.open+')>'+(r.open==1?'<span class="label label-success">下架</span>':'<span class="label label-danger">上架</span>')+'</a>&nbsp;&nbsp;' +
                            '<a herf="#"  onclick=updateGcGameHome('+r.id+','+r.home+','+r.open+')>'+(r.home==1?'<span class="label label-success">下首页</span>':'<span class="label label-danger">上首页</span>')+'</a>';
                    }}
                ]],
                tools:[
                    {instant:false}
                ],
                success:function(){
                    $('#<?php echo $id?>').datagrid('enableDnd');
                }
            });
            $('#<?php echo $id?>').datagrid({
                onDrop:function (t, s) {
                    var open = $(s).attr('open');
                    if (open) {
                        var r = $('#<?php echo $id?>').datagrid('getRows');
                        if (r.length) {
                            var cp = [];
                            $.each(r, function (i, d) {
                                d.open == 1 && cp.push(d.id);
                            });
                            $.get(WEB+'game/ajax_get_cp',{ctg:'sc'},function(json){
                                var c = JSON.parse(json);
                                if (c.status == 'OK') {
                                    var s = c.msg == null ? cp.join(',') : cp.join(',') + ',' + c.msg;
                                    $.post(WEB+'game/ajax_update_game',{cp:s},function(){});
                                } else {
                                    Core.error('操作频繁');
                                }
                            });
                        }
                    }
                }
            });
            function updateGcGameStatus(id,status){
                $.messager.confirm('溫馨提示', '確定'+(status==0?'上架':'下架')+'該彩种嗎', function(r){
                    if (r){
                        status = status==0 ? 1 : 0;
                        $.post(WEB+'game/update_game_status',{id:id,status:status},function(json){
                            var c = JSON.parse(json);
                            if (c.status == 'OK') {
                                $('#<?php echo $id?>').datagrid('reload');
                                Core.ok(c.msg);
                                $('#<?php echo $id2?>').datagrid('reload');
                            } else {
                                Core.error(c.msg);
                            }
                        });
                    }
                });
            }
            function updateGcGameHome(id,status,open){
                if (open==0) {
                    Core.error('請先上架該彩種');
                    return false;
                }
                $.messager.confirm('溫馨提示', '確定'+(status==0?'上首页':'下首页')+'該彩种嗎', function(r){
                    if (r){
                        status = status==0 ? 1 : 0;
                        $.post(WEB+'game/update_game_home',{id:id,status:status},function(json){
                            var c = JSON.parse(json)
                            if (c.status == 'OK') {
                                $('#<?php echo $id?>').datagrid('reload');
                                Core.ok(c.msg);
                                $('#<?php echo $id2?>').datagrid('reload');
                            } else {
                                Core.error(c.msg);
                            }
                        });
                    }
                });
            }
        </script>
    </div>
    <div title="首頁彩種排序" style="padding:10px;">
        <table id="<?php echo $id2;?>"></table>
        <script>
            $("#<?php echo $id2;?>").DataSource({url:'game/get_home_list?ctg=gc',
                fields:[[
                    {field:'id',    title:'ID ',width:40, sortable:false},
                    {field:'name',  title:'彩种名字',width:100,align:'center'},
                    {field:'tname', title:'展示分类',width:100,align:'center'},
                    {field:'img',   title:'缩略图',  width:50,align:'center',formatter:function(v){if(!v) return '';return '<img src="'+v+'" height=30>'}},
                    {field:'op',    title:'操作', width:150,align:'center',sortable:false,formatter:function(){
                        return '<a herf="#"><span class="label label-success">拖动列表可以排序</span>';
                    }}
                ]],
                tools:[
                    {instant:false}
                ],
                success:function(){
                    $('#<?php echo $id2?>').datagrid('enableDnd');
                }
            });
            $('#<?php echo $id2?>').datagrid({
                onDrop:function (t, s) {
                    var r = $('#<?php echo $id2?>').datagrid('getRows');
                    if (r.length > 1) {
                        var cp_index = [];
                        $.each(r, function (i, d) {
                            cp_index.push(d.id);
                        });
                        $.get(WEB+'game/ajax_get_cp_index',{ctg:'sc'},function(json){
                            var c = JSON.parse(json);
                            if (c.status == 'OK') {
                                var s = c.msg == null ? cp_index.join(',') : cp_index.join(',') + ',' + c.msg;
                                $.post(WEB+'game/ajax_update_home_game',{cp_index:s},function(){});
                            } else {
                                Core.error('操作频繁');
                            }
                        });
                    }
                }
            });

        </script>
    </div>
</div>