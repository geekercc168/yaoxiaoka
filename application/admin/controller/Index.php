<?php

namespace app\admin\controller;
use think\Session;
use app\admin\model\User;
use think\Controller;
use think\captcha\Captcha;
use think\Validate;

import('lib.global_arr', EXTEND_PATH);

class Index extends Controller
{
    public function index()
    {
        /*$sql = Db::name('options')->where(['option_name'=>'site_optionss'])->find();
        $arr = $this->object_array(json_decode($sql['option_value']));
        $this->assign('sys',$arr);*/
    	$this->assign('admin_title','layui');
        return view();
    }
    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
    function login()
    {
    	$user = Db('user');
		$logname = trim(input('username'));
		$logpass = trim(input('password'));
		$vercode = trim(input('vercode'));
		$request = request(); 	//获取request类
		$ip = $request->ip();	//获取ip地址
		$time = time();//$this->check_verify($vercode)
        $token = $this->request->post('__token__');

        $rule = [
            'username|用户名'      => 'require|length:3,30',
            'password|密码'        => 'require|length:3,30',
            // 'vercode|验证码'       =>'require|captcha',
            '__token__'           => 'token',
        ];
        $checkdata = [
            'username'  => $logname,
            'password'  => $logpass,
            // 'vercode'  => $vercode,
            '__token__' => $token,
        ];

        $validate = new Validate($rule);

        $result = $validate->check($checkdata);
        $data['token'] = $this->request->token();
        if (!$result) {
            $data['status'] = '2';
            $data['tips'] = $validate->getError();
            exit(json_encode($data));
        }
		
		if($logname && $logpass){
			// 查询单个数据//
            $user_info = $user->where(array('username'=>$logname))->find();
			if($user_info){
				if($user_info['status'] == 1){
					if($user_info['password'] == md5("JJpay:!@#%".$logpass)){
                        if($user_info['group_id']){
                            unset($user_info['password']);
                            session('user_info',$user_info);
                            session('login_type',1);//登录状态
                            $login_qx=Db('user_group')->where("group_id=".$user_info['group_id']."")->value('group_roles');
                            session('login_qx',$login_qx);//权限
                            $data['status'] = '1';
                            $data['tips'] = '登录成功';
                            //$index=new \app\admin\model\Index();
                            //$index->login_log();
                        }else{
                            $data['status'] = '2';
                            $data['tips'] = '您没有权限登录后台';
                        }
					}else{
						$data['status'] = '2';
						$data['tips'] = '用户名或密码错误';
					}
				}else{
					$data['status'] = '2';
					$data['tips'] = '该账号已停用，请联系管理员';
				}
			}else{
				$data['status'] = '2';
				$data['tips'] = '用户名或密码错误';
			}
		}else{
			$data['status'] = '2';
			$data['tips'] = '请填写登录信息';
		}
		
		echo json_encode($data);exit;
    }
    /**
     * 退出登录
     */
    function logout($msg = '')
    {	if (empty($msg)) {
    		$msg = '退出成功';
   		}else{
   			$msg = $msg;
   		}
    	session::delete('login_type');		//登录状态
		session::delete('user_info');		//用户信息
		$this->success($msg,'admin/index/index');
    }
    /**
     * 验证码
     */
	public function verify()
    {
		$captcha = new Captcha();
		$captcha->fontSize = 36;
		$captcha->length   = 4;
		$captcha->useNoise = false;
		return $captcha->entry();
    }
	function check_verify($code, $id = ''){
	    $captcha = new Captcha();
	    return $captcha->check($code, $id);
	}
    public function ajax_order(){
        if (request()->isAjax()) {
            $parm=input();
            $res=get_orders($parm);
            return mac_return(0, '查询成功', $res['list'], $res['count'], $res['tj']);
        }
    }
    public function yinglitongji_auto(){

        error_reporting(0);
        set_time_limit(999999);

        file_put_contents('tj.txt', date("Y-m-d H:i:s", time()) . "\n");

//查询昨日盈利
        $zuo_yl = MC('order')->query("select sum(pt_lirun) pt_lirun ,sum(pt_incash) pt_incash,sum(incash) incash,count(distinct uid) total_uids,sum(up_lirun) up_lirun from orders where  status >0 and status <2 and end_time>" . strtotime(date("Y-m-d 00:00:00", time() - 24 * 3600)) . "  and  on_time<" . strtotime(date("Y-m-d 00:00:00", time())));
        $zuo_yl[0] && $zuo_yl=$zuo_yl[0];

//手动补漏用
//$zuo_yl = MC('order')->query("select sum(pt_lirun) pt_lirun ,sum(pt_incash) pt_incash,sum(incash) incash,count(distinct uid) total_uids,sum(up_lirun) up_lirun from orders where  status >0 and status <2 and on_time>".strtotime(date("Y-m-d 00:00:00",time()-48*3600))."  and  on_time<".strtotime(date("Y-m-d 00:00:00",time()-24*3600)));

//查询昨日提现金额
        $zuo_tx = MC('order')->query("select sum(cash) total_cash,sum(yl_fee) total_fee from tixian_log where  status >0 and status <2 and end_time>" . strtotime(date("Y-m-d 00:00:00", time() - 24 * 3600)) . "  and  end_time<" . strtotime(date("Y-m-d 00:00:00", time())));
        $zuo_tx[0] && $zuo_tx=$zuo_tx[0];
        $zuo_total_yl = $zuo_yl['pt_lirun'] + $zuo_tx['total_fee'];

        $yhhz = round($zuo_yl['incash'] + $zuo_yl['up_lirun'], 3);

        $yll = round(($zuo_yl['pt_incash'] - $zuo_yl['incash'] - $zuo_yl['up_lirun']) / ($zuo_yl['incash'] + $zuo_yl['up_lirun']), 4);

//查询昨日用户注册数
        $zuo_user =MC('order')->query("select count(id) total_zhuce from sys_user where register_time>" . strtotime(date("Y-m-d 00:00:00", time() - 24 * 3600)) . "  and  register_time<" . strtotime(date("Y-m-d 00:00:00", time())));
        $zuo_user[0] && $zuo_user=$zuo_user[0];

//查询昨日提现未处理
        $tx_chuli = MC('order')->query("select sum(cash) total_cash from tixian_log where  status<1 and create_time>" . strtotime(date("Y-m-d 00:00:00", time() - 24 * 3600)) . "  and  create_time<" . strtotime(date("Y-m-d 00:00:00", time())));
        $tx_chuli[0] && $tx_chuli=$tx_chuli[0];

//获取周盈利
        $week_yl = MC('order')->query("select sum(pt_lirun) pt_lirun from orders where status >0 and status <2 and end_time>" . strtotime(date("Y-m-d 00:00:01", time() - 7 * 24 * 3600)));
        $week_tx = MC('order')->query("select sum(yl_fee) total_fee from tixian_log where  status >0 and status <2 and end_time>" . strtotime(date("Y-m-d 00:00:01", time() - 7 * 24 * 3600)));
        $week_total_yl = round($week_yl[0]['pt_lirun'] + $week_tx[0]['total_fee'],3);

//查询月盈利
        $month_yl = MC('order')->query("select sum(pt_lirun) pt_lirun from orders where status >0 and status <2 and end_time>" . strtotime(date("Y-m-01", time())));
        $month_tx = MC('order')->query("select sum(yl_fee) total_fee from tixian_log where  status >0 and status <2 and end_time>" . strtotime(date("Y-m-01", time())));
        $month_total_yl =  round($month_yl[0]['pt_lirun'] + $month_tx[0]['total_fee'],3);

//查询总盈利
        $total_yl = MC('order')->query("select sum(pt_lirun) pt_lirun from orders where  status=1");
        $total_tx = MC('order')->query("select sum(fee) total_fee from tixian_log where  status=1");
        $t_total_yl = round($total_yl[0][pt_lirun] + $total_tx[0]['total_fee'],3);

//上月盈利
        if (date("m", time()) == 1) {
            $start_m = 12;
            $start_y = date("Y", time()) - 1;
        } else {

            $start_m = date("m", time()) - 1;
            $start_y = date("Y", time());
        }

        $sy_time = date("Y-m", strtotime(date("Y-m-d") . " -1 month "));
        $sy_yl = MC('order')->query("select sum(pt_lirun) pt_lirun from orders where   status >0 and status <2 and from_unixtime(end_time,'%Y-%m')='" . $sy_time . "'");
        $sy_tx = MC('order')->query("select sum(fee) total_fee from tixian_log where  status >0 and status <2 and from_unixtime(end_time,'%Y-%m')='" . $sy_time . "'");
        $sy_total_yl = round($sy_yl[0]['pt_lirun'] + $sy_tx[0]['total_fee'],3);

        $yonghu_yue = MC('order')->query("select sum(zj_cash) total_cash from sys_user");
        $yonghu_yue[0] && $yonghu_yue=$yonghu_yue[0];

//插入统计表
        $insert_arr = array(
            'riyingli' => $zuo_yl['pt_lirun'],
            'zhouyingli' => $week_total_yl,
            'yueyingli' => $month_total_yl,
            'shangyueyingli' => $sy_total_yl,
            'zongyingli' => $t_total_yl,
            'zuoyingli' => $zuo_total_yl,
            'zuoptsuode' => $zuo_yl['pt_incash'],
            'zuoyhsuode' => $zuo_yl['incash'],
            'zuosxlirun' => $zuo_yl['up_lirun'],
            'zuoyhhuizong' => $yhhz,
            'zuoyinglilv' => $yll,
            'zuoxiaokarenshu' => $zuo_yl['total_uids'],
            'zuotixianjine' => $zuo_tx['total_cash'],
            'zuoxinzhuce' => $zuo_user['total_zhuce'],
            'zuoweitixian' => $yonghu_yue['total_cash'],
            'zuoweichuli' => $tx_chuli['total_cash'],
            'status' => 1,
            'on_time' => time()
        );


        //插入统计表
        $insert_arr_z = array(

            'zuoyingli' => $zuo_total_yl,
            'zuoptsuode' => $zuo_yl['pt_incash'],
            'zuoyhsuode' => $zuo_yl['incash'],
            'zuosxlirun' => $zuo_yl['up_lirun'],
            'zuoyhhuizong' => $yhhz,
            'zuoyinglilv' => $yll,
            'zuoxiaokarenshu' => $zuo_yl['total_uids'],
            'zuotixianjine' => $zuo_tx['total_cash'],
            'zuoxinzhuce' => $zuo_user['total_zhuce'],
            'status' => 1,
            'on_time' => time()  //strtotime(date("Y-m-d 00:00:00",time()-24*3600))
        );
        var_dump($insert_arr);
        MC('zong_yinglitongji')->insert($insert_arr_z);
        MC('yinglitongji')->insert($insert_arr);

        //每日用户余额顺便统计了
        $total_cash=MC('sys_user')->sum('zj_cash');
        $update_arr = array(
            "on_time"=>time(),
            "total_cash"=> $total_cash
        );
        MC('total_cash')->where('id=1')->update($update_arr);
        MC('sys_user')->where('1=1')->update(["is_login"=>0]);
        $nowday=date('d',time());
        if($nowday==15){
            MC('sys_user')->where('setbank=0')->update(['setbank'=>1]);
        }
        die;
    }
    function img_upload(){
        set_time_limit(0);
        $file = request()->file('file');
        $type=input('type');//1卡品牌的logo
        if($file){
            if($type==1){
                $path= 'data' . DS . 'upload'. DS . 'dk_logo';
            }else{
                $path= 'data' . DS . 'upload'. DS.'public';
            }
            if($file->check(['size'=>IMG_SIZE*1024,'ext'=>['gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf']])) {
                    $info = $file->move(ROOT_PATH . $path);
                    if ($info) {
                        $reubfo['info'] = 1;
                        $reubfo['savename'] = $info->getSaveName();
                        $reubfo['data'] = [
                            'src' => DS . $path . DS . $info->getSaveName(),
                        ];
                        /*  $image = \think\Image::open(ROOT_PATH.'public/static/admin/banner'.DS.$reubfo['savename']);
          //                $width = $image->width();
          //                $height = $image->height();
          //                $percent = 0.5;  //图片压缩比
                          $path='public/static/admin/banner/'.date('Ymd');
                          if (!file_exists($path)) {
                              $reubfo['err'] = '生成缩略图失败';
                          }
                          $image->thumb(540,210,1)->save(ROOT_PATH.'public/static/admin/banner'.DS.$reubfo['savename']);*/
                    } else {
                        $reubfo['info'] = 0;
                        $reubfo['err'] = $file->getError();
                    }
            }else { // 上传失败获取错误信息
                $reubfo['info'] = 0;
                $reubfo['err'] =$file->getError();
            }
            echo json_encode($reubfo);
        }
    }
    //快捷通支付回调1xiaoka
    public function kjt_notify(){
        require_once ("./extend/lib/kjt_yxk/config.php");
        require_once ("./extend/lib/kjt_yxk/Api.php");
        //查询提现配置表手续费
        $tx_config = MC('tx_config')->find();
        /**
        $res = file_get_contents("php://input");
        file_put_contents('kjt_input.txt',date("Y-m-d H:i:s",time())."----".$res."\n",FILE_APPEND);
        parse_str($res,$res_arr);
         **/
        file_put_contents('kjt_notify.txt',date("Y-m-d H:i:s",time())."----".json_encode($_POST)."\n",FILE_APPEND);

        /**
         * 回调结果处理。
         */
        $apiObj = new \Api($apiUrl, $merchantNo, $privateKey, $kjtPublicKey);
// 接收快捷通异步通知的支付结果。
//        $json = '{"notify_time":"20200916135601","outer_trade_no":"jjf2020091613093572973705668","_input_charset":"UTF-8","gmt_withdrawal":"20200916135601","sign":"SjOeNcHxNhkV5GLnM2sTMXoRKX3Drk1TkC86HXbsKeIVvP8zfyJi36A23kjL9S7aYwq0fNAvsC4Y6oOtKeTGg816c31v194e9p9UEl8XABzNdEtzOCeGmERj+x\/zwGDJjQ1UD8qy6A+OTvNETWzSyfruERQvFJyQ2Vra\/Cf5\/Ag=","withdrawal_status":"WITHDRAWAL_SUCCESS","version":"1.0","notify_id":"784127e2358f42c3920f10f8d0e2bda2","notify_type":"withdrawal_status_sync","inner_trade_no":"102160023573578153590","fail_reason":"","sign_type":"RSA","withdrawal_amount":"0.10"}';

        //$responseData = json_decode($json,1);
        $responseData = $_POST;
        $result = $apiObj->callbackResultVerifySign($responseData);
//验签
        if($result){
            //$tixian_res = $db_obj->get_one("select * from tixian_log where no_order='".$responseData['outer_trade_no']."'");
            $tixian_res=MC('tixian_log')->where(['no_order'=>$responseData['outer_trade_no']])->find();
            if($tixian_res['end_time']){

            }else{
                if($responseData['withdrawal_status']=='WITHDRAWAL_SUCCESS'){
                    //处理成功逻辑
                    $update_arr = array(
                        'status'=>1,
                        'end_time'=>time(),
                        'ext'=>'KJT付款成功'
                    );
                    MC('tixian_log')->where('id='.intval($tixian_res['id']))->update($update_arr);

                    $fina_arr = array(
                        'action'=>"提现成功",
                        'pingtailirun'=>$tx_config['fee']
                    );
                    MC('finance')->where("orderid='".$tixian_res['id']."'")->update($fina_arr);

                }elseif($responseData['withdrawal_status']=='RETURN_TICKET'){

                    $update_arr = array(
                        'ext'=>'KJT付款退款'
                    );
                    MC('tixian_log')->where('id='.intval($tixian_res['id']))->update($update_arr);

                }elseif($responseData['withdrawal_status']=='WITHDRAWAL_FAIL'){
                    $update_arr = array(
                        'ext'=>'KJT付款失败'
                    );
                    MC('tixian_log')->where('id='.intval($tixian_res['id']))->update($update_arr);
                }else{

                }
            }
        }else{
            file_put_contents('kjt_yanqianshibai.txt',date("Y-m-d H:i:s",time())."----".json_encode($responseData)."\n",FILE_APPEND);
            //echo "验签失败";
        }
        echo 'success';
        die;
    }
    //客服端jjf的快捷通回调
    public function kjt_jjf(){
	    $dkfdb='db3';
        require_once ("./extend/lib/kjt_daifu/config.php");
        require_once ("./extend/lib/kjt_daifu/Api.php");
        //查询提现配置表手续费
        $tx_config = MC('tx_config',$dkfdb)->find();
        file_put_contents('kjt_notify_jjf.txt',date("Y-m-d H:i:s",time())."----".json_encode($_POST)."\n",FILE_APPEND);
        $apiObj = new \Api($apiUrl, $merchantNo, $privateKey, $kjtPublicKey);
// 接收快捷通异步通知的支付结果。
//        $json = '{"notify_time":"20200916135601","outer_trade_no":"jjf2020091613093572973705668","_input_charset":"UTF-8","gmt_withdrawal":"20200916135601","sign":"SjOeNcHxNhkV5GLnM2sTMXoRKX3Drk1TkC86HXbsKeIVvP8zfyJi36A23kjL9S7aYwq0fNAvsC4Y6oOtKeTGg816c31v194e9p9UEl8XABzNdEtzOCeGmERj+x\/zwGDJjQ1UD8qy6A+OTvNETWzSyfruERQvFJyQ2Vra\/Cf5\/Ag=","withdrawal_status":"WITHDRAWAL_SUCCESS","version":"1.0","notify_id":"784127e2358f42c3920f10f8d0e2bda2","notify_type":"withdrawal_status_sync","inner_trade_no":"102160023573578153590","fail_reason":"","sign_type":"RSA","withdrawal_amount":"0.10"}';

        //$responseData = json_decode($json,1);
        $responseData = $_POST;
        $result = $apiObj->callbackResultVerifySign($responseData);
//验签
        if($result){
            //$tixian_res = $db_obj->get_one("select * from tixian_log where no_order='".$responseData['outer_trade_no']."'");
            $tixian_res=MC('tixian_log',$dkfdb)->where(['no_order'=>$responseData['outer_trade_no']])->find();
            if($tixian_res['end_time']){

            }else{
                if($responseData['withdrawal_status']=='WITHDRAWAL_SUCCESS'){
                    //处理成功逻辑
                    $update_arr = array(
                        'status'=>1,
                        'end_time'=>time(),
                        'ext'=>'KJT付款成功'
                    );
                    MC('tixian_log',$dkfdb)->where('id='.intval($tixian_res['id']))->update($update_arr);

                    $fina_arr = array(
                        'action'=>"提现成功",
                        'pingtailirun'=>$tx_config['fee']
                    );
                    MC('finance',$dkfdb)->where("orderid='".$tixian_res['id']."'")->update($fina_arr);

                }elseif($responseData['withdrawal_status']=='RETURN_TICKET'){

                    $update_arr = array(
                        'ext'=>'KJT付款退款'
                    );
                    MC('tixian_log',$dkfdb)->where('id='.intval($tixian_res['id']))->update($update_arr);

                }elseif($responseData['withdrawal_status']=='WITHDRAWAL_FAIL'){
                    $update_arr = array(
                        'ext'=>'KJT付款失败'
                    );
                    MC('tixian_log',$dkfdb)->where('id='.intval($tixian_res['id']))->update($update_arr);
                }else{

                }
            }
        }else{
            file_put_contents('kjt_yanqianshibai_jjf.txt',date("Y-m-d H:i:s",time())."----".json_encode($responseData)."\n",FILE_APPEND);
            //echo "验签失败";
        }
        echo 'success';
        die;
    }
}
