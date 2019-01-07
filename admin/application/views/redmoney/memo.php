<?php $id=uniqid();?>
<form action=""  class="form-horizontal validate" role="form" method="post" style="margin: 10px;">
    <div class="form-group">
        <div class="col-sm-6">
            <button class="btn btn-success" id="<?php echo $id?>textbtn"><i class="entypo-upload"></i> 上傳圖片</button>
            <textarea id="<?php echo $id?>"  style="height:400px;width: 100%" name="content"><?php echo $content?></textarea>
        </div>
        <div class="col-sm-6" style="line-height: 25px;font-size: 14px;">
            1.紅包設置開始時間至少提前半個小時，搶紅包時間最長不超過24個小時.<br>
            2.在距離搶紅包半小時以內包括半小時，後臺刪除搶紅包活動或等級設置，前臺不應被刪除（後臺提示距離搶 紅包半小時，不可刪除）<br>
            3.搶紅包等級根據昨天會員的充值金額劃分，並在前臺顯示 <br>
            4.在後臺新增搶紅包，前臺在距離搶紅包之前半小時顯示搶紅包圖標 <br>
            5.所有用戶搶到的紅包總額應不超過後臺設置的紅包總額 <br>
            6.那個搶紅包的活動設置已經過期的，不可以修改在重新搶<br> 
            7.紅包時間段不能重復 <br>
            8.紅包沒有稽核 <br>
            9.（客戶須知：在紅包距離開搶半小時以內包括半小時和正在搶的時候，不能去改等級設置，紅包結束可以修 改。）後臺未限制此操作，可隨時進行修改，前臺即時獲取修改信息並顯示。
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label"></label>
        <div class="col-sm-10">
            <button class="btn btn-success btn-icon save" type="button" onclick="save(this)">保存修改 <i class="entypo-check"></i></button>
        </div>
    </div>
</form>
<script type="text/javascript">
    var ue=UE.getEditor('<?php echo $id?>',{
        toolbars:[['source','bold','italic','link', 'unlink','underline','fontborder','forecolor','backcolor','fontsize','fontfamily','justifyleft','justifycenter','indent', 'inserttable']],
        elementPathEnabled: false,//刪除元素路徑
        wordCount: false    //刪除字數統計
    });
    Core.singleUploader('<?php echo $id?>textbtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        var text='<img src="'+rs.result+'">';
        ue.setContent(text,true);
    });
    function save(e){
        $(e).parents('form').form('submit',{
            ajax:true,
            url:'redmoney/save_memo',
            onSubmit: function(){
                return $(this).form('enableValidation').form('validate');
            },
            success:function(c){
                c=eval('('+c+')');
                switch(c.status){
                    case "ERROR": Core.error('沒有修改任何信息','error'); break;
                    case 'OK': Core.ok('基礎信息修改成功'); break;
                    default: Core.error(c);
                }
            }
        });
    }
</script>
