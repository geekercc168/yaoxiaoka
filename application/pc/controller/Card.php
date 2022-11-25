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

import('lib.global_arr', EXTEND_PATH);
import('lib.STD3Des', EXTEND_PATH);

class Card extends Controller
{
    protected $sys_config;
    protected $is_mobile;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->is_mobile=is_mobile()?1:0;
        $this->assign('is_mobile', $this->is_mobile);
        $this->sys_config = get_sys_config();
    }
    //用户端前后台共用销卡页面
    public function index(){
        $this->assign('tid', input('tid')?:1);
        $this->assign('au', input('au')?:0);
//        $is_truename = is_truename(session('uinfo.id'));
//        $this->assign('is_truename', $is_truename);
        $is_bank = MC('member_bank')->where(['uid' => intval(session('uinfo.id'))])->find();
        $this->assign('is_bank', $is_bank);
        $uid=session('uinfo.id');
        $this->assign('uid',$uid );
        $this->assign('nav', 2);
        
        $tx_config=MC('tx_config')->find();
        $ture_name_status = 0;
        if($tx_config['need_face'] == 1){
           
            $ture_name=MC('truename_auth')->where('uid='.$uid)->find();
            
            if(empty($ture_name['zfb_key'])){
                $ture_name_status = 1;
            }
        }
        $this->assign('ture_name_status',$ture_name_status);
        
        if($this->is_mobile==1){
            return view('m_index');
        }
        
       
      
        return view();
    }
    
    //定时更新-速销卡
    public function dsgx_sxk(){
        
        if(input('act') != '4a9822efa584de0f796d4e543ffb2326'){
            echo 'error';exit;
        }
      
        $list_arr = MC('orders')->field('orderid')->where('tongdao=6 and check_status=0 and xbh_tiqu=1 and status=2')->limit(100)->select();
        d($list_arr);
        if($list_arr){
            foreach($list_arr as $v){
                //构造参数数组
                $ordertime = date("YmdHis",time());
                $params =array(
                    'customerId'=>SUID,
                    'orderId'=>$v['orderid'],
                );
                $sign = sxk_getSign($params);

                $params['sign'] = $sign;

                $callback_res  = myCurl(http_build_query($params),'http://api.suxiaoka.cn/api/query/queryOrder.do');
                $res_arr = json_decode($callback_res,TRUE);
               
                if($res_arr['status']==2){
                    $state =1;
                    $status_desc = '成功';
                }elseif($res_arr['status']==3){
                    $state =2;
                    $status_desc = isset($res_arr['remarks']) ? $res_arr['remarks']:'失败';
                    //$status_desc = '失败';
                }elseif($res_arr['resultCode']==100013){
                    $state =2;
                    $status_desc = '订单号不存在';
                }else{
                    $state =0;
                    $status_desc = '处理中..';
                }

                $update_array = array(
                    'status' => $state,
                    'check_status' => 1,
                    'status_desc' => $status_desc
                );
                $res = MC('orders')->where(['orderid' => $v['orderid']])->update($update_array);
                d($res);
            }
        }else{
            echo 'empty';
        }
       
    }

    //定时更新-闲卖
    public function dsgx_xm(){
        
        if(input('act') != '4a9822efa584de0f796d4e543ffb2326'){
            echo 'error';exit;
        }
      
        $list_arr = MC('orders')->field('orderid')->where('tongdao=11 and check_status=0 and xbh_tiqu=1 and status=2')->limit(100)->select();
        d($list_arr);
        
        if($list_arr){
            foreach($list_arr as $v){
                //构造参数数组
                $nonce_str = date("YmdHis",time()).rand(1000000,9999999);
                $params =array(
                    'mch_id'=>XMUID,
                    'out_trade_no'=>$v['orderid'],
                    'nonce_str'=>$nonce_str,
                );
                $sign = xm_getSign($params);
                $params['sign'] = $sign;
                $callback_res = myCurl(json_encode($params),'http://api.xiansell.com/xm-api/card/query',1);
                
                $res_arr = json_decode($callback_res,1);
               
                if($res_arr['status']=='SUCCESS'){
                    $state =1;
                    $status_desc = '成功';
                }elseif($res_arr['status']=='DEALING'){
                    $state =0;
                    $status_desc = '处理中';
                }else{
                    $state =2;
                    $status_desc = '订单号不存在';
                }

                $update_array = array(
                    'status' => $state,
                    'check_status' => 1,
                    'status_desc' => $status_desc
                );
                $res = MC('orders')->where(['orderid' => $v['orderid']])->update($update_array);
                d($res);
            }
        }else{
             echo 'empty';
        }
       
    }
    
   
    public function dk_list(){
        if (request()->isAjax()){
            $search_name=input('search_name');
            $map=array();
            $map['status']=1;
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=MC('dk_list')->field('*')->where($map)->order('status desc,listorder asc')->limit($start,$limit)->select();
            $count=MC('dk_list')->where($map)->count();
            return mac_return(0,'查询成功',$list,$count);
        }else{
            return view();
        }
    }
    
    //apisign
    private static function creatSign($params) {
        $key = $params['apiKey'];
        $str = "";

        ksort($params);
        if($params['cardBatch']) unset($params['cardBatch']);
        if($params['cardNumber']) unset($params['cardNumber']);
        if($params['cardPassword']) unset($params['cardPassword']);
        if($params['memo']) unset($params['memo']);
        if($params['apiKey']) unset($params['apiKey']);

        foreach ($params as $k => $v ) {
            if(!is_null($v) && isset($v)){
                $str .= $k."=".$v."&";
            }
        }

        $str.= "key=" . $key;
      
        return strtolower(md5($str));
    }
    private static function yxk_api_notify($orderid,$state){
      
        $field = 'id,uid,orderid,xbh_orderid,type,status,crad_number,crad_pass,cash,successAmount,end_time,callbackURL,status_desc,tongzhi_status';

        $orders = MC('orders')->where("orderid='{$orderid}'")->field($field)->find();

        if(!empty($orders['callbackURL'])){
            $arraystr['customerId'] = $orders['uid'];
            $arraystr['orderId'] = $orders['orderid'];
            $arraystr['systemOrderId'] = $orders['xbh_orderid'];
            $arraystr['productCode'] = $orders['type'];
            $arraystr['status'] = $state;
            $arraystr['cardNumber'] = $orders['crad_number'];
            $arraystr['cardPassword'] = $orders['crad_pass'];
            $arraystr['amount'] = $orders['cash'];
            $arraystr['successAmount'] = $orders['successAmount'];
            $arraystr['successTime'] = $orders['end_time'];
            $arraystr['callbackURL'] = $orders['callbackURL'];
            $arraystr['memo'] = $orders['status_desc'];
            $sys_user = MC('sys_user')->where('id','=',$orders['uid'])->field('api_key')->find();

            $arraystr['apiKey'] = $sys_user['api_key'];
            $sign = self::creatSign($arraystr);

            $arraystr['sign'] = $sign;
            unset($arraystr['apiKey']);

            $res = go_curl($orders['callbackURL'], 'post',$arraystr);

            if($orders['tongzhi_status'] == 1){
                echo '订单已完成';
            }
          
            if($res == 'success'){
                $update['tongzhi_status'] = 1;
                MC('orders')->where('id='.$orders['id'])->update($update);
                echo 'success';
            }else{
                d($res);
            }
        }else{
            echo 'empty';
        }
        
    }
    
    //异步请求卡品牌
    public function cardinfo()
    {
        $tid = input('tid') ?: 1;
        $json = MC('dk_list')->where("card_type=" . $tid)->order('status desc,listorder asc')->select();
        //下面的第一个品牌
        //查询卡信息
        if ($json) {
            return mac_return(1, '查询成功', $json);
        } else {
            return mac_return(0);
        }
    }
    //要销卡获取费率数据
    public function cardval()
    {
        $cid = input('cid') ?: 1;
        $cinfo = MC('dk_list')->where("id=" . $cid)->find();
        $data = [];
        if ($cinfo['money']) {
            $list = explode(',', $cinfo['money']);
            //确定费率
            $uid = session('uid');
            $zc_profit = $cinfo['zc_profit'];
            if ($uid > 0) {
                //查是否指定费率
                $mdk_config = MC('m_dk_config')->where(['uid' => $uid])->value('type' . $cid);
                if ($mdk_config) {
                    $zc_profit = $mdk_config;
                }
            }
            //超快销自定义汇率
            if ($cinfo['isanyrate'] == 1) {
                $price_arr = explode('-', $zc_profit);
                $minRate = $price_arr[0];
                $maxRate = $price_arr[1];
                $zc_profit = 0;
            } else {
                $maxRate = 0;
                $minRate = 0;
            }
            
            $profitArr = explode(',', $cinfo['zc_profit']);
            $profit_status = 0;
            if(count($list) == count($profitArr)){
                $profit_status = 1;
            }
            
            foreach ($list as $k => $v) {
                $data[$k]['isAnyRate'] = $cinfo['isanyrate'];
                
                if($profit_status == 1){
                    $data[$k]['rate'] = number_format($profitArr[$k] / 10,2);//转为折扣
                    $data[$k]['price'] = number_format($v * $profitArr[$k] / 100, 2,'.','');
                }else{
                    $data[$k]['rate'] = number_format($zc_profit / 10,2);//转为折扣
                    $data[$k]['price'] = number_format($v * $zc_profit / 100, 2,'.','');
                }
                
                $data[$k]['value'] = $v;
                $data[$k]['cardvalueId'] = $cinfo['id'];
                $data[$k]['maxRate'] = $maxRate;
                $data[$k]['minRate'] = $minRate;
                $data[$k]['status'] = $cinfo['status'];
            }

        }

        return mac_return(1, '查询成功', $data);
    }
    //漏单补单,轮询提交到销卡渠道
    public function bulou()
    {
        $not_str = "  and !( type=6  or (type=10 and tongdao=2)  or (tongdao=6 and type='JW') or (tongdao=5 and type='JW') or (type=30 and tongdao=4) ) and !( (type=15 and tongdao=1) or (type=60 and tongdao=2) or (tongdao=6 and type='TH') or (tongdao=5 and type='TH') or (type=32 and tongdao=4)  )  ";
        $sql = "select * from orders where status=0 and  ISNULL(xbh_tiqu)  limit 400";

        $list_arr = MC('orders')->query($sql);
        echo "<pre>";
        d($list_arr);
       
        $_jaja_d = intval(date('H'));
        // echo $_jaja_d.'<br>';
        if ($list_arr) {
            foreach ($list_arr as $k => $v) {
                
                $_jaja_d_redis = GetRedis('tc_time_'.$v['uid']);
                $_jaja_d_dk_id = GetRedis('dk_id_'.$v['uid']);
              
                if($_jaja_d_redis >=0 && $_jaja_d >= $_jaja_d_redis && (in_array($v['dk_id'], $_jaja_d_dk_id))){
                    $_jaja_status = 1;
                }else{
                    $_jaja_status = 0;
                }
                if(!in_array($v['dk_id'], $_jaja_d_dk_id)){
                    $_jaja_status = 1;
                }
                if($_jaja_d_redis ==-1 || !$_jaja_d_redis){
                    $_jaja_status = 1;
                }
                // echo $_jaja_status.'|'.$v['uid'].'|'.$_jaja_d_redis.'<br>'; exit;
                if($_jaja_status == 1){
                    
                    if ($v['tongdao'] == 2) {
                        $callbackurl = WEB_URL . "pc/card/hstcallback";
                        $this->getApi($v, $callbackurl);
                    } elseif ($v['tongdao'] == 6) {
                        $callbackurl = WEB_URL . "pc/card/sxkcallback";
                        $this->getApi($v, $callbackurl);
                    } elseif ($v['tongdao'] == 5) {
                        $callbackurl = WEB_URL . "pc/card/blcallback";
                        $this->getApi($v, $callbackurl);
                    } elseif ($v['tongdao'] == 7) {
                        $callbackurl = WEB_URL . "pc/card/xycallback";
                        $this->getApi($v, $callbackurl);
                    } elseif ($v['tongdao'] == 8) {
                        if ($v['type'] == 3) {
                            $productid = 33009;
                        } elseif ($v['type'] == 4) {
                            $productid = 33011;
                        } elseif ($v['type'] == 5) {
                            $productid = 33013;
                        } else {
    
                        }
                        $callbackurl = WEB_URL . "pc/card/supcallback";
                        $this->getApi($v, $callbackurl, $productid);
                    } elseif ($v['tongdao'] == 9) {
                        $callbackurl = WEB_URL . "pc/card/ldcallback";
                        $this->getApi($v, $callbackurl);
                    } elseif ($v['tongdao'] == 11) {
                        //提交闲卖
                        $callbackurl = WEB_URL . "pc/card/xmcallback";
                        $this->getApi($v, $callbackurl);
                    }elseif ($v['tongdao'] == 10) {
                        $callbackurl = WEB_URL . "pc/card/xklcallback";
                        $this->getApi($v, $callbackurl);
                    } elseif($v['tongdao'] == 12) {
                        $callbackurl = WEB_URL . "pc/card/camicallback";
                        $this->getApi($v, $callbackurl);
                    }
                }
            }
        }
    }
    //咔咪回调通知
    public function camicallback()
    {
        
        file_put_contents('data/log/camicallback.txt', getIP() . '------------' . date("Y-m-d H:i:s") . ":" . json_encode(input()) . PHP_EOL, FILE_APPEND);
        $fp = fopen("lock.txt", 'w+');
        if (flock($fp, LOCK_EX)) {
            $orderId = input('orderId');
            $order_res = MC('orders')->where(['orderid' => $orderId])->find();
            if ($order_res) {
                $datas=input();
                $params =array(
                    'customerId'=>$datas['customerId'],
                    'orderId'=>$datas['orderId'],
                    'systemOrderId'=>$datas['systemOrderId'],
                    'productCode'=>$datas['productCode'],
                    'status'=>$datas['status'],
                    'amount'=>$datas['amount'],
                    'cardNumber'=>$order_res['crad_number'],
                    'cardPassword'=>$order_res['crad_pass'],
                    'successAmount'=>$datas['successAmount'],
                    'actualAmount'=>$datas['actualAmount'],
                    'code' =>$datas['code']
                );
                $server_sign = cami_getSign($params);
                $sign = input('sign');
                if ($server_sign == $sign) {
                    $cami_ret_arr = \global_arr::cami_ret_arr();
                    $memo = input('memo');
                    $status_desc = !empty($memo) ? $memo : $cami_ret_arr[$datas['code']];
                    $status = input('status');
                    $success_amount = $datas['successAmount'];
                    $realPrice = input('successAmount');
                    //1成功
                    if ($status == 2) {
                        $state = 1;
                        $status_desc = '成功';
                    }elseif($status == 1){
                        $state = 0;
                        $status_desc = '处理中';
                    } else {
                        $state = 2;
                        $realPrice = 0.00;
                        $success_amount = 0.00;
                    }
                    file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
                    //$success_amount结算面值50 ，真实面值100 结算价格actualAmount
                    $actualAmount=$datas['actualAmount'];
                    $this->setOrder($state,$order_res,$success_amount,$realPrice,$actualAmount, $status_desc);
                    echo trim("Y");
                } else {
                    //签名不正确返回false
                    //file_put_contents('sxk_fail.txt',date("Y-m-d H:i:s").":".json_encode($_REQUEST)."\n",FILE_APPEND);
                    echo "false";
                }
            } else {
                //订单被删的情况返回Y
                echo trim("Y");
            }
        } else {
            echo "false";
            file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
        }
        flock($fp, LOCK_UN);
        clearstatcache();
        fclose($fp);
        die;
    }
    //订单数据更新，金额变更 private只允许内部调用 $success_amount//结算面值 $realPrice//实际面值 $actualAmount//渠道结算金额
    private function setOrder($state = 0, $order_res, $success_amount = 0, $realPrice = 0,$actualAmount=0, $return_info = '')
    {
        //查询是否开启闲时提点规则
        //$sys_config = $this->sys_config;

        //查询通用点卡表汇率
        //$profit = MC('dk_config')->where(['tongdao' => $order_res[tongdao], 'type' => $order_res[type]])->value('profit');//系统费率
        $user_huilv = $order_res['user_huilv'];//用户提交费率
        //极速卡类型数组
        $dis_arr = array('MOBILE_DISCOUNT', 'UNICOM_DISCOUNT', 'TELECOM_DISCOUNT', 'MOBILE', 'UNICOM', 'TELECOM');
        if (in_array($order_res['type'], $dis_arr)) {
            //$cardtype = $order_res[type];
            $tongdao = $order_res['tongdao'];
            if ($tongdao == 6) {
                $profit=$order_res['xt_huilv'];
            }
            if ($tongdao == 11) {
                $profit=$order_res['xt_huilv'];//有系统汇率是快销或慢销，不进行计算
            }
        }
        if($tongdao==10){//销卡啦
            $butong_arr = array(36,32,27);	//35 京东E卡现在汇率都一样了
            //部分卡面值不同结算汇率不一致
            if(in_array($order_res['type'],$butong_arr)){
                switch($order_res['type']){
                    case 35:
                        if($success_amount>99){

                        }else{
                            $profit = 91;
                            $user_huilv =90;
                        }
                        break;
                    case 36:
                        if($success_amount>99){

                        }else{
                            $profit = 91;
                            $user_huilv =90;
                        }
                        break;

                    case 32:
                        if($success_amount==50){
                            $profit = 79;
                            $user_huilv =78.4;
                        }else{

                        }
                        break;

                    case 27:
                        if($success_amount==2000 || $success_amount==50 || $success_amount==300){
                            $profit = 97;
                            $user_huilv =96.4;
                        }else{

                        }
                        break;
                }
            }
        }
        if($order_res['xt_huilv']>0){
            $profit=$order_res['xt_huilv'];//有系统汇率是快销或慢销，不进行计算
        }
        $orderid=$order_res['orderid'];
        $incash = $success_amount * ($user_huilv / 100);//用户结算价格
        $pt_incash=$success_amount * ($profit / 100);//平台结算价格
        $pt_lirun = $success_amount * ($profit - $user_huilv) / 100;//平台利润
        $update_array = array(
            'orderid' => $orderid,
            'status' => $state,
            'realvalue' => $realPrice,//真实面值
            'pt_incash' =>$pt_incash ,
            'incash' => $incash,
            'status_desc' => $return_info,
            'xt_huilv' => $profit,//系统实际费率 97+0.5
            'user_huilv' => $user_huilv,//用户提交的费率97
            'end_time' => time(),
            'pt_lirun' => $pt_lirun,
            'successAmount' => $actualAmount,//渠道结算价格
        );
        file_put_contents('data/log/succ.txt', date("Y-m-d H:i:s") . ":" . json_encode($update_array) . "\n", FILE_APPEND);
        MC('orders')->where(['orderid' => $orderid])->update($update_array);
        //如果状态值是1，写入财务记录表，更新用户金额
        if ($state == 1) {
            //查询用户基本信息
            $zj_cash = MC('sys_user')->where(['id' => $order_res[uid]])->value('zj_cash');
            $finance = MC('finance')->where(['orderid' => $orderid])->find();
            //明细不存在才插入
            if (!$finance) {
                $fina_array = array(
                    'uid' => $order_res['uid'],
                    'old_cash' => $zj_cash,
                    'cash' => $incash,
                    'action' => '销卡成功',
                    'on_time' => time(),
                    'orderid' => $orderid,
                    'new_cash' => $zj_cash + $incash,
                    'crad_number' => $order_res['crad_number'],
                    'pingtailirun' => $pt_lirun,
                    'ext' => 1,
                );
                MC('finance')->insert($fina_array);
                $info_arr = array(
                    'zj_cash' => $zj_cash + $incash
                );
                MC('sys_user')->where(['id' => $order_res['uid']])->update($info_arr);
            }

        }
        //self::yxk_api_notify($orderid,$state);
    }

    //闲卖回调
    public function xmcallback()
    {
        file_put_contents('data/log/xmcallback.txt', getIP() . '------------' . date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
        $fp = fopen("lock.txt", 'w+');
        if (flock($fp, LOCK_EX)) {
            //$order_res = $db_obj->get_one("select * from orders where orderid='".$out_trade_no."'");
            $order_res = MC('orders')->where(['orderid' => input('out_trade_no')])->find();
            if ($order_res) {
                $filed = array('mch_id', 'out_trade_no', 'trade_no', 'request_amount', 'status', 'success_amount', 'finish_time', 'return_code', 'return_info', 'attach','settle_amount');//允许通过的字段
                $params = input();
                foreach ($params as $k => $v) {
                    if (!in_array($k, $filed)) {
                        unset($params[$k]);
                    };
                }
                $server_sign = xm_getSign($params);
                $sign = input('sign');
                if ($server_sign == $sign) {
                    $success_amount = input('success_amount');//结算面值
                    //1成功
                    if (input('status') == 'SUCCESS') {
                        $state = 1;
                    }elseif(input('status') == 'FAILED'){
                        $state = 2;
                        $success_amount =0.00;
                    } else {
                        $state = 0;
                        $success_amount = 0.00;
                    }
                    $this->setOrder($state, $order_res, $success_amount, $success_amount, input('settle_amount'), input('return_info'));
                    echo "success";

                } else {
                    //签名不正确返回false
                    //file_put_contents('sxk_fail.txt',date("Y-m-d H:i:s").":".json_encode($_REQUEST)."\n",FILE_APPEND);
                    echo "false";
                }
            } else {

                //订单被删的情况返回Y
                echo "success";

            }
        } else {
            echo "false";
            file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
        }
        flock($fp, LOCK_UN);
        clearstatcache();
        fclose($fp);
        die;
    }
    //速销卡回调
    public function sxkcallback()
    {
        file_put_contents('data/log/sxkcallback.txt', getIP() . '------------' . date("Y-m-d H:i:s") . ":" . json_encode(input()) . PHP_EOL, FILE_APPEND);
        $fp = fopen("lock.txt", 'w+');
        if (flock($fp, LOCK_EX)) {
            $orderId = input('orderId');
            $order_res = MC('orders')->where(['orderid' => $orderId])->find();
            if ($order_res) {
                $datas=input();
                $params =array(
                    'customerId'=>$datas['customerId'],
                    'orderId'=>$datas['orderId'],
                    'systemOrderId'=>$datas['systemOrderId'],
                    'productCode'=>$datas['productCode'],
                    'status'=>$datas['status'],
                    'amount'=>$datas['amount'],
                    'cardNumber'=>$order_res['crad_number'],
                    'cardPassword'=>$order_res['crad_pass'],
                    'successAmount'=>$datas['successAmount'],
                    'actualAmount'=>$datas['actualAmount'],
                    'code' =>$datas['code']
                );
                $server_sign = sxk_getSign($params);
                $sign = input('sign');
                if ($server_sign == $sign) {
                    $sxk_ret_arr = \global_arr::sxk_ret_arr();
                    $memo = input('memo');
                    $status_desc = isset($memo) ? $memo : $sxk_ret_arr[$datas['code']];
                    $status = input('status');
                    $success_amount = $datas['successAmount'];
                    $realPrice = input('realPrice');
                    //1成功
                    if ($status == 2) {
                        $state = 1;
                        $status_desc = '成功';
                    }elseif($status==3){
                        $state = 2;
                       
                        $status_desc = '失败';
                    } else {
                        $state = 0;
                        $realPrice = 0.00;
                        $success_amount = 0.00;
                    }
                    
                    
                    
                    file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
                    //$success_amount结算面值50 ，真实面值100 结算价格actualAmount
                    $actualAmount=$datas['actualAmount'];
                    $this->setOrder($state,$order_res,$success_amount,$realPrice,$actualAmount, $status_desc);
                    echo "Y";
                } else {
                    //签名不正确返回false
                    //file_put_contents('sxk_fail.txt',date("Y-m-d H:i:s").":".json_encode($_REQUEST)."\n",FILE_APPEND);
                    echo "false";
                }
            } else {
                //订单被删的情况返回Y
                echo "Y";
            }
        } else {
            echo "false";
            file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
        }
        flock($fp, LOCK_UN);
        clearstatcache();
        fclose($fp);
        die;
    }
    //汇速通回调
    public function hstcallback(){
        file_put_contents('data/log/hstcallback.txt', getIP() . '------------' . date("Y-m-d H:i:s") . ":" . json_encode(input()) . PHP_EOL, FILE_APPEND);
        $fp = fopen("lock.txt", 'w+');
        if (flock($fp, LOCK_EX)) {
//构造参数数组
            $datas=input();
            $params =array(
                'ret_code'=>$datas['ret_code'],
                'agent_id'=>$datas['agent_id'],
                'bill_id'=>$datas['bill_id'],
                'huisu_bill_id'=>$datas['huisu_bill_id'],
                'bill_status'=>$datas['bill_status'],
                'card_real_price'=>$datas['card_real_price'],
                'card_settle_amt'=>$datas['card_settle_amt'],
            );
            $key = HMD5;
            $server_sign = hst_getSign($params,$key);
            //汇速通返回描述键值对

            if($server_sign==input('sign')){
                file_put_contents('data/log/hst.txt',date("Y-m-d H:i:s").":".json_encode($_GET)."\n",FILE_APPEND);
                //根据订单ID查询订单表找到uid
                $order_res = MC('orders')->where(['orderid' => $datas['bill_id']])->find();
                //查询用户基本信息
                $bill_status=$datas['bill_status'];
                if($bill_status==2){
                    $state =1;
                }elseif($bill_status==-1){
                    $state =2;
                }else{
                    $state =0;
                }
                $hst_msg_arr = \global_arr::hst_msg_arr();
                $status_desc=$hst_msg_arr[$datas['ret_msg']];
                $this->setOrder($state, $order_res, $datas['card_real_price'], $datas['card_real_price'],$datas['card_settle_amt'], $status_desc);
            }else{
                echo 'error';
            }
        }else{
            echo "false";
            file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
        }
        flock($fp, LOCK_UN);
        clearstatcache();
        fclose($fp);
        die;

    }
    //销卡啦回调
    public function xklcallback(){
        file_put_contents('data/log/xklcallback.txt',core_class::getIP().'------------'.date("Y-m-d H:i:s").":".json_encode($_REQUEST)."\n",FILE_APPEND);
        $fp = fopen("lock.txt" , 'w+');
        if(flock($fp ,LOCK_EX)){
            $orderno=input('orderno');
            $order_res = MC('orders')->where(['orderid' => $orderno])->find();
            if($order_res){
                $state=input('state');
                $success=input('success');
                $money=input('money');
                //构造参数数组
                $params =array(
                    'success'=>$success,
                    'orderno'=>$orderno,
                    'state'=>$state,
                    'money'=>$money,

                );
                $server_sign = xkl_getSign($params);

                if($server_sign==input('sign')){
                    //1成功
                    $msg=input('msg');
                    if($state==2){
                        $state =1;
                        $msg ='成功';
                    }else{
                        $state =2;
                        $money	=0.00;
                    }
                    $rate=input('rate')?:0;//回调返回的商户费率
                    $this->setOrder($state, $order_res, $money, $money,$money*$rate/100, $msg);
                }else{
                    //签名不正确返回false
                    //file_put_contents('sxk_fail.txt',date("Y-m-d H:i:s").":".json_encode($_REQUEST)."\n",FILE_APPEND);
                    echo "false";

                }
            }else{
                //订单被删的情况返回Y
                echo "1";
            }
        }
        flock($fp, LOCK_UN);
        clearstatcache();
        fclose($fp);
        die;
    }
//sup回调
    public function supcallback(){
        file_put_contents('/data/log/supcallback.txt',core_class::getIP().'------------'.date("Y-m-d H:i:s").":".json_encode(input())."\n",FILE_APPEND);
        die(1);
        $fp = fopen("lock.txt" , 'w+');
        if(flock($fp ,LOCK_EX)){
            $orderno=input('orderno');
            $order_res = MC('orders')->where(['orderid' => $orderno])->find();
            if($order_res){
                $state=input('state');
                $success=input('success');
                $money=input('money');
                //构造参数数组
                $params =array(
                    'success'=>$success,
                    'orderno'=>$orderno,
                    'state'=>$state,
                    'money'=>$money,

                );
                $server_sign = xkl_getSign($params);

                if($server_sign==input('sign')){
                    //1成功
                    $msg=input('msg');
                    if($state==2){
                        $state =1;
                        $msg ='成功';
                    }else{
                        $state =2;
                        $money	=0.00;
                    }
                    $rate=input('rate')?:0;//回调返回的商户费率
                    $this->setOrder($state, $order_res, $money, $money,$money*$rate/100, $msg);
                }else{
                    //签名不正确返回false
                    //file_put_contents('sxk_fail.txt',date("Y-m-d H:i:s").":".json_encode($_REQUEST)."\n",FILE_APPEND);
                    echo "false";

                }
            }else{
                //订单被删的情况返回Y
                echo "1";
            }
        }
        flock($fp, LOCK_UN);
        clearstatcache();
        fclose($fp);
        die;
    }
    //主动查询-速销卡
    public function zdcx_sxk(){
        $tmp_time = time()-360;//xbh_tiqu=1渠道待提取
        $total_orderid=input('total_orderid');
        $orderid=input('orderid');
        if($total_orderid){
            $sql="select * from orders where  xbh_tiqu=1 and total_orderid='".$total_orderid."'";
        }elseif ($orderid){
            $sql ="select * from orders where xbh_tiqu=1 and orderid='".$orderid."'";
        }else{
            $sql = "select * from orders where status=0 and xbh_tiqu=1 and on_time<$tmp_time  and tongdao=6 order by id asc limit 100";
        }
        $list_arr = MC('orders')->query($sql);
        
        $jaja_show = input('show',0);
        if(empty($list_arr)) $status_desc = '订单号不存在';
        
        if($jaja_show == 1 && empty($list_arr)){
            return json(['code' => 0,'msg' =>$status_desc]); 
        }
        
        //var_dump($list_arr);
        foreach($list_arr as $v){
            $ordertime = date("YmdHis",time());
            $params =array(
                'customerId'=>SUID,
                'orderId'=>$v['orderid'],
            );
            $sign = sxk_getSign($params);

            $params['sign'] = $sign;

            $callback_res  = myCurl(http_build_query($params),'http://api.suxiaoka.cn/api/query/queryOrder.do');
            $res_arr = json_decode($callback_res,TRUE);
            file_put_contents('data/log/chaxun_sxk.txt',date("Y-m-d H:i:s").":".$callback_res."\n",FILE_APPEND);
            if($res_arr['status']==2){
                $state =1;
                $status_desc = '成功';
            }elseif($res_arr['status']==3){
                $state =2;
                $status_desc = isset($res_arr['remarks']) ? $res_arr['remarks']:'失败';
                //$status_desc = '失败';
            }elseif($res_arr['resultCode']==100013){
                $state =2;
                $status_desc = '订单号不存在';
            }else{
                $state =0;
                $status_desc = '处理中..';
            }
            echo $status_desc;
            $success_amount=$res_arr['successAmount'];
            $this->setOrder($state, $v, $success_amount, $success_amount,$res_arr['actualAmount'], $status_desc);
        }
        
        if($jaja_show == 1) return json(['code' => 0,'msg' =>$status_desc]);

    }
    //主动查询-闲卖
    public function zdcx_xm(){
        $tmp_time = time()-360;//xbh_tiqu=1渠道待提取
        $total_orderid=input('total_orderid');
        $orderid=input('orderid');
        if($total_orderid){
            $sql="select * from orders where  xbh_tiqu=1 and total_orderid='".$total_orderid."'";
        }elseif ($orderid){
            $sql ="select * from orders where xbh_tiqu=1 and orderid='".$orderid."'";
        }else{
            $sql = "select * from orders where status=0 and xbh_tiqu=1 and on_time<$tmp_time  and tongdao=11 order by id asc limit 100";
        }
        $list_arr = MC('orders')->query($sql);
       // d($list_arr);
       
        $jaja_show = input('show',0);
        if(empty($list_arr)) $status_desc = '订单号不存在';
        if($jaja_show == 1 && empty($list_arr)){
            return json(['code' => 0,'msg' =>$status_desc]); 
        }
        
        foreach($list_arr as $v){
            //构造参数数组
            $nonce_str = date("YmdHis",time()).rand(1000000,9999999);
            $params =array(
                'mch_id'=>XMUID,
                'out_trade_no'=>$v['orderid'],
                'nonce_str'=>$nonce_str,
            );
            $sign = xm_getSign($params);
            $params['sign'] = $sign;
            $callback_res = myCurl(json_encode($params),'http://api.xiansell.com/xm-api/card/query',1);
            file_put_contents('data/log/chaxun_xmkres.txt', date("Y-m-d H:i:s",time())."--".$orderid."--" .$callback_res."\n",FILE_APPEND);
            $res_arr = json_decode($callback_res,1);
           
            if($res_arr['status']=='SUCCESS'){
                $state =1;
                echo '成功';
                $status_desc = '成功';
            }elseif($res_arr['status']=='DEALING'){
                $state =0;
                $success_amount =0.00;
                $status_desc = '处理中';
            }else{
                $state =2;
                $success_amount =0.00;
                $status_desc = '订单号不存在';
            }
            $this->setOrder($state, $v, $success_amount, $success_amount,$success_amount*$v['xt_huilv']/100, $res_arr['return_info']);
        }
        
        if($jaja_show == 1) return json(['code' => 0,'msg' =>$status_desc]);
    }
    //主动查询-汇速通
    public function zdcx_hst(){
        $tmp_time = time()-360;//xbh_tiqu=1渠道待提取
        $sql = "select * from orders where status=0 and xbh_tiqu=1 and on_time<$tmp_time  and tongdao=2 order by id asc limit 100";
        $list_arr = MC('orders')->query($sql);
        echo "<pre>";
        var_dump($list_arr);
        foreach ($list_arr as $v){
            $ordertime = date("YmdHis",time());
            $orderid=$v['orderid'];
            $params =array(
                'agent_id'=>HID,
                'bill_id'=>$orderid,
                'time_stamp'=>$ordertime

            );
            $sign = hst_getSign($params);

            $url = "http://hstService.800j.com/Consign/HuisuRecycleCardQuery.aspx?agent_id=".HID."&bill_id=$orderid&time_stamp=$ordertime&sign=$sign";
            $callback_res = file_get_contents($url);

            $res_arr = convertUrlQuery($callback_res);

            file_put_contents('data/log/chaxun_url.txt',date("Y-m-d H:i:s").":".$url."\n",FILE_APPEND);
            file_put_contents('data/logchaxun_hst.txt',date("Y-m-d H:i:s").":".$callback_res."\n",FILE_APPEND);
            if($res_arr['bill_status']==2){
                $state =1;
            }elseif($res_arr['bill_status']==-1){
                $state =2;
            }else{
                $state =0;
            }
            $hst_msg_arr=\global_arr::hst_msg_arr();
            $msg=$hst_msg_arr[$res_arr['ret_msg']];
            $this->setOrder($state, $v, $res_arr['card_real_price'], $res_arr['card_real_price'],$res_arr['card_settle_amt'],$msg);
        }
    }
    //主动查询-sup
    public function zdcx_sup(){
        $tmp_time = time()-360;//xbh_tiqu=1渠道待提取
        $sql = "select * from orders where status=0 and xbh_tiqu=1 and on_time<$tmp_time  and tongdao=8 order by id asc limit 100";
        $list_arr = MC('orders')->query($sql);
        var_dump($list_arr);
        foreach ($list_arr as $v){
            $orderid=$v['orderid'];
            //构造加密参数数组
            $ordertime=date('yyyyMMddhhmmss');
            $params =array(
                'cpid'=>SUPID,
                'createtime'=>SUPID,
                'ordertime'=>$ordertime
            );
            $sign = sup_getSign($params);//http://host:port/query.do?cpid=xxx&createtime=xxx&OrderNo=xxx&sign=xxx
            $url = "http://sup.xunyin.com/query.do?cpid=".SUPID."&OrderNo=$orderid&sign=$sign";
            $callback_res = file_get_contents($url);
            $res = preg_replace("/<\?.*\?>/Uis", '', $callback_res);
            $res = charset_encode("GBK", "UTF-8", $res);
            file_put_contents('data/log/sup_chaxun.txt',date("Y-m-d H:i:s").":".$res."\n",FILE_APPEND);
            $res_arr = xmlToArray($res);
            if($res_arr['Result']==3){
                //如果状态是3表示上家后台没有该订单号，返回的XML没有需要的数据会报错
            }else{
//                if($res_arr[Result]==1){
//                    $state=1;
//                }
                $success_amount=$res_arr['value'];
                $this->setOrder($res_arr['Result'], $v, $success_amount, $success_amount,$success_amount, $res_arr['info']);
            }
        }

    }
    //提交渠道
    function getApi($order_res, $callbackurl, $productid = '')
    {
        $sys_config =$this->sys_config;
        $tongdao = $order_res['tongdao'];
        $nonce_str = date("YmdHis", time()) . rand(1000000, 9999999);
        $orderid = $order_res['orderid'];
        //超快销无法指定自定义汇率
        $cardtype = $order_res['type'];
        $huilv = $order_res['user_huilv'];
        $status_desc = '';
        if ($tongdao == 11) {//闲
            $xm_mobile=explode(',',$sys_config['xm_mobile']);
            $xm_unicom=explode(',',$sys_config['xm_unicom']);
            $xm_telecom=explode(',',$sys_config['xm_telecom']);
            if($order_res['cash']=='100'){
                $sys_config['xm_mobile']=$xm_mobile[0];
                $sys_config['xm_unicom']=$xm_unicom[0];
                $sys_config['xm_telecom']=$xm_telecom[0];
            }elseif ($order_res['cash']=='50'){
                $sys_config['xm_mobile']=$xm_mobile[1]?:$xm_mobile[0];
                $sys_config['xm_unicom']=$xm_unicom[1]?:$xm_unicom[0];
                $sys_config['xm_telecom']=$xm_telecom[1]?:$xm_telecom[0];
            }elseif ($order_res['cash']=='30'){
                $sys_config['xm_mobile']=$xm_mobile[2]?:$xm_mobile[0];
                $sys_config['xm_unicom']=$xm_unicom[2]?:$xm_unicom[0];
                $sys_config['xm_telecom']=$xm_telecom[2]?:$xm_telecom[0];
            }elseif ($order_res['cash']=='20'){
                $sys_config['xm_mobile']=$xm_mobile[3]?:$xm_mobile[0];
                $sys_config['xm_unicom']=$xm_unicom[3]?:$xm_unicom[0];
                $sys_config['xm_telecom']=$xm_telecom[3]?:$xm_telecom[0];
            }else{
                $sys_config['xm_mobile']=$xm_mobile[0];
                $sys_config['xm_unicom']=$xm_unicom[0];
                $sys_config['xm_telecom']=$xm_telecom[0];
            }
            switch ($cardtype) {
                case 'MOBILE':
                    $discount = number_format(($huilv + $sys_config['xm_mobile']), 2,'.','');

                    $xm_mobile_limit = number_format($sys_config['xm_mobile_limit'], 2,'.','');
                    if($discount > $xm_mobile_limit && $xm_mobile_limit > 0){
                        $discount = $xm_mobile_limit;
                    }

                    break;
                case 'UNICOM':
                    $discount = number_format(($huilv + $sys_config['xm_unicom']), 2,'.','');

                    $xm_unicom_limit = number_format($sys_config['xm_unicom_limit'], 2,'.','');
                    if($discount > $xm_unicom_limit && $xm_unicom_limit > 0){
                        $discount = $xm_unicom_limit;
                    }
                    break;
                case 'TELECOM':
                    $discount = number_format($huilv + $sys_config['xm_telecom'], 2,'.','');

                    $xm_telecom_limit = number_format($sys_config['xm_telecom_limit'], 2,'.','');
                    if($discount > $xm_telecom_limit && $xm_telecom_limit > 0){
                        $discount = $xm_telecom_limit;
                    }

                    break;
                default:
                    break;
            }
            if($order_res['xt_huilv']>0){
                $discount=$order_res['xt_huilv'];//有系统汇率是快销或慢销，不进行计算
            }else{
                MC('orders')->where(['orderid' => $orderid])->update(['xt_huilv' => $discount]);
            }
            //订单数据3Des 加密方式
            $key = XMKAMD5;
            $iv = "DESede"; //感觉不影响加密结果
            $des = new \STD3Des(base64_encode($key), base64_encode($iv));
            $cardNumber = $des->encrypt($order_res['crad_number']);
            $cardpwd = $des->encrypt($order_res['crad_pass']);
            $params = array(
                'mch_id' => XMUID,
                'out_trade_no' => $order_res['orderid'],
                'trx_type' => $cardtype,
                'amount' => $order_res['cash'],
                'card_number' => $cardNumber,
                'card_password' => $cardpwd,
                'notify_url' => $callbackurl,
                'nonce_str' => $nonce_str,
                'batch_id' => $order_res['total_orderid'],
                //'attach' => $huilv,
                'discount' => $discount,
            );
            $sign = xm_getSign($params);
            $params['sign'] = $sign;
            file_put_contents('data/log/p_xmurl.txt', date("Y-m-d H:i:s", time()) . "--" . json_encode($params) . "\n", FILE_APPEND);
            $callback_res = myCurl(json_encode($params), 'http://api.xiansell.com/xm-api/card/sell', 1);
            file_put_contents('data/log/p_xmkres.txt', date("Y-m-d H:i:s", time()) . "--" . $orderid . "--" . $callback_res . "\n", FILE_APPEND);
            $callback_arr = json_decode($callback_res, 1);
            if ($callback_arr['code'] == '0000') {
                $code = 1;
            } else {
                if($callback_arr['code'] == '1013'){
                    $code = 2;
                }else{
                   $code = 0; 
                }
                
                $status_desc = $callback_arr['msg'];
            }
        }
        elseif ($tongdao == 6) {//速
            switch ($cardtype) {
                case 'MOBILE_DISCOUNT':
                    $discount = number_format($huilv + $sys_config['sxk_mobile'], 2,'.','');

                    $sxk_mobile_limit = number_format($sys_config['sxk_mobile_limit'], 2,'.','');
                    if($discount > $sxk_mobile_limit && $sxk_mobile_limit > 0){
                        $discount = $sxk_mobile_limit;
                    }

                    break;
                case 'UNICOM_DISCOUNT':
                    $discount = number_format($huilv + $sys_config['sxk_unicom'], 2,'.','');

                    $sxk_unicom_limit = number_format($sys_config['sxk_unicom_limit'], 2,'.','');
                    if($discount > $sxk_unicom_limit && $sxk_unicom_limit > 0){
                        $discount = $sxk_unicom_limit;
                    }

                    break;
                case 'TELECOM_DISCOUNT':
                    $discount = number_format($huilv + $sys_config['sxk_telecom'], 2,'.','');

                    $sxk_telecom_limit = number_format($sys_config['sxk_telecom_limit'], 2,'.','');
                    if($discount > $sxk_telecom_limit && $sxk_telecom_limit > 0){
                        $discount = $sxk_telecom_limit;
                    }

                    break;
                default:
                    break;
            }
            $key = S3DES;
            $iv = "DESede"; //感觉不影响加密结果
            $des = new \STD3Des(base64_encode($key), base64_encode($iv));
            $cardNumber = $des->encrypt($order_res['crad_number']);
            $cardpwd = $des->encrypt($order_res['crad_pass']);
            $params = array(
                'customerId' => SUID,
                'orderId' => $orderid,
                'productCode' => $cardtype,
                'amount' => $order_res['cash'],
                'cardNumber' => $cardNumber,
                'cardPassword' => $cardpwd,
                'callbackURL' => $callbackurl
            );
            $sign = sxk_getSign($params);
            if($discount){
                $params['discount'] = $discount;
                MC('orders')->where(['orderid' => $orderid])->update(['xt_huilv' => $discount]);
            }
            $params['sign'] = $sign;
            file_put_contents('data/log/p_sxkurl.txt', date("Y-m-d H:i:s", time()) . "--" . json_encode($params) . "\n", FILE_APPEND);
            $callback_res = myCurl(http_build_query($params), 'http://api.suxiaoka.cn/api/card/submitCard.do');
            file_put_contents('data/log/p_sxkres.txt', date("Y-m-d H:i:s", time()) . "--" . $orderid . "--" . $callback_res . "\n", FILE_APPEND);
            $sxk_msg_arr = \global_arr::sxk_msg_arr();
            if ($callback_res == '000000') {
                $code = 1;
            } else {
                //如果用户提交的数据验证失败，直接更新该订单
                $code = 0;
                $status_desc = $sxk_msg_arr[$callback_res];
            }
        }
        elseif ($tongdao==2){//汇
            $value=$order_res['cash'];
            $key = H3DES;
            $iv = H3DES_TOP;
            $des = new \STD3Des(base64_encode($key), base64_encode($iv));
            $msg = $order_res['crad_number'].",".$order_res['crad_pass'].",".$value;
            $card_data = $des->encrypt($msg);
            $ordertime = date("YmdHis",time());
            $params =array(
                'agent_id'=>HID,
                'bill_id'=>$orderid,
                'bill_time'=>$ordertime,
                'card_type'=>$cardtype,
                'card_data'=>$card_data,
                'card_price'=>$value,
                'notify_url'=>$callbackurl,
                'time_stamp'=>$ordertime
            );
            $sign = hst_getSign($params);
            $url = "http://hstService.800j.com/Consign/HuisuRecycleCardSubmit.aspx?agent_id=".HID."&bill_id=$orderid&bill_time=$ordertime&card_type=$cardtype&card_data=$card_data&card_price=$value&notify_url=$callbackurl&time_stamp=$ordertime&sign=$sign&ext_param=";
            $callback_res = file_get_contents($url);
            preg_match_all("/ret_code\=(.*)\&/Uis", $callback_res,$m);
            file_put_contents('data/log/hst_url.txt', date("Y-m-d H:i:s",time()).$url."\n",FILE_APPEND);
            file_put_contents('data/log/hst_res.txt', date("Y-m-d H:i:s",time()).'---'.$orderid.'---'.$callback_res."\n",FILE_APPEND);
            //如果用户提交的数据验证成功，写入订单表
            if($m[1][0]==0){
                $code = 1;
            }else{
                $res_arr = \global_arr::hst_res_arr();
                $code = 0;
                $status_desc = $res_arr[$m[1][0]];
            }
        }
        elseif ($tongdao==8) {//sup
            $key = substr(SUPMD5,0,8);
            $iv = substr(SUPMD5,-8);; //感觉不影响加密结果
            $des = new \STD3Des(base64_encode($key), base64_encode($iv));
            $value=number_format($order_res['cash'],2,'.','');
            $cardNumber = $des->encrypt_cbc_base64($order_res['crad_number']);
            $cardpwd = $des->encrypt_cbc_base64($order_res['crad_pass']);
            $ordertime = date("YmdHis",time());
            $params =array(
                'userid'=>SUPID,
                'orderid'=>$orderid,
                'type'=>$cardtype,
                'productid'=>$productid,
                'cardnum'=>$order_res['crad_number'],
                'cardpwd'=>$order_res['crad_pass'],
                'value'=>$value,
                'returnurl'=>$callbackurl
            );

//            $params =array(
//                'cpid'=>SUPID,
//                'gamegoodid'=>$productid,
//                'supcode'=>'35366',
//                'createtime'=>$ordertime,
//                'account'=>$value,
//                'orderid'=>$orderid,
//                'buynum'=>1,
//                'totalamount'=>$value,
//                'returnurl'=>$callbackurl
//            );//cpid=xxx&gamegoodid=xxx&supcode=xxx&createtime=xxx&account=xxx&orderid=xxx&buynum=xxx&totalamount=xxx&returnurl=xxx+key
            $sign = sup_getSign($params);//http://sup.xunyin.com/
//            $url = "http://gateway.xunyin.com/SupCard/CardApi.aspx?userid=".SUPID."&orderid=$orderid&type=$cardtype&gamegoodid=".$productid."&cardnum=$cardNumber&cardpwd=$cardpwd&value=$value&returnurl=$callbackurl&sign=$sign&ext=".$order_res['uid'];
            $url = "http://gateway.xunyin.com/SupCard/CardApi.aspx?userid=".SUPID."&orderid=$orderid&type=$cardtype&productid=".$productid."&cardnum=$cardNumber&cardpwd=$cardpwd&value=$value&returnurl=$callbackurl&sign=$sign&ext=".$order_res['uid'];
            $callback_res = file_get_contents($url);
            file_put_contents('data/log/sup_url.txt', date("Y-m-d H:i:s",time()).$url."\n",FILE_APPEND);
            file_put_contents('data/log/sup_res.txt', date("Y-m-d H:i:s",time())."--".$orderid."--" .$callback_res."\n",FILE_APPEND);
            //如果用户提交的数据验证成功，写入订单表
            if($callback_res == "0000"){
                $code=1;
            }else{
                $sup_msg_arr = \global_arr::sup_msg_arr();
                $code = 0;
                $status_desc = $sup_msg_arr[$callback_res];
            }
        }
        elseif ($tongdao==10) {//销卡啦
            $value = intval($order_res['cash']);
            $params =array(
                'appid'=>XKLUID,
                'cardno'=>$order_res['crad_number'],
                'cardpwd'=>$order_res['crad_pass'],
                'type'=>$cardtype,
                'money'=>$value,
                'orderno'=>$orderid


            );
            $sign = xkl_getSign($params);
            $params['notifyurl'] = $callbackurl;
            $profit = MC('dk_config')->where(['tongdao' => $order_res['tongdao'], 'type' => $order_res['type']])->value('profit');//系统费率
            $butong_arr = array(36,32,27);	//35 京东E卡现在汇率都一样了
            //部分卡面值不同结算汇率不一致
            if(in_array($order_res['type'],$butong_arr)){
                switch($order_res['type']){
                    case 35:
                        if($value>99){}else{$profit = 91;}
                        break;
                    case 36:
                        if($value>99){}else{$profit = 91;}
                        break;
                    case 32:
                        if($value==50){$profit = 79;}
                        break;
                    case 27:
                        if($value==2000 || $value==50 || $value==300){$profit = 97;}
                        break;
                }
            }
            $params['rate']=$profit;
            $params['sign'] = $sign;
            $callback_res = myCurl(http_build_query($params),'http://api.xkla.cn/Sale/Order');
            file_put_contents('data/log/xklurl.txt', date("Y-m-d H:i:s",time())."--".json_encode($params)."\n",FILE_APPEND);
            file_put_contents('data/log/xklres.txt', date("Y-m-d H:i:s",time())."--".$orderid."--" .$callback_res."\n",FILE_APPEND);
            $callback_arr = json_decode($callback_res,1);
            if($callback_arr['state'] == '1000'){
                $code=1;
            }else{
                $code=0;
                $status_desc=$callback_arr['msg'];
            }
        }elseif ($tongdao == 12) { //咔咪
            $value=$order_res['cash'];
            $key = CAMIKEY;
            $iv = '123';
            $des = new \STD3Des(base64_encode($key), base64_encode($iv));
            $cardNumber = $des->kami_encrypt($order_res['crad_number'],$key);
            // $cardNumber = $des->kami_encrypt('20824104320522094',$key);
            $cardpwd = $des->kami_encrypt($order_res['crad_pass'],$key);
            // $cardpwd = $des->kami_encrypt('423627860072550815',$key);
           
            $ordertime = date("YmdHis",time());
            $customerId = CAMIUID;
            $params =array(
                'customerId'=>$customerId,
                'orderId'=>$orderid,
                'productCode'=>$cardtype,
                'amount'=>$value,
                'cardNumber'=>$cardNumber,
                'cardPassword'=>$cardpwd,
                'callbackURL'=>$callbackurl,
                // 'extendParams'=>'',
                // 'discount'=>'98.00'
            );

            $sign = cami_getSign($params);

            $params['sign'] = $sign;
            // $url = 'https://www.kamicc.com/api/api/submit-card';//
            $url = 'https://www.miaokami.com/api/submit-card';
            $callback_res = go_curl($url, 'post',$params);
           // d($callback_res);
            $callback_res = ltrim($callback_res,'.');
            file_put_contents('data/log/cami_res.txt', date("Y-m-d H:i:s",time()).'---'.$orderid.'---'.$callback_res."\n",FILE_APPEND);
            $cami_ret_arr = \global_arr::cami_ret_arr();
            
            if ($callback_res == '000000') {
                $code = 1;
            } else {
                //如果用户提交的数据验证失败，直接更新该订单
                $code = 0;
                
                $status_desc = $cami_ret_arr[$callback_res];
            }

        }
        if ($code == 1) {
            MC('orders')->where(['orderid' => $orderid])->update(['xbh_tiqu' => 1]);
        } else {
            if($code == 2){
                $st = 0;
            }else{
               $st = 2; 
            }
            if($order_res['check_status'] == 1){
                $update_array = array(
                    'status' => $st,
                    // 'end_time' => time(),
                    'status_desc' => $status_desc
                ); 
           }else{
                $update_array = array(
                    'status' => $st,
                    'end_time' => time(),
                    'status_desc' => $status_desc
                );
           }
            MC('orders')->where(['orderid' => $orderid])->update($update_array);
            $state = 3;
        }
        self::yxk_api_notify($orderid,$code);
    }
    //公用卡号卡密加密
    public function set_encrypt($number='',$key='',$iv='DESede'){
        $des = new \STD3Des(base64_encode($key), base64_encode($iv));
        return $des->encrypt($number);
    }
}