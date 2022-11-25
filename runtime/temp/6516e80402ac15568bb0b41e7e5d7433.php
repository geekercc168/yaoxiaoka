<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"/www/wwwroot/yaoxiaoka/application/pc/view/tixian/bank_list.html";i:1623045329;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
	.layui-btn+.layui-btn{
		margin-left: 0px;
	}
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>
<!-- 功能栏 -->
<!--<form class="layui-form" id='form1' style='float: left;'>-->
<!--	<div class="demoTable" style='margin-left: 10px;'>-->
<!--		<div class="layui-inline">-->
<!--			<input type="text" id='search_name'  placeholder="请输入标题" autocomplete="off" class="layui-input" >-->
<!--		</div>-->
<!--	</div>-->
<!--</form>-->
<!--<button class='search layui-btn'>搜索</button>-->

<div style='clear:both'></div>

<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
<!-- 这里的 checked 的状态只是演示 -->
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">编辑</a>
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="on_time">
	{{layui.util.toDateString(d.on_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>

layui.use(['table','form'], function(){
  var table = layui.table,form = layui.form;
	if("<?php echo $is_mobile; ?>"==1){
		//方法级渲染
		table.render({
			elem: '#LAY_table_user'
			,url: "/pc/Tixian/bank_list"
			,cols: [[
				// {checkbox: true, fixed: true}
				{field:'bank', title: '银行名称',unresize: true }
				// , {field:'bank_name', title: '户名', unresize: true}
				,{field:'bank_number', title: '账号',unresize: true }
				,{field:'type', title: '是否默认',unresize: true ,templet:function (d) {
						if(d.type==1){
							return "<font color='green'>默认</font>"
						}else{
							return '否';
						}
					}}
				,{field:'', title: '操作',unresize: true,templet: '#caozuo' }
			]]
			,id: 'testReload'
			,page: true
			,limit: 20
			, done: function (res) {
				tdTitle();
			}
		})
	}else{
		//方法级渲染
		table.render({
			elem: '#LAY_table_user'
			,url: "/pc/Tixian/bank_list"
			,cols: [[
				// {checkbox: true, fixed: true}
				{field:'bank_name', title: '户名', unresize: true},
				{field:'bank', title: '银行名称',unresize: true },
				{field:'bankname', title: '所属银行',unresize: true },
				{field:'bank_number', title: '账号',unresize: true },
				{field:'zfb_number', title: '支付宝账号',unresize: true },
				{field:'on_time',title: '添加时间',unresize: true ,sort: true, templet:'#on_time'},
				{field:'type', title: '是否默认',unresize: true ,templet:function (d) {
					if(d.type==1){
						return "<font color='green'>默认</font>"
					}else{
						return '否';
					}
				}},
				{field:'', title: '操作',unresize: true,templet: '#caozuo' }
			]]
			,id: 'testReload'
			,page: true
			,limit: 20
			, done: function (res) {
				tdTitle();
			}
		})
	}

	$('#closeBtn').on('click', function(){
		var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
		parent.location.reload();//刷新父页面，注意一定要在关闭当前iframe层之前执行刷新
		parent.layer.close(index); //再执行关闭
	});
	$('.search').on('click', function(){
		//执行重载
		table.reload('testReload', {
			page: {
				curr: 1 //重新从第 1 页开始
			}
			,where: {
				search_name:$('#search_name').val(),

			}
		});
	});
  	//监听删除编辑操作
    table.on('tool(LAY_table_user)', function(obj){
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象
        if(layEvent === 'edit'){ //编辑
            var id = data.id;
             var _bank = data.bank;
            
             if(_bank == '支付宝') {
             	_bank = 'zfb';
             }else{
             	_bank = 'yhk';
             }
            
			if("<?php echo $is_mobile; ?>"==1){
				window.location.href='/pc/Tixian/bank?id='+id;
			}else{
				layer.open({
					type: 2,
					title:'编辑',
					shadeClose: true,
					area: ['90%', '90%'],
					// shade: 0.8,
					content: '/pc/Tixian/bank?way_add='+_bank+'&id='+id,
				});
			}

        }
		if(layEvent === 'del'){
			var id = data.id;
				layer.confirm('您确定删除吗？', {
					btn: ['确定','取消'] //按钮
				}, function(index){
					$.post( "/pc/Tixian/del_bank",{id:id},function(data){
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