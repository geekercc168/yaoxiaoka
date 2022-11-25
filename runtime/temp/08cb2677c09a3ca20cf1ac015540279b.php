<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"/www/wwwroot/yaoxiaoka/application/pc/view/tixian/bank.html";i:1623045351;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
    .layui-form-item{
        margin-bottom: 10px;
    }
</style>
<div class = 'outermost'>
    <div class="layui-card-header" style='border-bottom: none;'>
        <fieldset class="layui-elem-field layui-field-title" style="    margin-top: -7px;">
            <legend>编辑银行卡</legend>
        </fieldset>
    </div>
    <form class="layui-form" action="">
        <?php if(($way_add == 'yhk')): ?>
        <div class="yhk">
        <div class="layui-form-item">
            <label class="layui-form-label">选择银行</label>
            <div class="layui-input-inline">
                <select name="banktype" id='banktype' lay-verify="" lay-search="">
                    <option value="">--请选择提现方式<?php echo $item['bank']; ?>--</option>
                    <?php foreach($bank_arr as $k=>$v): ?>
                    <option value="<?php echo $k; ?>" <?php if($item['bank']==$k): ?> selected <?php endif; ?>><?php echo $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">收款人姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_truename" id="txt_truename"  value="<?php echo $res['truename']; ?>" lay-verify=""
                       placeholder="请输入收款人姓名" autocomplete="off" class="layui-input" readonly>
            </div>
                <div class="layui-form-mid layui-word-aux"><span style='color: red'>*</span>&nbsp收款人姓名需与实名信息一致，如要换其他收款人请新注册账号</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">提现账号</label>
            <div class="layui-input-inline" >
                <input type="text" name="nums" id='nums' value="<?php echo $item['bank_number']; ?>" lay-verify=""
                       placeholder="请输入提现账号" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span style='color: red'>*</span>必填项</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认账号</label>
            <div class="layui-input-inline" >
                <input type="text" name="rel_nums" id='rel_nums' value="<?php echo $item['bank_number']; ?>" lay-verify=""
                       placeholder="请输入确认账号" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"><span style='color: red'>*</span>必填项</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属银行</label>
            <div class="layui-input-inline" >
                <input type="text" name="bankname" id='bankname' value="<?php echo !empty($item['bankname'])?$item['bankname'] : ''; ?>"
                       placeholder="请输入所属银行" autocomplete="off" class="layui-input">
            </div>
        </div>
        </div>
        <?php endif; if(($way_add == 'zfb')): ?>
        <div class="zfb" style="display:">
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="zfb_txt_truename" id="zfb_txt_truename"  value="<?php echo $res['truename']; ?>" lay-verify=""
                           placeholder="请输入收款人姓名" autocomplete="off" class="layui-input" readonly>
                </div>
                    <div class="layui-form-mid layui-word-aux"><span style='color: red'>*</span>&nbsp收款人姓名需与实名信息一致，如要换其他收款人请新注册账号</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">支付宝账号</label>
                <div class="layui-input-inline" >
                    <input type="text" name="zfb_nums" id='zfb_nums' value="<?php echo $item['zfb_number']; ?>" lay-verify=""
                           placeholder="请输入支付宝账号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux"><span style='color: red'>*</span>支付宝登录账号</div>
            </div>
        </div>
        <?php endif; ?>
        <div class="layui-form-item">
            <label class="layui-form-label">默认提现</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="swmr" value="1" lay-skin="switch" lay-text="是|否" <?php if($item['type']=="1" || !($item['id'])): ?> checked="checked"<?php endif; ?>>
            </div>
        </div>
        <input type="hidden" name='id' id='id' value="<?php echo $item['id']; ?>">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type='button' lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
</div>

<script>
    //监听提交
    layui.use(['layer', 'form', 'table'], function () {
            var layer = layui.layer, form = layui.form, table = layui.table;
            var status="<?php echo $res['status']; ?>";
            if(status!=1){
                //没有则打开实名页面
                window.location.href='/pc/User/auth_name';
            }
            //监听提交
            form.on('submit(formDemo)', function (data) {
                var bankno = $("#nums").val();
                var bankno_r = $("#rel_nums").val();

                if(data.field.tx_way == 1){

                    if(bankno == "" || bankno_r == "" ) {
                        layer.msg("请填写银行卡号");
                        return false;
                    }

                    if(!$('#txt_truename').val()) {
                        layer.msg("请填写收款人姓名，请确保姓名与实名信息一致");
                        return false;
                    }

                    var num = /^\d*$/; //全数字
                    if(!num.exec(bankno) || !num.exec(bankno_r)) {
                        layer.msg("银行卡号必须全为数字");
                        return false;
                    }
                    if(bankno.length < 16 || bankno.length > 19 || bankno_r.length < 16 || bankno_r.length > 19) {
                        layer.msg("银行卡号长度必须在16到19之间");
                        return false;
                    }

                    //开头6位
                    var strBin = "10,18,30,35,37,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,58,60,62,65,68,69,84,87,88,94,95,98,99";
                    if(strBin.indexOf(bankno.substring(0, 2)) == -1 || strBin.indexOf(bankno_r.substring(0, 2)) == -1) {
                        layer.msg("银行卡号开头6位不符合规范");
                        return false;
                    }
                }else{
                    var zfb = $("#zfb_nums").val();
                    if(zfb == "") {
                        layer.msg("请填写支付宝账号");
                        return false;
                    }
                }
                $.post("/pc/Tixian/bank", $('.layui-form').serialize(), function (data) {
                    if (data.code == 1) {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        layer.msg(data.msg, {
                            icon: 1,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                            parent.window.location.reload();
                            parent.layer.closeAll();
                        });

                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }
                }, 'json')
            })

            form.on('switch(tx_way)', function(data){
                var tx_way = data.elem.checked;
                if(tx_way === true){
                    $('.zfb').hide();
                    $('.yhk').show();
                }
                if(tx_way === false){
                    $('.zfb').show();
                    $('.yhk').hide();
                }

            })

        });


</script>