<div class="panel panel-default bbc" data-collapsed="0" style="margin:8px">
    <input type="hidden" name="picsType" value="1">
    <button type="button" class="btn btn-info btn-danger btn-sm" onclick="change('1',this)">幻燈片</button>
    <!-- <button type="button" class="btn btn-info btn-sm" onclick="change('2',this)">手機幻燈片</button> -->
    <button type="button" class="btn btn-info btn-sm" onclick="change('3',this)">手機功能欄</button>
    <!-- <button type="button" class="btn btn-info btn-sm" onclick="change('4',this)">手機底部導航欄</button> -->
    <button type="button" class="btn btn-info btn-sm" onclick="change('5',this)">底部導航欄</button>
    <div class="panel-heading" style="line-height:24px;height:42px;padding-top:5px;border:1px solid #cecece;margin-top: 10px;">
        <div class="panel-title" style="float:left">輪播廣告屏</div>
        <b style="padding-left:10px;color: red">
        圖片大小：<span class="kk">740px × 230px，不超過100KB</span>
        </b>
        <div class="panel-options" style="float:right">
            <button class="btn btn-info" type="button" onclick="slideScreen.add()"><i class="entypo-plus-circled"></i> 新增壹屏</button>&nbsp;&nbsp;
            <button class="btn btn-success" type="button" onclick="slideScreen.save()"><i class="entypo-check"></i> 保存數據</button>
        </div>
    </div>
    <div class="panel-body" style="padding:15px">
        <div class="gallery-env">
            <div class="row" id="slideBox"></div>
        </div>
    </div>
</div>
<style>
    #slideBox img{background-size:cover;}
</style>
<script>
    var pc = <?php echo $pc?$pc:[];?>;
    var wap_banner = <?php echo $wap_banner?$wap_banner:[];?>;
    var wap_slides = <?php echo $wap_slides?$wap_slides:[];?>;
    var wap_bottom = <?php echo $wap_bottom?$wap_bottom:[];?>;
    var wap_bottom_unselected = <?php echo $wap_bottom_unselected?$wap_bottom_unselected:[];?>;
    var slideScreen = {
        init: function(arr){
            $.each(arr,function(i,d){
                slideScreen.insert(d);
            });
        },
        add: function(){
            // 獲取最後壹個元素的ID
            var id = $('#slideBox .col-sm-3:last').find('[name=_id]').val();
            id = id===undefined?1:parseInt(id) + 1;
            slideScreen.open({
                id: id
            });
        },
        remove: function(e){
         $(e).parents('.col-sm-3').remove();
         },
        editStatus: function (e) {
            var status = $(e).parents('.col-sm-3').find('[name=_status]').val();
            $.messager.confirm('溫馨提示', '確定'+(status==1?'停用':'開啟')+'該功能使用嗎', function(r){
                if (r){
                    status = status==1?0:1;
                    var text = status==1?'停用':'開啟';
                    $(e).parents('.col-sm-3').find('[name=_status]').val(status);
                    $(e).parents('.col-sm-3').find('.entypo-trash').text(text);
                }
            });
        },
        insert: function(m,_target){
            if(_target){
                _target.find('h3').text(m.title);
                _target.find('[name=_pic]').val(m.pic);
                _target.find('[name=_url]').val(m.url);
                _target.find('img').attr('src',m.pic);
            }else{
                var item = '<div class="col-sm-3"><article class="album"><header style="height:100px;overflow:hidden"><a href="javascript:;" onclick="slideScreen.edit(this)"><input type=hidden name="_id" value="'+m.id+'"/><input type=hidden name="_status" value="'+m.status+'"/><input type=hidden name="_pic" value="'+m.pic+'"/><input type=hidden name="_url" value="'+m.url+'"/><img src="'+m.pic+'" width="100%"/></a></header>'+
                    '<section class="album-info"><h3><a href="javascript:;" onclick="slideScreen.edit(this)">'+(m.title?m.title:'')+'</a></h3></section>'+
                    '<footer><div class="album-images-count"></div><div class="album-options">'+
                    '<a href="javascript:;" onclick="slideScreen.edit(this)"><i class="entypo-cog"></i> 編輯</a>';
                var c = $('[name=picsType]').val();
                if (c==1 || c==2){
                    item += '<a href="javascript:;" onclick="slideScreen.remove(this)"><i class="entypo-trash"></i> 刪除</a></div></footer></article></div>';
                } else {
                    item += '<a href="javascript:;" onclick="slideScreen.editStatus(this)"><i class="entypo-trash">'+(m.status==1?"停用":"開啟")+'</i></a></div></footer></article></div>';
                }
                $(item).appendTo('#slideBox');
            }
            $('#slideBox').sortable();
        },
        edit: function(e){
            var o=$(e).parents('.col-sm-3');
            slideScreen.open({
                id: o.find('[name=_id]').val(),
                status: o.find('[name=_status]').val(),
                title: o.find('h3').text(),
                pic: o.find('[name=_pic]').val(),
                url: o.find('[name=_url]').val()
            },o);
        },
        open: function(a,_target){
            var s='<form class="form-horizontal validate" role="form" method="post">'+
                '<input type="hidden" name="id" value="'+(a.id?a.id:'')+'">' +
                '<input type="hidden" name="status" value="'+(a.status?a.status:1)+'">' +
                '<div class="form-group"><label class="col-sm-2 control-label">標題</label><div class="col-sm-10"><input type="text" class="form-control" name="title" value="'+(a.title?a.title:'')+'"></div></div>'+
                '<div class="form-group"><label class="col-sm-2 control-label">網址</label><div class="col-sm-10"><input type="text" class="form-control easyui-validatebox" data-options="validType:\'url\'" name="url" value="'+(a.url?a.url:'')+'"></div></div>'+
                '<div class="form-group"><label class="col-sm-2 control-label">圖片</label><div class="col-sm-5"><input type="text" class="form-control easyui-validatebox" name="pic" data-options="required:true"  value="'+(a.pic?a.pic:'')+'"></div><div class="col-sm-5"><button class="btn btn-info" type="button" id="upload_btn_screen">上傳圖片</button></div></div>'+
                '</form>';
            Core.dialog("新增壹屏",s,function(dlg){
                dlg.find('.easyui-validatebox').each(function(){
                    if($(this).data('options')) $(this).validatebox(eval('({'+$(this).data('options')+'})'));
                });
                if(!dlg.form('enableValidation').form('validate')) return;
                slideScreen.insert({
                    id: $('[name=id]').val(),
                    status: $('[name=status]').val(),
                    title: $('[name=title]').val(),
                    url: $('[name=url]').val(),
                    pic: $('[name=pic]').val()
                },_target);
                $('#modal').modal('hide');
            },false,false);
            Core.singleUploader('upload_btn_screen',[{title : "Image files", extensions : "jpg,gif,png"}],'1mb',function(rs){
                $('[name=pic]').val(rs.result);
            });
        },
        save: function(){
            var arr=[];
            $('#slideBox .col-sm-3').each(function(i){
                arr.push({
                    id:    $(this).find('[name=_id]').val(),
                    status:$(this).find('[name=_status]').val(),
                    title: $(this).find('h3').text(),
                    pic:   $(this).find('[name=_pic]').val(),
                    url:   $(this).find('[name=_url]').val()
                });
            });
            $.post(WEB+'setting/save_pics',{type:$('[name=picsType]').val(),data:JSON.stringify(arr)},function(c){
                c=eval('('+c+')');
                if(c.status=='OK') Core.ok('成功保存設置',true);
                else Core.error('保存設置失敗',true);
            });
        }
    };
    slideScreen.init(pc);

    function change(v,e){
        $('[name=picsType]').val(v);
        $('.bbc .btn-sm').removeClass('btn-danger');
        $(e).addClass('btn-danger');
        $('#slideBox').html('');
        var _data = pc;
        if(v==1){
            $('.kk').text('740px × 230px，不超過100KB')
        }else if (v == 2) {
            $('.kk').text('740px × 230px，不超過100KB')
            _data = wap_banner;
        }else if (v ==3) {
            $('.kk').text('')
            _data = wap_slides;
        }//else if (v ==4) {
           // $('.kk').text('')
            //_data = wap_bottom;
        //}
        else if (v ==5) {
            $('.kk').text('')
            _data = wap_bottom_unselected;
        }
        slideScreen.init(_data);
    }
</script>
<style type="text/css">
    .gallery-env article.album {
        border: 1px solid #cecece;
        margin-bottom: 30px;
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        -webkit-border-radius: 3px;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 3px;
        -moz-background-clip: padding;
        border-radius: 3px;
        background-clip: padding-box;
</style>

