<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    public function password()
    {
        $this->load->view('manager/password');
    }

    public function save_pwd()
    {
        if (empty($_POST['pwd']) && empty($_POST['two_pwd']) && empty($_POST['old_pwd'])) {
            exit($this->status('ERROR', '密碼不能為空'));
        }

        $pattern = '/^.{6,18}$/';
        if (!preg_match($pattern, $_POST['pwd']) && !preg_match($pattern, $_POST['two_pwd'])){
            exit($this->status('ERROR', '密碼格式為：6-18位，不能包含漢字和空格'));
        }

        $pattern = '/[\s|　]+/';
        if (preg_match($pattern, $_POST['pwd'])) {
            exit($this->status('ERROR', '密碼不能包含中文和空格'));
        }

        $pattern = '/[\x{4e00}-\x{9fa5}]/u';
        if (preg_match($pattern, $_POST['pwd'])) {
            exit($this->status('ERROR', '密碼不能包含中文和空格'));
        }
        
        if ($_POST['pwd'] != $_POST['two_pwd']) {
            exit($this->status('ERROR', '輸入的新密碼要與重復確認輸入的密碼壹致'));
        }
        $arr = $this->curl_post(ADMINAPI . 'manager/edit_pwd',
            array(
                'admin_id' => $this->session->userdata('admin_id'),
                'pwd' => md5($_POST['pwd']),
                'two_pwd' => md5($_POST['two_pwd']),
                'old_pwd' => md5($_POST['old_pwd'])
            ));
        $rs = json_decode($arr, true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
}