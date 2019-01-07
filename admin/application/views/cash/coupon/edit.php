<form action="cash/ajax_coupon_edit" class="form-horizontal validate" method="post" id="coupon_edit">
    <table>
        <tr>
            <td width="50%;">每個用戶允許充值次數</td>
            <td width="50%;">
            <input type="text" class="form-control" placeholder="" name="user_card_cishu"></td>
        </tr>
        <tr>
            <td width="50%;">每個IP允許充值次數</td>
            <td><input type="text" class="form-control" placeholder="" name="ip_cishu"></td>
        </tr>
    </table>
</form>

<script>

    $(document).ready(function(){

        var url = 'cash/getlist';

        $.ajax({
            url: url,// 跳轉到 action
            data: {

            },
            type: 'post', //用post方法
            cache: false,
            dataType: 'json',//數據格式為json,定義這個格式data不用轉成對象
            success: function (data) {

                $("input[name='ip_cishu']").attr('placeholder',data.cishu.ip_cishu);
                $("input[name='user_card_cishu']").attr('placeholder',data.cishu.user_card_cishu);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.responseText.indexOf("script")>-1) {
                    $('#coupon_edit').html(XMLHttpRequest.responseText);
                } else {
                    Core.error('接口請求異常 '+XMLHttpRequest.responseText+' '+textStatus);
                }
            }
        });

    });

</script>