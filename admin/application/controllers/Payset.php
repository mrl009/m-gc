<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payset extends MY_Controller
{
    private $assign = array();

    function __construct()
    {
        parent::__construct();
        $this->checklogin();
        $this->auth = explode(',', $this->input->get('auth'));
    }

    //支付设定
    public function index()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth']=$this->auth;
        $this->load->view('payset/list', $data);
    }

    //获取支付设定
    public function get_pay_types()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'pay/pay_set/pay_show',$_POST),true);
        echo json_encode($arr['data']);
    }

    public function del_pay_type()
    {
        $id = $this->input->post('id');
        $data = array(
            'code'  =>  '0',
            'msg'   =>  '刪除成功',
        );
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    //修改支付设定
    public function edit_pay_setting()
    {
        $data=array();
        $id = $this->input->get('id');
        if(!empty($id)){
            $arr = json_decode($this->curl_get(ADMINAPI.'pay/pay_set/pay_show/'. $id,$_POST),true);
            $data=$arr['data']['rows'][0]['pay_set_content'];
            $data['id'] = $arr['data']['rows'][0]['id'];
            $data['pay_name'] = $arr['data']['rows'][0]['pay_name'];
        }
        $this->load->view('payset/edit_pay_setting',$data);
    }

    public function edit_pay_setting_do()
    {
        $rs = json_decode($this->curl_post(ADMINAPI.'pay/pay_set/pay_add',$_POST),true);
         if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    public function delete_pay_setting()
    {
        $rs=json_decode($this->curl_post(ADMINAPI.'pay/pay_set/pay_del',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    public function bankset()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('payset/bankset', $data);
    }

    public function get_bank_list()
    {
        $arr = json_decode($this->curl_post(ADMINAPI.'level/bank/bank_card_show',$_POST),true);
        echo json_encode($arr['data']);
    }

    //编辑入款银行
    public function edit_bank()
    {
        $platform = json_decode($this->curl_get(ADMINAPI.'level/bank/bank_list', array('type' => 1)),true);
        $data['platform'] = $platform['data']['bank'];
        if(!empty($_GET['id'])){
            $arr = json_decode($this->curl_get(ADMINAPI.'level/bank/bank_card_show/'. $_GET['id'],$_POST),true);
            $data = array_merge($data, array_pop($arr));
            // 支付宝微信标题和描述
            $rs = json_decode($data['describe'], true);
            $data['title'] = $rs['title'];
            $data['prompt'] = $rs['prompt'];
        }
        $this->load->view('payset/edit_bank', $data);
    }

    // 新增修改入款银行
    public function save_bank(){
        $rs = json_decode($this->curl_post(ADMINAPI. 'level/bank/bank_card_add/'. $_POST['id'],$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    // 删除入款银行
    public function delete_bank(){
        $rs=json_decode($this->curl_post(ADMINAPI. 'level/bank/bank_card_del',$_POST),true);
        if($rs['code']== 200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    //修改支付信息
    public function edit_pay_info()
    {
        $platform = json_decode($this->curl_get(ADMINAPI.'level/bank/online_list'),true);
        $data['platform'] = $platform['data']['bank_online'];
        if(!empty($_GET['id'])){
            $arr = json_decode($this->curl_get(ADMINAPI.'level/bank/online_show/'. $_GET['id'],$_POST),true);
            $data = array_merge($data, array_pop($arr));
        }
        if (empty($data['pay_code'])) {
            $data['pay_code'] = explode(',', $data['platform'][0]['pay_code']);
        } else {
            $data['pay_code'] = explode(',', $data['pay_code']);
        }
        foreach ($data['pay_code'] as $v) {
            if ($v != 7) {
                $data['is_describe'] = true;
            }
        }
        if (empty($data['is_box'])) {
            $data['is_box'] = explode(',', $data['platform'][0]['is_box']);
        } else {
            $data['is_box'] = explode(',', $data['is_box']);
        }
        $this->load->view('payset/edit_pay_info', $data);
    }

    //修改自动出款
    public function edit_out_info()
    {
        $platform = json_decode($this->curl_get(ADMINAPI.'level/bank/out_list'),true);
        $data['platform'] = $platform['data']['out_online'];
        if(!empty($_GET['id'])){
            $arr = json_decode($this->curl_get(ADMINAPI.'level/bank/out_show/'. $_GET['id'],$_POST),true);
            $data = array_merge($data, array_pop($arr));
        }
        if (empty($data['is_box'])) {
            $data['is_box'] = explode(',', $data['platform'][0]['is_box']);
        } else {
            $data['is_box'] = explode(',', $data['is_box']);
        }
        $this->load->view('payset/edit_out_info', $data);
    }

    //银行存款记录
    public function list_bank_deposit()
    {
        $data['bankCard'] = $this->input->get('bankCard');
        $this->load->view('payset/list_bank_deposit',$data);
    }

    public function get_bank_deposit_list()
    {
        $_POST['status'] = 2;
        $_POST['bankCard'] = $_GET['bankCard'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/in_company/get_list', $_POST),true);
        $arr['data']['footer']['total'] = count($arr['data']['rows']);
        $arr['data']['footer'] = [$arr['data']['footer']];
        echo json_encode($arr['data']);
    }

    //线上支付设定列表
    public function online_pay_setting()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $platform = json_decode($this->curl_get(ADMINAPI.'level/bank/online_list'),true);
        $data['platform'] = $platform['data']['bank_online'];
        $this->load->view('payset/online_pay_setting', $data);
    }

    //自动出款设定列表
    public function out_pay_setting()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $platform = json_decode($this->curl_get(ADMINAPI.'level/bank/out_list'),true);
        $data['platform'] = $platform['data']['out_online'];
        $this->load->view('payset/out_pay_setting', $data);
    }

    //获取线上支付设定
    public function get_online_pay_setting()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'level/bank/online_show',$_POST),true);
        echo json_encode($arr['data']);
    }

    //获取自动出款设定
    public function get_out_pay_setting()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'level/bank/out_show',$_POST),true);
        echo json_encode($arr['data']);
    }

    //修改线上支付设定
    public function edit_online_pay_setting()
    {
        $rs = json_decode($this->curl_post(ADMINAPI.'level/bank/online_add',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }


    //修改自动出款设定
    public function edit_online_out_setting()
    {
        $rs = json_decode($this->curl_post(ADMINAPI.'level/bank/out_add',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    // 停用启用线上支付设定
    public function edit_online_pay_setting_status()
    {
        $rs=json_decode($this->curl_post(ADMINAPI.'level/bank/chang_status',array('id'=>$_POST['id'],'status'=>$_POST['status'], 'type' => 2)),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }


    // 停用启用第三方自动出款
    public function edit_online_out_setting_status()
    {
        $rs=json_decode($this->curl_post(ADMINAPI.'level/bank/chang_status',array('id'=>$_POST['id'],'status'=>$_POST['status'], 'type' => 3)),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    //删除线上支付设定
    public function del_online_pay_setting()
    {
        $rs=json_decode($this->curl_post(ADMINAPI. 'level/bank/bank_online_del',$_POST),true);
        if($rs['status']=='OK'){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }


    //删除自动出款设置
    public function del_online_out_setting()
    {
        $rs=json_decode($this->curl_post(ADMINAPI. 'level/bank/out_del',$_POST),true);
        if($rs['status']=='OK'){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    public function online_pay_list()
    {
        $data['payId'] = $this->input->get('payId');
        $this->load->view('payset/online_pay_list', $data);
    }

    //.自动出款记录
    public function online_out_list()
    {
        $data['outId'] = $this->input->get('payId');
        $this->load->view('payset/online_out_list', $data);
    }

    //获取线上支付付款记录
    public function get_online_pay_list()
    {
        $_POST['status'] = 2;
        $_POST['payId'] = $_GET['payId'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/in_online/get_list', $_POST),true);
        $arr['data']['footer']['total'] = count($arr['data']['rows']);
        $arr['data']['footer'] = [$arr['data']['footer']];
        echo json_encode($arr['data']);
    }

    //获取线上自动出款记录
    public function get_online_out_list()
    {
        $_POST['status'] = 2;
        $_POST['outId'] = $_GET['outId'];
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/out_manage/get_auto_list', $_POST),true);
        $arr['data']['footer'] = [$arr['data']['footer'][0]];
        echo json_encode($arr['data']);
    }
}
