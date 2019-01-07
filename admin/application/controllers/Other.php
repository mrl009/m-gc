<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Other extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->checklogin();
	}
	//载入会员列表
	public function index(){
		$data['type']=$this->uri->segment(3);
	    $data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('member/index',$data);
	}
	//获取会员列表
	public function getlist(){
		$type=$this -> input -> get('type');
		$arr=array('username'=>'username','grade'=>'grade' );
		if($verify_status) $arr['verify_status']='value:'.$verify_status;
		$rs=$this->user->getlist($arr);
	    echo json_encode($rs['msg']);
	}
	//保存会员列表
	public function save(){
		$id 		   			= $this -> input -> post('id');
		$row['gg_sort_order'] 	= $this -> input -> post('gg_sort_order');
		if($this -> user -> save($id,$row) && $this -> admin_sh -> add($sh)){
			echo '{"status":"OK","msg":"執行成功"}';
		}else{
			echo '{"status":"ERROR","msg":"執行失敗"}';
		}
	}
	//修改会员
	public function edituser(){
		$data['rs']=array_pop($this->user->update());
		$this->load->view('member/edituser',$data);
	}
	//删除会员
	public function deluser(){
		$this->user->remove();
	}
}