<?php

namespace app\admin\controller;

use think\Db;
use think\Request;

class Agent extends Home
{
	public function agent_list()
	{
		$txt_uid = input('txt_uid');
	    $this->assign('txt_uid', $txt_uid);
	    if (request()->isAjax()) {
	        $map = array();
	        $txt_uid && $map['id'] = $txt_uid;
	        input('username') && $map['username'] = ['like', "%" . input('username') . "%"];
	        if (input('weidenglu') == 1) {
	            $thirty_day = strtotime("-30 day");
	            $map['last_login_time'] = ['elt', $thirty_day];
	        }
	        $chagend_uids = MC('m_dk_config')->field('uid')->select();
	        $tmp_str = '';
	        foreach ($chagend_uids as $k => $v) {
	            $tmp_str .= "" . $v['uid'] . ",";
	        }

	        $tmp_str = substr($tmp_str, 0, -1);
	        input('xiugai') == 1 && $map['id'] = ['in', $tmp_str];

	        input('qq') && $map['qq'] = ['like', "%" . input('qq') . "%"];
	        input('mobile') && $map['mobile'] = ['like', "%" . input('mobile') . "%"];
	        $order = 'id desc';
	        $px_type = input('px_type');
	        if ($px_type) {
	            if ($px_type == 1) {
	                $order = 'id desc';
	            } elseif ($px_type == 2) {
	                $order = 'zj_cash desc';
	            } else {
	                $order = 'is_login desc,zj_cash desc';
	            }
	        }
	        $search_time = input('search_time');
	        if ($search_time) {
	            $start_time = strtotime(explode(' - ', $search_time)[0] . ' 00:00:00');
	            $end_time = strtotime(explode(' - ', $search_time)[1] . ' 00:00:00') + 86400;
	            $map['register_time'] = ['between', "$start_time, $end_time"];
	        }
	        $p = trim(input('page')) ? trim(input('page')) : 1;
	        $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
	        $start = ($p - 1) * $limit;
	        $list = MC('sys_user')->where("api_key != ''")->limit($start, $limit)->order($order)->select();
	        $count = MC('sys_user')->where("api_key != ''")->field('api_key')->select();

	        $tempArrCount = [];
	        foreach ($count as $key => $val) {
	        	if($val['api_key']){
	        		$tempArrCount[$key] = $val;
	        	}
	        }

	        $tempArr = [];
	        foreach ($list as $key => $val) {
	        	if($val['api_key']){
	        		$tempArr[$key] = $val;
	        	}
	        }

	        return mac_return(0, '查询成功', $list, count($list));
	    } else {
	        return view();
	    }
	}

	public function add_agent()
	{
		if (request()->isAjax()) {

			$name = input('truename');

			$find = MC('sys_user')->where(['username' => $name])->field('id,username,api_key')->find();

			if(!empty($find)){

				if(!empty($find['api_key'])) return mac_return(0, '该会员已是代理，无要再次添加');

				$api_key = md5(md5($find['username'].time().'&^%$HGqsaak123'));

				$row = MC('sys_user')->where('id','=',$find['id'])->update(['api_key' => strtolower($api_key)]);

				if($row){
					return mac_return(1, '新增成功');
				}
			}
			return mac_return(0, '没有该会员，请先注册，再来添加');
			
		}else{
			return view();
		}
	}

	public function add_acount()
	{
		if (request()->isAjax()) {

			$name = input('truename');

			$find = MC('sys_user')->where(['username' => $name])->field('id,username,api_key')->find();

			if(!empty($find)){

				if(!empty($find['api_key'])) return mac_return(0, '该会员已是代理，无要再次添加');

				$api_key = md5(md5($find['username'].time().'&^%$HGqsaak123'));

				$row = MC('sys_user')->where('id','=',$find['id'])->update(['api_key' => strtolower($api_key)]);

				if($row){
					return mac_return(1, '新增成功');
				}
			}
			return mac_return(0, '没有该会员，请先注册，再来添加');
			
		}else{
			return view();
		}
	}
}