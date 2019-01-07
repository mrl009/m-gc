<?php 
/**
 * 二維碼入款  控制權
 * User: lqh6249
 * Date: 1970/01/01
 * Time: 00:01
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
//引用公用文件
include_once  __DIR__.'/Base.php';

class Qrcode extends Base
{
    function __construct()
    {
        parent::__construct();
    }

    //入款二維碼設定
    public function qrcode_set()
    {
        $data['auth'] = [];
        $auth = input('param.auth');
        if (!empty($auth)) $data['auth'] = explode(',',$auth);
        $this->load->view('payset/qrcode_set', $data);
    }

    //獲取二維碼賬戶列表
    public function get_qrcode_list()
    {
        //獲取參數
        $parms = input("param.");
        //構造接口數據
        $url = ADMINAPI. 'level/qrcode/get_qrcode_list';
        $data = $this->get_index_data($url,$parms);
    }

    //二維碼存款記錄列表
    public function qrcode_deposit_list()
    {
        $this->load->view('payset/qrcode_deposit_list');
    }


    //添加或修改二維碼入款賬戶
    public function qrcode_edit()
    {
        //獲取參數
        $parms = input("param.");
        $id = input("param.id",0,'intval'); 
        //獲取二維碼入款的數據支付類型
        $qr_url = ADMINAPI. 'level/qrcode/get_qrcode_type';
        $qrcode_type =  $this->get_index_data($qr_url,[],1);
        //編輯二維碼入款信息 獲取信息數據
        if (!empty($id))
        {
            $url = ADMINAPI. 'level/qrcode/get_qrcode_info';
            $data = $this->get_index_data($url,$parms,1);
            if (!empty($data['describe']))
            {
                $rs = json_decode($data['describe'],true);
            }
            $data['title'] = isset($rs['title']) ? $rs['title'] : '';
            $data['prompt'] = isset($rs['prompt']) ? $rs['prompt'] : '';
        }
        //合併二維碼類型數據   
        $data['platform'] = $qrcode_type;
        $this->load->view('payset/qrcode_edit', $data);
    }

    //保存二維碼入款賬戶
    public function qrcode_save()
    {
        //獲取參數
        $parms = input("param.");
        if (empty($parms['qrcode'])) $this->retMsg(-100,'請先上傳二維碼');
        //構造接口數據
        $url = ADMINAPI. 'level/qrcode/qrcode_save';
        $this->get_save_data($url,$parms);
    }

    //刪除二維碼入款賬戶
    public function qrcode_delete()
    {
        $parms = input("param.");
        $url = ADMINAPI . 'level/qrcode/qrcode_delete';
        $this->get_save_data($url,$parms);
    }
}
