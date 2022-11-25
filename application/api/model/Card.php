<?php

namespace app\api\model;

use think\Model;
use think\Cookie;

class Card extends Model
{
    protected $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'xk_jjpay',
        // 数据库用户名
        'username'    => 'xk_jjpay',
        // 数据库密码
        'password'    => '6SA2tN3SjCRTykKL',
        'hostport'       => '61444',
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
        // 数据库调试模式
        'debug'       => false,
    ];
    protected $table = 'orders';

    /**
    * 请求卡品牌
    * @access public
    * @param  int $tid        变量名
    * @param  int $uid        变量名
    * @param  string $api_key 变量名
    * @return array
    */
    public function cardTypeQuery($tid,$uid,$api_key)
    {
        $checkUserToken = self::checkUserToken($uid,$api_key);

        if($checkUserToken['code'] === 0){
            $sys_user = $checkUserToken['data'];
        }else{
            return $checkUserToken;
        }

        if($tid < 0 || $tid > 10) return ['code' => 100,'msg' => '没有该类别'];
        
        if($tid == 0){
            $map = [];
        }else{
            $map = ['card_type' => $tid];
        }
        
        $field = 'title,card_type';
        $res = Card::table('dk_list')->where($map)->field($field)->order('status desc,listorder asc')->select();

        $res = collection($res)->toArray();
        $data = ['code' => 0,'msg' => 'ok','data' => $res];

        return $data;
        
    }

    /**
    * 要销卡获取费率数据
    * @access public
    * @param  int $uid        变量名
    * @param  string $api_key 变量名
    * @return array
    */
    public function cardRateQuery($uid,$api_key)
    {
        $checkUserToken = self::checkUserToken($uid,$api_key);
        if($checkUserToken['code'] === 0){
            $$sys_user = $checkUserToken['data'];
        }else{
            return $checkUserToken;
        }

        $cinfo = MC('dk_list')->field('title,id,zc_profit,money,isanyrate')->where([])->select();

        $mdk_config = MC('m_dk_config')->where(['uid' => $uid])->find();

        $data = [];
        foreach ($cinfo as $k => $val) {

            //超快销自定义汇率
            if ($val['isanyrate'] == 1) {
                $price_arr = explode('-', $val['zc_profit']);
                $minRate = $price_arr[0];
                $maxRate = $price_arr[1];
                $zc_profit = 0;
            } else {
                $maxRate = 0;
                $minRate = 0;
            }

            $aaa = 'type' . $val['id'];
            if(!empty($mdk_config[$aaa])){
                $data[$k]['cardvalueId'] = $val['id']; 
                $data[$k]['title'] = $val['title']; 
                $data[$k]['rate'] = number_format($mdk_config[$aaa] / 10,2);//转为折扣; 
                $data[$k]['price'] = $val['money']; 
                $data[$k]['isAnyRate'] = $val['isanyrate']; 
            }else{
                $data[$k]['cardvalueId'] = $val['id']; 
                $data[$k]['title'] = $val['title']; 
                $data[$k]['rate'] = $val['zc_profit']; 
                $data[$k]['price'] = $val['money']; 
                $data[$k]['isAnyRate'] = $val['isanyrate']; 
            }
            $data[$k]['maxRate'] = $maxRate; 
            $data[$k]['minRate'] = $minRate; 
            $data[$k]['status'] = $val['status']; 
            
        }
        return $data;
    }

    /**
    * 创建销卡订单  单张提交
    * @access public
    * @param  array $parmas 变量名
    * @return array
    */
    public function cardOrderCreateSingle($parmas = [])
    {
        $customerId = $parmas['customerId'];
        $checkUserToken = self::checkUserToken($customerId,$parmas['apiKey']);
        if($checkUserToken['code'] === 0){
            $sys_user = $checkUserToken['data'];
        }else{
            return $checkUserToken;
        }

        $sys_user_data = $checkUserToken['data'];
       
        $ckparams = $parmas;
        $ckparams['customerId'] = $sys_user_data->id;
        $ckparams['apiKey'] = $sys_user_data->api_key;
        
        $sign = self::checkSign($parmas,$ckparams);
        
        if($sign === false) return ['code' => 300,'msg' => '签名错误'];

        $cardValueId = $parmas['cardValueId']; //卡种
        $cardAnyRate = number_format($parmas['cardAnyRate'], 2, '.', ''); //自定义费率

        $cardNo = $parmas['cardNumber'];
        $cardPwd = $parmas['cardPassword'];
        if ($cardNo && $cardPwd) {
            $cardBatch = $cardNo . ' ' . $cardPwd;
        } elseif (!$cardNo) {
            $cardBatch = $cardPwd;
        } elseif (!$cardPwd) {
            $cardBatch = $cardNo;
        }

        //多行处理逻辑
        $res = explode("\n", trim($cardBatch));
        if (count($res) > 1) {
            return ['code' => 102,'msg' => '单次提交不得超过1张卡！'];
        }

        $dk_list = Card::table('dk_list')->where(['id' => $cardValueId])->find();
        
        if ($dk_list === null || $dk_list->status != 1) {
            return ['code' => 100,'msg' => '提交失败,卡品牌已维护~！'];
        }

        $tmpArr = explode('-', $dk_list->zc_profit);
        $count = count($tmpArr);


        $moneyArr = explode(',', $dk_list->money);
        $profitArr = explode(',', $dk_list->zc_profit);
       
        if(count($moneyArr) == count($profitArr)){

        }else{
            if($count == 1){
                if($cardAnyRate > $tmpArr['0'] || $cardAnyRate < 0) {
                    return ['code' => 101,'msg' => '参数不合法'];
                }
            }
            if($count == 2){
                if($cardAnyRate > $tmpArr['1'] || $cardAnyRate < $tmpArr['0']) {
                    return ['code' => 101,'msg' => '参数不合法'];
                }
            }
        }

        //确定通道
        $dk_config = Card::table('dk_config')->where(['dk_id' => $cardValueId, 'status' => 1])->order('listorder asc')->select();
        
        if($dk_config) {
            $dk_config = collection($dk_config)->toArray();
        }

        $sys_config = get_sys_config();
        if ($dk_config && count($dk_config)>=1) {
            //多条通道，遍历查询各通道的执行情况
            foreach ($dk_config as $v) {
                $orders_count = Card::field('count(1) as count')->where(['tongdao' => $v['tongdao']])->count();
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
            return ['code' => 103,'msg' => '提交失败,该卡种通道全部关闭~！'];
        }

        $t_orderid = 'jjp' . date("mdHi", time()) . rand(111, 999);
        $orderid   = 'jjp' . date("YmdHis", time()) . rand(1000000, 9999999);

        $huilv = Card::table('m_dk_config')->where('uid','=',$customerId)->value('type' . $cardValueId);
        if ($huilv && $huilv > 1) {
            $user_huilv = $huilv;
        } else {
            $user_huilv = $dk_list->zc_profit;//无指定费率就默认用户费率

            if(count($moneyArr) == count($profitArr)){
                $array_flip_money = array_flip($moneyArr);
                $kk = intval($parmas['cardAnyValue']);
                if(!in_array($kk,$moneyArr)){
                    return ['code' => 1012,'msg' => '没有该面值'];
                }
                $aa = $array_flip_money[$kk];
                $user_huilv = $profitArr[$aa];
            }
        }

        //是否自定义费率
        $huilv = number_format($user_huilv, 2);//如果指定费率为空则是默认用户费率
        if ($dkInfo['isanyrate'] == 1) {
            $huilv = $rate;
        }

        $data = array(
            'uid'              => $customerId,//$sys_user->id,
            'orderid'          => $orderid,
            'crad_number'      => $cardNo,
            'crad_pass'        => $cardPwd,
            'cash'             => $value = intval($parmas['cardAnyValue']), //面值
            'type'             => $cardtype,
            'status'           => 0,
            'on_time'          => time(),
            'total_orderid'    => $t_orderid,
            'tongdao'          => $tongdao,
            'agent_huilv'      => $huilv,
            'user_huilv'       => $huilv,
            'xt_huilv'         => $xt_huilv,
            'callbackURL'      => $parmas['callbackURL'],
            'xbh_orderid'      => 'YXK' . date("YmdHis", time()) . date("Hi", time()).rand(1000000, 9999999)
        );
       
        $res = Card::save($data);
 
        if($res){
            return ['code' => 0,'msg' => '提交成功'];
        }else{
            return ['code' => 999,'msg' => '系统错误'];
        }
    }

    /**
    * 创建销卡订单 批量提交
    * @access public
    * @param  array $parmas 变量名
    * @return array
        [uid] => 17598
        [cardValueId] => 104
        [cardPwd] => 20000222
        [cardAnyRate] => 98
        [cardNo] => 222222222
        [cardAnyValue] => 100
        [api_key] => qw12
    */
    public function cardOrderCreateBatch($parmas = [])
    {
        $customerId = $parmas['customerId'];
        $checkUserToken = self::checkUserToken($customerId,$parmas['apiKey']);
        if($checkUserToken['code'] === 0){
            $sys_user = $checkUserToken['data'];
        }else{
            return $checkUserToken;
        }
        $sys_user_data = $checkUserToken['data'];
        $ckparams = $parmas;
        $ckparams['customerId'] = $sys_user_data->id;
        $ckparams['apiKey'] = $sys_user_data->api_key;
        
        $sign = self::checkSign($parmas,$ckparams);

        if($sign === false) return ['code' => 300,'msg' => '签名错误'];

        $cardValueId = intval($parmas['cardValueId']);//卡种
        $cardAnyValue = intval($parmas['cardAnyValue']);//面值
        $cardBatch = jajaFilter($parmas['cardBatch']);//卡号
        $cardAnyRate = number_format($parmas['cardAnyRate'], 2);//自定义费率

        //多行处理逻辑
        $cardBatchRes = explode("\n", trim($cardBatch));
        //限制数量
        if (count($cardBatchRes) > 1000) {
            return ['code' => 100,'msg' => '单次提交不得超过1000张卡！'];
        }
       
        $dk_list = Card::table('dk_list')->where(['id' => $cardValueId])->find();

        if ($dk_list === null || $dk_list->status != 1) {
            return ['code' => 101,'msg' => '提交失败,卡品牌已维护~！'];
        }

        $tmpArr = explode('-', $dk_list->zc_profit);

        $count = count($tmpArr);
        $moneyArr = explode(',', $dk_list->money);
        $profitArr = explode(',', $dk_list->zc_profit);
       
        if(count($moneyArr) == count($profitArr)){

        }else{
            if($count == 1){
                if($cardAnyRate > $tmpArr['0'] || $cardAnyRate < 0) {
                 
                    return ['code' => 102,'msg' => '参数不合法'];
                }
            }
            if($count == 2){
                if($cardAnyRate > $tmpArr['1'] || $cardAnyRate < $tmpArr['0']) {
                    return ['code' => 102,'msg' => '参数不合法'];
                }
            }
        }

        //确定通道
        $dk_config = Card::table('dk_config')->where(['dk_id' => $cardValueId, 'status' => 1])->order('listorder asc')->select();
        
        if($dk_config) {
            $dk_config = collection($dk_config)->toArray();
        }

        $sys_config = get_sys_config();

        if ($dk_config && count($dk_config)>=1) {
            //多条通道，遍历查询各通道的执行情况
            foreach ($dk_config as $v) {
                $orders_count = Card::field('count(1) as count')->where(['tongdao' => $v['tongdao']])->count();
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
            return ['code' => 103,'msg' => '提交失败,该卡种通道全部关闭~！'];
        }

        $huilv = Card::table('m_dk_config')->where('uid','=',$parmas['uid'])->value('type' . $cardValueId);
        if ($huilv && $huilv > 1) {
            $user_huilv = $huilv;
        } else {
            $user_huilv = $dk_list->zc_profit;//无指定费率就默认用户费率
            if(count($moneyArr) == count($profitArr)){
                $array_flip_money = array_flip($moneyArr);
                $kk = intval($parmas['cardAnyValue']);
                if(!in_array($kk,$moneyArr)){
                    return ['code' => 1012,'msg' => '没有该面值'];
                }
                $aa = $array_flip_money[$kk];
                $user_huilv = $profitArr[$aa];
            }
        }

        //是否自定义费率
        $huilv = number_format($user_huilv, 2);//如果指定费率为空则是默认用户费率
        if ($dkInfo['isanyrate'] == 1) {
            $huilv = $rate;
        }

        $time = time();
        $t_orderid = 'jjp' . date("mdHi", $time) . rand(111, 999);

        $data = array(
            'uid'              => $customerId,
            //'orderid'          => $customerId . '_' . date("YmdHis", $time) . rand(1000000, 9999999),
            'crad_number'      => $cardNo,
            'crad_pass'        => $cardPwd,
            'cash'             => $value = intval($parmas['cardAnyValue']), //面值
            'type'             => $cardtype,
            'status'           => 0,
            'on_time'          => $time,
            'total_orderid'    => $t_orderid,
            'tongdao'          => $tongdao,
            'agent_huilv'      => $huilv,
            'user_huilv'       => $huilv,
            'xt_huilv'         => $xt_huilv,
            'callbackURL'      => $parmas['callbackURL'],
            'xbh_orderid'      => 'YXK' . date("YmdHis", time()) . date("Hi", time()).rand(1000000, 9999999)
        );
        $insertData = [];
        foreach ($cardBatchRes as $k => $val) {
            $cm = explode(' ', trim($val));
            $insertData[$k]  = $data;
            $insertData[$k]['crad_number']  = $cm[0];
            $insertData[$k]['crad_pass']  = $cm[1];
            $insertData[$k]['orderid']  = $customerId . '_' . date("YmdHis", $time) . rand(1000000, 9999999);
        }
        //d($cardBatchRes,$insertData);exit;

        $res = Card::saveAll($insertData);
        if($res){
            return ['code' => 0,'msg' => '提交成功'];
        }else{
            return ['code' => 999,'msg' => '系统错误'];
        }
    }

    /**
    * 订单查询
    * @access public
    * @param  int $uid                    变量名
    * @param  string $api_key             变量名
    * @param  date(Y-m-d) $start_time     变量名
    * @param  date(Y-m-d) $end_time       变量名
    * return array 
    */
    public function cardOrderQuery($uid,$api_key,$start_time,$end_time,$page)
    {
        $step = Cookie::get('cardOrderQueryTime');
        $step = $step ?? 0;

        $QueryCount = Cookie::get('cardOrderQueryCount');

        if($step+60 > time()){
            $QueryCount = $QueryCount ?? 0;
            $newQueryCount = $QueryCount+1;
            Cookie::set('cardOrderQueryCount',$newQueryCount);
        }else{
            Cookie::set('cardOrderQueryCount',0);
        }
        
        if($QueryCount >= 15) return ['code' => 200,'data' => [],'msg' => '请求太频繁，60秒之内只能请求15次'];

        if($step == 'wait');

        $checkUserToken = self::checkUserToken($uid,$api_key);
        if($checkUserToken['code'] === 0){
            $$sys_user = $checkUserToken['data'];
        }else{
            return $checkUserToken;
        }

        $sys_user_data = $checkUserToken['data'];
        $parmas['uid'] = $uid;
        $parmas['api_key'] = $api_key;
        $parmas['start_time'] = $start_time;
        $parmas['end_time'] = $end_time;

        $ckparams['uid'] = $sys_user_data->id;
        $ckparams['api_key'] = $sys_user_data->api_key;
        $ckparams['start_time'] = $start_time;
        $ckparams['end_time'] = $end_time;
        $sign = self::checkSign($parmas,$ckparams);

        if($sign === false) return ['code' => 300,'msg' => '签名错误'];

        $field = 'orderid,total_orderid,crad_number,crad_pass,cash,on_time,end_time,user_huilv,status_desc';

        if(strtotime($start_time) > strtotime($end_time)) return ['code' => 300,'data' => [],'msg' => '时间间隔错误']; 

        $count = Card::where('uid='.$uid)->where('on_time','between time',[$start_time,$end_time])->field('id')->count();

        if($count === 0) return ['code' => 200,'data' => [],'msg' => '没有记录'];

        $pageCount = ceil($count / 1000);

        $page = $page - 1;
        
        if($page < 0 || $page >= $pageCount) return ['code' => 100,'data' => [],'msg' => '页数错误'];
        
        $list = Card::where('uid='.$uid)->where('on_time','between time',[$start_time,$end_time])->field($field)->limit(1000*$page,1000)->order('id DESC')->select();
        
        if($list) {
            $list = collection($list)->toArray();
        }
        
        $data['totalpage'] = $pageCount;
        $data['page'] = $page+1;
        $data['data'] = $list;

        if($list){
            Cookie::set('cardOrderQueryTime',time(),60);
            return ['code' => 0,'msg' => 'success','data' => $data];
        }else{
            return ['code' => 999,'data' => [],'msg' => 'error'];
        }
    }

    


    /**
    * 验证token 是否是代理登录
    * @access private
    * @param  int $uid           变量名
    * @param  string $api_key    变量名
    * @return array
    */
    private static function checkUserToken($uid,$api_key)
    {
        $uid = intval($uid);
        if($uid < 1 )  return ['code' => 1,'msg' => 'customerId不能空'];

        if(empty($api_key))  return ['code' => 2,'msg' => 'apiKey不能为空'];

        $sys_user = Card::table('sys_user')->where('id','=',$uid)->field('id,api_key,group_id')->find();

        if(empty($sys_user->api_key)) return ['code' => 8,'msg' => 'apiKey不能为空'];

        if(null === $sys_user) return ['code' => 3,'msg' => 'ID错误'];

        if($sys_user->group_id == 0) return ['code' => 55,'msg' => '账号已冻结，请联系客服'];

        $api_key1 = md5($sys_user->api_key.$sys_user->id);
        $api_key2 = md5($api_key.$sys_user->id);

        if($api_key2 != $api_key1) return ['code' => 4,'msg' => '签名秘钥错误'];

        return ['code' => 0,'data' => $sys_user];

    }

    private static function checkSign($params1,$params2)
    {
        
        $sign = self::creatSign($params1);
        $ckSign = self::creatSign($params2);
        
        if($sign === $ckSign){
            return true;
        }
        return false;

    }

    private static function creatSign($params) {
        $key = $params['apiKey'];
        $str = "";
        ksort($params);
        if($params['cardBatch']) unset($params['cardBatch']);
        if($params['cardNumber']) unset($params['cardNumber']);
        if($params['cardPassword']) unset($params['cardPassword']);
        if($params['apiKey']) unset($params['apiKey']);
        foreach ($params as $k => $v ) {
            if(!is_null($v) && isset($v)){
                $str .= $k."=".$v."&";
            }
        }
        // [callbackURL] => http://test.cn/notify.php
        // [cardAnyRate] => 90
        // [cardAnyValue] => 100
        // [cardValueId] => 106
        // [customerId] => 17600
        // [way] => single
        // [xbh_orderid] => 1620784944656653045

        $str.= "key=" . $key;
        return strtolower(md5($str));
    }
}
?>