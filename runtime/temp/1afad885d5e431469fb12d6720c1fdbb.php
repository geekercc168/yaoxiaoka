<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"/www/wwwroot/yaoxiaoka/application/pc/view/user/setpwd.html";i:1602480630;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
    .layui-form-label {
        /*width: 120px;*/
        /*float: left;*/
    }
    /*input[type="radio"]:enabled, input[type="radio"]:disabled{*/
    /*    opacity: inherit;*/
    /*}*/

</style>
<div class = 'outermost'>
    <form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">密码类型：</label>
        <div class="layui-input-block">
            <input type="radio" name="type" lay-filter="type" value="1" title="登录密码" <?php if($type=="1"): ?>checked<?php endif; ?>>
            <input type="radio" name="type" lay-filter="type"  value="2" title="提现密码" <?php if($type=="2"): ?>checked<?php endif; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label id="newpwd" class="layui-form-label"><?php if($type=="2"): ?>提现<?php else: ?>新登录<?php endif; ?>密码：</label>
        <div class="layui-input-inline">
            <input type="password" name="txt_newpwd" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label id="relpwd" class="layui-form-label">确认<?php if($type=="2"): ?>提现<?php else: ?>登录<?php endif; ?>密码：</label>
        <div class="layui-input-inline">
            <input type="password" name="txt_relpwd" value="" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">验证码：</label>
        <div class="layui-input-inline">
            <input type="text" name="captcha"  value="" autocomplete="off" class="layui-input">

        </div>
        <div class="layui-word-aux"><span class="captcha"><img height="40" id="tx_yzm" onclick="this.src='/admin/index/verify'"
                                                               src="/admin/index/verify" alt="验证码"></span></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">短信验证码：</label>
        <div class="layui-input-inline">
            <input type="text" name="telcode" value="" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-word-aux">
            <a id="yzm_btn" class="yzm layui-btn" onclick="getTelCode()">获取验证码</a>（<font id="tel" color="#ccc"><?php echo \think\Session::get('uinfo.mobile'); ?></font>）
        </div>
    </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type='button' lay-submit lay-filter="formDemo">立即提交</button>
<!--                <button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
            </div>
        </div>
    </form>
</div>
<script>
    var clickAble = true;
    var inter;
    /**
     * 发送短信验证码
     */
    function getTelCode() {

        if (!clickAble) {
            return false;
        } else {
            var $captcha = $('[name=captcha]');
            if ($captcha.val() === '') {
                layer.msg('请填写图形验证码');
                return;
            }
            clickAble = false;
            var t = 100;
            $('#yzm_btn').html('重新获取（' + t-- + 's）');
            inter = window.setInterval(function () {
                $('#yzm_btn').html('重新获取（' + t + 's）');
                $('#yzm_btn').attr('disabled', true);
                t = t - 1;
            }, 1000);
            window.setTimeout(function () {
                clickAble = true;
                window.clearInterval(inter)
                $('#yzm_btn').html('获取验证码');
            }, 1000 * t);
            if($(':radio[name="type"]:checked').val()==1){
                var type=5;
            }else{
                var type=6;
            }
            $.post("/pc/sign/sms", {tel: "<?php echo \think\Session::get('uinfo.mobile'); ?>", type: type, code: $captcha.val()}, function (ret) {
                if (ret.code === 1) {
                    layer.msg(ret.msg, {icon: 1});
                } else {
                    layer.msg(ret.msg, {icon: 5});
                    clickAble = true;
                    window.clearInterval(inter)
                    $('#yzm_btn').html('获取验证码');
                }
            },'json')
        }
    }
    layui.use('form', function(){
        var form = layui.form;
        form.on('radio(type)', function(data){
            var v=data.value;
            if(v==1){
               $('#newpwd').text('新登录密码：');
               $('#relpwd').text('确认登录密码：');
            }else{
                $('#newpwd').text('新提现密码：');
                $('#relpwd').text('确认提现密码：');
            }
            clickAble = true;
            window.clearInterval(inter);//清除定时器
            $('#yzm_btn').html('获取验证码');
            $('[name=captcha]').val('');
            $('[name=telcode]').val('');
            $('[name=txt_newpwd]').val('')
            $('[name=txt_relpwd]').val('')
            $('#tx_yzm').click();
        });
        form.on('submit(formDemo)', function (data) {
            if ($('[name=txt_newpwd]').val() === '') {
                layer.msg('请填写密码');
                return;
            }
            if ($('[name=txt_relpwd]').val() === '') {
                layer.msg('请填写确认密码');
                return;
            }
            if ($('[name=telcode]').val() === '') {
                layer.msg('请填写短信验证码');
                return;
            }
            $.post("/pc/User/setpwd", $('.layui-form').serialize(), function (data) {
                if (data.code == 1) {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    layer.msg(data.msg, {
                        icon: 1,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){
                                if(index){
                                    parent.window.location.reload();
                                    parent.layer.close(index);
                                }else{
                                    window.location.reload();
                                }
                            });
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            },'json')
        })
    });
</script>
