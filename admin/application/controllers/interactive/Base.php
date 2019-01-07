<?php 
/**
 * 公用控制器 
 * User: lqh6249
 * Date: 1970/01/01
 * Time: 00:01
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base extends MY_Controller
{
    //初始化参数
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
        $this->load->helper('interactive');
    }
    
    /**
     * 获取接口返回对应的列表/详情数据 (get/post方法)
     * @param string $means 控制器操作方法
     * @return json
     */
    protected function get_index_data($url,$parms=[],$is_return=0)
    {
        $sdata = [];
        //根据是否有参数决定是否那种方法获取数据
        if (!empty($parms))
        {
            $data = $this->curl_post($url,$parms);
        } else {
            $data = $this->curl_get($url);
        }
        //解析并返回规定的格式数据
        if (!empty($data)) $data = json_decode($data,true);
        if (!empty($data['data'])) $sdata = $data['data'];
        //是否返回数据还是直接输出json数据 
        if (!empty($is_return)) 
        {
            return $sdata;
        } else {
            echo json_encode($sdata,320);
        }
    }

    /**
     * 获取接口返回对应的保存结果数据数据 (get/post方法)
     * @param string $means 控制器操作方法
     * @return json
     */
    protected function get_save_data($url,$parms=[])
    {
        $data = $this->curl_post($url,$parms);
        //解析并返回规定的格式数据
        if (!empty($data)) $data = json_decode($data,true);
        //判读保存修改操作是否操作成功
        if (isset($data['code']) && (200 == $data['code']))
        {
            $this->retMsg(200,'保存成功');
        } else {
            //保存数据失败，返回失败信息
            $msg = isset($data['msg']) ? $data['msg'] : '没有数据被修改';
            $this->retMsg(-200,$msg);
        }
    }

    /**
     * 返回错误提示信息
     * @param array $msg 
     * @return json
     */
    protected function retMsg($code,$msg)
    {
        $status = (200 == $code) ? 'OK' : 'ERROR';
        $err = array('status' => $status, 'msg' => $msg);
        exit(json_encode($err,320));
    }
}