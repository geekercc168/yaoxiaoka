<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\pc\controller;

use think\captcha\Captcha;
use think\Controller;
// use think\Db;
use think\Request;
use think\Session;
use think\Cookie;
use think\Validate;

class Sign extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('is_mobile', is_mobile()?1:0);
    }

    //点击登录生成一个cookie
    public function MemberLoginCookie()
    {
        if (Request::instance()->isAjax()) {
            //生成4位图形验证码
            $origin = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
            for ($i = 0; $i < 4; $i++) {
                $mystr[] = $origin{rand(0, strlen($origin) - 1)};
            }
            $str = join("", $mystr);
            //代替图形验证码
            Cookie::set('verifycode', $str, 600);
            $data['code'] = 200;
            $data['msg'] = '图形验证码成功';
        } else {
            $data['code'] = 0;
            $data['msg'] = '图形验证码失败';
        }
        echo json_encode($data);
    }

    public function in222a()
    {
        if (Request::instance()->isAjax()) {

            $login_user=input('username')?:'';
            $user_info=MC('sys_user')->where(['username'=>$login_user,'password'=>md5(input('userpass'))])->find();
            if($user_info){
                if($user_info[is_del]==1 || $user_info[group_id]==0){
                    return mac_return(0,'账号已被注销或冻结，请联系客服！');
                }
                    if(!$user_info[up_id]){
                        unset($user_info['password']);
                        $lifeTime = 24 * 3600;
                        session_set_cookie_params($lifeTime);
                        session::set('uid',$user_info['id']);
                        session::set('uinfo',$user_info);
                        $data['is_truename']=is_truename(session('uinfo.id'));//是否
                        //更新用户状态
                        //写入登录日志表

                        $ip =getIP();
                        $dataArray =array(
                            'uid'=>$user_info[id],
                            'login_time'=>time(),
                            //'address'=>core_class::GetIpLookup($ip),
                            'ip'=>$ip,
                            'REMOTE_IP'=>$_SERVER[REMOTE_ADDR].":".$_SERVER[REMOTE_PORT],
                            'server_info'=>json_encode($_SERVER),
                        );
                        MC('login_log')->insert($dataArray);
                        //更新会员表的登录信息
                        $dataArray =array(
                            'last_login_time'=>time(),
                            'last_login_ip'=>$ip,
                            'is_login'=>1
                        );
                        MC('sys_user')->where('id='.$user_info[id])->update($dataArray);
                        SetRedis('is_login'.$user_info[id],1);//更新状态
                        return mac_return(1,'登录成功！',$data);
                    }else{
                        $res = MC('pt_yuming')->where('uid="'.$user_info[up_uid].'"')->find();
                        echo '<script type="text/javascript">alert("您不是此平台用户!");</script>';die;
                        die('<script type="text/javascript">top.location.href="http://'.$res[pt_yuming].'.jijipay.com";</script>');
                    }



            }else{
                return mac_return(0,'账户或密码错误！');
            }
        }
        return view();
    }
    
    public function in()
    {
        if (Request::instance()->isAjax()) {

            $token = $this->request->post('__token__');
            $rule = [
                '__token__'  => 'require|token',
            ];
            $checkdata = [
                '__token__' => $token,
            ];

            $validate = new Validate($rule);
            $result = $validate->check($checkdata);

            $msgdata['token'] = $this->request->token();
            if (!$result) {
                $msgdata['msg'] = $validate->getError();
                return mac_return(0,$msgdata);
            }

            $login_user = trim(input('username'))?:'';
            $user_info = MC('sys_user')->where(['username'=>$login_user])->find();

            $new_pwd = jaja_md5($login_user,trim(input('userpass')));

            if($new_pwd != $user_info['password']){
                $msgdata['msg'] = '账户或密码错误！';
                return mac_return(0,$msgdata);
            }
            if($user_info){
                if($user_info['is_del']==1 || $user_info['group_id']==0){
                    $msgdata['msg'] = '账号已被注销或冻结，请联系客服！';
                    return mac_return(0,$msgdata);
                }
                    if(!$user_info['up_id']){
                        unset($user_info['password']);
                        $lifeTime = 24 * 3600;
                        session_set_cookie_params($lifeTime);
                        session::set('uid',$user_info['id']);
                        session::set('uinfo',$user_info);
                        $data['is_truename']=is_truename(session('uinfo.id'));//是否
                        //更新用户状态
                        //写入登录日志表

                        $ip =getIP();
                        $dataArray =array(
                            'uid'=>$user_info['id'],
                            'login_time'=>time(),
                            //'address'=>core_class::GetIpLookup($ip),
                            'ip'=>$ip,
                            'REMOTE_IP'=>$_SERVER['REMOTE_ADDR'].":".$_SERVER['REMOTE_PORT'],
                            'server_info'=>json_encode($_SERVER),
                        );
                        MC('login_log')->insert($dataArray);
                        //更新会员表的登录信息
                        $dataArray =array(
                            'last_login_time'=>time(),
                            'last_login_ip'=>$ip,
                            'is_login'=>1
                        );
                        MC('sys_user')->where('id='.$user_info['id'])->update($dataArray);
                        SetRedis('is_login'.$user_info['id'],1,2500);//更新状态
                        return mac_return(1,'登录成功！',$data);
                    }else{
                        $res = MC('pt_yuming')->where('uid="'.$user_info['up_uid'].'"')->find();
                        echo '<script type="text/javascript">alert("您不是此平台用户!");</script>';die;
                        die('<script type="text/javascript">top.location.href="http://'.$res['pt_yuming'].'.jijipay.com";</script>');
                    }



            }else{
                $msgdata['msg'] = '账户或密码错误！';
                return mac_return(0,$msgdata);
            }
        }
        return view();
    }

    public function up()
    {
        if (Request::instance()->isAjax()) { 
            mac_return('0', '注册通道暂时关闭！');
            $txt_mobile = input('tel');
            $txt_code = input('telcode');
            $loginName = trim(input('username'));
            $url = input('');
            $password = input('userpass');
            //$tx_password = input('');
            $qq = input('qqnumber');
            $email = input('email');
            $code_res = MC('vire_code')->where(['type' => 3, 'mobile' => $txt_mobile])->order('on_time desc')->find();
            if(!$code_res){
                mac_return('0', '未输入验证码或验证码异常！');
            }
            if (($code_res['on_time'] + 300) < time()) {
                return mac_return('0', '验证码超时，请重新获取！');

            } else {
                if ($txt_code == $code_res['code']) {
                    $res = MC('sys_user')->where(['username' => $loginName])->find();
                    if ($res) {
                        return mac_return('0', '该用户名已存在，请更换');
                    }
                    $insert_arr = array(
                        'username' => $loginName,
                        'password' => jaja_md5($loginName,trim($password)),
                        //'truename'=>trim($realname),
                        //'idcard'=>$idcardno,
                        'qq' => $qq,
                        'email' => $email,
                        'zj_cash' => 0.00,
                        'mobile' => $txt_mobile,
                        'is_mobile_auth' => 1,
                        'last_login_ip' => request()->ip(),
                        'register_ip' => request()->ip(),
                        'last_login_time' => time(),
                        'register_time' => time(),
                        'group_id' => 1
                    );
                    MC('sys_user')->insert($insert_arr);
                    return mac_return('1', '注册成功，请牢记密码！');
                } else {


                    return mac_return('0', '短信验证码有误');
                }

            }


        }
        $this->assign('is_mobile', is_mobile()?1:0);
        return view();
    }

    public function passwd()
    {
        if (Request::instance()->isAjax()){
            $txt_mobile=input('tel');
            $txt_code=input('telcode');
            $username=input('username');
            $code_res = MC('vire_code')->where(['type' => 4, 'mobile' => $txt_mobile])->order('on_time desc')->find();
            if(!$code_res){
                mac_return('0', '未输入验证码或验证码异常！');
            }
            if (($code_res['on_time'] + 300) < time()) {
                return mac_return('0', '验证码超时，请重新获取！');
            }else{
                if ($txt_code == $code_res['code']) {
                    $res = MC('sys_user')->where(['mobile' => $txt_mobile,'username'=>$username])->find();
                    //dy($res);
                    if (!$res) {
                        return mac_return('0', '该手机号注册用户不存在！');
                    }
                    $insert_arr = array(
                        'password' => jaja_md5($username,trim(input('userpass'))),
                    );
                    MC('sys_user')->where(['mobile' => $txt_mobile,'username'=>$username])->update($insert_arr);
                    return mac_return('1', '重置成功，请牢记密码！');
                } else {
                    return mac_return('0', '短信验证码有误');
                }
            }
        }
        $this->assign('is_mobile', is_mobile()?1:0);
        return view();
    }

    //发送短信验证码
    public function sms()
    {
        $vercode = trim(input('code'));
        if ($this->check_verify($vercode)) {
            $txt_mobile = input('tel');
            $type=intval(input('type'));
            $top3 = substr($txt_mobile, 0, 3);
            $no_arr = array(170, 171);
            $captcha=input('captcha');
            if (in_array($top3, $no_arr)) {
                return mac_return('0', '170,171号段无法接收短信');
            } else {
//                $mobile_res = MC('sys_user')->where("mobile='" . $txt_mobile . "'")->find();
//                if ($mobile_res) {
//                    //core_class::echojson('该手机号已经注册', 2);
//                    return mac_return('0', '该手机号已经注册');
//                } else {
                   // $code=1111;

                    $code = rand(1111, 9999);
                    $re=send_sms($txt_mobile,$code);
                    if(!$re){
                        echo mac_return(0, '验证码发送失败');
                    }else{
                        $insert_arr = array(
                            'mobile' => $txt_mobile,
                            'type' => $type,
                            'status' => 1,
                            'code' => $code,
                            'on_time' => time()
                        );
                        $id=MC('vire_code')->insertGetId($insert_arr);
                        return mac_return(1, '验证码已发送',['code_id'=>$id]);
                    }

                //}
            }
        } else {
            return mac_return(0, '输入的图形验证码错误');
        }
    }

    function check_verify($code, $id = '')
    {
        $captcha = new Captcha();
        return $captcha->check($code, $id);
    }


    public function rand_str($length)
    {
        $chars = array_merge(range('a', 'z'), range('A', 'Z'), range(1, 9));
        $rand_keys = array_rand($chars, $length);
        shuffle($rand_keys);
        foreach ($rand_keys as $key) {
            $str[] = $chars[$key];
        }
        return implode($str);
    }
    //退出登录
    public function out(){
        $dataArray =array(
            'is_login'=>0
        );
        MC('sys_user')->where('id='.intval(session('uinfo.id')))->update($dataArray);
        DelRedis('is_login'.intval(session('uinfo.id')));
        session::Clear();
//        cookie('verifycode', null);

        $this->redirect('/');
    }
}