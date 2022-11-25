<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Session;
use think\Model;
use think\Db;

class Index extends Model
{
	protected $table = 'xd_admin';

	// 密码判断
	public function get_password($password, $verify = '')
    {
        $pwd             = array();
        $pwd['verify']  = $verify;
        $pwd['password'] = md5(md5(trim($password)) . $pwd['verify']);
        return $pwd['password'];
    }
    // 随机生成字符串
    public function rand_str($length)
    {
		$chars=array_merge(range('a','z'),range('A','Z'),range(1,9));
		$rand_keys=array_rand($chars,$length);
		shuffle($rand_keys);
		foreach($rand_keys as $key){
		$str[] = $chars[$key]; 
		}
		return implode($str);
    }
  function ip() {

    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif($_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}
   public function login_log()
    {
		$arr=array(
           'admin_id'=>session('admin_id'),
          'admin_name'=>session('admin_user'),
          'ip'=>$this->ip(),
          'createtime'=>time(),
        );
     Db::name('admin_login_log')->insert($arr);
    }
  public function operate_log($info)
    {
		$arr=array(
           'admin_id'=>session('admin_id'),
          'admin_name'=>session('admin_user'),
          'info'=>$info,
          'ip'=>$this->ip(),
          'createtime'=>time(),
        );
     Db::name('operate_log')->insert($arr);
    }
}