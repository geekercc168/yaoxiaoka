<?php
namespace app\admin\model;

use think\Model;
use think\Session;

class MenuModel extends Model
{
	protected $table = 'sys_menu';

	// 左边菜单
	public function menu()
	{
	    $userinfo=session::get('user_info');

		if ($userinfo['group_id']==1) {
		    //用户组权限
            $user_menu=Db('menu_item')->where('1=1')->select();
		}else{
            $userinfo['group_id']=$userinfo['group_id']?:0;
            $user_group=Db('user_group')->where("group_id=".$userinfo['group_id']."")->value('group_roles');
            $user_menu=Db('menu_item')->where('resource_id','in',$user_group)->order('listorder asc')->select();
		}
        $arr_k=[];
		foreach($user_menu as $k=>$v){

            $temp[$v['submenu_id']][$k] = $v;
            if(!in_array($v['submenu_id'],$arr_k)){
                $arr_k[]=$v['submenu_id'];
            }
        }
		$menu=Db('menu')->where(['status'=>1,'submenu_id'=>['in',$arr_k]])->order('listorder asc')->select();
		foreach($menu as $k=>$v){
            $menu[$k]['erji']=$temp[$v['submenu_id']];
        }
		return $menu;
	}
	// 超级管理员菜单设置里边
	public function ajax_menu_list()
	{
		$menu = db('auth_rule')->where('level != 4')->order('id asc')->select();
		return $menu;
	}
	// 代理后台菜单设置里边
	public function agency_menu_list()
	{
		$menu = db('agency_auth_rule')->where('level != 4')->order('id asc')->select();
		return $menu;
	}
	// 设置权限的时候
	public function ajax_menu_qx()
	{
		$menu = db('auth_rule')->where('pid=0 AND status=1')->order('id desc')->select();
		foreach ($menu as $k => $v) {
			$menu[$k]['erji'] = db('auth_rule')->where('pid='.$menu[$k]['id'].' and status=1')->order('id desc')->select();
		}
		return $menu;
	}
}