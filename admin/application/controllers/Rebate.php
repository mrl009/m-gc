<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rebate extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    /***********************************获取代理退佣设定*************************************/
    public function set()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('rebate/set', $data);
    }

    // 获取列表
    public function get_set_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'rebate/rebate_manage/getSetList', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 新增修改代理退佣设定
    public function add_set()
    {
        if (!empty($_GET['id'])) {
            $arr = json_decode($this->curl_get(ADMINAPI . 'rebate/rebate_manage/getSetInfo?id=' . $_GET['id']), true);
            $data = $arr['data'];
        }
        $arr = json_decode($this->curl_get(ADMINAPI . 'rebate/rebate_manage/getRateType'), true);
        $data['rate_type'] = $arr['data']['rate_type'];
        $this->load->view('rebate/add_set', $data);
    }

    // 保存新增修改数据
    public function save_set()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'rebate/rebate_manage/addSet', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 更新状态
    public function update_set_status()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'rebate/rebate_manage/updateSetStatus', array('id' => $_POST['id'], 'status' => $_POST['status'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 设置佣金模式
    public function set_rate_type()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'rebate/rebate_manage/getRateType'), true);
        $data = $arr['data'];
        $this->load->view('rebate/set_rate_type', $data);
    }

    // 保存佣金模式
    public function save_rate_type()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'rebate/rebate_manage/saveRateType', array('rate_type' => $_POST['rate_type'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /***********************************END代理退佣设定*************************************/

    /***********************************获取退佣查询*************************************/
    public function search()
    {
        $data = $_GET;
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('rebate/search', $data);
    }

    public function get_search_list()
    {
        $_POST['report_date'] = $_GET['report_date'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'rebate/rebate_manage/getSearchList', $_POST), true);
        echo json_encode($arr['data']);
    }

    /**
     * 确认返佣
     */
    public function agent_rebate()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'cash/in_company/agent_rebate', $_POST), true);
        echo json_encode($rs);
    }
    /***********************************END退佣查询*************************************/

    /***********************************获取退佣统计*************************************/
    public function count()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('rebate/count', $data);
    }

    public function get_count_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'rebate/rebate_manage/getCountList', $_POST), true);
        echo json_encode($arr['data']);
    }
    /***********************************END退佣统计*************************************/
}