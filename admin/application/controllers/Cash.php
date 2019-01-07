<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cash extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
        $this->load->library('session');
    }

    //载入公司入款列表
    public function index()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        //$arr = json_decode($this->curl_get(ADMINAPI . 'cash/in_company/get_banks', $_POST), true);
        //$data['bankcards'] = $arr['data']['rows'];
        if(!empty($_GET['skip'])) {
            $data['skip'] = 'skip='.$_GET['skip'].'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&f_username='.$_GET['f_username'].'&agent_id='.$_GET['agent_id'].'&status=2';
        }
        // 层级
        $arr = json_decode($this->curl_get(ADMINAPI . 'level/level/show_level', $_POST), true);
        $data['level'] = $arr['data']['rows'];
        $this->load->view('cash/deposit/list', $data);
    }

    //线上入款
    public function income()
    {   
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/in_online/get_banks', $_POST), true);
        $data['banks'] = $arr['data']['rows'];
        //直通车数据
        $data['fasts'] = [];
        $arr = json_decode($this->curl_get(ADMINAPI . 'pay/fast/get_fasts', $_POST), true);
        if (!empty($arr['data'])) $data['fasts'] = $arr['data'];
        if(!empty($_GET['skip'])) {
            $data['skip'] = 'skip='.$_GET['skip'].'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&f_username='.$_GET['f_username'].'&status=2'.'&agent_id='.$_GET['agent_id'];
        }
        // 层级
        $arr = json_decode($this->curl_get(ADMINAPI . 'level/level/show_level', $_POST), true);
        $data['level'] = $arr['data']['rows'];
        $this->load->view('cash/income/list', $data);
    }

    //彩豆入款
    public function coupon()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));

        $dataCurl = $this->curl_get(ADMINAPI . 'cash/in_card/index', $_POST);
        $arr = json_decode($dataCurl, true);

        $data['level'] = $arr['data']['top4list'];
        $this->load->view('cash/coupon/list', $data);
    }

    public function payment()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        // 层级信息
        $arr = json_decode($this->curl_get(ADMINAPI . 'level/level/level_base'), true);
        $data['level'] = $arr['data']['rows'];
        if(!empty($_GET['skip'])) {
            $data['skip'] = 'skip='.$_GET['skip'].'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&f_username='.$_GET['f_username'].'&status=2&sort=actual_price&order=desc'.'&agent_id='.$_GET['agent_id'];
            if (!empty($_GET['impounded'])) {
                $data['skip'] .= '&impounded=1';
            }
        }
        $this->load->view('cash/payment/list', $data);
    }

    public function payment_auto()
    {
        // 获取自动出款设置
        $set = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_set'),true);
        $data['is_auto_out'] = isset($set['data']['is_auto_out']) ? $set['data']['is_auto_out'] : 0;
        if ($data['is_auto_out'] == 0) {
            exit('<script>Core.error("該功能未開啓或正在維護中!");</script>');
        }
        if (strtolower($this->session->userdata('admin_name')) !== 'syszdchukuan') {
            exit('<script>Core.error("非自動出款管理員!");</script>');
        }
        $data['auth'] = explode(',', $this->input->get('auth'));
        //.获取自动出款第三方列表
        $apay_channels = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_apay_channel_list'), true);
        $data['apay_channels'] = $apay_channels['data'];
        if (empty($data['apay_channels'])) {
            exit('<script>Core.error("無可用代付通道!");</script>');
        }
        $this->load->view('cash/payment/auto_list', $data);
    }

    // 修改出款订单（未处理和预备出款才能修改）
    public function edit_payment()
    {
        /*$id = $this->input->get('id');
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/out_manage/get_list?id='. $id), true);
        $data = $arr['data']['rows'][0];
        $this->load->view('cash/payment/edit_payment', [ 'id' => $id, $data ] );*/
        $this->load->view('cash/payment/edit_payment', $_GET);
    }

    // 保存出款订单修改
    public function save_payment()
    {
        $rs = json_decode($this->curl_post(ADMINAPI. 'cash/out_manage/chang_order',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','执行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }

    public function payment_cancel()
    {
        //.获取当前出款id
        $data =[];
        if(isset($_GET['id'])){
            $data['id'] = intval(htmlspecialchars($_GET['id']));
        }
        if(isset($_GET['status'])){
            $data['status'] = intval(htmlspecialchars($_GET['status']));
        }
        if(isset($_GET['people_remark'])){
            $data['people_remark'] = $_GET['people_remark'];
        }
        $this->load->view('cash/payment/payment_cancel',$data);
    }

    public function ring_setting()
    {
        $this->load->view('cash/payment/ring_setting');
    }

    //获取彩豆入款
    public function getlist()
    {
        $data = $this->curl_get(ADMINAPI . 'cash/in_card/index', $_POST);
        if($data===null){
            $arr = 'post請求結果為空';
            echo json_encode($arr);
        }else{
            //echo $data;exit;
            $arr = json_decode($data, true);
            echo json_encode($arr['data']);
        }

    }

    //公司入款
    public function get_deposit_list()
    {
        foreach ($_GET as $key => $value) {
            if (empty($_POST[$key])) {
                $_POST[$key] = $value;
            }
        }
        $data = $this->curl_get(ADMINAPI . 'cash/in_company/get_list', $_POST);
        $arr = json_decode($data, true);
        $arr['data']['footer']['total'] = count($arr['data']['rows']);
        $arr['data']['footer'] = [$arr['data']['footer']];
        echo json_encode($arr['data']);
    }

    //ajax公司入款按钮功能
    public function ajax_deposit_operation()
    {
        $_POST['status'] = intval(htmlspecialchars($_REQUEST['status']));
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));

        $data = $this->curl_post(ADMINAPI . 'cash/in_company/in_company_do?token='.$this->session->userdata('token'), $_POST);
        echo $data;

    }

    //ajax公司入款撤消订单取消
    public function ajax_deposit_revoke()
    {
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));
        $data = $this->curl_post(ADMINAPI . 'cash/in_company/bank_revoke', $_POST);
        echo $data;

    }

    //显示优惠券设置表单
    public function coupon_edit()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('cash/coupon/edit', $data);
    }

    //ajax请求优惠券设置表单
    public function ajax_coupon_edit()
    {
        $_POST['ip_cishu'] = intval(htmlspecialchars($_REQUEST['ip_cishu']));
        $_POST['user_card_cishu'] = intval(htmlspecialchars($_REQUEST['user_card_cishu']));

        $data = $this->curl_post(ADMINAPI . 'cash/in_card/set_all', $_POST);

        $arr = json_decode($data, true);

        if($arr['code'] == 200){
            $arr['status'] = 'OK';
        }

        echo json_encode($arr);
    }

    //ajax请求优惠券封印解封ip
    public function ajax_op_ip()
    {
        $data['ip_status'] = intval(htmlspecialchars($_REQUEST['ip_status']));
        $data['uid'] = intval(htmlspecialchars($_REQUEST['uid']));
        $data = $this->curl_post(ADMINAPI . 'cash/in_card/set_one', $data);
        $arr = json_decode($data, true);
        echo json_encode($arr);

    }

    //ajax请求优惠券封印解封user
    public function ajax_op_user()
    {
        $_POST['is_card'] = intval(htmlspecialchars($_REQUEST['is_card']));
        $_POST['uid'] = intval(htmlspecialchars($_REQUEST['uid']));

        $data = $this->curl_post(ADMINAPI . 'cash/in_card/set_one', $_POST);

        $arr = json_decode($data, true);
        echo json_encode($arr);

    }

    //现金系统-存取款
    public function deposit_withdraw_money()
    {
        $data = array();
        if(!empty($_GET['skip'])) {
            $data['skip'] = '&skip='.$_GET['skip'].'&time_start='.$_GET['time_start'].'&time_end='.$_GET['time_end'].'&username='.$_GET['f_username'].'&big_type='.$_GET['big_type'].'&sort=price&order=desc'.'&agent_id='.$_GET['agent_id'];
        }
        $data['big_type'] = $_GET['big_type'];
        $this->load->view('cash/deposit_withdraw_money', $data);
    }

    //现金系统-查询
    public function ajax_search_user()
    {
        $data['username'] = htmlspecialchars($_REQUEST['username']);
        $data = $this->curl_post(ADMINAPI . 'cash/Cash_people/get_user', $data);
        $arr = json_decode($data, true);
        echo json_encode($arr);
    }

    public function ajax_get_level_list()
    {

        $data = [];
        $data = $this->curl_get(ADMINAPI . 'cash/Cash_people/get_level_list', $data);

        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    //现金系统-存款
    public function ajax_deposit_money()
    {
        //判断是单项操作还是批量操作
        $mult_flag = $_REQUEST['mult_flag'];

        if ($mult_flag) {
            $mult_select_dep_flag = $_REQUEST['mult_select_dep_flag'];
            if ($mult_select_dep_flag == 1) {
                $data['username'] = $_REQUEST['mult_username'];
            } else if ($mult_select_dep_flag == 2) {
                $data['level_id'] = (int)$_REQUEST['level_id'];
            }
        } else {
            $data['uid'] = $_REQUEST['uid'];
        }


        $data['price'] = htmlspecialchars($_REQUEST['price']);
        $data['discount_price'] = htmlspecialchars($_REQUEST['discount_price']);
        $data['auth_multiple'] = htmlspecialchars($_REQUEST['auth_multiple']);
        $data['type'] = intval(htmlspecialchars($_REQUEST['type']));
        $data['auth_dml'] = htmlspecialchars($_REQUEST['sum_check_num']);
        $data['remark'] = htmlspecialchars($_REQUEST['remark']);
        $data = $this->curl_post(ADMINAPI . 'cash/Cash_people/cash_in_people', $data);
        echo $data;
    }

    //现金系统-取款
    public function ajax_withdraw_money()
    {
        /*if (isset($_REQUEST['uid']) && ($_REQUEST['uid'] != null)) {
            $data['uid'] = $_REQUEST['uid'];
        }*/
        $data['uuid'] = $_REQUEST['uuid'];
        $data['price'] = round((htmlspecialchars($_REQUEST['price'])), 2);
        $data['remark'] = htmlspecialchars($_REQUEST['remark']);
        $data['type'] = intval(htmlspecialchars($_REQUEST['type']));
        $data['balance'] = round(htmlspecialchars($_REQUEST['balance']),2);
        $data = $this->curl_post(ADMINAPI . 'cash/Cash_people/cash_out_people', $data);
        echo $data;
    }

    //获取存取款历史记录列表
    public function get_deposit_withdraw_money_list()
    {
        foreach ($_GET as $key => $value) {
            if (empty($_POST[$key])) {
                $_POST[$key] = $value;
            }
        }
        $data = $this->curl_get(ADMINAPI . 'cash/Cash_people/history', $_POST);

        $arr = json_decode($data, true);

        $arr['data']['footer'][0]['type_name'] = '小计：';
        $arr['data']['footer'][0]['price'] = $arr['data']['price_count'];
        $arr['data']['footer'][0]['discount_price'] = $arr['data']['youhui_count'];
        $arr['data']['footer'][1]['type_name'] = '总计：';
        $arr['data']['footer'][1]['price'] = $arr['data']['price_all_count'];
        $arr['data']['footer'][1]['discount_price'] = $arr['data']['youhui_all_count'];

        echo json_encode($arr['data']);
    }

    //获取出款管理列表
    public function get_payment_list()
    {
        foreach ($_GET as $key => $value) {
            if (empty($_POST[$key])) {
                $_POST[$key] = $value;
            }
        }
        $data = $this->curl_get(ADMINAPI . 'cash/out_manage/get_list', $_POST);
        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    //获取自动出款管理列表
    public function get_auto_payment_list()
    {
        $params = $_POST;
        if (!isset($_POST['apay_channel'])) {
            exit(json_encode(['rows'=>[],'total'=>0]));
        }
        unset($params['apay_channel'],$params['cool_time']);
        $data = $this->curl_post(ADMINAPI . 'cash/out_manage/get_pre_auto_out_list', $params);
        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    //获取出款管理列表
    public function ajax_company_do()
    {
        $_POST['status'] = intval(htmlspecialchars($_REQUEST['status']));
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));
        if (isset($_REQUEST['remark'])) {
            $_POST['remark'] = htmlspecialchars($_REQUEST['remark']);
        }

        $data = $this->curl_post(ADMINAPI . 'cash/out_manage/out_handle?token='.$this->session->userdata('token'), $_POST);
        echo $data;
    }

    // 自动出款发起代付
    public function ajax_auto_doapay()
    {
        $order_num = $this->input->post('order_num');
        $doapay_api = $this->input->post('doapay_api');

        $data = $this->curl_get(ADMINAPI . $doapay_api.'/'.$order_num);
        echo $data;
    }

    // 自动出款发起代付
    public function ajax_auto_doquery()
    {
        $order_num = $this->input->post('order_num');
        $doquery_api = $this->input->post('doquery_api');

        $data = $this->curl_get(ADMINAPI . $doquery_api.'/'.$order_num);
        echo $data;
    }

    // 自动出款解除锁定
    public function ajax_unlock_apay()
    {
        $order_num = $_POST['order_num'];
        if (strtolower($this->session->userdata('admin_name')) !== 'syszdchukuan') {
            $this->status('ERROR','非自動出款管理員');
        }
        $data = $this->curl_post(ADMINAPI . 'cash/out_manage/unlock_apay_order',['order_num'=>$order_num]);
        echo $data;

    }

    //出款管理人工备注
    public function ajax_remark_do()
    {
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));
        if (isset($_REQUEST['remark'])) {
            $_POST['remark'] = htmlspecialchars($_REQUEST['remark']);
        }

        $data = $this->curl_post(ADMINAPI . 'cash/out_manage/remark_handle?token='.$this->session->userdata('token'), $_POST);
        echo $data;
    }

    //公司出款人工备注
    public function ajax_deposit_remark_do()
    {
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));
        if (isset($_REQUEST['remark'])) {
            $_POST['remark'] = htmlspecialchars($_REQUEST['remark']);
        }

        $data = $this->curl_post(ADMINAPI . 'cash/in_company/remark_company_do?token='.$this->session->userdata('token'), $_POST);
        echo $data;
    }

    //验证是否是同一个管理员
    public function ajax_admin_match_do()
    {
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));
        $data = $this->curl_post(ADMINAPI . 'cash/out_manage/match_handle?token='.$this->session->userdata('token'), $_POST);
        echo $data;
    }

    //出入汇总
    public function amount_summary()
    {
        $data = array();
        $this->load->view('cash/amount_summary', $data);
    }

    //获取出入款汇总列表
    public function get_amount_summary_list()
    {
        $data = $this->curl_get(ADMINAPI . 'cash/report/get_list', $_POST);
        $arr = json_decode($data, true);
        $row[0]['in'] = '公司入款';
        $row[0]['in_money'] = $arr['data']['in_company_total'] . '('
            . $arr['data']['in_company_num'] . ')筆(' . $arr['data']['in_company_peo'] . ')人';
        $row[0]['out'] = '會員出款';
        $row[0]['out_detail'] = $arr['data']['out_company_total'] . '('
            . $arr['data']['out_company_num'] . ')筆(' . $arr['data']['out_company_peo'] . ')人';

        $row[1]['in'] = '線上支付';
        $row[1]['in_money'] = $arr['data']['in_online_total'] . '('
            . $arr['data']['in_online_num'] . ')筆(' . $arr['data']['in_online_peo'] . ')人';
        $row[1]['out'] = '給於優惠';
        $row[1]['out_detail'] = $arr['data']['out_discount_total'] . '('
            . $arr['data']['out_discount_num'] . ')筆(' . $arr['data']['out_discount_peo'] . ')人';

        $row[2]['in'] = '人工存入';
        $row[2]['in_money'] = $arr['data']['in_people_total'] . '('
            . $arr['data']['in_people_num'] . ')筆(' . $arr['data']['in_people_peo'] . ')人';
        $row[2]['out'] = '人工提出';
        $row[2]['out_detail'] = $arr['data']['out_people_total'] . '('
            . $arr['data']['out_people_num'] . ')筆(' . $arr['data']['out_people_peo'] . ')人';

        $row[3]['in'] = '會員出款被扣金額';
        $row[3]['in_money'] = $arr['data']['in_member_out_deduction'] . '('
            . $arr['data']['in_member_out_num'] . ')筆(' . $arr['data']['in_member_out_peo'] . ')人';
        $row[3]['out'] = '給予反水';
        $row[3]['out_detail'] = $arr['data']['out_return_water'] . '('
            . $arr['data']['out_return_num'] . ')筆(' . $arr['data']['out_return_peo'] . ')人';

        $arr['data']['rows'] = $row;
        $arr['data']['footer']=array(array('in'=>'賬目總額','in_money'=>$arr['data']['total_price'],'out'=>'平臺實際盈虧','out_detail'=>$arr['data']['win_lose']));
        $arr['data']['total'] = 4;

        echo json_encode($arr['data']);
    }

    //现金流水
    public function cash_system()
    {
        $data = array();
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/cash_list/get_list'), true);
        $data['level'] = $arr['data']['types'];
        $this->load->view('cash/cash_system', $data);
    }

    public function get_cash_list()
    {
        $_POST['uid'] = $_GET['uid'];
        $data = $this->curl_get(ADMINAPI . 'cash/cash_list/get_list', $_POST);

        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    //获得稽核日志列表
    public function get_audit_log()
    {
        $data = $this->curl_get(ADMINAPI . 'auth/index/index', $_POST);

        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    public function audit_list()
    {
        $data['type'] = $this->uri->segment(3);
        $data['auth'] = explode(',', $this->input->get('auth'));

        $this->load->view('cash/audit/list', $data);
    }

    public function get_audit_list()
    {

        if ($_POST['username'] != null) {

            $data = $this->curl_get(ADMINAPI . 'auth/index/auth', $_POST);
            $arr = json_decode($data, true);
            echo json_encode($arr['data']);
        }else{
            $result['rows'] = [];
            $result['total']  = 0;
            echo json_encode($result);
        }
    }

    //会员额度统计
    public function balance()
    {
        $data = array();

        $this->load->view('cash/balance', $data);
    }

    //获取会员额度统计列表
    public function get_balance_list()
    {
        $data = $this->curl_get(ADMINAPI . 'level/Member/member_cash', $_POST);

        $arr = json_decode($data, true);
        $arr['data']['rows']['balance'] = '系统额度';
        $arr['data']['rows'] = [$arr['data']['rows']];
        $arr['data']['total'] = 1;
        echo json_encode($arr['data']);
    }

    //会员额度统计刷新
    public function ajax_balance()
    {
        $data = $this->curl_post(ADMINAPI . 'level/Member/member_cash', $_POST);
        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    //稽查日志
    public function audit_log()
    {
        $data = array();

        $this->load->view('cash/audit/audit_log', $data);
    }

    /**
     * @php 快速直通车支付通道新加方法
     * lqh  2018/12/31
     */
    public function get_income_list_new()
    {
        if (!empty($_GET))
        {
            foreach ($_GET as $key => $val) 
            {
                if (empty($_POST[$key])) 
                {
                    $_POST[$key] = $val;
                }
            }
        }
        $url = ADMINAPI . 'cash/in_online/get_list';
        $data = $this->curl_get($url,$_POST);
        if (!empty($data)) $arr = json_decode($data, true);
        if (!empty($arr['data']['rows'])) 
        {
            $count = count($arr['data']['rows']);
        }
        $arr['data']['footer']['total'] = isset($count) ? $count : 0;
        $arr['data']['footer'] = [$arr['data']['footer']];
        echo json_encode($arr['data']);
    }

    //获取线上入款
    public function get_income_list()
    {
        foreach ($_GET as $key => $value) {
            if (empty($_POST[$key])) {
                $_POST[$key] = $value;
            }
        }
        $data = $this->curl_get(ADMINAPI . 'cash/in_online/get_list', $_POST);

        $arr = json_decode($data, true);
        $arr['data']['footer']['total'] = count($arr['data']['rows']);
        $arr['data']['footer'] = [$arr['data']['footer']];

        echo json_encode($arr['data']);

    }

    //获取线上入款
    public function ajax_income_ignore()
    {
        $data = $this->curl_post(ADMINAPI . 'cash/in_online/ignore', $_POST);
        echo $data;

    }

    //获取线上入款
    public function ajax_income_confirm()
    {
        $data = $this->curl_post(ADMINAPI . 'cash/in_online/online_doing', $_POST);
        echo $data;
    }

    //保存会员列表
    public function save()
    {
        $id = $this->input->post('id');
        $row['gg_sort_order'] = $this->input->post('gg_sort_order');
        if ($this->user->save($id, $row) && $this->admin_sh->add($sh)) {
            echo '{"status":"OK","msg":"執行成功"}';
        } else {
            echo '{"status":"ERROR","msg":"執行失敗"}';
        }
    }

    public function export()
    {
        $title = '订单报表';
        $fields = array(
            'xz' => '订单号',
            'kithe' => '层级/代理商',
            'upline' => '会员帐号',
            'order_sn' => '存款人与时间',
            'username' => '存入金额与优惠',
            'type' => '存入总额与备注',
            'content' => '存入银行帐户',
            'money' => '状态',
            'rebate' => '首存',
            'lucky_price' => '操纵者',
            'result' => '时间',
        );
        $data = array(
            array('xz' => '201702200506245398', 'kithe' => '未分层<br>tex_default_dl', 'upline' => 'hz180',
                'order_sn' => '存款人:刘飞<br>時間:2017-02-20 17:06:20',
                'username' => '存入金額：10000.00<br>存款/其他優惠：100.00/50.00<br>银行：中国银行<br>方式：網銀轉帳',
                'type' => '存入总额：10150.00<br>备注：',
                'content' => '卡主：怡宝【6225881275848776】<br>銀行：中国银行',
                'money' => '已确认', 'rebate' => '是', 'lucky_price' => 'admin', 'result' => '2017-02-20 00:41:04'),
            array('xz' => '201702200506245398', 'kithe' => '未分层<br>tex_default_dl', 'upline' => 'hz180',
                'order_sn' => '存款人:刘飞<br>時間:2017-02-20 17:06:20',
                'username' => '存入金額：10000.00<br>存款/其他優惠：100.00/50.00<br>银行：中国银行<br>方式：網銀轉帳',
                'type' => '存入总额：10150.00<br>备注：',
                'content' => '卡主：怡宝【6225881275848776】<br>銀行：中国银行',
                'money' => '已确认', 'rebate' => '是', 'lucky_price' => 'admin', 'result' => '2017-02-20 00:41:04'),
            array('xz' => '201702200506245398', 'kithe' => '未分层<br>tex_default_dl', 'upline' => 'hz180',
                'order_sn' => '存款人:刘飞<br>時間:2017-02-20 17:06:20',
                'username' => '存入金額：10000.00<br>存款/其他優惠：100.00/50.00<br>银行：中国银行<br>方式：網銀轉帳',
                'type' => '存入总额：10150.00<br>备注：',
                'content' => '卡主：怡宝【6225881275848776】<br>銀行：中国银行',
                'money' => '已确认', 'rebate' => '是', 'lucky_price' => 'admin', 'result' => '2017-02-20 00:41:04'),
        );
        $this->user->export('公司入款报表', array(array('name' => '公司入款报表', 'data' => $data, 'fields' => $fields)));
    }

    public function search_agent(){
        $arr['from_id'] = $_GET['id'];
        $this->load->view('cash/agent/search_agent', $arr);
    }

    public function get_search_agent_list(){
        $arr = json_decode($this->curl_get(ADMINAPI . '/level/member/agent_name', $_POST), true);
        echo json_encode($arr['data']);
    }

    public function get_base_info()
    {
        $data = $_GET;
        if (empty($data['id']) || empty($data['uid'])) exit('ID不能為空');
        $arr = $this->curl_get(ADMINAPI . 'level/member/update_show/' . $data['uid'] . '?detail=1');
        $rs = json_decode($arr, true);
        $data['rs'] = $rs['data'];
        // 银行卡信息
        $platform = json_decode($this->curl_get(ADMINAPI . 'level/bank/bank_list', array('type' => 1)), true);
        $data['bank'] = '';
        foreach ($platform['data']['bank'] as $v) {
            if ($v['id'] == $data['rs']['bank_id']) {
               $data['bank'] = $v['bank_name'];
            }
        }
        $this->load->view('cash/base_info', $data);
    }

    // 今日出入款明细
    public function withdraw_and_top_up()
    {
        $data = array();
        $params = array(
            'time_start' => date('Y-m-d', time()),
            'time_end' => date('Y-m-d', time()),
            'status' => 1
        );
        // 公司入款
        $rs = json_decode($this->curl_get(ADMINAPI . 'cash/in_company/get_list', $params), true);
        $data['deposit_list'] = isset($rs['data']['rows']) ? $rs['data']['rows'] : [];
        // 线上入款
        $rs = json_decode($this->curl_get(ADMINAPI . 'cash/in_online/get_list', $params), true);
        $data['income_list'] = isset($rs['data']['rows']) ? $rs['data']['rows'] : [];
        // 出款管理
        $rs = json_decode($this->curl_get(ADMINAPI . 'cash/out_manage/get_list', $params), true);
        $data['payment_list'] = isset($rs['data']['rows']) ? $rs['data']['rows'] : [];
        $this->load->view('cash/withdraw_and_top_up', $data);
    }

    // 公司入款核对
    public function company_top_up_check()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $set = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        $data['limit_time'] = $set['data']['income_time'];
        $this->load->view('cash/check/list', $data);
    }

    public function search_bank_card()
    {
        $arr = json_decode($this->curl_get(ADMINAPI . 'cash/in_company/get_banks', $_POST), true);
        array_shift($arr['data']['rows']);
        $data = [
            'num'       => round(count($arr['data']['rows'])/2),
            'form_id'   => $this->input->get('form_id'),
            'bank_card' => $arr['data']['rows']
        ];
        $this->load->view('cash/deposit/search_bank_card', $data);
    }

    // 公司入款银行数据
    public function get_auto_list()
    {
        $data = $this->curl_post(ADMINAPI . 'cash/in_company/get_autolist', $_POST);
        $arr = json_decode($data, true);
        echo json_encode($arr['data']);
    }

    public function get_auto_deposit_list()
    {
        $data = json_decode($this->curl_get(ADMINAPI . 'cash/in_company/get_list', $_REQUEST), true);
        echo json_encode($data['data']);
    }

    public function ajax_auto_confirm()
    {
        $_POST['status'] = intval(htmlspecialchars($_REQUEST['status']));
        $_POST['id'] = intval(htmlspecialchars($_REQUEST['id']));
        $data = $this->curl_post(ADMINAPI . 'cash/in_company/bank_sure?token='.$this->session->userdata('token'), $_POST);
        echo $data;
    }

    public function ajax_relate_auto_confirm()
    {
        $data = $this->curl_post(ADMINAPI . 'cash/in_company/compare_do?token='.$this->session->userdata('token'), $_POST);
        echo $data;
    }

}