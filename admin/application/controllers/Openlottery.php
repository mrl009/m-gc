<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Openlottery extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->checklogin();
	}
	//载入会员列表
	public function index(){
	    $data['auth']=explode(',', $this->input->get('auth'));
	    $games = json_decode($this->curl_get(ADMINAPI.'games/info'),true);
		$data['games']=$games['data']['rows'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        $set_games = array();
        if ($arr['code'] == 200){
            $set = $arr['data']['cp'];
            if (!empty($set)) {
                $set = explode(',', $set);
                foreach ($set as $v){
                    $set_games[] = $v>50 && !in_array($v,[73,74,82,88]) ? $v-50 : $v;
                }
            }
        }

		foreach ($data['games'] as $k => $v) {
		    if ($v['id'] > 50 && !in_array($v['id'],[73,74,82,88]) || !in_array($v['id'],$set_games) ) {
		        unset($data['games'][$k]);
            }
            $data['tmp'][$v['id']] = $v['tmp'];
        }
		$this->load->view('openlottery/list',$data);
	}
	//获取开奖列表
	public function getlist(){
		//$_POST['gid']=3;
        $data = $this->curl_get(ADMINAPI . 'result/Open_result', $_POST);
        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
	}
}