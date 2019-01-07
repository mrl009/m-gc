<div style="width:100%;">
    <button class="btn btn-info btn-sm" type="button" onclick="add()"><i class="entypo-plus-circled"></i> 新增壹條</button>&nbsp;&nbsp;
    <button class="btn btn-success btn-sm" type="button" onclick="save()"><i class="entypo-check"></i> 保存數據</button>
</div>
<div class="row" id="slideBox"></div>
<style>
    .form-inline {
        padding-left: 12px;
    }

    #slideBox input[type=number] {
        -moz-appearance:textfield;
    }
    #slideBox input[type=number]::-webkit-inner-spin-button,
    #slideBox input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<script type="text/javascript">
    function add() {
        var html = '<div class="form-inline"><div class="form-group"><label>活動時間：&nbsp;</label><input type="datebox" name="start_time" editable="false" style="width: 155px">&nbsp;~&nbsp;</div>' +
                   '<div class="form-group"><input type="datebox" name="end_time" editable="false" style="width: 155px"></div>' +
                   '<div class="form-group"><label>&nbsp;&nbsp;紅包總額：</label><input type="number" name="price_total" style="width: 100px"></div>&nbsp;&nbsp;' +
                   '<div class="form-group"><label><button class="btn btn-danger btn-sm" onclick="del(this)">刪除</button></label></div></div>';
        $(html).appendTo('#slideBox');
        $('#slideBox .form-inline:last').find('[name=start_time]').datetimebox();
        $('#slideBox .form-inline:last').find('[name=end_time]').datetimebox();
    }

    function del(e) {
        $(e).parent().parent().parent('.form-inline').remove();
    }

    function save() {
        var arr=[], flag = true, date = new Date;
        var msg = '請輸入正確的格式';
        $('#slideBox .form-inline').each(function(){
            var start_time  = $(this).find('[name=start_time]').val();
            var end_time    = $(this).find('[name=end_time]').val();
            var price_total = $(this).find('[name=price_total]').val();
            if (start_time == '' || end_time == '') {
                flag = false;
                return;
            }

            if (date.getTime() > Date.parse(new Date(start_time))) {
                msg = '活動開始時間必須大於當前時間';
                flag = false;
                return;
            }
            if (Date.parse(new Date(start_time)) > Date.parse(new Date(end_time))) {
                msg = '活動結束時間必須大於開始時間';
                flag = false;
                return;
            }
            arr.push({
                start_time: start_time,
                end_time:   end_time,
                price_total:price_total
            });
        });
        if (flag && arr.length) {
            $.post(WEB+'redmoney/multiple_save_activeset',{data:JSON.stringify(arr)},function(c){
                c=eval('('+c+')');
                if(c.status=='OK') {
                    $('#modal').modal('hide');
                    $('.modal-backdrop').remove();
                    Core.ok('成功保存設置',true);
                    $('#<?php echo $id?>').datagrid('reload');
                } else {
                    Core.error(c.msg,true);
                }
            });
        } else {
            Core.error(msg,true);
        }
    }
</script>