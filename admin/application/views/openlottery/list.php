<?php $id = "form_" . uniqid(); ?>
<?php $form_id = "form_" . $id; ?>
<table id="<?php echo $id; ?>"></table>
<script>
	var tmp=<?php echo json_encode($tmp);?>;
	var play_id=1;
	var sname= getSname(1);
	var allarr=getCol(sname);
	var tools= [
		{instant: false},
		{type: 'combobox',text: '彩票類型',width: 100,name: 'gid',value: '',
			items: '<?php foreach($games as $v){?><option value="<?php echo $v['id']?>"><?php echo $v['name']?></option><?php }?>'
		},
		{type: 'datebox', text: '日期', width: 100, name: 'time'},
		{type: 'textbox', text: '期數', width: 120, name: 'kithe'},
		{
		text: "搜索", iconCls: "icon-search", handler: function () {
			$('#<?php echo $id?>').DataSource('search');
			play_id=$('#<?=$form_id?> #gid').combobox('getValue');
			play_name=$('#<?=$form_id?> #gid').combobox('getText');
			kithe=$('#<?=$form_id?> [name=kithe]').val();
			time=$('#<?=$form_id?> [name=time]').val();
			sname = getSname(play_id)
			var searchAll=getCol(sname,play_name);
			tools[2].value = time;
			$("#<?php echo $id;?>").DataSource({url: 'openlottery/getlist',fields: [searchAll], tools:tools});
				$('#<?=$form_id?> #gid').combobox('select',play_id);
				$('#<?=$form_id?> [name=kithe]').val(kithe);
				//$('[name=time]').val(time);
			}
		}
	];
	        		
	$("#<?php echo $id;?>").DataSource({url: 'openlottery/getlist',fields: [allarr], tools:tools});
	$('#<?=$form_id?> #gid').combobox('select',1);
	
	function getCol(v,n){
		var lottey=[];
		var rs=[];
		var arr=[
			{field: 'id',        title: 'ID', width: 70, sortable: true},
			{field: 'gid',      title: '彩票類型 ',align:'center', width: 100, formatter:function (tt) {
				return n?n:'福彩3D';
			}},
			{field: 'kithe',     title: '彩票期號 ',align:'center',width: 110},
			{field: 'open_time', title: '開獎時間', align:'center', width: 140},
			{field: 'num1',   title: '第壹球',align:'center',width: 80},
			{field: 'num2',   title: '第二球',align:'center', width: 80},
			{field: 'num3',   title: '第三球',align:'center', width: 80}
		];
        if (v=='yb' || v=='s_yb') {
			lottey=[
				    {field: 'k1', title: '總和',align:'center',width: 80}
				    /*{field: 'k2', title: '前二總和', width: 80},
				    {field: 'k3', title: '後二總和', width: 80}*/
			];
		}else if(v=='lhc'){
			lottey=[
					{field: 'num4',   title: '第四球',align:'center',width: 80},
					{field: 'num5',   title: '第五球',align:'center', width: 80},
					{field: 'num6',   title: '第六球',align:'center', width: 80},
					{field: 'num7',   title: '特碼',align:'center', width: 80},
				    {field: 'k1', title: '總和',   align:'center',  width: 60},
					{field: 'k2', title: '總和單雙',  align:'center',   width: 60},
					{field: 'k3', title: '總和大小', align:'center',    width: 60},
					{field: 'k4', title: '七色波',  align:'center',   width: 60},
					{field: 'k5', title: '特碼單雙', align:'center',    width: 60},
					{field: 'k6', title: '特碼大小', align:'center',    width: 60},
					{field: 'k7', title: '合單雙',  align:'center',   width: 60},
					{field: 'k8', title: '合大小',  align:'center',   width: 60},
					{field: 'k9', title: '特碼大小尾',  align:'center',   width: 60}
			];
		}else if(v=='ssc' || v=='s_ssc'){
			lottey=[
					{field: 'num4',   title: '第四球',align:'center',width: 80},
					{field: 'num5',   title: '第五球',align:'center', width: 80}
					/*{field: 'k1', title: '百位大小',     width: 80},
					{field: 'k2', title: '百位單雙',     width: 80},
					{field: 'k3', title: '十位大小',     width: 80},
					{field: 'k4', title: '十位單雙',     width: 80},
					{field: 'k5', title: '個位大小',     width: 80},
					{field: 'k6', title: '個位單雙',     width: 80}*/
			];
		}else if(v=='k3' || v=='s_k3' || v=='pcdd'){
			lottey=[
				{field: 'k1', title: '總和',  align:'center',  width: 80}
			];
		}else if(v=='pk10' || v=='s_pk10'){
			lottey=[
				{field: 'num4',   title: '第四球',align:'center',width: 80},
				{field: 'num5',   title: '第五球',align:'center', width: 80},
				{field: 'num6',   title: '第六球', align:'center',width: 80},
				{field: 'num7',   title: '第七球',align:'center',width: 80},
				{field: 'num8',   title: '第八球', align:'center',width: 80},
				{field: 'num9',   title: '第九球',align:'center', width: 80},
				{field: 'num10',   title: '第十球',align:'center',width: 80}
			];
		}else if(v=='11x5' || v=='s_11x5'){
			lottey=[
				{field: 'num4',   title: '第四球',align:'center',width: 80},
				{field: 'num5',   title: '第五球',align:'center', width: 80}
			];
		}else if(v=='s_kl10'){
            lottey=[
                {field: 'num4',   title: '第四球',align:'center',width: 80},
                {field: 'num5',   title: '第五球',align:'center', width: 80},
                {field: 'num6',   title: '第六球', align:'center',width: 80},
                {field: 'num7',   title: '第七球',align:'center',width: 80},
                {field: 'num8',   title: '第八球', align:'center',width: 80}
            ];
        }
		rs=$.merge(arr,lottey);
		rs.push( {field: 'status', title: '狀態', align: 'center', width: 200, sortable: true, formatter: function (v, r) {
			if (r.status == 0)  return '獲取不到開獎結果';
			else if (r.status == 1) return '沒開獎';
			else if (r.status == 2) return '已開獎';
			else if (r.status == 3) return '已結算';
			else if (r.status == 4) return '抓了很久沒有抓到';
			else return '獲取不到開獎結果';
		}});
		return rs;
	}

	function getSname(gid) {
	    var sname = '';
        $.each(tmp, function (i, d) {
            if (i == gid) {
                sname = d;
            }
        })
        return sname;
    }
</script>