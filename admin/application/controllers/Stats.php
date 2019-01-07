<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends MY_Controller {
	function __construct(){
		parent::__construct();
		//$this->checklogin();
		//$this->load->library('gc/statistics');
	}

	//首页
	public function order(){
		$this->load->view('stats/order');
	}
	public function data_order(){
		$source = $this->input->get('source');
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$rs = array_pop($this->statistics->order($source,$start,$end));
		echo json_encode($rs);
	}
	//销售排行
	public function goodstop(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/goodstop',$data);
	}
	public function getgoodstop(){
		$star=$this->input->post('qaddtime')?$this->input->post('qaddtime')." 00:00:00":'';
		$end=$this->input->post('zaddtime')?$this->input->post('zaddtime')." 23:59:59":'';
		$pay=$this->input->post('order_status')?$this->input->post('order_status'):'';
		$order=$this->input->post('orderItem')?$this->input->post('orderItem'):'goods_amount';
		$data=array_pop($this->statistics->goodsTop($star,$end,$pay,'goods_id',$order,$pay));
		$rs = array('total'=>0,'rows'=>$data);
		echo json_encode($rs);
	}
	//会员排行
	public function usertop(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/usertop',$data);
	}
	//会员排行
	public function getusertop(){
		$star=$this->input->post('qaddtime')?$this->input->post('qaddtime')." 00:00:00":date('Y-m-d')." 00:00:00";
		$end=$this->input->post('zaddtime')?$this->input->post('zaddtime')." 23:59:59":date('Y-m-d')." 23:59:59";
		$pay=$this->input->post('order_status')?$this->input->post('order_status'):'';
		$order=$this->input->post('orderItem')?$this->input->post('orderItem'):'amount';
		$data=array_pop($this->statistics->userTop($star,$end,$pay,'user_id',$order));
		$rs = array('total'=>0,'rows'=>$data);
		echo json_encode($rs);
	}
	//访问购物率
	public function exchange(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/exchange',$data);
	}
	
	//访问购物率
	public function getexchange(){
		$star=$this->input->post('qaddtime')?$this->input->post('qaddtime'):date('Y-m-d');
		$end=$this->input->post('zaddtime')?$this->input->post('zaddtime'):date('Y-m-d');
		$pay=$this->input->post('order_status')?$this->input->post('order_status'):'';
		$order=$this->input->post('orderItem')?$this->input->post('orderItem'):'goods_amount';
		$data=array_pop($this->statistics->exchange($star,$end,$pay,'user_id',$order));
		$rs = array('total'=>0,'rows'=>$data);
		echo json_encode($rs);
	}
	//利润总报表
	public function profit(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/profit',$data);
	}
	public function getprofit(){
		$star=$this->input->post('qaddtime')?$this->input->post('qaddtime'):date('Y-m-d');
		$end=$this->input->post('zaddtime')?$this->input->post('zaddtime'):date('Y-m-d');
		$data=array_pop($this->statistics->profit($star,$end,''));
		echo json_encode($data);
	}
	//客户统计
	public function guest(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/guest',$data);
	}

	//上级公告
	public function up_notice(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/up_notice',$data);
	}

	
	//上级公告列表
	public function get_up_notice_list()
    {
        echo json_encode(
            array(
                'total' =>  1,
                'rows'  =>  array(
                    array('t1'=>'2017-03-08 04:24:57', 't2'=>'11111111')
                )
            ), JSON_UNESCAPED_UNICODE);
	}
	//日志记录
	public function log_record(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/log_record',$data);
	}

	//会员登陆
	public function member_login(){
        $data['type']=$this->uri->segment(3);
        $data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/member_login');
	}

	//获取会员登陆列表
	public function get_member_login_list()
    {
        $_POST = array_merge($_POST, array('log_type' => 'log_user_login'));
        $arr = json_decode($this->curl_get(ADMINAPI.'log/log/getLogList',$_POST),true);
        echo json_encode($arr['data']);
	}

	//管理登陆
	public function manage_login(){
        $data['type']=$this->uri->segment(3);
        $data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/manage_login');
	}

	// 管理员登陆日志列表
	public function get_manage_login_list()
    {
        $type = array('log_type' => 'log_admin_login');
        $_POST = array_merge($_POST, $type);
        $arr = json_decode($this->curl_get(ADMINAPI.'log/log/getLogList',$_POST),true);
        echo json_encode($arr['data']);
    }

	//操作日志
	public function handle_log(){
        $data['type']=$this->uri->segment(3);
        $data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/handle_log');
	}

	//获取操作日志列表
	public function get_log_list()
    {
        $type = array('log_type' => 'log_admin_record');
        $_POST = array_merge($_POST, $type);
        $arr = json_decode($this->curl_get(ADMINAPI.'log/log/getLogList',$_POST),true);
        echo json_encode($arr['data']);
	}
	//自动稽核
	public function check(){
		$this->load->view('stats/check');
	}
	//获取自动稽核列表
	public function get_check_list()
    {
        echo json_encode(
            array(
                'total' =>  1,
                'rows'  =>  array(
                    array('t1'=>'kgbet.cc', 't2'=>'52493','t3'=>'登入成功(kgbet.cc)','t4'=>'2017-03-08 04:24:57','t5'=>'113.89.238.16(广东省深圳市 电信(113.89.238.16))')
                )
            ), JSON_UNESCAPED_UNICODE);
	}

	//会员消息
	public function member_info(){
		$data['auth']=explode(',', $this->input->get('auth'));
		$this->load->view('stats/member_info',$data);
	}

	//发布新消息
	public function release_news(){
        $this->load->view('stats/release_news');
	}

	// 保存新消息
	public function save_new(){
        $rs = json_decode($this->curl_post(ADMINAPI.'log/userMsgLog/add',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    // 删除新信息
	public function delete_news(){
        $rs=json_decode($this->curl_post(ADMINAPI.'log/userMsgLog/delete',array('id'=>$_POST['id'])),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

	//获取日志记录列表
	public function get_info_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'log/userMsgLog/getMsgLogList',$_POST),true);
        echo json_encode($arr['data']);
	}

	//前台公告
	public function front_notice()
    {
        $data['admin_id'] = 1;
        $data['type']=$this->uri->segment(3);
        $data['auth']=explode(',', $this->input->get('auth'));
        $this->load->view('stats/front_notice', $data);
    }

    //获取前台公告列表
    public function get_front_notice_list(){
	    isset($_POST['content']) && $_POST['content'] = urlencode($_POST['content']);
        $arr = json_decode($this->curl_get(ADMINAPI.'log/userNoticeLog/getNoticeLogList',$_POST),true);
        echo json_encode($arr['data']);
    }

    //修改前台信息
    public function change_front_notice(){
        $data['rs'] = array();
        $data['rs']['admin_id'] = isset($_GET['admin_id']) ? $_GET['admin_id'] : '';
        if(!empty($_GET['id'])){
            $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'log/userNoticeLog/getInfo?id='.$_GET['id']),true));
        }
        $this->load->view('stats/change_front_notice', $data['rs']);
    }

    // 新增保存公告修改
    public function save_notice(){
        $rs = json_decode($this->curl_post(ADMINAPI.'log/userNoticeLog/saveNotice',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    // 删除公告
    public function delete_notice(){
        $rs=json_decode($this->curl_post(ADMINAPI.'log/userNoticeLog/delete',array('id'=>$_POST['id'])),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    // 更新公告状态
    public function update_notice_status(){
        $rs=json_decode($this->curl_post(ADMINAPI.'log/userNoticeLog/updateStatus',array('id'=>$_POST['id'],'status'=>$_POST['status'])),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

	//获取
	public function getguest(){
		$data=array_pop($this->statistics->guest());
		echo json_encode($data);
	}
	public function plat_percentage(){
		echo json_encode(array_pop($this->statistics->platPercentage($this->input->post('start'),$this->input->post('end'))));
	}
	public function status_percentage(){
		echo json_encode(array_pop($this->statistics->statusPercentage($this->input->post('start'),$this->input->post('end'))));
	}
	public function all_profit(){
		echo json_encode(array_pop($this->statistics->allProfit($this->input->post('start'),$this->input->post('end'))));
	}
	public function plat_profit(){
		echo json_encode(array_pop($this->statistics->platProfit($this->input->post('start'),$this->input->post('end'))));
	}
	public function realtime_profit(){
		echo json_encode(array_pop($this->statistics->realtime($this->input->post('start'),$this->input->post('end'))));
	}
	
	/******** 以下为流量统计 *************/
	//获取基本流量统计
	public function get_profile(){
		echo json_encode(array_pop($this->statistics->profile()));
	}
	public function latest24(){
		echo json_encode(array_pop($this->statistics->latest24()));
	}
}
?>