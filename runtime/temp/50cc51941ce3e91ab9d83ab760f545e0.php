<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/www/wwwroot/yaoxiaoka/application/admin/view/agent/add_agent.html";i:1618379135;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<link rel="stylesheet" href="/public//static/admin/kindeditor/themes/default/default.css"/>
<script charset="utf-8" src="/public//static/admin/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public//static/admin/kindeditor/lang/zh_CN.js"></script>
<div class = 'outermost'>
<form class="layui-form" action="">

    <div class="layui-form-item">
        <label class="layui-form-label">会员账号</label>
        <div class="layui-input-inline">
            <input type="text" name="truename" id='truename' value="" lay-verify="required"
                   placeholder="请输入会员账号" autocomplete="off" class="layui-input">
        </div>

    </div>
    
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" type='submit' lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
</div>

<script>
    //Demo
    layui.use('form', function () {
        var form = layui.form;

        //监听提交
        layui.use(['layer', 'form', 'table'], function () {
            var layer = layui.layer, form = layui.form, table = layui.table;
            //监听提交
            form.on('submit(formDemo)', function (data) {
                $.post("/admin/agent/add_agent", $('.layui-form').serialize(), function (data) {
                    if (data.code == 1) {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        layer.msg(data.msg, {icon: 1});
                        setTimeout(function () {
                            parent.layer.close(index);
                            //修改成功刷新父页面
                            if ($('#id').val()) {
                                window.parent.location.reload();
                            } else {
                                //添加页面直接返回上一页并刷新
                                window.location.reload();
                            }

                        }, 1000); //再执行关闭

                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }
                }, 'json')
                return false;
            });
        });
    });
</script>
<script>
    KindEditor.ready(function (K) {
        kd = K.create('.tid', {
            'resizeType': '0',
            'items': [
                'source', 'preview', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull',
                , '|', 'fullscreen', '|', 'fontname', 'fontsize', 'forecolor', 'bold', 'italic', 'underline', '|', 'image', 'multiimage', '|', 'emoticons', 'baidumap', '|', 'link', 'unlink'
            ],
        });
    });

    KindEditor.ready(function (K) {
        var editor1 = K.create('textarea[name="content1"]', {
            allowFileManager: true,
            filterMode: false,
            afterBlur: function () {
                this.sync();
            }
        });
    });

</script>