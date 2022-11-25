<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/index/new_html.html";i:1622510490;}*/ ?>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo GetRedis('jaja_title'); ?></title>
        <meta name="description" content="<?php echo GetRedis('jaja_desc'); ?>">
        <meta name="keywords" content="<?php echo GetRedis('jaja_keywords'); ?>">
        <meta name="applicable-device" content="pc,mobile">
        <link href="/public/pc/new/css/bootstrap.css" rel="stylesheet">
        <link href="/public/pc/new/css/bxslider.css" rel="stylesheet">
        <link href="/public/pc/new/css/style.css" rel="stylesheet">
        <script src="/public/pc/new/js/jquery.min.js"></script>
        <script src="/public/pc/new/js/bxslider.min.js"></script>
        <script src="/public/pc/new/js/common.js?v=222"></script>
        <script src="/public/pc/new/js/bootstrap.js"></script>
        <script src="/public/layer/layer.js?v=20211" type="text/javascript" charset="utf-8"></script>
     
    </head>

    <body>
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
                            <li onclick="card_rate_query()">
                                <a href="javascript:;">平台费率</a>
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
        <!-- bxslider -->
        <style type="text/css">
            .btn-white {
                color: #fff;
                border-color: #fff;
                background-color: transparent;
            }
            .btn-lg {
                height: auto;
                line-height: 30px;
                font-size: 18px;
                padding: 14px 70px 16px 70px;
            }
            .btn-circle {
                border-radius: 100px !important;
            }
            .btn {
                display: inline-block;
                padding: 0 25px;
                height: 40px;
                line-height: 40px;
                line-height: 38px\9;
                _line-height: 40px;
                font-size: 14px;
                font-weight: normal;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                color: #018ebb;
                border: 2px solid transparent;
                background-color: #e8f0f3;
                border-radius: 3px;
                -webkit-transition: .3s;
                transition: .3s;
            }
            
        </style>
        <div class="" style="margin-top:90px;">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12" style="background:url('/public/pc/new/images/jumbotron.jpg') no-repeat;background-size: 100%;height: 440px;text-align: center">
                    <div style="height: 150px;"></div>
                    
                    <div >
                        <img style="" height="80" src="/public/pc/images/nologo6.png" alt="">
                        <div style="height: 30px;"></div>
                        <a style="font-size: 30px;height: auto;line-height: 30px;font-size: 18px;padding: 14px 70px 16px 70px;color: #fff;border-color: #fff;background-color: transparent" class="btn btn-white btn-lg btn-circle" href="<?php echo $lo_url; ?>">我有卡要回收</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- main -->
        <style type="text/css">
            
            .notice {
                position: relative;
                height: 100px;
                background-color: #ffffff;
                box-shadow: 0px 4px 20px 0px rgba(48, 55, 83, 0.1);
                border-radius: 50px;
                margin-top: -50px;
            }

            .notice_img {
                float: left;
            }

            .notice_img > img {
                margin: 24px 40px 0 40px;
            }

            .notice_txt {
                position: absolute;
                left: 140px;
                top: 0px;
                width: 1000px;
                height: 90px;
                overflow: hidden;
                text-align: left;
                color: #303753;
            }

            .notice_txt a {
                text-align: left
            }

            .notice_txt a:hover {
                color: #5673ff
            }

            .notice_txt a:hover p {
                color: #5673ff
            }

            .notice_txt h1 {
                font-size: 20px;
                font-weight: 500;
                margin-bottom: 14px;
                width: 970px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .notice_txt h1 img {
                vertical-align: middle;
                margin-right: 8px
            }

            .notice_txt p {
                font-size: 18px;
                color: #767e91;
                width: 970px;
                height: 30px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .notice_more {
                display: block;
                position: absolute;
                color: #b3b9c7;
                font-size: 18px;
                line-height: 24px;
                top: 26px;
                right: 60px;
                transition: .2s;
            }

            .notice_more:after {
                position: absolute;
                top: 12px;
                right: -30px;
                content: '';
                display: block;
                background: url("../images/right_icon2.png");
                height: 18px;
                width: 10px;
            }

            .notice_more:hover {
                color: #5673ff;
            }

            .notice_date {
                position: absolute;
                right: 0;
                top: 3px;
                padding-right: 31px;
                text-align: right;
            }

            .notice_date:after {
                content: '';
                width: 1px;
                height: 40px;
                background-color: #e5e8ee;
                position: absolute;
                right: 0;
                top: 4px;
            }

            .notice_date .p1 {
                font-size: 20px;
                font-weight: 500;
                margin-bottom: 12px;
                color: #303753;
            }

            .notice_date .p2 {
                font-size: 18px;
                color: #b3b9c7;
                font-weight: 500;
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="notice">
                    <div class="notice_img" style="margin-top: -53px;"><img src="/public/pc/images/ptgg.png" alt="平台公告"></div>
                    <div class="notice_txt swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach($notice as $v): ?>
                            <a  href="/ninfo/t/1/id/<?php echo $v['id']; ?>" target="_blank" class="swiper-slide">
                                <h1><img style="" src="/public/pc/images/gg_icon.png" alt="公告图标"><?php echo $v['title']; ?></h1>
                                <p><?php echo $v['content']; ?></p>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <a href="#" onclick="n_list('公告列表','notice')" class="notice_more">更多<br>公告</a>
                </div>
            </div>
            <script src="/public/pc/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
           
            <script>
                var mySwiper = new Swiper ('.notice_txt', {
                    direction: 'vertical', // 垂直切换选项
                    loop: true, // 循环模式选项
                    autoplay:true,//等同于以下设置
                })
            </script>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="index_product">
                        <div class="pro_title">
                            <p>products</p>
                            <span>我们的产品</span>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/17.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="移动卡">移动卡</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/18.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="联通卡">联通卡</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/19.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="电信卡">电信卡</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/16.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="骏网一卡通(骏卡)">骏网一卡通(骏卡)</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/20.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="盛大一卡通">盛大一卡通</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/21.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="网易一卡通">网易一卡通</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/22.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="完美一卡通">完美一卡通</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/25.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="天宏一卡通">天宏一卡通</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/26.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="纵游一卡通">纵游一卡通</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/28.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="巨人一卡通(征途卡)">巨人一卡通(征途卡)</a></p>
                        </div>
                        <div class="col-sm-4 col-md-2 col-mm-6 product_img">
                            <a href="<?php echo $lo_url; ?>">
                                <img src="/public/pc/new/images/31.jpg" class="img-thumbnail" alt="">
                            </a>
                            <p class="product_title"><a href="<?php echo $lo_url; ?>" title="盛付通卡">盛付通卡</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="news_box">
                        <h1 class="title_h1">常见问题</h1>
                        <span class="title_span pull-right" onclick="n_list('常见问题','question')">更多</span>
                        <ul class="index_news">
                            <?php foreach($question as $v): ?>
                            <li>
                                <a href="/ninfo/t/2/id/<?php echo $v['id']; ?>" title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></a>
                                <span class="news_time"><?php echo date('Y-m-d',$v['pub_time']); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
            
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="index_contact">
                        <h1 class="title_h1">行业资讯</h1>
                        <span class="title_span pull-right" onclick="a_list()">更多</span>
                        <ul class="index_news">
                            <?php foreach($article as $v): ?>
                            <li>
                                <a href="/ninfo/t/3/id/<?php echo $v['id']; ?>" title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></a>
                                <span class="news_time"><?php echo date('Y-m-d',$v['pub_time']); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="news_box">
                        <h1 class="title_h1">联系我们</h1>
                        <p> &nbsp;</p>
                        <p>工作时间：周一至周日09:00 - 23:00</p>
                        <p>联系电话：400-075-5998</p>
                        <p>公司地址：深圳市福田区中康南路8号</p>
                        <p>QQ ：1828847938</p>
                        <p>邮箱：1828847938@qq.com</p>
                        <img src="/public/pc/picture/qrcode1.jpg" alt="二维码" width="120">
                        <p>关注微信公众号</p>
                    </div>
                </div>
            </div>
        </div>
      
        <footer>
            <div class="copyright">
                <p>粤ICP备2020113587号<a href="javascript:;" target="_blank">网站地图</a></p>
                <p class="copyright_p"><p>版权所有：深圳宏信智联 <img src="/public/pc/images/gwab.png">粤公网安备：44030402004298号 ICP证：粤ICP备2020113587号 </p></p>
                <p class="copyright_p">
                    <a href="http://1xiaoka.com/sitemap.xml">要销卡平台-提供充值卡回收|点卡回收</a>，
                    <a href="http://1xiaoka.com/sitemap.xml">充值卡兑换|点卡兑换，</a>
                    <a href="http://1xiaoka.com/sitemap.xml">充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台</a>
                </p>
            </div>
        </footer>
       
       <script>
        function n_list(title,type) {
            layer.open({
                type: 2,
                title:title,
                offset :'30px',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/'+type,
            });
        }
        function a_list() {
            layer.open({
                type: 2,
                title:'资讯列表',
                offset :'30px',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/article',
            });
        }
        function card_rate_query() {
            layer.open({
                type: 2,
                title:'平台费率',
                offset :'30px',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/pc/help/card_rate_query',
            });
        }
    </script>
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
</html>
