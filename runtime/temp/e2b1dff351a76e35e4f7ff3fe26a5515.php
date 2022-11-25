<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"/www/wwwroot/yaoxiaoka/application/admin/view/admin/user_group.html";i:1598002912;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<body style='background: white;margin: 10px 10px 10px 10px; '> 
<h1>
	<span style='line-height: 40px;margin-left: 10px;'></span> 
	<a href="/admin/admin/user_group" >
		<button class="layui-btn layui-btn-primary layui-btn-sm">用户组列表</button>
	</a>
</h1>
 
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
<!-- 这里的 checked 的状态只是演示 -->
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">编辑</a>
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['table','form'], function(){
  var table = layui.table,form = layui.form;
  
  //方法级渲染
  table.render({
    elem: '#LAY_table_user'
    ,url: "/admin/admin/user_group"
    ,cols: [[
      // {checkbox: true, fixed: true}
      {field:'group_id', title: 'ID',  unresize: true}
      ,{field:'groupname', title: '用户组',unresize: true }
      ,{field:'on_time', title: '添加时间',unresize: true , edit:true}
      ,{field:'', title: '操作',unresize: true,templet: '#caozuo' }
    ]]
    ,id: 'testReload'
    ,page: true
    ,limit: 20
  });
  	//监听删除编辑操作
    table.on('tool(LAY_table_user)', function(obj){
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象
        if(layEvent === 'edit'){ //编辑
            var group_id = data.group_id;
			layer.open({
				type: 2,
				title:'编辑',
				shadeClose: true,
				area: ['80%', '80%'],
				shade: 0.8,
				content: '/admin/Admin/user_group_add?group_id='+group_id,
			});
        }
		if(layEvent === 'del'){
			var group_id = data.group_id;
				layer.confirm('您确定删除吗？', {
					btn: ['确定','取消'] //按钮
				}, function(index){
					$.post( "/admin/Admin/user_group_del",{group_id:group_id},function(data){
						if(data == 1){
							layer.msg('已经删除', {icon: 1});
							obj.del();
						}else if(data == -1){
							layer.msg('删除失败，请重试', {icon: 5});
						}
					},'json')
					layer.close(index);
				}, function(){
				});
		}
    });
});
</script>

</body>
</html>