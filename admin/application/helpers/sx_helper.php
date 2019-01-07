<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
function PrintJs(){
    $js='';
    foreach(GetGameType('',2) as $k=>$r){
        foreach($r as $a=>$b){
            $js .= '
        var '.$a.'["'.$k.'"] = new array(';
            $js_value='';
            foreach($b as $c=>$d){
                $js_value.="['$c':'$d'],";
            }
            $js.=rtrim($js_value,',').");";
        }

    }
    return json_encode(GetGameType('',2));
}
function porkeradd($v){

    if($v==11) $v='J';
    elseif($v==12) $v='Q';
    elseif($v==13) $v='K';
    return $v;
}

function poker($v){
    $a=$b=$c=$d=0;
    $r='';
    for($i=1;$i<=52;$i++){
        if($i<=13) {
              if($v==$i) $r='♠'.porkeradd($i);
        }
        elseif($i<=26) {
            $a++;
            if($v==$i) $r='<font color=red>♥</font>'.porkeradd($a);
        }
        elseif($i<=39) {
            $b++;
            if($v==$i) $r='♣'.porkeradd($b);
        }
        elseif($i<=52) {
            $c++;
            if($i==50)      $c='J';
            elseif($i==51)  $c='Q';
            elseif($i==52)  $c='K';
            if($v==$i) $r='<font color=red>♦</font>'.porkeradd($c);
        }
    }
    return $r;
}
function poker_lb($v){
    $a=$b=$c=$d=0;
    $r='';
    for($i=1;$i<=61;$i++){
        if($i<=13) {
            if($v==$i) $r='<font color=red>♦</font>'.porkeradd($i);
        }
        elseif($i<=29 && $i>=17) {
            $a++;
            if($v==$i) $r='♣'.porkeradd($a);
        }
        elseif($i<=45  && $i>=33) {
            $b++;
            if($v==$i) $r='<font color=red>♥</font>'.porkeradd($b);
        }
        elseif($i<=61  && $i>=49) {
            $c++;
            if($i==59)      $c='J';
            elseif($i==60)  $c='Q';
            elseif($i==61)  $c='K';
            if($v==$i) $r='♠'.porkeradd($c);
        }
    }
    return $r;
}
function GetGameType($v,$t=false,$CompanyType='og',$GameType='video'){
    //mg ag BBIN有電子
    $Type['video']['bbin'] = array(
        3=>['Name'=>'視訊'],
        15=>['Name'=>'3D廳'],
        1=>['Name'=>'球類'],
        5=>['Name'=>'機率'],
        12=>['Name'=>'彩票'],
    );
    $Type['game']['bbin'] = array(
    );
    $Type['video']['mg'] = array(
        'Diamond LG Baccarat'=>['Name'=>'Diamond LG Baccarat'],
    );
    $Type['game']['mg'] = array(
        '3 Reel Slot Games'=>['Name'=>'3 Reel Slot Games'],
        '5 Reel Slot Games'=>['Name'=>'5 Reel Slot Games'],
        'Soft Game'=>['Name'=>'Soft Game'],
    );
    $Type['video']['lebo'] = [
        1=>['Name'=>'百家樂'],
        2=>['Name'=>'輪盤'],
        3=>['Name'=>'股寶'],
        4=>['Name'=>'龍虎'],
        5=>['Name'=>'番攤/股寶翻攤'],
    ];
    $Type['game']['lebo'] = array(
    );
    $Type['video']['og'] = array(
        11=>['Name'=>'百家樂'],
        12=>['Name'=>'龍虎'],
        13=>['Name'=>'輪盤'],
        14=>['Name'=>'股寶'],
        15=>['Name'=>'撲克'],
        16=>['Name'=>'番攤'],
    );
    $Type['game']['og'] = array(
    );
    $Type['video']['dg'] = [
        1=>['Name'=>'百家樂'],
        2=>['Name'=>'輪盤'],
        3=>['Name'=>'股寶'],
        4=>['Name'=>'龍虎','Result'=>''],
        5=>['Name'=>'番攤/股寶翻攤'],
        7=>['Name'=>'保險百家樂'],
        9=>['Name'=>'色碟'],
    ];
    $Type['game']['dg'] = array(
    );
    $Type['video']['ag'] = array(
        'BAC'=>['Name'=>'百家樂'],
        'CBAC'=>['Name'=>'包桌百家樂'],
        'LINK'=>['Name'=>'連環百家樂'],
        'DT'=>['Name'=>'龍虎'],
        'SHB'=>['Name'=>'股寶'],
        'FT'=>['Name'=>'番攤'],
		'ROU'=>['Name'=>'輪盤'],
		'LBAC '=>['Name'=>'競咪百家樂'],
		'ULPK'=>['Name'=>'終極德州撲克'],
		'SBAC '=>['Name'=>'保險百家樂'],
    ); //添加:輪盤,競迷百家樂,終極德州撲克,保險百家樂.2016.8.22.dafuhaomen
    $Type['game']['ag'] = array(
        'SL1'=>['Name'=>'巴西世界杯'],
        'PK_J'=>['Name'=>'視頻撲克(傑克高手)'],
        'SL2'=>['Name'=>'瘋狂水果店'],
        'SL3'=>['Name'=>'3D 水族館'],
        'SL4'=>['Name'=>'極速賽車'],
        'PKBJ'=>['Name'=>'新視頻撲克(傑克高手)'],
        'FRU'=>['Name'=>'水果拉霸'],
    );
    if($t==1){
        return $Type[$GameType][$CompanyType];
    }elseif($t==2){
        return $Type;
    }else{
        $d=null;

        return $d;
    }
}
function ogwin($a){
    if($a==1) $b='<font color=blue>輸</font>';
    elseif($a==2) $b='<font color=red>贏</font>';
    elseif($a==3) $b='和';
    else $b='';
    return $b;
}
function GetGameResult($v,$t=false){
    $Type=array(
        'a'=>'莊',
        'b'=>'莊,閑對',
        'c'=>'莊,莊對',
        'd'=>'莊,莊對,閑對',
        'e'=>'閑',
        'f'=>'閑,閑對',
        'g'=>'閑,莊對',
        'h'=>'閑,莊對,閑對',
        'i'=>'和',
        'j'=>'和,閑對',
        'k'=>'和,莊對',
        'l'=>'和,閑對,莊對',
    );
    if($t==true){
        return $Type;
    }else{
        $d=null;
        foreach($Type as $k=>$r){
            if($v==$k || $v==$r){
                $d['k']=$k;
                $d['v']=$r;
                break;
            }
        }
        return $d;
    }
}

// DG注单游戏大厅号
function dating($lobbyid) {
    $arr = array(
        '1' => '旗舰店', '2' => '竞咪厅'
    );
    return $arr[$lobbyid];
}

// DG游戏类型数字转汉字
function gameType($type) {
    $game = array(
        '1' => '百家乐', '3' => '龙虎', '4' => '轮盘',
        '5' => '骰子', '7' => '牛牛', '8' => '竞咪百家乐'
    );
    return $game[$type];
}

// DG桌号数字转汉字
function dg_zhuo($num) {
    $zhuo = array(
        '10101' => 'DG01', '10102' => 'DG02', '10103' => 'DG03', '10105' => 'DG05',
        '10106' => 'DG06', '10107' => 'DG07', '10301' => 'DG12', '10401' => 'DG13',
        '10501' => 'DG15', '10701' => 'DG16', '20801' => 'DG08', '20802' => 'DG09',
        '20803' => 'DG10', '20805' => 'DG11'
    );
    return $zhuo[$num];
}

// DG结果转换
function result_win($result, $type) {
    $result = json_decode($result);
    $game = explode(',', $result->result);

    switch ($type) {
        case 1: // 百家乐
        case 8:
            $wanfa = array('1' => '庄赢', '2' => '闲赢', '3' => '和');
            $one = $wanfa[$game[1]].$game[2];
            break;
        
        case 3: // 龙虎
            $wanfa = array('1' => '龙赢', '2' => '虎赢', '3' => '和赢');
            $one = $wanfa[$game[0]].$game[1];
            break;

        case 4: // 轮盘
            $one = $game[0];
            break;

        case 5: // 骰宝
            $one = $game[0];
            break;

        case 7:
            $one = '闲1，闲2，闲3';
            break;
    }
    return $one;
}

//LEBO大厅
function lebo_dating($gameid) {
    $num = substr($gameid, 0, 3);
    switch ($num) {
        case '000':
            return '旗舰厅';
            break;
        case '010':
            return '贵宾厅';
            break;
        case '020':
            return '金臂厅';
            break;
        case '020':
            return '至尊厅';
            break;
        
        default:
            return '旗舰厅';
            break;
    }
}

//LEBO类型
function lebo_gameType($type) {
    $game = array(
        '1' => '百家乐', '2' => '轮盘', '3' => '骰宝', '4' => '龙虎',
        '5' => '番摊/骰宝翻摊'
    );
    return $game[$type];
}

//LEBO结果
function lebo_result($result, $type) {
    $one = explode('^', $result);
    switch ($type) {
        case '1': // 百家乐
            $num = explode(';', $one[0]);
            $str = $num[0] > $num[1] ? '闲赢'.$num[0] : '庄赢'.$num[1];
            return $str;
            break;
        case '2': // 轮盘
            return $one[0];
            break;
        case '3': // 骰宝
            return $one[0];
            break;
        case '4': // 龙虎
            $num = explode(';', $one[0]);
            $str = $num[0] > $num[1] ? '龙赢'.$num[0] : ($num[0] == $num[1] ? '和' : '虎赢'.$num[1]);
            return $str;
            break;
        default:
            return '开发中';
    }
}

// AG游戏
function ag_dating($type) {
    $game = array(
        'AGIN' => 'AG国际厅',
        'AG' => 'AG旗舰厅',
        'DSP' => 'AG实地厅',
        'IPM' => 'IPM',
        'XIN' => 'XIN'
    );
    return $game[$type];
}

// AG类型
function ag_gameType($type) {
    $type_arr = array(
        'BAC' => '百家乐',
        'CBAC' => '包桌百家乐',
        'LINK' => '连环百家乐',
        'DT' => '龙虎',
        'SHB' => '骰宝',
        'ROU' => '轮盘',
        'FT' => '番摊',
        'LBAC' => '竞咪百家乐',
        'ULPK' => '终极德州扑克',
        'SBAC' => '保险百家乐'
    );
    $one = isset($type_arr[$type]) ? $type_arr[$type] : 'AG电子';
    return $one;
}

// BBIN大厅
function bbin_dating($code, $type) {
    switch ($type) {
        case '3001':
            $ting = array(
                '1' => 'BB视讯',
                '2' => 'BB视讯',
                '3' => 'BB视讯',
                '6' => 'BB视讯',
                '7' => 'BB视讯',
                '23' => 'VIP厅',
                '24' => 'VIP厅',
                '25' => 'VIP厅',
                '26' => 'VIP厅',
                '27' => 'VIP厅',
                '36' => 'BB视讯',
                '37' => 'BB视讯',
                '38' => '竞眯厅',
                '39' => '竞眯厅',
                '40' => '竞眯厅',
                '41' => '竞眯厅',
                '42' => '竞眯厅',
                '43' => '竞眯厅',
                '44' => '竞眯厅',
                '101' => '竞眯厅'
            );
            break;
        case '3003':
            $ting = array(
                '1' => 'BB视讯',
                '6' => 'BB视讯'
            );
            break;
        case '3007':
            $ting = array(
                '1' => 'BB视讯',
                '4' => '竞眯厅'
            );
            break;
        case '3008':
            $ting = array(
                '1' => 'BB视讯',
                '3' => '竞眯厅',
                '4' => 'BB视讯'
            );
            break;
        default:
            $ting = array(
                '1' => 'BB视讯'
            );
            break;
    }
    return $ting[$code];
}

// BBIN游戏类型
function bbin_gameType($type) {
    $gameType = array(
        '3001' => '百家乐',
        '3002' => '二八杠',
        '3003' => '龙虎斗',
        '3005' => '三公',
        '3006' => '温州牌九',
        '3007' => '轮盘',
        '3008' => '骰宝',
        '3010' => '德州扑克',
        '3011' => '色碟',
        '3012' => '牛牛',
        '3014' => '无限21点',
        '3015' => '番摊'
    );
    return $gameType[$type];
}

// BBIN出牌
function gameResult() {
    
}