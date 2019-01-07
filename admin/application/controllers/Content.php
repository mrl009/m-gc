<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    /**************************获取内容列表****************************/
    // 内容列表
    public function index()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $this->load->view('content/list', $data);
    }

    // 获取内容列表数据
    public function get_article_list()
    {
        $rs = json_decode($this->curl_get(ADMINAPI . 'content/content/getArticleList', $_POST), true);
        echo json_encode($rs['data']);
    }

    // 新增修改内容
    public function editarticle()
    {
        $data = array();
        if (!empty($_GET['id'])) {
            // 获取一条文章信息
            $rs = json_decode($this->curl_get(ADMINAPI . 'content/content/getOneArticle', $_GET), true);
            $data = $rs['data'];
            if ($data['no_edit'] == 2) {
                $this->load->view('error', array());
            }
        }
        $this->load->view('content/edit_article', $data);
    }

    // 保存内容
    public function savearticle()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'content/content/saveArticle', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 删除内容
    public function delarticle()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'content/content/deleteArticle', array('id' => $_POST['id'])), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /**************************END内容列表****************************/

    /**************************获取文章分类****************************/
    //分类列表
    public function channel()
    {
        $this->load->view('content/channel');
    }

    // 获取分类列表数据
    public function getchannel()
    {
        $rs = json_decode($this->curl_get(ADMINAPI . 'content/content/getCategoryList', $_GET), true);
        echo json_encode($rs['data']);
    }

    // 新增修改分类
    public function editchannel()
    {
        $data = array();
        if (!empty($_GET['id'])) {
            // 获取一条分类信息
            $rs = json_decode($this->curl_get(ADMINAPI . 'content/content/getOneCategory', $_GET), true);
            $data = $rs['data'];
            if ($data['no_edit'] == 2) {
                $this->load->view('error', array());
            }
        }
        $this->load->view('content/edit_channel', $data);
    }

    // 保存分类
    public function savechannel()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'content/content/saveCategory', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    // 删除分类
    public function removechannel()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'content/content/deleteCategory', $_GET), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
    /**************************END文章分类****************************/
}