<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/about/privacy.html";i:1614933319;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mheader.html";i:1614909815;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/header.html";i:1621324688;s:58:"/www/wwwroot/yaoxiaoka/application/pc/view/common/nav.html";i:1624612117;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mfooter.html";i:1620488383;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/footer.html";i:1632456108;}*/ ?>
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
    个人信息及隐私保护政策
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
            <h1>要销卡的用户个人信息及隐私保护政策</h1>
        </div>
        <p class="news_con_main">

            重要须知：深圳宏信智联科技有限公司旗下的要销卡二手卡回收平台（下称“要销卡”）一贯重视用户的个人信息及隐私的保护，在您使用要销卡的服务时，要销卡有可能会收集和使用您的个人信息。为此，要销卡通过本《要销卡用户个人信息及隐私保护政策》（以下简称“本《隐私政策》”）向您说明您在使用要销卡的服务时，要销卡是如何收集、存储、使用和分享这些信息的，以及要销卡向您提供的访问、更新、控制和保护这些信息的方式。<br>
            <span style="text-decoration:underline"><b>本《隐私政策》与您使用要销卡的服务息息相关，请您务必仔细阅读、充分理解</b></span>（未成年人应当在其监护人的陪同下阅读）。
            <br>
            您如果使用或者继续使用要销卡的服务，即视为您充分理解并完全接受本《隐私政策》；您如果对本《隐私政策》有任何疑问、异议或者不能完全接受本《隐私政策》。<br>

            <br><br><b>第一条：</b>本《隐私政策》所述的个人信息类型包括：
            1. 注册信息（如，用户名、及在注册过程中提供的其他信息等）；<br>
            2. 个人联系方式（如，姓名、通讯地址、电邮地址、电话、手机号码）；<br>
            3. 订单信息（如，收货人名称、货货地址、电邮地址和电话号码等与订单相关的任何信息； 在交付文件上的签名；网站帐户及帐户信息；为帮助我们提供服务（包括特定服务）而提供给我们的信息）；<br>
            4. 用于您身份识别的信息（如，身份证号码、身份证证件照）；<br>
            5. 支付信息（如，订单支付详情）和财务信息（如，银行账号、支付宝）；<br>
            6. 其他个人、公司、单位、或社会实体信息。<br>
            7. 一般情况下，用户可以匿名访问要销卡网站查看相关的服务文档。当我们需要能识别您的个人信息或者可以与您联系的信息时，我们会征求您的同意。
            但在注册要销卡或申请要销卡某项服务时，我们可能会收集这些信息:手机号码、银行卡信息、身份信息、Email地址，并征求你的确认。<br>
            8. 同时，我们非常重视对未成年人个人信息的保护。我们不希望未成年人直接使用人要销卡平台网站提供的产品或服务，如果您是未成年人，请与您监护人一起或在监护人的监督下使用本网站的产品或服务。<br>

            <br><br><b>第二条：</b>您承诺并保证：您主动填写或者提供给要销卡的个人信息是真实的、准确的、完整的。而且，填写或者提供给要销卡后，如果发生了变更的，您会在第一时间内，通过原有的渠道或者要销卡提供的新的渠道进行更新，以确保要销卡所获得的您的这些个人信息是最新的、真实的、准确的和完整的；否则，要销卡无须承担由此给您造成的任何损失。

            <br><br><b>第三条：</b>
            您应当重视您的个人信息的保护，您如果发现您的个人信息已经被泄露或者存在被泄露的可能，且有可能会危及您注册获得的要销卡账户安全，或者给您造成其他的损失的，您务必在第一时间通知要销卡，以便要销卡采取相应的措施确保您的要销卡账户安全，防止损失的发生或者进一步扩大；否则，要销卡无须承担由此给您造成的任何损失（及扩大的损失）。
            <br><br><b>第四条：</b>
            您充分理解并完全接受：您在使用要销卡的服务时，要销卡遵循“合法、正当、必要”原则，有可能会收集您的如下信息（以下统称“用户信息”）：<br>
            1. 您在访问或使用本网站服务时提供的个人信息及行为数据（包括但不限于订单下达及取消数据、退货退款申请数据、账户余额、交易纠纷数据等）；<br>
            2. 您在与我们的沟通中自动获取的信息：无论您何时与我们沟通，我们接收并存储的信息；<br>
            3. 从其他来源获取的信息：如，您提供给第三方或者向第三方披露的个人信息及隐私；<br>
            4. 您所使用的台式计算机、移动设备的品牌、型号、IP地址、地理位置信息以及软件版本信息。<br>
            <br><br><b>第五条：</b>您具有如下用户权利：
            1.
            要销卡不定期通过邮件、短信、app推送等形式，对本网站用户发送订单信息、促销活动等信息，您在注册成为要销卡会员时，表示您已同意接受该类信息，如果您不想接收该类信息，您可以向要销卡客户服务提出退订申请，要销卡会在收到申请后为您办理退订。<br>
            2. 您通过具有定位功能的移动设备登录、使用要销卡的App时，有权决定要销卡是否通过GPS或者Wifi收集您的地理位置信息；您如果不同意收集，您在您的移动设备上关闭此项功能。<br>
            3.
            如您发现要销卡违反法律、行政法规的规定或者双方的约定收集、使用个人信息的，有权要求要销卡删除您的个人信息及注销账号；您可向要销卡客户服务提出申请，要销卡核实用户身份及信息后，在不违背法律、法规及监管政策的原则下，将采取措施予以删除。<br>
            4. 如您发现要销卡收集、存储的个人信息有错误的，有权要求要销卡予以更正。<br>
            <br><br><b>第六条：</b>您充分理解并完全接受：保护用户信息是要销卡一贯的政策，要销卡将会使用各种安全技术和程序存储、保护用户信息，防止其被未经授权的访问、使用、复制和泄露。我们不会向第三方出售或以其他方式共享您的个人信息，但存在下列任何一项情形除外：
            1. 根据国家法律、法规及法律程序的规定；<br>
            2. 根据政府部门（如行政机构、司法机构）的要求；<br>
            3. 与我们的关联公司共享相关信息；<br>
            4. 为保护要销卡或您的合法权益而披露；<br>
            5. 用户本人或其监护人授权披露；<br>
            6. 应用户的监护人的合法要求而向其披露。<br>
            除以上规定及本《隐私政策》已列明的情况外，当您的信息有可能披露给第三方时，您将会得到通知，并且您将有机会选择不与第三方共享此信息。<br>
            要销卡即便是按照条款约定将用户信息披露给第三方，亦会要求接收上述用户信息的第三方严格按照国家法律法规使用和保护用户信息。
            <br><br><b>第七条：</b>您充分理解并完全接受：即便是要销卡采取各种安全技术和程序存储、保护用户信息，防止其被未经授权的访问、使用、复制和泄露，但用户信息仍然有可能发生被黑客攻击、窃取，因不可抗力或者其他非要销卡的自身原因而被泄露的情形。对此，只要是要销卡采取了必要的措施防止上述情形之发生，并在上述情形发生之后及时通知用户信息泄露的情况，并采取必要的措施防止其损失进一步扩大，要销卡则无须赔偿由此给您造成的任何损失。
            <br><br><b>第八条：</b>您充分理解并完全接受：为向您提供服务、提升我们的服务质量以及优化您的服务体验，我们会在符合法律规定下使用您的个人信息，并主要用于下列用途：
            1. 在您登录要销卡网站或者App时，用于验证您的身份、为您提现余额、售后服务以及其他客户服务；<br>
            2. 帮助要销卡分析、了解用户需求，设计新的商业模式，或将其用于要销卡所开展的新业务当中；<br>
            3. 向您推荐您可能感兴趣的产品或服务信息。如您不希望接收上述信息，可通过相应的退订功能进行退订；<br>
            4. 评估和改进要销卡服务中的广告和其他促销及推广活动效果；<br>
            5. 要销卡网站或者App软件版本的升级、改版；<br>
            6. 可能使用您的个人信息用于预防和追究各种违法、犯罪活动或违反我们政策规则的行为，以保护您、其他要销卡用户，或要销卡的合法权益；<br>
            7. 其他的用于改进要销卡的服务、提升用户体验的目的。<br>
            要销卡仅在本《隐私政策》所述目的所必需期间和法律法规要求的时限内保留您的个人信息。<br>
            随着我们业务的发展，我们及我们的关联方有可能进行合并、收购、资产转让或类似的交易，您的个人信息有可能作为此类交易的一部分而被转移。我们将在转移前通知您。
            <br><br><b>第九条：</b>您可以访问和更新您的个人信息。您可以在要销卡页面的“我的账户”菜单中查阅您提交给要销卡的个人信息。如果您需要更新，也可以在该页面重置信息后提交给要销卡。或者联系要销卡客服予以更新。如果您需要注销账号，请务必亲自联系要销卡客服处理。
            <br><br><b>第十条：</b>您充分理解并完全接受：要销卡或者为实现第八条所述目的而接收了要销卡提供的用户信息的第三方企业或者公司发生合并或者分立，那么合并或者分立后企业或者公司仍然有权按照本《隐私政策》及其他相关约定收集、存储、保护、使用和分享用户信息，而无须另行征得您的同意。
            <br><br><b>第十一条：</b>我们非常重视对未成年人个人信息的保护。我们不希望未成年人直接使用要销卡网站提供的产品或服务，如果您是未成年人，请与您监护人一起或在监护人的监督下使用本网站的产品或服务。
            <br><br><b>第十二条：</b>您充分理解并完全接受：本《隐私政策》已经向您充分说明了要销卡是如何收集、存储、使用、保护以及分享您的用户信息，除了您对本《隐私政策》存在疑问或者异议，可以询问要销卡客户服务部外，要销卡没有义务另行以其他书面的方式再向您说明其用户个人信息及隐私保护政策。但如果要销卡有另行书面说明，且与本《隐私政策》相矛盾或者不一致的，以另行书面说明的为准；未尽事宜，仍以本《隐私政策》为准。
            <br><br><b>第十三条：</b>本《隐私政策》条款是可分的，所约定的任何条款如果部分或者全部无效，不影响该条款其他部分及本协议其他条款的法律效力。
            <br><br><b>第十四条：</b>要销卡基于本《隐私政策》及其补充约定的有效弃权必须是书面的，并且该弃权不能产生连带的相同或者类似的弃权。
            <br><br><b>第十五条：</b>本《隐私政策》是《要销卡用户服务协议》不可分割的组成部分，与之具有同等的法律效力；本《隐私政策》与《要销卡用户服务协议》不一致或者矛盾的地方，适用本《隐私政策》；未涉及的内容，仍适用《要销卡用户服务协议》。
            <br><br><b>第十六条：</b>要销卡有可能会适时变更本《隐私政策》，一经变更，要销卡将会按照此前的渠道或者可以用户知晓的其他渠道对外进行公布，必要的时候，要销卡将会在要销卡网站、App显著的位置或者以发送电子邮件的方式提醒您。修订后的《隐私政策》即取代修订前的《隐私政策》而产生相应的法律效力。如果您对于本隐私政策或在使用要销卡服务时对于您的个人信息或隐私情况有任何问题，请联系要销卡客服并作充分描述，要销卡将尽力解决。也请您务必关注并了解本《隐私政策》的变更，且一经变更，如果您继续使用要销卡的服务，即视为您充分理解并完全接受变更后的本《隐私政策》。
        </p>
    </div>
    <?php if($is_mobile!=1): ?>
    <div class="news_right">
        <div class="service_list">
            <a href="/about/service" target="_blank" rel=“nofollow”>服务协议</a>
            <a href="/about/protocol" target="_blank" rel=“nofollow”>转让协议</a>
            <a href="/about/ze" target="_blank" rel=“nofollow”>免责申明</a>
            <a href="/about/privacy" class="active" target="_blank" rel=“nofollow”>隐私政策</a>
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
