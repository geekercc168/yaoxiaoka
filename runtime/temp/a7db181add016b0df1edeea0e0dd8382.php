<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"/www/wwwroot/yaoxiaoka/application/pc/view/tixian/card_logg.html";i:1623828722;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
    .layui-table-cell {
        padding: 0 1px;
    }
    .tj_num{
        color: red;
        font-size: 16px;
        font-weight: bold;
    }
    .layui-elem-quote>div{
        margin-left: 15px;
    }
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>
<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="demoTable" style='margin-left: 10px;'>
        <div class="layui-inline" style="width: 300px;">
            <input type="text" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',time()); ?> 00:00:00 - ">
        </div>
        <div class="layui-inline item-date">
            <span class="layui-btn layui-btn-primary" data-item="yestoday">昨天</span>
            <span class="layui-btn layui-btn-primary" data-item="today">今天</span>
            <span class="layui-btn layui-btn-primary" data-item="lastWeek">近一周</span>
            <span class="layui-btn layui-btn-primary" data-item="lastMonth">近一个月</span>
            <span class="layui-btn layui-btn-primary" data-item="month">近三个月</span>
        </div>
        <div class="layui-inline">
            <span class='search layui-btn'>搜索</span>
        </div>
    </div>
</form>

<div style='clear:both'></div>
<div id='nums' class="tj_num"></div>
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
    <!-- 这里的 checked 的状态只是演示 -->
    {{# if (d.status == 0) { }}{{# } }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>

</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="time1">
    {{layui.util.toDateString(d.on_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script type="text/html" id="time2">
    {{layui.util.toDateString(d.last_login_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>

    layui.use(['table', 'form', 'laydate'], function () {
        var table = layui.table, form = layui.form
        var laydate = layui.laydate;
        //日期范围
        laydate.render({
            elem: '#test1'
            ,type: 'datetime'
            , range: true
        });
        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: "/pc/Tixian/card_logg"
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'id', title: '流水号', width: 180, unresize: true}
                , {field: 'uid', title: '用户编号[昵称]', width: 110, unresize: true,templet: function (d) {
                    var str='';
                    if(d.username){
                        str+='['+ d.username+']';
                        }
                        return "<font color='green'>"+d.uid+"</font>"+str+""
                    }}
                , {field: 'orderid', title: '订单号',  unresize: true}
                , {field: 'action', title: '变动类型', width: 110, unresize: true}
                , {field: 'crad_number', title: '卡号', unresize: true}
                , {field: 'old_cash', title: '变动前总金额',style:'color:#FF7B0E', unresize: true}
                , {field: 'new_cash', title: '变动金额', unresize: true,templet:function (d) {
                    if(d.ext==1){
                        return "<font color='green'>"+d.cash+"</font>";
                    }else{
                        return "<font color='red'>-"+d.cash+"</font>";
                    }
                    }}
                , {field: 'new_cash', title: '变动后总金额',style:'color:red', unresize: true}
                , {field: 'on_time', title: '变动时间', unresize: true,templet:'#time1'}
            ]]
            , id: 'testReload'
            , page: true
            , limit: 20
            , done: function (res,curr,count) {
                // $('#nums').html(res.title.nums);
                // $('#total_cash').html(res.title.total_cash);
                // $('#total_fee').html(res.title.total_fee);
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
                    search_time: $('#test1').val(),
                    selresult: $('#selresult').val(),
                }
            });
        });
        //监听删除编辑操作
        table.on('tool(LAY_table_user)', function (obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            if (layEvent === 'edit') { //编辑
                var id = data.id;
                layer.open({
                    type: 2,
                    title: '编辑',
                    shadeClose: true,
                    area: ['80%', '80%'],
                    shade: 0.8,
                    content: '/admin/member/add_member?id=' + id,
                });
            }
            if (layEvent === 'del') {
                var id = data.id;
                var type = tr.find('.' + layEvent).attr('value');
                layer.confirm('您确定操作吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function (index) {
                    $.post("/admin/Member/order_del", {id: id}, function (data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 1});
                            obj.del();
                        } else {
                            layer.msg(data.msg, {icon: 5});
                        }
                    }, 'json')
                    layer.close(index);
                }, function () {
                });
            }
        });
    });
</script>
<script type="text/javascript">

$('.item-date span').click(function(){
    let _item = $(this).data('item')
    $(this).removeClass('layui-btn-primary').siblings().addClass('layui-btn-primary')
    const _day = new Date()

    if(_item == 'today'){
        _day.setTime(_day.getTime());
        let _time = _day.getFullYear()+"-" + (_day.getMonth()+1) + "-" + _day.getDate();
        $('#test1').val(_time + ' 00:00:00 - ' + _time + ' 23:59:59');
    }

    if(_item == 'yestoday'){
        _day.setTime(_day.getTime()-24*60*60*1000);
        let _time = _day.getFullYear()+"-" + (_day.getMonth()+1) + "-" + _day.getDate();
       $('#test1').val(_time + ' 00:00:00 - ' + _time + ' 23:59:59');
    }

    if(_item == 'lastWeek'){
        let _day2 = new Date()
        _day2.setTime(_day2.getTime());
        let _time2 = _day2.getFullYear()+"-" + (_day2.getMonth()+1) + "-" + _day2.getDate();

        _day.setTime(_day.getTime()-7*24*60*60*1000);
        let _time = _day.getFullYear()+"-" + (_day.getMonth()+1) + "-" + _day.getDate();
       $('#test1').val(_time + ' 00:00:00 - ' + _time2 + ' 23:59:59');
    }

    if(_item == 'lastMonth'){
        let _day2 = new Date()
        _day2.setTime(_day2.getTime());
        let _time2 = _day2.getFullYear()+"-" + (_day2.getMonth()+1) + "-" + _day2.getDate();

        _day.setTime(_day.getTime()-30*24*60*60*1000);
        let _time = _day.getFullYear()+"-" + (_day.getMonth()+1) + "-" + _day.getDate();
       $('#test1').val(_time + ' 00:00:00 - ' + _time2 + ' 23:59:59');
    }

    if(_item == 'month'){
        let _day2 = new Date()
        _day2.setTime(_day2.getTime());
        let _time2 = _day2.getFullYear()+"-" + (_day2.getMonth()+1) + "-" + _day2.getDate();

        _day.setTime(_day.getTime()-90*24*60*60*1000);
        let _time = _day.getFullYear()+"-" + (_day.getMonth()+1) + "-" + _day.getDate();
       $('#test1').val(_time + ' 00:00:00 - ' + _time2 + ' 23:59:59');
    }
    
})
$('.item-date span').eq(1).click()

</script>
</body>
</html>