<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\pc\controller;

use think\Db;
use think\Request;
use think\Session;

import('lib.global_arr', EXTEND_PATH);
class User extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 个人中心  首页
     * */
    public function index()
    {
        return $this->fetch();
    }
    public function profile(){
        $uid = session::get('uinfo.id');
        $uinfo=MC('sys_user')->where(['id'=>$uid])->find();
        $is_truename = is_truename($uinfo['id']);
        $this->assign('is_truename', $is_truename);
        $this->assign('uinfo', $uinfo);
        return $this->fetch();
    }
    
    public function show_status()
    {
        $uinfo['id'] = session::get('uinfo.id');

        $today_where=" and on_time>=".(strtotime(date('Y-m-d',time())."0:0:0")) ."  and uid=".$uinfo['id'];
        //今日成功笔数，面额，结算额
        $data=array();

        $tmpa = reback_status(0,$uinfo['id']);
        $data['t_jy_cg'] = $tmpa['t_jy_cg'];
        $data['t_jy_ds'] = $tmpa['t_jy_ds'];
        $data['t_jy_sb'] = $tmpa['t_jy_sb'];

        $yestoday_where=" and on_time<=".(strtotime(date('Y-m-d',time())."0:0:0")) ." and on_time>=".((strtotime(date('Y-m-d',time())."0:0:0"))-86400) ."  and uid=".$uinfo['id'];
        //昨日成功笔数，面额，结算额
        $tmp = reback_status(1,$uinfo['id']);
        $data['z_jy_cg'] = $tmp['z_jy_cg'];
        $data['z_jy_ds'] = $tmp['z_jy_ds'];
        $data['z_jy_sb'] = $tmp['z_jy_sb'];
        
        //今日提现笔数，提现总额
        $data['t_tx_res']=MC('tixian_log')->field('count(id) tx_bishu,cast(sum(cash) as decimal(10,2)) tx_cash ')->where("status=1 and create_time>=".(strtotime(date('Y-m-d',time())."0:0:0")) ."  and uid=".$uinfo[id])->find();
        //昨日提现笔数，提现总额
        $data['z_tx_res']=MC('tixian_log')->field('count(id) tx_bishu,cast(sum(cash) as decimal(10,2)) tx_cash')->where("status=1 and create_time<=".(strtotime(date('Y-m-d',time())."0:0:0")) ." and create_time>=".((strtotime(date('Y-m-d',time())."0:0:0"))-86400) ."  and uid=".$uinfo['id'])->find();

        $this->assign('data',$data);
        return $this->fetch();
    }

    public function info()
    {

        $uid = session::get('uinfo.id');
        $uinfo=MC('sys_user')->where(['id'=>$uid])->find();
        $is_truename = is_truename($uinfo['id']);
        $uinfo['email'] ? $email=1 : $email=0;
        $uinfo['tx_pwd'] ? $tx_pwd=1 : $tx_pwd=0;
        $bl=number_format(($is_truename+$email+$tx_pwd)/3,2)*100;
        $this->assign('bl', $bl);
        $this->assign('is_truename', $is_truename);
        $this->assign('uinfo', $uinfo);
        
        $notice_list['list']=get_index_notice(3);

        foreach ($notice_list['list'] as $k=>$v){
            $notice_list['list'][$k]['time1']=  date('m-d',$v['pub_time']);
            $notice_list['list'][$k]['time2']=date('H:i',$v['pub_time']);
        }
        //dy($notice_list['list'][0]);
        $this->assign('notice', $notice_list['list']);
        $this->assign('notice_one', $notice_list['list'][0]);
        
        return $this->fetch();
    }
    
    //基本资料
    public function  basic(){
        $uid = session::get('uinfo.id');
        $uinfo=MC('sys_user')->where(['id'=>$uid])->find();
        $this->assign('uinfo', $uinfo);
        return view();
    }

    /**
     * 修改个人信息
     * */
    public function UpdateUserInfo()
    {
        if (Request::instance()->isAjax()) {
            $uid = $this->uid;
            //修改参数
            $update = [];
            $update['member_list_sex'] = input('sex');
            $update['user_introduce'] = input('introduce');
            $update['member_list_nickname'] = input('nickname');
            if (!empty($update)) {
                $re = Db::name('member_list')->where(array('member_list_id' => $uid))->update($update);
                if ($re) {
                    $data['code'] = 200;
                    $data['msg'] = '修改成功';
                } else {
                    $data['code'] = 1001;
                    $data['msg'] = '信息没有变化或者网络错误';
                }
            } else {
                $data['code'] = '1003';
                $data['msg'] = '请输入修改的信息';
            }
            return json($data);
        }
    }

    /**
     * 联系客服
     */
    public function service()
    {
        $poster_data = Db::name('contact')->field('*')->select();
        //seo
        $this->UserSeo('联系客服');
        //控制导航的样式
        $this->assign('user_nav', 'service');
        $this->assign('list', $poster_data);
        //dump($poster_data);die;
        return $this->fetch();
    }
    public function auth_name()
    {
        $uinfo = session('uinfo');
        $res = MC('truename_auth')->cache('truename_auth_uid_'. $uinfo['id'])->where("uid = '" . $uinfo['id'] . "'")->find();
        $is_bank = MC('member_bank')->where(['uid' => $uinfo['id']])->find();
        $this->assign('is_bank', $is_bank);
        $this->assign('res', $res);
        $this->assign('is_mobile', is_mobile()?1:0);
        if (Request()->isPost()) {
            $txt_card = input('txt_card');
            $truename = input('truename');
            //$user_res =MC('truename_auth')->where("idcard = '".$txt_card."'")->find();
            //取消一个身份证只验证一次
            if (1 == 1) {
                if ($this->isIdCard($txt_card)) {
                    //查询实名认证表是否存在该用户的认证信息
                    $update_arr = array(
                        'truename' => $truename,
                        'idcard' => $txt_card,
                        'status' => 0,
                        'on_time' => time(),
                    );
                    $tx_config=MC('tx_config')->find();
                    if($tx_config['need_face']!=1){
                        $update_arr['status']=1;
                        $msg='实名登记成功！';
                        //自动审核通过
                        $update_uarr = array(
                            'truename' => $truename,
                            'idcard' => $txt_card
                        );
                        MC('sys_user')->where(['id' => $uinfo['id']])->update($update_uarr);
                    }else{
                        MC('truename_auth')->where(['uid' => $uinfo['id']])->update(['zfb_key'=>'']);
                        $msg='实名登记成功，请进行扫码人脸识别！';
                        MC('truename_auth')->cache('truename_auth_uid_'. $uinfo['id'])->where(['uid' => $uinfo['id']])->update(['zfb_key'=>'']);
                    }
                    if ($res) {
                        $sql = MC('truename_auth')->where(['uid' => $uinfo['id']])->update($update_arr);
                        MC('truename_auth')->cache('truename_auth_uid_'. $uinfo['id'])->where(['uid' => $uinfo['id']])->update($update_arr);
                    } else {
                        $update_arr['uid'] = $uinfo['id'];
                        $sql = MC('truename_auth')->insert($update_arr);
                        MC('truename_auth')->cache('truename_auth_uid_'. $uinfo['id'])->where(['uid' => $uinfo['id']])->update($update_arr);
                    }
                    return mac_return(1, $msg,['status'=>$update_arr['status']]);

                } else {
                    return mac_return(0, '输入的身份证不合规范');
                }
            } else {
                return mac_return(0, '输入的身份证已存在');
            }
        }
        //该用户是否有银行卡
//        if (!$is_bank) {
//            $this->redirect('pc/Tixian/bank');
//        }
        return view();
    }
    //变更实名登记，注销当前账号并生成新账号，并验证当前账号是否已变更超过3次
    public function update_truename(){
        $uinfo = session('uinfo');
        $uid=intval($uinfo['id']);
        $res = MC('truename_auth')->where("status=1 and uid = '" . $uid . "'")->find();
        if($res){
            $uinfo=MC('sys_user')->where(['id'=>$uid])->find();
            $user_count=MC('sys_user')->where(['username'=>['like', "%".$uinfo['username']."%"],'is_del'=>1])->count();
            if($user_count<=3){
                $insert_arr = array(
                    'username' => $uinfo['username'],
                    'password' => $uinfo['password'],
                    'qq' => $uinfo['qq'],
                    'email' => $uinfo['email'],
                    'zj_cash' => $uinfo['zj_cash'],
                    'mobile' => $uinfo['mobile'],
                    'is_mobile_auth' => 1,
                    'last_login_ip' => request()->ip(),
                    'register_ip' => request()->ip(),
                    'last_login_time' => time(),
                    'register_time' => time(),
                    'group_id' => 1
                );
                $res=MC('sys_user')->insertGetId($insert_arr);
                if($res>0){
                    MC('sys_user')->where(['id'=>$uid])->update(['zj_cash'=>0,'group_id'=>0,'is_del'=>1,'username'=>$uinfo['username'].'['.rand(10,99).']']);
                    //增加金额转移明细
                    $fina_array =array(
                        'cash'=>$uinfo['zj_cash'],
                        'action'=>'实名变更',
                        'on_time'=>time(),
                        'new_cash'=>0,
                        'pingtailirun'=>0,
                        'ext'=>3
                    );
                    $fina_array['uid']=$uinfo['id'];
                    $fina_array['old_cash']=$uinfo['zj_cash'];
                    $fina_array['new_cash']=0;
                    $fina_array['orderid']=$res;
                    MC('finance')->insert($fina_array);

                    $fina_array['uid']=$res;
                    $fina_array['old_cash']=0;
                    $fina_array['new_cash']=$uinfo['zj_cash'];
                    $fina_array['orderid']=$uinfo['id'];
                    MC('finance')->insert($fina_array);
                    //清除session,跳转到登录页面
                    session::Clear();
                    return mac_return(1, '操作成功，请重新登录！');
                }
            }else{
                return mac_return(0, '该账户实名变更已超过3次，无法继续变更，请注册新账户！');
            }
        }else{
            return mac_return(0, '用户未进行实名');
        }
    }

    public function isIdCard($number)
    {
        $sigma = '';
        //加权因子
        $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码串
        $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        //按顺序循环处理前17位
        for ($i = 0; $i < 17; $i++) {
            //提取前17位的其中一位，并将变量类型转为实数
            $b = (int)$number{$i};
            //提取相应的加权因子
            $w = $wi[$i];
            //把从身份证号码中提取的一位数字和加权因子相乘，并累加 得到身份证前17位的乘机的和
            $sigma += $b * $w;
        }
        //echo $sigma;die;
        //计算序号  用得到的乘机模11 取余数
        $snumber = $sigma % 11;
        //按照序号从校验码串中提取相应的余数来验证最后一位。
        $check_number = $ai[$snumber];
        if ($number{17} == $check_number) {
            return true;
        } else {
            return false;
        }
    }

    //销卡订单
    public function orders()
    {
        $type_arr = \global_arr::type_arr();
        $fenzu_arr = \global_arr::fenzu_arr();
        $tongdao_arr = \global_arr::tongdao_arr();
        $this->assign('type_arr', $type_arr);
        $this->assign('tongdao_arr', $tongdao_arr);
        $this->assign('fenzu_arr', $fenzu_arr);
        $this->assign('txt_pici', input('txt_pici'));
        $this->assign('selresult', input('selresult'));
        $this->assign('search_time', input('search_time')?:(date('Y-m-d',time()).' 00:00:00 - '.date('Y-m-d H:i:s',time())));
        if(request()->isAjax()){
            $parm = input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $parm['txt_uid']=session('uinfo.id');
            $parm['pc']=1;
            $res = get_orders($parm);
            return mac_return(0, '查询成功', $res['list'], $res['count'], $res['tj']);
        }
        if(is_mobile()){
            return view('m_orders');
        }
        return view();
    }
    //数据统计
    public function  statistics(){
        if(request()->isAjax()) {
            $parm=input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $parm['txt_uid']=session('uinfo.id');
            return get_statistics($parm);
        }else{
            $tongdao_arr=\global_arr::tongdao_arr();
            $type_arr=\global_arr::type_arr();
            $this->assign('tongdao_arr',$tongdao_arr);
            $this->assign('type_arr',$type_arr);
            return view();
        }
    }
    //批次统计
    public function pici(){
        if(request()->isAjax()) {
            $parm=input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $parm['txt_uid']=session('uinfo.id');
            $res=get_pici($parm);
            echo json_encode($res,true);die;
        }else{
            $tongdao_arr=\global_arr::tongdao_arr();
            $type_arr=\global_arr::type_arr();
            $this->assign('tongdao_arr',$tongdao_arr);
            $this->assign('type_arr',$type_arr);
            return view();
        }
    }

    //修改密码-登录密码和提现密码
    public function setpwd(){
        $type=input('type')?:1;//1修改登录，2修改提现密码
        $this->assign('type',$type);
        if (Request::instance()->isAjax()) {
            $uinfo=session('uinfo');
            check_code(input('telcode'),$uinfo['mobile'],$type==1?5:6);
            $txt_newpwd=input('txt_newpwd');
            if(!$txt_newpwd || !input('txt_relpwd')){
                mac_return('0','密码不能为空');
            }
            if($txt_newpwd!=input('txt_relpwd')){
                mac_return('0','两次密码输入不一致');
            }
            //验证通过开始修改密码
            if($type==1){
                $up_arr['password']= jaja_md5($uinfo['username'],trim($txt_newpwd));
                MC('sys_user')->where(['id'=>$uinfo['id']])->update($up_arr);
            }else{
                $up_arr['tx_pwd']=md5($txt_newpwd.PWD_JJF);
                MC('sys_user')->where(['id'=>$uinfo['id']])->update($up_arr);
            }
            mac_return();
        }else{
            return view();
        }
    }
    //账户注销
    //public function
    //用户登录日志
    public function login_log()
    {
        if (request()->isAjax()) {
            $map = array();
            $map['uid'] = session('uinfo.id');
            $order = 'id desc';
            $search_time = input('search_time');
            if ($search_time) {
                $start_time = strtotime(explode(' - ', $search_time)[0] . ' 00:00:00');
                $end_time = strtotime(explode(' - ', $search_time)[1] . ' 00:00:00') + 86400;
                $map['login_time'] = ['between', "$start_time, $end_time"];
            }
            $p = trim(input('page')) ? trim(input('page')) : 1;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
            $start = ($p - 1) * $limit;
            $list = MC('login_log')->alias('a')->join('sys_user b', 'a.uid=b.id', 'left')->field('a.*,b.username,b.truename')->where($map)->limit($start, $limit)->order($order)->select();
            $count = MC('login_log')->where($map)->count();
            return mac_return(0, '查询成功', $list, $count);
        } else {
            return view();
        }
    }

}