<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/tixian/add_tx.html";i:1631282582;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;s:64:"/www/wwwroot/yaoxiaoka/application/pc/view/common/wap_beian.html";i:1623812844;}*/ ?>
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
    .bank_i{
        margin-left: 20px;
        margin-bottom: 10px;
        padding: 10px;
        background: #e4e4e4;
        border-radius: 5px;
    }
    .bank_i>H3{
        margin-bottom: 5px;
    }
    .captcha>img{
        width: 100px;
    }
</style>

<?php if($is_mobile==1): ?>
<link rel="stylesheet" href="//at.alicdn.com/t/font_1786378_02usjpdi4hev.css">
<style>
    .tip2{
        height: inherit;
    }
    .tab_bar_bottom{
        margin-bottom: 54px;
    }
    .tab_bar_nav{
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 44px;
        padding: 6px 0 4px 0;
        font-size: 12px;
        font-weight: 200;
        background: #fafafa;
    }
    .tab_bar_nav a{
        float: left;
        display: block;
        width: 20%;
        text-align: center;
        color: #b3b9c7;
    }
    .tab_bar_nav a>i{
        display: block;
        font-size: 24px;
        color: #b3b9c7;
    }
    .tab_bar_nav a.active{
        color: #5673ff;
        font-weight: 400;
    }
    .tab_bar_nav a.active>i{
        color: #5673ff;
    }
    .home_btn{
        display: inline-block;
        height: 52px;
        width: 52px;
        border-radius: 30px;
        border: 4px solid #fafafa;
        background-image: linear-gradient(0deg,
        #5673ff 9%,
        #88a2ff 100%);
        margin-top: -16px;
        text-align: center;
        line-height: 52px;
    }
    .home_btn>i{
        font-size: 55px;
        color: #fff;
    }
</style>
<div class="main_top">
    申请提现
    <a href="javascript:history.back(-1);" class="back"><img src="/public/wap/img/left_icon.png" alt=""></a>
    <a class="kf_right" href="mqqwpa://im/chat?chat_type=wpa&amp;uin=1828847938&amp;version=1&amp;src_type=web&amp;web_src="><img src="/public/wap/img/kf_icon.png" alt=""></a>
</div>
<?php endif; ?>
<form class="layui-form" action="">
    <div class="animated fadeInUp">
<!--        <div class="main_title" style="padding: 10px 20px">-->
<!--            &lt;!&ndash;                我要提现  <span>/  Withdraw Cash</span>&ndash;&gt;-->
<!--        </div>-->
        <div class="main_region_700" style="padding: 10px">
            <div class="balance_card_left_1"><img src="/public/pc/images/cash_icon.png" alt=""></div>
            <div class="balance_card_left_2">
                <p>账户余额（元）</p>
                <h3><?php echo $uinfo['zj_cash']; ?></h3>
            </div>
            <a href="#" class="layui-btn" style="float: right" id="card_logg">提现记录</a>
            <div class="clear"></div>
            <div class="balance_card_line"></div>
            <div class="cash_title">选择收款方式
                <?php if($yxk == 0 && $tx_config['need_kjt'] == '1'): ?>
                <font color="#ccc">(<font class="tixian_bt">添加提现方式</font>)</font>
                <?php endif; ?>
                <a href="javascript:void(0);" onclick="newTab('/pc/Tixian/bank_list','提现方式管理')">提现管理<img
                    src="/public/pc/images/more.png" alt=""></a>
            </div>
            <style type="text/css">
                .layui-form-select .layui-input {
                    padding-right: 30px;
                    cursor: pointer;
                    border: 0;
                }
            </style>
            <form id="formId" action="" method="post">
<!--                <input type="hidden" name="collId" value="">-->
                   
                    <div class="cash_input">
                       
                        <select name="banktype" id='banktype' lay-filter="banktype" lay-search="">
                            <option value="">--请选择提现方式--</option>
                            <?php foreach($bank_list as $key=>$vo): ?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo $bank_arr[$vo['bank']]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        
                    </div>
                    
                    <?php if($yxk == 0 && $tx_config['need_kjt'] == '1'): ?>
                    <div class="add_payment add_yhk">
                        <img src="/public/pc/images/add_icon.png" alt="">
                        <div class="payment_inf">
                            <h3>添加银行卡</h3>
                            <p>还未设置银行卡</p>
                        </div>
                    </div>
                    <?php endif; if($zfb == 0 && $tx_config['need_zfb'] == '1'): ?>
                    <div class="add_payment add_zfb">
                        <img src="/public/pc/images/add_icon.png" alt="">
                        <div class="payment_inf">
                            <h3>添加支付宝</h3>
                            <p>还未设置支付宝</p>
                        </div>
                    </div>
                    <?php endif; ?>
                  
                <div class="clear"></div>
                <div class="tip2 animated fadeInRight" style="display: block">
                    <?php if($is_mobile!=1): ?> 提现时间：9:00 - 23:00，<?php endif; ?>手续费<span class='blue sxf_class'><?php echo $tx_config['fee']; ?>元 /笔</span>，有问题找客服！
                </div>
                <div class="cash_title">提现金额</div>
                <input type="number" onkeyup='num(this)' class="cash_input" name="money" autocomplete="off" placeholder="请输入整数金额" autofocus>
                <div class="tip3 animated fadeInRight" style="display: block">最低金额<span class="red" id="minAmount">10.00</span>元
                    单笔提现不能超过<span class="red">50000</span>元(提现手续费将从填写的提现金额中扣除)
                </div>
                <div class="cash_title">提现密码</div>
                <input type="password" name="safecode" class="cash_input" <?php if(!$uinfo['tx_pwd']): ?>disabled<?php endif; ?> placeholder="请输入安全密码">
                <?php if(!$uinfo['tx_pwd']): ?>
                <div class="tip3">您还未设置提现密码，<a class="blue set_pass" style="text-decoration: underline">马上设置</a></div>
                <?php endif; if(\think\Session::get('tx_sms_code')==1): else: ?>
                <div class="cash_title">验证码</div>
                <input type="text" class="cash_input" name="captcha" value="" placeholder="请输入验证码" autocomplete="off">
                <span class="captcha"><img height="40" onclick="this.src='/admin/index/verify'"
                                           src="/admin/index/verify" alt="验证码"></span>
                <input type="text" name="telcode" class="cash_input" value="" placeholder="短信验证码"
                       autocomplete="off">
                <a id="yzm_btn" class="yzm layui-btn" onclick="getTelCode()">获取验证码</a>（<font id="tel" color="#ccc"><?php echo $uinfo['mobile']; ?></font>）
                <?php endif; ?>

            </form>
            <div class="layui-form-item">
<!--                <div class="layui-input-block"></div>-->
                    <button class="layui-btn" type="button" style="margin-left: 20%;width: 60%;margin-top: 10px;margin-bottom: 10px" onclick="submitSafe(this)">立即申请</button>

            </div>
        </div>
    </div>
</form>
<?php if($is_mobile==1): ?>
<div class="section5" style="margin-bottom: 50px"> 
<p style="text-align: center;"><a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.1xiaoka.com&from=label&code=90030"> <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a></p>
	<br>
<p style="text-align: center;font-size: 12px;color: #b3b9c7;">
    &nbsp;&nbsp;<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=44030402004298">粤公网安备：44030402004298号</a> <br /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://beian.miit.gov.cn/#/Integrated/index">ICP证&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：粤ICP备2020113587号</a>
    
</p>
<!-- <p style="margin-top: 20px;line-height: 19px;">
    要销卡平台-提供充值卡回收|点卡回收， 充值卡兑换|点卡兑换， 充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台
</p> -->
<div style="height: 27px;width: 100%;border-color: #e6e6e6;"></div>
<div class="tab_bar_nav">
    <!--active为当前页面选中效果-->
    <a href="/" ><i class="iconfont icon-home-smile-line"></i>首页</a>
    <a href="/pc/user/orders"><i class="iconfont icon-file-list--fill"></i>订单</a>
    <a href="/yk_card"><span class="home_btn"><i class="iconfont icon-maichu"></i></span></a>
    <a href="/pc/tixian/add_tx" class="active"><i class="iconfont icon-money-cny-circle-fill"></i>提现</a>
    <a href="/user/profile" ><i class="iconfont icon-user--fill"></i>我的</a>
</div>
<?php endif; ?>
<script>
    function num(obj){
        obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
        obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
    }
    var clickAble = true;

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
            var inter = window.setInterval(function () {
                $('#yzm_btn').html('重新获取（' + t + 's）');
                $('#yzm_btn').attr('disabled', true);
                t = t - 1;
            }, 1000);
            window.setTimeout(function () {
                clickAble = true;
                window.clearInterval(inter)
                $('#yzm_btn').html('获取验证码');
            }, 1000 * t);
            $.post("/pc/sign/sms", {tel: "<?php echo $uinfo['mobile']; ?>", type: 2, code: $captcha.val()}, function (ret) {
                if (ret.code === 1) {
                    layer.msg(ret.msg, {icon: 1});
                } else {
                    layer.msg(ret.msg, {icon: 5});
                    clickAble = true;
                    window.clearInterval(inter)
                    $('#yzm_btn').html('获取验证码');
                }
            }, 'json')
        }
    }

    function submitSafe(e) {
        if($('[name=safecode]').val()==''){
            layer.msg('提现密码不能为空', {icon: 5});return;
        }
        //var is_tixian="<?php echo $uinfo['is_tixian']; ?>";
        var tx_sms_code="<?php echo \think\Session::get('tx_sms_code'); ?>";
        if(tx_sms_code==1){

        }else{
            if($('[name=telcode]').val()==''){
                layer.msg('短信验证码不能为空', {icon: 5});return;
            }
        }

        var money=$('[name=money]').val();
        if(money<10 || money>50000){
            layer.msg('提现金额不能小于10元，大于50000元', {icon: 5});return;
        }
        $(e).addClass('layui-btn-disabled');
        $(e).css('pointer-events','none');
        $.post("/pc/Tixian/add_tx",  $('.layui-form').serialize(), function (ret) {
            if (ret.code === 1) {
                layer.msg(ret.msg, {icon: 1,time:2000},function () {
                    window.location.reload();
                });
            } else {
                layer.msg(ret.msg, {icon: 5});
            }
        }, 'json');
        
        setTimeout(function(){
            $(e).removeClass('layui-btn-disabled');
            $(e).css('pointer-events','')
        },"2000");
        
        return false;

    }

    layui.use('form', function () {
        var layer = layui.layer;
        var is_truename = "<?php echo $is_truename; ?>";
        var need_truename_auth = "<?php echo $tx_config['need_truename_auth']; ?>";
        if (is_truename != 1 && need_truename_auth == 1) {
            layer.open({
                type: 2,
                title: '实名认证',
                shadeClose: true,
                //skin: 'layui-layer-rim', //加上边框
                area: ['90%', '90%'], //宽高
                content: '/pc/User/auth_name'
            });
        }
        $('#card_logg').click(function () {
            if("<?php echo $is_mobile; ?>"==1){
                window.location.href='/pc/Tixian/lists';
            }else{
                layer.open({
                    type: 2,
                    title: '提现记录',
                    shadeClose: true,
                    area: ['80%', '80%'],
                    shade: 0.8,
                    content: '/pc/Tixian/lists',
                });
            }

        })
        $('.add_yhk,.tixian_bt').click(function () {
            layer.open({
                type: 2,
                title: '添加银行卡',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/pc/Tixian/bank/way_add/yhk',
            });
        })

        $('.add_zfb').click(function () {
            layer.open({
                type: 2,
                title: '添加支付宝',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/pc/Tixian/bank/way_add/zfb',
            });
        })
        $('.set_pass').click(function () {
            layer.open({
                type: 2,
                title: '设置密码',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/pc/User/setpwd?type=2',
            });
        })
        var form = layui.form;
        form.on('select(banktype)',function(data){
            let _item = $('#banktype option:selected').text()
            let sxf_alipay = '<?php echo $sxf_alipay; ?>';
            let sxf_bank = '<?php echo $sxf_bank; ?>';
            if(_item == '支付宝'){
                $('.sxf_class').html(sxf_alipay + '元 /笔')
            }else{
                $('.sxf_class').html(sxf_bank + '元 /笔')
            }
        })
        // $('#tx_list').click(function (){
        //     newTab();
        //     // layer.open({
        //     //     type: 2,
        //     //     title: '提现方式',
        //     //     shadeClose: true,
        //     //     area: ['80%', '80%'],
        //     //     shade: 0.8,
        //     //     content: '/pc/Tixian/bank_list',
        //     // });
        // })
    })
</script>