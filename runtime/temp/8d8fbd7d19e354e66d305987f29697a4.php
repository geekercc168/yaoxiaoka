<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:58:"/www/wwwroot/yaoxiaoka/application/pc/view/user/index.html";i:1620550109;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo GetRedis('jaja_title'); ?></title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="/public/static/admin/layuiadmin/layui/css/layui.css" media="all">
	<link rel="stylesheet" href="/public/static/admin/layuiadmin/style/admin.css?v=20211" media="all">
	<script src="/public/static/admin/layuiadmin/layui/layui.js?v=20211"></script>
	<script src="/public/static/admin/js/jquery.js"></script>
	<link rel="stylesheet" href="/public/static/admin/layuiadmin/style/login.css?v=1.0" media="all">
	<link rel="stylesheet" href="/public/pc/css/styles.css?v=20211" media="all">
	
    
    <meta name="description" content="<?php echo GetRedis('jaja_desc'); ?>">
    <meta name="keywords" content="<?php echo GetRedis('jaja_keywords'); ?>">
</head>
<style>
	.outermost{
		padding: 10px 10px 10px 10px;
		background: white;
	}
	.tj_num{
		color: red;
		font-size: 16px;
		font-weight: bold;
	}
</style>
<script>
    function tdTitle(){
        $('th').each(function(index,element){
            $(element).attr('title',$(element).text());
        });
        $('td').each(function(index,element){
            $(element).attr('title',$(element).text());
        });
    };
	function newTab(url, tit) {
		if (top.layui.index) {
			top.layui.index.openTabsPage(url, tit)
		} else {
			window.open(url)
		}
	}
	
	
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
<style>
    .layui-side-menu .layui-nav .layui-nav-item a{
         padding-left: 5px;
    }
</style>
<body class="layui-layout-body">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="#" target="_blank" title="前台">
                        <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="/" layadmin-event="fullscreen">
                        首页
                    </a>
                </li>
               
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen"  onclick="card_rate_query()">
                        平台费率
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="/yk_card" layadmin-event="fullscreen">
                        我要销卡
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="/help/gzh" layadmin-event="fullscreen">
                        公众号
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="#" id="favorites">收藏本站</a>
                </li>
                <!--  <li class="layui-nav-item" lay-unselect>
                   <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
                     <i class="layui-icon layui-icon-notice"></i>   -->

                <!-- 如果有新消息，则显示小圆点 -->
                <!-- <span class="layui-badge-dot"></span>
              </a>
            </li> -->
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <!-- <li class="layui-nav-item layui-hide-xs" lay-unselect>
                  <a href="javascript:;" layadmin-event="note">
                    <i class="layui-icon layui-icon-note"></i>
                  </a>
                </li> -->
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect style='margin-right: 30px;'>
                    <a href="javascript:;">
                        <cite><?php echo \think\Session::get('uinfo.username'); ?></cite>
                    </a>
                    <dl class="layui-nav-child">
                        <!--                        <dd><a lay-href="/admin/admin/profile">基本资料</a></dd>-->
                        <!--                        <dd><a lay-href="/admin/admin/password">修改密码</a></dd>-->
                        <!--                        <hr>-->
                        <dd style="text-align: center;"><a href="/sign/out">退出</a></dd>
                    </dl>
                </li>

                <!-- <li class="layui-nav-item layui-hide-xs" lay-unselect> -->
                <!-- <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a> -->
                <!-- </li> -->
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="/pc/user/info">
                    <span>用户管理后台</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    <li data-name="home" class="layui-nav-item layui-nav-itemed">
                        <dd data-name="button">
                            <i class="layui-icon layui-icon-home"></i>
                            <a lay-href="/pc/user/info">控制台</a>
                        </dd>
                    </li>
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li data-name="component" class="layui-nav-item <?php if($vo['submenu_id']=='1'): ?>layui-nav-itemed<?php endif; ?>">
                        <?php if(empty($vo['menu_name'])): ?>
                        <a href="javascript:;" lay-tips="<?php echo $vo['submenu_name']; ?>" lay-direction="2">
                            <i class="layui-icon <?php echo $vo['css']; ?>"></i>
                            <cite><?php echo $vo['submenu_name']; ?></cite>
                        </a>
                        <?php if(is_array($vo['erji']) || $vo['erji'] instanceof \think\Collection || $vo['erji'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['erji'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?>
                        <dl class="layui-nav-child">
                            <?php if(empty($voo['sanji'])): ?>
                            <dd data-name="button">
                                <a lay-href='/<?php echo $voo['resource_url']; ?>'><?php echo $voo['resource_name']; ?></a>
                            </dd>
                            <?php else: ?>
                            <dd data-name="grid">
                                <a href="javascript:;"><?php echo $voo['resource_name']; ?></a>
                                <?php if(is_array($voo['sanji']) || $voo['sanji'] instanceof \think\Collection || $voo['sanji'] instanceof \think\Paginator): $i = 0; $__LIST__ = $voo['sanji'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sanji): $mod = ($i % 2 );++$i;?>
                                <dl class="layui-nav-child">
                                    <dd data-name="list"><a lay-href="'/<?php echo $sanji['resource_url']; ?>'"><?php echo $sanji['resource_name']; ?></a></dd>
                                </dl>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </dd>
                            <?php endif; ?>
                        </dl>
                        <?php endforeach; endif; else: echo "" ;endif; else: ?>
                            <a lay-href="/<?php echo $vo['menu_name']; ?>" lay-tips="<?php echo $vo['menu_name']; ?>" lay-direction="1">
                                <i class="layui-icon <?php echo $vo['css']; ?>"></i>
                                <cite><?php echo $vo['submenu_name']; ?></cite>
                            </a>
                                <?php endif; ?>



                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="/pc/user/info" lay-attr="/pc/user/info" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="/pc/user/info" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>


<script>
    layui.config({
        base: '/public/static/admin/layuiadmin/' //静态资源所在路径
        ,version: "202009233"
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','element'],function () {
        var element=layui.element;
        element.on('tab(layadmin-system-side-menu)', function(data){
            console.log(data);
        });
        $(document).ready(function(){
            $("#favorites").click(function(){
                var ctrl=(navigator.userAgent.toLowerCase()).indexOf('mac')!=-1?'Command/Cmd': 'CTRL';
                if(document.all){
                    window.external.addFavorite('http://1xiaoka.com/','要销卡');
                }
                else if(window.sidebar){
                    window.sidebar.addPanel('要销卡', 'http://1xiaoka.com/', "");
                }
                else{ alert('您可以通过快捷键' + ctrl + ' + D 加入到收藏夹');}
            })


        })
    });
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
</body>
</html>