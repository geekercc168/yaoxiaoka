<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"/www/wwwroot/yaoxiaoka/application/pc/view/user/show_status.html";i:1615364700;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>

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
    .hd_title{
        margin: 17px 68px;
    }
</style>
<link rel="stylesheet" type="text/css" href="/public/pc/css/swiper.min.css" />
<div class="right">
    <div class="main animated fadeInUp">

        <div class="balance_card" style="width: 100%;padding: 0 0 20px 0;margin: 0px;">
         
            <div class="hd_title">今日回收状态 
                <a href="#" onclick="newTab('/pc/User/orders','销卡记录')">
                    更多<img src="/public/pc/images/more.png" alt="">
                </a>
                 <hr />
            </div>
            <ul class="hd_list">
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">待售（张）</p>
                    <h3><?php echo !empty($data['t_jy_ds']['bishu'])?$data['t_jy_ds']['bishu']:0; ?></h3>
                    <p class="p2">待售面额：<?php echo !empty($data['t_jy_ds']['miane'])?$data['t_jy_ds']['miane']:0; ?></p>
                </li>
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">已售（张）</p>
                    <h3><?php echo !empty($data['t_jy_cg']['bishu'])?$data['t_jy_cg']['bishu']:0; ?></h3>
                    <p class="p2">结算金额：<?php echo !empty($data['t_jy_cg']['jiesuane'])?$data['t_jy_cg']['jiesuane']:0; ?></p>
                </li>
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">失败订单（张）</p>
                    <h3><?php echo !empty($data['t_jy_sb']['bishu'])?$data['t_jy_sb']['bishu']:0; ?></h3>
                    <p class="p2">失败面额：<?php echo !empty($data['t_jy_sb']['miane'])?$data['t_jy_sb']['miane']:0; ?></p>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="hd_title">昨日回收状态 <hr /> </div>
            <ul class="hd_list">
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">待售（张）</p>
                    <h3><?php echo !empty($data['z_jy_ds']['bishu'])?$data['z_jy_ds']['bishu']:0; ?></h3>
                    <p class="p2">待售面额：<?php echo !empty($data['z_jy_ds']['miane'])?$data['z_jy_ds']['miane']:0; ?></p>
                </li>
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">已售（张）</p>
                    <h3><?php echo !empty($data['z_jy_cg']['bishu'])?$data['z_jy_cg']['bishu']:0; ?></h3>
                    <p class="p2">结算金额：<?php echo !empty($data['z_jy_cg']['jiesuane'])?$data['z_jy_cg']['jiesuane']:0; ?></p>
                </li>
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">失败订单（张）</p>
                    <h3><?php echo !empty($data['z_jy_sb']['bishu'])?$data['z_jy_sb']['bishu']:0; ?></h3>
                    <p class="p2">失败面额：<?php echo !empty($data['z_jy_sb']['miane'])?$data['z_jy_sb']['miane']:0; ?></p>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="hd_title">提现数据 <hr /></div>
            <ul class="hd_list" style="margin-left: 28px;">
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">今日提现成功次数</p>
                    <h3><?php echo !empty($data['t_tx_res']['tx_bishu'])?$data['t_tx_res']['tx_bishu']:0; ?></h3>
                    <p class="p2">金额：<?php echo !empty($data['t_tx_res']['tx_cash'])?$data['t_tx_res']['tx_cash']:0; ?></p>
                </li>
                <li>
                    <p class="p1"><img src="/public/pc/images/order_icon.png" alt="">昨日提现成功次数</p>
                    <h3><?php echo !empty($data['z_tx_res']['tx_bishu'])?$data['z_tx_res']['tx_bishu']:0; ?></h3>
                    <p class="p2">金额：<?php echo !empty($data['z_tx_res']['tx_cash'])?$data['z_tx_res']['tx_cash']:0; ?></p>
                </li>
            </ul>
        </div>
        
        <div class="clear"></div>
    </div>
</div>
<style type="text/css">
    #dsfsdf{
        line-height: 30px;padding: 0 25px;
    }
</style>
<script src="/public/pc/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    
    function ninfo(id) {

        $.get('/ninfo?id='+id, {'show':1}, function(res){
            layer.open({
                // type: 1,
                title:[res.data.title, 'text-align:center'],
                shadeClose: true,
                area: ['50%', '50%'],
                shade: 0.8,
                content: res.data.content
            });
        });
    }
    
    function showStatus(){
        layer.open({
            type: 2,
            title:'统计经营概况',
            shadeClose: true,
            area: ['80%', '80%'],
            shade: 0.8,
            content: '/pc/user/show_status',
        });
    }
</script>


