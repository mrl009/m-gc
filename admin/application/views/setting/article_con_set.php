<!-- 設置內容 -->
<script src="static/js/editor/ueditor.all.min.js"></script>
<div class="content">
  <form name="myFORM" action="" method="post" class="form-horizontal" id="content_set_form">
    <table style='width:100%;' class="table table-bordered">
      <tbody>
        <tr >
          <td align="center">設置項</td>
          <td align="center">設置內容</td>
        </tr>

      <tr>
        <td align="center" >類別</td>
        <td align="left" >
          <input type="text" name="title" value="關於我們" style="width:280px;" class="checkbox"/>
        </td>
      </tr>
      <tr>
        <td align="center">內容</td>
        <td align="left">
          <script id="editor" type="text/plain" style="width:100%;height:300px;"></script>
        </td>
      </tr>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript">

  UE.getEditor('editor',{
        toolbars:[['source','bold','italic','underline','fontborder','forecolor','backcolor','fontsize','fontfamily','justifyleft','justifycenter','justifyright','indent','removeformat','customstyle','paragraph','rowspacingbottom','rowspacingtop','lineheight','spechars','insertunorderedlist','insertorderedlist',]],
        elementPathEnabled: false,//刪除元素路徑
        wordCount: false    //刪除字數統計
    });
</script>