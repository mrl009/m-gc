<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    //载入报表
    public function index()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $arr = json_decode($this->curl_get(ADMINAPI . 'level/level/show_level', $_POST), true);
        $data['level'] = $arr['data']['rows'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'report/report/months'), true);
        if ($arr['code'] == 200) {
            $data['qi_shu_key'] = array_keys($arr['data']);
            $data['qi_shu_data'] = $arr['data'];
        }
        $arr = json_decode($this->curl_get(ADMINAPI . 'report/report/day_bets'), true);
        if ($arr['code'] == 200) {
            $arr = $arr['data'];
            $today = $arr[date('Ymd')];
            $yesterday = $arr[date('Ymd', strtotime('-1 days'))];
            $data['settlement_finish']['today'] = $today[1];
            $data['settlement_finish']['yesterday'] = $yesterday[1];
            $data['settlement_unfinished']['today'] = $today[0] - $today[1];
            $data['settlement_unfinished']['yesterday'] = $yesterday[0] - $yesterday[1];
        } else {
            $data['settlement_finish']['today'] = 0;
            $data['settlement_finish']['yesterday'] = 0;
            $data['settlement_unfinished']['today'] = 0;
            $data['settlement_unfinished']['yesterday'] = 0;
        }
        $arr = json_decode($this->curl_get(ADMINAPI . 'report/report/index'), true);
        if ($arr['code'] == 200) {
            $data['win_lose']['today'] = $arr['data']['win_lose']['today'];
            $data['win_lose']['yesterday'] = $arr['data']['win_lose']['yesterday'];
            $data['lose']['today'] = $arr['data']['lose']['today'];
            $data['lose']['yesterday'] = $arr['data']['lose']['yesterday'];
            $data['win']['today'] = $arr['data']['win']['today'];
            $data['win']['yesterday'] = $arr['data']['win']['yesterday'];
        }
        // @modify 2018-04-14 根据配置过滤视讯
        $set = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        if ($set['code'] == 200) {
            $sx_id = [1001, 1002, 1003, 1004, 1005]; //@todo 如果要新加视讯彩种这边改为读取公库数据
            $cp = explode(',', $set['data']['cp']);
            $sx_list = array_intersect($sx_id, $cp);
            $data['is_sx'] = empty($sx_list) ? false : true;
        }
        $this->load->view('report/index', $data);
    }

    // 报表刷新
    public function report_refresh()
    {
        $res = $this->curl_post(ADMINAPI . 'report/report/pumping', $_GET);
        $rs = json_decode($res, true);
        echo json_encode($rs);
    }

    //报表查询
    public function report_search()
    {
        $this->load->view('report/report_search');
    }

    //会员报表
    public function settlement_report()
    {
        $this->load->view('report/settlement_report', $_GET);
    }

    //彩票报表
    public function classify_report()
    {
        $this->load->view('report/classify_report', $_GET);
    }

    // 会员、彩票列表
    public function get_search_report_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'report/report/get_list', $_GET + $_POST), true);
        $arr['data']['footer']['name'] = '總額';
        $arr['data']['footer'] = array($arr['data']['footer']);
        echo json_encode($arr['data']);
    }

/********视讯*************/
    //会员视讯报表
    public function user_sx_report()
    {
        $this->load->view('report/user_sx_report', $_GET);
    }

    // 会员视讯列表
    public function get_user_sx_list()
    {
        $arr = json_decode($this->curl_get(SXAPI . 'report/sx_report/get_list', $_GET + $_POST), true);
        $arr['data']['footer']['name'] = '總額';
        $arr['data']['footer'] = array($arr['data']['footer']);
        echo json_encode($arr['data']);
    }
    //视讯报表
    public function sx_report()
    {
        $this->load->view('report/sx_report', $_GET);
    }

    // 视讯列表
    public function get_sx_list()
    {
        $arr = json_decode($this->curl_get(SXAPI . 'report/sx_report/get_list', $_GET + $_POST), true);
        $arr['data']['footer']['name'] = '總額';
        $arr['data']['footer'] = array($arr['data']['footer']);
        echo json_encode($arr['data']);
    }
/*********************/
    // 彩票账单
    public function lottery()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $arr = json_decode($this->curl_get(ADMINAPI . 'report/report/months'), true);
        if ($arr['code'] == 200) {
            $data['qi_shu_key'] = array_keys($arr['data']);
            $data['qi_shu_data'] = $arr['data'];
        }
        $this->load->view('report/lottery', $data);
    }

    /***
     * 模块：图表
     * 开发者：super
     * 日期：2017-06-22
     ***/

    //图形报表页面显示
    public function chart()
    {
        $this->load->view('report/chart');
    }

    public function get_chart()
    {
        $data = $this->curl_get(ADMINAPI . 'Chart/' . $_POST['flag'], $_POST);
        echo $data;
    }

    public function del_chart_redis()
    {
        $data = $this->curl_get(ADMINAPI . 'Chart/del_chart_redis');
        echo $data;
    }

    //综合报表
    public function s_report()
    {
        $params = [
            'start' => date('Y-m-d', time()),
            'end' => date('Y-m-d', time())
        ];
        $arr = json_decode($this->curl_post(ADMINAPI . 'report/report/home', $params), true);
        $data['rs'] = $arr['data'];
        //盈利
        if ($arr['data']['bet_money'] != null && $arr['data']['prize_money'] != null) {
            $data['win_price'] = sprintf("%.3f", $arr['data']['bet_money'] - $arr['data']['prize_money']);
            $data['win_rate'] = sprintf("%.2f", ($arr['data']['bet_money'] - $arr['data']['prize_money']) / $arr['data']['bet_money'] * 100);
        } else {
            $data['win_price'] = '0.000';
            $data['win_rate'] = '0.00';
        }
        $this->load->view('report/s_report', $data);
    }

    public function ajax_s_report()
    {
        $arr = json_decode($this->curl_post(ADMINAPI . 'report/report/home', $_POST), true);
        $data['rs'] = [
            'activity_money' => $arr['data']['activity_money'] == null ? 0.000 : $arr['data']['activity_money'],
            'activity_user_num' => $arr['data']['activity_user_num'] == null ? 0 : $arr['data']['activity_user_num'],
            'bet_money' => $arr['data']['bet_money'] == null ? 0.000 : $arr['data']['bet_money'],
            'bet_num' => $arr['data']['bet_num'] == null ? 0 : $arr['data']['bet_num'],
            'cancel_money' => $arr['data']['cancel_money'] == null ? 0.000 : $arr['data']['cancel_money'],
            'cancel_num' => $arr['data']['cancel_num'] == null ? 0 : $arr['data']['cancel_num'],
            'charge_money' => $arr['data']['charge_money'] == null ? 0.000 : $arr['data']['charge_money'],
            'charge_num' => $arr['data']['charge_num'] == null ? 0 : $arr['data']['charge_num'],
            'charge_user_num' => $arr['data']['charge_user_num'] == null ? 0 : $arr['data']['charge_user_num'],
            'first_charge_num' => $arr['data']['first_charge_num'] == null ? 0 : $arr['data']['first_charge_num'],
            'out_people_money' => $arr['data']['out_people_money'] == null ? 0.000 : $arr['data']['out_people_money'],
            'prize_money' => $arr['data']['prize_money'] == null ? 0.000 : $arr['data']['prize_money'],
            'prize_num' => $arr['data']['prize_num'] == null ? 0 : $arr['data']['prize_num'],
            'rebate_money' => $arr['data']['rebate_money'] == null ? 0.000 : $arr['data']['rebate_money'],
            'rebate_num' => $arr['data']['rebate_num'] == null ? 0 : $arr['data']['rebate_num'],
            'rebate_user_num' => $arr['data']['rebate_user_num'] == null ? 0 : $arr['data']['rebate_user_num'],
            'refuse_money' => $arr['data']['refuse_money'] == null ? 0.000 : $arr['data']['refuse_money'],
            'register_num' => $arr['data']['register_num'] == null ? 0 : $arr['data']['register_num'],
            'withdraw_money' => $arr['data']['withdraw_money'] == null ? 0.000 : $arr['data']['withdraw_money'],
            'withdraw_num' => $arr['data']['withdraw_num'] == null ? 0 : $arr['data']['withdraw_num'],
            'withdraw_user_num' => $arr['data']['withdraw_user_num'] == null ? 0 : $arr['data']['withdraw_user_num'],
        ];
        //盈利
        if ($arr['data']['bet_money'] != null && $arr['data']['prize_money'] != null) {
            $data['win_price'] = sprintf("%.3f", $arr['data']['bet_money'] - $arr['data']['prize_money']);
            $data['win_rate'] = sprintf("%.2f", ($arr['data']['bet_money'] - $arr['data']['prize_money']) / $arr['data']['bet_money'] * 100);
        } else {
            $data['win_price'] = '0.000';
            $data['win_rate'] = '0.00';
        }
        echo json_encode($data);
    }
}