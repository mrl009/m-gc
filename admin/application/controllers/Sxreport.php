<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sxreport extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    public function index()
    {
        $this->load->view('report/sx/index');
    }

    public function sx(){
    	$data['game']=$this->input->get('game');
    	$data['auth']=explode(',', $this->input->get('auth'));
    	$this->load->view('report/sx/ag',$data);
    }
    public function getsxlist(){
    	$_POST['game']=$this->input->get('game');
    	$arr = json_decode($this->curl_get(ADMINAPI.'sx/shixun/get_sx_report',$_POST),true);
        echo json_encode($arr['data']);
    }
}