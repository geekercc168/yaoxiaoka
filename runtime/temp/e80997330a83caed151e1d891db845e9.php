<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"/www/wwwroot/yaoxiaoka/application/admin/view/member/louka.html";i:1598424800;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
    .zy {
        font-size: 20px;
        color: red;
        font-weight: bold;
    }
</style>
<div class='outermost'>
    <div class="layui-card-header" style='border-bottom: none;'>
        <fieldset class="layui-elem-field layui-field-title" style="    margin-top: -7px;">
            <legend>漏卡查询</legend>
        </fieldset>
    </div>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-inline">
                <input type="text" class="layui-input" id="txt_uid" placeholder="用户id">
            </div>
            <div class="layui-inline">
                <input type="text" class="layui-input" id="test1" placeholder="提交时间(默认当天)">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <textarea class="layui-textarea"  id='txt_cardnum' lay-verify="txt_cardnum"
                          style="width:670px;height: 300px"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
        <div class="layui-inline" style="margin: 0px;width: 320px">
            <input type="text" class="layui-input" id="c_str" placeholder="" style="height: 32px;">
        </div>
            <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" onclick="del_ext_str();">去除该字符</button>
            <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" onclick="reset_textarea();" >重置</button>
        </div>
        <div class="layui-form-item" style="font-size: 16px">
            <label class="layui-form-label"></label> 已经输入 <font class="zy" id="total">0</font> 张
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type='button' lay-submit lay-filter="formDemo">漏卡查询</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script>

    //监听提交
    layui.use(['layer', 'form', 'table', 'laydate'], function () {
        var layer = layui.layer, form = layui.form, table = layui.table;
        var laydate = layui.laydate;
        //日期范围
        laydate.render({
            elem: '#test1'
            , range: true
            , max: 0
            ,value: '<?php echo $now; ?> - <?php echo $now; ?>'
        });



        //监听提交
        form.on('submit(formDemo)', function (data) {
            var s = jQuery.trim($("#txt_cardnum").val());
            var txt_uid = $("#txt_uid").val();
            if(!s){var	s = $("#txt_cardnum").html();}
            if (s == '') {
                layer.msg("请输入卡号和密码", {icon: 5});
                $('#txt_cardnum').focus();
                return false;
            }
            $.post("/admin/Member/louka", {
                sub : 1,
                txt_cardnum :s,
                search_time :$('#test1').val(),
                txt_uid:txt_uid
            }, function(json) {
                if (json.code == '1') {
                    $('#txt_cardnum').val(json.data);
                    check_card();
                } else {
                    layer.msg(json.msg, {icon: 5});
                    //artDialog(json.msg);
                }

            }, 'json');
            return false;
        });
    });
    //监听键盘按键
    $(document).keydown(function(e){
        check_card();
    });


    //监听键盘按键释放
    $(document).keyup(function(e){
        check_card();
    });

    //监听鼠标
    $("body").click(function(){
        check_card();
    });

    //选择金额
    $(".cash").click(function (){
        var cash = $(this).attr("money");
        $(".cash").removeClass("select_a");
        $(this).addClass("select_a");
        $("#slt_cash").html(cash);
        $("#hdn_cash").val(cash);
    });

    //检测已经输入多少行
    function check_card(){
        var s = jQuery.trim($("#txt_cardnum").val());
        if(!s){var	s = $("#txt_cardnum").html();}

        if(s.indexOf("\n") > 0 ){
            var re = new RegExp("\n","g");
            var arr = s.match(re);
            var total = arr.length+1;
            if(total>=301){
                layer.msg("每次最多提交300张", {icon: 5});
                return;
            }
            $("#total").html(total);
        }else{
            $("#total").html('1');
        }

    }

    //去除字符
    function del_ext_str(){
        var repalce_str = $("#c_str").val();
        var str = $("#txt_cardnum").val();
        var reg = new RegExp(repalce_str,"g");
        var new_str = str.replace(reg,"");
        $("#txt_cardnum").val(new_str);

    }
    //重置
    function reset_textarea(){
        $("#txt_cardnum").val("");
        $("#txt_cardnum").html("");
    }
</script>
<script>

</script>