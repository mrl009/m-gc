<div  class="content" id="ad_revise">
  <div style="margin:0 auto;width:100%;">
    <form action=""  method="post" class="form-horizontal">
      <input type="hidden" name="id" value="1"/>
      <input type="hidden" name="cateId" value="11"/>
      <table  width="100%"  class="m_tab_ed table table-bordered">
        <tbody>
          <tr  class="m_title_over_co">
            <td  colspan="3" align="center">首页幻灯一</td>
          </tr>
          <tr  class="m_bc_ed">
            <td  class="m_co_ed">广告标题1：</td>
            <td><input name="Form[title]"  type="text" value="首页幻灯一"  class="form-control"></td>
          </tr>
          <tr  class="m_bc_ed">
            <td  class="m_co_ed">广告图片：</td>
            <td>
                <div class="panel panel-default" data-collapsed="0" style="width:31%">
                    <div class="panel-heading" style="height:51px;border:1px solid #ccc;">
                        <div class="panel-title" style="position: relative;"><button class="btn btn-blue" id="logo_uploadBtn" style="position: relative; z-index: 1;"><i class="entypo-upload"></i> 上传图片</button><div class="fileList"></div><div id="html5_1bb62je7b1mat1t0gtjat9518fm8_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 106px; height: 34px; overflow: hidden; z-index: 0;"><input id="html5_1bb62je7b1mat1t0gtjat9518fm8" type="file" capture="camera" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" accept="image/jpeg,image/gif,image/png"></div></div>
                    </div>
                    <div class="panel-body">
                        <img class="qrcode_thumb img-rounded logo_thumb" width="100%">
                        <input type="hidden" name="logo" value="">
                    </div>
                </div>
<!--              <input name="Form[img]" type="text" value="/site_info/1/img/flash20170226115542.png"  class="form-control" style='width:300px;'>-->
<!--              <input type="button"  name="upfile"  value="上传图片"  class="btn btn-danger upload" onClick="Core.dialog('上传图片', 'setting/logo_up', call_ad_back, true, null, null, hide_ad_con_set, 'ad_con_set', show_ad_con_set);">规定&nbsp;&nbsp;宽度：1920，高度：575-->
            </td>
          </tr>
          <tr class="m_bc_ed">
            <td class="m_co_ed">
          图片预览：
            </td>
            <td>
          		<img style="width:800px;" src="http://kgbet.cc/site_info/1/img/flash20170226115542.png">
            </td>
          </tr>
          <tr  class="m_bc_ed">
            <td colspan="2"> 提示：内链优先，如既选了内链也填了外链，则优先展示内链。</td>
          </tr>
          <tr  class="m_bc_ed">
          <td  class="m_co_ed">跳转地址1：</td>
          <td>
            <span>
              <select  class="form-control urltype" name="Form[urltype]" id="urltype">
                <option value="0">不选内链</option>
                <option value="0">不选内链</option>
                <option value="2">视讯</option>
                <option value="3">电子</option>
                <option value="4">彩票</option>
                <option value="5">优惠活动</option>
                <option value="6">代理联盟</option>
                <option value="7">免费试玩</option>
                <option value="8">常见问题</option>
                <option value="9">关于我们</option>
                <option value="10">联系我们</option>
                <option value="11">会员注册</option>
                <option value="12">存款帮助</option>
                <option value="13">取款帮助</option>
                <option value="14">线路检测</option>
              </select>
            </span>
            &nbsp;&nbsp;外链：
            <input name="Form[url]" type="text" value=""    class="form-control">&nbsp;&nbsp;<label>完整地址，含http:// </label>
          </td>
          </tr>
          <tr  class="m_bc_ed">
            <td  class="m_co_ed">排序：</td>
            <td><input name="Form[sort]" type="text" value="0" class="form-control"></td>
          </tr>
          <tr class="m_bc_ed">
            <td class="m_co_ed">状态：</td>
            <td> 
                 <label><input type="radio" name="Form[state]" value="1" checked/>提审</label>
                 <label><input type="radio" name="Form[state]" value="0"  />停用</label>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<script>
    Core.singleUploader('logo_uploadBtn',[{title : "Image files", extensions : "jpg,gif,png"}],'1mb',function(rs){
        $('.logo_thumb').attr('src',WEB+'../'+rs.result);
        $('[name=logo]').val(rs.result);
    });

//    var app = new Vue({
//        el: '#ad_revise',
//        data: {
//            id:3
//        },
//        methods: {
//            getAd: function () {
//                var _ = this;
//                axios.get("setting/get_advertise_list")
//                    .then(function(response){
//                        _.message=response.data;
//                    })
//                    .catch(function(error){
//
//                    })
//            }
//        },
//
//        created(){
//            this.getAd();
//        }
//    })
</script>