<style type="text/css">
    #interactive-site td:first-child 
    { 
        width: 160px; 
        padding-right: 10px; 
        text-align: right;
    }
</style>
<div id="interactive-site" class="tab-content" style="padding-top: 15px">
    <div class="tab-pane active">
        <table class="table table-bordered"> 
            <!--
            <tr>
                <td>运行状态:</td>
                <td>
                    <span class=""><label><input type="radio" value="1" name="is_open_hddt">&nbsp;开启&nbsp; </label></span>
                    <span class=""><label><input type="radio" value="0" name="is_open_hddt">&nbsp;关闭&nbsp; </label></span>
                    <button id="refresh_open_hddt" class="buttonl button-primary" style="width: 100px; margin-left: 10px;">保存</button><br /><br />
                    <p><span style="color: red;">注意：关闭互动大厅时,手机端底部将看不到互动大厅的入口
                    </span></p>
                </td>
            </tr>
            <tr>
                <td>计划软件接口CODE:</td>
                <td>
                    <span class="plan_code"><?php echo $code;?></span>
                    <button id="refresh_plan_code" class="buttonl button-primary" style="width: 100px; margin-left: 10px;">更换</button> <br />
                    <p>
                        计划软件接口地址：<?php echo $plan_url;?><br />
                        <span style="color: red;">注意：gcapi.com替换为相应的站点的gcapi地址</span> 
                    </p>
                </td>
            </tr>
            -->
            <tr>
                <td>全局禁言设置:</td>
                <td>
                    <span class=""><label><input type="radio" value="1" name="is_all_silence" <?php echo $is_all_silence == 1 ? 'checked' : ''?>>&nbsp;开启&nbsp; </label></span>
                    <span class=""><label><input type="radio" value="0" name="is_all_silence" <?php echo $is_all_silence == 0 ? 'checked' : ''?>>&nbsp;关闭&nbsp; </label></span>
                    <button id="refresh_silence_set" class="buttonl button-primary" style="width: 100px; margin-left: 10px;">保存</button><br /><br />
                    <p><span style="color: red;">注意：开启全局禁言时只有管理员才能发言
                    </span></p>
                </td>
            </tr>
            
        </table>
    </div>
</div>

<script>
    $('#refresh_plan_code').click(function(){
        var url = '/interactive/activity/get_plan_code';
        refresh(url,{update:'1'});
    });

    $('#refresh_open_hddt').click(function(){
        var status = $('[name=is_open_hddt]:checked').val();
        var url = '/interactive/activity/save_set';
        refresh(url,{key:'is_open_hddt',value:status});
    });

    $('#refresh_silence_set').click(function(){
        var status = $('[name=is_all_silence]:checked').val();
        var url = '/interactive/activity/save_set';
        refresh(url,{key:'is_all_silence',value:status});
    });
    
    var refresh = function(url,data) {
        $.ajax({url:url,data:data,type:"POST",dataType:'json',
            success : function(reps) 
            {
                if (reps.status && ('OK' == reps.status))
                {
                    layer.msg('保存成功',{time:1000},Core.refresh());
                } else if (reps.code) {
                    layer.msg('更换成功',{time:1000},Core.refresh());
                } else {
                    var msg = reps.msg ? reps.msg : '操作失败';
                    layer.msg(msg,{time:1000},Core.refresh());
                }
            }
        });
    }
</script>