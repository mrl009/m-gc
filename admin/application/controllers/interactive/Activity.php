<?php 
/**
 * 活动大厅 (大厅设置) 
 * User: lqh6249
 * Date: 1970/01/01
 * Time: 00:01
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
//引用公用文件
include_once  __DIR__.'/Base.php';

class Activity extends Base
{
    function __construct()
    {
        parent::__construct();
    }

    //大厅设置
    public function site()
    {
        //获取大厅开启状态和全局禁言设置
        $url = ADMINAPI.'interactive/activity/get_hddt_set';
        $data = $this->get_index_data($url,$parms,1);
        //获取软件接口CODE值
        $code_url = ADMINAPI.'interactive/activity/get_plan_code';
        $code = $this->get_index_data($code_url,$parms,1);
        //软件计划地址
        $send_code = isset($code['code']) ? $code['code'] : '';
        $code['plan_url'] = 'http://gcapi.com/interactive/chat/send_plan?code='.$send_code;
        $data = array_merge($data,$code);
        $this->load->view('interactive/activity/site', $data);
    }

    //开启/禁用 互动大厅 全局禁言
    public function save_set()
    {
        $parms = input("param.");
        $url = ADMINAPI.'interactive/activity/save_set';
        $this->get_save_data($url,$parms);
    }

    //跟新软件技术code值
    public function get_plan_code(){
        $data = [];
        $parms = input("param.");
        $url = ADMINAPI.'interactive/activity/get_plan_code';
        $this->get_index_data($url,$parms);
    }
}