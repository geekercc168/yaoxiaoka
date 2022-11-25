<?php
namespace app\kefu\controller;
use think\Controller;;
use think\Db;
use think\Session;
import('lib.global_arr', EXTEND_PATH);

class Index extends Home {
    public function index(){

        return view();
    }

    //提现审核
    public function tx_shenhe(){
        $bj =time()-100;
        $kfdb=session('kfdb')?:'db2';
        $res=MC('tixian_log',$kfdb)->where("status=0 and create_time>=".$bj)->find();
        $res ? $tx_bj=1 : $tx_bj=0;
        $this->assign('tx_bj',$tx_bj);
        if(request()->isAjax()){
            $parm=input();
            $parm['selresult']=0;
            return tixian_list($parm);
        }else{
            return  view();
        }
    }
    //提现列表
    public function m_lists()
    {
        if (request()->isAjax()) {
            $parm = input();
            $txt_uid=input('txt_uid');
            $this->assign('txt_uid',$txt_uid);
            return tixian_list($parm);
        } else {
            return view();
        }
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

    public function tx_status(){
        $kfdb=session('kfdb')?:'db2';
        if (request()->isPost()){
            $txid=intval(input('post.id'));
            $type=input('post.type');
            $tx_config = MC('tx_config',$kfdb)->where('id=1')->find();
            $tx_arr=array('status'  => $type,'end_time'=>time());
            if($type==1){
                //通过
                $fina_arr = array(
                    'action'=>"提现成功",
                    'pingtailirun'=>$tx_config[fee]
                );
                MC('finance',$kfdb)->where(['orderid' => $txid])->update($fina_arr);//更改明细信息
                MC('tixian_log',$kfdb)->where(['id' => $txid])->update($tx_arr);//修改订单状态
                return mac_return(1,'提现审核成功');
            }else{
                $fp = fopen("lock.txt" , 'w+');
                if(flock($fp ,LOCK_EX)) {
                    //处理拒绝提现逻辑，更新提现表状态和时间、用户表用户金额、写入财务记录表退还明细
                    $tx_arr['faildesc']=input('chuli_desc');
                    //退款前先审核订单状态
                    $tx_info=MC('tixian_log',$kfdb)->where(['id'=>$txid])->find();
                    if($tx_info['status']==2){
                        flock($fp,LOCK_UN);
                        clearstatcache();
                        fclose($fp);
                        return mac_return(0,'提现操作失败,该记录已处理过');
                    }
                    MC('tixian_log',$kfdb)->where(['id' => $txid])->update($tx_arr);//修改订单状态
                    $fina_arr = array(
                        'action'=>"提现拒绝",
                        'pingtailirun'=>0
                    );
                    MC('finance',$kfdb)->where(['orderid' => $txid])->update($fina_arr);//更改明细信息
                    //恢复用户余额
                    $tx_info=MC('tixian_log',$kfdb)->where(['id'=>$txid])->find();
                    $uinfo=MC('sys_user',$kfdb)->where(['id'=>$tx_info[uid]])->find();
                    $n_cash = $uinfo[zj_cash]+$tx_info[cash]+$tx_info[fee];
                    $update_arr = array(
                        'zj_cash'=>$n_cash,
                    );
                    MC('sys_user',$kfdb)->where(['id'=>$tx_info[uid]])->update($update_arr);

                    $fina_array =array(
                        'uid'=>intval($tx_info[uid]),
                        'old_cash'=>$uinfo[zj_cash],
                        'cash'=>$tx_info[cash]+$tx_info[fee],
                        'action'=>'提现退回',
                        'on_time'=>time(),
                        'new_cash'=>$n_cash,
                        'orderid'=>intval($txid),
                        'ext'=>1,

                    );
                    MC('finance',$kfdb)->insert($fina_array);
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
        if(input('pwd')!='jjf168@@'){
            return mac_return(0,'打款密码错误，打款失败');
        }
        $kfdb=session('kfdb')?:'db2';
        $txid=input('id');
        $tx_res=MC('tixian_log',$kfdb)->where("ISNULL(is_llp) and status=0 and id=".intval($txid))->find();
        if(!$tx_res){
            return mac_return(0,'已经提交,请勿重复提交');
        }
        if($kfdb=='db2'){
            require_once ("./extend/lib/kjt_yxk/config.php");
            require_once ("./extend/lib/kjt_yxk/Api.php");
            //查询提现详情  避免客服重新点击
            //$tx_res = $db_obj->get_one("select * from tixian_log where ISNULL(is_llp) and status=0 and id=".intval($txid));
            /**************************请求参数**************************/
            $out_trade_no = 'yxk'.date("YmdHms",time()).$tx_res[id].rand(111111,999999);
            $apiObj = new \Api($apiUrl, $merchantNo, $privateKey, $kjtPublicKey);
            //$tx_res[cash]=0.1;
            $data = [
                'userid'              => 'jjf',
                'out_trade_no'   => $out_trade_no,
                'payer_identity'   => '200003297377',//商户id
                'amount' => $tx_res[cash],
                'bank_card_no'        => trim($tx_res[account]),
                'bank_account_name'     => trim($tx_res[username]),
                'biz_product_code'     => '10221',//即时到账
                'pay_product_code'     => '14', //14对私
                'memo'     => 'YXKZZ', //备注
                'notify_url'     => WEB_URL.'kjt_notify'
            ];
        }else{
            require_once ("./extend/lib/kjt_daifu/config.php");
            require_once ("./extend/lib/kjt_daifu/Api.php");
            //查询提现详情  避免客服重新点击
            //$tx_res = $db_obj->get_one("select * from tixian_log where ISNULL(is_llp) and status=0 and id=".intval($txid));
            /**************************请求参数**************************/
            $out_trade_no = 'jjf'.date("YmdHms",time()).$tx_res[id].rand(111111,999999);
            $apiObj = new \Api($apiUrl, $merchantNo, $privateKey, $kjtPublicKey);
            //$tx_res[cash]=0.1;
            $data = [
                'userid'              => 'jjf',
                'out_trade_no'   => $out_trade_no,
                'payer_identity'   => '200003266283',//商户id
                'amount' => $tx_res[cash],
                'bank_card_no'        => trim($tx_res[account]),
                'bank_account_name'     => trim($tx_res[username]),
                'biz_product_code'     => '10221',//即时到账
                'pay_product_code'     => '14', //14对私
                'memo'     => 'JJFZZ', //备注
                'notify_url'     => WEB_URL.'kjt_jjf'
            ];
        }
        $result = $apiObj->transfer_to_cardRequest($data);
        //更新提现表商户流水号以及is_llp状态
        $update_arr = array(
            'no_order'=>$out_trade_no,
            'is_llp'=>1

        );
        MC('tixian_log',$kfdb)->where('id='.intval($txid))->update($update_arr);
        file_put_contents('kjt_res_'.$kfdb.'.txt',date("Y-m-d H:i",time())."---".json_encode($result)."\n",FILE_APPEND);
        if($result['code']=='S10000'){
            mac_return(1,$result['msg']);
        }else{
            mac_return(0,$result['msg']);
        }
        //echo json_encode($result);
    }

}