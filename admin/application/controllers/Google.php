<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->checklogin();
		
	}

	public function index(){
		require_once 'GoogleAuthenticator.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		$data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_set'),true));
		if(empty($data['rs']['google_key'])){
			$k=$ga->createSecret();
			$rs = array('google_key'=>$k);
			$arr = $this->curl_post(ADMINAPI . 'setting/Setting/save_set2', $rs);
			$secret = $k;
		}else{
			$secret = $data['rs']['google_key'];//$ga->createSecret();
		}
		$data['qrCodeUrl'] = $ga->getQRCodeGoogleUrl($this->session->userdata('sid'), $data['rs']['google_key']); //
		$this->load->view('google',$data);
	}

	//保存令牌
	public function save_key(){
		$_POST['google_key']=strtoupper($_POST['google_key']);
		$arr = $this->curl_post(ADMINAPI . 'setting/Setting/save_set2', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
	}
}