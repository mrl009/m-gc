<?php 
/**
 * 代付直通車  
 * User: lqh6249
 * Date: 1970/01/01
 * Time: 00:01
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
//引用公用文件
include_once  __DIR__.'/Base.php';

class Fast extends Base
{
    function __construct()
    {
        parent::__construct();
    }

    //數據列表
    public function setting()
    {
        $auth = input('param.auth'); 
        $data['auth'] = !empty($auth) ? explode(',', $auth) : '';
        $this->load->view('payset/fast/fast_list', $data);
    }

    //獲取數據
    public function get_fast_list()
    {
        $parms = input('param.');
        $url = ADMINAPI . 'pay/fast/get_fast_list';
        $this->get_index_data($url,$parms);
    }

    //新增接入方平臺
    public function fast_edit()
    {
        $data = '';
        $id = input('param.id',1,'intval');
        //編輯信息,獲取信息
        if (!empty($id))
        {
           $parms = input('param.');
           $url = ADMINAPI . 'pay/fast/get_fast_info';
           $data = $this->get_index_data($url,$parms,1); 
        } 
        $this->load->view('payset/fast/fast_edit', $data);
    }

    public function update_status()
    {
        $parms = input('param.');
        $status = input('param.status',0,'intval');
        //開啟裝狀態下 點擊為關閉 或者為開啟
        $parms['status'] = (1 == $status) ? 2 : 1; 
        $url = ADMINAPI . 'pay/fast/fast_save';
        $this->get_save_data($url,$parms);
    }

    //保存接入平台信息
    public function fast_save()
    {
        $parms = input('param.');
        //保存接入平台信息接口地址
        $url = ADMINAPI . 'pay/fast/fast_save';
        $this->get_save_data($url,$parms);
    }
    
    //刪除接入平台信息
    public function fast_delete()
    {
        $parms = input('param.');
        $url = ADMINAPI . 'pay/fast/fast_delete';
        $this->get_save_data($url,$parms);
    }
}
