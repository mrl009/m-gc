<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//$config['soap']  ='http://114.215.209.224:8088/';
//$config['soap_header']='http://168zght.com/webservices/';
$config['max_wechat_site']=5;

/*
type类型
view: 打开网页
click: 点击菜单事件
scancode_waitmsg: 扫码带提示
scancode_push: 扫码推事件
pic_sysphoto: 系统拍照发图
pic_photo_or_album: 拍照或者相册发图
pic_weixin: 微信相册发图
location_select： 发送位置
*/
$config['system_modules'] = array(
	array(
		'name' => '会员中心',
		'type' => 'view',
		'url'  => str_replace('/admin/','/wechat',WEB).'/customer?sn={SN}',
		'key'  => '',
		'tag'  => 'MEMBER',
	),
	array(
		'name' => '我的订单',
		'type' => 'view',
		'url'  => str_replace('/admin/','/wechat',WEB).'/customer/myorder?sn={SN}',
		'key'  => '',
		'tag'  => 'MEMBER',
	),
	array(
		'name' => '购物车',
		'type' => 'view',
		'url'  => str_replace('/admin/','/wechat',WEB).'/customer/cart?sn={SN}',
		'key'  => '',
		'tag'  => 'MEMBER',
	),
	array(
		'name' => '商城',
		'type' => 'view',
		'url'  => str_replace('/admin/','/wechat',WEB).'/mall?sn={SN}',
		'key'  => '',
		'tag'  => 'MALL',
	),
	array(
		'name' => '附近站点',
		'type' => 'location_select',
		'url'  => '',
		'key'  => 'NEARBYSTATION',
		'tag'  => 'NEARSTATION',
	),
	array(
		'name' => '签到',
		'type' => 'click',
		'url'  => '',
		'key'  => 'CHECKIN',
		'tag'  => 'CHECKIN',
	),
);