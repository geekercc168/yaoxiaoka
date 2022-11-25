var deviceWidth = parseInt(window.screen.width);
var deviceScale = deviceWidth / 720;
var ua = navigator.userAgent;
if(/Android (\d+\.\d+)/.test(ua)) {
	var version = parseFloat(RegExp.$1);
	if(version > 2.3) {
		document.write('<meta name="viewport" content="width=720,initial-scale=' + deviceScale + ', minimum-scale = ' + deviceScale + ', maximum-scale = ' + deviceScale + ', target-densitydpi=device-dpi">');
	} else {
		document.write('<meta name="viewport" content="width=720,initial-scale=0.72,maximum-scale=0.72,minimum-scale=0.72,target-densitydpi=device-dpi" />');
	}
} else {
	document.write('<meta name="viewport" content="width=720, user-scalable=no">');
}

function err() {

}

//

function fangfa() {
	var browser = {
		versions: function() {
			var u = navigator.userAgent,
				app = navigator.appVersion;
			return { //移动终端浏览器版本信息
				trident: u.indexOf('Trident') > -1, //IE内核
				presto: u.indexOf('Presto') > -1, //opera内核
				webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
				gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
				mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
				ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
				android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或uc浏览器
				iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
				iPad: u.indexOf('iPad') > -1, //是否iPad
				webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
			};
		}(),
		language: (navigator.browserLanguage || navigator.language).toLowerCase()
	}
	if(browser.versions.mobile) { //判断是否是移动设备打开。browser代码在下面
		var ua = navigator.userAgent.toLowerCase(); //获取判断用的对象
		if(ua.match(/MicroMessenger/i) == "micromessenger") {
			//this.she = "微信端"
			localStorage.setItem("mobile", "wei")
			//在微信中打开
		} else {
			if(browser.versions.ios == true) {
				localStorage.setItem("mobile", "ios")
			} else {
				localStorage.setItem("mobile", "yi")
			}
		}
	} else {
		localStorage.setItem("mobile", "pc")
		//否则就是PC浏览器打开
	}
}

fangfa()