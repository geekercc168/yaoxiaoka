<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\pc\controller;

use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    private $redis;//redis 资源
    private $timeout = 3600; //redis缓存时间 默认一个小时
    public $uid;//当前登录会员的id

    //公共方法
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        //控制样式
        //$this->ViewStyle();
        //底部信息
        $this->FooterInfo();
        //会员信息
        $this->is_login();

        $this->setHeader();

    }

    //当前控制器 方法
    public function ViewStyle()
    {
        $request = Request::instance();
        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        $arr = [];
        if ($controller == 'Login' && $action == 'yhxy') {
            $arr = ['yhxy'];
        } else {
            $arr = ['index'];
        }
        $this->assign('ViewStyle', $arr);
    }

    //会员信息
    public function is_login()
    {

        //当前登录用户
        $uinfo = session::get('uinfo')?:'';

        if ($uinfo) {
            $is_login=GetRedis('is_login'.$uinfo['id']);
            if ($is_login==99) {
                session::set('uinfo',null);
            }else{
                session::set('uinfo', $uinfo);//再次赋值防止过期
            }
            if($is_login === false){
              
                $this->redirect('/sign/in');
            }
        } else {
            //用户没有登录
            session::set('uid', null);//代表没有登录
            session::set('uinfo', null);//代表没有登录
            $request = Request();
            $url = $request->url();
            //如果是ajax请求的直接返回错误
            if($request->isAjax()){
                return mac_return(0,'用户未登录');
            }else{
                //缓存当前跳转模块
                session::set('gourl', '/'.$url);
                //二级窗口跳转不美观，直接弹出提示
               // echo "<script>alert('用户未登录或已过期!');history.back();</script>"; die;
//                if ($request->controller() == 'User') {
//
//                    session::set('gourl', $url);
//                    //跳转至登录页面
                    $this->redirect('/sign/in');
//                }
            }
        }

        $this->assign('uid', $uinfo['id']);
    }

    //底部信息
    public function FooterInfo()
    {
        //底部友情链接
//        $link_list=Db::name('plug_link')->field('plug_link_name,plug_link_url,plug_link_target')->select();
//        session('pc_link_list',$link_list);
//        //底部的关于我们
//        $about_info_list = session('pc_about_info');
//        if(!$about_info_list){
//            $about_info=Db::name('options')->field('option_value')->where(array('option_name'=>'site_optionss'))->find();
//            $about_info_list = str_replace('null', '""', $about_info);
//            $about_info_list = json_decode($about_info_list['option_value'],true);
//            session('pc_about_info',$about_info_list);
//        }
//        //当前会员是否登录
//        //dump($about_info);die;
//        $this->assign('link_list',$link_list);//部友情链接
//        $this->assign('about_info',$about_info_list);//关于我们
    }


    protected function setHeader()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
        $userinfo = session::get('uinfo');
        //用户组权限
        $user_menu = MC('sys_menu_item')->cache(false)->where('1=1')->select();
        $arr_k = [];
        foreach ($user_menu as $k => $v) {
            $temp[$v['submenu_id']][$k] = $v;
            if (!in_array($v['submenu_id'], $arr_k)) {
                $arr_k[] = $v['submenu_id'];
            }
        }
        $menu = MC('sys_menu')->cache(false)->where(['status' => 1, 'submenu_id' => ['in', $arr_k]])->order('listorder asc')->select();
        foreach ($menu as $k => $v) {
            $menu[$k]['erji'] = $temp[$v['submenu_id']];
        }
        $this->assign('list', $menu);
    }

}