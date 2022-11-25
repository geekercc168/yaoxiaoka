<?php
namespace app\phone\model;
use think\Db;
use think\Validate;
use think\Loader;
use think\Model;

class Weixin extends model
{
	protected $appScrect;
	protected $appId;

	public function __construct($appScrect="",$appId=""){
			$this->appScrect=$appScrect;
			$this->appId=$appId;

	}

	public function code_shouquan(){
		// echo $this->appScrect;
		// echo $this->appId;
		// exit;
		  $redirect_uri=urlencode("http://book.yueyuecms.com/phone/payment/wechat_pay/");//微信获取网页授权地址
			// 1、引导用户进入授权页面同意授权，获取code 
			// 2、通过code换取网页授权access_token
			// 3、如果需要，开发者可以刷新网页授权access_token，避免过期 
			// 4、通过网页授权access_token和openid获取用户基本信息（支持UnionID机制） 
		 $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appId."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
		 return $url;
		// header("Location: $url");
	}


	public function get_access_token($code){

		//检测缓存中是否有access_token(2小时),如果存在直接返回,不存在则检测缓存中的refresh_token(30天),
		// refresh_token如果存在调用刷新缓存;如果不存在重新发起授权code授权
		$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appId."&secret=".$this->appScrect."&code=".$code."&grant_type=authorization_code";

		$res= file_get_contents($url);
		$res=json_decode($res,true);

		return $res;
	}


	public function get_refresh_token($refresh_token){

		$url="https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$this->appId."&grant_type=refresh_token&refresh_token=".$refresh_token;

		$res= file_get_contents($url);
		$res=json_decode($res,true);

		return $res;


	}

	 public function get_openid_userinfo($access_token,$openid){
	 	$url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
	 	$res= file_get_contents($url);
		$res=json_decode($res,true);

		return $res;
	 }


}