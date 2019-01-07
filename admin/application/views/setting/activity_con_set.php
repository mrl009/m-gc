<!-- 設置內容 -->
<?php $id=uniqid();?>
<div class="content">
  <form name="myFORM" action="setting/save_activity" method="post" class="form-horizontal validate" id="activity_set_form">
    <input type="hidden" value="<?php echo $rs['id']?>" name="id" id='id'>
    <table style='width:100%;' class="table table-bordered">
      <tbody>
        <tr>
          <td align="center">活動標題</td>
          <td><input type="text" class="form-control easyui-validatebox"
            data-options="required:true" value="<?php echo $rs['title']?>"  name="title"></td>
        </tr>
        <tr>
            <td align="center">小標題</td>
            <td><input type="text" class="form-control" value="<?php echo $rs['extra_title']?>"  name="extra_title"></td>
        </tr>
        <tr>
          <td align="center">活動封面</td>
          <td>
            <div class="panel panel-default" data-collapsed="0" style="width:98%; float: left;margin-right: 20px;">
          <div class="panel-heading" style="height:51px;border:1px solid #ccc;">
            <div class="panel-title">
              <button class="btn btn-danger" id="ggUloadsBtn"><i class="entypo-upload"></i> 上傳封面</button>
              <b style="padding-left:10px;color: red">
                <!-- 手機端大小：<span class="kk">750px × 282px，不超過100KB</span> -->
                封面图共用大小：<span class="kk">660px × 150px，不超過100KB</span>
            </b>
            </div>

          </div>
          <div class="panel-body" style="height: 130px;">
            <img <?php if($rs['img_base64']) echo "src='$rs[img_base64]'"?> class="qrcode_thumb img-rounded ggUloadsBtn" style="width:598px;height: 120px;">
            <input type="hidden" name="img_base64" value="<?php echo $rs['img_base64']?>">
          </div>
      </div>
          </td>
        </tr>
        <?php if($rs['id']!=1001&&$rs['id']!=1002){?>
        <tr >
          <td align="center">顯示位置</td>
          <td>
            <label class="fwn"><input type="checkbox" name="show_way[]" value="1" <?php if (in_array(1, $rs['show_way'])) echo 'checked';?>>&nbsp;IOS&nbsp;</label>
            <label class="fwn"><input type="checkbox" name="show_way[]" value="2" <?php if (in_array(2, $rs['show_way'])) echo 'checked';?>>&nbsp;安卓&nbsp;</label>
            <label class="fwn"><input type="checkbox" name="show_way[]" value="3" <?php if (in_array(3, $rs['show_way'])) echo 'checked';?>>&nbsp;PC&nbsp;</label>
            <label class="fwn"><input type="checkbox" name="show_way[]" value="4" <?php if (in_array(4, $rs['show_way'])) echo 'checked';?>>&nbsp;WAP&nbsp;</label>
          </td>
        </tr>
        <tr>
            <td align="center">开始時間</td>
            <td><input name="start_time" type="text" value="<?php echo $rs['start_time']?date('Y-m-d',$rs['start_time']):''?>" class="form-control easyui-datebox"></td>
        </tr>
        <tr>
          <td align="center">過期時間</td>
          <td><input name="expiration_time" type="text" value="<?php echo $rs['expiration_time']?date('Y-m-d',$rs['expiration_time']):''?>" class="form-control easyui-datebox"></td>
        </tr>
        <tr>
          <td align="center">排序</td>
          <td><input name="sort" type="text" value="<?php echo $rs['sort']?>" class="form-control"></td>
        </tr>

        <tr>
          <td align="center">內容</td>
          <td>
            <button class="btn btn-danger" id="textbtn"><i class="entypo-upload"></i> 上傳圖片</button>
            <textarea id="<?php echo $id?>" style="height:300px;width: 98%;" name="content"><?php echo $rs['content']?></textarea>
          </td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript">
    var id = $('#id').val();
    if(id!=1001&&id!=1002){
      var ue = UE.getEditor('<?php echo $id?>', {
          toolbars:[['source', '|', 'undo', 'redo', '|',
              'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
              'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
              'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
              'directionalityltr', 'directionalityrtl', 'indent', '|',
              'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
              'link', 'unlink', '|', 'imagenone', 'insertvideo','pagebreak', '|',
              'horizontal', 'date', 'time', 'spechars', '|',
              'inserttable', '|',
              'print', 'searchreplace', 'drafts']],
          elementPathEnabled: false,//刪除元素路徑
          wordCount: false,    //刪除字數統計
      });
    }

  Core.singleUploader('ggUloadsBtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
      $('.ggUloadsBtn').attr('src',rs.result);
      $('[name=img_base64]').val(rs.result);
  });

   Core.singleUploader('textbtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
      var text='<img src="'+rs.result+'">';
      ue.setContent(text,true);
  });
</script>