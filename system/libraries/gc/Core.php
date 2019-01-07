<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Core{
	private $tbname;
	private $dbname='';
	public  $ci;
	public  $db;
	
	function __construct(){
		error_reporting(E_ERROR);
		$this->ci =& get_instance();
	}
	
	/*** 获取相对路径 ***/
	private function getRelatePath(){
		$base = dirname(dirname(BASEPATH));
		$base = str_replace($base,'',FCPATH); 
		return $base; //return project/ht/admin
	}
	
	public function status($s,$m){
		return array('status'=>$s,'msg'=>$m);
	}
	//XML转ARRAY
	public function xmlToarray($str){
		$res = @simplexml_load_string($str,NULL,LIBXML_NOCDATA);
		$res = json_decode(json_encode($res),true);
		return $res;
	}
	public function arraytoTree($rows, $id='id',$pid='pid',$child='childs',$root=0){  
		$tree = array();
        if(is_array($rows)){
			$array = array();
			foreach ($rows as $key=>$item){
				$array[$item[$id]] =& $rows[$key];
			}
			foreach($rows as $key=>$item){
				$parentId = $item[$pid];
				if($root == $parentId){
					$tree[] =&$rows[$key];
				}else{
					if(isset($array[$parentId])){
						$parent =&$array[$parentId];
						$parent[$child][]=&$rows[$key];
					}
				}
			}
		}
		return $tree;
	}
	//发送邮件
	public function sendmail($name,$to,$topic,$content){
		$config = Array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.qq.com',
			'smtp_port' => 465,
			'smtp_user' => 'support@168off.com',
			'smtp_pass' => 'eprgdip@521',
			'mailtype'  => 'html', 
			'newline'   => "\r\n",
			'crlf'      => "\r\n",
			'smtp_timeout'=>50,
		);
		$this->ci->load->library('email', $config);
		$this->ci->email->from('support@168off.com', $name);
		$this->ci->email->to($to);
		$this->ci->email->subject($topic);
		$this->ci->email->message($content);
		$this->ci->email->send();
		//echo $this->ci->email->print_debugger();
	}
	/** 通过IP查找地址 **/
	public function location($ip){
		$arr=json_decode(file_get_contents("http://api.map.baidu.com/location/ip?ak=3aaadcbeae9a481baf24e3ba767060ee&ip=$ip"),true);
		$data=array(
		'address'=>$arr['content']['address'],
		'detail'=>array(
			'province'=>$arr['content']['address_detail']['province'],
			'city'=>$arr['content']['address_detail']['city'],
			'district'=>$arr['content']['address_detail']['district'],
			'street'=>$arr['content']['address_detail']['street']
		),
		'geo'=>array('lat'=>$arr['content']['point']['x'],'lng'=>$arr['content']['point']['y'])
		);
		return $data;
	}
	

	/**********************导出************************************/
	/*** 导出EXCEL(修正版)
	 * 可以生成多个工作表，多工作表示例请参阅后台订单, 单工作表示例请参阅后台违禁词
	**/
	function export($title,$rs=array()){
		if($rs==array()) return;
		//$this->ci->load->library('gc/PHPExcel');
		require_once('PHPExcel.php');
		$excel = new PHPExcel();
		$alpha=array_merge(array_merge(range('A','Z'),array_map(create_function('$v','return "A$v";'),range('A','Z'))),array_map(create_function('$v','return "B$v";'),range('A','Z')));  
		$color=array('FF0000','00FF00','993300','00FFFF','008000','008080','9999FF','993366','0066CC','FF6600','FF00FF','333399','333333','99CC00','FFCC00','FF9900','660066','800000','800080','333300');
		foreach($rs as $k=>$v){
			if($k!=0) $excel->createSheet();
			$excel->setActiveSheetIndex($k);
			$sheet = $excel->getActiveSheet();
			$sheet->setTitle($v['name']);
			$fields=array_keys(array_map(create_function('$v','return array_keys($v);'),$v['fields']));
			foreach($fields as $k=>$s){
				$arr[$s]=$alpha[$k];
				$sheet->getColumnDimension($alpha[$k])->setWidth(15);
				$sheet->setCellValue($alpha[$k]."1",is_array($v['fields'][$s])?$v['fields'][$s][0]:$v['fields'][$s]);
				$sheet->getStyle($alpha[$k]."1")->applyFromArray(array('font'=>array('bold'=>true,'color'=>array('rgb' => 'FFFFFF')),'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'color'=>array('rgb' =>empty($color[$k])?'FF0000':$color[$k]))));
			}
			foreach($v['data'] as $k=>$s){
				foreach($s as $i=>$o){
					if(in_array($i,$fields)){
						if(is_array($v['fields'][$i])){
							if(!empty($v['fields'][$i][1])){
								$func=create_function('$value,$row',$v['fields'][$i][1].';');
								$t=$func($o,$s);
							}else $t=$o;
						}else $t=$o;
						$sheet->setCellValue($arr[$i].($k+2),' ' .$t);
					}
				}
			}
		}
		$excel->setActiveSheetIndex(0);
		//$writer = new PHPExcel_Writer_Excel5($this->ci->phpexcel);
		$writer = new PHPExcel_Writer_Excel5($excel);
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:attachment; filename=".(empty($title)?'无标题':$title).".xls"); 
		$writer->save('php://output'); 
	}
	/** 导出CSV
	 * 支持大数据
	 **/
	public function exportCSV($title,$head=array(),$table,$args=array(),$parameter=array(),$def_sort='b.id',$sum='*'){
		header('Content-Type: application/vnd.ms-excel;charset=utf-8');
		header('Content-Disposition: attachment;filename="'.$title.'.csv"');
		header('Cache-Control: max-age=0');
		$fp = fopen('php://output', 'a');
		fwrite($fp,"\xEF\xBB\xBF");//写入BOOM
		foreach($head as $i=>$v){
			$headline[$i] = is_array($v)?array_shift($v):$v;
		}
		fputcsv($fp,$headline);
		$this->open($table);
		$pagesize=50;
		$arr=$this->get_list($args,$parameter,$def_sort,$sum);
		$total=$arr['total_rows'];
		$data=$arr['result'];
		$pages=intval($total/$pagesize);
		if($total%$pagesize) $pages++;
		
		$cnt = 0;
		$limit = 100000;
		for($i=1;$i<=$pages;$i++){
			$_POST['size']=$pagesize;
			$_POST['page']=$i;
			$arr=$this->get_list($args,$parameter,$def_sort,$sum);
			$data=$arr['result'];
			foreach($data as $k=>$v){
				$dataset[]=$v;
				if($table=='order'){
					$_arr=$this->get_all('*',array('oid'=>$v['cid']),'order_detail');
					foreach($_arr as $t=>$s){
						$row=$v;
						$row['cid'].="-$s[id]";
						$row['user_name']=$row['uid']=$row['order_time']=$row['order_id']=$row['link_type']=$row['shop_id']=$row['shop_name']=$row['u_email']=$row['nick_name']=$row['u_mobile']=$row['member_rebate_checked']='';
						$row['member_rebate']=$s['member_rebate'];
						$row['shop_return_rate_uncheck']=$s['current_return_rate'];
						$row['addtime']=$s['add_time'];
						$row['check_time']=$s['check_time'];
						$row['u_qq']=$row['ad_customer_id']=$row['feedback']='';
						$row['uniq_id']=$s['uniq_id'];
						$row['goods_category']=$s['goods_category'];
						$dataset[]=$row;
					}
				}
			}
			
			foreach($dataset as $k=>$v){
				$cnt++;
				if($limit == $cnt){ 
					ob_flush();
					flush();
					$cnt = 0;
				}
				$row=array();
				foreach($head as $d=>$s){
					if(in_array($d,array_keys($v))){
						if(is_array($s)){
							$func=create_function('$value,$row',$s[1].';');
							$row[$d]=$func($v[$d],$v);
						}else $row[$d]=(string)$v[$d];
					}else $row[$d]='';
				}
				fputcsv($fp, $row);
			}
		}
		fclose($fp);
	}
	/***导入**/
	public function import($filename){
	    //自己设置的上传文件存放路径
	    $this->ci->load->library('Import');
	    $a= new Import();
	    $a->dc($filename);
	   // $this->ci->load->library('PHPExcel/IOFactory');
	    
		
		//完成，可以存入数据库了
	}
	
	//无限分级
	function data2tree($data, $root=0, $cid='id', $pid='pid', $child='children', $_parent='', $_id=''){
		$tree = array();
		$_temp = array();
		foreach($data as $key=>$val){
			if(!empty($_parent) && $_parent==$val[$cid]) continue;
			$_temp[$val[$cid]] = &$data[$key];
		}
		foreach($data as $key=>$val){
			$parentId = $val[$pid];   //上级id
			if($root == $parentId){   //如果上级id 等于根id
				if(empty($_id) || $_id!=$val[$cid]) $tree[] = &$data[$key];   //那么 添加到tree里面
			}else{
				if(isset($_temp[$parentId])){
					$parent = &$_temp[$parentId]; 
					$parent[$child][] = &$data[$key];
				}
			}
		}
		return $tree;
	}
	public function pinyin($text,$concat='-'){
		require_once('ChinesePinyin.class.php'); 
		$Pinyin = new ChinesePinyin();
		$result = $Pinyin->TransformWithoutTone(strip_tags($text),$concat);
		return substr($result,0,strlen($result));
	}
	//压缩图片
	public function scaleImg($src,$pWidth=800){
		if(stristr($src,'.jpg') || stristr($src,'.jpeg') || stristr($src,'.png') || stristr($src,'.gif')){ 
			$info  = getimagesize($src);
			$width = $info[0];
			$height= $info[1]; 
			$mime  = array_pop($info); 
			if($width>$pWidth){//宽度超过指定宽度时进行压缩
				$w = $pWidth;
				$h = intval($w*$height/$width);
				$temp_img=imagecreatetruecolor($w,$h);
				if(stristr($mime,'jpeg')) $im = imagecreatefromjpeg($src);
				if(stristr($mime,'png'))  $im = imagecreatefrompng($src);
				if(stristr($mime,'gif'))  $im = imagecreatefromgif($src);
				imagecopyresampled($temp_img,$im,0,0,0,0,$w,$h,$width,$height);
				imagejpeg($temp_img,$src, 100);
				imagedestroy($im);
			}
		}
	}
	//保存远程图片
	public function saveRemotePhoto($url,$dir='../uploads/'){
		$ch  = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$raw = curl_exec($ch);
		curl_close($ch);
		$rootDir = $dir.'image/'.date('Y');
		if(!file_exists($rootDir)) @mkdir($rootDir);
		$targetDir = $rootDir.'/'.date('md');
		if(!file_exists($targetDir)) @mkdir($targetDir);
		$saveto = $targetDir.DIRECTORY_SEPARATOR.md5(uniqid()).'.'.array_pop(explode('.',$url));
		$fp = fopen($saveto,'x');
		fwrite($fp, $raw);
		fclose($fp);
		return '{"jsonrpc":"2.0", "result":"'.str_replace('../','',$saveto).'"}';
	}
	//快递查询(新版)
	public function express($e,$sn,$order){
		$url = "http://wap.kuaidi100.com/wap_result.jsp?rand=".time()."&id=$e&fromWeb=null&postid=$sn";
		$c   = $this->curl_get($url);
		preg_match_all('/<p>\&middot\;(.*?)<\/p>/is',$c,$arr);
		$isComplete=false;
		$routine=array();
		foreach($arr[1] as $v){
			if(stristr($v,'已收件')||stristr($v,'已签收')) $isComplete=true;
			$a = explode('<br />',$v);
			if(!trim($a[0])||!trim($a[1])) continue;
			$routine[]=array(
				'time'=>trim($a[0]),
				'ftime'=>trim($a[0]),
				'context'=>trim($a[1])
			);
		}
		//if($isComplete) $this->db->update('order',array('ship_status'=>3), array('order_sn'=>$order));
		
		$f   = 'uploads/file/delivery.json';
		$j   = file_get_contents($f);
		if(!$j) $j = file_get_contents("../$f");
		foreach(json_decode($j,true) as $v){
			if($v['code']==$e){
				$e=$v;break;
			}
		}
		return array(
			'status' =>$isComplete?'已签收':'在途',
			'fuzhi_str' =>$routine,
			'carrier'=>$e,
			'sn' =>$sn,
		);
	}
}