<!-- 站点配置 -->
<style type="text/css">
    .hen1{width:390px;float: left;list-style: none;margin-right: 15px;}
    .hen2{width:144px;float: left;list-style: none;margin-right: 10px;}
    .hen3{width:390px;float: left;list-style: none;margin-right: 10px;}
    .hen4{width:144px;float: left;list-style: none;margin-right: 10px;}
    .hen5{width:144px;float: left;list-style: none;}
    .panel-headingl{margin-top: 10px;}
    .panel-bodyl{border: 0 !important;border-style: none !important;height: 144px;text-align: center;}
    .buttonl {
    width: 100%;
    padding: 0 10px 0 10px;
    font-weight: 300;
    font-family: "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    margin: 0;
    appearance: none;
    border: none;
    -moz-box-sizing: border-box;

    transition-duration: .3s;
}
</style>
<form action="" class="form-horizontal validate" id="siteSet" role="form" method="post">
    <div style="position:absolute;margin-top: 0;background-color: #ffffff;width: 100%;">
        <ul class="nav nav-tabs bordered" id="goods_tab">
            <li class="active"><a href="#basic-setting" data-toggle="tab"><span class="hidden-xs">基本配置</span></a></li>
            <li ><a href="#register-setting" data-toggle="tab"><span class="hidden-xs">注册配置</span></a></li>
        </ul>
    </div>
    <div class="tab-content" style="padding-top: 21px">
        <div class="tab-pane active" id="basic-setting"><br>
            <table class="table table-bordered">
                <tr>
                    <td>网站名称:</td>
                    <td>
                        <input type="text" class="form-control easyui-validatebox" value="<?php echo $rs['web_name']?>" name="web_name" data-options="required:true">
                        <span class="c_red">(必填)</span>
                    </td>
                </tr>
                <tr>
                    <td>LOGO/二维码:</td>
                    <td>
                        <div class="panel panel-default" data-collapsed="0" style="width:100%;">
                            <ul style="float: left;list-style: none;">
                                <li class="hen1">
                            <div class="panel-bodyl">
                                <img <?php if($rs['logo']) echo "src='$rs[logo]'"?> class="qrcode_thumb img-rounded logo_thumb" style="width:390px;height: 144px;">
                                <input type="hidden" name="logo" value="<?php echo $rs['logo']?>">
                            </div>
                               <div class="panel-headingl">
                                <div class="panel-titlel">
                                    <button class="buttonl button-primary" id="logo_uploadBtn"><i class="entypo-upload"></i> 电脑LOGO(460*170)</button>
                                </div>
                            </div>
                               </li>
                               <li class="hen2">
                            <div class="panel-bodyl">
                                <img <?php if($rs['logo_wap']) echo "src='$rs[logo_wap]'"?> class="qrcode_thumb img-rounded logo_thumb_wap" style="width:144px;height: 144px;">
                                <input type="hidden" name="logo_wap" value="<?php echo $rs['logo_wap']?>">
                            </div>
                                  <div class="panel-headingl">
                                <div class="panel-titlel">
                                    <button class="buttonl button-primary" id="logo_uploadBtn_wap"><i class="entypo-upload"></i>手机LOGO(144*144)</button>
                                </div>
                            </div>
                               </li>
                                <li class="hen3">
                                    <div class="panel-bodyl">
                                        <img <?php if($rs['wap_head_logo']) echo "src='$rs[wap_head_logo]'"?> class="qrcode_thumb img-rounded wap_head_logo" style="width:390px;height:144px;">
                                        <input type="hidden" name="wap_head_logo" value="<?php echo $rs['wap_head_logo']?>">
                                    </div>
                                    <div class="panel-headingl">
                                        <div class="panel-titlel">
                                            <button class="buttonl button-primary" id="wap_head_logoBtn_wap"><i class="entypo-upload"></i> 手机首页头部logo(390*144)</button>
                                        </div>
                                    </div>
                                </li>
                               <li class="hen4">
                            <div class="panel-bodyl">
                                <img <?php if($rs['ios_qrcode']) echo "src='$rs[ios_qrcode]'"?> class="qrcode_thumb img-rounded ios_qrcode" style="width:144px;height: 144px;">
                                <input type="hidden" name="ios_qrcode" value="<?php echo $rs['ios_qrcode']?>">
                            </div>
                             <div class="panel-headingl">
                                <div class="panel-titlel">
                                    <button class="buttonl button-primary" id="ios_qrcodeBtn"><i class="entypo-upload"></i> IOS二维码(200*200)</button>
                                </div>
                            </div>
                              </li>
                               <li class="hen5">
                            <div class="panel-bodyl">
                                <img <?php if($rs['android_qrcode']) echo "src='$rs[android_qrcode]'"?> class="qrcode_thumb img-rounded android_qrcode" style="width:144px;height: 144px;">
                                <input type="hidden" name="android_qrcode" value="<?php echo $rs['android_qrcode']?>">
                            </div>
                            <div class="panel-headingl">
                                <div class="panel-titlel">
                                    <button class="buttonl button-primary" id="android_qrcodeBtn"><i class="entypo-upload"></i> 安卓二维码(200*200)</button>
                                </div>
                            </div>
                        </li>
                         </ul>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>关键字:</td>
                    <td>
                        <input type="text" class="form-control"  value="<?php echo $rs['keyword']?>" name="keyword">
                        <span class="c_red">(站点关键词)</span>
                    </td>
                </tr>

                <tr>
                    <td>站点描述:</td>
                    <td>

                        <input type="text" class="form-control"  value="<?php echo $rs['description']?>" name="description">
                        <span class="c_red">(站点说明)</span>
                    </td>
                </tr>
                <tr>
                    <td>版权信息:</td>
                    <td>
                        <input type="text" class="form-control easyui-validatebox"  value="<?php echo $rs['copyright']?>" name="copyright" data-options="required:true">
                        <span class="c_red">(必填)</span>
                    </td>
                </tr>
                <tr>
                    <td>客服QQ:</td>
                    <td>
                        <input type="text" class="form-control"  value="<?php echo $rs['qq']?>" name="qq">
                    </td>
                </tr>
                <tr>
                    <td>EMAIL:</td>
                    <td>
                        <input type="email" class="form-control"  value="<?php echo $rs['email']?>" name="email">
                        <span class="c_red">(多个邮箱中间用,隔开)</span>
                    </td>
                </tr>
                <tr>
                    <td>客服热线:</td>
                    <td>
                        <input type="tel" class="form-control" value="<?php echo $rs['tel']?>" name="tel">
                        <span class="c_red">(多个电话中间用,隔开)</span>
                    </td>
                </tr>
                <tr>
                    <td>易记域名:</td>
                    <td>
                        <input type="text" class="form-control"  value="<?php echo $rs['domain']?>" name="domain">
                    </td>
                </tr>
                <tr>
                    <td>在线客服:</td>
                    <td>
                        <input type="tel" class="form-control"  value="<?php echo $rs['online_service']?>" name="online_service">
                    </td>
                </tr>
                <tr>
                    <td>手机网站名称:</td>
                    <td>
                        <input type="text" class="form-control easyui-validatebox"  value="<?php echo $rs['wap_name']?>" name="wap_name" data-options="required:true">
                        <span class="c_red">(必填)</span>
                    </td>
                </tr>
                 <tr>
                    <td>ios公司名称:</td>
                    <td>
                        <input type="text" class="form-control easyui-validatebox"  value="<?php echo $rs['ios_name']?>" name="ios_name" data-options="required:true">
                        <span class="c_red">(必填)</span>
                    </td>
                </tr>

 <!--                <tr>
                    <td>手机站域名:</td>
                    <td>
                        <input type="text" class="form-control easyui-validatebox"  value="<?php echo $rs['wap_domain']?>" name="wap_domain">
                </tr> -->
                <tr>
                    <td>APP下载地址:</td>
                    <td>
                        <input type="text" class="form-control easyui-validatebox"  value="<?php echo $rs['app_download']?>" name="app_download">
                </tr>

                <tr>
                    <td>默认支付来路域名:</td>
                    <td><?php echo $rs['pay_domain']?></td>
                </tr>
                <tr>
                    <td>出入款自动过期时间:</td>
                    <td>
                        <input type="text"  name="incompany_timeout" value="<?php echo $rs['incompany_timeout']?>"><span class="c_red">分钟</span>&nbsp;&nbsp;<span class="c_red">* 公司入款,第三方入款未处理自动取消时间. </span>
                    </td>
                </tr>
                <tr>
                    <td>入款操作时间限制:</td>
                    <td>
                        <input type="text"  name="income_time" value="<?php echo $rs['income_time']?$rs['income_time']:0?>"><span class="c_red">分钟</span>&nbsp;&nbsp;<span class="c_red">* 公司入款,入款操作限制时间. </span>
                    </td>
                </tr>
                <tr>
                    <td>公司入款:</td>
                    <td>
                        <input type="text"  name="incompany_count" value="<?php echo $rs['incompany_count']?>"><span class="c_red">笔数</span>&nbsp;&nbsp;<span class="c_red">* 公司入款最多单个会员未处理笔数. </span>
                    </td>
                </tr>
                <tr>
                    <td>出款次数:</td>
                    <td>
                        <input type="text"  name="default_out_num" value="<?php echo $rs['default_out_num']?>"><span class="c_red">笔数/天</span>&nbsp;&nbsp;<span class="c_red">* 默认会员每天出款次数. </span>
                    </td>
                </tr>
                <!--<tr>
                    <td>APP,H5主色调</td>
                    <td>
                        <input type="text"  name="app_color" id="picker" value="<?php /*echo $rs['app_color']*/?>">
                        <span style="padding:2px 10px;background: <?php /*echo $rs['app_color']*/?>" id="adminc">&nbsp;</span>
                        <span class="c_red">点击选择颜色,请选择合适的颜色.</span>&nbsp;&nbsp;
                    </td>
                </tr>-->
                <tr class="hidden">
                    <td>首页默认选中显示彩票</td>
                    <td>
                        <input type="radio"  name="cp_default" value="1" checked><?php echo $rs['sys_games']?>&nbsp;&nbsp;
                        <input type="radio"  name="cp_default" value="0">官方彩票&nbsp;&nbsp;
                        &nbsp;&nbsp;<span class="c_red">* 首页优先显示彩种,务必要开通对应彩票,如:这里选择"官方彩票",下面选项一定要选中"官方彩票".</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr class="hidden">
                    <td>彩票开通</td>
                    <td>
                        <label class="fwn"><input type="checkbox" name="lottery_auth[]" value="1">官方彩票</label>
                        <label class="fwn"><input type="checkbox" name="lottery_auth[]" value="2" checked><?php echo $rs['sys_games']?></label>
                        <!--<label class="fwn"><input type="checkbox" name="lottery_auth[]" value="3" <?php /*if (in_array(3, $rs['lottery_auth'])) echo 'checked';*/?>>电子游艺</label>
                        <label class="fwn"><input type="checkbox" name="lottery_auth[]" value="4" <?php /*if (in_array(4, $rs['lottery_auth'])) echo 'checked';*/?>>视讯</label>-->&nbsp;&nbsp;<span class="c_red">* 如果想要完全不可用,请去"设置-彩票管理"把对应彩种下架处理.</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>系统活动</td>
                    <td>
                        <label class="fwn"><input type="checkbox" name="sys_activity[]" value="1" <?php if (in_array(1, $rs['sys_activity'])) echo 'checked';?>>晋级奖励</label>
                        <label class="fwn"><input type="checkbox" name="sys_activity[]" value="2" <?php if (in_array(2, $rs['sys_activity'])) echo 'checked';?>>每日加奖</label>
                    </td>
                </tr>
                <tr>
                    <td>出款方式</td>
                    <td>
                        <input type="radio"  name="win_dml" value="0" <?php if ($rs['win_dml'] == 0) echo 'checked';?>>按稽核&nbsp;&nbsp;
                        <input type="radio"  name="win_dml" value="1" <?php if ($rs['win_dml'] == 1) echo 'checked';?>>按免费额度&nbsp;&nbsp;
                        <input type="radio"  name="win_dml" value="2" <?php if ($rs['win_dml'] == 2) echo 'checked';?>>未达到稽核不能出款&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>每日加奖阶梯设置:</td>
                    <td>
                        <input type="text" class="form-control w120"  value="<?php echo $rs['reward_day'][0]?>" name="reward_day[]">&nbsp;&nbsp;
                        <input type="text" class="form-control w120"  value="<?php echo $rs['reward_day'][1]?>" name="reward_day[]">&nbsp;&nbsp;
                        <input type="text" class="form-control w120"  value="<?php echo $rs['reward_day'][2]?>" name="reward_day[]">
                    </td>
                </tr>
                <tr>
                    <td>苹果APP版本下载地址:</td>
                    <td>
                        <input type="text" class="form-control"  value="<?php echo $rs['ios_app_setting']['url']?>" name="ios_app_download_url">
                        版本号: <input type="text" class="form-control w120"  value="<?php echo $rs['ios_app_setting']['version']?>" name="ios_app_version">
                        是否强制更新 <label class="fwn"><input type="checkbox" name="ios_update_flag" value="1" <?php if ($rs['ios_app_setting']['is_must_update'] == 1) echo 'checked';?>> 是 </label>

                    </td>
                </tr>
                <tr>
                    <td>安卓APP版本下载地址:</td>
                    <td>
                        <input type="text" class="form-control"  value="<?php echo $rs['android_app_setting']['url']?>" name="android_app_download_url">
                        版本号: <input type="text" class="form-control w120"  value="<?php echo $rs['android_app_setting']['version']?>" name="android_app_version">
                        是否强制更新  <label class="fwn"><input type="checkbox" name="android_update_flag" value="1" <?php if ($rs['android_app_setting']['is_must_update'] == 1) echo 'checked';?>> 是 </label>

                    </td>
                </tr>

                <tr>
                    <td>安卓APP下载、二维码校验</td>
                    <td>
                        <input type="text" id="android_link_check" name="android_link_check" class="form-control easyui-validatebox" value="<?php echo $rs['android_link_check']?>" />&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>苹果APP下载、二维码校验</td>
                    <td>
                        <input type="text" id="ios_link_check" name="ios_link_check" class="form-control easyui-validatebox" value="<?php echo $rs['ios_link_check']?>" />&nbsp;&nbsp;
                    </td>
                </tr>


                <tr>
                    <td>安卓APPKEY</td>
                    <td>
                        <input type="text"  name="app_key" class="form-control easyui-validatebox" value="<?php echo $rs['app_key']?>"><span class="c_red">请填写appkey如：5975a450210c9332ab01106a</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>安卓秘钥</td>
                    <td>
                        <input type="text"  name="app_master_secret" class="form-control easyui-validatebox" value="<?php echo $rs['app_master_secret']?>"><span class="c_red">请填写APP_MASTER_SECRET如：b21kulb0u33v4elibfls4itelkdif5ld</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>苹果APPKEY</td>
                    <td>
                        <input type="text"  name="ios_app_key" class="form-control easyui-validatebox" value="<?php echo $rs['ios_app_key']?>"><span class="c_red">请填写appkey如：5975a450210c9332ab01106a</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>苹果秘钥</td>
                    <td>
                        <input type="text"  name="ios_app_master_secret" class="form-control easyui-validatebox" value="<?php echo $rs['ios_app_master_secret']?>"><span class="c_red">请填写APP_MASTER_SECRET如：b21kulb0u33v4elibfls4itelkdif5ld</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>分享页面说明</td>
                    <td>
                        <input type="text"  name="fenxiang_string" class="form-control easyui-validatebox" value="<?php echo $rs['fenxiang_string']?>"><span class="c_red">例如：邀请注册送积分</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>快速充值链接</td>
                    <td>
                        <input type="text"  name="quick_recharge_url" class="form-control" value="<?php echo $rs['quick_recharge_url']?>">
                        <span class="c_red">快速充值网址跳转出去充值</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <!--<tr>
                    <td>自主彩杀率</td>
                    <td>
                        <input onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " name="win_rand" value="<?php /*echo $win_rand*/?>" class="form-control" maxlength="2">
                        <span class="c_red">数字从1到10整数,数值越低杀率越高,如果想赢多就把数字调小,如果想赢少就把数字调大![建议设置在4-8之间]</span>&nbsp;&nbsp;
                    </td>
                </tr>-->
            </table>
        </div>
        <div class="tab-pane" id="register-setting"><br>
            <table class="table table-bordered">
                <tr>
                    <td>是否开启充值中心弹窗</td>
                    <td>
                        <input type="radio"  name="is_bomb_box" value="1" <?php if ($rs['is_bomb_box'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="is_bomb_box" value="0" <?php if ($rs['is_bomb_box'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                        &nbsp;&nbsp;<span class="c_red">* 弹窗内容请去"设置"-"支付信息"-"充值中心弹窗"处填写.</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>是否开启彩豆充值</td>
                    <td>
                        <input type="radio"  name="card_status" value="1" <?php if ($rs['card_status'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="card_status" value="0" <?php if ($rs['card_status'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>是否开启注册</td>
                    <td>
                        <input type="radio"  name="register_is_open" value="1" <?php if ($rs['register_is_open'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="register_is_open" value="0" <?php if ($rs['register_is_open'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>是否开启注册验证码</td>
                    <td>
                        <input type="radio"  name="register_open_verificationcode" value="1" <?php if ($rs['register_open_verificationcode'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="register_open_verificationcode" value="0" <?php if ($rs['register_open_verificationcode'] != 1) echo 'checked';?>>否
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="c_red">* 选择否注册不用填写验证码".</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>是否开启注册真实姓名</td>
                    <td>
                        <input type="radio"  name="register_open_username" value="1" <?php if ($rs['register_open_username'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="register_open_username" value="0" <?php if ($rs['register_open_username'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                        &nbsp;&nbsp;<span class="c_red">* 选择否注册不用填写姓名".</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>真实姓名是否唯一</td>
                    <td>
                        <input type="radio"  name="is_unique_name" value="1" <?php if ($rs['is_unique_name'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="is_unique_name" value="0" <?php if ($rs['is_unique_name'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>银行卡是否唯一</td>
                    <td>
                        <input type="radio"  name="is_unique_bank" value="1" <?php if ($rs['is_unique_bank'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="is_unique_bank" value="0" <?php if ($rs['is_unique_bank'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                        <label class="fwn"><input type="checkbox" name="bank_num_check" value="1" <?php echo $rs['bank_num_check']==1?'checked':''?>>是否开启银行卡真实认证[可能出现银行卡无法绑定慎用]</label>
                    </td>
                </tr>
                <!--<tr>
                    <td>是否开启支付宝绑定</td>
                    <td>
                        <input type="radio"  name="is_open_alipay" value="1" <?php /*if ($rs['is_open_alipay'] == 1) echo 'checked';*/?>>是&nbsp;&nbsp;
                        <input type="radio"  name="is_open_alipay" value="0" <?php /*if ($rs['is_open_alipay'] != 1) echo 'checked';*/?>>否&nbsp;&nbsp;
                        &nbsp;&nbsp;<span class="c_red">* 选择否支付宝绑定不可用".</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>是否开启微信绑定</td>
                    <td>
                        <input type="radio"  name="is_open_wechat" value="1" <?php /*if ($rs['is_open_wechat'] == 1) echo 'checked';*/?>>是&nbsp;&nbsp;
                        <input type="radio"  name="is_open_wechat" value="0" <?php /*if ($rs['is_open_wechat'] != 1) echo 'checked';*/?>>否&nbsp;&nbsp;
                        &nbsp;&nbsp;<span class="c_red">* 选择否微信绑定不可用".</span>&nbsp;&nbsp;
                    </td>
                </tr>-->
                <tr>
                    <td>设置资金密码需要手机号</td>
                    <td>
                        <input type="radio"  name="is_phone" value="1" <?php if ($rs['is_phone'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="is_phone" value="0" <?php if ($rs['is_phone'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                        &nbsp;&nbsp;<span class="c_red">* 选择否绑定银行卡不用填写手机号码".</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>是否开启密码强度验证</td>
                    <td>
                        <input type="radio"  name="strength_pwd" value="1" <?php if ($rs['strength_pwd'] == 1) echo 'checked';?>>是&nbsp;&nbsp;
                        <input type="radio"  name="strength_pwd" value="0" <?php if ($rs['strength_pwd'] != 1) echo 'checked';?>>否&nbsp;&nbsp;
                    </td>
                </tr>
                <tr class="hidden">
                    <td>是否开启邀请码注册</td>
                    <td>
                        <input type="radio"  name="is_agent" value="1">是&nbsp;&nbsp;
                        <input type="radio"  name="is_agent" value="0">否&nbsp;&nbsp;
                        <input type="radio"  name="is_agent" value="2" checked><label>开启并且为必填项</label>&nbsp;&nbsp;
                        <span class="c_red">* 选择否注册看不到邀请码选项".</span>&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td>注册会员送优惠</td>
                    <td>
                        <input type="text"  name="register_discout" value="<?php echo $rs['register_discout']?>"><span class="c_red">* 为零时会员不赠送优惠</span>&nbsp;&nbsp;
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="1" <?php if (in_array(1, $rs['register_discount_from_way'])) echo 'checked';?>>IOS</label>
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="2" <?php if (in_array(2, $rs['register_discount_from_way'])) echo 'checked';?>>安卓</label>
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="3" <?php if (in_array(3, $rs['register_discount_from_way'])) echo 'checked';?>>PC</label>
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="4" <?php if (in_array(4, $rs['register_discount_from_way'])) echo 'checked';?>>WAP</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="6" <?php if (in_array(6, $rs['register_discount_from_way'])) echo 'checked';?>>勾住绑定银行卡后才送优惠</label>
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="7" <?php if (in_array(7, $rs['register_discount_from_way'])) echo 'checked';?>>绑定支付宝送优惠</label>
                        <label class="fwn"><input type="checkbox" name="register_discount_from_way[]" value="8" <?php if (in_array(8, $rs['register_discount_from_way'])) echo 'checked';?>>绑定微信送优惠</label>
                    </td>
                </tr>
                <tr>
                    <td>同一IP允许注册次数</td>
                    <td>
                        <input type="text"  name="register_num_ip" value="<?php echo $rs['register_num_ip']?>"><span class="c_red">次</span>&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div style="text-align: center;">
        <button type="button" class="btn btn-success site_button" onclick="_savesetting(this)">提交</button>
    </div>
</form>

<script src="static/js/reqrcode.js"></script>
<script type="text/javascript">
    Core.singleUploader('logo_uploadBtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.logo_thumb').attr('src',rs.result);
        $('[name=logo]').val(rs.result);
    });
    Core.singleUploader('logo_uploadBtn_wap',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.logo_thumb_wap').attr('src',rs.result);
        $('[name=logo_wap]').val(rs.result);
    });
    Core.singleUploader('wap_head_logoBtn_wap',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.wap_head_logo').attr('src',rs.result);
        $('[name=wap_head_logo]').val(rs.result);
    });
    Core.singleUploader('ios_qrcodeBtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.ios_qrcode').attr('src',rs.result);
        $('[name=ios_qrcode]').val(rs.result);
    });
    Core.singleUploader('android_qrcodeBtn',[{title : "Image files", extensions : "jpeg,gif,png,jpg"}],'1mb',function(rs){
        $('.android_qrcode').attr('src',rs.result);
        $('[name=android_qrcode]').val(rs.result);
    });
    /*Core.singleUploader('h5_qrcodeBtn',[{title : "Image files", extensions : "ico"}],'1mb',function(rs){
     $('.h5_qrcode').attr('src',rs.result);
     $('[name=h5_qrcode]').val(rs.result);
     });*/
    function savesetting(e){
        /*var cp_default = $("#basic-setting input[name='cp_default']:checked").val();
        var lottery_auth = $("#basic-setting input[name='lottery_auth\[\]']:checked");
        var flag = false;
        if (lottery_auth != undefined && lottery_auth.length > 0) {
            $.each(lottery_auth, function (i, d) {
                if (cp_default==0 && $(d).val() ==1) {
                    flag = true;
                    return;
                }
                if (cp_default==1 && $(d).val() ==2) {
                    flag = true;
                    return;
                }
            })
        }
        if (!flag) {
            Core.error('首页默认选中显示彩票必须开启彩票权限');
            return;
        }*/
        $(e).parents('form').form('submit',{
            ajax:true,
            url:'setting/save_set',
            contentType: "application/json", //必须这样写
            onSubmit: function(){
                return $(this).form('enableValidation').form('validate');
            },
            success:function(c){
                c=eval('('+c+')');
                switch(c.status){
                    case "ERROR": Core.error(c.msg,'error'); break;
                    case 'OK': Core.ok('基础信息修改成功'); break;
                    default: Core.error(c);
                }
            }
        });
    }

    var savesetting_cb;
    function _savesetting(e){
        // 下载地址 和 二维码 检查
        var android_check = $('#android_link_check').val();
        var ios_check = $('#ios_link_check').val();
        var android_qrcode_msg = '';
        var ios_qrcode_msg = '';
        var cbn = 0;
        savesetting_cb = function () {
            cbn++;
            if ( cbn == 1 ) {
                var url = $('input[name="ios_qrcode"]').val();
                qrcode.decode('/setting/get_img?url='+ url);
                return;
            }
            errnu = 0;
            if ( cbn == 2 ) {
                if ( android_check != '' ) {
                    var android_link = $('input[name="android_app_download_url"]').val();
                    if ( android_link != '' && android_link.indexOf(android_check) == -1 ) {
                        // 未找到
                        alert('校验不通过，Android下载地址未包含关键字！');
                        errnu ++;
                        return;
                    }
                    if ( errnu == 0 && android_qrcode_msg != '' && android_qrcode_msg.indexOf(android_check) == -1 ) {
                        // 未找到
                        alert('校验不通过，Android二维码地址未包含关键字！');
                        errnu ++;
                        return;
                    }
                }
                if ( ios_check != '' ) {
                    var ios_link = $('input[name="ios_app_download_url"]').val();
                    if (errnu == 0 && ios_link != '' && ios_link.indexOf(ios_check) == -1 ) {
                        // 未找到
                        alert('校验不通过，IOS下载地址未包含关键字！');
                        errnu ++;
                        return;
                    }
                    if ( errnu == 0 && ios_qrcode_msg != '' && ios_qrcode_msg.indexOf(ios_check) == -1 ) {
                        // 未找到
                        alert('校验不通过，IOS二维码地址未包含关键字！');
                        errnu ++;
                        return;
                    }
                }
                if ( errnu == 0 && ( android_check != '' || ios_check != '') ) {
                    alert('校验通过，下载地址和二维码地址均包含关键字！');
                }
                savesetting(e);
            }
        }
        qrcode.callback = function (imgMsg) {
            if ( imgMsg == 'Failed to load the image' || imgMsg == 'error decoding QR Code' ) {
                //alert( (cbn == 0 ? 'Android' : 'IOS') + '二维码图片识别失败！');
            } else {
                if ( cbn == 0 ) {
                    android_qrcode_msg = imgMsg;
                } else {
                    ios_qrcode_msg = imgMsg;
                }
            }
            savesetting_cb();
        }
        var url = $('input[name="android_qrcode"]').val();
        qrcode.decode('/setting/get_img?url='+ url);
    }



    //选取颜色
    $('#picker').colpick({
    layout:'hex',
    submit:0,
    colorScheme:'dark',
    onChange:function(hsb,hex,rgb,el,bySetColor) {
        //$(el).css('border-color','#'+hex);
        $('#adminc').css('background-color','#'+hex);
        // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
        if(!bySetColor) $(el).val('#'+hex);
    }
}).keyup(function(){
    $(this).colpickSetColor(this.value);
});
</script>