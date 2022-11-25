<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\pc\controller;

use think\MC;
// use think\Request;
use think\Session;

class Menu extends Base
{
    public function _initialize()
	{
		parent::_initialize();
    }
    /**
     * 前台首页海报设置
     */
    public function menu()
    {
        $userinfo=session::get('user_info');
        if ($userinfo['group_id']==1) {
            //用户组权限
            $user_menu=MC('menu_item')->where('1=1')->select();
        }else{
            $userinfo['group_id']=$userinfo['group_id']?:0;
            $user_group=MC('user_group')->where("group_id=".$userinfo['group_id']."")->value('group_roles');
            $user_menu=MC('menu_item')->where('resource_id','in',$user_group)->order('listorder asc')->select();
        }
        $arr_k=[];
        foreach($user_menu as $k=>$v){

            $temp[$v['submenu_id']][$k] = $v;
            if(!in_array($v['submenu_id'],$arr_k)){
                $arr_k[]=$v['submenu_id'];
            }
        }
        $menu=MC('menu')->where(['status'=>1,'submenu_id'=>['in',$arr_k]])->order('listorder asc')->select();
        foreach($menu as $k=>$v){
            $menu[$k]['erji']=$temp[$v['submenu_id']];
        }
        return $menu;
    }

}



