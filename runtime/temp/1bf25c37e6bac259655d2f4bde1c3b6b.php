<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"/www/wwwroot/yaoxiaoka/application/admin/view/member/login_log.html";i:1599707870;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
	.layui-btn+.layui-btn{
		margin-left: 0px;
	}
	.layui-btn-xs{
		padding: 0 3px;
	}
	.layui-table-cell{
		padding: 0 1px;
	}
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '> 

<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
	<div class="demoTable" style='margin-left: 10px;'>
		<div class="layui-inline">
			<input type="text" class="layui-input" id="test1" placeholder="搜索登录时间">
		</div>
		<div class="layui-inline">
			<input type="text"  id='uid'  placeholder="搜索用户ID" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-inline">
			<input type="text"   id='ip'  placeholder="登录ip" autocomplete="off" class="layui-input">
		</div>
	</div>
</form>
<button class='search layui-btn'>搜索</button>

<div style='clear:both'></div>

<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="time1">
	{{layui.util.toDateString(d.login_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script type="text/html" id="time2">
	{{layui.util.toDateString(d.last_login_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>

layui.use(['table','form','laydate'], function(){
  var table = layui.table,form = layui.form
	var laydate = layui.laydate;
	//日期范围
	laydate.render({
		elem: '#test1'
		,range: true
		,max: 0
	});
  //方法级渲染
  table.render({
    elem: '#LAY_table_user'
    ,url: "/admin/member/login_log"
    ,cols: [[
      // {checkbox: true, fixed: true}
      {field:'uid', title: '用户编号[昵称][姓名]',unresize: true,templet: "<div>{{d.uid}}{{d.username?'['+d.username+']':''}}{{d.truename?'['+d.truename+']':''}}</div>" }
      ,{field:'ip', title: '登录ip',unresize: true }
      ,{field:'address', title: '登录地址',unresize: true }
      ,{field:'login_desc', title: '登录描述',unresize: true }
      ,{field:'login_time', title: '登录时间',unresize: true ,sort: true,templet: '#time1'}
    ]]
    ,id: 'testReload'
    ,page: true
    ,limit: 20
	  , done: function (res) {
		  tdTitle();
	  }
  })
	$('.search').on('click', function(){
		//执行重载
		table.reload('testReload', {
			page: {
				curr: 1 //重新从第 1 页开始
			}
			,where: {
				search_time:$('#test1').val(),
				uid:$('#uid').val(),
				ip:$('#ip').val(),
			}
		});
	});
});
</script>

</body>
</html>