<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:104:"C:\Users\geeker_yuyu\Desktop\coder\workspace\A-jobstack\yaoxiaoka/application/admin\view\main\index.html";i:1615274882;s:107:"C:\Users\geeker_yuyu\Desktop\coder\workspace\A-jobstack\yaoxiaoka\application\admin\view\common\header.html";i:1614909998;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>要销卡平台-提供充值卡回收|点卡回收， 充值卡兑换|点卡兑换， 充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台</title>
<!--	<meta name="renderer" content="webkit">-->
<!--	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
  <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
<!--	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">-->
	<link rel="stylesheet" href="/public/static/admin/layuiadmin/layui/css/layui.css" media="all">
	<link rel="stylesheet" href="/public/static/admin/layuiadmin/style/admin.css?v=20211" media="all">
	<script src="/public/static/admin/layuiadmin/layui/layui.js"></script>
	<script src="/public/static/admin/js/jquery.js"></script>
	<link rel="stylesheet" href="/public/static/admin/layuiadmin/style/login.css?v=1.0" media="all">
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
</script>
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
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

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
                        <cite><?php echo \think\Session::get('user_info.username'); ?></cite>
                    </a>
                    <dl class="layui-nav-child">
<!--                        <dd><a lay-href="/admin/admin/profile">基本资料</a></dd>-->
<!--                        <dd><a lay-href="/admin/admin/password">修改密码</a></dd>-->
<!--                        <hr>-->
                        <dd style="text-align: center;"><a href="/admin/index/logout">退出</a></dd>
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
                <div class="layui-logo" lay-href="/admin/main/console">
                    <span>管理后台</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    <li data-name="home" class="layui-nav-item layui-nav-itemed">
                        <dd data-name="button">
                            <i class="layui-icon layui-icon-home"></i>
                            <a lay-href="/admin/main/console">控制台</a>
                        </dd>
                    </li>
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li data-name="component" class="layui-nav-item">
                        <?php if(empty($vo['name'])): ?>
                        <a href="javascript:;" lay-tips="<?php echo $vo['submenu_name']; ?>" lay-direction="2">
                            <?php else: ?>
                            <a lay-href="/<?php echo $vo['resource_url']; ?>.html" lay-tips="<?php echo $vo['submenu_name']; ?>" lay-direction="2">
                                <?php endif; ?>
                                <i class="layui-icon <?php echo $vo['css']; ?>"></i>
                                <cite><?php echo $vo['submenu_name']; ?></cite>
                            </a>
                            <?php if(is_array($vo['erji']) || $vo['erji'] instanceof \think\Collection || $vo['erji'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['erji'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?>
                            <dl class="layui-nav-child">
                                <?php if(empty($voo['sanji'])): ?>
                                <dd data-name="button">
                                    <a lay-href='/<?php echo $voo['resource_url']; ?>.html'><?php echo $voo['resource_name']; ?></a>
                                </dd>
                                <?php else: ?>
                                <dd data-name="grid">
                                    <a href="javascript:;"><?php echo $voo['resource_name']; ?></a>
                                    <?php if(is_array($voo['sanji']) || $voo['sanji'] instanceof \think\Collection || $voo['sanji'] instanceof \think\Paginator): $i = 0; $__LIST__ = $voo['sanji'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sanji): $mod = ($i % 2 );++$i;?>
                                    <dl class="layui-nav-child">
                                        <dd data-name="list"><a lay-href="'/<?php echo $sanji['resource_url']; ?>.html'"><?php echo $sanji['resource_name']; ?></a></dd>
                                    </dl>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </dd>
                                <?php endif; ?>
                            </dl>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
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
                    <li lay-id="/admin/main/console" lay-attr="/admin/main/console" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="/admin/main/console" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>


<script>
    layui.config({
        base: '/public/static/admin/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');
    
    setInterval(
        function(){ 
        $.get('/admin/finance/notice_tx_shen_he',{},function(res){
            
            if(res.code == 1){
                layer.open({
                    title: '新消息来啦！',
                    type: 2,
                    shadeClose: false, //开启遮罩关闭
                    shade: false,
                    area: ['220px', '220px'],//<audio autoplay="autoplay"><source src="../resource/img/admin/05.mp3" type="audio/wav"/>
                    content: "/public/tx_tixing.html",
                    offset:"rb"
                })
                setTimeout(function(){
                    layer.closeAll();//10s自动关闭弹窗
                },5000);
            }
        })

    }, 20000);
    
</script>
</body>
</html>


