<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/***
 * 模块：彩票注单
 * 开发者：BC
 * 日期：2017-01-15
 ***/
class Order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    //载入列表
    public function index($is2 = false)
    {
        $data = $_GET;
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $data['ctg'] = $this->uri->segment(3);
        // 彩种类型
        $games = json_decode($this->curl_get(ADMINAPI . 'games/info?ctg=' . $data['ctg']), true);
        $data['games'] = $games['data']['rows'];
        // 来源
        $arr = json_decode($this->curl_get(ADMINAPI . 'order/order/getFromType'), true);
        $data['from_type'] = $arr['data'];
        // 是否注单2
        $data['is2'] = $is2;
        $this->load->view('order/list', $data);
    }

    // 注单2（测试临时要）
    public function index2()
    {
        $this->index(true);
    }

    //获取列表
    public function getlist()
    {
        $_REQUEST['status'] = $_POST['status'] ? $_POST['status'] : $_POST['status1'];
        // 判断取用接口
        $is2 = $this->input->get('is2');
        $url = $is2 ? 'order/order/get_list2' : 'order/order/get_list';
        $arr = json_decode($this->curl_get(ADMINAPI . $url, $_REQUEST), true);
        if (!empty($arr['data']['rows'])) {
            // 彩种类型
            $data = json_decode($this->curl_get(ADMINAPI . 'games/play'), true);
            $orderType = array_column($data['data'], 'name', 'id');
            foreach ($arr['data']['rows'] as $k => $v) {
                isset($orderType[$v['gid']]) && $arr['data']['rows'][$k]['order_type'] = $orderType[$v['gid']];
            }
        }
        echo json_encode($arr['data']);
    }

    // 获取注单详情
    public function detail()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'order/order/getOrderDetail', $_GET), true);
        $arr['data']['account'] = $_GET['account'];
        $this->load->view('order/detail', $arr['data']);
    }

    // 获取注单中奖可能
    public function win_content()
    {
        $rs = json_decode($this->curl_get(ADMINAPI . 'order/order/getWinContent', $_GET), true);
        $this->load->view('order/win_content', $rs);
    }

    // 取消注单
    public function cancel_order()
    {
        $url = $_POST['ctg'] == 'gc' ? 'order/order/gc_cancel' : 'order/order/sc_cancel';
        $arr = $this->curl_post(ADMINAPI . $url, array('order_num' => $_POST['order_num']));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    /*****************视讯******************/
    public function ag()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('order/sx/ag', $data);
    }

    public function get_ag()
    {
        $this->load->helper('sx_helper');
        $arr = json_decode($this->curl_get(SXAPI . 'sx/shixun/get_ag_order', $_POST), true);
        foreach ($arr['data']['rows'] as $k => $v) {
            $arr['data']['rows'][$k]['game_type'] = ag_gameType($v['game_type']);
            $arr['data']['rows'][$k]['gcuser'] = substr($v['username'], 3);
        }
        echo json_encode($arr['data']);
    }

    public function dg()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('order/sx/dg', $data);
    }

    public function get_dg()
    {
        $this->load->helper('sx_helper');
        $arr = json_decode($this->curl_get(SXAPI . 'sx/shixun/get_dg_order', $_POST), true);
        foreach ($arr['data']['rows'] as $k => $v) {
            $arr['data']['rows'][$k]['result'] = result_win($v['result'], $v['GameType']);
            $arr['data']['rows'][$k]['tableId'] = gameType($v['GameType']) . ' ' . dg_zhuo($v['tableId']);
            $arr['data']['rows'][$k]['resultMoney'] = $v['winOrLoss'] - $v['availableBet'];
            $arr['data']['rows'][$k]['platUsername'] = substr($v['userName'], 3);
        }
        echo json_encode($arr['data']);
    }

    public function ky()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('order/sx/ky', $data);
    }


    public function get_ky()
    {
        $this->load->helper('sx_helper');
        $arr = json_decode($this->curl_get(SXAPI . 'sx/shixun/get_ky_order',$_POST), true);
        foreach($arr['data']['rows'] as $k=>$v){
            $arr['data']['rows'][$k]['gcuser']=ltrim($v['username'],$v['sn']);
        }
        echo json_encode($arr['data']);
    }
    public function lebo()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('order/sx/lebo', $data);
    }
    public function get_lebo()
    {
        $this->load->helper('sx_helper');
        $arr = json_decode($this->curl_get(SXAPI . 'sx/shixun/get_lebo_order',$_POST), true);
        foreach($arr['data']['rows'] as $k=>$v){
            $arr['data']['rows'][$k]['gcuser']=ltrim($v['user_name'],$v['sn']);
        }
        echo json_encode($arr['data']);
    }
    /*****************视讯 END******************/
}