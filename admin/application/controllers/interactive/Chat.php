<?php 
/**
 * 活动大厅 (聊天记录) 
 * User: lqh6249
 * Date: 1970/01/01
 * Time: 00:01
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
//引用公用文件
include_once  __DIR__.'/Base.php';

class Chat extends Base
{
    function __construct()
    {
        parent::__construct();
    }

    //聊天记录 (页面)
    public function record_list()
    {
        $auth = input('param.auth'); 
        $data['auth'] = !empty($auth) ? explode(',', $auth) : '';
        $this->load->view('interactive/chat/record_list', $data);
    } 

    //聊天记录 获取聊天记录数据
    public function get_record_list()
    {
        $parms = input("param.");
        //获取聊天记录数据接口
        $url = ADMINAPI . 'interactive/chat/get_record_list';
        $this->get_index_data($url,$parms);
    }   

    //聊天记录 删除聊天记录
    public function record_delete()
    {
        $parms = input("param.");
        //删除聊天记录数据接口
        $url = ADMINAPI . 'interactive/chat/record_delete';
        $this->get_save_data($url,$parms);
    }

    //发送聊天室消息 页面
    public function msg_send()
    {
        $url = ADMINAPI . 'interactive/chat/get_msg_send';
        $sdata['rs'] = $this->get_index_data($url,[],1);
        if (empty($sdata['rs'])) $sdata['rs'] = '';
        $this->load->view('interactive/chat/msg_send',$sdata);
    }

    //保存发送的聊天室消息
    public function msg_send_save()
    {
        $parms = input("param.");
        $type = input("param.type",'','trim');
        //根據類別獲取對應的消息內容
        $parms = array_filter($parms);
        //富文本编辑框消息包含HTML标签不使用过滤
        $msg = isset($_REQUEST[$type.'_msg']) ? $_REQUEST[$type.'_msg'] : '';
        if (empty($msg)) exit($this->status('ERROR','请先填入消息内容'));
        unset($parms[$type.'_msg']);
        if ($type == 'notice'){
            $parms['msg'] = strip_tags($msg);
        }
        $parms['msg'] = $msg;
        //保存消息
        $url = ADMINAPI . 'interactive/chat/msg_send_save';
        $this->get_save_data($url,$parms);
    }

    //敏感词过滤 页面
    public function msg_filter()
    {
        $sdata = [];
        $url = ADMINAPI . 'interactive/chat/get_msg_filter';
        $sdata['rs'] = $this->get_index_data($url,[],1);
        $this->load->view('interactive/chat/msg_filter', $sdata);
    }

    // 敏感词过滤保存操作
    public function msg_filter_save()
    {
        $parms = input("param.");
        if (empty($parms['data_filter']))
        {
            exit($this->status('ERROR','请先填入过滤词'));
        }
        //保存消息过滤接口
        $url = ADMINAPI . 'interactive/chat/msg_filter_save';
        $this->get_save_data($url,$parms);
    }

    //禁言列表 (页面)
    public function silence_list()
    {
        $auth = input('param.auth'); 
        $data['auth'] = !empty($auth) ? explode(',', $auth) : '';
        //刷新一下用户禁言过期时间
        $this->silence_refresh();
        $this->load->view('interactive/chat/silence_list', $data);
    } 

    //禁言列表 获取禁言列表数据
    public function get_silence_list()
    {
        $parms = input("param.");
        //获取聊天记录数据接口
        $url = ADMINAPI . 'interactive/chat/get_silence_list';
        $this->get_index_data($url,$parms);
    }   

    //设置禁言
    public function silence_edit()
    {
        $parms = input("param.");
        if (empty($parms['id'])) $this->status('ERROR', '缺少参数');
        //获取基本信息
        $url = ADMINAPI . 'interactive/chat/get_silence_info';
        $data = $this->get_index_data($url,$parms,1);
        $this->load->view('interactive/chat/silence_edit', $data);
    }

    //保存禁言设置
    public function silence_save()
    {
        $parms = input("param.");
        if (empty($parms['id'])) $this->status('ERROR', '缺少参数');
        //修改Vip权限
        $url = ADMINAPI . 'interactive/chat/silence_save';
        $this->get_save_data($url,$parms);
    }

    //刷新用户禁言状态
    private function silence_refresh()
    {
        $url = ADMINAPI . 'interactive/chat/silence_refresh';
        $data = $this->curl_get($url);
        return true;
    }
}