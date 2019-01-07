<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Game extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();
    }

    //彩种管理
    public function index()
    {
        $data['auth'] = explode(',', $this->input->get('auth'));
        $ctg = $this->uri->segment(3);
        $tmp = $ctg == 'gc' ? 'game/gc_list' : 'game/sc_list';
        $this->load->view($tmp, $data);
    }

    //彩种管理列表
    public function get_list()
    {
        // 判断取用接口
        $arr = json_decode($this->curl_get(ADMINAPI . 'games/info', $_GET), true);
        $rs = $arr['data'];
        $set = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        $cp = $set['data']['cp'];
        $cp_index = $set['data']['cp_index'];
        $game = isset($set['data']['game']) ? explode(',', $set['data']['game']) : [];
        //增加是否首頁，開啟狀態
        foreach ($rs['rows'] as $k => $v) {
            if (!in_array($v['id'], $game)) {
                unset($rs['rows'][$k]);
                continue;
            }
            $rs['rows'][$k]['home'] = !empty($cp_index) && in_array($v['id'], explode(',', $cp_index)) ? 1 : 0;
            $rs['rows'][$k]['open'] = !empty($cp) && in_array($v['id'], explode(',', $cp)) ? 1 : 0;
        }
        //根據cp排序
        $tmp = [];
        if ($cp) {
            $cp = explode(',', $cp);
            foreach ($cp as $id) {
                foreach ($rs['rows'] as $k => $v) {
                    if ($id == $v['id']) {
                        array_push($tmp, $rs['rows'][$k]);
                        unset($rs['rows'][$k]);
                    }
                }
            }
        }
        $rs = array_merge($tmp, $rs['rows']);
        echo json_encode($rs);
    }

    //首頁彩种管理列表
    public function get_home_list()
    {
        // 判断取用接口
        $arr = json_decode($this->curl_get(ADMINAPI . 'games/info', $_GET), true);
        $rs = $arr['data'];
        $set = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        $cp_index = $set['data']['cp_index'];
        $cp_index = explode(',', $cp_index);
        $game = isset($set['data']['game']) ? explode(',', $set['data']['game']) : [];
        $cp_index = array_intersect($cp_index,$game);
        //過濾非首頁彩種
        foreach ($rs['rows'] as $k => $v) {
            if (!in_array($v['id'], $cp_index)) {
                unset($rs['rows'][$k]);
                continue;
            }
        }
        //根據cp_index排序
        $tmp = [];
        if ($cp_index) {
            foreach ($cp_index as $id) {
                foreach ($rs['rows'] as $k => $v) {
                    if ($id == $v['id']) {
                        array_push($tmp, $rs['rows'][$k]);
                        unset($rs['rows'][$k]);
                    }
                }
            }
        }
        $rs = array_merge($tmp, $rs['rows']);
        echo json_encode($rs);
    }

    //更新彩种状态
    public function update_game_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $arr = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        if ($arr['code'] == 200) {
            $set = $arr['data']['cp'];
            $cp_index_set = $arr['data']['cp_index'];
            if (!empty($set)) {
                $set = explode(',', $set);
                $cp_index_set = explode(',', $cp_index_set);
                if ($status) {
                    array_push($set, $id);
                } else {
                    foreach ($set as $k => $v) {
                        if ($id == $v) {
                            unset($set[$k]);
                            break;
                        }
                    }
                    foreach ($cp_index_set as $k => $v) {
                        if ($id == $v) {
                            unset($cp_index_set[$k]);
                            break;
                        }
                    }
                }
                $cp = count($set) > 0 ? implode(',', array_unique($set)) : '';
                $cp_index = count($cp_index_set) > 0 ? implode(',', array_unique($cp_index_set)) : '';
            } else {
                $cp = $status ? $id : '';
            }
            $rs = json_decode($this->curl_post(ADMINAPI . 'setting/setting/save_set_cp', array('cp' => $cp,'cp_index'=>$cp_index)), true);
            if ($rs['code'] == 200) {
                echo $this->status('OK', '執行成功');
            } else {
                echo $this->status('ERROR', $rs['msg']);
            }
        } else {
            echo $this->status('ERROR', $arr['msg']);
        }
    }

    //更新彩种首页状态
    public function update_game_home()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $arr = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        if ($arr['code'] == 200) {
            $set = $arr['data']['cp_index'];
            if (!empty($set)) {
                $set = explode(',', $set);
                if ($status) {
                    array_push($set, $id);
                } else {
                    foreach ($set as $k => $v) {
                        if ($id == $v) {
                            unset($set[$k]);
                            break;
                        }
                    }
                }
                $cp_index = count($set) > 0 ? implode(',', array_unique($set)) : '';
            } else {
                $cp_index = $status ? $id : '';
            }
            $rs = json_decode($this->curl_post(ADMINAPI . 'setting/setting/save_set_cp_index', array('cp_index' => $cp_index)), true);
            if ($rs['code'] == 200) {
                echo $this->status('OK', '執行成功');
            } else {
                echo $this->status('ERROR', $rs['msg']);
            }
        } else {
            echo $this->status('ERROR', $arr['msg']);
        }
    }

    //获取cp
    public function ajax_get_cp()
    {
        $ctg = $this->input->get('ctg');
        $rs = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_cp', array('ctg' => $ctg)), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', $rs['data']));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //获取cp_index
    public function ajax_get_cp_index()
    {
        $ctg = $this->input->get('ctg');
        $rs = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_cp_index', array('ctg' => $ctg)), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', $rs['data']));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //拖動更新
    public function ajax_update_game()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'setting/setting/save_set_cp', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }

    //拖動更新
    public function ajax_update_home_game()
    {
        $rs = json_decode($this->curl_post(ADMINAPI . 'setting/setting/save_set_cp_index', $_POST), true);
        if ($rs['code'] == 200) {
            exit($this->status('OK', '執行成功'));
        } else {
            exit($this->status('ERROR', $rs['msg']));
        }
    }
}