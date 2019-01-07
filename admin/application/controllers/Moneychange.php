<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Moneychange extends MY_Controller
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
    	$data = [];
    	$this->load->view('cash/moneychange/index', $data);
    }

    //切换模板
    public function changeTmp()
    {
    	$t = $this->input->get('t');
    	$data = [];
    	if($t == 1) {
    		$this->load->view('cash/moneychange/edzh', $data);
    	}else if($t == 2) {
    		$this->load->view('cash/moneychange/edzhlist', $data);
    	}else if($t == 3) {
    		$this->load->view('cash/moneychange/ddcl', $data);
    	}
    }
}