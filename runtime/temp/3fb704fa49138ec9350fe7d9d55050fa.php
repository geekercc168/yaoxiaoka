<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:64:"/www/wwwroot/yaoxiaoka/application/pc/view/help/notice_info.html";i:1614933490;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mheader.html";i:1614909815;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/header.html";i:1621324688;s:58:"/www/wwwroot/yaoxiaoka/application/pc/view/common/nav.html";i:1624612117;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mfooter.html";i:1620488383;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/footer.html";i:1632456108;}*/ ?>
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
    信息详情
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
<link rel="stylesheet" type="text/css" href="/public/pc/css/base.css?v=2021"/>

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

<style>
    .layui-fluid{
        padding: 15px;
        min-height: 345px;
    }
    .layuiAdmin-msg-detail .layui-card-header {
        height: auto;
        line-height: 30px;
        padding: 15px;
    }
    .layui-card-header>h2{
        margin-bottom: 10px;
        font-weight: bold;
    }
    .layui-card-header{
        text-align: center;
    }
    .layui-text{
        line-height: 24px;
        font-size: 14px;
        color: #666;
        padding: 3% 5%;
    }
    .layui-text p,div{
        line-height: 22px;
    }
</style>
<body layadmin-themealias="default">

<div class="layui-fluid" id="LAY-app-message-detail">
    <div class="layui-card layuiAdmin-msg-detail">
            <div class="layui-card-header">
                <h2 class="ninfo_title"><?php echo $info['title']; ?></h2>
                <p>
                    <span><?php echo date('Y-m-d H:i',$info['pub_time']); ?></span>
                </p>
            </div>
            <div class="layui-card-body layui-text">
                <div class="layadmin-text">
                    <?php echo $info['content']; ?>
                </div>
            </div>
        <input id="nid" hidden value="<?php echo $id; ?>">
        <input id="tid" hidden value="<?php echo $t; ?>">
    </div>
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
<script>
    $(document).keydown(function(event){
        //判断当event.keyCode 为37时（即左方面键），执行函数to_left();
        //判断当event.keyCode 为39时（即右方面键），执行函数to_right();
        if(event.keyCode == 37 || event.keyCode == 38){
            window.location.href='/ninfo/t/'+$('#tid').val()+'/id/'+(parseInt($('#nid').val())-1);
        }else if (event.keyCode == 39 || event.keyCode == 40){
            window.location.href='/ninfo/t/'+$('#tid').val()+'/id/'+(parseInt($('#nid').val())+1);
        }
    });

</script>
<?php endif; ?>