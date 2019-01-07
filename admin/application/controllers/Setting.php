<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MY_Controller {
	function __construct(){
		parent::__construct();
        $this->checklogin();
	}
    /*****************站点配置*******************/
	//站点配置
	public function site_set(){
        $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_set'),true));
        $data['rs']['register_discount_from_way'] = explode(',',$data['rs']['register_discount_from_way']);
        $data['rs']['lottery_auth'] = explode(',',$data['rs']['lottery_auth']);
        $data['rs']['sys_activity'] = explode(',',$data['rs']['sys_activity']);
        $data['rs']['reward_day'] = explode(',',$data['rs']['reward_day']);
        $win=json_decode($data['rs']['win_rate'],true);
        $data['win_rand'] = $win['win_rand'];
        $data['rs']['win_rate']=json_decode($data['rs']['win_rate'],true);
		$this->load->view('setting/site_set',$data);
	}
    public function save_set(){
        $fromWay = $sysActivity = $rewardDay = '';
        foreach ($_POST['register_discount_from_way'] as $v) {
            $fromWay = empty($fromWay) ? $v : $fromWay. ','. $v;
        }
        $_POST['register_discount_from_way'] = $fromWay;
        foreach ($_POST['sys_activity'] as $v) {
            $sysActivity = empty($sysActivity) ? $v : $sysActivity. ','. $v;
        }
        $_POST['sys_activity'] = $sysActivity;
        foreach ($_POST['reward_day'] as $v) {
            $rewardDay = empty($rewardDay) ? $v : $rewardDay. ','. $v;
        }
        $_POST['reward_day'] = $rewardDay;
        $rs= json_decode($this->curl_post(ADMINAPI.'setting/setting/save_set',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    /*****************END站点配置*******************/

    /***********************************域名配置***********************************************/
    //域名列表
    public function site_domain()
    {
        $data['auth']=explode(',', $this->input->get('auth'));
        $this->load->view('setting/domain', $data);
    }
    public function get_site_domain_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_site_domain_list',$_POST),true);
        echo json_encode($arr['data']);

    }
    public function edit_domain()
    {
        $data['rs'] = array();
        $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_site_domain_list'),true);
        $rs = $arr['data']['rows'];
        $data['type'] = array_column($rs, 'type');
        if(!empty($_GET['id'])){
            $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_domain_info?id='.$_GET['id']),true));
        }
        $this->load->view('setting/add_domain', $data);
    }
    //保存修改
    public function save_domain(){
        //$_POST['domain'] = preg_replace('/http:\/\//i', '', $_POST['domain']);
        $rs = json_decode($this->curl_post(ADMINAPI.'setting/setting/save_domain',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    //删除
    public function delete_domain(){
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/delete_domain',array('id'=>$_POST['id'])),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    /***********************************END域名配置*************************************/

    /***********************************获取网站信息*************************************/
    public function site_information(){
        $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_site_info?type=1'),true));
        $this->load->view('setting/site_information',$data);
    }
    public function getSiteOne(){
        $rs = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_site_one?id='.$_GET['id']),true));
        echo json_encode($rs);
        
    }
    public function saveSiteInfo(){
        $data['id'] = $this->input->post('text_id');
        $data['content'] =$this->input->post('content');
        $data['title'] =$this->input->post('title');
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/saveSiteInfo',$data),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    /***********************************END网站信息*************************************/

    /***********************************获取支付信息*************************************/
    public function pay_information(){
        $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_site_info?type=2'),true));
        $this->load->view('setting/pay_information',$data);
    }
    /***********************************END支付信息*************************************/

    /***********************************活动管理*************************************/
    //活动管理
    public function activity_manage(){
        $data['auth']=explode(',', $this->input->get('auth'));
        $this->load->view('setting/activity_manage',$data);
    }
    //活动管理列表
    public function get_activity_list()
    {
        $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_activity_list',$_POST),true);
        echo json_encode($arr['data']);
    }

    //活动管理 --设置内容
    public function activity_con_set()
    {
        $data['rs']=array();
        $id = $this->input->get('id');
        if(!empty($id)){
             $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_activity_info',array('id'=>$id)),true);
             $arr['data']['show_way'] = explode(',',$arr['data']['show_way']);
             $data['rs'] = $arr['data'];
        }
        $this->load->view('setting/activity_con_set',$data);
    }
    //保存活动
    public function save_activity()
    {
        foreach ($_POST['show_way'] as $v) {
            $showWay = empty($showWay) ? $v : $showWay. ','. $v;
        }
        $_POST['show_way'] = $showWay;
        
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/save_activity',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    //删除活动
    public function delete_activity()
    {
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/delete_activity',array('id'=>$_POST['id'])),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    //修改活动状态
    public function update_status()
    {
        $arr = $this->curl_post(ADMINAPI.'setting/setting/update_status',array('admin_id'=>$_POST['id'],'status'=>$_POST['status'],'title'=>$_POST['title']));
        $rs=json_decode($arr,true);
        if($rs['code']==200){
            exit($this->status('OK','执行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    /***********************************END活动管理*************************************/
    /***********************************活动黑名单****************************************/
    public  function activity_blacklist(){
        $data['auth']=explode(',', $this->input->get('auth'));
        $this->load->view('setting/activity_blacklist',$data);
    }
    public function get_activity_blacklist(){
        $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_activity_blacklist',$_POST),true);
        echo json_encode($arr['data']);
    }
    public function activity_black_set()
    {
        $data['rs']=array();
        $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_set'),true));
        $data['rs']['sys_activity'] = explode(',',$data['rs']['sys_activity']);
        $activity_lists=array_map(function ( $value){
            if($value == 1){
                $activity['id'] =1;
                $activity['title'] ='晋级奖励';
            }
            if($value == 2){
                $activity['id'] =2;
                $activity['title'] ='每日加奖';
            }
            return $activity;
        }, $data['rs']['sys_activity']);
        $id = $this->input->get('id');
        /*$arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_activity_list',array('id'=>$id)),true);
        $activity_lists=array_map(function ( $value){
            if(in_array($value['id'],[1001,1002])){
                $activity['id']=$value['id'];
                $activity['title']=$value['title'];
            }
            return $activity;
        },$arr['data']['rows']);*/
        $data['activity_lists']=array_filter($activity_lists);
        if(!empty($id)){
            $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_activity_blacklist_info',array('id'=>$id)),true);
            $arr['data']['activity_id'] = explode(',',$arr['data']['activity_id']);
            $data['rs'] = $arr['data'];
        }
        $this->load->view('setting/activity_blacklist_set',$data);
    }
    public function save_activity_blacklist(){
        if(empty($_POST['show_way'])){
            exit($this->status('ERROR','至少勾选一个活动'));
        }
        foreach ($_POST['show_way'] as $v) {
            $showWay = empty($showWay) ? $v : $showWay. ','. $v;
            /*$arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_activity_info',array('id'=>$v)),true);*/
            if($v == 1){
                $arr['data']['title'] = '晋级奖励';
            }else{
                $arr['data']['title'] = '每日嘉奖';
            }
            $activity_title = empty($activity_title) ? $arr['data']['title'] : $activity_title. ','. $arr['data']['title'];
        }
        /* foreach ($_POST['activity_title'] as $v) {
             $activity_title = empty($activity_title) ? $v : $activity_title. ','. $v;
         }*/
        $_POST['show_way'] = $showWay;
        $_POST['activity_title'] = $activity_title;
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/save_activity_blacklist',$_POST),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    public function delete_activity_blacklist(){
        //var_dump($_POST);exit();
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/delete_activity_blacklist',array('id'=>$_POST['id'])),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }
    /***********************************END活动黑名单*************************************/
    //广告管理
    public function images_manage(){
        $arr = json_decode($this->curl_get(ADMINAPI.'setting/setting/get_advertise_list'),true);
        $data['pc'] = $arr['data'][0]['img_json'];
        $data['wap_banner'] = $arr['data'][1]['img_json'];
        $data['wap_slides'] = $arr['data'][2]['img_json'];
        $data['wap_bottom'] = $arr['data'][3]['img_json'];
        $data['wap_bottom_unselected'] = $arr['data'][4]['img_json'];
        $this->load->view('setting/advertise_manage',$data);
    }
    public function save_pics(){
        $data = array('type'=>$this->input->post('type'),'pics'=>$this->input->post('data'));
        $rs=json_decode($this->curl_post(ADMINAPI.'setting/setting/save_pics',$data),true);
        if($rs['code']==200){
            exit($this->status('OK','執行成功'));
        }else{
            exit($this->status('ERROR',$rs['msg']));
        }
    }


    /***********************************注册配置*************************************/

    public function register_set(){
        $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI.'setting/setting/get_set'),true));
        $data['rs']['register_discount_from_way'] = explode(',',$data['rs']['register_discount_from_way']);
        $this->load->view('setting/register_set',$data);
    }


    /***********************************END注册配置*************************************/

    /**
     * 用于 js canvas 使用在线图片 跨域问题
     */
    public function get_img(){
        header('Content-type: image/png');
        $url = $this->input->get('url');
        echo file_get_contents($url);
    }
}