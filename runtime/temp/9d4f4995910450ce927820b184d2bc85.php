<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"/www/wwwroot/yaoxiaoka/application/pc/view/user/profile.html";i:1620490650;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mheader.html";i:1614909815;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mfooter.html";i:1620488383;s:64:"/www/wwwroot/yaoxiaoka/application/pc/view/common/wap_beian.html";i:1623812844;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>账户概览 -要销卡-专注充值卡回收兑换_话费卡回收_游戏点卡回收_加油卡回收</title>
    <link rel="stylesheet" type="text/css" href="/public/wap/css/iconfont.css?v=20211" />
    <link rel="stylesheet" href="/public/wap/css/style_mobile.css?v=20211">
    <link rel="stylesheet" href="/public/layer/theme/default/layer.css?v=20211">
<!--    <link rel="stylesheet" href="//at.alicdn.com/t/font_1786378_3f9wkx8x2vp.css">-->
    <script src="/public/pc/js/jquery-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/layer/layer.js?v=20211" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div class="main_top">账户管理
    <a href="javascript:history.back(-1);" class="back"><img src="/public/wap/img/left_icon.png" alt=""></a>
    <a class="kf_right"><img src="/public/wap/img/kf_icon.png" alt=""></a>
</div>
<div class="acc_list">
    <ul>
        <li>
            <h3 class=""><img src="/public/wap/img/acc_icon1.png" width="20" alt="">实名认证</h3>
            <p>您还未完成实名认证，认证后才可提现</p>
            <a class="sign">立即认证</a>
        </li>
        <li>
            <h3 class=""><img src="/public/wap/img/acc_icon6.png" width="20" alt="">电子合同</h3>
            <p>为保障您的合法权益，请及时签署承诺书</p>
            <a class="sign">签署承诺书</a>
        </li>
        <li>
            <h3 class=""><img src="/public/wap/img/acc_icon2.png" width="20" alt="">收款账户</h3>
            <p>设置收款账户才可正常提现</p>
            <a class="add_payment">账户管理</a>
        </li>
        <li>
            <h3 class=""><img src="/public/wap/img/acc_icon3.png" width="20" alt="">密码保护</h3>
            <p>修改登录密码以及设置提现安全密码</p>
            <a class="mmbh">立即设置</a>
        </li>
        <li>
            <h3 class=""><img src="/public/wap/img/acc_icon4.png" width="20" alt="">微信绑定</h3>
            <p>绑定微信后可获取通知信息</p>
            <a href="javascript: void (0)" onclick="layer.msg('技术正在紧张开发中哦，请等待...')">开发中...</a>
        </li>
<!--        <li>-->
<!--            <h3 class=""><img src="/public/wap/img/acc_icon5.png" width="20" alt="">邮箱绑定</h3>-->
<!--            <p>绑定邮箱后方便找回密码</p>-->
<!--            <a class="yxbd">立即绑定</a>-->
<!--        </li>-->
        <li>
            <h3 class=""><img src="/public/wap/img/acc_icon6.png" width="20" alt="">操作日志</h3>
            <p>查看近期账号登录及操作</p>
            <a href="/pc/user/login_log" class="">查看记录</a>
        </li>
    </ul>
</div>
<a href="/sign/out" class="out_btn">退出登录</a>
<div class="shadow"></div>
<div class="shell_show kf_show_modal animated slideInUp">
    <div class="shell_show_head">请选择官网客服</div>
    <span class="close_btn"><img src="/public/wap/img/close_icon2.png" alt=""></span>
    <div class="shell_show_kl">
        <ul>
            <li onclick="layer.open({
            type: 1,
            title: '官网客服QQ',
            shadeClose: true,
            area: ['100%', '100px'],
            shade: 0.8,
            content: '<br/>&nbsp;&nbsp;&nbsp;1828847938',})"><i class="iconfont icon-message--line"></i>在线客服咨询<span class="shell_show_kl_right"><img src="/public/wap/img/right_icon.png" alt=""></span></li>
            <li onclick="window.location='tel:400-075-5998'"><i class="iconfont icon-phone-line"></i>在线客服电话<span class="shell_show_kl_right"><img src="/public/wap/img/right_icon.png" alt=""></span></li>
            <li onclick="window.location='/'"><i class="iconfont icon-home-smile-line"></i>返回点卡首页<span class="shell_show_kl_right"><img src="/public/wap/img/right_icon.png" alt=""></span></li>
        </ul>
    </div>
</div>
<script>
    $('.kf_right').click(function () {
        $('.shadow').show();
        $('.kf_show_modal').show();
    });
    $('.close_btn,.shadow').click(function () {
        $('.shell_show').hide();
        $('.shadow').hide();
    });
    // $('.kf_right').click(function () {
    //     // window.location.href='mqqwpa://im/chat?chat_type=wpa&uin=169632957&version=1&src_type=web&web_src=oicqzone.com';
    //     window.location.href='mqqwpa://im/chat?chat_type=wpa&uin=169632957&version=1&src_type=web&web_src=';
    // })
    var pos = function (event) {  //鼠标定位赋值函数
        var posX = 0, posY = 0;  //临时变量值
        var e = event || window.event;  //标准化事件对象
        if (e.pageX || e.pageY) {  //获取鼠标指针的当前坐标值
            posX = e.pageX;
            posY = e.pageY;
        } else if (e.clientX || e.clientY) {
            posX = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
            posY = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
        }
        sessionStorage.setItem("cookieLogin", posX.toString()+posY.toString());
        var d = new Date();
        sessionStorage.setItem("passTime", d.getTime());
       
    }

    // var div1 = document.getElementById("div1");
    document.onmousemove = function () {
        // pos();
    }
    
    function saveCookie(){
        let _cookieLogin = sessionStorage.getItem("cookieLogin");
        
        let _passTime = sessionStorage.getItem("passTime");

        let _d = new Date();
        let _now = _d.getTime();
        var _uuid = "<?php echo $_SESSION['think']['uid']; ?>";

        let _time = parseInt(_now) - parseInt(_passTime);
        console.log(_time)
        if(_time >= 30*1000*60){
            $.get('/pc/index/onlineCount',{uid:_uuid},function(res){
                console.log(res);
            },'json');
        }else{
            $.get('/pc/index/onlineCount',{uid:_uuid,redis_time:'yxk'},function(res){
                console.log(res);
            },'json');
        }
        
    }
    var _uuid = "<?php echo $_SESSION['think']['uid']; ?>";
    if(_uuid > 0 ){
       setInterval(saveCookie, 10000); 
    }
    $("body").on("click", function(e) {
        pos();
    });
</script>

<div class="section5" style="margin-bottom: 50px"> 
<p style="text-align: center;"><a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.1xiaoka.com&from=label&code=90030"> <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a></p>
	<br>
<p style="text-align: center;font-size: 12px;color: #b3b9c7;">
    &nbsp;&nbsp;<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=44030402004298">粤公网安备：44030402004298号</a> <br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://beian.miit.gov.cn/#/Integrated/index">ICP证&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：粤ICP备2020113587号</a>
    
</p>
<!-- <p style="margin-top: 20px;line-height: 19px;">
    要销卡平台-提供充值卡回收|点卡回收， 充值卡兑换|点卡兑换， 充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台
</p> -->
<script>
    $(function () {
        let ref = getUrlParam("ref");
        if (ref === "home") {
            $('.mask').show();
            setTimeout(function () {
                $('.smrz_modal').addClass('modal_show');
            },100);
        }
    });
    // 获取url中的参数
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
</script>
<script>
    $('.kf_right').click(function () {
        $('.shadow').show();
        $('.kf_show_modal').show();
    });
    $('.close_btn,.shadow').click(function () {
        $('.shell_show').hide();
        $('.shadow').hide();
    });
    $('.add_payment').click(function () {
        window.location.href='/pc/Tixian/bank_list';
    })
    $('.sign').click(function () {
        layer.open({
            type: 2,
            title: '实名认证',
            shadeClose: true,
            //skin: 'layui-layer-rim', //加上边框
            area: ['90%', '90%'], //宽高
            content: '/pc/User/auth_name'
        });
    })
    $('.mmbh').click(function () {
        layer.open({
            type: 2,
            title: '设置密码',
            shadeClose: true,
            area: ['90%', '90%'],
            shade: 0.8,
            content: '/pc/User/setpwd?type=2',
        });
    })
</script>
<!--底部弹层结束-->
<link rel="stylesheet" href="//at.alicdn.com/t/font_1786378_3f9wkx8x2vp.css">
<!--标签栏开始-->
<div class="tab_bar_bottom"></div>
<div class="tab_bar_nav">
    <!--active为当前页面选中效果-->
    <a href="/" ><i class="iconfont icon-home-smile-line"></i>首页</a>
    <a href="/pc/user/orders"><i class="iconfont icon-file-list--fill"></i>订单</a>
    <a href="/yk_card"><span class="home_btn"><i class="iconfont icon-maichu"></i></span></a>
    <a href="/pc/tixian/add_tx" ><i class="iconfont icon-money-cny-circle-fill"></i>提现</a>
    <a href="/user/profile" class="active"><i class="iconfont icon-user--fill"></i>我的</a>
</div>
