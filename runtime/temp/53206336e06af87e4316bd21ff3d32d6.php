<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/tixian/m_lists.html";i:1608183182;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
<link rel="stylesheet" href="//at.alicdn.com/t/font_1786378_02usjpdi4hev.css">

<div class="main_top">提现记录
    <a href="javascript:history.back(-1);"  class="back"><img src="/public/wap/img/left_icon.png" alt=""></a>
    <a class="kf_right"><img src="/public/wap/img/kf_icon.png" alt=""></a>
</div>

<body style='background: white;padding: 2px'>

<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="demoTable" style='  margin-left: 10px;'>
<!--        <div class="layui-inline" style="width: 100%;margin-bottom: 5px">-->
<!--            <input type="text" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',time()); ?> 00:00:00 - ">-->
<!--        </div>-->
        <div class="layui-inline" style="margin-bottom: 5px">

            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="startTime" value="<?php echo date('Y-m-d',time()); ?> 00:00:00">
            </div>
                ~
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="endTime" value="">
            </div>
        </div>
        <div class="layui-inline">
            <select class="selresult" id='selresult' lay-search="">
                <option value="">状态</option>
                <option value="1">成功</option>
                <option value="2">失败</option>
                <option value="0">处理中</option>
                <option value="3">其他</option>
            </select>
        </div>
        <button class='search layui-btn' type="button">搜索</button>
    </div>

</form>

<div style='clear:both'></div>
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
    <!-- 这里的 checked 的状态只是演示 -->
    {{# if (d.status == 0) { }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
    {{# } }}
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="change">
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="正常|隐藏" lay-filter="change" {{
           d.status==1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="time1">
    {{layui.util.toDateString(d.register_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script type="text/html" id="time2">
    {{layui.util.toDateString(d.last_login_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>
    layui.use(['table', 'form', 'laydate'], function () {
        var table = layui.table, form = layui.form
        var laydate = layui.laydate;
        //日期范围
        // 选择日期
        laydate.render({
            elem: '#startTime', //指定元素
            type: 'datetime',
            theme: '#5978fb',
            done: function (value, date, endDate) {
                var startDate = new Date(value).getTime();
                var endTime = new Date($('#endTime').val()).getTime();
                if (endTime < startDate) {
                    $('#startTime').val($('#endTime').val());
                }
            }
        });
        laydate.render({
            elem: '#endTime', //指定元素
            theme: '#5978fb',
            type: 'datetime',
            done: function (value, date, endDate) {
                var startDate = new Date($('#startTime').val()).getTime();
                var endTime = new Date(value).getTime();
                if (endTime < startDate) {
                    $('#endTime').val($('#startTime').val());
                }
            }
        });
        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: "/pc/Tixian/lists"
            ,totalRow:true
            , cols: [[
                // {checkbox: true, fixed: true}
                 {field: 'bank_r', title: '提现'},
                 {field: 'account', title: '卡号',unresize: true}
                , {field: 'create_time', title: '申请时间'}
                , {field: 'cash', title: '金额',totalRow:true}
                , {field: 'fee', title: '手续费',totalRow:true}
                // , {field: 'ext', title: '描述'}
                , {
                    field: 'status', title: '状态', templet: function (d) {
                        var colors = 'blue';
                        if (d.status == 1) {
                            colors = 'green';
                        }else{
                            colors = 'red';
                        }
                        return '<font color="' + colors + '">' + d.status_txt + '</font>';
                    }
                }
                , {field: 'faildesc', title: '备注',style:"color:red",unresize: true}
            ]]
            , id: 'testReload'
            , page: true
            , limit: 20
            , done: function (res,curr,count) {
                tdTitle();
            }
        })
        $('.search').on('click', function () {
            //执行重载
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    search_time: $('#startTime').val()+' - '+$('#endTime').val(),
                    selresult: $('#selresult').val(),
                }
            });
        });
    });
</script>

</body>
</html>