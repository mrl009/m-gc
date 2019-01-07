<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller
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
        $rs = $this->curl_get(ADMINAPI . 'level/level/show_level', $_POST);
        $arr = json_decode($rs, true);
        $data['level'] = $arr['data']['rows'];
        $data['type'] = $this->uri->segment(3);
        $this->load->view($data['type'] == 1 ? 'member/index' : 'member/agent', $data);
    }

    //獲取會員列表
    public function getlist()
    {
        $_POST['type'] = $this->uri->segment(3);
        if ($_POST['type'] == 1) {
            $rs = $this->curl_get(ADMINAPI . 'level/member/index', $_POST);
            $arr = json_decode($rs, true);
            echo json_encode($arr['data']);
        } else if ($_POST['type'] == 2) {
            $rs = $this->curl_get(ADMINAPI . 'level/member/agent', $_POST);
            $arr = json_decode($rs, true);
            echo json_encode($arr['data']);
        } else {

        }

    }

    //修改會員狀態
    public function update_member_status()
    {
        $status = $_POST['status'] == 1 ? 2 : 1;
        $arr = $this->curl_post(ADMINAPI . 'level/member/chang_status',
            array('id' => $_POST['id'], 'status' => $status, 'username' => $_POST['username']));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //修改會員反水狀態
    public function update_rebate_status()
    {
        $status = $_POST['status'] == 1 ? 0 : 1;
        $arr = $this->curl_post(ADMINAPI . 'level/member/chang_rebate_status',
            array('id' => $_POST['id'], 'ban' => $status, 'username' => $_POST['username']));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }


    //踢出會員
    public function user_out()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'level/member/user_out', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    public function export()
    {
        $arr = $this->input->post('val');
        $fields = $this->input->post('fields');
        $title = $this->input->post('title');
        $this->load->library('gc/core');
        foreach ($fields as $k => $v) {
            $fields[$k] = $v;
        }
        foreach ($arr as $k => $v) {
            $t = explode('^', $v);
            $ss = array();
            foreach ($t as $kk => $vv) {
                $ss[$kk] = $vv;
            }
            $data[] = $ss;
        }
        $this->core->export($title, array(array('name' => $title, 'data' => $data, 'fields' => $fields)));

    }

    //保存會員
    public function save_member()
    {
        if (isset($_POST['bank_pwd'])) {
            if ($_POST['bank_pwd'] == '******') {
                unset($_POST['bank_pwd']);
            } else if($_POST['bank_pwd'] === ''){
                $_POST['bank_pwd'] = null;
            }else{
                $patten = '/^\d{6}$/';
                if(!preg_match($patten,$_POST['bank_pwd'])){
                    exit($this->status('ERROR', '資金密碼必須為6位純數字'));
                }else{
                    $_POST['bank_pwd'] = md5($_POST['bank_pwd']);
                }
            }
        }

        if ($_POST['pwd'] == '******') {
            unset($_POST['pwd']);
        } else if($_POST['pwd'] == ''){
            $_POST['pwd'] = null;
        }else{

            if (empty($_POST['pwd'])) {
                exit($this->status('ERROR', '密碼不能為空'));
            }

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

            $_POST['pwd'] = md5($_POST['pwd']);
        }
        if (isset($_POST['bank_num']) && !empty($_POST['bank_num'])) {
            rtrim(' ', $_POST['bank_num']);
        }

        $arr = $this->curl_post(ADMINAPI . 'level/member/update', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //修改會員
    public function edit_member()
    {
        $data['auth']=explode(',',$this->input->get('auth'));
        $uid = $this->input->get('uid');
        $is_actual = $this->input->get('is_actual');
        $is_audit = $this->input->get('is_audit');
        $id = $uid ? $uid : $this->input->get('id');
        if (empty($id)) exit('ID不能為空');
        $arr = $this->curl_get(ADMINAPI . 'level/member/update_show/' . $id . '?detail=1');
        $rs = json_decode($arr, true);
        $level = $this->curl_get(ADMINAPI . 'level/level/show_level');
        $level = json_decode($level, true);
        $data['level'] = $level['data']['rows'];
        $data['rs'] = $rs['data'];
        $data['rs']['pwd']='******';
        $data['rs']['id'] = $id;
        $data['is_actual'] = $is_actual;
        $data['is_audit'] = $is_audit ? $is_audit : 0;
        // 銀行卡信息
        $platform = json_decode($this->curl_get(ADMINAPI . 'level/bank/bank_list', array('type' => 1)), true);
        $data['platform'] = $platform['data']['bank'];
        // 出款管理信息
        $data['payment_id'] = $this->input->get('payment_id');
        $data['actual_price'] = $this->input->get('actual_price');
        $data['order_num'] = $this->input->get('order_num');
        $data['form_id'] = $this->input->get('form_id');
        $this->load->view('member/edituser', $data);
    }

    //獲取分層信息
    public function getfc()
    {
        $data['id'] = $this->input->get('id');
        $arr = $this->curl_get(ADMINAPI . 'level/member/update_show/' . $data['id'] . '?detail=1');
        $uinfo = json_decode($arr, true);
        $le = $this->curl_get(ADMINAPI . 'level/level/show_level', $_POST);
        $arr = json_decode($le, true);
        $data['level'] = $arr['data']['rows'];
        $data['is_level_lock'] = $uinfo['data']['is_level_lock'];
        $data['level_id'] = $uinfo['data']['level_id'];
        $this->load->view('member/fcinfo', $data);
    }

    //保存分層信息
    public function save_fc()
    {
        $_POST['is_level_lock'] = $_POST['is_level_lock'] == 'on' ? 1 : 0;
        $arr = $this->curl_post(ADMINAPI . 'level/member/move_level', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //基本資料設定
    public function basic_info()
    {
        $this->load->view('member/basic_info');
    }

    //獲取日誌
    public function get_log()
    {
        $data['uid'] = $this->input->get('uid');
        $this->load->view('log/easy_member', $data);
    }

    //獲取現金
    public function get_cash()
    {
        $data['uid'] = $this->input->get('uid');
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/cash_list/get_list'), true);
        $data['level'] = $arr['data']['types'];
        $this->load->view('cash/easy_cash', $data);
    }

    //獲取下註
    public function get_order()
    {
        $data['uid'] = $this->input->get('uid');
        // 彩種類型
        $games = json_decode($this->curl_get(ADMINAPI . 'games/info'), true);
        $data['games'] = $games['data']['rows'];
        // 來源
        $arr = json_decode($this->curl_get(ADMINAPI . 'order/order/getFromType'), true);
        $data['from_type'] = $arr['data'];
        $this->load->view('order/easy_order', $data);
    }

    // 獲取會員統計
    public function get_count()
    {
        $_POST['uid'] = $this->input->get('uid');
        $ttt = json_decode($this->curl_get(ADMINAPI . 'level/member/update_show/' . $_POST['uid'] . '?detail=1'), true);

        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/cash_user/user_count', $_POST), true);
        $data = $arr['data']['rows'];
        $data['rs'] = $ttt['data'];
        $this->load->view('useranalyse/easy_count', $data);
    }

    // 稽核
    public function get_audit()
    {
        $data['uid'] = $this->input->get('uid');
        $this->load->view('cash/audit/easy_list', $data);
    }

    public function get_audit_list()
    {
        $_POST['uid'] = $_GET['uid'];
        $data = $this->curl_get(ADMINAPI . 'auth/index/auth', $_POST);
        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    // 出款管理
    public function get_payment()
    {
        $data = $_GET;
        if (empty($data['id']) || empty($data['uid'])) exit('ID不能為空');
        $arr = $this->curl_get(ADMINAPI . 'level/member/update_show/' . $data['uid'] . '?detail=1');
        $rs = json_decode($arr, true);
        $data['rs'] = $rs['data'];
        // 銀行卡信息
        $platform = json_decode($this->curl_get(ADMINAPI . 'level/bank/bank_list', array('type' => 1)), true);
        $data['bank'] = '';
        foreach ($platform['data']['bank'] as $v) {
            if ($v['id'] == $data['rs']['bank_id']) {
                $data['bank'] = $v['bank_name'];
            }
        }
        //出款信息
        $out = json_decode($this->curl_get(ADMINAPI . 'cash/out_manage/outtype/'.$data['id']), true);
        $data['bank'] = $out['data']['pay_type'];
        $data['bank_num'] = $out['data']['pay_user'];
        $data['address'] = $out['data']['pay_address'];
        $data['qrcode'] = $out['data']['pay_image'];
        $this->load->view('cash/base_info', $data);
    }

    // 出款記錄
    public function get_payment_list()
    {
        $this->load->view('cash/easy_payment_list', $_GET);
    }
    //视讯额度
    public function get_credit_list()
    {
        $_POST['uid'] = $this->input->get('uid');
        $ttt = json_decode($this->curl_get(SXAPI . 'sx/shixun/get_user_sx_credit', $_POST), true);
        $data['user']=$ttt['data']['user'];
        $data['ky']=isset($ttt['data']['sx']['ky'])?$ttt['data']['sx']['ky']:0;
        $data['ag']=isset($ttt['data']['sx']['ag'])?$ttt['data']['sx']['ag']:0;
        $data['dg']=isset($ttt['data']['sx']['dg'])?$ttt['data']['sx']['dg']:0;
        $this->load->view('useranalyse/credit_list', $data);
    }
    /*********************************子帳號************************************/
    //載入列表
    public function child()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('member/child', $data);
    }

    //獲取列表
    public function getchild()
    {
        $rs = $this->curl_get(ADMINAPI . 'manager/get_child_list', $_POST);
        $arr = json_decode($rs, true);
        foreach ($arr['data']['rows'] as $k => $v) {
            if ($v['username'] == 'js888999' || $v['username'] == 'ycjs') {
                unset($arr['data']['rows'][$k]);
            }
        }
        $arr['data']['rows'] = array_values($arr['data']['rows']);
        echo json_encode($arr['data']);
    }

    //修改
    public function editchild()
    {
        $data['rs'] = array();
        if (!empty($_GET['id'])) {
            $arr = $this->curl_get(ADMINAPI . 'manager/get_info?admin_id=' . $_GET['id']);
            $rs = json_decode($arr, true);
            $data['rs'] = $rs['data'];
        }
        $this->load->view('member/editchild', $data);
    }

    //保存修改
    public function save_child()
    {
        $id = $this->input->post('admin_id');
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
        $arr = $this->curl_post(ADMINAPI . 'manager/update_user', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }

    }

    //修改返点
    public function edit_rebate()
    {
        if (empty($_GET['id'])) {
            exit($this->status('ERROR', '缺少参数'));
        }
        $rs = $this->curl_get(ADMINAPI . 'agent/get_info/' . $_GET['id']);
        $rs = json_decode($rs,true);
        if ($rs['code'] == 200) {
            $this->load->view('member/edit_rebate', $rs['data']);
        } else {
            exit($rs['msg']);
        }
    }
    public function save_rebate()
    {
        $arr = $this->curl_post(ADMINAPI . 'agent/update_rebate', $_POST);
        $rs = json_decode($arr, true);

        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //獲取權限
    public function get_power()
    {
        $data['public'] = file_get_contents('static/data/public_menu.json');
        if (!empty($_GET['id'])) {
            $arr = $this->curl_get(ADMINAPI . 'manager/get_info?admin_id=' . $_GET['id']);
            $rs = json_decode($arr, true);
            $data['rs'] = $rs['data'];
            $auth = $data['rs']['privileges'];
            if ($auth == '*') {
                $data['rs']['privileges'] = '[]';
                $data['all'] = '*';
            } else if (empty($data['rs']['privileges'])) {
                $data['rs']['privileges'] = [];
            }
        }
        $this->load->view('member/get_power', $data);
    }

    //保存權限
    public function save_power()
    {
        $top_menu = $this->input->post('top_menu');
        $sub_menu = $this->input->post('sub_menu');
        $act = array();
        foreach ($top_menu as $k => $v) {
            foreach ($v as $i => $s) {
                foreach ($sub_menu[$k][$s] as $e => $o) {
                    $act[$k][$s][$e] = $o;
                }
            }
        }
        $row['privileges'] = json_encode($act);
        $row['admin_id'] = $this->input->post('admin_id');
        $row['max_credit_out_in'] = $this->input->post('max_credit_out_in');
        $row['max_credit_in_people'] = $this->input->post('max_credit_in_people');
        $row['username'] = $this->input->post('username');
        $arr = $this->curl_post(ADMINAPI . 'manager/save_privilege', $row);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //刪除管理員
    public function delete_user()
    {
        $arr = $this->curl_post(ADMINAPI . 'manager/delete_user', array('admin_id' => $_POST['id']));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //修改管理員狀態
    public function update_status()
    {
        $arr = $this->curl_post(ADMINAPI . 'manager/update_status', array('admin_id' => $_POST['id'], 'status' => $_POST['status'], 'username' => $_POST['username']));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    /*********************************代理審核************************************/
    public function agent()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('member/agent_audit', $data);
    }

    public function get_agent_audit_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'agent/get_agent_list', $_POST), true);
        echo json_encode($arr['data']);
    }

    public function agent_submit_form()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'agent/get_agent_detail', $_GET), true);
        $result['data'] = $arr['data'];
        $this->load->view('member/agent_form', $result);
    }

    public function form_save()
    {
        $data = $this->curl_post(ADMINAPI . 'agent/agent_detail_update', $_POST);
        echo $data;
    }


    /*********************************代理管理****************************************/
    //修改代理
    public function edit_agent()
    {

        $uid = $this->input->get('uid');
        $id = $uid ? $uid : $this->input->get('id');
        if (empty($id)) exit('ID不能為空');
        $arr = $this->curl_get(ADMINAPI . 'level/member/update_show/' . $id . '?detail=1');
        $rs = json_decode($arr, true);
        $level = $this->curl_get(ADMINAPI . 'level/level/show_level');
        $level = json_decode($level, true);
        $data['level'] = $level['data']['rows'];
        $data['rs'] = $rs['data'];
        $data['rs']['pwd']='******';
        $data['rs']['id'] = $id;
        // 銀行卡信息
        $platform = json_decode($this->curl_get(ADMINAPI . 'level/bank/bank_list', array('type' => 1)), true);
        $data['platform'] = $platform['data']['bank'];
        $this->load->view('member/editagent', $data);

    }

    public function agent_user_list()
    {

        $data['uid'] = $this->input->get('id');
        $this->load->view('member/agent_user_list', $data);
    }

    public function get_agent_user_list()
    {

        $data = array_merge($_GET,$_POST);
        $arr = json_decode($this->curl_get(ADMINAPI . 'agent/get_agent_user', $data), true);
        echo json_encode($arr['data']);
    }


    //保存代理
    public function save_agent()
    {
        if ($_POST['bank_pwd'] == '******') {
            unset($_POST['bank_pwd']);
        } else if($_POST['bank_pwd'] == ''){
            $_POST['bank_pwd'] = null;
        }else{
            $patten = '/^\d{6}$/';
            if(!preg_match($patten,$_POST['bank_pwd'])){
                exit($this->status('ERROR', '資金密碼必須為6位純數字'));
            }else{
                $_POST['bank_pwd'] = md5($_POST['bank_pwd']);
            }
        }

        if ($_POST['pwd'] == '******') {
            unset($_POST['pwd']);
        } else if($_POST['pwd'] == ''){
            $_POST['pwd'] = null;
        }else{
            if (empty($_POST['pwd'])) {
                exit($this->status('ERROR', '密碼不能為空'));
            }

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

            $_POST['pwd'] = md5($_POST['pwd']);
        }
        $arr = $this->curl_post(ADMINAPI . 'level/member/update_agent', $_POST);
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /*****************等級設置************************/
    public function grade_mechanism(){
        $this->load->view('member/grade_mechanism');
    }
    public function get_grade_list(){
        $rs = $this->curl_get(ADMINAPI.'grade_mechanism/all', $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    /*****************晉級詳情************************/
    public function promotion_detail(){
        $this->load->view('member/promotion_detail');
    }
    public function get_promotion_list(){
        $rs = $this->curl_get(ADMINAPI.'promotion_detail/all', $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }
    public function sum_user(){
        $id = $this->input->post('id');
        $arr = $this->curl_get(ADMINAPI . 'Grade_mechanism/user_count', array('vipId'=>$id));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }

    }
    /*****************视讯额度转换start************************/
    public function sx_transfer()
    {
        $data['sx_list'] = [
            ['name' => 'AG视讯', 'id' => 1001,'style'=>"<span class='agBalance'>0</span>"],
            ['name' => 'DG视讯', 'id' => 1002,'style'=>"<span class='dgBalance'>0</span>"],
            ['name' => '开元棋牌', 'id' => 1006,'style'=>"<span class='kyBalance'>0</span>"],
        ];
        $this->load->view('member/sx_transfer', $data);
    }
    public function get_sx_user()
    {
        $username = $this->input->post('username');
        $arr = $this->curl_get(SXAPI . 'sx/shixun/get_user_sx_credit', array('username'=>$username));
        $rs = json_decode($arr, true);
        if($rs['code'] == 200){
            echo json_encode($rs,true);
        }else{
            $rs['code']=422;
            echo json_encode($rs,true);
        }
    }
    public function get_transfer_in(){
        //$uid=$_POST['uid'];
        switch ($_POST['sx_id']){
            case  1001:
                $url = SXAPI . 'sx/ag/user/transfer';
                break;
            case  1002:
                $url = SXAPI . 'sx/dg/user/transfer';
                break;
            case  1006:
                $url = SXAPI . 'sx/ky/user/transfer';
                break;
            default :
                $url = SXAPI . 'sx/ag/user/transfer';
        }
        $data = array(
            'uid' => $_POST['uid'],
            'data' =>json_encode(array(
                    'credit'=>$_POST['credit'],
                    'type'=>$_POST['type'])
            )
        );
        $arr = $this->curl_post($url,  $data);
        $arr = json_decode($arr, true);
        echo json_encode($arr,true);
    }
    public function get_all_transfer_in(){
        //$uid=$_POST['uid'];
        switch ($_POST['sx_id']){
            case  1001:
                $url = SXAPI . 'sx/ag/user/all_transfer';
                break;
            case  1002:
                $url = SXAPI . 'sx/dg/user/all_transfer';
                break;
            case  1006:
                $url = SXAPI . 'sx/ky/user/all_transfer';
                break;
            default :
                $url = SXAPI . 'sx/ag/user/all_transfer';
        }
        $data = array(
            'uid' => $_POST['uid'],
            'data' =>json_encode(array(
                    'type'=>$_POST['type'])
            )
        );
        $arr = $this->curl_post($url,  $data);
        $arr = json_decode($arr, true);
        //var_dump($data);exit();
        echo json_encode($arr,true);
    }
    /*****************视讯额度转换end************************/
}