<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/www/wwwroot/yaoxiaoka/application/admin/view/index/index.html";i:1614826932;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<style>
    html{
        height: 100%;/*background-color: #6FAAFF;*/
        background-image: url('/public/static/admin/img/bg.png');
    }
    .layui-input{
        border-radius: 25px;
    }
    .input{
        border: none;
        padding: 15px 20px;
        border-radius: 25px;
        background: rgba(255,255,255,.1);    
        width: 100%;
        color: #fff;
        display: block;
        outline: none;
        text-indent: 1em;
    }
</style>
<body style=''>
  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
    <div></div>
    <div class="layadmin-user-login-main" >
        <div style='border: 1px solid;opacity: 0.2; background-color: black; background-size: 170% 210%;    background-position: 53% 49%; margin-top: 145px;border-radius: 10px;width: 619px; height: 360px;top: 100px;margin: auto;'></div>
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2 style=''>要销卡平台</h2>
        <!-- <p></p> -->
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          <input type="text" name="username" id="LAY-user-login-username" lay-verify="required" placeholder="用户名"  value="" class=" username input" style=''>
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="密码" value="" class="input password">
        </div>
        <?php echo token(); ?>

        <!-- <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs5">
              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
              <input type="text" name="vercode" id="LAY-user-login-vercode" placeholder="图形验证码" class="input" maxlength="4">
            </div>
            <div class="layui-col-xs7">
              <div style="margin-left: 10px;">
                <img src="<?php echo url('index/verify'); ?>" class="input " id="refreshCaptcha" style="height: 50px;padding: 0px 0px;margin-left: 40px;">
              </div>
            </div>
          </div>
        </div> -->
        
        <div class="layui-form-item" style='width: 415px;'>
          <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit" style='background-color: #1161ee;border-radius: 25px; height: 46px; margin-top: 10px;'>登 入</button>
        </div>
      </div>
    </div>
    
  </div>

  <script>

    $('#refreshCaptcha').click(function() {
        $(this).attr('src', "<?php echo url('/admin/index/verify/'); ?>"+Math.random());
    })
    function refreshCaptcha(){
        $('#refreshCaptcha').attr('src', "<?php echo url('/admin/index/verify/'); ?>"+Math.random());
    }

    // 点击回车登录
    $(document).keyup(function(event){
        if(event.keyCode ==13){
            $(".layui-btn-fluid").trigger("click");
        }
    });
    layui.config({
    base: '/public/static/admin/layuiadmin/' //静态资源所在路径
    }).extend({
    index: 'lib/index' //主入口模块
    }).use(['index', 'user'], function(){
        var $ = layui.$
        ,setter = layui.setter
        ,admin = layui.admin
        ,form = layui.form
        ,router = layui.router()
        ,search = router.search;

        form.render();

    // 点击登录
    form.on('submit(LAY-user-login-submit)', function(obj){
      
        var username = $(".username").val();
        var password = $(".password").val();
        var vercode  = $(".vercode").val();
        if(!username){
            layer.msg('请输入登录账号',{icon:2,time:1000});
        }else if(!password){
            layer.msg('请输入登录密码',{icon:2,time:1000});
        }else{
            layer.msg('登陆中', {icon: 16,time:false});
            $.post("/admin/index/login",{username:username,password:password,vercode:obj.field.vercode,__token__:obj.field.__token__},function(data){
                layer.closeAll();
                var i = eval("("+data+")");
                if(i.status == 1){
                    layer.msg(i.tips,{icon:1,time:1000});
                    setTimeout(function() {
                        window.location.href="/admin/main/index";
                    }, 1000);
                }else{
                  
                    layer.msg(i.tips,{icon:2,time:1000});
                    $("input[name='__token__']").val(i.token);
                    refreshCaptcha();
                }
            })
        }
    });

  });
  </script>
</body>
</html>