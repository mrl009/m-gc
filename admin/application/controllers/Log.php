<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    // 会员登陆
    public function member_login()
    {
        $this->load->view('log/member_login');
    }

    // 会员登陆列表
    public function get_member_login_list()
    {
        $_POST = array_merge($_POST, array('log_type' => 'log_user_login'));
        $uid = $_GET['uid'];
        if (!empty($uid)) $_POST['uid'] = $uid;
        $arr = json_decode($this->curl_get(ADMINAPI . 'log/log/getLogList', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 获取IP地址
    public function get_ip_location()
    {
        $type = $this->input->get('type');
        if (!$type) {
            $ip = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=" . $_GET["ip"]);
        } else {
            $ip = $this->get_bd_ip($_GET["ip"]);
        }
        echo $ip;
    }

    private function get_bd_ip($ip)
    {
        $data = [
            'ip' => $ip,
            'ak' => 'goyZKlYa1MGiiw18WuTXZ0DV5mqtPmsI'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.map.baidu.com/location/ip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $rs = curl_exec($ch);
        curl_close($ch);
        return $rs;
    }

    // 添加会员登录IP黑名单
    public function add_member_login_black()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/log/add_black', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 移除会员登录IP黑名单
    public function del_member_login_black()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/log/rm_black', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 管理登陆
    public function manage_login()
    {
        $this->load->view('log/manage_login');
    }

    // 管理登陆列表
    public function get_manage_login_list()
    {
        $_POST = array_merge($_POST, array('log_type' => 'log_admin_login'));
        $arr = json_decode($this->curl_get(ADMINAPI . 'log/log/getLogList', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 添加管理登陆IP黑名单
    public function add_manage_login_black()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/log/add_black', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 移除管理登陆IP黑名单
    public function del_manage_login_black()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/log/rm_black', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 操作记录
    public function handle_log()
    {
        $this->load->view('log/handle_log');
    }

    // 操作记录列表
    public function get_handle_log_list()
    {
        $_POST = array_merge($_POST, array('log_type' => 'log_admin_record'));
        $arr = json_decode($this->curl_get(ADMINAPI . 'log/log/getLogList', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 会员消息
    public function member_info()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('log/member_info', $data);
    }

    // 会员消息列表
    public function get_member_info_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'log/user_msg_log/getMsgLogList', $_POST), true);
        echo json_encode($arr['data']);
    }

    // 增加会员消息弹框
    public function add_member_info()
    {
        $data['admin_id'] = $this->session->userdata('admin_id');
        $this->load->view('log/add_member_info', $data);
    }

    // 保存会员消息
    public function save_member_info()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/user_msg_log/add', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 删除会员消息
    public function delete_member_info()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/user_msg_log/delete', array('id' => $_POST['id'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 前台公告
    public function front_notice()
    {
        $data['admin_id'] = $this->session->userdata('admin_id');
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('log/front_notice', $data);
    }

    // 前台公告列表
    public function get_front_notice_list()
    {
        isset($_POST['content']) && $_POST['content'] = urlencode($_POST['content']);
        $arr = json_decode($this->curl_get(ADMINAPI . 'log/user_notice_log/getNoticeLogList', $_POST), true);
        $arr['data']['rows']=array_map(function ($item){
            if($item['level_id'] == -1){
                $item['level_name'] = '全部层级';
            }
            return $item;
        },$arr['data']['rows']);
        echo json_encode($arr['data']);
    }
    //额度流水
    public function credit_record()
    {
        $data['admin_id'] = $this->session->userdata('admin_id');
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('log/credit_record',$data);
    }
    //获取额度流水
    public function get_credit_record()
    {
        $_POST['admin_id'] = $this->session->userdata('admin_id');
        $arr = json_decode($this->curl_get(SXAPI . 'sx/shixun/get_sx_credit', $_POST), true);
        echo json_encode($arr['data']['rows']);
    }
    // 新增修改前台公告弹框
    public function add_front_notice()
    {
        $data = array();
        $data['admin_id'] = isset($_GET['admin_id']) ? $_GET['admin_id'] : '';
        if (!empty($_GET['id'])) {
            $arr = json_decode($this->curl_get(ADMINAPI . 'log/user_notice_log/getInfo?id=' . $_GET['id']), true);
            $data = $arr['data'];
        }
        // 层级信息
        $arr = json_decode($this->curl_get(ADMINAPI . 'level/level/level_base'), true);
        $data['level'] = $arr['data']['rows'];
        // 公告类型
        $arr = json_decode($this->curl_get(ADMINAPI . 'log/user_notice_log/getNoticeTypeAndShowLocation'), true);
        $data['noticeType'] = $arr['data']['notice_type'];
        $data['showLocation'] = $arr['data']['show_location'];
        $this->load->view('log/add_front_notice', $data);
    }

    // 新增保存公告修改
    public function save_front_notice()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/user_notice_log/saveNotice', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 删除公告
    public function delete_front_notice()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/user_notice_log/delete', array('id' => $_POST['id'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 更新公告状态
    public function update_front_notice_status()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'log/user_notice_log/updateStatus', array('id' => $_POST['id'], 'status' => $_POST['status'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
}