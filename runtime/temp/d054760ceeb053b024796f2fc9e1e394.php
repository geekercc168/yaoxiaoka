<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/user/auth_name.html";i:1622299690;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
    .face_btn{
        margin-top: 10px;
        text-align: center;
    }
</style>
<form class="layui-form" action="" style="width: 90%;padding: 5%;" id="form1">
    <div class="real"><img src="/public/pc/images/real.png" height="<?php if($is_mobile==1): ?>100<?php else: ?>180<?php endif; ?>" alt=""></div>
    <p class="real_name_modal_p1">为保障您的合法权益，请签署承诺书</p>
    <p class="real_name_modal_p2">为有效保障您的合法权益和正常合法经营，需实名认证并签署承诺书，才能<font color="red">绑定银行卡使用点卡回收服务及提现操作</font>，请您仔细阅读并签署！</p>
    <div class="smrz_list">
        <?php if($res['idcard'] && $res['status']==1): ?>
        <div class="tip4" style="color: green">恭喜！您已经实名认证成功</div>
        <div class="add_input" style="margin-top: 5px"><input type="text" name="truename" value="<?php echo $res['truename']; ?>" readonly placeholder="请输入真实姓名"></div>
        <div class="add_input"><input type="text" name="txt_card" placeholder="请输入身份证号" value="<?php echo $res['idcard']; ?>" readonly></div>
        <div class="auth_btn">
        <?php if(!$is_bank): ?>
        <button class="add_btn" type="button" onclick="location='/pc/Tixian/bank'">已认证,去绑卡>>></button>
        <?php else: ?>
        <button class="add_btn" type="button" onclick="location='/yk_card'">已认证,去销卡>>></button>
        <?php endif; ?>
        <button class="add_btn set_sm_btn"  type="button" id="update_truename">变更实名</button>
        </div>
        <?php else: ?>
        <div class="tip4">请输入与您银行卡一致的姓名和身份证号</div>
        <div class="add_input" style="margin-top: 5px"><input type="text" name="truename"  value="<?php if($res['status']==1): ?><?php echo $res['truename']; endif; ?>" placeholder="请输入真实姓名"></div>
        <div class="add_input"><input type="text" name="txt_card" placeholder="请输入身份证号" value="<?php if($res['status']==1): ?><?php echo $res['idcard']; endif; ?>"></div>
        <button class="add_btn" style="width: 100%" type="button" id="add_btn">立即绑定</button>
        <?php endif; ?>
    </div>
</form>
<!--  支付宝扫码弹窗  -->
<div class="modal sm_modal">
    <!--        <div class="close"></div>-->
    <!--        <div class="title_icon"><img src="/public/pc/images/acc_icon6.png" alt="承诺书"></div>-->
            <div class="title_txt"><h3>用户承诺书</h3><p>为有效保障您的合法权益，请及时签署</p></div>
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
<script src="/public/pc/js/jquery.qrcode.min.js?v=2021" type="text/javascript" charset="utf-8"></script>
<script>
    layui.use('form', function() {
        var form = layui.form;
        var layer = layui.layer;
        $('#update_truename').click(function () {
            layer.confirm('操作变更实名后您的销卡记录、提现记录、实名认证等信息将全部被清除且只保留余额，请慎重操作！！同一账户实名变更最多3次，确定变更实名吗？', function(index) {
                $.post("/pc/User/update_truename", function (data) {
                    if (data.code == 1) {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        layer.msg(data.msg, {icon: 1});
                        setTimeout(function () {
                            window.location.href='/sign/in';
                        }, 1000);
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }
                }, 'json')
            });

        })
        $('#add_btn').click(function (){
            $.post("/pc/User/auth_name", $('.layui-form').serialize(), function (data) {
                if (data.code == 1) {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    layer.msg(data.msg, {icon: 1});
                        setTimeout(function () {
                            if(data.data.status==1){
                                window.location.reload();
                            }else{
                                // 判断是否人脸
                                $('#form1').empty();
                                host = window.location.host;
                                var isLogin = "<?php echo \think\Session::get('uinfo.id'); ?>";
                                $('#sign_img').empty();
                                $('#sign_img').qrcode({'text':'http://'+host+'/pc/index/face_zfb?uid='+isLogin,'width':120,'height':120});
                                $('.mask').show();
                                setTimeout(function () {
                                    $('.sm_modal').addClass('modal_show');
                                },100);
                                return;
                            }
                        }, 1000);

                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            }, 'json')
        })
        $('.close').click(function () {
            $('.mask').hide();
            $('.modal').removeClass('modal_show');
            $( "input[name='truename']").val('');
            $( "input[name='txt_card']").val('');
            // window.location.reload();
        });
        $('.face_res').click(function (obj) {
            var v=$(this).attr('v');
            if(v==1){
                window.location.href='/pc/Tixian/bank';
            }else{
                window.location.reload();
            }
        })

    })
</script>
