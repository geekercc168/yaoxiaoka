<?php

namespace app\admin\controller;

use think\Request;
use think\Session;

import('lib.global_arr', EXTEND_PATH);

class Member extends Home
{
    //用户列表
    public function member_list()
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
            $list = MC('sys_user')->where($map)->limit($start, $limit)->order($order)->select();
            $count = MC('sys_user')->where($map)->count();
            return mac_return(0, '查询成功', $list, $count);
        } else {
            return view();
        }
    }

    //用户状态
    public function member_del()
    {
        if (Request::instance()->isAjax()) {
            $do = input('do');
            $ids = input('post.id');
            $code = 1;
            $msg = '';
            $type = intval(input('type'));
            if ($do == 'is_del') {//注销
                $rs = ['is_del' => $type];

            }
            if ($do == 'dongjie') {//冻结
                $rs = ['group_id' => $type];
            }
            if ($do == 'qiangti') {//强踢
                // $rs = ['is_login' => $type];
                DelRedis('is_login'.intval($ids));
                // SetRedis('is_login'.$ids,$type);
                $dataArray =array(
                    'is_login'=>0
                );
                $res = MC('sys_user')->where(['id' => ['in', $ids]])->update($dataArray);
               return mac_return($code, $msg);
            }
            if ($do == 'linshi') {//授权
                $rs = ['is_linshi' => $type];

            }
            if ($do == 'tixian') {//提现
                $rs = ['is_tixian' => $type];

            }
            $res = MC('sys_user')->where(['id' => ['in', $ids]])->update($rs);
            if (!$res) {
                $code = 0;
            }
            return mac_return($code, $msg);
        }
    }

    //会员用户编辑
    public function add_member()
    {
        $id = intval(input('id'));
        if (request()->isPost()) {
            $filed = array('uid', 'password', 'tx_pwd', 'truename','mobile');//允许通过的字段
            $parm = input();
            if (intval($parm['uid']) >= 0) {
                //md5($txt_txpwd.'jijipay!@#')
                foreach ($parm as $k => $v) {
                    if (!in_array($k, $filed)) {
                        unset($parm[$k]);
                    };
                }
                $parm['tx_pwd'] && $parm['tx_pwd'] = md5($parm['tx_pwd'] . 'jijipay!@#');
                
                $parm = array_filter($parm);
                if ($id > 0) {
                    //更新了新用户名需要同步银行卡名称
                    if($parm['truename']){
                        MC('member_bank')->where(['uid'=>$id])->update(['bank_name'=>$parm['truename']]);
                    }
                    $row = MC('sys_user')->field('username')->where('id=' . $id . '')->find();
                    $parm['password'] && $parm['password'] = jaja_md5($row['username'],trim($parm['password']));
                    MC('sys_user')->where('id=' . $id . '')->update($parm);
                    return mac_return();
                } else {
                    MC('sys_user')->insert($parm);
                    return mac_return();

                }
            } else {
                return mac_return(0, '用户id异常');
            }
        } else {
            if ($id) {
                $item = MC('sys_user')->field('truename,id,mobile')->where("id=$id")->find();
                $this->assign('item', $item);
            }
            return view();
        }
    }
    //编辑个人费率
    public function user_profit()
    {
        $uid=input('uid');
        $this->assign('uid',$uid);
        $info=MC('m_dk_config')->where("uid=".$uid)->find();
        if (request()->isPost()) {
            $update_arr=[];
            $dk_id=input('dk_id');//卡种
            $profit=number_format(input('profit'),2,'.','');
            if($profit<30 || $profit>100){
                return mac_return(0,'费率设置错误');
            }
            $update_arr['type'.$dk_id]=$profit;
            if($info){
                $res=MC('m_dk_config')->where(['uid'=>$uid])->update($update_arr);
            }else{
                $update_arr['uid']=$uid;
                $res=MC('m_dk_config')->insert($update_arr);
            }
            if ($res) {
                return mac_return();
            } else {
                return mac_return(0);
            }
        }else{
            $list=MC('dk_list')->field('*')->where('isanyrate!=1')->order('listorder asc,id desc')->select();


            foreach ($list as $k=>$v){
                $list[$k]['user_profit']=$info[type.$v['id']];
            }
            $this->assign('list',$list);
            $this->assign('info',$info);
            return view();
        }
    }
    //实名审核
    public function truename_auth()
    {
        //$status_arr=parent::global_arr();
        if (request()->isAjax()) {
            $map = array();
            if (input('search_name')) {
                $map['uid|truename'] = array('like', "%" . input('search_name') . "%");
            }
            if (input('status') && input('status') != 'all') {
                $map['status'] = input('status');
            }
            $p = trim(input('page')) ? trim(input('page')) : 1;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
            $start = ($p - 1) * $limit;
            $list = MC('truename_auth')->where($map)->order('id desc')->limit($start, $limit)->select();


            $count = MC('truename_auth')->where($map)->count();
            return mac_return(0, '查询成功', $list, $count);
        } else {
            $status_arr = \global_arr::status_arr();
            $this->assign('status_arr', $status_arr);
            return view();
        }
    }

    //审核实名认证
    public function truename_status()
    {
        if (request()->isPost()) {
            $id = intval(input('id'));
            $parm['status'] = input('status');
            $parm['chuli_desc'] = input('chuli_desc');
            $sql = MC('truename_auth')->where(['id' => $id])->update($parm);
            if ($sql) {
                MC('sys_user')->where(['id' => intval(input('uid'))])->update(['is_truename_auth' => $parm['status']]);
                return mac_return();
            } else {
                return mac_return(0);
            }
        } else {
            return mac_return(0);
        }
    }

    //用户登录日志
    public function login_log()
    {
        if (request()->isAjax()) {
            $map = array();
            input('uid') && $map['uid'] = input('uid');
            input('ip') && $map['ip'] = input('ip');
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

    //订单查询
    public function orders()
    {
        $api = input('api');
        $this->assign('api', $api);
        $this->assign('group_id', Session::get('user_info')['group_id']);
        $type_arr = \global_arr::type_arr();
        $fenzu_arr = \global_arr::fenzu_arr();
        $tongdao_arr = \global_arr::tongdao_arr();
        $this->assign('type_arr', $type_arr);
        $this->assign('tongdao_arr', $tongdao_arr);
        $this->assign('fenzu_arr', $fenzu_arr);
        $this->assign('txt_uid', input('txt_uid'));
        $this->assign('txt_pici', input('txt_pici'));
        $this->assign('selresult', input('selresult'));
        $this->assign('search_time', input('search_time')?:(date('Y-m-d',time()).' 00:00:00 - '.date('Y-m-d H:i:s',time())));
        if (request()->isAjax()) {
            $parm = input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $res = get_orders($parm);
            return mac_return(0, '查询成功', $res['list'], $res['count'], $res['tj']);
        } else {
            return view();
        }


    }
    
    public function orders1()
    {
        
        $tijao = input('tijao') ?? 0;
        $parm = input();
        if(!isset($parm['search_time'])){
            $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
        }
        $res = get_orders($parm);
        return mac_return(0, '查询成功', $res['list'], $res['count'], $res['tj']);
    }
    //批次统计
    public function pici(){
        if(request()->isAjax()) {
            $parm=input();
           // $parm['search_time']="2020-11-01 00:00:00 - 2020-11-03 00:00:00";
            return get_pici($parm);
        }else{
            $tongdao_arr=\global_arr::tongdao_arr();
            $type_arr=\global_arr::type_arr();
            $this->assign('tongdao_arr',$tongdao_arr);
            $this->assign('type_arr',$type_arr);
            return view();
        }
    }
    //批量修改费率
    public function gaijia(){
        $xt_huilv=input('xt_huilv');
        $user_huilv=input('user_huilv');
        $total_orderid=input('total_orderid');
        if($xt_huilv>100 || $xt_huilv<=0 || $xt_huilv==''){
            mac_return(0,"系统汇率输入错误");
        }
        if($user_huilv>100 || $user_huilv<=0 || $user_huilv==''){
            mac_return(0,"用户汇率输入错误");
        }
        if($xt_huilv<=$user_huilv){
            mac_return(0,"系统费率不得小于用户汇率");
        }
        if($total_orderid){
            $update_arr =array(
                'xt_huilv'=>$xt_huilv,
                'user_huilv'=>$user_huilv,

            );
            $total_orderid=str_replace(',',"','",$total_orderid);
            MC('orders')->where("status=0 and total_orderid in ('".$total_orderid."')")->update($update_arr);
            mac_return();
        }else{
            mac_return(0,"批次号不能为空");
        }
    }

    //公用重提入口
    public function again_init()
    {
        $parm = input();
        $parm['limit'] = 200;
        $parm['status'] = 1;//失败的才能重提
        $parm['status_code'] = 1;//
        $again_td = input('again_td');//重提的通道
        $order_res = get_orders($parm);
        $xt_huilv = number_format(input('xt_huilv'),2);
        $count = $order_res['count'];
        $i = 0;
        //99为速销卡急速通道 88为原始通道
        if (!in_array($again_td, [1, 2, 5, 6, 7, 8, 9, 10, 11, 88, 99])) {
            mac_return(0, '重提通道错误');
        }
        if ($count > 0) {
            foreach ($order_res['list'] as $k => $v) {
                //成功的不准继续重提
                if ($order_res['status'] != 1) {
                    if ($again_td == 2) {
                        $type = $this->again_hst($v);
                    } elseif ($again_td == 6) {
                        $type = $this->again_sxk($v);
                    } elseif ($again_td == 8) {
                        $type = $this->again_sup($v);
                    } elseif ($again_td == 10) {
                        $type = $this->again_xkl($v);
                    } elseif ($again_td == 11) {
                        $type = $this->again_xm($v);
                    } elseif ($again_td == 99) {
                        $again_td = 6;//通道设置为速
                        $type = $this->again_sxk_s($v);
                    } elseif ($again_td == 88) {
                        $again_td = $v['tongdao'];//通道设置为速
                        $type = $v['type'];
                    } else {
                        //默认汇
                        $again_td = 2;
                        $type = $this->again_hst($v);
                    }
                    //提交新订单等待轮询提交渠道，批次号不变 ，用户费率不变（可能需要自定义，待确定）
                    newOrder($v, $again_td,$type,$xt_huilv);
                    if($v['status']==0){//处理中的不做修改，让通道继续提交

                    }else{
                        $update_array = array(
                            'status_desc' => '客服已协助重提',
                            'status' => 2
                        );
                        MC('orders')->where("orderid='" . $v['orderid'] . "'")->update($update_array);
                    }

                    $i++;
                }
            }
        }

        $fail_count = $count - $i;
        mac_return(1, "共处理" . $i . "张,其中失败" . $fail_count . "张");
    }

    //重提速
    public function again_sxk($v)
    {

        //福禄->汇速通 移动 31->13   联通25->14   电信26->15  盛付通   45->61  骏网30->10
        $sxk_arrs = array(13, 14, 15, 42, 60, 11, 44);
        if ($v['tongdao'] == 2) {
            if (in_array($v[type], $sxk_arrs)) {
                $v['type'] == 13 and $v['type'] = 'MOBILE';
                $v['type'] == 14 and $v['type'] = 'UNICOM';
                $v['type'] == 15 and $v['type'] = 'TELECOM';
                $v['type'] == 42 and $v['type'] = 'WY';
                $v['type'] == 60 and $v['type'] = 'TH';
                $v['type'] == 11 and $v['type'] = 'JW_ALL';
                $v['type'] == 44 and $v['type'] = 'WM';

            }
        }

        if ($v['tongdao'] == 5) {

            $v['type'] == 'SZX' and $v['type'] = 'MOBILE';
            $v['type'] == 'LT' and $v['type'] = 'UNICOM';
            $v['type'] == 'DX' and $v['type'] = 'TELECOM';
            $v['type'] == 'QQ' and $v['type'] = 'QB';

        }

        if ($v['tongdao'] == 7) {

            $v['type'] == '1008' and $v['type'] = 'MOBILE';
            $v['type'] == '1010' and $v['type'] = 'UNICOM';
            $v['type'] == '1009' and $v['type'] = 'TELECOM';

        }

        if ($v['tongdao'] == 8) {

            $v['type'] == '3' and $v['type'] = 'MOBILE';
            $v['type'] == '5' and $v['type'] = 'UNICOM';
            $v['type'] == '4' and $v['type'] = 'TELECOM';

        }

        if ($v['tongdao'] == 9) {
            $v['type'] == '203' and $v['type'] = 'MOBILE';
            $v['type'] == '205' and $v['type'] = 'UNICOM';
            $v['type'] == '204' and $v['type'] = 'TELECOM';
        }
        return $v['type'];

    }

    //重提速-急
    public function again_sxk_s($v)
    {
        //福禄->汇速通 移动 31->13   联通25->14   电信26->15  盛付通   45->61  骏网30->10
        $sxk_arrs = array(13, 14, 15, 42, 60, 11, 44);

        if ($v['tongdao'] == 2) {
            if (in_array($v['type'], $sxk_arrs)) {
                $v['type'] == 13 and $v['type'] = 'MOBILE_DISCOUNT';
            }
        }
        if ($v['tongdao'] == 6) {
            $v['type'] == 'MOBILE' and $v['type'] = 'MOBILE_DISCOUNT';
        }

        if ($v['tongdao'] == 5) {

            $v['type'] == 'SZX' and $v['type'] = 'MOBILE_DISCOUNT';
        }
        if ($v['tongdao'] == 7) {
            $v['type'] == '1008' and $v['type'] = 'MOBILE_DISCOUNT';
        }
        if ($v['tongdao'] == 8) {
            $v['type'] == '3' and $v['type'] = 'MOBILE_DISCOUNT';
        }
        if ($v['tongdao'] == 9) {
            $v['type'] == '203' and $v['type'] = 'MOBILE_DISCOUNT';
        }
        return $v['type'];
    }

    //重提闲
    public function again_xm($v)
    {
        $hst_arrs = array(13, 14, 15);
        $sxk_arrs = array('MOBILE', 'UNICOM', 'TELECOM');
        $bl_arrs = array('SZX', 'LT', 'DX');
        if ($v['tongdao'] == 2) {
            if (in_array($v['type'], $hst_arrs)) {
                $v['type'] == 13 and $v['type'] = 'MOBILE';
                $v['type'] == 14 and $v['type'] = 'UNICOM';
                $v['type'] == 15 and $v['type'] = 'TELECOM';

            }
        }


        if ($v['tongdao'] == 5) {
            if (in_array($v['type'], $bl_arrs)) {
                $v['type'] == 'SZX' and $v['type'] = 'MOBILE';
                $v['type'] == 'LT' and $v['type'] = 'UNICOM';
                $v['type'] == 'DX' and $v['type'] = 'TELECOM';
            }
        }

        if ($v['tongdao'] == 6) {
            $v['type'] == 'MOBILE_DISCOUNT' and $v['type'] = 'MOBILE';
            $v['type'] == 'UNICOM_DISCOUNT' and $v['type'] = 'UNICOM';
            $v['type'] == 'TELECOM_DISCOUNT' and $v['type'] = 'TELECOM';

        }

        if ($v['tongdao'] == 7) {
            $v['type'] == '1008' and $v['type'] = 'MOBILE';
            $v['type'] == '1010' and $v['type'] = 'UNICOM';
            $v['type'] == '1009' and $v['type'] = 'TELECOM';
        }

        if ($v['tongdao'] == 8) {
            $v['type'] == '3' and $v['type'] = 'MOBILE';
            $v['type'] == '5' and $v['type'] = 'UNICOM';
            $v['type'] == '4' and $v['type'] = 'TELECOM';
        }
        return $v['type'];
    }

    //重提sup
    public function again_sup($v)
    {
//福禄->汇速通 移动 31->13   联通25->14   电信26->15  盛付通   45->61  骏网30->10
        $hst_arrs = array(13, 14, 15);
        $sxk_arrs = array('MOBILE', 'UNICOM', 'TELECOM');
        $bl_arrs = array('SZX', 'LT', 'DX');

        if ($v['tongdao'] == 2) {
            if (in_array($v['type'], $hst_arrs)) {
                $v['type'] == 13 and $v['type'] = '3';
                $v['type'] == 14 and $v['type'] = '5';
                $v['type'] == 15 and $v['type'] = '4';

            }
        }

        if ($v['tongdao'] == 6) {
            if (in_array($v[type], $sxk_arrs)) {
                $v['type'] == 'MOBILE' and $v['type'] = '3';
                $v['type'] == 'UNICOM' and $v['type'] = '5';
                $v['type'] == 'TELECOM' and $v['type'] = '4';
            }
        }

        if ($v['tongdao'] == 5) {
            if (in_array($v['type'], $bl_arrs)) {
                $v['type'] == 'SZX' and $v['type'] = '3';
                $v['type'] == 'LT' and $v['type'] = '5';
                $v['type'] == 'DX' and $v['type'] = '4';
            }
        }

        if ($v['tongdao'] == 7) {
            $v['type'] == '1008' and $v['type'] = '3';
            $v['type'] == '1010' and $v['type'] = '5';
            $v['type'] == '1009' and $v['type'] = '4';
        }

//        if($v[type]==3){
//            $productid=33009;
//        }elseif($v[type]==4){
//            $productid=33011;
//        }elseif($v[type]==5){
//            $productid=33013;
//        }else{
//        }

        if ($v['tongdao'] == 9) {
            $v['type'] == '203' and $v['type'] = '3';
            $v['type'] == '205' and $v['type'] = '5';
            $v['type'] == '204' and $v['type'] = '4';
        }
        return $v['type'];
    }

    //重提汇速通
    public function again_hst($v)
    {
//福禄->汇速通 移动 31->13   联通25->14   电信26->15  盛付通   45->61  骏网30->10
        $hst_arrs = array('MOBILE', 'UNICOM', 'TELECOM','MOBILE_DISCOUNT', 'UNICOM_DISCOUNT', 'TELECOM_DISCOUNT', 'WY', 'TH', 'WM');

        $bl_hst_arrs = array('SZX', 'DX', 'LT', 'WY', 'TH');

        if ($v['tongdao'] == 6) {
            if (in_array($v['type'], $hst_arrs)) {
                $v['type'] == 'MOBILE' and $v['type'] = 13;
                $v['type'] == 'MOBILE_DISCOUNT' and $v['type'] = 13;
                $v['type'] == 'UNICOM' and $v['type'] = 14;
                $v['type'] == 'UNICOM_DISCOUNT' and $v['type'] = 14;
                $v['type'] == 'TELECOM' and $v['type'] = 15;
                $v['type'] == 'TELECOM_DISCOUNT' and $v['type'] = 15;
                $v['type'] == 'WY' and $v['type'] = 42;
                $v['type'] == 'TH' and $v['type'] = 60;
                $v['type'] == 'WM' and $v['type'] = 44;
            }
        }

        if ($v['tongdao'] == 5) {
            if (in_array($v['type'], $bl_hst_arrs)) {
                $v['type'] == 'SZX' and $v['type'] = 13;
                $v['type'] == 'LT' and $v['type'] = 14;
                $v['type'] == 'DX' and $v['type'] = 15;
                $v['type'] == 'WY' and $v['type'] = 42;
                $v['type'] == 'TH' and $v['type'] = 60;
            }
        }

        if ($v['tongdao'] == 7) {

            $v['type'] == '1008' and $v['type'] = 13;
            $v['type'] == '1010' and $v['type'] = 14;
            $v['type'] == '1009' and $v['type'] = 15;

        }

        if ($v['tongdao'] == 8) {

            $v['type'] == '3' and $v['type'] = 13;
            $v['type'] == '5' and $v['type'] = 14;
            $v['type'] == '4' and $v['type'] = 15;

        }

        if ($v['tongdao'] == 9) {
            $v['type'] == '203' and $v['type'] = 13;
            $v['type'] == '205' and $v['type'] = 14;
            $v['type'] == '204' and $v['type'] = 15;
        }
        return $v['type'];
    }

    //重提销卡啦
    public function again_xkl($v)
    {
        //
    }

    //漏卡查询
    public function louka()
    {
        $this->assign('now', date('Y-m-d'));
        if (request()->isPost()) {
            $search_time = input('search_time')?:'';
            if (!empty($search_time)) {
                $tmp_start = strtotime(explode(' - ', $search_time)[0] . ' 00:00:00');
                $tmp_end = strtotime(explode(' - ', $search_time)[1] . ' 00:00:00') + 86400;
            } else {
                $tmp_start = strtotime(date('Y-m-d'));
                $tmp_end = time();
            }

            $txt_cardnum = input('txt_cardnum');

            //处理提交的原卡密
            preg_match_all("/[\w\d]{7,}/", $txt_cardnum, $res);

            foreach ($res[0] as $k => $v) {

                if ($k % 2 == 0) {
                    $tmp1_arr[] = $v;

                } else {
                    $tmp2_arr[] = $v;
                }

            }

            $yuan_arr = array_combine($tmp1_arr, $tmp2_arr);
            $txt_uid = input('txt_uid');

            $sql = "select crad_number,crad_pass,count(distinct crad_number) tmp from orders where 1=1 ";
            $txt_uid and $sql .= " and uid=" . intval($txt_uid);
            $sql .= " and on_time>" . intval($tmp_start);
            $sql .= " and on_time<" . intval($tmp_end);
            $sql .= " group by crad_number order by id desc";
            $yiti_res = MC('orders')->query($sql);

            foreach ($yiti_res as $k => $v) {
                $yiti_arr[$v['crad_number']] = $v['crad_pass'];
            }

            $lou_arr = array_diff_assoc($yuan_arr, $yiti_arr);
            $new_str = '';
            foreach ($lou_arr as $k => $v) {
                $new_str .= $k . " " . $v . "\n";
            }
            if ($new_str) {
                return mac_return(1, '查询成功', $new_str);
            } else {
                return mac_return(0, '未发现漏卡');
            }
        } else {
            return view();
        }
    }

    //api订单查询
    public function apiorder()
    {

    }

    //订单删除
    public function order_del()
    {
        if (Request::instance()->isAjax()) {
            $ids = explode(',', input('post.id'));
            if (MC('orders')->where(['id' => ['in', $ids]])->delete()) {
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }
    
    //提卡设定
    public function tikashezhi()
    {

        $id = intval(input('uid'));
        if (request()->isPost()) {

            $data = input();
            
            $parm['tc_time'] = $data['timesc'];
            $dklist = $_POST['like'];
            $arr = [];
            foreach ($dklist as $key => $value) {
                $arr[] = $key;
            }

            $res = MC('sys_user')->where('id='.$data['id'])->update($parm);
            SetRedis('tc_time_'.$data['id'],$data['timesc'],86400*365);

            $str = json_encode($arr);
            SetRedis('dk_id_'.$data['id'],$str,86400*365);
           
            if($res>=0){
                return mac_return();
            }else{
                return mac_return(0);
            }
        }else{

            $find = GetRedis('tc_time_'.$id);
            $dkArr = GetRedis('dk_id_'.$id);

            $dk_list = MC('dk_list')->where('status=1')->field('title,id')->select();

            $this->assign('dk_list',$dk_list);
            $this->assign('find',$find);
            $this->assign('dkArr',$dkArr);
            $this->assign('uid',$id);
            return view();
        }
    }
    
    
    //提现手续费
    public function tixian_sxf()
    {

        $id = intval(input('uid'));
        if (request()->isPost()) {

            $data = input();
            $parm['sxf_bank'] = $data['sxf_bank'];
            $parm['sxf_alipay'] = $data['sxf_alipay'];
            
            $res = MC('sys_user')->where('id='.$data['id'])->update($parm);
           
            if($res>=0){
                return mac_return();
            }else{
                return mac_return(0);
            }
        }else{

            $find = MC('sys_user')->field('sxf_bank,sxf_alipay')->where('id='.$id)->find();
            $this->assign('find',$find);
            $this->assign('uid',$id);
            return view();
        }
    }


}