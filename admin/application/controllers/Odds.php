<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Odds extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->checklogin();
	}
	// 赔率修改地址，自己用
	// http://admin.gc.com/welcome/pubbox?url=b2Rkcy9pbmRleC9zYz9hdXRoPVJFQUQsRURJVCbmmJPlvanlvannpajotZTnjoc=
    //    {
//        "name": "賠率",
//        "en_name": "Odds",
//        "icon": "entypo-basket",
//        "submenu": [
//            {
//                "name": "易彩彩票赔率",
//                "en_name": "sOddsSetting",
//                "url": "odds/index/sc",
//                "auth": "READ,EDIT"
//            }
//        ]
//    },

	//獲取玩法賠率
	public function get_list_new(){
		$id=$this->input->get('id');
		$tmp=$this->input->get('tmp');
		$ctg=$this->input->get('ctg');
		$id=empty($id)?1:$id;
		$odds= json_decode($this->curl_get(ADMINAPI.'rate/rate/get_list/'.$id),true);
		$data['odds'] = $odds['data'];
        $data['tmp'] = $tmp;
        if($tmp=='lhc'){
			$view='odds/ajax_lhc';
		}else if($id==24 || $id==25){
			$view='odds/ajax_pcdd';
		}else{
			$view= $ctg == 'gc' ? 'odds/ajax_list_new' : 'odds/sc/ajax_list_new';
		}
		$this->load->view($view,$data);
	}

	//批量保存
	public function save_odds_batch(){
		$data['tid']=$this->input->post('tid');
		$data['rate']=$this->input->post('rate');
		$data['rebate']=$this->input->post('rebate');
		if(empty($data['rate']) && empty($data['rebate'])){
			 exit($this->status('ERROR','參數錯誤'));
		}
		$rs= json_decode($this->curl_post(ADMINAPI.'rate/rate/set_tid',$data),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
		
	}
	/********************************/	
	//載入賠率設置
    public function index()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $data['ctg'] = $this->uri->segment(3);
        $games = json_decode($this->curl_get(ADMINAPI . 'games/info?ctg=' . $data['ctg']), true);
        $data['games'] = $games['data']['rows'];
        $view = $data['ctg'] == 'gc' ? 'odds/index_new' : 'odds/sc/index_new';
        $this->load->view($view, $data);
    }
	
	//保存
	public function save_odds(){
		$rs= json_decode($this->curl_post(ADMINAPI.'rate/rate/set_id',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
	}
	//初始化賠率
	public function rate_init(){
		$id=$this->input->post('id');
		$rs= json_decode($this->curl_post(ADMINAPI.'rate/rate/init',array('gid'=>$id)),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
	}
	//刪除緩存
	public function del_cache(){
		$id=$this->input->post('id');
		$rs= json_decode($this->curl_post(ADMINAPI.'games/cleancache/'.$id,array()),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
	}
}