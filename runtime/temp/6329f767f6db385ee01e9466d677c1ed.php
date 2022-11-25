<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/about/service.html";i:1614933362;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mheader.html";i:1614909815;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/header.html";i:1621324688;s:58:"/www/wwwroot/yaoxiaoka/application/pc/view/common/nav.html";i:1624612117;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mfooter.html";i:1620488383;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/footer.html";i:1632456108;}*/ ?>
<?php if($is_mobile==1): ?>
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
<div class="main_top">
    平台服务协议
    <a href="javascript:history.back(-1);" class="back"><img src="/public/wap/img/left_icon.png" alt=""></a>
    <a class="kf_right"><img src="/public/wap/img/kf_icon.png" alt=""></a>
</div>
<?php else: ?>
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
<link rel="stylesheet" type="text/css" href="/public/pc/css/news.css?v=2021"/>
<!--NAV-->
<link rel="stylesheet" type="text/css" href="/public/pc/css/base.css?v=20211" />
<style type="text/css">
    /*导航菜单*/
.navbar{ margin:0px; background-color:#1E9FFF; border: none; margin-top: 30px;}
#app_menudown{position: absolute; top:0px; right:0px; font-size: 16px;}
#app_menudown:hover{background-color: #1b2fecb5;}
/*大屏幕*/
@media screen and (min-width: 769px) {
      .logo{max-height: 80px; max-width:260px; margin-top: 7px;}
      .logo_box{margin: 0px; background-color: #f6f6f6; padding: 0px 10px; height: 90px;}
      .flash{margin-top: 90px;}
      .navbar{min-height: 90px;}
      .navbar-nav{float:right;}
      .navbar-nav > li > a {transition:background 0.4s; text-align: center;}
      .navbar-default .navbar-nav > li > a{padding-top: 35px; padding-bottom:35px;color: #fff;font-size:18px; font-weight: 300; font-family:'Roboto',Arial,Helvetica, sans-serif;}
      .navbar-default .navbar-nav > li > a:hover,
      .navbar-default .navbar-nav > li > a:focus,
      .navbar-default .navbar-nav > .active > a,
      .navbar-default .navbar-nav > .active > a:hover,
      .navbar-default .navbar-nav > .open > a,
      .navbar-default .navbar-nav > .open > a:hover,
      .navbar-default .navbar-nav > .open > a:focus {
          background-color: #1b2fecb5; color: #fff;}
      .navbar-default .navbar-nav-c > li > a{font-size:14px;font-family:'microsoft yahei';}

      .small-nav{min-height: 70px; background: #1E9FFF; margin-top: 0px;}
      .small-nav .navbar-nav > li > a{padding-top: 25px; padding-bottom:25px;}
      .small-nav img.logo{max-height: 60px; max-width:220px; }
       .small-nav p.logo_box{padding: 0px 10px; height: 70px;}
      .toflash{margin-top:0px;}
      .navbar-brand{display: none;}

      .nav_small{ background-color:#1E9FFF; padding: 15px 0px 15px 0px;   border-radius: 0px; border: none; box-shadow: none;}
      .nav_small > li{}
      .nav_small > li > a{line-height:20px; color: #ffffff; font-size: 12px;font-family: Arial}
      .nav_small > li > a:hover{color: #fff; background-color: #d8b571;}
      #app_menudown,#small_search{ display:none; }
      .index_left_nav,.footer_nav{display:none; }
}

@media screen and (min-width:768px) and (max-width:1024px) {
  .logo{max-width:150px; margin-top: 20px;}
  .small-nav img.logo{max-width:150px; margin-top: 10px;}
}

/*小屏幕*/
@media screen and (max-width: 768px) {
      .navbar{}
      .navbar-default .navbar-brand {color: #fff;}
      .navbar-default .navbar-brand:hover,
      .navbar-default .navbar-brand:focus {color: #fff;}
      .navbar-toggle{border:none;}
      .navbar-default .navbar-collapse, .navbar-default .navbar-form{border:1px solid #1b2fecb5;}
      .navbar-default .navbar-toggle:hover,
      .navbar-default .navbar-toggle:focus {
        background-color: #1b2fecb5;
      }
      .navbar-default .navbar-toggle .icon-bar{background-color: #fff;}
      .navbar-default .navbar-nav{margin-top: 0px;margin-bottom: 0px;}
      .navbar-default .navbar-nav > li {}
      .navbar-default .navbar-nav > li:last-child{border: none;}
      .navbar-default .navbar-nav > li > a,
      .navbar-default .navbar-nav .open .dropdown-menu > li > a{color: #fff;font-family:Arial,Helvetica, sans-serif; font-size: 13px;}
      .navbar-default .navbar-nav > li > a:hover,
       .navbar-default .navbar-nav > li > a:focus,
       .navbar-default .navbar-nav > .active > a, 
       .navbar-default .navbar-nav > .active > a:hover, 
       .navbar-default .navbar-nav > .active > a:focus,
       .navbar-default .navbar-nav > .open > a, 
       .navbar-default .navbar-nav > .open > a:hover, 
       .navbar-default .navbar-nav > .open > a:focus,
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover{
        background-color: #1b2fecb5; color: #fff;}

      .flash{margin-top: 50px;}
      .top_name{display: none;}
      .logo{margin:0px 0px 0px 0px; max-width:150px; max-height: 50px;}
      .logo_box{margin: 0px 0px 0px 15px; padding:0px 5px; background-color: #f6f6f6; max-width:160px;  height: 50px;}
      .small-nav{margin-top: 0px;}
      .list_box{margin:5px 0px 0px 0px; }
      .flash div.bx-pager{ /*display:none;*/}
      .left_h1{margin-top: 10px;}
      #product div.flash,#product h2.left_h1,#photo div.flash,#photo h2.left_h1{display: none;}
      #product div.list_box,#photo div.list_box{margin-top:45px;}
      .index_left_nav{margin:0px 15px 0px 15px;}
      .product_con img,.contents img{width:100%;}
      .news_time{ display:none;}
      .footer_nav{background-color: #fafafa;}
      #pic-page a img {width:35px;}
      #cmsFloatPanel{ display: none;}
      .point span.to_prev,.point span.to_next{text-align:left; padding-bottom: 8px;}
      footer{ margin-bottom:50px;}
}

@media screen and (max-width: 767px) {
     .copyright_p{ display:none;}
}


@media screen and (min-width:480px) and (max-width:768px) {
  .col-mm-1, .col-mm-2, .col-mm-3, .col-mm-4, .col-mm-5, .col-mm-6, .col-mm-7, .col-mm-8, .col-mm-9, .col-mm-10, .col-mm-11, .col-mm-12 {
    float: left;
  }
  .col-mm-12 {
    width: 100%;
  }
  .col-mm-11 {
    width: 91.66666667%;
  }
  .col-mm-10 {
    width: 83.33333333%;
  }
  .col-mm-9 {
    width: 75%;
  }
  .col-mm-8 {
    width: 66.66666667%;
  }
  .col-mm-7 {
    width: 58.33333333%;
  }
  .col-mm-6 {
    width: 50%;
  }
  .col-mm-5 {
    width: 41.66666667%;
  }
  .col-mm-4 {
    width: 33.33333333%;
  }
  .col-mm-3 {
    width: 25%;
  }
  .col-mm-2 {
    width: 16.66666667%;
  }
  .col-mm-1 {
    width: 8.33333333%;
  }
}

@media screen and (max-width: 240px) {
  .logo{max-width:120px; margin: 5px;}
  .logo_box{padding:0px 5px; max-width:130px;  height: 50px;}
}.navbar-fixed-top,
.navbar-fixed-bottom {
  position: fixed;
  right: 0;
  left: 0;
  z-index: 1030;
}
@media (min-width: 769px) {
  .navbar-fixed-top,
  .navbar-fixed-bottom {
    border-radius: 0;
  }
}
.navbar-fixed-top {
  top: 0;
  border-width: 0 0 1px;
}
.navbar-fixed-bottom {
  bottom: 0;
  margin-bottom: 0;
  border-width: 1px 0 0;
}
.navbar-brand {
  float: left;
  height: 50px;
  padding: 15px 15px;
  font-size: 18px;
  line-height: 20px;
}
.navbar-brand:hover,
.navbar-brand:focus {
  text-decoration: none;
}
.navbar-brand > img {
  display: block;
}
@media (min-width: 769px) {
  .navbar > .container .navbar-brand,
  .navbar > .container-fluid .navbar-brand {
    margin-left: -15px;
  }
}
.navbar-toggle {
  position: relative;
  float: right;
  padding: 9px 10px;
  margin-top: 8px;
  margin-right: 15px;
  margin-bottom: 8px;
  background-color: transparent;
  background-image: none;
  border: 1px solid transparent;
  border-radius: 4px;
}
.navbar-toggle:focus {
  outline: 0;
}
.navbar-toggle .icon-bar {
  display: block;
  width: 22px;
  height: 2px;
  border-radius: 1px;
}
.navbar-toggle .icon-bar + .icon-bar {
  margin-top: 4px;
}
@media (min-width: 769px) {
  .navbar-toggle {
    display: none;
  }
}
.navbar-nav {
  margin: 7.5px -15px;
}
.navbar-nav > li > a {
  padding-top: 10px;
  padding-bottom: 10px;
  line-height: 20px;
}
@media (max-width: 768px) {
  .navbar-nav .open .dropdown-menu {
    position: static;
    float: none;
    width: auto;
    margin-top: 0;
    background-color: transparent;
    border: 0;
    -webkit-box-shadow: none;
            box-shadow: none;
  }
  .navbar-nav .open .dropdown-menu > li > a,
  .navbar-nav .open .dropdown-menu .dropdown-header {
    padding: 5px 15px 5px 25px;
  }
  .navbar-nav .open .dropdown-menu > li > a {
    line-height: 20px;
  }
  .navbar-nav .open .dropdown-menu > li > a:hover,
  .navbar-nav .open .dropdown-menu > li > a:focus {
    background-image: none;
  }
}
@media (min-width: 769px) {
  .navbar-nav {
    float: left;
    margin: 0;
  }
  .navbar-nav > li {
    float: left;
  }
  .navbar-nav > li > a {
    padding-top: 15px;
    padding-bottom: 15px;
  }
}
.navbar-form {
  padding: 10px 15px;
  margin-top: 8px;
  margin-right: -15px;
  margin-bottom: 8px;
  margin-left: -15px;
  border-top: 1px solid transparent;
  border-bottom: 1px solid transparent;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1), 0 1px 0 rgba(255, 255, 255, .1);
          box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1), 0 1px 0 rgba(255, 255, 255, .1);
}
@media (min-width: 769px) {
  .navbar-form .form-group {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
  }
  .navbar-form .form-control {
    display: inline-block;
    width: auto;
    vertical-align: middle;
  }
  .navbar-form .form-control-static {
    display: inline-block;
  }
  .navbar-form .input-group {
    display: inline-table;
    vertical-align: middle;
  }
  .navbar-form .input-group .input-group-addon,
  .navbar-form .input-group .input-group-btn,
  .navbar-form .input-group .form-control {
    width: auto;
  }
  .navbar-form .input-group > .form-control {
    width: 100%;
  }
  .navbar-form .control-label {
    margin-bottom: 0;
    vertical-align: middle;
  }
  .navbar-form .radio,
  .navbar-form .checkbox {
    display: inline-block;
    margin-top: 0;
    margin-bottom: 0;
    vertical-align: middle;
  }
  .navbar-form .radio label,
  .navbar-form .checkbox label {
    padding-left: 0;
  }
  .navbar-form .radio input[type="radio"],
  .navbar-form .checkbox input[type="checkbox"] {
    position: relative;
    margin-left: 0;
  }
  .navbar-form .has-feedback .form-control-feedback {
    top: 0;
  }
}
@media (max-width: 767px) {
  .navbar-form .form-group {
    margin-bottom: 5px;
  }
  .navbar-form .form-group:last-child {
    margin-bottom: 0;
  }
}
@media (min-width: 769px) {
  .navbar-form {
    width: auto;
    padding-top: 0;
    padding-bottom: 0;
    margin-right: 0;
    margin-left: 0;
    border: 0;
    -webkit-box-shadow: none;
            box-shadow: none;
  }
}
.navbar-nav > li > .dropdown-menu {
  margin-top: 0;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.navbar-fixed-bottom .navbar-nav > li > .dropdown-menu {
  margin-bottom: 0;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.navbar-btn {
  margin-top: 8px;
  margin-bottom: 8px;
}
.navbar-btn.btn-sm {
  margin-top: 10px;
  margin-bottom: 10px;
}
.navbar-btn.btn-xs {
  margin-top: 14px;
  margin-bottom: 14px;
}
.navbar-text {
  margin-top: 15px;
  margin-bottom: 15px;
}.nav {
  padding-left: 0;
  margin-bottom: 0;
  list-style: none;
}
.nav > li {
  position: relative;
  display: block;
}
.nav > li > a {
  position: relative;
  display: block;
  padding: 10px 15px;
}
.nav > li > a:hover,
.nav > li > a:focus {
  text-decoration: none;
  background-color: #eee;
}
.nav > li.disabled > a {
  color: #777;
}
.nav > li.disabled > a:hover,
.nav > li.disabled > a:focus {
  color: #777;
  text-decoration: none;
  cursor: not-allowed;
  background-color: transparent;
}
.nav .open > a,
.nav .open > a:hover,
.nav .open > a:focus {
  background-color: #eee;
  border-color: #337ab7;
}
.nav .nav-divider {
  height: 1px;
  margin: 9px 0;
  overflow: hidden;
  background-color: #e5e5e5;
}
.nav > li > a > img {
  max-width: none;
}
.nav-tabs {
  border-bottom: 1px solid #ddd;
}
.nav-tabs > li {
  float: left;
  margin-bottom: -1px;
}
.nav-tabs > li > a {
  margin-right: 2px;
  line-height: 1.42857143;
  border: 1px solid transparent;
  border-radius: 4px 4px 0 0;
}
.nav-tabs > li > a:hover {
  border-color: #eee #eee #ddd;
}
.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
  color: #555;
  cursor: default;
  background-color: #fff;
  border: 1px solid #ddd;
  border-bottom-color: transparent;
}
.nav-tabs.nav-justified {
  width: 100%;
  border-bottom: 0;
}
.nav-tabs.nav-justified > li {
  float: none;
}
.nav-tabs.nav-justified > li > a {
  margin-bottom: 5px;
  text-align: center;
}
.nav-tabs.nav-justified > .dropdown .dropdown-menu {
  top: auto;
  left: auto;
}
@media (min-width: 769px) {
  .nav-tabs.nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .nav-tabs.nav-justified > li > a {
    margin-bottom: 0;
  }
}
.nav-tabs.nav-justified > li > a {
  margin-right: 0;
  border-radius: 4px;
}
.nav-tabs.nav-justified > .active > a,
.nav-tabs.nav-justified > .active > a:hover,
.nav-tabs.nav-justified > .active > a:focus {
  border: 1px solid #ddd;
}
@media (min-width: 769px) {
  .nav-tabs.nav-justified > li > a {
    border-bottom: 1px solid #ddd;
    border-radius: 4px 4px 0 0;
  }
  .nav-tabs.nav-justified > .active > a,
  .nav-tabs.nav-justified > .active > a:hover,
  .nav-tabs.nav-justified > .active > a:focus {
    border-bottom-color: #fff;
  }
}
.nav-pills > li {
  float: left;
}
.nav-pills > li > a {
  border-radius: 4px;
}
.nav-pills > li + li {
  margin-left: 2px;
}
.nav-pills > li.active > a,
.nav-pills > li.active > a:hover,
.nav-pills > li.active > a:focus {
  color: #fff;
  background-color: #337ab7;
}
.nav-stacked > li {
  float: none;
}
.nav-stacked > li + li {
  margin-top: 2px;
  margin-left: 0;
}
.nav-justified {
  width: 100%;
}
.nav-justified > li {
  float: none;
}
.nav-justified > li > a {
  margin-bottom: 5px;
  text-align: center;
}
.nav-justified > .dropdown .dropdown-menu {
  top: auto;
  left: auto;
}
@media (min-width: 769px) {
  .nav-justified > li {
    display: table-cell;
    width: 1%;
  }
  .nav-justified > li > a {
    margin-bottom: 0;
  }
}
.nav-tabs-justified {
  border-bottom: 0;
}
.nav-tabs-justified > li > a {
  margin-right: 0;
  border-radius: 4px;
}
.nav-tabs-justified > .active > a,
.nav-tabs-justified > .active > a:hover,
.nav-tabs-justified > .active > a:focus {
  border: 1px solid #ddd;
}
@media (min-width: 769px) {
  .nav-tabs-justified > li > a {
    border-bottom: 1px solid #ddd;
    border-radius: 4px 4px 0 0;
  }
  .nav-tabs-justified > .active > a,
  .nav-tabs-justified > .active > a:hover,
  .nav-tabs-justified > .active > a:focus {
    border-bottom-color: #fff;
  }
}
.tab-content > .tab-pane {
  display: none;
}
.tab-content > .active {
  display: block;
}
.nav-tabs .dropdown-menu {
  margin-top: -1px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.navbar {
  position: relative;
  min-height: 50px;
  margin-bottom: 20px;
  border: 1px solid transparent;
}
@media (min-width: 769px) {
  .navbar {
    border-radius: 4px;
  }
}
@media (min-width: 769px) {
  .navbar-header {
    float: left;
  }
}
.navbar-collapse {
  padding-right: 15px;
  padding-left: 15px;
  overflow-x: visible;
  -webkit-overflow-scrolling: touch;
  border-top: 1px solid transparent;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
          box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
}
.navbar-collapse.in {
  overflow-y: auto;
}
@media (min-width: 769px) {
  .navbar-collapse {
    width: auto;
    border-top: 0;
    -webkit-box-shadow: none;
            box-shadow: none;
  }
  .navbar-collapse.collapse {
    display: block !important;
    height: auto !important;
    padding-bottom: 0;
    overflow: visible !important;
  }
  .navbar-collapse.in {
    overflow-y: visible;
  }
  .navbar-fixed-top .navbar-collapse,
  .navbar-static-top .navbar-collapse,
  .navbar-fixed-bottom .navbar-collapse {
    padding-right: 0;
    padding-left: 0;
  }
}
.navbar-fixed-top .navbar-collapse,
.navbar-fixed-bottom .navbar-collapse {
  max-height: 340px;
}
@media (max-device-width: 480px) and (orientation: landscape) {
  .navbar-fixed-top .navbar-collapse,
  .navbar-fixed-bottom .navbar-collapse {
    max-height: 200px;
  }
}
.container > .navbar-header,
.container-fluid > .navbar-header,
.container > .navbar-collapse,
.container-fluid > .navbar-collapse {
  margin-right: -15px;
  margin-left: -15px;
}
@media (min-width: 769px) {
  .container > .navbar-header,
  .container-fluid > .navbar-header,
  .container > .navbar-collapse,
  .container-fluid > .navbar-collapse {
    margin-right: 0;
    margin-left: 0;
  }
}
.navbar-static-top {
  z-index: 1000;
  border-width: 0 0 1px;
}
@media (min-width: 769px) {
  .navbar-static-top {
    border-radius: 0;
  }
}
.navbar-fixed-top,
.navbar-fixed-bottom {
  position: fixed;
  right: 0;
  left: 0;
  z-index: 1030;
}
@media (min-width: 769px) {
  .navbar-fixed-top,
  .navbar-fixed-bottom {
    border-radius: 0;
  }
}@media screen and (min-width:768px) and (max-width:1024px) {
  .logo{max-width:150px; margin-top: 20px;}
  .small-nav img.logo{max-width:150px;margin-top: 10px;}
}
@media screen and (min-width: 769px){
.navbar-nav {
    float: right;
}
@media (min-width: 769px) {
  .container {
    width: 750px;
  }
}
@media (min-width: 992px) {
  .container {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  .container {
    width: 1170px;
  }
}
</style>
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top small-nav" style="margin-top:0px;">
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
                    <li>
                        <a href="/pc/help/card_rate_query">平台费率</a>
                    </li>
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

<script type="text/javascript" charset="utf-8">
    function card_rate_query() {
        layer.open({
            type: 2,
            title:'平台费率',
            shadeClose: true,
            area: ['90%', '90%'],
            shade: 0.8,
            content: '/pc/help/card_rate_query',
        });
    }
    
</script>
<!--<div style="height: 180px;"></div>-->
<?php endif; ?>
<div class="container" style="padding: 15px">
    <div class="news_con">
        <div class="news_con_head">
            <h1>要销卡平台服务协议</h1>
        </div>
        <p class="news_con_main">
            <b>提示条款</b>
            <br>欢迎您与本平台经营者（详见本协议第一款）共同签署本《要销卡平台服务协议》（下称“本协议”）并使用本平台服务！
            <br>各服务条款前所列索引关键词仅为帮助您理解该条款表达的主旨之用，不影响或限制本协议条款的含义或解释。为维护您自身权益，建议您仔细阅读各条款具体表述。
            <br><br>
            <b>【审慎阅读】</b>要销卡平台在此特别提醒用户，您在申请注册流程中点击同意本协议之前，应当认真阅读本协议。请您务必审慎阅读、充分理解各条款内容，特别是免除或者限制本平台经营者责任的免责条款及对用户的权利限制条款。请您审慎阅读并选择接受或不接受本协议(未成年人应在法定监护人陪同下阅读）。免除或者限制责任的条款将以粗体下划线标识，您应重点阅读。如您对协议有任何疑问，可向本平台客服咨询。
            <br><b>【签约动作】</b>当您按照注册页面提示填写信息、阅读并同意本协议且完成全部注册程序后，即表示您已充分阅读、理解并接受本协议的全部内容，并与本平台达成一致，成为本平台“用户”。阅读本协议的过程中，除非您接受本协议所有条款，否则您无权注册、登录或使用本站所提供的相关服务。您的注册、登录、使用等行为将视为对本协议的接受，并同意接受本协议各项条款的约束。
            <br><br>

            <b>一、定义</b>
            <br><b>本平台：</b>或称“本站”，指包括要销卡的网站及客户端；
            <br><b>要销卡平台：</b>指本平台经营者深圳宏信智联科技有限公司的简称；
            <br><b>用户：</b>或称“您”，指注册、登录、使用、浏览本平台服务的个人或组织；
            <br><b>本协议：</b>指《要销卡平台服务协议》的简称；
            <br><b>礼品卡：</b>本协议所称礼品卡，是指包含但不仅限于电子商务卡、商城超市卡、游戏充值卡、话费充值卡、旅游预付卡、石油预付充值卡等业务运营商发行的具有一定面值、可用于购买商品或服务的实体卡或虚拟卡；
            <br><b>礼品卡转让：</b>本协议所称礼品卡转让，是指本平台提供的礼品卡转让服务。用户可将其持有的礼品卡，转让给本平台或本平台合作商户，转让所得的金额将直接转入用户在要销卡的账户余额中。具体支持的礼品卡卡种以用户使用本服务时的页面提示为准。
            <br><br>

            <b>二、本站服务条款的确认和接纳</b>
            <br>1. 您应当认真阅读本协议，对于协议中粗体加下划线字的内容和涉及重要权益的内容，您应当加以重点阅读。 如果您对本协议中的某一或某些条款产生疑问，您应当向本平台客服咨询。如果您不同意本协议中的某一或某些条款，您应当立即停止注册或停止使用本站所提供的服务；
            <br>2. 本协议为电子形式的协议，是处理您与本站一切权利义务关系的约定，对双方均具有法律约束力；
            <br>3. 由于互联网高速发展，您与本平台签署的本协议列明的条款并不能完整罗列并覆盖您与本平台所有权利与义务，现有的约定也不能保证完全符合未来发展的需求。<b>因此，本平台网站上已经发布的或将来可能发布或更新的各类规则，是本协议不可分割的组成部分，与本协议正文具有同等法律效力。因此，当您完全接受本协议时，当然且确定的表明您也完全接受本协议的全部条款；</b>
            <br>4. 本平台有权根据需要不时地制订、修改本协议及/或各类规则，并以网站公示的方式进行公告，不再单独通知您。修订后的协议或将来可能发布或更新的各类规则一经在网站公布后，立即自动生效。<b>如您不同意相关修订，应当立即停止使用本站服务。您继续使用本站服务，即表示您接受经修订的协议或规则。</b>
            <br><br>

            <b>三、用户使用规则</b>
            <br>1. 您无需注册账户即可浏览本网站。但某些网站功能和服务需要您注册本站帐户。如果您想使用本站服务的更多功能，<b>您必须注册相应帐户并按本平台要求及相关法律法规规定完成实名认证。在实名页面上提供真实有效的个人信息，并签署《要销卡用户承诺书》。</b>您可以按照网站说明随时终止使用您的账户，本站将会依据本协议规定保留或终止您的账户。<b>您必须承诺和保证：</b>
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.1、未成年人除非在法定监护人的陪同下了解并同意本协议方可注册，否则我们有权立即停止提供服务，您独自承担由此而产生的一切损失及法律责任；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.2、您了解并理解，注册本站的用户必须是具有完全民事行为能力的自然人，无民事行为能力、限制民事行为能力人不得注册为网站用户或超过其民事权利或行为能力范围在本站进行交易，如否，本站有权采取取消订单、冻结或关闭账户、拒绝提供服务等措施，给本站及相关方造成损失的，用户还应承担全部责任；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.3、您了解并同意，用户须对注册信息的真实性、合法性、有效性承担全部责任；用户不得冒充他人，不得利用他人的名义进行注册、交易等相关操作；不得恶意使用注册帐户导致其他用户误认；否则本平台有权立即停止提供服务，您独自承担由此而产生的一切法律责任；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.4、您应该根据本站系统的要求填写必要的注册信息和账户信息，并保证信息的合法性、真实性、及时性和有效性。注册成功后，如果您所填写的信息发生改变，您应当及时登录本站变更相关内容；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.5、您使用本站与及服务的行为必须合法，您必须为自己注册帐户下的一切行为负责，包括您所提交的任何礼品卡券以及由此产生的任何结果。用户应对其中的礼品卡券自行加以判断，并承担因提供的礼品卡券交易服务而引起的所有风险，包括因对礼品卡券正确性、完整性或合法性的依赖而产生的风险。本平台无法且不会对因用户行为而导致的任何损失或损害承担责任；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.6、您对您的登录信息保密、不被其他人获取并使用并且对您在本站账户下的所有行为负责。您必须将任何有可能触犯法律的，未授权使用或怀疑为未授权使用的行为在第一时间通知本站，本站不对您因未能遵守上述要求而造成的损失承担责任；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.1.7、您不得将在本站注册获得的账户借给他人使用，否则您应承担由此产生的全部责任，并与实际使用人承担连带责任。如果您是在监护人参与下完成用户注册的不具备完全民事权利能力或完全民事行为能力的自然人，您及您的监护人同意为在该用户名下所发生的一切行为负责。
            <br><b>2. 您必须知悉并确认：</b>
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2.1、本站因业务发展需要，拥有单方面对本服务的全部或部分服务内容在任何时候不经任何通知的情况下变更、暂停、限制、终止或撤销我们服务的权利，用户需承担此风险；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2.2、本站有权自行全权决定以任何理由，对违反有关法律法规或本协议约定；或侵犯、妨害、威胁任何人权利或安全的内容，或者假冒他人的行为，有权依法停止传输任何相关内容，并有权依其自行判断对违反本协议的任何用户采取适当的法律行动，包括但不限于，从服务中删除具有违法性、侵权性、不当性等内容，终止违反者的成员资格，阻止其使用我们全部或部分服务，并且依据法律法规保存有关信息并向有关部门报告等；
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.2.3、您了解隐私政策。在任何时候，您的信息均依照要销卡平台的《<a href="/about/privacy">隐私政策</a>》处理，该政策通过提述而纳入本许可证内。<br><br>

            <b>四、商品信息</b>
            <br>  1. 本站网站上所发布的一切商品信息，包括但不限于图片、视频、文字说明，均供您决定是否回收礼品卡券，一旦您在决定回收礼品卡券后通过网站系统提交订单，即表明您向要销卡平台发出了明确的出售该礼品卡券的意图；
            <br>  2. 本站上的商品回收价格、数量、是否回收等商品信息随时都有可能发生变动，本站不作特别通知。由于网站上商品信息的数量极其庞大，虽然本站会尽最大努力保证您所浏览商品信息的准确性，但由于众所周知的互联网技术因素等客观原因存在，本站网页显示的信息可能会有一定的滞后性或差错，对此情形您知悉并理解；
            <br>  3. 当您通过本站系统提交订单后，商品信息发生变化的，您不得以变更后的商品信息主张权利或要求要销卡平台承担责任；
            <br>  4. 因本平台系统或互联网技术性问题导致商品信息发生错误的，要销卡平台有权视情况取消订单或作其它处理；
            <br>  5. <b>本站可以根据市场变化、市场竞争及国家政策的规定需要不时的变更回收价格。如果价格变更发生在您提交订单之前，您所提交的商品的价格以变更后的价格为准。如果您提交订单后发生了价格变更，您所提交的商品的价格以您提交订单时的价格为准。</b>
            <br><br>

            <b>五、订单服务</b>
            <br>  1. 如果您使用本站相关服务，请务必依据系统程序填写并提交订单。当您提交订单后，网站系统将自动向您账户信息中进行确认。无论您所收到确认信息如何描述，该确认信息仅表示本站已经收到您的订单要约；
            <br>  2. <b>要销卡平台特别提醒您，请在提供的礼品卡券交易服务卡号与卡密之前，务必认真了解《要销卡礼品卡转让协议》。在订单提交成功之后，您不得以不了解《要销卡礼品卡转让协议》的相关信息而主张撤销订单；</b>
            <br>  3. 当您使用本平台提供的礼品卡券交易服务或相关服务时，请务必依据本协议及系统程序进行操作。您不得以不了解本协议及系统程序为由主张订单无效或可撤销；
            <br>  4. 本站收到您的订单后，将会及时审核订单。<b>您必须承诺所提交的礼品卡券是合法的、完整的，保证所提供的身份信息真实完整，无侵犯他人权益的行为，愿意接受监管部门的监管，并承担相应法律责任；</b>如本站对用户提交的礼品卡的合法性存在疑义，本平台有权向用户通过包括但不限于在线聊天软件，电话、邮件等方式进行卡密来源合法性的核实，您必须配合提供相关证明以证明卡密来源的合法性；
            <br>  5. 经本平台审核无误，本平台将安排打款。如果本站认为订单存在疑问（如：您提交的礼品卡券错误、非法等），本站均有权取消订单，并有权视实际情况决定是否通过在线聊天软件、邮件、电话等沟通渠道通知您；
            <br>  6. 本站根据本协议的规定拒绝、取消或不接受订单的，您同意自行承担一切责任，但是有特别规定的除外；
            <br>  7. 本站的受理礼品卡券时效和打款时效均为一般处理时间，该时间仅作为您提供的礼品卡券交易服务的参考因素。
            <br><br>
            <b>六、用户消费卡、电子卡、预付卡交易服务协议</b>
            <br>  如您需要使用本平台所提供的礼品卡券交易服务，您需遵守以下内容：
            <span class="focus_txt"><br>  1. 本站工作人员不会向您索取任何礼品卡券资料，如果您泄露任何关于礼品卡券的信息，本站概不负责也不承担任何法律责任；
            <br>  2. 礼品卡券交易过程中，您因自身原因使礼品卡被盗取或封存导致不能成功回收的责任由您全部承担；
            <br>  3. 礼品卡券交易过程中，您若有重复提交同一卡号或故意提交错误信息的，我们会取消交易，并有权冻结用户账户信息或停止向您提供全部或部分服务；
            <br>  4. 礼品卡券交易过程中，如果您私下将礼品卡券信息交易给除本站外的任何第三方，并再次出售给本站，如若出现，造成的损失由您全部承担，本站并有权冻结用户账户或停止向您提供全部或部分服务；
            </span>
            <br><br>
            <b>七、责任限制与不可抗力</b>
            <br>  1. 在法律法规所允许的限度内，因使用本站服务而引起的任何损害或经济损失，本站承担的全部责任均不超过就用户所提交的礼品卡券与该索赔有关的礼品卡券所实际获得的直接收益。这些责任限制条款将在法律所允许的最大限度内适用，并在用户账户被注销后仍继续有效；
            <br>  2. 本站仅限在“按现状”和“按现有”的基础上，向用户提供全部的信息、内容、材料、产品（包括软件）和服务。除非另有明确的书面说明，本站不对其包含在网站上的信息、内容、材料、产品（包括软件）或服务作任何形式的、明示或默示的担保；
            <br>  3. 本站不希望出现任何因交易而与用户之间产生纠纷，但并不保证可杜绝该类纠纷的发生。对于因前述各类情形而产生的任何纠纷（如用户所持卡为非法或被盗、泄露等），将由交易双方通过合理、合法的方式自行解决，对于因此类交易而产生的各类纠纷之任何责任和后果，由用户承担，本站不承担任何责任及后果。<b>如果任何单位或者个人通过上述“信息”而进行任何交易或者进行其他行为，须得知网络交易、网上行为的风险性，进行交易或行为的事前应辨别和采取谨慎的预防措施，本站对任何损失或任何由于使用本站而引起的损失，包括但不限于直接的，间接的，偶然的、惩罚性的而引发的损失，不承担责任；</b>
            <br>  4. 本站审核只是针对用户提供信息进行审核，特别是虚拟商品来源我们无法审核，自回收完毕并打款给用户后，即已完成<b>（如若遇到盗刷卡、来历不明卡等任何非法形式获得的卡类，本站有权冻结该账户并将用户信息提交给相关部门。）</b>本站不对商品来源负责，亦不承担任何法律责任；
            <br>  5. 不论在任何情况下，本站均不对由于互联网设备正常维护，互联网络连接故障，电脑、通讯或其他系统的故障，电力故障，罢工，暴乱，骚乱，灾难性天气（如火灾、洪水、风暴等），爆炸，战争，政府行为，司法行政机关的命令或第三方的不作为而造成的不能履行或延迟履行承担责任。

            <br><br>
            <b>八、协议终止</b>
            <br>  1. 本站有权经通知后终止本协议，您有权请求本站作出终止本协议的决定；
            <br>  2. 发生下列情形之一的，本平台有权立即终止协议并关停您的账户：
            <span class="focus_txt">
            <br>  本协议发生变更后，您明确通知本站不愿意接受新协议或变更内容的；
            <br>  本站发现您恶意注册账户，扰乱正常经营秩序的；
            <br>  本站发现您多次恶意提交礼品卡券，扰乱正常经营秩序的；
            <br>  您注册账户后，连续12个月不使用该账户的；
            <br>  您通过本网站进行违法犯罪活动的；
            <br>  触发本平台风控机制并无法提供相关证明的；
            <br>  其他本平台认为账户使用者的行为有可能违反本协议或相关法律法规并无法提供相关证明的；
            </span>
            <br>  3. 协议终止后，您在本站上的积分、账户余额均失效，本站不予兑现；
            <br>  4. 协议终止后，您同意本站在2年内继续保留您的注册信息、账户信息以及交易记录；
            <br>  5. 协议终止后，本站有权向他人开放您所注册使用的用户名；
            <br>  6. 如果您在协议终止之前存在违反本协议的行为，本站有权依据本协议追究您的法律责任。
            <br><br>
            <b>九、账户注销</b>
            <br>  我们在此善意地提醒您，您注销账户的行为会给您的权益带来诸多不便，且注销要销卡账户后，您的个人信息我们只会在要销卡的前台系统中去除，使其保持不可被检索、访问的状态，或对其进行匿名化处理。
            <br>  您知晓并理解，根据相关法律规定相关交易记录须在要销卡系统中保存5年甚至更长的时间。
            <br>  如果您仍执意注销账户，您的账户需同时满足以下条件：
            <span class="focus_txt">
            <br>  1、账号当前为有效状态；
            <br>  2、账户内无任何订单记录，包括回收点卡产生的成功/失败订单记录、账户提现的流水记录；
            <br>  3、账户无任何纠纷（包括投诉举报或被投诉举报）；
            </span>
            <br>  特别提醒：
            <span class="focus_txt">
            <br>  1、账户无法同时满足上述要求，则表示不符合注销条件，账户将无法注销。
            <br>  2、注销操作需账户本人亲自联系要销卡客服申请处理
            </span>
            <br>  账户一旦被注销将不可恢复，请您在操作之前自行备份要销卡账户相关的所有信息和数据。请您保存好账户内的订单，信息等资料，因客户的账户申请注销对客户造成的不利影响，要销卡将不承担任何责任。
            <br><br>

            <b>十、适用的法律和管辖权</b>
            <br>  1. 本协议的签订、履行和执行及解释均适用中华人民共和国法律法规。如果中华人民共和国法律法规没有相关规定，则适用中华人民共和国的商业惯例；
            <br>  2. 如果本协议的相关规定违反中华人民共和国法律法规的相应条款，则适用中华人民共和国法律法规。如果本协议的相关规定违反中华人民共和国的相关商业惯例，则仍然以本协议为准。
            <br>  3. 因本协议发生的任何争议，本站与您应当友好协商，协商不成的，任何一方均有权向深圳宏信智联技术有限公司所在地有管辖权的人民法院起诉，其它任何法院均不具有管辖权。
            <br><br>
            <b>十一、其他</b>
            <br>1. 反馈
            <br>
            您对本站提出建议（或称“反馈”），即视为您向本站转让“反馈”的全部权利并同意本站有权利以任何合理方式使用此反馈及其相关信息。我们将视此类反馈信息为非保密且非专有；
            <br>
            您已同意您不会向本站提供任何您视为保密和专有的信息；
            <br>
            我们将保留基于我们的判断检查用户内容的权利（而非义务）。无论通知与否，我们有权在任何时间以任何理由删除或移动您的用户内容。依据第8条规定，我们有权保留或终止您的账户。
            <br>
            2. 隐私政策
            <br>
            请查阅我们的《隐私政策》，《隐私政策》为与本协议效力等同且不可分割的一部分。
            <br>
            3. 礼品卡转让协议
            <br>
            请查阅我们的《礼品卡转让协议》，《礼品卡转让协议》为与本协议效力等同且不可分割的一部分。
            <br>
            4. 通知
            <br>
            您必须提供您最近经常使用的有效的电子邮件地址。您所提供的电子邮件地址无法使用或者因任何原因我们无法将通知送达给您而产生的风险，本站不承担责任。本站发布的公告通知及向您所发送的包含此类通知的电子邮件毫无疑问构成有效通知。
            <br>
            5. 独立性
            <br>
            若本协议中的某些条款因故无法适用，则本协议的其他条款继续适用且无法适用的条款将会被修改，以便其能够依法适用。
            <br>
            6. 完整性
            <br>
            本协议（包括隐私政策）是您和要销卡平台之间关于本站及服务相关事项的最终的、完整的、排他的协议，且取代和合并之前当事人关于此类事项（包括之前的礼品卡转让协议、礼品卡回收说明）的讨论和协议；
            <br>
            每部分的题目只为阅读之便而无任何法律或合同义务；
            <br>
            除非本站书面同意，您不得转让本协议所规定的权利义务。任何违反上述规定企图转让的行为均无效。
        </p>
    </div>
    <?php if($is_mobile!=1): ?>
    <div class="news_right">
        <div class="service_list">
            <a href="/about/service" class="active" target="_blank" rel=“nofollow”>服务协议</a>
            <a href="/about/protocol" target="_blank" rel=“nofollow”>转让协议</a>
            <a href="/about/ze" target="_blank" rel=“nofollow”>免责申明</a>
            <a href="/about/privacy" target="_blank" rel=“nofollow”>隐私政策</a>
            <div class="clear"></div>
        </div>
        <div class="line_mid"></div>
        <div class="news_right_ewm">
            <h3>关注要销卡</h3>
            <img src="/public/pc/picture/qrcode1.jpg" class="ewm" alt="要销卡二维码">
            <p>扫描上方二维码<br>掌握要销卡最新活动</p>
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php if($is_mobile==1): ?>
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

<?php else: ?>
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
<?php endif; ?>