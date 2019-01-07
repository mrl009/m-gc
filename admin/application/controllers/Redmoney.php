<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Redmoney extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    /***********************************红包设置***********************************************/
    //红包设置
    public function activeset()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('redmoney/activeset', $data);
    }

    // 获取红包设置
    public function get_activeset()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'red/activity/all', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 新增修改红包设置
    public function add_activeset()
    {
        $data = array();
        if (!empty($_GET['id'])) {
            $arr = json_decode($this->curl_get(ADMINAPI . 'red/activity/one?id=' . $_GET['id']), true);
            $data = $arr['data'];
        }
        $this->load->view('redmoney/add_activeset', $data);
    }

    // 批量新增红包设置
    public function multiple_add_activeset()
    {
        $this->load->view('redmoney/multiple_add_activeset', $_GET);
    }

    // 新增保存红包设置
    public function save_activeset()
    {
        $url = !empty($_POST['id']) ? 'red/activity/upd' : 'red/activity/add';
        $rs = json_decode($this->curl_post(ADMINAPI . $url, $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 批量保存操作
    public function multiple_save_activeset()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'red/activity/batch', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 删除红包设置数据
    public function delete_activeset()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'red/activity/del', array('id' => $_POST['id'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /***********************************红包设置end********************************************/

    /***********************************等级设置***********************************************/
    //等级设置
    public function lavelset()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('redmoney/lavelset', $data);
    }

    // 获取红包设置
    public function get_lavelset()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'red/level/all', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 新增修改红包设置
    public function add_lavelset()
    {
        $data = array();
        if (!empty($_GET['id'])) {
            $arr = json_decode($this->curl_get(ADMINAPI . 'red/level/one?id=' . $_GET['id']), true);
            $data = $arr['data'];
        }
        $this->load->view('redmoney/add_lavelset', $data);
    }

    // 新增保存红包设置
    public function save_lavelset()
    {
        $url = !empty($_POST['id']) ? 'red/level/upd' : 'red/level/add';
        $rs = json_decode($this->curl_post(ADMINAPI . $url, $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 删除红包设置数据
    public function delete_lavelset()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'red/level/del', array('id' => $_POST['id'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /***********************************等级设置end********************************************/

    /***********************************订单列表***********************************************/
    //订单列表
    public function orderlist()
    {
        $data = $_GET;
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('redmoney/orderlist', $data);
    }

    // 获取订单列表
    public function get_orderlist()
    {
        if (empty($_POST['start_time']) && empty($_POST['end_time']) && empty($_POST['username']) && !empty($_GET['rid'])) {
            $_POST['rid'] = $_GET['rid'];
        }
        $arr = json_decode($this->curl_get(ADMINAPI . 'red/order/all', $_POST), true);
        echo json_encode($arr['data']);
    }
    /***********************************订单列表end********************************************/

    /***********************************红包说明***********************************************/
    //红包说明
    public function memo()
    {
        $data = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_site_one?id=38'), true);
        $this->load->view('redmoney/memo', $data['data']);
    }

    public function save_memo()
    {
        //$reg = '/<(\/?html.*?)>|<(\/?body.*?)>|<(\/?head.*?)>|<(\/?meta.*?)>|<(\/?table.*?)>|<(\/?tbody.*?)>|<(\/?td.*?)>|<(\/?tr.*?)>|<(\/?th.*?)>/';
        $data = [
            'id' => 38,
            'title' => '紅包說明',
            //'content' => preg_replace($reg,  '', $_POST['content'])
            'content' => $_POST['content']
        ];
        $rs = json_decode($this->curl_post(ADMINAPI . 'setting/setting/saveSiteInfo', $data), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /***********************************红包说明end********************************************/
}