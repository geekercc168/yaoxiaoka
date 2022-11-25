<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"/www/wwwroot/yaoxiaoka/application/admin/view/article/article_list.html";i:1615277220;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
	<div class="demoTable" style='margin-left: 10px;'>
		<div class="layui-inline">
			<input type="text" name="search_name"  id='search_name' lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value="<?php echo \think\Request::instance()->post('search_name'); ?>">
		</div>
	</div>
</form>
<button class='search layui-btn'>搜索</button>

<div style='clear:both'></div>

<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
<!-- 这里的 checked 的状态只是演示 -->
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">编辑</a>
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="change">
	<input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="正常|隐藏" lay-filter="change" {{ d.status==1 ? 'checked' : '' }}>
</script>
<script>

layui.use(['table','form'], function(){
  var table = layui.table,form = layui.form;
  
  //方法级渲染
  table.render({
    elem: '#LAY_table_user'
    ,url: "/admin/article/article_list"
    ,cols: [[
      // {checkbox: true, fixed: true}
      {field:'id', title: 'ID',width:100,  unresize: true}
      ,{field:'title', title: '标题',unresize: true,templet: function (d) {
					return "<div style='text-align: left !important;'>"+d.title+"</div>"
			  } }
	 ,{field:'categ_name',width:120, title: '类别',unresize: true }
	 ,{field:'status', width:120,title: '状态',unresize: true ,templet: '#change'}
      ,{field:'pub_time',width:180, title: '发布时间',unresize: true ,sort: true, edit:true}
      ,{field:'', width:180, title: '操作',unresize: true,templet: '#caozuo' }
    ]]
    ,id: 'testReload'
    ,page: true
    ,limit: 15
	  , done: function (res) {
		  tdTitle();
	  }
  })
	$('.search').on('click', function(){
		//执行重载
		var search_name = $('#search_name').val();
		table.reload('testReload', {
			page: {
				curr: 1 //重新从第 1 页开始
			}
			,where: {
				search_name:search_name,

			}
		});
	});
	form.on('switch(change)', function(obj){
		var id = this.value;
		var status=obj.elem.checked;
		if (status== true) {
			type=1;
		}else{
			type=0;
		}
		$.post("/admin/article/article_on",{id:id,type:type},function(data){
			layer.msg(data.msg);
		})
	});
  	//监听删除编辑操作
    table.on('tool(LAY_table_user)', function(obj){
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象
        if(layEvent === 'edit'){ //编辑
            var id = data.id;
            
			layer.open({
				type: 2,
				title:'编辑',
				shadeClose: true,
				area: ['80%', '80%'],
				shade: 0.8,
				content: '/admin/article/add_article?id='+id,
			});
        }
		if(layEvent === 'del'){
			var id = data.id;
				layer.confirm('您确定删除吗？', {
					btn: ['确定','取消'] //按钮
				}, function(index){
					$.post( "/admin/Article/article_del",{id:id},function(data){
						if(data.code == 1){
							layer.msg(data.msg, {icon: 1});
							obj.del();
						}else{
                            layer.msg(data.msg, {icon: 5});
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