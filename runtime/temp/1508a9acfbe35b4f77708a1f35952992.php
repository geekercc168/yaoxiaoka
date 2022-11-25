<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/user/login_log.html";i:1602229186;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
	.layui-btn-xs{
		padding: 0 3px;
	}
	.layui-table-cell{
		padding: 0 1px;
	}
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>
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
    ,url: "/pc/user/login_log"
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