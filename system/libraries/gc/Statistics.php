<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("Core.php");

class CI_Statistics extends CI_Core{
	public $db;
	public $ci;
	function __construct(){
		error_reporting(E_ERROR);
		$this->ci =& get_instance();
		$dba = array(
			'dsn'	=> '',
			'hostname' => '192.168.8.102',
			'username' => 'root',
			'password' => 'root',
			'database' => 'hs',
			'dbdriver' => 'mysqli',
			'dbprefix' => 'ht_',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE
		);
        $this->db=$this->ci->load->database($dba, true);
	}

	//各端营业额所占比例
	public function platPercentage($start,$end){
		if(!$start || !$end) return $this->status(false,array());
		$rs = array();
		$start  = strtotime($start." 00:00:00");
		$end    = strtotime($end." 23:59:59");
		$sql = "select sum(total_price) as total,source from ht_order where add_time>=$start and add_time<=$end group by source";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		foreach($arr as $v) $rs[]=array($v['source'],intval($v['total']));
		return $this->status(true,$rs);
	}
	public function statusPercentage($start,$end){
		if(!$start || !$end) return $this->status(false,array());
		$rs = array();
		$start  = strtotime($start." 00:00:00");
		$end    = strtotime($end." 23:59:59");
		$sql = "select sum(total_price) as total,order_status as status from ht_order where add_time>=$start and add_time<=$end group by order_status";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		foreach($arr as $v){
			if($v['order_status']==1) $v['order_status']='未付款';
			if($v['order_status']==2) $v['order_status']='已支付';
			if($v['order_status']==3) $v['order_status']='挂账';
			if($v['order_status']==4) $v['order_status']='已取消';
			$rs[]=array(iconv("gbk","UTF-8//TRANSLIT",$v['order_status']),intval($v['total']));
		}
		return $this->status(true,$rs);
	}
	public function allProfit($start,$end){
		if(!$start || !$end) return $this->status(false,array());
		$rs = array();
		$format = $start==$end?'%Y-%m-%d %H:00':'%Y-%m-%d';
		$start  = strtotime($start." 00:00:00");
		$end    = strtotime($end." 23:59:59");
		$sql = "select sum(total_price) as total,date_format(FROM_UNIXTIME(add_time),'$format') as date from ht_order where add_time>=$start and add_time<=$end  group by date";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		foreach($arr as $v) $rs[]=array(strtotime($v['date'])*1000,intval($v['total']));
		return $this->status(true,$rs);
	}
	public function platProfit($start,$end){
		if(!$start || !$end) return $this->status(false,array());
		$rs = array();
		$format = $start==$end?'%Y-%m-%d %H:00':'%Y-%m-%d';
		$start  = strtotime($start." 00:00:00");
		$end    = strtotime($end." 23:59:59");
		$sql = "select sum(total_price) as total,date_format(FROM_UNIXTIME(add_time),'%Y-%m-%d') as date,source from ht_order where add_time>=$start and add_time<=$end group by date,source";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		foreach($arr as $v){
			$rs[$v['source']]['name']=$v['source'];
			$rs[$v['source']]['data'][]=array(strtotime($v['date'])*1000,intval($v['total']));
		}
		return $this->status(true,array_values($rs));
	}
	public function realtime($date){
		if(!$date) return $this->status(false,array());
		$rs = array();
		$start  = strtotime("$date 00:00");
		$end    = strtotime("$date 23:59"); 
		$sql = "select sum(total_price) as total,date_format(FROM_UNIXTIME(add_time),'%Y-%m-%d %H:00') as date,source from ht_order where add_time>=$start and add_time<=$end group by date,source";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		foreach($arr as $v){
			$rs[$v['source']]['name']=$v['source'];
			$rs[$v['source']]['data'][]=array(strtotime($v['date'])*1000,intval($v['total']));
		}
		return $this->status(true,array_values($rs));
	}
	
	//订单月报
	public function annualOrder($godate,$enddate,$payStatus='',$type='m'){
		$format = $type=='m'?'%Y-%m-%d':'%Y-%m';
		$where="where add_time >=".strtotime($godate)." and add_time<=".strtotime($enddate);
		if($payStatus) $where.=" and order_status=$payStatus";
		$sql = "select sum(total_price) as total,sum(cost_price) as cost_price,date_format(FROM_UNIXTIME(add_time),'$format') as date,source from ht_order ".$where."  group by date";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		return $this->status(true,$arr);
	}
	//销售排行
	public function goodsTop($godate,$enddate,$payStatus='2',$group='goods_id',$order='goods_amount'){
		if($godate && $enddate) $where="where goods_add_time >=".strtotime($godate)." and goods_add_time<=".strtotime($enddate);
		//if($payStatus) $where.=" and goods_status=$payStatus";
		$sql = "select sum(goods_price) as goods_price,sum(goods_amount) as goods_amount,goods_id from ht_order_info ".$where."  group by $group order by $order desc limit 20";
		#echo $sql;exit;
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		foreach($arr as $key => $v){
			$goods_info = $this -> ci -> goods -> getName($v['goods_id']);
			$arr[$key]['goods_title'] = $goods_info['title'];
		}
		return $this->status(true,$arr);
	}
	//会员排行
	public function userTop($godate,$enddate,$payStatus='2',$group='user_id',$order='amount'){
		if($godate && $enddate) $where="where add_time >=".strtotime($godate)." and add_time<=".strtotime($enddate);
		if($payStatus) $where.=" and order_status=$payStatus";
		$sql   = "select sum(total_price) as total_price,sum(cost_price) as cost_price,sum(amount) as amount,user_name from ht_order ".$where."  group by $group order by $order desc limit 20";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		return $this->status(true,$arr);
	}
	//访问购物率
	public function exchange($godate,$enddate,$payStatus='2',$group='goods_id',$order='goods_amount'){
		if($godate && $enddate) $where="where goods_add_time >=".strtotime($godate)." and goods_add_time<=".strtotime($enddate);
		if($payStatus) $where.=" and goods_status=$payStatus";
		$left="left join ht_goods as a on b.goods_id=a.id";
		$sql = "select sum(goods_price) as goods_price,sum(goods_cost_price) as goods_cost_price,sum(goods_amount) as goods_amount,goods_title,sum(views) as views from ht_order_detail as b $left ".$where."  group by $group order by $order desc limit 20";
		$query = $this->db->query($sql);
		$arr = $query->result_array($sql);
		return $this->status(true,$arr);
	}
	//利润表
	public function profit($godate,$enddate,$payStatus='2'){
		if($godate && $enddate) $where="where add_time >=".strtotime($godate)." and add_time<=".strtotime($enddate);
		if($payStatus) $where.=" and order_status=$payStatus";
		$sql   = "select sum(total_price) as total_price,sum(cost_price) as cost_price from ht_order ".$where;
		$query = $this->db->query($sql);
		//$arr = $query->result_array($sql);
		$arr =$query->row_array();
		return $this->status(true,$arr);
	}
	//客户统计
	public function guest(){
		$where='';
		$sql   = "select count(id) as amount from ht_user ".$where;
		$query = $this->db->query($sql);
		$arr =$query->row_array();
		return $this->status(true,$arr);
	}
	/*********** 以下为流量统计 *************/
	private $PREFIX = "http://www.51.la/";
	//基本流量统计
	public function profile(){
		$this->_loginCtrl();
		$arr = array_pop($this->ci->system->settings(false));
		$rs = $this->_get($this->PREFIX."report/1_main_online.asp?id=$arr[stats_id]");
		preg_match("/getElementById\(\"UserOnlinesSpan\"\)\.innerHTML = '(\d+)'/is",$rs,$a);
		$data['online'] = $a[1];
		$rs = $this->_get($this->PREFIX."report/1_main.asp?id=$arr[stats_id]");
		preg_match('/<table id="tabmain">(.*?)<\/table>/is',$rs,$a);
		preg_match_all('/<tr.*?>(.*?)<\/tr>/is',$a[1],$a);
		foreach($a[1] as $v){
			$c=array();
			preg_match_all('/<td>(.*?)<\/td>/is',$v,$b);
			foreach($b[1] as $k=>$s){
				if($k==0) $c['key']=iconv("gbk","UTF-8//TRANSLIT",strip_tags($s));
				else $c['values'][]=strip_tags($s);
			}
			if($c['key']) $data['profile'][]=$c;
		}
		return $this->status(true,$data);
	}
	//24时流量
	public function latest24(){
		date_default_timezone_set('UTC');
		$this->_loginCtrl();
		$arr = array_pop($this->ci->system->settings(false));
		$rs = $this->_get($this->PREFIX."report/2_hour.asp?id=$arr[stats_id]");
		preg_match('/<table id="gra_shu" cellspacing="0">(.*?)<\/table>/is',$rs,$a);
		preg_match_all('/<tr.*?>(.*?)<\/tr>/is',$a[1],$a);
		$data=array();
		foreach($a[1] as $i=>$v){
			if($i==0) continue;
			$c=array();
			preg_match_all('/<td.*?>(.*?)<\/td>/is',$v,$b);
			foreach($b[1] as $k=>$s){
				if($k==0) $c['time']=str_replace("&nbsp;",'',strip_tags($s));
				else if(!stristr($s,'%')) $c['values'][]=str_replace("&nbsp;",'',strip_tags($s));
			}
			if($c['time']) $data[]=$c;
		}
		$d=array('独立IP','客户端','新客户','浏览量');
		$rs = array();
		foreach($d as $k=>$v){
			$a=array();
			foreach($data as $i=>$s){
				$b=explode('-',$s['time']);
				if($i<count($data)-1) $a[]=array(strtotime("$b[0]-$b[1]-$b[2]")*1000,intval($s['values'][$k]));
			}
			$rs[]=array('name'=>iconv("gbk","UTF-8//TRANSLIT",$v),'data'=>$a);
		}
		return $this->status(true,$rs);
	}
	//新增流量站点
	public function addSite($name,$domain){
		$this->_loginCtrl();
		$rs = $this->_post('http://www.51.la/user/newsite.asp',array(
			'SStyle'=>0,
			'ST_CanGuest'=>0,
			'grp_id'=>1,
			'sitename'=>$name,
			'siteurl'=>$domain
		));
		preg_match('/4_s\.asp\?id=(\d+)/is',$rs,$arr);
		$data['id']=$arr[1];
		$rs = $this->_get('http://www.51.la/report/4_s.asp?id='.$data['id']);
		preg_match('/<textarea.*?>(.*?)<\/textarea>/is',$rs,$arr);
		$data['code']=htmlspecialchars_decode($arr[1]);
		return $this->status(true,$data);
	}
	private function _login(){
		$arr = array_pop($this->ci->system->settings(false));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.51.la/login.asp');
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'uname='.$arr['51lauser'].'&upass='.$arr['51lapass']);
		curl_exec($ch);
		curl_close($ch);
	}
	private function _loginCtrl(){
		$rs = $this->_get('http://www.51.la/user/');
		if(stristr($rs,'<a HREF="../login.asp">here</a>')){
			$this->_login();
		}
	}
	private function _get($url){
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");
		curl_setopt($ch, CURLOPT_REFERER, "http://www.51.la/user/");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$_SERVER["REMOTE_ADDR"], 'CLIENT-IP:'.$_SERVER["REMOTE_ADDR"]));
		$rs = curl_exec($ch);
		curl_close($ch); 
		return $rs; 
	}
	private function _post($url,$params){
		$postData = '';
		foreach($params as $k => $v) $postData.=$k.'='.$v.'&'; 
		rtrim($postData, '&');
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");
		curl_setopt($ch, CURLOPT_REFERER, "http://www.51.la/user/");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$_SERVER["REMOTE_ADDR"], 'CLIENT-IP:'.$_SERVER["REMOTE_ADDR"]));
		$rs = curl_exec($ch);
		curl_close($ch); 
		return $rs; 
	}
}