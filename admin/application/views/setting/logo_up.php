<!-- 上传图片 -->
<div id="logo_up" class="con_menu">
  <form action="up_logo_do" method="post" enctype="multipart/form-data" name="add_form" class="form-horizontal">
    <table class="m_tab" style="width:300px;margin:0;" id="">
        <tbody>
          <tr class="m_title">
            <td class="de_td" align="center">
                <div class="uploader blue" style="margin-bottom:10px;">
                  <div style="display:none;">
                    <input type="text" class="filename" readonly name="filename">
                  </div> 
                  <input type="file" size="30" name="logo" style="width:150px;">               
                  <input type="hidden" id="id2" name="id2" value="1" class="form-control"/>
                  <input type="hidden" name="cateId2" value="11" class="form-control"/>
                </div>
            </td>
          </tr>
    </tbody>
    </table>
  </form>
</div>
