<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;

class Ajax
{
	/*
     * 返回行政区域json字符串
     */
	public function getRegion()
	{
		$map['parentid']=input('pid');
	//	$map['type']=input('type');
		$list=Db::name("area")->where($map)->select();
		return json($list);
	}
	/*
     * 返回模块下控制器json字符串
     */
	public function getController()
	{
		$module=input('request_module','admin');
		$list=\ReadClass::readDir(APP_PATH . $module. DS .'controller');
		return json($list);
	}
	//返回二级分类
	public function getCate()
	{
		$map['p_id']=input('pid');
		$map['checks_id']=1;
		//	$map['type']=input('type');
		$list=Db::name("cate")->where($map)->select();
		return json($list);
	}
}