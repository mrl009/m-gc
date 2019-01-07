<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    protected $error = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    /**
     * GET请求
     * @param string $url 请求地址
     * @param string $data 请求参数
     * @return string
     */
    public function curl_get($url,$arr=array())
    {
        $j=$url;
        if($arr != array()){
            $p='';
            foreach ($arr as $k=>$v) {$p.="$k=$v&";}
            $url.='?'.$p;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $param=array(
            'AUTHGCD: '.$this->token_encrypt($_SERVER['SERVER_NAME']),
            'AUTHGCI: '.ip2long($this->get_ip()),
            'AuthGC: ' .$_SERVER['HTTP_HOST'].';'.$this->session->userdata('token'),
            'ApiURL: ' .$this->getApiURL($j)
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER,$param);
        curl_setopt($ch, CURLOPT_TIMEOUT,26);
        curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        $errno = curl_errno($ch);
        if ($errno) {
            $this->error = curl_error($ch);
            $str = '[GET][error:cURL请求出错][url:' . $url . '][cURL连接资源信息:' .json_encode(curl_getinfo($ch)).'][cURL头部参数:' . json_encode($param) .'][cURL错误信息:'. $this->error .'][cURL错误码:'.$errno. "]" . PHP_EOL;
            $sid = $this->session->userdata('sid');
            $sid = empty($sid) ? $_SERVER['HTTP_HOST'] : $sid;
            $this->write_log($sid, $str);
            $this->error = '网络请求出错 ' . $this->error;
        }
        curl_close($ch);
        if($this->session->userdata('test')==1){
            header("Content-type:text/html;charset=utf-8");
            $aa=json_encode(array('params'=>$arr));
            $json = $url.'<br>'.json_encode($param).'<br>'.$aa.'<br>'.$data;
            file_put_contents('test/'.$this->session->userdata('admin_name').'_get.html', '<meta charset="UTF-8">'.$json);
        }
        $auth=json_decode($data,true);
        if (!empty($data) && $auth == NULL) {
            $this->error = json_last_error_msg();
            $str = '[GET][error:接口返回解析出错][url:' . $url . '][接口返回:'. $data .'][json_last_error:'.json_last_error().'|'. $this->error .'][头部参数:' .json_encode($param)."]" . PHP_EOL;
            $sid = $this->session->userdata('sid');
            $sid = empty($sid) ? $_SERVER['HTTP_HOST'] : $sid;
            $this->write_log($sid, $str);
            $this->error = '接口返回数据解析出错 ' . $this->error;
        }
        if($auth['code']=='NOAUTH'){
            echo '<script>alert("沒有操作權限1");</script>';
            exit;
        }

        return $data;
    }

    /**
     * POST请求
     * @param string $url 请求地址
     * @param string $data 请求参数
     * @return string
     */
    public function curl_post($url,$data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $param=array(
            'AUTHGCD: '.$this->token_encrypt($_SERVER['SERVER_NAME']),
            'AUTHGCI: '.ip2long($this->get_ip()),
            'AuthGC: ' .$_SERVER['HTTP_HOST'].';'.$this->session->userdata('token'),
            'ApiURL: ' .$this->getApiURL($url)
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER,$param);
        curl_setopt($ch, CURLOPT_TIMEOUT,26);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:23.0) Gecko/20100101 Firefox/23.0");

        //curl_setopt($ch, CURLOPT_REFERER, "http://www.google.ca/");
        $output = curl_exec($ch);
        $errno = curl_errno($ch);
        if ($errno) {
            $str = '[POST][error:cURL请求出错][url:' . $url . '][cURL连接资源信息:' .json_encode(curl_getinfo($ch)).'][cURL头部参数:' . json_encode($param) .'][post参数:'. json_encode($data) .'][cURL错误信息:'.curl_error($ch).'][cURL错误码:'.$errno. "]" . PHP_EOL;
            $sid = $this->session->userdata('sid');
            $sid = empty($sid) ? $_SERVER['HTTP_HOST'] : $sid;
            $this->write_log($sid, $str);
            $this->error = '网络请求出错 ' . $this->error;
        }
        curl_close($ch);
        if($this->session->userdata('test')==1){
            header("Content-type:text/html;charset=utf-8");
            $aa=json_encode(array('params'=>$data));
            $json = $url.'<br>'.json_encode($param).'<br>'.$aa.'<br>'.$output;
            file_put_contents('test/'.$this->session->userdata('admin_name').'_post.html', '<meta charset="UTF-8">'.$json);
        }
        $auth=json_decode($output,true);
        if (!empty($output) && $auth == NULL) {
            $this->error = json_last_error_msg();
            $str = '[POST][error:接口返回解析出错][url:' . $url . '][接口返回:'. $data .'][json_last_error:'.json_last_error().'|'. $this->error .'][头部参数:' .json_encode($param).'][post参数:'. json_encode($data) .']' . PHP_EOL;
            $sid = $this->session->userdata('sid');
            $sid = empty($sid) ? $_SERVER['HTTP_HOST'] : $sid;
            $this->write_log($sid, $str);
            $this->error = '接口返回数据解析出错 ' . $this->error;
        }
        if($auth['code']==='NOAUTH'){
            exit($this->status('ERROR','沒有操作權限'));
            exit;
        }

        return $output;
    }

    public function status($s='OK',$m='執行成功')
    {
        return json_encode(array('status'=>$s,'msg'=>$m));
    }
    /***验证登陆状态***/
    public function checklogin()
    {
        $arr=$this->curl_get(ADMINAPI.'ping/ping');
        $rs=json_decode($arr,true);
        if($rs['code']==600 || $rs['code']==422 || empty($this->session->userdata('token'))){
            echo '<script>alert("登陸超時，請重新登陸");setTimeout(function(){window.location.href="/login"},1000);</script>';
            exit;
        }else if($rs['code']==601){
            echo '<script>alert("您的帳號已在其他地方登陸");setTimeout(function(){window.location.href="/login"},1000);</script>';
            exit;
        }
    }
    /**
     * 获取客户端IP
     * @return string
     */
    private function get_ip()
    {
        $realip = '';
        $unknown = 'unknown';
        if (isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach($arr as $ip){
                    $ip = trim($ip);
                    if ($ip != 'unknown'){
                        $realip = $ip;
                        break;
                    }
                }
            }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
                $realip = $_SERVER['REMOTE_ADDR'];
            }else{
                $realip = $unknown;
            }
        }else{
            if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
                $realip = getenv("HTTP_CLIENT_IP");
            }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
                $realip = getenv("REMOTE_ADDR");
            }else{
                $realip = $unknown;
            }
        }
        if($realip=='::1'){
            $realip = '127.0.0.1';
        }
        $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
        return $realip;
    }
    /**
     * 加密
     * @param string $token 需要被加密的数据
     * @param string $private_key 密钥
     * @return string
     */
    public function token_encrypt($token='',$private_key='123456')
    {
        return base64_encode(openssl_encrypt($token, 'BF-CBC', md5($private_key), null, substr(md5($private_key), 0, 8)));
       
        //return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($private_key), $token, MCRYPT_MODE_CBC, md5(md5($private_key))));
    }

    public function write_log($name,$str,$path= '')
    {
        $path = APPPATH . 'logs/' . $path;
        $path = str_replace("\\", "/", $path);
        if (!is_dir($path)) mkdir($path, 0777, true);
        $file = $path . $name .'_'. date('Ym').'.log';
        $str = '['.date('Y-m-d H:i:s').'] '.' : ' .$str;
        @file_put_contents($file, $str, FILE_APPEND);
    }

    /**
     * 获取权限url
     * @param $url
     * @return mixed
     */
    private function getApiURL($url){
        $url = str_replace(array(ADMINAPI),"",$url);
        $flag = strpos($url, '?');
        if ($flag) {
            $url = substr($url, 0, $flag);
        }
        return $url;
    }
}
