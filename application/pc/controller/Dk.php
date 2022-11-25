<?php

namespace app\pc\controller;

import('lib.STD3Des', EXTEND_PATH);

use think\Request;

class Dk extends Base
{
    protected $sys_config;
    protected $user_huilv;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sys_config = get_sys_config();
        $dkId = input('cardValueId');//卡种id
        $cardAnyValue = intval(input('cardAnyValue'));//面值
        if (!session('uinfo.id') || session('uinfo.id') <= 0) {
            return mac_return(0, '用户登录已过期');
        }
        $huilv = MC('m_dk_config')->where("uid=" . session('uinfo.id'))->value('type' . $dkId);
        if ($huilv && $huilv > 1) {
            $this->user_huilv = $huilv;
        } else {
            $find = MC('dk_list')->where(['id' => $dkId])->field('zc_profit,money')->find();
            $moneyArr = explode(',', $find['money']);
            $profitArr = explode(',', $find['zc_profit']);
            $this->user_huilv = $find['zc_profit'];
            if(count($moneyArr) == count($profitArr)){

                $array_flip_money = array_flip($moneyArr);
                $kk = $array_flip_money[$cardAnyValue];
                if(!in_array($cardAnyValue,$moneyArr)){
                    return mac_return(1, '参数不合法');
                }
                $this->user_huilv = $profitArr[$kk];
            }
        }
        error_reporting(0);
        set_time_limit(999999);
    }

    //单笔提交
    function index()
    {
        if (Request()->isPost()) {
            $cardValueId = input('cardValueId');//卡种
            $cardAnyValue = intval(input('cardAnyValue'));//面值
            $cardAnyRate = number_format(input('cardAnyRate'), 2, '.', '');//自定义费率

            $cinfo = MC('dk_list')->where("id=" . $cardValueId)->field('zc_profit,status')->find();

            $tmpArr = explode('-', $cinfo['zc_profit']);

            $count = count($tmpArr);

            if($count == 1){
                if($cardAnyRate > $tmpArr['0'] || $cardAnyRate < 0) {
                    return mac_return(0, '参数不合法');
                }
            }
            if($count == 2){
                if($cardAnyRate > $tmpArr['1'] || $cardAnyRate < $tmpArr['0']) {
                    return mac_return(0, '参数不合法');
                }
            }

            $cardNo = input('cardNo','','strip_tags');
            $cardPwd = input('cardPwd','','strip_tags');
            if ($cardNo && $cardPwd) {
                $cardBatch = $cardNo . ' ' . $cardPwd;
            } elseif (!$cardNo) {
                $cardBatch = $cardPwd;
            } elseif (!$cardPwd) {
                $cardBatch = $cardNo;
            }

            //多行处理逻辑
            $res = explode("\n", trim($cardBatch));
            $cinfo = MC('dk_list')->where("id=" . $cardValueId)->find();
            if (!$cinfo || $cinfo['status'] != 1) {
                return mac_return(0, '提交失败,卡品牌已维护~！');
            }
            //限制数量
            if (count($res) > 1) {
                return mac_return(0, '单次提交不得超过1张卡！');
            }
            //确定通道
            $dk_config = MC('dk_config')->where(['dk_id' => $cardValueId, 'status' => 1])->order('listorder asc')->select();

            $sys_config = $this->sys_config;
            if ($dk_config && count($dk_config)>=1) {
                //多条通道，遍历查询各通道的执行情况
                foreach ($dk_config as $v) {
                    $orders_count = MC('orders')->field('count(1) as count')->where(['tongdao' => $v['tongdao']])->count();
                    if ($orders_count < $sys_config['order_count']) {
                        $tongdao = $v['tongdao'];
                        $cardtype = $v['type'];
                        $xt_huilv = $v['profit'];
                        break;
                    }
                }
                //单通道或遍历后通道全部堵塞则强制选定第一个
                if(!$tongdao){
                    $tongdao = $dk_config[0]['tongdao'];
                    $cardtype = $dk_config[0]['type'];
                    $xt_huilv = $dk_config[0]['profit'];
                }
            }else{
                return mac_return(0, '提交失败,该卡种通道全部关闭~！');
            }
            $t_orderid = 'pt' . date("mdHi", time()) . rand(111, 999);
            //单行提交处理逻辑
            $this->get_api($cardBatch, $cardAnyValue, $cardValueId, $cardAnyRate, $t_orderid,$tongdao,$cardtype,$xt_huilv);
            return mac_return(1, '提交成功！请在个人中心->订单管理->销卡订单中查看最新记录');
        }
    }

    //批量提交
    function batch()
    {
        if (Request()->isPost()) {
            $cardValueId = input('cardValueId');//卡种
            $cardAnyValue = intval(input('cardAnyValue'));//面值
            $cardBatch = input('cardBatch','','strip_tags');//卡号
            $cardAnyRate = number_format(input('cardAnyRate'), 2);//自定义费率

            $cinfo = MC('dk_list')->where(['id' => $cardValueId])->field('status,zc_profit')->find();

            $tmpArr = explode('-', $cinfo['zc_profit']);

            $count = count($tmpArr);

            if($count == 1){
                if($cardAnyRate > $tmpArr['0'] || $cardAnyRate < 0) {
                    return mac_return(0, '参数不合法');
                }
            }
            if($count == 2){
                if($cardAnyRate > $tmpArr['1'] || $cardAnyRate < $tmpArr['0']) {
                    return mac_return(0, '参数不合法');
                }
            }

            //多行处理逻辑
            $res = explode("\n", trim($cardBatch));
            
            if (!$cinfo || $cinfo['status'] != 1) {
                return mac_return(0, '提交失败,卡品牌已维护~！');
            }
            //限制数量
            if (count($res) > 1000) {
                return mac_return('单次提交不得超过1000张卡！');
            } else {
                //确定通道
                $dk_config = MC('dk_config')->where(['dk_id' => $cardValueId, 'status' => 1])->order('listorder asc')->select();
                $sys_config = $this->sys_config;
                if ($dk_config && count($dk_config)>=1) {
                    //多条通道，遍历查询各通道的执行情况
                    foreach ($dk_config as $v) {
                        $orders_count = MC('orders')->field('count(1) as count')->where(['tongdao' => $v['tongdao']])->count();
                        if ($orders_count < $sys_config['order_count']) {
                            $tongdao = $v['tongdao'];
                            $cardtype = $v['type'];
                            $xt_huilv = $v['profit'];
                            break;
                        }
                    }
                    //单通道或遍历后通道全部堵塞则强制选定第一个
                    if(!$tongdao){
                        $tongdao = $dk_config[0]['tongdao'];
                        $cardtype = $dk_config[0]['type'];
                        $xt_huilv = $dk_config[0]['profit'];
                    }
                }else{
                    return mac_return(0, '提交失败,该卡种通道全部关闭~！');
                }

                $t_orderid = 'pt' . date("mdHi", time()) . rand(111, 999);
                if (strpos($cardBatch, "\n") === false) {
                    //单行提交处理逻辑
                    $this->get_api($cardBatch, $cardAnyValue, $cardValueId, $cardAnyRate, $t_orderid,$tongdao,$cardtype,$xt_huilv);
                } else {
                    foreach ($res as $k => $v) {
                        $this->get_api($v, $cardAnyValue, $cardValueId, $cardAnyRate, $t_orderid,$tongdao,$cardtype,$xt_huilv);
                    }
                }
                return mac_return(1, '提交成功！请在个人中心->订单管理->销卡订单中查看最新记录');
            }
        }
    }

    //单笔提交公共方法 '2' => '汇速通','6' => '速销卡','8' => 'sup(新讯银)','10' => '销卡啦','11' => '闲卖'
    function get_api($txt_cardnum, $txt_value, $cardValueId, $rate, $t_orderid,$tongdao,$cardtype,$xt_huilv)
    {
        $uid = session('uinfo.id');
        //卡种是否允许提交

        $dkInfo = MC('dk_list')->where(['id' => $cardValueId])->find();
        if ($dkInfo['status'] == 1) {
            $res = explode(' ', trim($txt_cardnum));
            $orderid = 'jjp' . date("YmdHis") . rand(111111111, 999999999);
            $value = intval($txt_value);
////查售卡平台卖出的卡，不收
//                $match_res=MC('match_card')->where('1=1')->select();
//                foreach($match_res as $k=>$v){
//                    $match_arr[] = $v[card_number];
//                }
//                if(in_array($cardNumber,$match_arr)){
//                    //写入订单表
//                    $insert_array = array(
//                        'uid' =>$uid,
//                        'orderid' =>$orderid,
//                        'crad_number' =>$cardNumber,
//                        'crad_pass' =>$cardpwd,
//                        'cash' =>$value,
//                        'type' =>$cardtype,
//                        'status' =>2,
//                        'on_time' =>time(),
//                        'end_time' =>time(),
//                        'total_orderid'=>$t_orderid,
//                        'tongdao'=>$tongdao,
//                        //'xbh_tiqu'=>1,
//                        'status_desc'=>'卡密未使用，我司无法提交'
//                    );
//                    MC('orders')->insert($insert_array);
//                    return 13;//卡号已存在本系统
//                }
                //是否自定义费率
                $huilv = number_format($this->user_huilv, 2);//如果指定费率为空则是默认用户费率
                if ($dkInfo['isanyrate'] == 1) {
                    $huilv = $rate;
                }
                $insert_array = array(
                    'uid' => $uid,
                    'orderid' => $orderid,
                    'crad_number' => $res[0],
                    'crad_pass' => $res[1],
                    'cash' => $value,
                    'type' => $cardtype,
                    'status' => 0,
                    'on_time' => time(),
                    'total_orderid' => $t_orderid,
                    'tongdao' => $tongdao,
                    'user_huilv' => $huilv,
                    'xt_huilv' => $xt_huilv,
                    'dk_id'=>$cardValueId
                    //'xbh_tiqu'=>1
                );
                //dy($insert_array);
                MC('orders')->insert($insert_array);//生成用户订单
            } else {
                return 11;//该卡种通道全部关闭
            }

    }

}