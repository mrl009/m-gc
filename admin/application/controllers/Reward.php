<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reward extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    //嘉獎機制
    public function index()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $rs = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'),true);
        if ($rs['code'] == 200) {
            $data['reward_day'] = explode(',',$rs['data']['reward_day']);
        } else {
            $data['reward_day'] = [100,1000,20000];
        }
        $this->load->view('reward/index',$data);
    }

    public function get_reward()
    {
        $rs = json_decode($this->curl_get(ADMINAPI . 'reward_day/index'), true);
        echo json_encode($rs['data']);
    }

    public function edit_reward()
    {
        $data = json_decode($this->curl_get(ADMINAPI . 'reward_day/reward_info', $_GET), true);
        $this->load->view('reward/edit_reward', $data);
    }

    public function save_reward()
    {
        if ($_POST['d1_rate'] > 2 || $_POST['d2_rate'] > 2 || $_POST['d3_rate'] > 2) {
            exit($this->status('ERROR', '嘉奖比例不能大于2'));
        }
        $rs = json_decode($this->curl_post(ADMINAPI . 'reward_day/save_reward', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //嘉獎詳情
    public function detail()
    {
        $this->load->view('reward/detail');
    }

    public function get_detail()
    {
        $rs = json_decode($this->curl_get(ADMINAPI . 'reward_day/get_detail', $_POST), true);
        echo json_encode($rs['data']);
    }
}