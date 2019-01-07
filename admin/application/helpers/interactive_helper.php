<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 仿TP 获取输入参数 支持过滤和默认值
*使用方法: 和TP一致
*/
if(!function_exists('input'))
{
    function input($name='',$default='',$filter=null)
    {
        if (!empty($name) && (strpos($name,'.')))
        {
            list($method,$name) = explode('.',$name,2);
        } else {
            $method = 'param';
        }
        //参数方式 
        $input = [];
        $method = strtolower($method);
        if ('get' == $method) $input = & $_GET;
        if ('post' == $method) $input = & $_POST;
        if ('param' == $method)
        {
            $m = $_SERVER['REQUEST_METHOD'];
            if ('POST' == $m) 
            {
               $input = $_POST; 
            } elseif ('PUT' == $m) {
                parse_str(file_get_contents('php://input'), $input);
            } else {
                $input = $_GET;
            }
            unset($m);
        }
        if ('request' == $method) $input =& $_REQUEST; 
        if ('session' == $method) $input =& $_SESSION; 
        if ('cookie' == $method) $input =& $_COOKIE; 
        if ('server' == $method) $input =& $_SERVER; 
        if ('globals' == $method) $input =& $GLOBALS; 
        // 获取全部变量
        if(empty($name))
        {
            $data = $input; 
            $filters = !empty($filter) ? $filter : 'htmlspecialchars';
            if($filters)
            {
                $filters = explode(',',$filters);
                foreach($filters as $filter)
                {
                    $data = array_map_recursive($filter,$data); 
                }
            }
        // 取值操作
        } elseif(isset($input[$name])){
            $data = $input[$name];
            $filters = !empty($filter) ? $filter : 'htmlspecialchars';
            if($filters)
            {
                $filters = explode(',',$filters);
                foreach($filters as $filter)
                {
                    if(function_exists($filter))
                    {
                        $data = is_array($data) ? array_map_recursive($filter,$data) : $filter($data);
                    } else {
                        $data = filter_var($data,is_int($filter) ? $filter : filter_id($filter));
                        if(false === $data) {
                            return isset($default) ? $default : NULL;
                        }
                    }
                }
            }
        } else {
            $data = isset($default) ? $default : NULL;
        }
        return $data;
    }
}

function array_map_recursive($filter, $data) 
{
    $result = array();
    foreach ($data as $key => $val) {
        $result[$key] = is_array($val)
         ? array_map_recursive($filter, $val)
         : call_user_func($filter, $val);
    }
    return $result;
}
