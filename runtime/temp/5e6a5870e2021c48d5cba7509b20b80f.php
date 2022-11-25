<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/www/wwwroot/yaoxiaoka/application/admin/view/admin/admin_add.html";i:1598519868;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<style type="text/css">
    body {
        margin: 10px 10px 10px 10px;
        padding: 10px 10px 10px 10px;
        background-color: white;
    }

    .layui-form {
        width: 1100px;
        padding-top: 10px;
    }

    .layui-form-label {
        width: 100px;
        float: left;
    }

    .layui-input-block {
        margin-left: 0px;
        width: 570px;
        float: left;
    }

    .layui-form-mid {
        margin-left: 15px;
    }

    .red {
        color: red;
    }
</style>
<h1>
    <span style='line-height: 40px;margin-left: 10px;'></span>
    <button class="layui-btn layui-btn-primary layui-btn-sm"><a href="/admin/admin/admin_list">管理员列表</a></button>
</h1>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">所属用户组</label>
        <div class="layui-input-block">
            <select name="group_id" id='group_id' lay-verify="required" lay-search="">
                <?php foreach($list as $vo): ?>
                <option value="<?php echo $vo['group_id']; ?>" <?php if($item['group_id']==$vo['group_id']): ?> selected <?php endif; ?>><?php echo $vo['groupname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录用户名</label>
        <div class="layui-input-block">
            <input type="text" name="username" id='username' value="<?php echo $item['username']; ?>" required lay-verify="username"
                   placeholder="请输入用户名称" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"><span class='red'>*&nbsp;&nbsp;</span>以英文字母开头，只能包含英文字母、数字、下划线</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" id='password' value="<?php echo $item['password']; ?>" lay-verify="pass"
                   placeholder="请输入登录密码" autocomplete="on" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"><span class='red'>*&nbsp;&nbsp;</span>密码必须大于6位，小于15位</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">用户邮箱</label>
        <div class="layui-input-block">
            <input type="text" name="email" id='email' value="<?php echo $item['email']; ?>" placeholder="请输入用户邮箱" autocomplete="on"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机号码</label>
        <div class="layui-input-block">
            <input type="text" name="moblie" id='moblie' value="<?php echo $item['moblie']; ?>" placeholder="请输入手机号码" autocomplete="on"
                   class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">真实姓名</label>
        <div class="layui-input-block">
            <input type="text" name="truename" id='truename' value="<?php echo $item['truename']; ?>" placeholder="请输入真实姓名"
                   autocomplete="on" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" type='submit' lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <input type="hidden" name='id' id='userid' value="<?php echo $item['userid']; ?>">
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use('form', function () {
        var form = layui.form;
        var layedit = layui.layedit;
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '标题至少得5个字符啊';
                }
            }
            , uid: [/^[1-9]\d*$/, '只能是整数哦']
            , pass: [/(.+){6,15}$/, '密码必须6到15位']
            , content: function (value) {
                layedit.sync(editIndex);
            }

            , username: [/^[a-zA-Z][a-zA-Z0-9_]*$/, '以英文字母开头，只能包含英文字母、数字、下划线']
            , content: function (value) {
                layedit.sync(editIndex);
            }
        });
        //监听提交
        form.on('submit(formDemo)', function (data) {
            $.post("/admin/Admin/admin_add", $('.layui-form').serialize(), function (data) {
                if (data.code == 1) {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    layer.msg(data.msg, {icon: 1});
                    setTimeout(function () {
                        parent.layer.close(index);
                        //修改成功刷新父页面
                        if ($('#userid').val()) {
                            window.parent.location.reload();
                        } else {
                            //添加页面直接返回上一页并刷新
                            //window.location.href="/admin/Admin/admin_list";
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
</script>