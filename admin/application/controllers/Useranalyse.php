<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Useranalyse extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    // 下注分析
    public function bet()
    {
        $data = array();
        // 彩种类型
        $arr = json_decode($this->curl_get(ADMINAPI . 'games/play'), true);
        $data['games'] = array_column($arr['data'], 'name', 'id');
        $this->load->view('useranalyse/bet', $data);
    }

    // 下注分析列表
    public function get_bet_list()
    {
        $ret = $this->curl_get(ADMINAPI . 'analysis/buy_analysis/get_list', $_POST);

        $arr = json_decode($ret,true);

        $data = $arr['data'];
        echo json_encode($data);
    }

    public function effective_user()
    {
        $data = array();
        $this->load->view('useranalyse/effective_user', $data);
    }

    public function analysis_cash()
    {
        $data = array();
        $data['auth'] = explode(',', $this->input->get('auth'));
        if(!empty($_GET['skip'])) {
            $data['skip'] = 'skip='.$_GET['skip'].'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&f_username='.$_GET['f_username'].'&agent_id='.$_GET['agent_id'];
            if (!empty($_GET['impounded'])) {
                $data['skip'] .= '&impounded=1';
            }
        }
        $this->load->view('useranalyse/analysis_cash', $data);
    }

    public function get_effective_user()
    {
        $data = $this->curl_get(ADMINAPI . 'cash/cash_user/effective_member', $_POST);

        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    public function get_analysis_cash()
    {
//        echo json_encode($_REQUEST);
        $data = $this->curl_get(ADMINAPI . 'analysis/inout_price/get_list', $_REQUEST);

        $arr = json_decode($data, true);
        echo json_encode($arr['data']);

    }

    // 会员查询
    public function member_check()
    {
        $data = array();
        $data['auth']=explode(',',$this->input->get('auth'));
        $this->load->view('useranalyse/member_check', $data);
    }

    // 会员查询列表
    public function get_member_check_list()
    {
        $data = $this->curl_get(ADMINAPI . 'cash/cash_user/user_select', $_POST);

        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    // 优惠分析
    public function privilege_analyse()
    {
        $data = array();
        if(!empty($_GET['skip'])) {
            $data['skip'] = 'skip='.$_GET['skip'].'&start='.$_GET['time_start'].'&end='.$_GET['time_end'].'&username='.$_GET['f_username'].'&agent_id='.$_GET['agent_id'];
        }
        $this->load->view('useranalyse/privilege_analyse', $data);
    }

    // 优惠分析列表
    public function get_privilege_analyse_list()
    {

        foreach ($_GET as $key => $value) {
            if (empty($_POST[$key])) {
                $_POST[$key] = $value;
            }
        }
        $data = $this->curl_get(ADMINAPI . 'cash/cash_user/discount_count', $_POST);

        $arr = json_decode($data, true);

        $arr['data']['footer']['total'] = count($arr['data']['rows']);
        $arr['data']['footer'] = [$arr['data']['footer']];
        echo json_encode($arr['data']);
    }

    // 会员统计
    public function member_statistics()
    {
        $data = array();
        // 层级信息
        $arr = json_decode($this->curl_get(ADMINAPI . 'level/level/level_base'), true);
        $data['level'] = $arr['data']['rows'];
        $this->load->view('useranalyse/member_statistics', $data);
    }

    // 会员统计列表
    public function get_member_statistics_list()
    {
        $_POST['uid'] = $_GET['uid'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/cash_user/member_count', $_POST), true);
        $data = $arr['data'];
        echo json_encode($data);
    }

    // 有效会员单个详情
    public function date_effective()
    {
        $this->load->view('useranalyse/date_effective', $_GET);
    }

    public function get_date_effective()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . '/cash/cash_user/date_effective', $_GET), true);
        echo json_encode($arr['data']);
    }
}