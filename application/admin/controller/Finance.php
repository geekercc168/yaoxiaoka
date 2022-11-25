<?php

namespace app\admin\controller;
// use think\Db;
// use think\Request;

import('lib.global_arr', EXTEND_PATH);

class Finance extends Home
{
    //提现列表
    public function lists(){
        if(request()->isAjax()){
            $parm = input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            return tixian_list($parm);
        }else{
            return  view();
        }
    }
    public function notice_tx_shen_he()
    {
        $bj = time()-100;
        $res = MC('tixian_log')->where("status=0 and create_time>=".$bj)->find();

        $res ? $tx_bj=1 : $tx_bj=0;

        return json(['code' => $tx_bj]);
    }
    //提现设置
    public function config(){
        if(Request()->isPost()){
            $insert_arr = array(
                "fee"=>input('txt_fee'),
                "need_truename_auth"=>input('need_truename_auth'),
                "need_face"=>input('need_face'),
                "need_kjt"=>input('need_kjt'),
                "need_zfb"=>input('need_zfb'),
            );
            $re=MC('tx_config')->where('id=1')->update($insert_arr);
            $re ? $code=1:$code=0;
            return mac_return($code);
        }else{
            $item=MC('tx_config')->find();
            $this->assign('item',$item);
            return view();
        }

    }
    //提现审核
    public function tx_shenhe(){
        $bj =time()-100;
        $res=MC('tixian_log')->where("status=0 and create_time>=".$bj)->find();
        $res ? $tx_bj=1 : $tx_bj=0;
        //if(session('user_info.userid')==79) $tx_bj=1;
        $this->assign('tx_bj',$tx_bj);
        if(request()->isAjax()){
            $parm=input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $parm['selresult']=0;
            return tixian_list($parm);
        }else{
            return  view();
        }
    }
    //提现补单（需要设置key，防止恶意提交）
    public function budan(){
        $this->assign('key',input('key'));
        if (request()->isPost()) {
            //验证key
            if(input('key')!=BD_KEY){
                return mac_return(0,'key值错误，不合法提交！');
            }
            $fp = fopen("lock.txt", 'w+');
            if (flock($fp, LOCK_EX)) {
                $uid=input('uid');
                $cash=input('cash');
                $txt_ext=input('txt_ext');
                $res=MC('sys_user')->where("id=".intval($uid))->find();
                $orderid = 'jjp'.date("YmdHis",time()).rand(1000000,9999999);
                if($txt_ext==1){
                    $new_cash = $res['zj_cash']+$cash;
                }else{
                    $new_cash = $res['zj_cash']-$cash;
                }
                $bd_type=input('bd_type');
                $insert_arr = array(
                    "uid"=>$uid,
                    "old_cash"=>$res['zj_cash'],
                    "cash"=>$cash,
                    "action"=>$bd_type,
                    'on_time' =>time(),
                    'ext' =>$txt_ext,
                    'new_cash' =>$new_cash,
                    'orderid' =>$orderid,
                    'up_uid' =>$res['up_uid']
                );
                MC('finance')->insert($insert_arr);
                $update_arr = array('zj_cash' =>$new_cash);
                MC('sys_user')->where("id=".intval($uid))->update($update_arr);
                flock($fp, LOCK_UN);
                clearstatcache();
                fclose($fp);
                return mac_return(1,'补单成功，该用户当前可用余额为'.$new_cash);
            } else {
                file_put_contents('sh_bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode(input()) . "\n", FILE_APPEND);
                flock($fp, LOCK_UN);
                clearstatcache();
                fclose($fp);
                return mac_return(0,'系统繁忙，请稍后再试！');
            }
        }else{
            return view();
        }
    }
    //提现状态处理
    public function tx_status(){
        if (request()->isPost()){
            $txid=intval(input('post.id'));
            $type=input('post.type');
            $tx_config = MC('tx_config')->where('id=1')->find();
            $tx_arr=array('status'  => $type,'end_time'=>time());
            if($type==1){
                //通过
                $fina_arr = array(
                    'action'=>"提现成功",
                    'pingtailirun'=>$tx_config[fee]
                );
                MC('finance')->where(['orderid' => $txid])->update($fina_arr);//更改明细信息
                MC('tixian_log')->where(['id' => $txid])->update($tx_arr);//修改订单状态
                return mac_return(1,'提现审核成功');
            }else{
                $fp = fopen("lock.txt" , 'w+');
                if(flock($fp ,LOCK_EX)) {
                    //处理拒绝提现逻辑，更新提现表状态和时间、用户表用户金额、写入财务记录表退还明细
                    $tx_arr['faildesc']=input('chuli_desc');
                    //退款前先审核订单状态
                    $tx_info=MC('tixian_log')->where(['id'=>$txid])->find();
                    if($tx_info['status']==2){
                        flock($fp,LOCK_UN);
                        clearstatcache();
                        fclose($fp);
                        return mac_return(0,'提现操作失败,该记录已处理过');
                    }
                    MC('tixian_log')->where(['id' => $txid])->update($tx_arr);//修改订单状态
                    $fina_arr = array(
                        'action'=>"提现拒绝",
                        'pingtailirun'=>0
                    );
                    MC('finance')->where(['orderid' => $txid])->update($fina_arr);//更改明细信息
                    //恢复用户余额
                    $tx_info=MC('tixian_log')->where(['id'=>$txid])->find();
                    $uinfo=MC('sys_user')->where(['id'=>$tx_info['uid']])->find();
                    $n_cash = $uinfo['zj_cash']+$tx_info['cash']+$tx_info['fee'];
                    $update_arr = array(
                        'zj_cash'=>$n_cash,
                    );
                    MC('sys_user')->where(['id'=>$tx_info['uid']])->update($update_arr);

                    $fina_array =array(
                        'uid'=>intval($tx_info['uid']),
                        'old_cash'=>$uinfo['zj_cash'],
                        'cash'=>$tx_info['cash']+$tx_info['fee'],
                        'action'=>'提现退回',
                        'on_time'=>time(),
                        'new_cash'=>$n_cash,
                        'orderid'=>intval($txid),
                        'ext'=>1,

                    );
                    MC('finance')->insert($fina_array);
                    flock($fp,LOCK_UN);
                    clearstatcache();
                    fclose($fp);
                    return mac_return(1,'提现审核已拒绝');
                }else{
                    file_put_contents('sh_bingfa.txt',date("Y-m-d H:i:s").":".json_encode(input())."\n",FILE_APPEND);
                    flock($fp,LOCK_UN);
                    clearstatcache();
                    fclose($fp);
                    return mac_return(0,'系统繁忙，请稍后再试！');
                }

            }

        }else{
            return mac_return(0);
        }
    }
    //提现快捷通
    public function tx_kjt(){
        //验证下打款密码，避免恶意提交打款
        $checkCode = trim(input('pwd'));
       
        import('lib.PHPGangsta.GoogleAuthenticator', EXTEND_PATH, '.php');
        $ga = new \PHPGangsta_GoogleAuthenticator();
        $secret = "CQDFBXHHOW6B2VEM";

        $qrCodeUrl = $ga->getQRCodeGoogleUrl('宏信智联', $secret); 
        $oneCode = $ga->getCode($secret); //服务端计算"一次性验证码"
        $checkResult = $ga->verifyCode($secret, $checkCode,0);
        if (!$checkResult) {
            return mac_return(0,'打款密码错误，打款失败');exit;
        }
        require_once ("./extend/lib/kjt_yxk/config.php");
        require_once ("./extend/lib/kjt_yxk/Api.php");
        //查询提现详情  避免客服重新点击
        //$tx_res = $db_obj->get_one("select * from tixian_log where ISNULL(is_llp) and status=0 and id=".intval($txid));
        $txid=input('id');
        $tx_res=MC('tixian_log')->where("ISNULL(is_llp) and status=0 and id=".intval($txid))->find();
        if(!$tx_res){
            return mac_return(0,'已经提交,请勿重复提交');
        }
        /**************************请求参数**************************/

//商户付款流水号
        $out_trade_no = 'yxk'.date("YmdHms",time()).$tx_res['id'].rand(111111,999999);
        $apiObj = new \Api($apiUrl, $merchantNo, $privateKey, $kjtPublicKey);
        //$tx_res[cash]=0.1;
        $data = [
            'userid'              => 'jjf',
            'out_trade_no'   => $out_trade_no,
            'payer_identity'   => '200003297377',//商户id
            'amount' => $tx_res['cash'],
            'bank_card_no'        => trim($tx_res['account']),
            'bank_account_name'     => trim($tx_res['username']),
            'biz_product_code'     => '10221',//即时到账
            'pay_product_code'     => '14', //14对私
            'memo'     => 'YXKZZ', //备注
            'notify_url'     => WEB_URL.'kjt_notify'
        ];

        $result = $apiObj->transfer_to_cardRequest($data);
        //更新提现表商户流水号以及is_llp状态
        $update_arr = array(
            'no_order'=>$out_trade_no,
            'is_llp'=>1

        );
        
        file_put_contents('kjt_res.txt',date("Y-m-d H:i",time())."---".json_encode($result)."\n",FILE_APPEND);
        if($result['code']=='S10000'){
            MC('tixian_log')->where('id='.intval($txid))->update($update_arr);
            mac_return(1,$result['msg']);
            
        }else{
            mac_return(0,$result['msg']);
        }
        //echo json_encode($result);
    }
    //用户账变明细
    public function card_logg(){
        $txt_uid=input('txt_uid');
        $this->assign('txt_uid',$txt_uid);
        if(request()->isAjax()){
            return cash_log(input());
        }else{
            return  view();
        }
    }
    //银行卡列表
    public function bank_list(){
        $txt_uid=input('txt_uid');
        $this->assign('txt_uid',$txt_uid);
        if(request()->isAjax()){
            input('txt_uid') && $map['uid'] = input('txt_uid');
            input('username') && $map['bank_name'] = ['like', "%" . input('username') . "%"];
            input('txt_card') && $map['bank_number'] =['like', "%" . input('txt_card') . "%"];
            $p = trim(input('page')) ? trim(input('page')) : 1;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
            $start = ($p - 1) * $limit;
            $bank_arr=\global_arr::bank_arr();
            $list = MC('member_bank')->where($map)->limit($start, $limit)->order('on_time desc')->select();
            foreach($list as &$v){
                $v['tx_type']=$bank_arr[$v['bank']];
            }
            $count = MC('member_bank')->where($map)->count();//cast(sum(xxxxx) as decimal(10,2))
            return mac_return(0, '查询成功', $list, $count);
        }else{
            return  view();
        }
    }
    //报表统计
    public function tj(){
        if(request()->isAjax()){
            $whereStr=' ';
            $search_time=input('search_time');
            if ($search_time) {
                $tmp_start = strtotime(explode(' - ', $search_time)[0]);
                $tmp_end = strtotime(explode(' - ', $search_time)[1]);
            }
            else{
                $tmp_start=strtotime(date('Y-m-d'));
                $tmp_end =time();
            }
            $tmp_start && $whereStr .= "  and on_time >" . $tmp_start;
            $tmp_end && $whereStr .= "  and on_time <" . $tmp_end;
            $txt_uid=input('txt_uid');
            $txt_tongdao=input('txt_tongdao');
            $stype=input('stype');
            $sql = "select uid,count(distinct uid) total_uids,count(id) total_num,sum(status=1) chenggong,sum(case when status=2 then 1 else 0 end ) shibai,sum(case when status=1  ".sql_str(8)."  then realvalue else 0 end ) yidong,sum(case when status=1  ".sql_str(10)."  then realvalue else 0 end ) liantong,sum(case when status=1  ".sql_str(9)."  then realvalue else 0 end ) dianxin,
            sum(case when status=0 then 1 else 0 end ) chulizhong,round(sum(pt_lirun),3) pt_lirun,sum(realvalue) succ_cash,sum(incash) in_cash,round(sum(pt_incash),2) pt_incash,round(sum(up_lirun),2) up_lirun from orders where 1=1 ";  //and status >0 and status<2
            
//sum(case when status=1  ".sql_str(6)."  then realvalue else 0 end ) junwang,
            $txt_uid and $whereStr.="  and uid =".intval($txt_uid);
            strlen($txt_tongdao)>0 and $whereStr.="  and tongdao =".intval($txt_tongdao);
//区分讯银和汇速通的卡类型
            strlen($stype)>0 && $whereStr.= sql_str($stype);

            $tongji = MC('orders')->query($sql.$whereStr);
            $tongji[0] && $tongji=$tongji[0];

            $tongji['username']=$tongji['total_uids'];
            unset($tongji['uid']);
            $sql.=($whereStr."  group by uid order by pt_lirun desc");
//根据条件统计

            $sqlc = "select uid from orders where 1=1  ";  //and status>0 and status<2

            $p = trim(input('page')) ? trim(input('page')) : 1;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
            $start = ($p - 1) * $limit;

            $count=count(MC('order')->query($sqlc.$whereStr.' group by uid '));
            //dy($sql.$whereStr.' limit '.$start.','.$limit);
            $list=MC('order')->query($sql.' limit '.$start.','.$limit);
            foreach($list as &$v){
                $v['username']=MC('sys_user')->where(['id'=>$v['uid']])->value('username');
            }
            return mac_return(0, '查询成功', $list, $count,$tongji);
        }else{

            //查询日盈利
            $day_yl = MC('orders')->query("select sum(pt_lirun) pt_lirun from orders where  status >0 and status <2 and on_time>".strtotime(date("Y-m-d 00:00:01",time())));
            $day_tx = MC('orders')->query("select sum(yl_fee) total_fee from tixian_log where  status >0 and status <2 and end_time>".strtotime(date("Y-m-d 00:00:01",time())));
            $day_total_yl = number_format($day_yl[0]['pt_lirun']+$day_tx[0]['total_fee'], 2,'.','');

            //$yonghu_yue = MC('orders')->field('*')->sum('total_cash');
            //$this->assign('yonghu_yue',$yonghu_yue);

            $tongji_res = MC('yinglitongji')->order('id desc')->find();
            $this->assign('day_total_yl',$day_total_yl);

            $this->assign('tongji_res',$tongji_res);

            $is_power=0;
            $power_arr = array(1,14);
            if(in_array(session('user_info.group_id'),$power_arr)){
                $is_power = 1;
            }
            $this->assign('is_power',$is_power);
            $tongdao_arr=\global_arr::tongdao_arr();
            $type_arr=\global_arr::type_arr();
            $this->assign('tongdao_arr',$tongdao_arr);
            $this->assign('type_arr',$type_arr);
            return view();
        }

    }
    //业绩分析
    public function yjfx(){

        if (request()->isAjax()) {
            $map = [];
            $search_time = input('search_time');
            if ($search_time) {
                list($start_time,$end_time) = explode(' - ', $search_time);
                $start_time = strtotime($start_time);
                $end_time = strtotime($end_time);
                $map['on_time'] = ['between', "$start_time, $end_time"];
            }

            $field = 'on_time,zuoyingli,riyingli,zuoptsuode,zuoyhsuode,zuoyhhuizong,zuoyinglilv,zuoxiaokarenshu,zuotixianjine,zuoxinzhuce,zuoweitixian,zuoweichuli';

            $p = trim(input('page')) ? trim(input('page')) : 1;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
            $start = ($p - 1) * $limit;
            $list = MC('yinglitongji')->where($map)->field($field)->limit($start, $limit)->order('id DESC')->select();
           
            $arr = [];
            foreach ($list as $key => $v) {
               $arr[$key]['on_time'] = date('Y-m-d',$v['on_time']);
               $arr[$key]['zuoyingli'] = $v['zuoyingli'] ?? 0 ;
               $arr[$key]['riyingli'] = $v['riyingli'] ?? 0 ;
               $arr[$key]['zuoptsuode'] = $v['zuoptsuode'] ?? 0 ;
               $arr[$key]['zuoyhsuode'] = $v['zuoyhsuode'] ?? 0 ;
               $arr[$key]['zuoyhhuizong'] = $v['zuoyhhuizong'] ?? 0 ;
               $arr[$key]['zuoyinglilv'] = $v['zuoyinglilv'] ?? 0 ;
               $arr[$key]['zuoxiaokarenshu'] = $v['zuoxiaokarenshu'] ?? 0 ;
               $arr[$key]['zuotixianjine'] = $v['zuotixianjine'] ?? 0 ;
               $arr[$key]['zuoxinzhuce'] = $v['zuoxinzhuce'] ?? 0 ;
               $arr[$key]['zuoweitixian'] = $v['zuoweitixian'] ?? 0 ;
               $arr[$key]['zuoweichuli'] = $v['zuoweichuli'] ?? 0 ;
            }
            $count = MC('yinglitongji')->where($map)->count();
            return mac_return(0, '查询成功', $arr, $count);
           
        }
         $this->assign('search_time', input('search_time')?:(date('Y-m-d',time()).' 00:00:00 - '.date('Y-m-d H:i:s',time())));
        return view();
    }
    //错卡统计
    public function rongcuo(){
        if(Request()->isAjax()){
            $search_time=input('search_time');
            if ($search_time) {
                $tmp_start = strtotime(explode(' - ', $search_time)[0]);
                $tmp_end = strtotime(explode(' - ', $search_time)[1]);
            } else{
                $tmp_start=strtotime(date('Y-m-d'));
                $tmp_end =time();
            }
            $whereStr='';
            $tmp_start && $whereStr .= "  and on_time >" . $tmp_start;
            $tmp_end && $whereStr .= "  and on_time <" . $tmp_end;

            $sql = "SELECT count(id) t_nums,sum(realvalue) t_realvalue,sum(cash) t_cash FROM `orders` where status=1 and cash!=realvalue ";  //tongdao=3 and

            $t_sql = "SELECT count(id) t_nums,sum(realvalue) t_realvalue,sum(cash) t_cash FROM `orders`  where status=1 "; //  tongdao=3 and
            $cuo_res = MC('orders')->query($sql.$whereStr);
            $cuo_res[0] && $cuo_res=$cuo_res[0];
            $zong_res = MC('orders')->query($t_sql.$whereStr);
            $zong_res[0] && $zong_res=$zong_res[0];
            //dy($zong_res);
            $cuo_lv = sprintf("%.2f", number_format($cuo_res['t_realvalue']/$zong_res['t_realvalue']*100, 2));
            $list['c_nums']=$cuo_res['t_nums'];
            $list['z_nums']=$zong_res['t_nums'];
            $list['z_realvalue']=$zong_res['t_realvalue'];
            $list['c_realvalue']=$cuo_res['t_realvalue'];
            $list['cuo_lv']=$cuo_lv.'%';
            $data[0]=$list;
            return mac_return(0, '查询成功', $data, 0);

        }else{
            return view();
        }
    }
    //销卡统计
    public function  statistics(){
        if(request()->isAjax()) {
            get_statistics(input());
        }else{
            $tongdao_arr=\global_arr::tongdao_arr();
            $type_arr=\global_arr::type_arr();
            $this->assign('tongdao_arr',$tongdao_arr);
            $this->assign('type_arr',$type_arr);
            return view();
        }
    }
    
    // 支付宝下发
    public function alipay_trans()
    {
        //验证下打款密码，避免恶意提交打款
        $checkCode = trim(input('pwd'));
        
        import('lib.PHPGangsta.GoogleAuthenticator', EXTEND_PATH, '.php');
        $ga = new \PHPGangsta_GoogleAuthenticator();
        $secret = "CQDFBXHHOW6B2VEM";

        $qrCodeUrl = $ga->getQRCodeGoogleUrl('宏信智联', $secret); 
        $oneCode = $ga->getCode($secret); //服务端计算"一次性验证码"
        $checkResult = $ga->verifyCode($secret, $checkCode,0);
        if (!$checkResult) {
           return mac_return(0,'打款密码错误，打款失败');exit;
        }
        require_once ("./extend/lib/kjt_yxk/config.php");
        require_once ("./extend/lib/kjt_yxk/Api.php");
        //查询提现详情  避免客服重新点击
        
        $txid=input('id');
        $tx_res=MC('tixian_log')->where("ISNULL(is_llp) and bank=19 and status=0 and id=".intval($txid))->find();
        if(!$tx_res){
            return mac_return(0,'已经提交,请勿重复提交');
        }
        /**************************请求参数**************************/
        
        //商户付款流水号
        $out_trade_no = 'yxk'.date("YmdHms",time()).$tx_res['id'].rand(111111,999999);

        require_once 'extend/lib/zfb/aop/AopCertClient.php';
        require_once 'extend/lib/zfb/aop/AopCertification.php';
        require_once 'extend/lib/zfb/aop/request/AlipayFundTransUniTransferRequest.php';
 
        $aop = new \AopCertClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId =ZFB_APPID;
        $aop->rsaPrivateKey =ZFB_Private_key;
        $aop->alipayrsaPublicKey=ZFB_Public_key;
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        
        $appCertPath = "http://www.1xiaoka.com/public/alipay/appCertPublicKey_2021002113699267.crt";
        $alipayCertPath = "http://www.1xiaoka.com/public/alipay/alipayCertPublicKey_RSA2.crt";
        $rootCertPath = "http://www.1xiaoka.com/public/alipay/alipayRootCert.crt";
       
        //调用getPublicKey从支付宝公钥证书中提取公钥
        $aop->alipayrsaPublicKey = $aop->getPublicKey($alipayCertPath);
       
        //是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
        $aop->isCheckAlipayPublicCert = true;
        //调用getCertSN获取证书序列号
        $aop->appCertSN = $aop->getCertSN($appCertPath);
        //调用getRootCertSN获取支付宝根证书序列号
        $aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);

        $data = [
            'out_biz_no' => $out_trade_no,
            'trans_amount' => sprintf("%.2f",substr(sprintf("%.3f", $tx_res['cash']), 0, -2)),
            'product_code' => 'TRANS_ACCOUNT_NO_PWD',
            'biz_scene' => 'DIRECT_TRANSFER',
            'order_title' => '转账',
           
            'payee_info' =>[
                'identity' => trim($tx_res['account']),
                'identity_type' => 'ALIPAY_LOGON_ID',
                'name' =>trim($tx_res['username']),
            ],
            'remark' => '单笔转账',
         
        ];
        $tosign=json_encode($data);
        
        $request = new \AlipayFundTransUniTransferRequest();
        $request->setBizContent($tosign);
        $result = $aop->execute ($request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
       
        $resultCode = $result->$responseNode->code;

        $update_arr = array(
            'no_order'=>$out_trade_no,
            'is_llp'=>1
        );
       
        file_put_contents('zfb_res.txt',date("Y-m-d H:i",time())."---".json_encode($result)."\n",FILE_APPEND);
        
        if(!empty($resultCode)&&$resultCode == 10000){
            $update_arr = array(
                'no_order'=>$out_trade_no,
                'is_llp'=>1,
                'status'=>1,
                'end_time'=>time(),
                'ext'=>'ZFB付款成功'
            );
            $tx_config = MC('tx_config')->find();
            $fina_arr = array(
                'action'=>"提现成功",
                'pingtailirun'=>$tx_config['fee']
            );
            MC('finance')->where("orderid='".$tx_res['id']."'")->update($fina_arr);
            
            MC('tixian_log')->where('id='.intval($txid))->update($update_arr);
            mac_return(1,'成功');
        } else {
            mac_return(1,'失败');
        }
    }
    
    public function sshenyan(){
        
        require_once 'extend/lib/zfb/aop/AopCertClient.php';
        require_once 'extend/lib/zfb/aop/AopCertification.php';
        require_once 'extend/lib/zfb/aop/request/AlipayUserCertdocCertverifyPreconsultRequest.php';
 
        $aop = new \AopCertClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId =ZFB_APPID;
        $aop->rsaPrivateKey =ZFB_Private_key;
        $aop->alipayrsaPublicKey=ZFB_Public_key;
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        
        $appCertPath = "http://www.1xiaoka.com/public/alipay/appCertPublicKey_2021002113699267.crt";
        $alipayCertPath = "http://www.1xiaoka.com/public/alipay/alipayCertPublicKey_RSA2.crt";
        $rootCertPath = "http://www.1xiaoka.com/public/alipay/alipayRootCert.crt";
       
        //调用getPublicKey从支付宝公钥证书中提取公钥
        $aop->alipayrsaPublicKey = $aop->getPublicKey($alipayCertPath);
       
        //是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
        $aop->isCheckAlipayPublicCert = true;
        //调用getCertSN获取证书序列号
        $aop->appCertSN = $aop->getCertSN($appCertPath);
        //调用getRootCertSN获取支付宝根证书序列号
        $aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);
        
        $data = [
            'user_name' => $out_trade_no,
            'cert_type' => 'IDENTITY_CARD',
            'cert_no' => 'TRANS_ACCOUNT_NO_PWD'
        ];
        
        $tosign=json_encode($data);
        
        $request = new \AlipayUserCertdocCertverifyPreconsultRequest();
        $request->setBizContent($tosign);
        $result = $aop->execute ($request); 
        
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        d($result,$resultCode);exit;
        
    }


}