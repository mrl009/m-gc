<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agent extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    //載入會員列表
    public function index()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $data['start'] = date('Y-m-d');
        $this->load->view('report/agent/index',$data);
    }

    public function new_register()
    {
        $this->load->view('report/agent/new_register', $_GET);
    }

    public function get_new_register()
    {
        $rs = $this->curl_post(ADMINAPI . 'agent/new_register', $_GET + $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    public function first_charge()
    {
        $this->load->view('report/agent/first_charge', $_GET);
    }

    public function get_first_charge()
    {
        $rs = $this->curl_post(ADMINAPI . 'agent/first_charge', $_GET + $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    public function bet_user()
    {
        $this->load->view('report/agent/bet_user', $_GET);
    }

    public function get_bet_user()
    {
        $rs = $this->curl_post(ADMINAPI . 'agent/bet_user', $_GET + $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    public function summarizing()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $data['end'] = date('Y-m-d',strtotime('-1 day'));
        $data['start'] = date('Y-m-d',strtotime($data['end'] . ' -7 day'));
        $this->load->view('report/agent/summarizing',$data);
    }

    //獲取會員列表
    public function getlist()
    {
        if ( !isset($_POST['start']) ){
            $_POST['start'] = date('Y-m-d');
        }
        $rs = $this->curl_post(ADMINAPI . 'agent/report', $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    public function getsummarizinglist()
    {
        $_POST['sort'] = isset($_POST['sort'])&&($_POST['sort']!='id') ? $_POST['sort'] : 'bet_money';
        if ( !isset($_POST['start'])  && !isset($_POST['end']) ){
            $_POST['end'] = date('Y-m-d',strtotime('-1 day'));
            $_POST['start'] = date('Y-m-d',strtotime($_POST['end'] . ' -6 day'));
        }
        $rs = $this->curl_post(ADMINAPI . 'agent/report_new', $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    //添加顶级代理
    public function add()
    {
        $this->load->view('report/agent/add');
    }

    //保存修改
    public function add_top_agent()
    {
        $pwd = $this->input->post('pwd');
        $two_pwd = $this->input->post('two_pwd');

        $pattern = '/^.{6,18}$/';
        if (!preg_match($pattern, $_POST['pwd'])){
            exit($this->status('ERROR', '密碼格式為：6-18位，不能包含漢字和空格'));
        }

        $pattern = '/[\s|　]+/';
        if (preg_match($pattern, $_POST['pwd'])) {
            exit($this->status('ERROR', '密碼不能包含中文和空格'));
        }

        $pattern = '/[\x{4e00}-\x{9fa5}]/u';
        if (preg_match($pattern, $_POST['pwd'])) {
            exit($this->status('ERROR', '密碼不能包含中文和空格'));
        }

        if ($pwd !== $two_pwd) {
            exit($this->status('ERROR', '兩次密碼不壹致'));
        }else{
            $_POST['pwd'] = md5($_POST['pwd']);
            $_POST['two_pwd'] = md5($_POST['two_pwd']);
        }
        $arr = $this->curl_post(ADMINAPI . 'agent/add_top_agent', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }

    }
}