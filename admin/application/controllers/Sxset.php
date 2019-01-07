<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/***
 * 模块：视讯设置返水
 * 开发者：BC
 * 日期：1920-01-15
 ***/
class Sxset extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    /*****************返点设置*******************/
    //返点设置
    public function lavelset()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('sxset/lavelset', $data);
    }

    //获取返点设置列表
    public function getlist()
    {
        $arr = json_decode($this->curl_get(SXAPI . 'sx/fsset/getfslist', $_POST), true);
        echo json_encode($arr['data']);
    }

    //编辑返点
    public function editset()
    {
        $data['rs'] = array();
        if (!empty($_GET['id'])) {
            $arr = $this->curl_get(SXAPI . 'sx/fsset/get_info?set_id=' . $_GET['id']);
            $rs = json_decode($arr, true);
            $data['rs'] = $rs['data'];
        }
        $level = $this->curl_get(SXAPI . 'level/level/show_level');
        $level = json_decode($level, true);
        $data['level'] = $level['data']['rows'];
        $this->load->view('sxset/setinfo', $data);
    }

    //保存返点
    public function save_rebate()
    {
        $arr = $this->curl_post(SXAPI . 'sx/fsset/save_rebate', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /*****************返点设置 END*******************/


    /*****************优惠统计*******************/
    //优惠统计
    public function count()
    {
        $level = $this->curl_get(SXAPI . 'level/level/show_level');
        $level = json_decode($level, true);
        $data['level'] = $level['data']['rows'];
        $this->load->view('sxset/count', $data);
    }

    public function fs_report()
    {
        $this->load->view('sxset/fs_report', $_GET);
    }

    // 获取返回优惠统计列表
    public function get_sx_rebate_list()
    {
        $rs = json_decode($this->curl_get(SXAPI . 'sx/fsset/get_sx_rebate_list', $_REQUEST), true);
        echo json_encode($rs['data']);
    }

    // 返水操作
    public function ajax_rebate_do()
    {
        $data = $this->curl_post(SXAPI . 'sx/fsset/rebate_do', $_POST);
        echo $data;
    }
    /*****************优惠统计 END*******************/

    /*****************优惠查询*******************/
    public function search()
    {
        $this->load->view('sxset/search');
    }

    public function get_rebate_report_list()
    {
        $rs = json_decode($this->curl_get(SXAPI . 'sx/fsset/get_rebate_report_list', $_POST), true);
        echo json_encode($rs['data']);
    }
    /*****************优惠查询 END*******************/

    /*****************优惠明细*******************/
    public function rebate_detail()
    {
        $this->load->view('sxset/rebate_detail', $_GET);
    }

    public function get_rebate_detail_list()
    {
        $rs = json_decode($this->curl_get(SXAPI . 'sx/fsset/get_rebate_detail_list', $_GET), true);
        echo json_encode($rs['data']);
    }

    public function ajax_rebate_cx()
    {
        $data = $this->curl_post(SXAPI . 'sx/fsset/rebate_cx', $_POST);
        echo $data;
    }
    /*****************优惠明细 END*******************/
}