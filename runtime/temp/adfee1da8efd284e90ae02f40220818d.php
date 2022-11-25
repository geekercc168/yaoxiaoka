<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"/www/wwwroot/yaoxiaoka/application/admin/view/member/user_profit.html";i:1601190352;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
    .profit_table th,td{
        text-align: center;
    }
</style>
<div class = 'outermost'>
<form class="layui-form" action="">
    <table class="layui-table profit_table">
        <tr>
            <th>卡品牌</th>
            <th>卡类型</th>
            <th>默认费率</th>
            <th>用户指定费率</th>
            <th>卡种状态</th>
            <th>操作</th>
        </tr>
        <?php foreach($list as $v): ?>
        <tr>
            <td><?php echo $v['title']; ?></td>
            <td><?php if($v['card_type']==1): ?>话费卡<?php elseif($v['card_type']==2): ?>游戏卡<?php elseif($v['card_type']==3): ?>加油卡<?php elseif($v['card_type']==4): ?>商超卡<?php elseif($v['card_type']==5): ?>电商卡<?php elseif($v['card_type']==6): ?>影视卡<?php endif; ?></td>
            <td><?php echo $v['zc_profit']; ?></td>
            <td><input type="number" step="0.01" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="<?php echo $v['user_profit']; ?>" id="type<?php echo $v['id']; ?>"></td>
            <td><?php if($v['status']==1): ?><font color="green">开启</font><?php else: ?><font color="red">关闭</font><?php endif; ?></td>
            <td><button type="button" class="layui-btn layui-btn-xs set_pro" tid="<?php echo $v['id']; ?>">保存</button></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <input type="hidden" name='uid' id='uid' value="<?php echo $uid; ?>">
</form>
</div>

<script>
    //Demo
    layui.use('form', function () {
        $('.set_pro').click(function () {
            var dk_id=$(this).attr('tid');
            $.post("/admin/Member/user_profit", {
                'uid':$('#uid').val(),
                'dk_id':dk_id,
                'profit':$('#type'+dk_id).val(),
            }, function (data) {
                if (data.code == 1) {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    layer.msg(data.msg, {icon: 1,time:1500},function () {
                        parent.layer.close(index);
                        window.parent.location.reload();
                    });
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            }, 'json')
            return false;
        })
    })

</script>