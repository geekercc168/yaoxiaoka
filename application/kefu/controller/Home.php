<?php

namespace app\kefu\controller;

use think\Controller;
use think\Session;
use think\Request;

class Home extends Controller
{
    protected $kfdb;

    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Credentials:false');
        $yxk = input('yxk_key') ?: session('yxk_key');
        $jjf = input('jjf_key') ?: session('jjf_key');
        if (isset($yxk) && $yxk == YXK_KEFU_KEY) {
            //要销卡的手机客服
            $db = 'db2';
            $kefu = 'jjf';
            session('yxk_key', $yxk);
        }
        if (isset($jjf) && $jjf == JJF_KEFU_KEY) {
            //集集付的手机客服
            $db = 'db3';
            $kefu = 'yxk';
            session('jjf_key', $jjf);
        }
        if (!$db) {
            Session::clear();
            die('密钥错误！非客服人员请勿进入！！');
            //mac_return(0, '密钥错误！非客服人员请勿进入！！');
        } else {
            session('kfdb', $db);
            session('kefu', $kefu);
        }


        $request = Request::instance();
        //dy($request->module().'/'.$request->controller().'/'.$request->action());
        $kfdb = Session::get('kfdb');
        $allow = ['index'];

        if (!in_array($request->action(), $allow)) {
            if (!$kfdb) {
                echo "密钥已过期，请重新携带密钥进入！！！";die;
            } else {
                session('kfdb', $kfdb);//登录状态
            }
        }


    }
}