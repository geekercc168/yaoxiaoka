<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"/www/wwwroot/yaoxiaoka/application/admin/view/finance/config.html";i:1631282432;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<body>
<div class = 'outermost'>
	<style type="text/css">
		body{
			margin: 10px 10px 10px 10px; 
			background: white;
		}
	</style>
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	    <legend>提现设置</legend>
	</fieldset>
	<!-- 功能栏 -->
	<form class="layui-form layui-form-pane" method='post' action="">
		<div class="layui-form-item">
			<label class="layui-form-label">手续费</label>
			<div class="layui-input-inline">
				<input type="number" name="txt_fee" required lay-verify="required" placeholder="请输入手续费" autocomplete="off" class="layui-input" value="<?php echo $item['fee']; ?>">
			</div>
		</div>
<!--		<div class="layui-form-item">-->
<!--			<label class="layui-form-label">实名认证</label>-->
<!--			<div class="layui-input-block" style='line-height: 36px;'>-->
<!--				<div class="layui-input-inline">-->
<!--					<input type="radio" name="need_truename_auth" <?php if($item['need_truename_auth']=="1"): ?> checked<?php endif; ?> value="1" title="开启">-->
<!--					<input type="radio" name="need_truename_auth" <?php if($item['need_truename_auth']!="1"): ?> checked<?php endif; ?> value="0" title="关闭">-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
		<div class="layui-form-item">
			<label class="layui-form-label">人脸识别</label>
			<div class="layui-input-block" style='line-height: 36px;'>
				<div class="layui-input-inline">
					<input type="radio" name="need_face" <?php if($item['need_face']=="1"): ?> checked<?php endif; ?> value="1" title="开启">
					<input type="radio" name="need_face" <?php if($item['need_face']!="1"): ?> checked<?php endif; ?> value="0" title="关闭">
				</div>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">KJT</label>
			<div class="layui-input-block" style='line-height: 36px;'>
				<div class="layui-input-inline">
					<input type="radio" name="need_kjt" <?php if($item['need_kjt']=="1"): ?> checked<?php endif; ?> value="1" title="开启">
					<input type="radio" name="need_kjt" <?php if($item['need_kjt']!="1"): ?> checked<?php endif; ?> value="0" title="关闭">
				</div>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">ZFB</label>
			<div class="layui-input-block" style='line-height: 36px;'>
				<div class="layui-input-inline">
					<input type="radio" name="need_zfb" <?php if($item['need_zfb']=="1"): ?> checked<?php endif; ?> value="1" title="开启">
					<input type="radio" name="need_zfb" <?php if($item['need_zfb']!="1"): ?> checked<?php endif; ?> value="0" title="关闭">
				</div>
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block" style='padding-bottom: 15px;'>
				<button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
			</div>
		</div>
	</form>
</div>
<script>
layui.use(['layer', 'form', 'table'], function(){
 	var layer = layui.layer,form = layui.form , table = layui.table;
 	//监听提交
	form.on('submit(formDemo)', function(data){
		$.post("/admin/Finance/config",$('.layui-form').serialize(),function(data){
			if(data.code==1){
				var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
				layer.msg(data.msg, {icon: 1});
				setTimeout(function(){
					parent.layer.close(index);
					//修改成功刷新父页面
					if($('#categ_id').val()){
						window.parent.location.reload();
					}else{
						//添加页面直接返回上一页并刷新
						window.location.reload();
					}

				},1000); //再执行关闭

			}else{
				layer.msg(data.msg, {icon: 5});
			}
		},'json')
		return false;
	});
	// 权限选择监听
});
</script>
</body>
</html>