<div class="rjlist">
	<button type="button" class="btn btn-danger" sn="ag">AG日结表</button>
	<button type="button" class="btn btn-link" sn="dg">DG日结表</button>
</div>
<div id="sxreport" style="height: 535px"></div>

<script type="text/javascript">
	
	$.get(WEB+'sxreport/sx?game=ag',function(c){
		$('#sxreport').html(c);
	});

	$('.rjlist button').click(function(){
		$('.rjlist button').removeClass('btn-danger');
		$(this).addClass('btn-danger');
		var t = $(this).attr('sn');
		$.get(WEB+'sxreport/sx?game='+t,function(c){
			$('#sxreport').html(c);
		});
	});
</script>
