<?php 
/**
 * vip权限设置 
 * User: lqh6249
 * Date: 1970/01/01
 * Time: 00:01
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
//引用公用文件
include_once  __DIR__.'/Base.php';

class Vip extends Base
{
    function __construct()
    {
        parent::__construct();
    }

    //vip权限列表
    public function access_list()
    {
        $auth = input('param.auth'); 
        $data['auth'] = !empty($auth) ? explode(',', $auth) : '';
        $this->load->view('interactive/vip/access_list', $data);
    }

    //获取Vip权限信息数据
    public function get_access_list()
    {
        //获取聊天记录数据接口
        $url = ADMINAPI . 'interactive/vip/get_access_list';
        $this->get_index_data($url);
    }

    //编辑Vip权限
    public function access_edit()
    {
        $parms = input("param.");
        if (empty($parms['id'])) $this->status('ERROR', '缺少参数');
        //获取基本信息
        $url = ADMINAPI . 'interactive/vip/get_access_info';
        $data = $this->get_index_data($url,$parms,1);
        $this->load->view('interactive/vip/access_edit', $data);
    }

    //保存Vip权限
    public function access_save()
    {
        $parms = input("param.");
        $record_num = input("param.record_num",0,'intval');
        $red_grab_num = input("param.red_grab_num",0,'intval');
        $red_send_num = input("param.red_send_num",0,'intval');
        if (empty($parms['id']) || (0 > $parms['id']))
        {
            exit($this->status('ERROR', '非法参数'));
        }
        if (0 > $record_num) exit($this->status('ERROR', '发言条数必须为数字'));
        if (0 > $red_grab_num) exit($this->status('ERROR', '抢红包次数必须为数字'));
        if (0 > $red_send_num) exit($this->status('ERROR', '发红包次数必须为数字'));
        //修改Vip权限
        $url = ADMINAPI . 'interactive/vip/access_save';
        $this->get_save_data($url,$parms);
    }
}