$(function() {
    $('input').blur(function() {
        $(this).val($.trim($(this).val()));
    });
});
$('.pw_hide').click(function () {
    if (!$(this).hasClass('pw_show')) {
        $(this).addClass('pw_show icon-browse_fill').removeClass('icon-browse');
        $(this).siblings('input').prop('type', 'text');
    } else {
        $(this).addClass('icon-browse').removeClass('pw_show icon-browse_fill');
        $(this).siblings('input').prop('type', 'password');
    }
});

var timeoutObj;
function showErr(msg) {
    $('#message_tip').hide();
    $('#message_tip').html(msg);
    $('#message_tip').removeClass('success_tip');
    $('#message_tip').addClass('error_tip');
    $('#message_tip').show();
    try { clearTimeout(timeoutObj); } catch (e) {}
    timeoutObj = setTimeout(function () { $('#message_tip').hide(); }, 5000);
}
function showOk(msg) {
    $('#message_tip').hide();
    $('#message_tip').html(msg);
    $('#message_tip').removeClass('error_tip');
    $('#message_tip').addClass('success_tip');
    $('#message_tip').show();
    try { clearTimeout(timeoutObj); } catch (e) {}
    timeoutObj = setTimeout(function () { $('#message_tip').hide(); }, 5000);
}

/**
 * 用户名
 */
var userNameTime
function checkUserName() {
    clearTimeout(userNameTime);
    var $that = $('[name=username]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        //layer.msg('手机号还没有输入哦!',{coin:5});
        layer.tips('用户名还没有输入哦!',$that,{tips: 3});
        // showTips($that, "手机号还没有输入哦!")
        return false;
    }
    var pattern = /^[A-Za-z0-9]{6,20}/;
    if (!pattern.test($that.val())) {
        layer.tips('请输入6-20位字母或数字组成的登录用户名!',$that,{tips: 3});
        //showTips($that, "手机号格式错误!")
        //layer.tips('手机号格式错误!',$that,{tips: 3});
        return false;
    }
    //hideTips($that);
    return true;
}
/**
 * 手机号
 */
var TelTime
function checkTel() {
    clearTimeout(TelTime);
    var $that = $('[name=tel]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        //layer.msg('手机号还没有输入哦!',{coin:5});
        layer.tips('手机号还没有输入哦!',$that,{tips: 3});
        // showTips($that, "手机号还没有输入哦!")
        return false;
    }
    var pattern = /^1[3456789]\d{9}$/;
    if (!pattern.test($that.val())) {
        //showTips($that, "手机号格式错误!")
        layer.tips('手机号格式错误!',$that,{tips: 3});
        return false;
    }
    //hideTips($that);
    return true;
}

/**
 * QQ
 */
var QQTime;
function checkQQ() {
    clearTimeout(QQTime);
    var $that = $('[name=qqnumber]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        //$that.siblings('.tip_msg').html('请输入QQ号码');
        layer.tips('请输入QQ号码!',$that,{tips: 3});
        return false;
    }
    var pattern = /^[1-9][0-9]{4,15}$/;
    if (!pattern.test($that.val())) {
        //$that.siblings('.tip_msg').html('QQ格式错误');
        layer.tips('QQ格式错误!',$that,{tips: 3});
        return false;
    }
    return true;
}


/**
 * 邮箱
 */
var emailTime;
function checkEmail() {
    clearTimeout(emailTime);
    var $that = $('[name=email]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        //$that.siblings('.tip_msg').html('请输入邮箱地址');
        layer.tips('请输入邮箱地址!',$that,{tips: 3});
        return false;
    }
    var pattern = /\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/;
    if (!pattern.test($that.val())) {
        //$that.siblings('.tip_msg').html('邮箱格式错误');
        layer.tips('邮箱格式错误!',$that,{tips: 3});
        return false;
    }
    return true;
}

/**
 * 密码
 */
var userPassTime;
function checkUserPass() {
    clearTimeout(userPassTime);
    var $that = $('[name=userpass]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        layer.tips('请输入密码',$that,{tips: 3});
        //showTips($that, "请输入密码");
        return false;
    }
    var pattern = /^[A-Za-z0-9]{6,20}/;
    if (!pattern.test($that.val())) {
        layer.tips('请输入6-20位字母或数字组成的密码!',$that,{tips: 3});
        //showTips($that, "请输入6-20位字母或数字组成的密码");
        return false;
    }
    //hideTips($that);
    return true;
}

/**
 * 手机验证码
 */
var telcodeTime;
function checkTelCode() {
    clearTimeout(telcodeTime);
    var $that = $('[name=telcode]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        layer.tips('短信验证码还未填写哦!',$that,{tips: 3});
        //showTips($that, "短信验证码还未填写哦!")
        return false;
    }
    return true;
}

/**
 * 图形验证码
 */
var piccodeTime;
function checkPicCode() {
    clearTimeout(piccodeTime);
    var $that = $('[name=piccode]');
    $that.val($.trim($that.val()));
    $that.siblings('.tip_msg').hide();
    if ($that.val() === '') {
        $that.siblings('.tip_msg').html('请输入图片验证码');
        $that.siblings('.tip_msg').show();
        piccodeTime = setTimeout(function () {
            $that.siblings('.tip_msg').fadeOut();
        }, 3000);
        return false;
    }
    return true;
}


function showTips(param, tips) {
    $(param).attr("title", tips);
    $(param).tipso({
        useTitle: true,
        background: 'tomato'
    });
    $(param).tipso('show');
}

function hideTips(event) {
    setTimeout(function () {
        $(event).tipso('hide');
    }, 500);
}