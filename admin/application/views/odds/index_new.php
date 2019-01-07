<div style="padding:5px" class="listLottery" id="odds">
	<div style="padding-bottom: 10px">
		<button type="button" class="btn btn-success" onclick="Oddss.updateOdds()">賠率初始化</button>
		<button type="button" class="btn btn-warning" onclick="Oddss.delCache('play')">清除所有緩存</button>
		<button type="button" class="btn btn-info delone" onclick="Oddss.delCache('e')">清除緩存</button>
		<span class="label label-danger">賠率/退水修改後請壹定要清除緩存,否則無法下註</span>
	</div>
	<div id="cpLists">
	<?php foreach($games as $v){?>
		<a type="button" class="btn btn-link cpbtn" tmp="<?php echo $v['tmp']?>" val="<?php echo $v['id']?>" onclick="Oddss.change(this)"><?php echo $v['name']?></a>
	<?php }?>
	</div>
	<div style="width: 100%;" id="newsOdds"></div>
</div>
<script>
	var Oddss={
		init:function(){
		    var id = $('#odds .cpbtn').eq(0).attr('val');
		    var tmp = $('#odds .cpbtn').eq(0).attr('tmp');
            Oddss.getlist(id,tmp);
			$('#odds .delone').text('清除'+$('#odds .cpbtn').eq(0).text()+'緩存');
			$('#odds .cpbtn').eq(0).removeClass('btn-link');
			$('#odds .cpbtn').eq(0).addClass('btn-danger');
		},
		getlist:function(id,tmp){
			layer.msg('加載中', {icon: 16,shade: 0.01});
			$.get('odds/get_list_new?id='+id+'&tmp='+tmp+'&ctg=<?php echo $ctg?>',function(c){
				$('#newsOdds').html(c);
				layer.closeAll();
			});
		},
		change:function(e){
			$('#odds .delone').text('清除'+$(e).text()+'緩存');
			$('#odds .cpbtn').removeClass('btn-danger');
			$('#odds .cpbtn').addClass('btn-link');
			$(e).removeClass('btn-link');
			$(e).addClass('btn-danger');
			Oddss.getlist($(e).attr('val'),$(e).attr('tmp'));
		},
		saveOdds:function(e){
			var _=$(e).parent().parent();
			setid    =_.find('.setid').val();
			rate     =_.find('.rate').val();
			rate_min =_.find('.rate_min').val();
			rebate   =_.find('.rebate').val();
			ratelist =_.find('.ratelist');
			rate_minlist =_.find('.rate_minlist');
			
			if(setid=='' || rate==''){
				Core.error('輸入信息有誤');
				return;
			}
			if(rate!=undefined){
					if(rate<=0){
					Core.error('賠率數據不合法');
					return;
				}
			}else{
				if(ratelist!=undefined){
					var dd=[];
					var Exit=false;
					$.each(ratelist,function(i,d){
						if($(d).val()==''){
							Core.error('輸入賠率有誤');
							Exit=true;
						}
						dd.push($(d).val());
					});
					if(Exit) return false;
					rate=dd.join(',');
				}
			}
			
			if(rate_min!=undefined){
					if(rate_min<=0){
					Core.error('最小賠率數據不合法');
					return;
				}
			}else{
				if(rate_minlist!=undefined){
					var dd=[];
					var Exit=false;
					$.each(rate_minlist,function(i,d){
						if($(d).val()==''){
							Core.error('輸入賠率有誤');
							Exit=true;
						}
						dd.push($(d).val());
					});
					if(Exit) return false;
					rate_min=dd.join(',');
				}
				
			}
			
			if(rebate!=undefined && rebate!=''){
				if(rebate<0 || isNaN(rebate)){
					Core.error('返水數據不合法');
					return;
				}
			}
			$.post('odds/save_odds',{setid:setid,rate:rate,rate_min:rate_min,rebate:rebate},function(c){
				c=eval('('+c+')');
				if(c.status=='OK'){
					Core.ok('修改成功');
				}else{
					Core.error(c.msg);
				}
			});
		},
		updateOdds:function(){
			var id=$('#cpLists .btn-danger').attr('val');
			var tmp=$('#cpLists .btn-danger').attr('tmp');
			$.messager.confirm('溫馨提示', '確定要初始化賠率嗎', function(r){
				if (r){
					$.post('odds/rate_init',{id:id},function(c){
						c=eval('('+c+')');
						if(c.status=='OK'){
							Oddss.getlist(id,tmp);
							Core.ok('初始化成功');
						}else{
							Core.error(c.msg);
						}
					});
				}
			});
		},
		//刪除緩存
		delCache:function(e){
			var id=$('#cpLists .btn-danger').attr('val');
			var tmp=$('#cpLists .btn-danger').attr('tmp');
			var title=$('#cpLists .btn-danger').text();
			if(e=='play') {
				id='';
				title='所有彩票';
			}
			$.messager.confirm('溫馨提示', '確定要刪除('+title+')緩存嗎', function(r){
				if (r){
					$.post('odds/del_cache',{id:id},function(c){
						c=eval('('+c+')');
						if(c.status=='OK'){
							Oddss.getlist(id,tmp);
							Core.ok('刪除緩存成功');
						}else{
							Core.error(c.msg);
						}
					});
				}
			});
		},
		batchUpdate:function(obj){
			var tid =$(obj).parent().find('.tid').val();
			var allrate=$(obj).parent().find('.allrate').val();
			var allrebate=$(obj).parent().find('.allrebate').val();
			if(allrate=='' && allrebate==''){
				Core.error('請輸入的賠率或返水');
				return;
			}
			$.post('odds/save_odds_batch',{tid:tid,rate:allrate,rebate:allrebate},function(c){
				c=eval('('+c+')');
				if(c.status=='OK'){
					//Oddss.getlist(id);
					Core.ok('批量修改成功');
				}else{
					Core.error(c.msg?c.msg:'未知錯誤');
				}
			});
			
		},
		yz:function(obj){
			//修復第壹個字符是小數點 的情況.  
	        if(obj.value !=''&& obj.value.substr(0,1) == '.'){  
	            obj.value="";  
	        }  
	        obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“數字”和“.”以外的字符  
	        //obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第壹個. 清除多余的       
	        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); 1
	        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d\d).*$/,'$1$2.$3');//只能輸入三個小數       
	        if(obj.value.indexOf(".")< 0 && obj.value !=""){	//以上已經過濾，此處控制的是如果沒有小數點，首位不能為類似於 01、02的金額  
	            if(obj.value.substr(0,1) == '0' && obj.value.length == 2){  
	                obj.value= obj.value.substr(1,obj.value.length);      
	            }  
	        }      
		},
		allUpdate:function(obj){
			Oddss.yz(obj);
			var _=$(obj).parent().parent().find('.oddslistInfo .rate');
			_.val($(obj).val());
		},
		allTs:function(obj){
			Oddss.yz(obj);
			var _=$(obj).parent().parent().find('.oddslistInfo .rebate');
			_.val($(obj).val());
		}
	};
	Oddss.init();
</script>
<style>
fieldset{margin:0 2px;border:1px solid silver}
legend{border:0;width:auto; font-size: 14px;padding: 24px 10px 0 10px;}
.oddslist{margin-top:10px;}
.oddslist h4{ line-height:40px;margin-top:0px;margin-bottom: -10px !important; background:#F2F2F2;padding-left: 15px; height: 40px;}
.listLottery button{border:0 !important;}
.listLottery .form-group{}
</style>