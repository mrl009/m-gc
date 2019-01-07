<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Level extends MY_Controller {
	function __construct(){
		parent::__construct();
        $this->checklogin();
	}
	
	//载入会员列表
	public function index(){
		$data['type']=$this->uri->segment(3);
	    $data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('level/index',$data);
	}
	//获取会员列表
	public function getlist()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'level/level/show_level',$_POST),true);

        echo json_encode($arr['data']);
	}
    
    /**
     * @php 快速直通车支付通道新加方法
     * lqh  2018/12/31
     */
    public function save_new()
    {
        // 组装post数据
        if (!empty($_POST['bank_id']))
        {
            $_POST['bank_id'] = implode(',', $_POST['bank_id']);
        }
        if (!empty($_POST['online_id']))
        {
            $temp = [];
            foreach($_POST['online_id'] as $val)
            {
                $v = explode('-', $val);
                $temp[$v[0]][] = $v[1];
            }
            $_POST['online_id'] = json_encode($temp);
        }
        if (!empty($_POST['fast_id']))
        {
            $temp = [];
            foreach($_POST['fast_id'] as $val)
            {
                $v = explode('-', $val);
                $temp[$v[0]][] = $v[1];
            }
            $_POST['fast_id'] = json_encode($temp);
        }
        //调用接口
        $url = ADMINAPI. 'level/level/level_add_new';
        $data = $this->curl_post($url,$_POST);
        if (!empty($data)) $rs = json_decode($data,true);
        if (isset($rs) && (200 == $rs['code']))
        {
            exit($this->status('OK','執行成功'));
        } else {
            $msg = isset($rs['msg']) ? $rs['msg'] : '执行失败';
            exit($this->status('ERROR',$msg));
        }
    }

    public function edituser_new()
    {
        if(!empty($_GET['id']))
        {
            $url = ADMINAPI . "level/level/updata_show_new/{$_GET['id']}";
            $data = $this->curl_get($url,$_POST);
            if (!empty($data)) $data = json_decode($data,true);
        }else {
            $url = ADMINAPI . 'level/level/insert_show_new';
            $data = $this->curl_get($url,$_POST);
            if (!empty($data)) $data = json_decode($data,true);
        }
        $data = array_pop($data);
        $this->load->view('level/edituser_new', $data);
    } 

	//保存会员列表
	public function save(){
        // 组装post数据
        $_POST['bank_id'] = isset($_POST['bank_id']) ? implode(',', $_POST['bank_id']) : '';
        $tempOnlineCode = [];
        foreach ($_POST['online_id'] as $value) {
            $v = explode('-', $value);
            $tempOnlineCode[$v[0]][] = $v[1];
        }
        $_POST['online_id'] = json_encode($tempOnlineCode);
        $rs = json_decode($this->curl_post(ADMINAPI. 'level/level/level_add',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
	}

	//修改会员
	public function edituser()
    {
        if(!empty($_GET['id'])){
            $data = json_decode($this->curl_get(ADMINAPI.'level/level/updata_show/'. $_GET['id'],$_POST),true);
        }else {
            $data = json_decode($this->curl_get(ADMINAPI.'level/level/insert_show',$_POST),true);
        }
        $data = array_pop($data);
        // 组装线上支付
        $tempOnline = [];
        foreach ($data['online'] as $v) {
            $tempOnline[$v['id']]['name'] = $v['name'];
            $tempOnline[$v['id']][$v['code']] = $v;
        }
        ksort($tempOnline);
        $data['online'] = $tempOnline;
        $this->load->view('level/edituser', $data);
	}
	//支付设定
	public function pay_set(){
		$this->load->view('level/pay_set');
	}

	// 修改层级弹框
	public function edit_level() {
        $data['level_id'] = $this->input->get('id');
        $arr = json_decode($this->curl_get(ADMINAPI.'level/level/show_level',$_POST), true);
        $data['level'] = $arr['data']['rows'];
        $this->load->view('level/edit_level',$data);
    }

    // 保存修改
    public function save_level() {
        $rs = json_decode($this->curl_post(ADMINAPI. 'level/level/move_level',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
}