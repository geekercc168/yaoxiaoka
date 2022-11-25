<?php
namespace app\pc\controller;
use think\Controller;;
use think\Db;

class Index extends Controller {
    public function index(){
      
        $notice_list = get_index_notice(3);
        $this->assign('notice',$notice_list);//公告

        $question_list = get_index_question(8);
        $this->assign('question',$question_list);//问题

        $article_list = get_index_article(8);

        $this->assign('article',$article_list);//问题

        $this->assign('nav',1);
        
        $uid = $uinfo=session('uinfo')['id'];
        if($uid > 0 ){
            $lo_url = '/yk_card';
        }else{
            $lo_url = '/sign/in';
        }

        $this->assign('lo_url',$lo_url);
        
        if(is_mobile()){
            $uinfo=session('uinfo');

            $is_truename = $hotlist = [];
            if($uinfo['id'] > 0)  $is_truename=is_truename($uinfo['id']);
            
            $this->assign('uinfo',$uinfo);
            // $hotlist=$list=MC('dk_list')->where('status=1 and ifhot=1')->order('listorder asc,id desc')->select();
            
            // $this->assign('hotlist',$hotlist);
            if($uinfo['id']>0){

                // $today_where=" and on_time>=".(strtotime(date('Y-m-d',time())."0:0:0")) ."  and uid=".$uinfo[id];
                
                // $data[t_jy_cg]=MC('orders')->field('count(id) bishu,sum(cash) miane,sum(incash) jiesuane')->where('status=1'.$today_where)->find();
                // //今日待售
                // $data[t_jy_ds]=MC('orders')->field('count(id) bishu,sum(cash) miane,sum(incash) jiesuane')->where('status=0'.$today_where)->find();
                // //今日失败
                // $data[t_jy_sb]=MC('orders')->field('count(id) bishu,sum(cash) miane,sum(incash) jiesuane')->where('status=2'.$today_where)->find();

                $data = reback_status(0,$uinfo['id']);

                $this->assign('data',$data);
                //热门回收
            }
            $this->assign('is_truename',$is_truename);
            return view('m_index');
        }
        return view();
    }
    public function new_html()
    {
        
        $notice_list=get_notice(['limit'=>3]);
        $this->assign('notice',$notice_list['list']);//公告
        $question_list=get_question(['limit'=>8]);
        $this->assign('question',$question_list['list']);//问题
        $article_list=get_article(['limit'=>8]);
        $this->assign('article',$article_list['list']);//问题
        $this->assign('nav',1);
        $uid = $uinfo=session('uinfo')['id'];
        if($uid > 0 ){
            $lo_url = '/yk_card';
        }else{
            $lo_url = '/sign/in';
        }

        $this->assign('lo_url',$lo_url);
        if(is_mobile()){
            $uinfo=session('uinfo');
            $is_truename=is_truename($uinfo['id']);
            $this->assign('uinfo',$uinfo);
            $hotlist=$list=MC('dk_list')->where('status=1 and ifhot=1')->order('listorder asc,id desc')->select();
            $this->assign('hotlist',$hotlist);
            if($uinfo['id']>0){
                $today_where=" and on_time>=".(strtotime(date('Y-m-d',time())."0:0:0")) ."  and uid=".$uinfo[id];
                $data[t_jy_cg]=MC('orders')->field('count(id) bishu,sum(cash) miane,sum(incash) jiesuane')->where('status=1'.$today_where)->find();
                //今日待售
                $data[t_jy_ds]=MC('orders')->field('count(id) bishu,sum(cash) miane,sum(incash) jiesuane')->where('status=0'.$today_where)->find();
                //今日失败
                $data[t_jy_sb]=MC('orders')->field('count(id) bishu,sum(cash) miane,sum(incash) jiesuane')->where('status=2'.$today_where)->find();
                $this->assign('data',$data);
                //热门回收
            }
            $this->assign('is_truename',$is_truename);
            return view('new');
        }
        return view();
    }

    //人脸识别
    public function face_zfb(){
        $uid=intval($_GET['uid']);
        require_once 'extend/lib/zfb/aop/AopCertClient.php';
        require_once 'extend/lib/zfb/aop/AopCertification.php';
        require_once 'extend/lib/zfb/aop/request/AlipayUserCertifyOpenInitializeRequest.php';
        $ture_name=MC('truename_auth')->where('uid='.$uid)->find();
        if(!$ture_name){
            echo "<script>alert('用户未实名登记姓名或身份证号码!')</script>";return;
        }
        // if($ture_name['status']==1){
        //     echo "<script>alert('用户已实名登记并完成人脸识别，无需再次实名!')</script>";return;
        // }
        if($ture_name['zfb_key']){
           echo "<script>alert('本次人脸识别二维码已失效，请前往网站重新提交实名信息后生成二维码!')</script>";return;
        }
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
        
        
        $newsigndata=array();
        $newsigndata['outer_order_no']='ZGYD'.date('YmdHis').rand(1000000,9999999);
        $newsigndata['biz_code']="FACE";
        $newsigndata['identity_param']['identity_type']="CERT_INFO";
        $newsigndata['identity_param']['cert_type']="IDENTITY_CARD";
        $newsigndata['identity_param']['cert_name']=$ture_name['truename'];
        $newsigndata['identity_param']['cert_no']=$ture_name['idcard'];
        $newsigndata['merchant_config']['return_url']="http://www.1xiaoka.com/pc/index/face_return?uid=".$uid;
        $newsigndata['face_contrast_picture']="xydasf==";
        $tosign=json_encode($newsigndata);
        $request = new \AlipayUserCertifyOpenInitializeRequest();
        $request->setBizContent($tosign);
        $result = $aop->execute ($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode=$result->$responseNode->code;
        $certify_id=$result->$responseNode->certify_id;
        
        if(!empty($resultCode)&&$resultCode == 10000){
            //初始化成功，拼接url并生成二维码
            require_once 'extend/lib/zfb/aop/request/AlipayUserCertifyOpenCertifyRequest.php';
            $request = new \AlipayUserCertifyOpenCertifyRequest ();
            $data=array();
            $data['certify_id']=$certify_id;
            MC('truename_auth')->where('uid='.$uid)->update(['zfb_key'=>$certify_id]);//保留$certify_id查询时候使用
            $tosign=json_encode($data);
            $request->setBizContent($tosign);
            $url= $aop->pageExecute ($request,'GET');
            Header("Location:$url");
        } else {
            echo "初始化失败";
        }
    }
    public function face_return(){
        $uid=intval($_GET['uid'])?:0;
        $ture_name=MC('truename_auth')->where('uid='.$uid)->find();
        $certify_id=$ture_name['zfb_key'];
        if(!empty($certify_id)){
            require_once 'extend/lib/zfb/aop/AopCertClient.php';
            require_once 'extend/lib/zfb/aop/request/AlipayUserCertifyOpenQueryRequest.php';
            $aop=new \AopCertClient ();
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
            
            $request = new \AlipayUserCertifyOpenQueryRequest ();
            $data=array();
            $data['certify_id']=$certify_id;
            $tosign=json_encode($data);
            $request->setBizContent($tosign);
            $result = $aop->execute ($request);
            $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
            $passed = $result->$responseNode->passed;
            if(!empty($passed)&&$passed[0] == 'T'){
                //成功则编辑用户认证状态
                MC('truename_auth')->where('uid='.$uid)->update(array('status'=>1));
                //自动审核通过
                $update_uarr = array(
                    'truename' => $ture_name['truename'],
                    'idcard' => $ture_name['idcard']
                );
                MC('sys_user')->where(['id' => $uid])->update($update_uarr);
                echo "<script>alert('认证成功，请前往网站继续销卡~~!')</script>";return;
            } else {
                //已经进入扣费认证，失败后直接删除实名登记，要求重新输入实名！
                echo "<script>alert('认证失败!')</script>";return;
            }
        } else {
            echo "<script>alert('初始化失败!')</script>";return;
        }
    }
    
    public function onlineCount()
    {
        $data = returnKeys('is_login');

        $dataArray =array(
            'is_login'=>0
        );
        //d($data);//,GetRedis('is_login17598')
        $input_uid = input('uid/d',0);
        $redis_time = input('redis_time','');
        
        //  SetRedis('is_login17598',1,60);
        if($input_uid > 0){
            
            $aasasa = returnKeyBlanceTime('is_login'.intval($input_uid));
            
            if(in_array('is_login'.$input_uid, $data)){
               
                if($redis_time == 'yxk'){
                    SetRedis('is_login'.intval($input_uid),1,2500);
                }else{
                    if($aasasa <= 0){
                        $res = MC('sys_user')->where('id='.intval($input_uid))->update($dataArray);
                        $resa = DelRedis('is_login'.intval($input_uid));
                    }
                }

            }
        }else{
            
            if($data){
                foreach ($data as $key => $val) {
                    $_uid = substr($val,8);
                    $aaaa = returnKeyBlanceTime('is_login'.intval($_uid));
                    //d($aaaa);
                    if($aaaa <= 500){
                        
                        $res = MC('sys_user')->where('id='.intval($_uid))->update($dataArray);
                        d($res);
                        DelRedis('is_login'.intval($_uid));
                    }
                    
                }
            }
        }
        
    }
    public function backtime(){

        $arr['106'] = '联通(慢销)';
        $arr['3'] = '联通(快销)';
        $arr['103'] = '联通(超快销)';
        $arr['104'] = '移动(慢销)';
        $arr['1'] = '移动(快销)';
        $arr['101'] = '移动(超快销)';
        $arr['2'] = '电信(慢销)';
        $arr['102'] = '电信(快销)';
        $arr['105'] = '电信(超快销)';

        $card['106'] = 'ltmx';
        $card['3'] = 'ltkx';
        $card['103'] = 'ltckx';
        $card['104'] = 'ydmx';
        $card['1'] = 'ydkx';
        $card['101'] = 'ydckx';
        $card['2'] = 'dxmx';
        $card['102'] = 'dxkx';
        $card['105'] = 'dxckx';
        
        $id = input('id');
        $price = input('price');
        $tpye = $card[$id];
        $ck = input('ck/d',0);

        $time = cache($tpye.'_'.$price);
        $tatus = cache($tpye.'St_'.$price);

        list($a,$b) = explode('-', $time);

        if(intval($a)<1 || intval($b)<1) return json(['code' => 111]);
        
        $jiange = cache($time.'jiange') ?? 0;

        $f = rand($a,$b-1);
        $m = rand(1,59);

        if(time()-$jiange > 60){
            $f = rand($a,$b-1);
            $m = rand(1,59);
            cache($time.'jiange',time());
        }else{
            $f = cache($time.'jiangef');
            $m = cache($time.'jiangem');
        }
        cache($time.'jiangef',$f);
        cache($time.'jiangem',$m);

        // 超快销
        $ckv = 0;
        if($ck == 1 ){
            $cck = cache($tpye.'Ck_'.$price);
            list($a,$b) = explode('-', $cck);
            $f1 = rand($a,$b-1);
            $f2 = rand(1,9);

            if(time()-$jiange > 60){
                $ckv = $f1 . '.' . $f2;
            }else{
                $f1 = cache($time.'jiangef1');
                $f2 = cache($time.'jiangef2');
                $ckv = $f1 . '.' . $f2;    
            }
            cache($time.'jiangef1',$f1);
            cache($time.'jiangef2',$f2);
            
        }

        if($tatus == 1){
            return json(['code' => 0,'name'=>$arr[$id],'id'=>$id,'time' => $f.'分'.$m.'秒','ckv'=>$ckv]);
        }
        return json(['code' => 999]);
        
  
    }

}