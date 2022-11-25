<?php


namespace app\pc\controller;


use think\Request;

import('lib.global_arr', EXTEND_PATH);

class Tixian extends Base
{
    //申请提现
    public function add_tx()
    {
        $is_truename = is_truename(session('uinfo.id'));//是否实名认证
        $uinfo = MC('sys_user')->field('id,zj_cash,tx_pwd,mobile,truename,sxf_bank,sxf_alipay')->where(['id' => session('uinfo.id')])->find();
        $this->assign('is_truename', $is_truename);
        $this->assign('is_mobile', is_mobile()?1:0);
        $tx_config = MC('tx_config')->field('fee,need_truename_auth,need_kjt,need_zfb')->where('id=1')->find();
        
        $sxf_alipay = !empty($uinfo['sxf_alipay']) ? $uinfo['sxf_alipay'] : $tx_config['fee'] ;
        $sxf_bank = !empty($uinfo['sxf_bank']) ? $uinfo['sxf_bank'] :  $tx_config['fee'] ;

        $this->assign('sxf_alipay', $sxf_alipay);
        $this->assign('sxf_bank', $sxf_bank);
        $this->assign('tx_config', $tx_config);

        $this->assign('uinfo', $uinfo);
        

        if (request()->isAjax()) {
            $banktype = input('banktype/d');

            $where_member_bank = [
                'uid' => $uinfo['id'],
                'id'  => $banktype
            ];

            if($is_truename!=1){
                return mac_return(0,'账户未实名认证，请先实名认证后申请');
            }
            //临时授权提现的用户和登录后已发送过一次不需要短信验证码//$uinfo[is_tixian] == 1 ||
            if (session('tx_sms_code')==1) {

            }else{
                $txt_code = input('telcode');
                $code_res = MC('vire_code')->where(['type' => 2, 'mobile' => $uinfo['mobile']])->order('on_time desc')->find();
                if (($code_res['on_time'] + 300) < time()) {
                    return mac_return('0', '验证码超时，请重新获取！');
                }
                if ($txt_code != $code_res['code']) {
                    return mac_return('0', '验证码错误！');
                }
                //验证全通过
                session('tx_sms_code',1);//设置暂时无需验证码
            }
            if ($tx_config['need_truename_auth'] == 1 && $is_truename != 1) {
                return mac_return(0, '未实名或提现账户与实名信息不符，先更新实名信息！');
            }

            $field_member_bank = 'id,bank_number,bank_name,bankname,bank,zfb_number';
            $default = MC('member_bank')->field($field_member_bank)->where($where_member_bank)->find();

            if(!$default){
                return mac_return(0,'提现方式不能为空');
            }
            if($default['bank_name'] != $uinfo['truename'])
                return mac_return(0, '提现姓名与注册姓名不符');
                
            if(empty($default['zfb_number'])){
                $tx_config_fee = !empty($uinfo['sxf_bank']) ? $uinfo['sxf_bank'] :  $tx_config['fee'] ;
            }else{
                $tx_config_fee = !empty($uinfo['sxf_alipay']) ? $uinfo['sxf_alipay'] : $tx_config['fee'] ;
            }

            $fp = fopen("lock.txt", 'w+');
            if (flock($fp, LOCK_EX)) {
                //提现额度已取消3000000
                //过滤每笔提现范围
                $tx_cash=number_format(input('money'),2,".","");//提现金额
                if ($tx_cash >= 10 && $tx_cash < 50000) {
                    $tx_pwd=input('safecode');//提现密码
                    //$total_cash=$tx_cash;//总金额
                    if($uinfo['tx_pwd']==md5($tx_pwd.PWD_JJF)){
                        if($uinfo['zj_cash']<$tx_cash){
                            $ret=0;
                            $remsg='提现余额不足';
                        }else{
                            //写入提现记录表

                            $tx_arr =array(
                                'uid'=>$uinfo['id'],
                                'create_time'=>time(),
                                'username'=>$default['bank_name'],
                                'bankname' =>$default['bank'] == 19 ? '支付宝' : $default['bankname'],
                                'account' => $default['bank'] == 19 ? $default['zfb_number'] : $default['bank_number'],
                                'cash'=>$tx_cash-$tx_config_fee,
                                'fee'=>$tx_config_fee,
                                'yl_fee'=>number_format($tx_config_fee-0.8,2),
                                'bank'=>$default['bank'],
                                'idcard'=>$uinfo['idcard'],
                                'status'=>0,
                                'ext'=>'提现申请'
                            );
                            
                            $last_id=MC('tixian_log')->insertGetId($tx_arr);
                            //更新用户金额，写入财务记录表
                            $nzj_cash = $uinfo[zj_cash]-$tx_cash;
                            $update_arr = array(
                                'zj_cash'=>$nzj_cash,
                                'is_tixian'=>0
                            );
                            MC('sys_user')->where(['id'=>$uinfo['id']])->update($update_arr);
                            //$db_obj->update('sys_user', $update_arr,'id='.$uinfo[id]);
                            $fina_array =array(
                                'uid'=>$uinfo['id'],
                                'old_cash'=>$uinfo['zj_cash'],
                                'cash'=>$tx_cash,
                                'action'=>'提现申请',
                                'on_time'=>time(),
                                'new_cash'=>$nzj_cash,
                                'orderid'=>$last_id,
                                'ext'=>2
                            );
                            MC('finance')->insert($fina_array);
                            $ttt = 'kehutixian'.intval($tx_cash);
                            send_sms(18126117527, $ttt);  //庆 18671713149 13659884552
                            $ret=1;
                            $remsg='提现申请已提交，请等待系统审核';
                        }
                    }else{
                        $ret=0;
                        $remsg='提现密码错误,请核对后输入';
                    }
                } else {
                    $ret=0;
                    $remsg='每笔提现金额范围为10-50000元';
                }
                flock($fp, LOCK_UN);
                clearstatcache();
                fclose($fp);
                return mac_return($ret,$remsg);
            } else {
                file_put_contents('bingfa.txt', date("Y-m-d H:i:s") . ":" . json_encode($_REQUEST) . "\n", FILE_APPEND);
                flock($fp, LOCK_UN);
                clearstatcache();
                fclose($fp);
                return mac_return(0, '提现业务正忙，请稍后再申请');
            }
        } else {
            $bank_arr = \global_arr::bank_arr();

            $bank_list = MC('member_bank')->field('id,bank_number,bank_name,bankname,bank,zfb_number')->where(['uid'=>$uinfo['id']])->limit(2)->select();

            $zfb = $yxk = 0;
            $neaaarr = [];
            foreach ($bank_list as $key => $value) {
                if($value['bank'] == 19 and $tx_config['need_zfb'] == '1'){
                    $zfb = 1;
                    $neaaarr[$key] = $value;
                }
                if($value['bank'] != 19 and $tx_config['need_kjt'] == '1'){
                    $yxk = 1;
                    $neaaarr[$key] = $value;
                }
            }

            $this->assign('zfb', $zfb);
            $this->assign('yxk', $yxk);
            $this->assign('bank_arr', $bank_arr);
            $this->assign('bank_list', $neaaarr);
            return view();
        }

    }

    //提现列表
    public function lists()
    {
        if (request()->isAjax()) {
            $parm = input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $parm['txt_uid'] = session('uinfo.id');
            return tixian_list($parm);
        } else {
            if(is_mobile()){
                return view('m_lists');
            }
            return view();
        }
    }

    //用户账变明细
    public function card_logg()
    {
        if (request()->isAjax()) {
            $parm = input();
            if(!isset($parm['search_time'])){
                $parm['search_time']= date('Y-m-d 00:00:00') . ' - ' . date('Y-m-d 23:59:59');
            }
            $parm['txt_uid'] = session('uinfo.id');
            return cash_log($parm);
        } else {
            return view();
        }
    }

    //银行卡列表
    public function bank_list()
    {
        $this->assign('is_mobile', is_mobile()?1:0);
        if (request()->isAjax()) {
            $map = array();
            $p = trim(input('page')) ? trim(input('page')) : 1;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE;
            $start = ($p - 1) * $limit;
            $map['uid'] = session('uinfo.id');
            $list = MC('member_bank')->field('*')->where($map)->order('id desc')->limit($start, $limit)->select();
            foreach ($list as &$v) {
                $bank_arr = \global_arr::bank_arr();
                $v['bank'] = $bank_arr[$v['bank']];
            }
            $count = MC('member_bank')->where($map)->count();
            return mac_return(0, '查询成功', $list, $count);
        } else {
            return view();
        }
    }

    //删除银行卡
    public function del_bank()
    {
        if (Request::instance()->isAjax()) {
            $ids = explode(',', input('post.id'));
            if (MC('member_bank')->where(['id' => ['in', $ids],'uid'=>session('uinfo.id')])->delete()) {
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }

    //添加银行卡
    public function bank()
    {
        $id = input('id');
        $uinfo = session('uinfo');
        $uinfo=$sys_user=MC('sys_user')->where(['id' => intval($uinfo['id'])])->find();
        $uid=intval($uinfo['id']);
        $bank_res = MC('member_bank')->where(['uid' =>$uid ])->find();
        $res = MC('truename_auth')->where("status=1 and uid = ".$uid)->find();
        $this->assign('bank_res', $bank_res);
        $this->assign('res', $res);
        $way_add = input('way_add','yhk');

        $this->assign('way_add',$way_add);
        //查询该用户手机号之前平台的收款人姓名
        $truename = MC('sys_user')->where(['mobile' => $uinfo['mobile']])->order('id desc')->limit(1)->value('truename');
        if (Request::instance()->isPost()) {

            $zfb = trim(input('zfb_nums'));

            $banktype = input('banktype');
            $txt_truename = input('txt_truename');
            $zfb_txt_truename = input('zfb_txt_truename');
            $nums = input('nums');
            $swmr = input('swmr');
            $rel_nums = input('rel_nums');

            if (empty($zfb)) {
                if (!$banktype) return mac_return(0, '请选择银行！');
                if ($uinfo['truename'] && trim($uinfo['truename'])!=trim($txt_truename)) {
                    return mac_return(0, "同一账号只能使用相同收款人");
                }
                if(empty($nums)) return mac_return(0, '请输入卡号');
                if($nums != $rel_nums) return mac_return(0, '两次输入的卡号不同');

                $updete_array = array(
                    'bank_number' => $nums,
                    'bank_name' => $txt_truename,
                    'bank' => $banktype,
                    'uid' => $uid,
                    'type' => $swmr,
                    'bankname' => input('bankname'),
                    'on_time' => time()
                );
            }else{
                if ($uinfo['truename'] && trim($uinfo['truename'])!=trim($zfb_txt_truename)) {
                    return mac_return(0, "同一账号只能使用相同收款人");
                }
                if(empty($zfb)) return mac_return(0, '请输入卡号');
                $updete_array = array(
                    'bank_number' => 0,
                    'bank_name' => $zfb_txt_truename,
                    'zfb_number' => $zfb,
                    'bank' => 19,
                    'uid' => $uid,
                    'type' => $swmr,
                    'bankname' => input('bankname'),
                    'on_time' => time()
                );
                $txt_truename = $zfb_txt_truename;
            }

            if ($swmr == 1) {
                MC('member_bank')->where(['uid' => $uid])->update(['type' => 2]);
            } else {
                $swmr = 2;
            }
            
            $msg='';
            if(trim($sys_user['truename'])!=trim($txt_truename)){
                $up_user =array(
                    'truename'=>$txt_truename
                );
                if($sys_user['truename']){
                    $up_user['setbank']=0;
                    $msg='每月仅限一次修改为他人银行卡，您本月将无法再次变更他人银行卡';
                }
                MC('sys_user')->where('id=' . $uinfo['id'])->update($up_user);
            }

            if ($id) {
                MC('member_bank')->where('id=' . $id . '')->update($updete_array);
                return mac_return(1, '银行卡编辑成功'.$msg);
            } else {
                MC('member_bank')->insert($updete_array);
                return mac_return(1, '银行卡添加成功'.$msg);
            }

        } else {
            if ($id) {
                $item = MC('member_bank')->where(['id' => $id])->find();
                $this->assign('item', $item);
            }
            //银行键值对
            $bank_arr = array(
                '1' => '招商银行',
                '2' => '工商银行',
                '3' => '建设银行',
                '4' => '浦发银行',
                '5' => '农业银行',
                '6' => '民生银行',
                '7' => '深圳发展银行',
                '8' => '兴业银行',
                '9' => '平安银行',
                '10' => '交通银行',
                '11' => '中信银行',
                '12' => '光大银行',
                '13' => '上海银行',
                '14' => '华夏银行',
                '15' => '广东发展银行',
                '16' => '邮政银行',
                '17' => '北京银行',
                '18' => '中国银行',
                // '19'=>'支付宝',
                //'20'=>'财付通',
                '21' => '其他'
            );

            $this->assign('bank_arr', $bank_arr);
            $this->assign('truename', $truename);
            return view();
        }
    }

}