<?php

namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;

class Home extends Controller
{
  	protected $is_admin;

	public function __construct()
	{
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    	header('Access-Control-Allow-Methods:*');  
		header('Access-Control-Allow-Credentials:false');
        $request = Request::instance();
//        set_time_limit(240);
        //session('login_type',0);//登录状态
 		$login_type = Session::get('login_type');

		if ($login_type != 1) {
			//$this->error('登录信息已过期，请重新登录！！');die;
            echo "<script>alert('登录信息已过期，请重新登录！！！');parent.location.href='/admin/index/index'</script>";
		}else{
            session('login_type',1);//登录状态
        }
        $admin=session::get('user_info');

		$this->is_admin = $admin['group_id'];
		if ($this->is_admin != 1) {
			$login_qx = session::get('login_qx');
			$url = $request->module().'/'.$request->controller().'/'.$request->action();
			//该角色未获取的权限
            $menu = db('menu_item')->query('select group_concat(resource_id) as menu_ids from sys_menu_item where resource_id not in ('.$login_qx.')');
            //禁止进入的模块id
            $danger=explode(',',$menu[0]['menu_ids']);
			//进入模块的权限id
            $meun_id=db('menu_item')->order('listorder')->where(['resource_url'=>$url])->value('resource_id');
          	if (in_array($meun_id,$danger)) {
                echo "<script>alert('没有权限访问！！！');</script>";die;
				//$this->error('没有权限访问。');
			}
		}

	}
  
  
  
    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
    //中文转阿拉伯
    function chrtonum($str)
    {
        $map = array(
            '一' => '1', '二' => '2', '三' => '3', '四' => '4', '五' => '5', '六' => '6', '七' => '7', '八' => '8', '九' => '9',
            '壹' => '1', '贰' => '2', '叁' => '3', '肆' => '4', '伍' => '5', '陆' => '6', '柒' => '7', '捌' => '8', '玖' => '9',
            '零' => '0', '两' => '2',
            '仟' => '千', '佰' => '百', '拾' => '十',
            '万万' => '亿',
        );

        $str = str_replace(array_keys($map), array_values($map), $str);
        $str = $this->checkString($str, '/([\d亿万千百十]+)/u');

        $func_c2i = function ($str, $plus = false) use (&$func_c2i) {
            if (false === $plus) {
                $plus = array('亿' => 100000000, '万' => 10000, '千' => 1000, '百' => 100, '十' => 10);
            }
            $i = 0;
            if ($plus) {
                foreach ($plus as $k => $v) {
                    $i++;
                    if (strpos($str, $k) !== false) {
                        $ex = explode($k, $str, 2);
                        $new_plus = array_slice($plus, $i, null, true);
                        $l = $func_c2i($ex[0], $new_plus);
                        $r = $func_c2i($ex[1], $new_plus);
                        if ($l == 0) {
                            $l = 1;
                        }

                        return $l * $v + $r;
                    }
                }
            }
            return (int)$str;
        };
        return $func_c2i($str);
    }

    function checkString($var, $check = '', $default = '')
    {
        if (!is_string($var)) {
            if (is_numeric($var)) {
                $var = (string)$var;
            } else {
                return $default;
            }
        }
        if ($check) {
            return (preg_match($check, $var, $ret) ? $ret[1] : $default);
        }

        return $var;
    }
}