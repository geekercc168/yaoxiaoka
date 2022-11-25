<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"/www/wwwroot/yaoxiaoka/application/pc/view/user/info.html";i:1623832879;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
    .balance_card{
        height: inherit;
    }
</style>
<link rel="stylesheet" type="text/css" href="/public/pc/css/swiper.min.css" />
<div class="right">

    <div class="layui-fluid layadmin-homepage-fluid">
        <div class="layui-row layui-col-space8">
            <div class="layui-col-md12">
                <div class="layadmin-homepage-panel layadmin-homepage-shadow">
                    <div class="layui-card text-center">
                        <div class="layui-card-body">
                            <div class="user_come">欢迎你，<span><?php echo $uinfo['username']; ?></span></div> 
                            <div class="login_log">您的ID:<?php echo $uinfo['id']; ?></div>
                            <div class="acc_safe">账户安全
                                <div class="safe_lv" style="background: #fff">
                                    <div class="layui-progress">
                                        <div class="layui-progress-bar layui-bg-blue" lay-percent="<?php echo $bl; ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-md8">
                                <div class="layui-col-md2">
                                    <a class="<?php if($is_truename!=1): ?>not_set<?php endif; ?>" href="#" onclick="newTab('/pc/User/auth_name','实名认证')"><img src="/public/pc/images/user_icon1.png" alt="">实名认证</a>
                                </div>
                                <div class="layui-col-md2">
                                    <a class="<?php if($uinfo['email']): else: ?>not_set<?php endif; ?>" href="#"><img src="/public/pc/images/user_icon2.png" alt="">邮箱绑定</a>
                                </div>
                                <div class="layui-col-md2">
                                    <a class="<?php if($uinfo['tx_pwd']): else: ?>not_set<?php endif; ?>" href="#" onclick="newTab('/pc/user/setpwd','修改密码')"><img src="/public/pc/images/user_icon3.png" alt="">密码保护</a>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md12">
                <div class="layui-col-md12">
                    <div class="layadmin-homepage-panel layadmin-homepage-shadow">
                        <div class="layui-card text-center">
                            <div class="layui-card-body">
                                <div class="balance_card_left_1">
                                    <img src="/public/pc/images/cash_icon.png" alt="">
                                </div>
                                <div class="balance_card_left_2">
                                    <p>账户余额（元）</p><h3><?php echo $uinfo['zj_cash']; ?></h3>
                                </div>
                                <div class="layui-col-md3">
                                    <a href="#" onclick="newTab('/pc/Tixian/add_tx','马上提现')" class="balance_card_right_1">马上提现</a>
                                    <a href="#" class="balance_card_right_2">提现记录</a>
                                </div>
                                <div class="clear"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md12">
                <div class="layui-col-md12">
                    <div class="layadmin-homepage-panel layadmin-homepage-shadow">
                        <div class="layui-card text-center">
                            <div class="layui-card-body">
                                <div class="balance_card_left_1">
                                    <img style="width: 38px;height: 35px;" src="/public/pc/images/api_icon3.png" alt="">
                                </div>
                                <div class="balance_card_left_2">
                                    <p>统计经营概况</p><h4><a href="javascript:;" onclick="showStatus()">点击查看</a></h4>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-col-md12">
                <div class="layui-col-md12">
                    <div class="layadmin-homepage-panel layadmin-homepage-shadow">
                        <div class="layui-card text-center">
                            <div class="layui-card-body">
                                <div class="layui-col-md6">
                                    <div class="hd_title"> 
                                        <div class="balance_card_left_1"><img style="width: 38px;height: 35px;" src="/public/pc/images/notice-img.png" alt=""></div>
                                        
                                        <div class="balance_card_left_2">
                                            <p>系统公告</p>
                                        </div>
                                        <a  href="#" onclick="n_list()">更多
                                            <img src="/public/pc/images/more.png" alt="">
                                        </a>
                                    </div>
                                    <div class="clear"></div>
                                    <ul class="notice_list">
                                        <?php foreach($notice as $v): ?>
                                        <li onclick="ninfo('<?php echo $v['id']; ?>')">
                                            <div class="notice_list_left"><a href="#"><?php echo $v['title']; ?>
                                            </a><p><?php echo $v['content']; ?></p></div>
                                            <div class="notice_list_right"><h3><?php echo $v['time1']; ?></h3><p><?php echo $v['time2']; ?></p></div>
                                            <div class="clear"></div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>



</div>
<style type="text/css">
    #dsfsdf{
        line-height: 30px;padding: 0 25px;
    }
</style>
<script src="/public/pc/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script>
   
    layui.use(['form','element'], function() {
        var form = layui.form,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
        var istop = "<?php echo $notice_one['is_top']; ?>";//公告置顶第一条弹出提示
        var is_truename="<?php echo $is_truename; ?>";//公告置顶第一条弹出提示
        if(is_truename==1){
            if(istop==1){
                ninfo("<?php echo $notice_one['id']; ?>");
            }
        }else{
            layer.open({
                type: 2,
                title: '实名认证',
                shadeClose: true,
                //skin: 'layui-layer-rim', //加上边框
                area: ['100%','90%'],//宽高
                content: '/pc/User/auth_name'
            });
        }
        $('.balance_card_right_2').click(function () {
            layer.open({
                type: 2,
                title: '提现记录',
                shadeClose: true,
                //skin: 'layui-layer-rim', //加上边框
                area: ['100%','90%'], //宽高
                content: '/pc/Tixian/lists'
            });
        })
    })
    function ninfo(id) {

        $.get('/ninfo?id='+id, {'show':1}, function(res){
            layer.open({
                // type: 1,
                title:[res.data.title, 'text-align:center'],
                shadeClose: true,
                area: ['100%','90%'],
                shade: 0.8,
                content: res.data.content,
                btn: ''
            });
        });
    }

     function n_list() {
        layer.open({
            type: 2,
            title:'公告列表',
            shadeClose: true,
            area: ['100%','90%'],
            shade: 0.8,
            content: '/notice',
        });
    }
    
    function showStatus(){
        layer.open({
            type: 2,
            title:'统计经营概况',
            shadeClose: true,
            area: ['100%','90%'],
            shade: 0.8,
            content: '/pc/user/show_status',
        });
    }
</script>


