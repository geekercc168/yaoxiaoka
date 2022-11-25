<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

function decrypt1($string, $key='12f862d21dcfeafb57bckfrrt5yuiopf')
    {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        return $decrypted;
    }
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

$total=$_GET['total'];
$a=explode('total',$total);
$uid=decrypt1($_GET['uid']);//echo $uid;exit();
$type=$_GET['type'];
//$uid=499;
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("微信公众号支付");
$input->SetAttach($uid);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($a[0]*100);
//$input->SetTotal_fee(1);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://www.ssyoo.cn/phone/payment/barcodewx/pay_type/".$type);
$input->SetTrade_type("JSAPI");

//$input->SetPackage("prepay_id=wx123123123123123");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);


$jsApiParameters = $tools->GetJsApiParameters($order);

 

//获取共享收货地址js函数参数
//$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	
    <title>微信支付</title>

    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				var msg = res.err_msg;
//alert(msg);
				if (msg == "get_brand_wcpay_request:ok") {
					alert("支付成功，跳转到订单详情页");
					location.href = "http://www.ssyoo.cn/#/me/";
				} else {
					if (msg == "get_brand_wcpay_request:cancel") {
						var err_msg = "您取消了微信支付";
						location.href='http://www.ssyoo.cn/#/me/';
					} else if (res.err_code == 3) {
						var err_msg = "您正在进行跨号支付正在为您转入扫码支付,请选择扫码支付......";
						location.href='http://www.ssyoo.cn/#/me/';
						//location.href='http://ssyoo.cn/pay/wechat/';
					} else if (msg == "get_brand_wcpay_request:fail") {
						var err_msg = "微信支付失败错误信息：" + res.err_desc;
						location.href='http://www.ssyoo.cn/#/me/';
					} else {
						var err_msg = msg + "" + res.err_desc;
						location.href='http://www.ssyoo.cn/#/me/';
					}

					alert(err_msg);
				//	show_notice(err_msg);
				}
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	callpay();
	</script>


</head>
<body>
  <!--  <br/>
    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">11分</span>钱</b></font><br/><br/>
	<div align="center">
		
		<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
	</div>-->
</body>
</html>