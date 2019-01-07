<?php $id=uniqid();?>
<form action="member/save_agent" class="form-horizontal validate" role="form" method="post" style="width: 100%">
	<input type="hidden" name="id" value="<?php echo $rs['id']?>">
	<ul class="nav nav-tabs bordered" style="margin-top:0;padding-top:0" id="goods_tab">
		<li class="active"><a href="#basic" data-toggle="tab"><span class="hidden-xs">基本信息</span></a></li>
        <li><a href="#bank" data-toggle="tab"><span class="hidden-xs">设置银行资料</span></a></li>
        <li><a href="#count" data-toggle="tab"  class="memberItem" type="count"><span>会员统计资料</span></a></li>
        <li><a href="#cash_list" data-toggle="tab" class="memberItem" type="cash_list"><span class="hidden-xs">现金记录</span></a></li>
        <li><a href="#order" data-toggle="tab" class="memberItem" type="order"><span class="hidden-xs">投注列表</span></a></li>
        <li><a href="#log" data-toggle="tab" class="memberItem" type="log"><span class="hidden-xs">日志列表</span></a></li>
        <li><a href="#audit" data-toggle="tab" class="memberItem" type="audit"><span class="hidden-xs">稽核查询</span></a></li>
		<li><a href="#agent_user_list" data-toggle="tab" class="memberItem" type="agent_user_list"><span class="hidden-xs">代理会员列表</span></a></li>
	</ul>
    <div class="tab-content">
        <div class="tab-pane active" id="basic"><br>
            <div class="form-group">
                <label  class="col-sm-2 control-label">账号:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['username']?>" disabled>
                </div>
                <label  class="col-sm-2 control-label">出生日期:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control easyui-datebox" value="<?php echo $rs['birthday']?>" name="birthday" style="width:100%;height: 35px">
                </div>
            </div>

            <div class="form-group">
                <label  class="col-sm-2 control-label">身份证号:</label>
                <div class="col-sm-3">
                    <input type="text" class="easyui-validatebox form-control" validType='idcared' value="<?php echo $rs['idcard']?>" name="idcard" invalidMessage="请输入正确的身份证">
                </div>
                <label  class="col-sm-2 control-label">手机:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['phone']?>" name="phone" style="height: 35px;width:100%" disabled>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2 control-label">qq:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control"  value="<?php echo $rs['qq']?>"  name="qq" disabled>
                </div>
                <label  class="col-sm-2 control-label">邮箱:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['email']?>"  name="email" style="height: 35px;width:100%" disabled>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2 control-label">取款密码:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" <?php if ($this->session->userdata('admin_id') != 1) echo "disabled='true'"; ?> value="<?php echo $rs['bank_pwd']?>" name="bank_pwd" maxlength="6" onkeyup="this.value=this.value.replace(/\D/g,'')">
                </div>
                <label  class="col-sm-2 control-label">登陆密码:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['pwd']?>" name="pwd">
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2 control-label">层级:</label>
                <div class="col-sm-3">
                    <select name="level_id" class="easyui-combobox" style="width:100%; height: 35px">
                        <?php foreach($level as $v){ ?>
                            <option value="<?php echo $v['id']?>" <?php echo $v['id']==$rs['level_id']?'selected':''?>><?php echo $v['level_name']?></option>
                        <?php }?>
                    </select>
                </div>
                <label  class="col-sm-2 control-label">备注:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['remark']?>" name="remark">
                </div>
            </div>

            <div class="form-group">
                <label  class="col-sm-2 control-label">注册IP:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['addip']?>" disabled>
                </div>
                <label  class="col-sm-2 control-label">注册时间:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['addtime']?>" disabled>
                </div>
            </div>

            <div class="form-group">
                      <label  class="col-sm-2 control-label">最后登录IP:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['loginip']?>" disabled>
                </div>
                <label  class="col-sm-2 control-label">最后登录时间:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['logintime']?>" disabled>
                </div>
 
            </div>

        </div>
        <div class="tab-pane" id="bank"><br>
            <div class="form-group">
                <label  class="col-sm-2 control-label">真实姓名:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['bank_name']?>" name="bank_name"
                        <?php echo $this->session->userdata('admin_id')!=1?'readonly':''?> >
                </div>
                <label  class="col-sm-2 control-label">取款银行:</label>
                <div class="col-sm-3">
                    <select class="form-control deposit_bank" name="bank_id">
                        <?php foreach ($platform as $v){?>
                            <option value="<?php echo $v['id'];?>" <?php echo $rs['bank_id'] == $v['id'] ? 'selected' : ''?>><?php echo $v['bank_name'];?></option>
                        <?php }?>
                    </select>
                </div>

            </div>

            <div class="form-group">
                <label  class="col-sm-2 control-label">收款账号:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['bank_num']?>" name="bank_num">
                </div>

                <label  class="col-sm-2 control-label">开户行地址:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['address']?>" name="address">
                </div>
            </div>

            <div class="form-group">
            <label  class="col-sm-2 control-label">微信账号:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['bank_num']?>" name="bank_num">
                </div>
               
                 <label  class="col-sm-2 control-label">微信收款二维码:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['address']?>" name="address">
                </div>
            </div>

            <div class="form-group">
            <label  class="col-sm-2 control-label">支付宝账号:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['bank_num']?>" name="bank_num">
                </div>
               
                 <label  class="col-sm-2 control-label">支付宝收款二维码:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php echo $rs['address']?>" name="address">
                </div>
            </div>


        </div>

        <div class="tab-pane" id="count">正在加载....</div>

        <div class="tab-pane" id="cash_list">正在加载....</div>

        <div class="tab-pane" id="order">正在加载....</div>
        <div class="tab-pane" id="log">正在加载....</div>
        <div class="tab-pane" id="audit">正在加载....</div>
        <div class="tab-pane" id="agent_user_list">正在加载....</div>
    </div>
</form>
<script type="text/javascript">

	$('.memberItem').unbind('click').bind('click',function(){
		type = $(this).attr('type');
        if(type=='cash_list'){
            url='member/get_cash?uid=<?php echo $rs['id']?>';
        }else if(type=='order'){
            url='member/get_order?uid=<?php echo $rs['id']?>';
        }else if(type=='log'){
            url='member/get_log?uid=<?php echo $rs['id']?>';
        }else if (type == 'count') {
            url='member/get_count?uid=<?php echo $rs['id']?>';
        }else if (type == 'audit') {
            url='member/get_audit?username=<?php echo $rs['username']?>';
        }else if(type == 'agent_user_list'){
            var id = $('input[name="id"]').val();
            url='member/agent_user_list?id='+id;
        }

		if($('#'+type).text()=='正在加载....'){
			$.get(WEB+url,function(c){
				$('#'+type).html(c);
			});
		}
		
	});
</script>