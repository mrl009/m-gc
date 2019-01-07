<!--发送聊天信息 -->
<?php $tid =  uniqid(); $nid = uniqid();?>
<form class="form-horizontal validate" role="form" method="post" action="interactive/chat/msg_send_save">
    <div class="tab-content">
    <div class="form-group">
        <label class="col-sm-3 control-label">發送員:</label>
        <div class="col-sm-6 pt7">
            <select class="form-control" name="form_type">
                <!--<option value="1">房管</option>-->
                <option value="2">計劃員</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">信息類別:</label>
        <div class="col-sm-6 pt7">
            <select class="form-control" name="type" id="iType">
                <option value="txt">普通消息</option>
                <option value="notice">大廳公告</option>
                <!-- <option value="img">圖片消息</option>
                <option value="plan">計劃內容</option> -->
            </select>
            <div class="msg-box" id="txtDiv">
                <textarea id="<?php echo $tid;?>" class="easyui-validatebox" style="height:200px;width:350px;" name="txt_msg" data-options="required:true"> </textarea>
            </div>
            <div class="msg-box" id="noticeDiv" style="display: none;">
                <textarea id="<?php echo $nid;?>" class="easyui-validatebox" style="height:200px;width:350px;" name="notice_msg"><?php echo $rs;?></textarea>
            </div>
            <!-- <div class="msg-box" id="planDiv" style="display: none;">
                <textarea id="<?php echo $plan_id;?>" style="height:200px;width:350px;" name="plan_msg"><?php echo $rs;?></textarea>
            </div>
            <div class="msg-box" id="picDiv" style="display: none;">
                <input type="text" class="form-control easyui-validatebox" name="img_msg" id="img_msg">
                <button class="btn btn-info" type="button" id="upload_btn_screen">上傳圖片</button>
            </div> -->
        </div>
    </div>
</form>
<style>
    .form-control 
    {
        width:60%;
        margin-right:10px;
        display: inline-block;
    }
    .form-control::-webkit-input-placeholder 
    {
        color: #999 !important;
        -webkit-transition: color.5s !important;
    }
    .form-control:focus::-webkit-input-placeholder, .form-control:hover::-webkit-input-placeholder 
    {
        color: #c2c2c2 !important;
        -webkit-transition: color.5s !important;
    }
    .msg-box 
    {
        margin-top:5%;
    }
    .msg-box input,.msg-box button,.msg-box textarea{
        border-radius: 4px;
    }
</style>
<script>
   //切換消息類別 更換輸入框
    $("#iType").bind("change",function(){
        var type = $(this).val();
        var tid = '<?php echo $tid;?>';
        var nid = '<?php echo $nid;?>';
        //大廳公告消息框
        if ('notice' == type)
        {
            $("#txtDiv").css("display","none");
            $("#noticeDiv").css("display","block");
            $("#"+tid).removeAttr("data-options");
            $("#"+nid).attr("data-options","required:true");
        //普通消息框
        } else {
            $("#txtDiv").css("display","block");
            $("#noticeDiv").css("display","none");
            $("#"+nid).removeAttr("data-options");
            $("#"+tid).attr("data-options","required:true");
        }
    });
     
    //上傳圖片
    Core.singleUploader('upload_btn_screen',[{title : "Image files", extensions : "jpg,gif,png"}],'1mb',function(rs){
        $('[name=img_msg]').val(rs.result);
    });
    //加載富文本編輯框1
    var ue = UE.getEditor('<?php echo $tid;?>',{
        toolbars:[['source','bold','italic','forecolor','fontsize','fontfamily','justifyleft','justifycenter','indent']],
        elementPathEnabled: false,//刪除元素路徑
        wordCount: false    //刪除字數統計
    });
    //加載富文本編輯框2
    var ue = UE.getEditor('<?php echo $nid;?>',{
        toolbars:[['source','bold','italic','forecolor','fontsize','fontfamily','justifyleft','justifycenter','indent']],
        elementPathEnabled: false,//刪除元素路徑
        wordCount: false    //刪除字數統計
    });

</script>