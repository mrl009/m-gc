<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklogin();

    }

    public function index()
    {
        $_SESSION['login'] = true;
        $this->session->set_userdata('test', $this->input->get('test'));
        $this->load->view('welcome_message');
    }

    //公用全屏页面
    public function pubbox()
    {
        $url = explode('&', base64_decode(str_replace(" ", "+", $this->input->get('url'))));
        $data = array(
            'url' => $url[0],
            'name' => $url[1],
        );
        $this->load->view('pubbox', $data);
    }

    //获取权限菜单
    public function getmenu()
    {
        $admin_id = $this->session->userdata('admin_id');
        $admin = $this->curl_get(ADMINAPI . 'manager/get_active_admin', array('admin_id' => $admin_id));
        $admin = json_decode($admin, true);
        $admin = $admin['data'];
        $contain = $admin['privileges'] == '*' ? '*' : json_decode($admin['privileges'], true);
        $menu = array();
        $rows = json_decode(file_get_contents('static/data/public_menu.json'), true);
        // @modify 2018-04-14 根据配置过滤视讯
        $set = json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true);
        if ($set['code'] == 200) {
            $sx_id = [1001, 1002, 1003, 1004, 1005, 1006]; //@todo 如果要新加视讯彩种这边改为读取公库数据
            $cp = explode(',', $set['data']['cp']);
            $sx_list = array_intersect($sx_id, $cp);
            $gcset = $set['data'];
            $rows = $this->format_sx_menu($rows, $sx_list, $gcset);
        }
        if ($contain == "*") {
            $menu = $rows;
        } else {
            foreach ($rows as $k => $v) {
                if (array_key_exists($v['en_name'], $contain['public'])) {
                    foreach ($v['submenu'] as $aa => $b) {
                        if (!array_key_exists($b['en_name'], $contain['public'][$v['en_name']])) {
                            unset($rows[$k]['submenu'][$aa]);
                        } else {
                            $a = explode(',', $rows[$k]['submenu'][$aa]['auth']);
                            $cc = array();
                            foreach ($a as $t => $o) {
                                if (in_array($o, $contain['public'][$v['en_name']][$b['en_name']])) {
                                    $cc[] = $o;
                                }
                            }
                            $rows[$k]['submenu'][$aa]['auth'] = implode(',', $cc);
                        }
                    }
                } else {
                    unset($rows[$k]);
                }
            }
            $menu = array_merge_recursive($menu, $rows);
        }
        echo json_encode($menu);
    }

    public function start()
    {
        $data['config'] = array();
        $data['rs'] = array_pop(json_decode($this->curl_get(ADMINAPI . 'setting/setting/get_set'), true));
        $this->load->view('startpage', $data);
    }

    private function format_sx_menu($data, $sx_list = array(), $gcset)
    {
        $is_auto_out = $gcset['is_auto_out'] ? $gcset['is_auto_out'] : 0;
        $is_open_hddt = $gcset['is_open_hddt'] ? $gcset['is_open_hddt'] : 0;
        $rs = [];
        if (strtolower($this->session->userdata('admin_name')) === 'syszdchukuan' && !empty($is_auto_out)) {
            $menu = [[
                "name"      => "現金系統",
                "en_name"   => "CashSystem",
                "icon"      => "entypo-chart-pie",
                "submenu"   => [
                    [
                        "name"      => "自動出款",
                        "en_name"   => "AutoWithdraw",
                        "url"       => "cash/payment_auto",
                        "auth"      => "READ"
                    ]
                ]
            ]];
            return $menu;
        }
        foreach ($data as $k => $v) {
            if (empty($sx_list)) {
                if ($v['en_name'] == 'sxOrderList' || $v['en_name'] == 'sxFsSet') {
                    continue;
                }
            } else {
                if ($v['en_name'] == 'sxOrderList') {
                    $t = [];
                    foreach ($v['submenu'] as $item) {
                        if ($item['en_name'] == 'AgOrder' && in_array(1001, $sx_list)) {
                            array_push($t, $item);
                        } elseif ($item['en_name'] == 'DgOrder' && in_array(1002, $sx_list)) {
                            array_push($t, $item);
                        } elseif ($item['en_name'] == 'LeboOrder' && in_array(1003, $sx_list)) {
                            array_push($t, $item);
                        } elseif ($item['en_name'] == 'PtOrder' && in_array(1004, $sx_list)) {
                            array_push($t, $item);
                        } elseif ($item['en_name'] == 'MgOrder' && in_array(1005, $sx_list)) {
                            array_push($t, $item);
                        } elseif ($item['en_name'] == 'KyOrder' && in_array(1006, $sx_list)) {
                            array_push($t, $item);
                        }
                    }
                    $v['submenu'] = $t;
                }
            }
            if ($v['en_name'] == 'Level' && empty($is_auto_out)) {
                $t = [];
                foreach ($v['submenu'] as $item) {
                    if ($item['en_name'] != 'OutPaymentSetting') {
                        array_push($t, $item);
                    }
                }
                $v['submenu'] = $t;
            }
            if ($v['en_name'] == 'Interactive' && $is_open_hddt == 0) {
                continue;
            }
            array_push($rs, $v);
        }
        return $rs;
    }
}