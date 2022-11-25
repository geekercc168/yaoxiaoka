<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:56:"/www/wwwroot/yaoxiaoka/application/pc/view/about/me.html";i:1622619187;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/header.html";i:1621324688;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/footer.html";i:1632456108;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="baidu-site-verification" content="<?php echo GetRedis('jaja_keywords'); ?>" />
    <meta name="sogou_site_verification" content="<?php echo GetRedis('jaja_keywords'); ?>"/>
    <head>
        <meta http-equiv="Content-Type" content="text/html;
charset=gb2312"/>
        <meta name="sogou_site_verification" content="<?php echo GetRedis('jaja_keywords'); ?>"/>
    </head>
    <title><?php echo GetRedis('jaja_title'); ?></title>
    <meta name="description" content="<?php echo GetRedis('jaja_desc'); ?>">
    <meta name="keywords" content="<?php echo GetRedis('jaja_keywords'); ?>">
</head>


<link rel="stylesheet" type="text/css" href="/public/pc/css/iconfont.css?v=20211" />
<link rel="stylesheet" type="text/css" href="/public/pc/css/datouwang.css?v=20211" />

<!-- 引入组件库 -->
<script src="/public/pc/js/jquery-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/public/pc/js/encryption.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/public/pc/js/public.js?v=20211" type="text/javascript" charset="utf-8"></script>
<script src="/public/layer/layer.js?v=20211" type="text/javascript" charset="utf-8"></script>

<body>
<div id="floatTools" class="rides-cs" style="height:286px;background: none;">
    <!--<div class="fix_right" style="height: 311px;top: 393px">-->

    <!--    <div class="fix_right_kf">-->
    <!--        <i class="iconfont icon-kefu"></i>联系客服-->
    <!--    </div>-->
    <!--    <div class="fix_right_api fix_right_ewm">-->
    <!--        <i class="iconfont icon-api"></i>API接口-->
    <!--    </div>-->
        
    <!--</div>-->
  
    <div id="divFloatToolsView" class="floatR" style="display: none;height:267px;width: 100%;overflow: unset;">
        <div class="cn" style="margin-left: -238px;position: absolute;width: 167px;margin-top: -19px;height: 128px;">
            <!-- <h3 class="titZx">在线客服</h3> -->
            <ul>
                <li>
                    <span>售前客服</span>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1828847938&amp;site=qq&amp;menu=yes"><img border="0" src="/public/pc/images/online.png" alt="点击这里给我发消息" title="点击这里给我发消息"></a>
                </li>
                <li>
                    <span>售后客服</span>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1828847938&amp;site=qq&amp;menu=yes"><img border="0" src="/public/pc/images/online.png" alt="点击这里给我发消息" title="点击这里给我发消息"></a>
                </li>
                <li>
                    <span>商务客服</span>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1828847938&amp;site=qq&amp;menu=yes"><img border="0" src="/public/pc/images/online.png" alt="点击这里给我发消息" title="点击这里给我发消息"></a>
                </li>

            </ul>
        </div>
    </div>
    
</div>
<script type="text/javascript">
 
    $(function(){
        $(".fix_right").click(function(){
            $('#divFloatToolsView').toggle();
            $('#aFloatTools_Hide').show();
        });
    });
    
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
        pos();
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
            },'json')
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
    
</script>
</body>
</html>
<link rel="stylesheet" type="text/css" href="/public/pc/css/about.css?v=2021"/>
<link rel="stylesheet" type="text/css" href="/public/pc/css/about.css?v=2021"/>
<link href="/public/pc/new/css/bootstrap.css" rel="stylesheet">
<link href="/public/pc/new/css/style.css" rel="stylesheet">
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top small-nav"  style="margin-top:0px;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                 aria-controls="navbar"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span
                     class="icon-bar"></span></button>
                <p class="logo_box" style="background-color:unset">
                    <a href="javascript:;">
                        <img src="/public/pc/images/nologo6.png" class="logo" alt="">
                    </a>
                </p>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-nav-c">
                    <li><a href="/">首页</a></li>
                   
                    <li class="dropdown">
                        <?php if(\think\Session::get('uid')): ?>
                            <a href="/yk_card.html">我要销卡</a>
                        <?php else: ?>
                            <a href="/sign/in">我要销卡</a>
                        <?php endif; ?>
                    </li>
                    
                    <li><a href="/me">联系我们</a></li>
                    <?php if(\think\Session::get('uid')): ?>
                        <li class="dropdown"><a href="/user">个人中心</a>
                            <a href="javascript:;" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-menu-down btn-xs"></span></a>
                            <ul class="dropdown-menu nav_small" role="menu" style="display: none;">
                                <li><a href="/yk_card">我要售卡</a></li>
                                <li><a href="/user/cash">我要提现</a></li>
                                <li><a href="/user/profile">账户管理</a></li>
                                <li><a href="/sign/out">退出账户</a></li>
                            </ul>
                       </li>
                    <?php else: ?>
                      <li class="dropdown"><a href="/sign/in">登录/注册</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
    
</header>
<div style="height:80px;clear:both"></div>
<div class="about_banner">
    <div class="main_title_white"><p class="p1">COMPANY PROFILE</p><p class="p2">公司简介</p><div class="title_line_white"></div></div>
</div>
<div class="container" style="padding: 15px">
    &nbsp;&nbsp;&nbsp;&nbsp;深圳宏信智联科技有限公司自主开发的要销卡数字卡密交易平台，致力于为会员提供专业、稳定、安全、便捷的卡类回收服务。直接面对用户回收，足不出户即可提交卡号卡密完成回收交易，让企业置闲、员工福利、亲友相赠等方式获取的礼品卡快速变现，以达到资金回流最大化。为广大用户提供安全可靠、简易操作、提现快捷的回收卡服务， 资金安全方面平台实名认证更有保障。

    &nbsp;&nbsp;&nbsp;&nbsp;公司资质齐全，自成立以来始终坚持以诚为本、以信立人，秉承客户至上、服务第一的经营理念，为客户提供专业、贴心、周到的服务； "互利互惠、合作共赢"是宏信智联的企业发展宗旨，宏信智联愿与广大客户共同建立良好的合作环境。 
</div>
<!--底部-->
<style>
      footer {
        text-align: center;
        background-color: #4b4b4a;
        color: #ababa8;
        padding: 20px 0px 20px 0px;
        margin-top: 20px;
        font-size: 13px;
    }
    .copyright a {
        color: #ababa8;
    }
</style>

<footer>
    <div class="copyright">
        <p><a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.1xiaoka.com&from=label&code=90030"> <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a></p>
        <br>
        <p class="copyright_p"><p>版权所有：深圳宏信智联 <img src="/public/pc/images/gwab.png">
        <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=44030402004298">粤公网安备：44030402004298号</a> <a target="_blank" href="https://beian.miit.gov.cn/#/Integrated/index">ICP证：粤ICP备2020113587号</a> </p>增值电信业务经营许可证编号：粤B2-20211158</p>
            
        <p class="copyright_p">
            <a href="http://1xiaoka.com/sitemap.html">要销卡平台-提供充值卡回收|点卡回收</a>，
            <a href="http://1xiaoka.com/sitemap.html">充值卡兑换|点卡兑换，</a>
            <a href="http://1xiaoka.com/sitemap.html">充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台</a>
        </p>
    </div>
</footer>
<script type="text/javascript">
    
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
        pos();
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
            },'json')
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
    
</script>
</body>