<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends MY_Controller {
	function __construct(){
		parent::__construct();
		 $this->checklogin();
	}
	//载入公司入款列表
	public function getToken(){
		$userName   =$this->input->get('username');
		$passWord   =$this->input->get('password');
		$clientKey  =$this->input->get('clientkey');
		$token=md5($userName.$passWord.date('Y-m-d').$clientKey.TOKEN);
		$token=base64_encode($token);
		echo $token;
	}
	
	public function getInfo(){
		$aa=$this->curl_get('http://www.baidu.com');
		echo $aa;
	}

	public function mq(){
		$this->load->library('Huashang/staff');
		$a=$this->staff->curl_get('http://admin.gc360.com/games/play/?gid=&token=123454657465y');
		print_r($a);
		//$this->staff->push(array('id'=>'33333','name'=>'俊在在'));
	}
	public function txt(){
		$this->load->view('txt');
	}
	public function push(){
		$name=$this->input->post('name');
		$this->load->library('Huashang/staff');
		$this->staff->push(array('name'=>$name));
		echo '發送成功';
	}
}