<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:58:"/www/wwwroot/yaoxiaoka/application/pc/view/card/index.html";i:1628072268;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/header.html";i:1621324688;s:58:"/www/wwwroot/yaoxiaoka/application/pc/view/common/nav.html";i:1624612117;s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/common/footer.html";i:1632456108;}*/ ?>
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

<?php if($au!=1): ?>
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
<?php else: ?>
<link rel="stylesheet" type="text/css" href="/public/pc/css/base.css?v=20211" />
<?php endif; ?>


<link rel="stylesheet" type="text/css" href="/public/pc/css/sell.css?v=20211"/>
<style>
    .choose_list li a>img {
        vertical-align: middle;
        margin: 0 13px;
    }
    .cardimg{
        max-width: 50px;
    }
    .import_tips{
        position: absolute;
        right: 0;
        width: 480px;
        height: 280px;
        background: rgba(0,0,0, 0.03);
        border-bottom-right-radius: 8px;
        text-align: center;
        margin-top: 60px;
    }
    .import_tips>img{
        margin: 30px 0 20px 0;
    }
    .import_tips>.p1{
        font-size: 14px;
        font-weight: 500;
        line-height: 30px;
        color: #ff6d5a;
    }
    .import_tips>.p2{
        font-size: 14px;
        line-height: 30px;
        color: #767e91;
    }
    .lx_list li{
        width: 200px;
        margin: 0 10px 10px 0;
    }
    .backtime{
        padding: 0 10px;height: 32px;line-height: 32px;font-size: 14px;color: #ff8282;font-weight: 500;background: rgba(255, 130, 130, 0.11);display: none;
    }
    .choose_list li>a {
    color: #fff;
}
</style>
<div class="container" style="width:1400px;padding: 0px 0 40px 0">
    <form id="formId" action="/user/sell/add" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cardInfoId" value="<?php echo $tid; ?>">
        <input type="hidden" name="cardValueId" value="0">
        <input type="hidden" name="cardAnyValue" value="0">
        <input type="hidden" name="isAnyRate" id="isAnyRate">
        <input type="hidden" name="submitType" value="batch">
        <input type="hidden" value="<?php echo $ture_name_status; ?>" id="ture_name_status">
        
        <!-- div class="jaja-cart-style" style="width: 212px;border: 1px solid #ddd;padding: 5px;border-radius: 10px;height: 948px;"> -->
            <div class="buy_title">选择卡类型</div>
            <ul class="lx_list">
                <li class="type_1 "  onclick="getAllCardBrand($(this), 1, '');" data-typeid="1"><i class="iconfont icon-smartphone-fill"></i><div class="lx_txt"><h3>话费卡</h3><p>移动/联通/电信..</p></div></li>
                <li class="type_2 "  onclick="getAllCardBrand($(this), 2, '');" data-typeid="2"><i class="iconfont icon-gamepad-fill"></i><div class="lx_txt"><h3>游戏卡</h3><p>骏网/九游/网易/完美..</p></div></li>
                <li class="type_3 "  onclick="getAllCardBrand($(this), 3, '');" data-typeid="3"><i class="iconfont icon-gas-station-fill"></i><div class="lx_txt"><h3>加油卡</h3><p>中石化/中石油..</p></div></li>
                <li class="type_4 "  onclick="getAllCardBrand($(this), 4, '');" data-typeid="4"><i class="iconfont icon-store--fill"></i><div class="lx_txt"><h3>商超卡</h3><p>中欣/沃尔玛/家乐福..</p></div></li>
                <li class="type_5 "  onclick="getAllCardBrand($(this), 5, '');" data-typeid="5"><i class="iconfont icon-shopping-cart-fill"></i><div class="lx_txt"><h3>电商卡</h3><p>京东/苏宁/天猫/美团..</p></div></li>
                <li class="type_6" onclick="getAllCardBrand($(this), 6, '');" data-typeid="18"><i class="iconfont icon-movie--fill"></i><div class="lx_txt"><h3>影视卡</h3><p>腾讯/优酷/爱奇艺..</p></div></li>
            </ul>
        <!-- </div> -->
        <div class="clear"></div>
        <!-- <div class="jaja-cart-pro" style="margin-left: 250px;margin-top: -961px;position: absolute;padding: 5px;border-radius: 10px;border: 1px solid #ddd;"> -->
            <div class="buy_title scroll_mz_up">选择卡品牌</div>
        
            <ul class="choose_list" id="brand_list" data-brand_id="15">
            </ul>
            <div class="clear"></div>
            <!-- <div class="jaja-cart-val" style="padding: 5px;border-radius: 10px;border: 1px solid #ddd;"> -->
                <div class="buy_title">选择卡面值</div>
                <div style="position: relative">
                    <!--mz_tip_show触发样式-->
                    <div class="mz_tip"></div>
                    <ul class="mz_list" id="mz_list">
                    </ul>
                    <div class="clear"></div>
                    <div id="backtime" class="backtime">
                        
                    </div>
                    
                    <div class="clear"></div>
                </div>
            <!-- </div> -->
            <div id="customRateShow" style="display: none">
                <div class="buy_title">供货折扣</div>
                <div class="gh_zk_input"><input type="number" min="1" step="0.01" name="cardAnyRate" id="cardAnyRate" placeholder="" onkeyup="rateFormat(this)"></div>
                <div class="gh_zk_tip tip2" id="anyRateTips">请先选择卡卷面值</div>
            </div>
        <!-- </div> -->
        
        
        <div class="buy_title">选择提交方式</div>
        <ul class="fs_list">
            <li class="lx_choose" id="type_batch"><i class="iconfont icon-file-copy-line"></i>批量提交</li>
            <li id="type_single"><i class="iconfont icon-dual-sim--line"></i>单张提交</li>
        </ul>
        <div class="clear"></div>
        <div class="buy_title" style="display: inline-block">请输入卡号/密码</div><div class="gh_zk_tip tip2" id="tips"></div>
        <div class="import">
            <div class="import_tips">
                <img src=" /public/pc/images/tips.png" alt="">
                <p class="p1">卡号和卡密之间必须使用空格隔开，<br>每张卡占用一行用“回车键”隔开，例如</p>
                <p class="p2">6054632001110017020 658359781003040130<br>2060546329011100170 408358350105750026</p>
            </div>
            <div class="import_top">
                <div class="import_top_left">已经输入<span><b><span id="lineCount">0</span>张</b></span>卡，每次最多可提交1000张<span>（单次提交重复卡密，系统将自动过滤）</span></div>
                <a onclick="tidyChar()" href="javascript:void(0)" class="import_top_btn1">整理卡号/密码</a>
                <a onclick="delChar()" href="javascript:void(0)" class="import_top_btn2">去除多余字符</a>
                <input type="text" name="del" class="import_top_input" placeholder="输入去除字符 (特殊符号除外,如: . \ 等)">
                <div class="clear"></div>
            </div>
            <textarea class="import_txt" name="cardBatch" id="cardBatch" onkeydown="cardNum(this,event)" onblur="cardNum(this,'blur')" placeholder="
请按下面规则填写

1.单次提交只能上传同一种类同一面值的充值卡。

2.上传格式为： 卡号空格卡密

3.每输入完一张充值卡换行输入下一张。

（示例:123456789 987654321）"></textarea>
        </div>
        <div class="import_one" style="display: none">
            <div class="import_one_input" id="cardNo"><input type="text" value="" class="input_one_text" name="cardNo" placeholder="请输入卡号"></div>
            <div class="import_one_input" id="cardP"><input type="text" value="" class="input_one_text" name="cardPwd" id="cardPwd" placeholder="请输入密码"></div>
        </div>
        <div class="agree">
            <!--            <p id="urgentShow" style="display: none"><label class="checkbox" for="urgent"><input type="checkbox" id="urgent" name="urgent" value="yes" ><span class="checkbox-text">我要加急处理<span class="gray">(9:00-18:00)</span> <span class="text-red" style="display: none" id="urgent-money">（手续费:1.00 元/张）</span> </span></label></p>-->
            <p><label class="checkbox" for="confirmXY"><input type="checkbox" id="confirmXY" name="confirmXY" value="yes" checked="checked"><span class="checkbox-text"> 我已阅读，理解并接受「<a class="text-blue" target="_blank" href="/about/service">服务协议</a>」和「<a class="text-blue" target="_blank" href="/about/protocol">回收说明</a>」</span></label></p>
            <p><label class="checkbox" for="legal"><input type="checkbox" id="legal" ><span class="checkbox-text">我已确认该卡号卡密<strong class="text-primary">来源合法</strong>，如有问题，本人愿意承担一切法律责任。</span></label></p>
        </div>
        <button type="button" class="buy_btn">确认提交卖卡</button>
        <div class="clear"></div>
    </form>
</div>
<p id="code"></p>

<input type="hidden" value="<?php echo $is_bank['id']; ?>" id="is_bank">
<?php if($uid): ?>

<div style="float: right">
    <a class="layui-btn layui-btn-primary layui-btn-xs reloads">刷新订单</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" target="_blank" href="pc/user/orders">所有订单</a>
</div>
<div style='clear:both'></div>
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
<link rel="stylesheet" href="/public/static/admin/layuiadmin/layui/css/layui.css" media="all">
<script src="/public/static/admin/layuiadmin/layui/layui.js"></script>
<script>
    layui.use(['layer','table'], function() {
        var table = layui.table;
        table.render({
            elem: '#LAY_table_user'
            , url: "/pc/User/orders"
            ,totalRow: true
            , cols: [[
                {field: 'orderid', title: '订单号',totalRowText:'合计：'}
                , {field: 'total_orderid', title: '批次'}
                , {field: 'kazhong', title: '卡种',width: 60 }
                , {field: 'crad_number', title: '卡号'}
                , {field: 'cash', title: '提面',totalRow:true}
                , {field: 'realvalue', title: '实面',totalRow:true}
                , {field: 'incash', title: '结算',totalRow:true}
                , {field: 'on_time', title: '提交'}
                , {field: 'end_time',title: '处理'}
                , {field: '', title: '描述', templet: function (d) {
                        var colors = 'green';
                        if (d.status == 1) {
                            if (Number(d.cash) != Number(d.realvalue)) {
                                colors = 'red';
                                d.status_desc = '实际面额不符';
                            }
                        } else {
                            colors = 'red';
                        }
                        if(!d.status_desc){
                            d.status_desc='';
                        }
                        return '<font color="' + colors + '">' + d.status_desc + '</font>';
                    }
                }
                , {field: 'status', width: 90, title: '状态', templet: function (d) {
                        var colors = 'blue';
                        if (d.status == 1) {
                            colors = 'green';
                        } else if (d.status == 2) {
                            colors = 'red';
                        }
                        return '<font color="' + colors + '">' + d.status_txt + '</font>';
                    }
                }
                // , {field: '', width: 60, title: '操作', templet: '#caozuo'}
            ]]
            , id: 'testReload'
            , limit: 5
            , page: false

        })
        $('.reloads').on('click', function () {
            //执行重载
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
            })
        })
    })
</script>
<?php endif; ?>


<script src="/public/pc/js/sellCard.js?v=20211.222" type="text/javascript" charset="utf-8"></script>
<script src="/public/pc/js/cardFormat.js?v=20211" type="text/javascript" charset="utf-8"></script>
<script>
    $(function () {
        //getAllCardBrand($(this), "<?php echo $tid; ?>", '');
        $('.lx_list li').eq(0).click();
    });
</script>
<div class="mask">
    <!--  登录弹窗  -->
    <div class="modal login_modal">
        <div class="close"></div>
        <div class="logo_mid"><img src="/public/pc/images/logo_test1.png" alt="logo"></div>
        <div class="title_mid"><h3>账户登录</h3><p>没有账号？ <a href="/sign/up">立即注册</a></p><div class="clear"></div></div>
        <div class="clear"></div>
        <form id="loginForm" action="/sign/in" method="post">
            <div class="add_input"><input type="text" name="username"  placeholder="手机号"></div>
            <div class="add_input"><input type="password" name="userpass" placeholder="密码"></div>
            <button type="button" class="add_btn" id="loginBtn" onclick="login()">登 录</button>
            <?php echo token(); ?>
        </form>
        <p class="tip_mid">忘记密码？ <a href="/passwd">立即找回</a></p>
    </div>
    <!--订单确认弹窗-->
    <div class="modal ddxq_modal">
        <div class="close"></div>
        <!--        <div class="title_icon"><img src="/new2020/index/img/dd_icon.png" alt="自定义卡"></div>-->
        <div class="title_txt"><h3>订单确认</h3><p>有任何问题可联系在线客服</p></div>
        <div class="clear"></div>
        <div class="tip2" style="margin:0;display: block">请确认提交面值与实际面值一致！否则后果自负！</div>
        <ul class="dd_list">
            <li><div>卡类型</div><div id="type"></div></li>
            <li><div>卡品牌</div><div id="brand"></div></li>
            <li><div>卡数量</div><div class="text-danger" id="count"></div></li>
            <li><div>卡面值</div><div><span class="text-danger" id="price"></span></div></li>
        </ul>
        <button class="add_btn" id="submitBtn" onclick="submitCard()">确认面值一致，提交</button>
    </div>

</div>

<!--  支付宝扫码弹窗  -->

<div class="modal sm_modal" style="opacity:1;z-index:2;display:none">
    <div class="clear"></div>
    <div class="sm_bg">
        <!--            <img id="sign_img" src="" height="120" alt="二维码">-->
        <p id="sign_img" style="padding-top: 75px"></p>
        <p>请使用<span class="blue">手机支付宝</span>
            <br>扫描二维码完成认证</p>
        <div class="face_btn"><button class="layui-btn layui-btn-sm face_res" type="button" v="1">认证完成</button><button v="2" class="layui-btn layui-btn-sm layui-btn-danger face_res" type="button" >认证失败</button></div>
    </div>
    <div class="clear"></div>
</div>
<script src="/public/pc/js/jquery.qrcode.min.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>


<script>
    let isLogin = "<?php echo \think\Session::get('uinfo.id'); ?>";
    function login() {
        var $username = $('[name=username]');
        if ($username.val() === '') {
            layer.msg('登录账户还未填写哦！',{icon:5});
            return ;
        }
        var $userpass = $('[name=userpass]');
        if ($userpass.val() === '') {
            layer.msg('密码还未填写哦！',{icon:5});
            return false;
        }
        $.post("/sign/in",$('#loginForm').serialize(),function(data){
            if(data.code==1){
                layer.msg(data.msg, {icon: 1});
                setTimeout(function(){
                    isLogin = true;
                    $('#is_truename').val(data.is_truename);
                    setTimeout(function () {
                        $('.mask').hide();
                        $('.modal').removeClass('modal_show');
                    }, 100)

                },1000); //再执行关闭

            }else{
                $("input[name='__token__']").val(data.token);
                layer.msg(data.msg, {icon: 5});
            }
        },'json');
    }
    $('.lx_list li').click(function () {
        $(this).addClass('lx_active').siblings('li').removeClass('lx_active');
    });
    $('.choose_list li').click(function () {
        $(this).addClass('lx_choose').siblings('li').removeClass('lx_choose');
        $(this).children('.zhe').show();
        $(this).siblings('li').children('.zhe').hide();
        let index = $(this).index();
        $('.mz_list').eq(index).show().siblings('.mz_list').hide();
    });
    $('.fs_list li').click(function () {
        $(this).addClass('lx_choose').siblings('li').removeClass('lx_choose');
        let ind = $(this).index();
        if (ind == 0){
            $('.import_one').hide();
            $('.import').show();
        }
        if (ind == 1){
            $('.import_one').show();
            $('.import').hide();
        }
    });
    /**
     * 自定义费率格式化（只保留2位小数）
     * @param obj
     */
    function rateFormat(obj) {

        obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
        obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        obj.value = obj.value.replace(/^\D*(\d*(?:\.\d{0,1})?).*$/g, '$1'); //只能输入两个小数
       
    }
    $('.mz_list li').not('.weihu').click(function () {
        $(this).addClass('lx_choose').siblings('li').removeClass('lx_choose');
    });
    $('.mz_list>.weihu').click(function () {
        alert('当前面值正在维护');
    });
    $('.lx_choose').find('.zhe').show();
    $('.gou').click(function () {
        $(this).removeClass('gou_huxi');
        $(this).toggleClass('agree_check');
    });
    $('.hs_nav').hover(function () {
        $('.hs_list').stop().fadeToggle();
    });
    $('.sell_show').hover(function () {
        $('.sell_nav').stop().slideToggle(200);
    });
    $('.close').click(function () {
        $('.mask').hide();
        $('.modal').removeClass('modal_show');
    });
    $('.buy_btn').click(function () {
        // 判断是否登录
        if (!isLogin) {
            $('.mask').show();
            setTimeout(function () {
                $('.login_modal').addClass('modal_show');
            },100);
            return;
        }
        //判断实名制
        if(!$('#is_bank').val()){
            layer.open({
                type: 2,
                title: '实名认证',
                shadeClose: true,
                area: ['480px', '80%'],
                shade: 0.8,
                content: '/pc/Tixian/bank',
            });
            // layer.msg('您的账户未实名认证，即将跳转至实名认证...',{icon:5 ,time:3000},function () {
            //     window.location.href='/pc/User/auth_name';
            // });
            return;
        }
        
        //判断是人脸 
        if($('#ture_name_status').val() == '1'){
            
           $('.sm_modal').show();
            var _weburl = window.location.host;
            var _isLogin = "<?php echo \think\Session::get('uinfo.id'); ?>";
            
            $('#sign_img canvas').css('display','none');
            $('#sign_img').qrcode({'text':'http://'+_weburl+'/pc/index/face_zfb?uid='+_isLogin,'width':120,'height':120});
            
           
           
            return;
            // layer.msg('您的账户未实名认证，即将跳转至实名认证...',{icon:5 ,time:3000},function () {
            //     window.location.href='/pc/User/auth_name';
            // });
            return;
        }
        
        
        
        // 判断是否选择了面值
        let valueIsSelected = $('[name=cardAnyValue]').val();
        if (valueIsSelected === "0" || valueIsSelected === "" || valueIsSelected === undefined) {
            $('html, body').animate({
                scrollTop: $(".scroll_mz_up").offset().top
            }, 500);
            $('.mz_tip').addClass('mz_tip_show');
            return;
        }
        // 支持自定义费率才校验
        if ($('#isAnyRate').val() === "1") {
            let customRate = $('#cardAnyRate').val();
            customRate = Number(customRate);
            if (customRate !== null || true) {
                let minRate = $('#anyRateTips').find("span").first().text();
                let maxRate = $('#anyRateTips').find("span").eq(1).text();
                if (customRate < minRate) {
                    // ToastErr("最低折扣不得低于"+ minRate + "%，请重新填写");
                    // showErrorBorder("#cardAnyRate");
                    layer.tips("最低折扣不得低于"+ minRate + "%，请重新填写",$('#cardAnyRate'))
                    return;
                }

                if (customRate > maxRate) {
                    // ToastErr("最高折扣不得超过"+ maxRate + "%，请重新填写");
                    // showErrorBorder("#cardAnyRate");
                    layer.tips("最高折扣不得超过"+ maxRate + "%，请重新填写",$('#cardAnyRate'))
                    return;
                }
            }
        }

        let cv = $('#confirmXY').is(':checked');
        let cx = $('#legal').is(':checked');
        let subType = $('[name=submitType]').val();
        console.log(cv,cx)
        if (cv && cx) {
            // 检查卡密是否为空
            if (subType === "batch") {
                let cardBatch = $.trim($('[name=cardBatch]').val());
                if (cardBatch.length <= 0) {
                    // ToastErr("请输入要提交的卡号/卡密");
                    // showErrorBorder('[name=cardBatch]');
                    layer.tips("请输入要提交的卡号/卡密",$('[name=cardBatch]'),{tips: 4})
                    return;
                }
                // 判断卡密总数是否超标
                let cardCount = $('#lineCount').text();
                if (cardCount > 1000) {
                    // ToastErr("单次卡密最多提交1000张，超出部分建议您分批提交");
                    // showErrorBorder("[name=cardBatch]");
                    layer.tips("单次卡密最多提交1000张，超出部分建议您分批提交",$('[name=cardBatch]'),{tips: 4})
                    return;
                }
                 
                getCount();
            }
            if (subType === "single") {
                let cardPwd = $('[name=cardPwd]').val();
                if (cardPwd.length <= 0) {
                    // ToastErr("请输入要提交的卡号/卡密");
                    // showErrorBorder('[name=cardPwd]');
                    layer.tips("请输入要提交的卡号/卡密",$('[name=cardPwd]'))
                    return;
                }
                $('#count').text("1 张")
            }
            $('.mask').show();
            setTimeout(function () {
                $('.ddxq_modal').addClass('modal_show');
            },100);
        } else {
            if (!cv) {
                layer.msg("请认真阅读并勾选： 我已阅读，理解并接受「服务协议」和「回收说明」",{icon:5});
            } else {
                layer.msg("请确认并勾选：我已确认该卡号卡密来源合法，如有问题，本人愿意承担一切法律责任。",{icon:5});
            }
        }
    });
    $('.face_res').click(function (obj) {
        var v=$(this).attr('v');
        if(v==1){
           window.location.reload();
        }else{
            window.location.reload();
        }
    })
</script>
<?php if($au!=1): ?>
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