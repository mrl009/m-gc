<form action="google/save_key" class="form-horizontal validate" role="form" method="post">
<br>
    <table class="table-bordered" style="wdith:30% !important;margin-left:30px;">
        <tr>
            <td style="height: 40px">是否啟用動態口令認證：</td>
            <td>
                <input type="radio" value="1" name="google_stataus" 
                <?php echo $rs['google_status']==1?'checked':''?>>&nbsp;是&nbsp;&nbsp;&nbsp;
                <input type="radio" value="2" name="google_stataus" <?php echo $rs['google_status']==2?'checked':''?>>&nbsp;否&nbsp;
            </td>
        </tr>
        <tr>
            <td style="height: 40px">密鑰：</td>
            <td>
                <input type="text" class="form-control easyui-validatebox" maxlength="16"  style="width: 80%;" data-options="required:true" 
                <?php echo !empty($rs['google_key'])?'readonly':''?>
                 name="google_key" value="<?php echo $rs['google_key'];?>" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">
            </td>
        </tr>
        <tr>
            <td >二維碼：</td>
            <td>
               <img src="<?php echo $qrCodeUrl?>">
            </td>
        </tr>

        <tr>
            <td colspan="2" style="height: 40px">
                <button class="btn btn-success" type="button" onclick="google.save()"><i class="entypo-check"></i> 保存數據</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span>
                    <p>第壹步：在手機應用商店搜索谷歌身份驗證器，並且安裝好.</p>
                    <p>第二步：進入後台打開令牌驗證設定頁面並且刷新一次令牌驗證設定頁面,<br>
                    生成16位數字和字母組合密鑰.然後保存!</p>
                    <p>第三步：然後用手機打開Authenticator,掃描二維碼即可!<br>
                        操作了第三步,第四步就可以不用操作了.第三步第四步任選一步操作.</p>
                    <p>第四步：在谷歌身份驗證器手動添加賬戶下的輸入提供的密鑰，賬戶名稱可以為任意字符串僅標識作用，<br>然後輸入對應的密鑰【16位數字和字母組合】，類型選擇基於時間.</p>
                    <p>動態口令只有30秒有效期，會有5秒左右延遲，如延遲很大請同步手機時間即可.</p>
                    <p>註:官方建議站點為了提高後臺安全性啟用這個功能,而且這個功能的權限請不用對普通子賬號開放.</p>
                    
                </span>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    var google = {
        save:function(){
            var google_status=$('[name=google_stataus]:checked').val();
            var google_key=$('[name=google_key]').val();
            if(google_key==''){
                Core.error('密鑰不能為空');
                return;
            }
            if(google_key.length!=16){
                Core.error('密鑰長度必須為16位');
                return;
            }
            $.post('google/save_key',{google_status:google_status,google_key:google_key},function(c){
                c=eval('('+c+')');
                c.status=='OK'?Core.ok('修改成功'):Core.error('修改失敗');
            });
        }
    }
</script>
