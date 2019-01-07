<!-- 賠率設置 -->
<div id="oddContent">
	<form class="form-horizontal" style='line-height: 30px; margin: 10px;'>
	  	<label class="control-label">請選擇彩票類型</label>
		<select class="input-group form-control" style="width:130px; height: 36px; line-height: 30px;" onchange="Odds.change(this)" id="games_odds">
		<?php foreach($games as $v){?>
		  	<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
		 <?php }?>
		</select>
		<button type="button" class="btn btn-danger" onclick="Odds.updateOdds()">賠率初始化</button>
		<button type="button" class="btn btn-danger" onclick="Odds.updateOdds()">清除所有緩存</button>
		
		<button type="button" class="btn btn-danger" onclick="Core.addTab('NEWSODDS','odds/index_new')">NEWS</button>
	</form>
	<div id="content"></div>
</div>
<script>
	var Odds={
		init:function(){
			Odds.getlist(1);
		},
		getlist:function(id){
			layer.msg('加載中', {icon: 16,shade: 0.01});
			$.get('odds/get_list?id='+id,function(c){
				$('#content').html(c);
				Odds.clickOdd();
				layer.closeAll();
			});
		},
		clickOdd:function(){
			$('ul.oneplaylist, ul.hzball').click(function(event) {
				id=$(this).attr('id');
				rate=$(this).find('span').eq(1).text();
				rate_min=$(this).find('span').eq(2).text();
				rebate=$(this).find('span').eq(3).text();
				Core.dialog('修改賠率', 'odds/revise_odds?id='+id+'&rate='+rate+'&rate_min='+rate_min+'&rebate='+rebate, function(){
					Odds.getlist($('#games_odds').val());
				}, true);
			});
			$('ul.bath_update').click(function(event) {
				id=$(this).attr('id');
				rate=$(this).find('span').eq(1).text();
				rate_min=$(this).find('span').eq(2).text();
				rebate=$(this).find('span').eq(3).text();
				Core.dialog('修改賠率', 'odds/lhc_evise_odds?id='+id+'&rate='+rate+'&rate_min='+rate_min+'&rebate='+rebate, function(){
					Odds.getlist($('#games_odds').val());
				}, true);
			});
		},
		change:function(e){
			Odds.getlist($(e).val());
		},
		updateOdds:function(){
			var id=$('#games_odds').val();
			$.messager.confirm('溫馨提示', '確定要初始化賠率嗎', function(r){
				if (r){
					$.post('odds/rate_init',{id:id},function(c){
						c=eval('('+c+')');
						if(c.status=='OK'){
							Odds.getlist($('#games_odds').val());
							Core.ok('初始化成功');
						}else{
							Core.error(c.msg);
						}
					});
				}
			});
		}
	};
	Odds.init();
</script>