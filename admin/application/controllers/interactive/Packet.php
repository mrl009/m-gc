<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once  __DIR__.'/Base.php';

class Packet extends Base{

    public function __construct(){
        parent::__construct();
    }

    public function packet_list(){
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('interactive/packet/packet_list', $data);
    }

    public function get_packet_list(){
        $rs = $this->curl_post(ADMINAPI . 'interactive/packet/get_packet_list', $_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    public function packet_detail(){
        $data['rid'] = $_GET['id'];
        $this->load->view('interactive/packet/packet_detail', $data);
    }
    public function get_packet_detail(){
        $rs = $this->curl_post(ADMINAPI . 'interactive/packet/get_packet_detail',$_GET+$_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }

    public function packet_statistics(){
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('interactive/packet/packet_statistics', $data);
    }

    public function get_statistics_list(){
        $rs = $this->curl_post(ADMINAPI . 'interactive/packet/get_statistics_list',$_POST);
        $arr = json_decode($rs, true);
        echo json_encode($arr['data']);
    }
}