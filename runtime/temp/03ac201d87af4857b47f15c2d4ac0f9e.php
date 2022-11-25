<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"/www/wwwroot/yaoxiaoka/application/pc/view/user/orders.html";i:1626061187;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/headers.html";i:1620895995;}*/ ?>
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
    
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>

<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="layui-form-item" style='  margin-left: 10px;'>

        <div class="layui-inline">
            <select class="px_type" id='stype' lay-search="">
                <option value="">选择卡种</option>
                <?php foreach($type_arr as $k=>$v): ?>
                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!--<div class="layui-inline">-->
            <!--<input type="checkbox" id="agains" lay-filter="agains" title="可重提" value="1">-->
        <!--</div>-->
        <div class="layui-inline">
            <input type="checkbox" id="wcg" lay-filter="wcg" title="2日未成功" value="1">
        </div>
        <div class="layui-inline">
            <input type="checkbox" id="quchong" lay-filter="quchong" title="去重" value="1">
        </div>
        <div class="layui-inline">
            <input type="checkbox" id="mianzhi_bufu" lay-filter="mianzhi_bufu" title="面值不符" value="1">
        </div>
        <div class="layui-inline">
            <select class="selresult" id='selresult' lay-search="">
                <option value="" >状态</option>
                <option value="1" <?php if($selresult=="1"): ?>selected<?php endif; ?>>成功</option>
                <option value="2" <?php if($selresult=="2"): ?>selected<?php endif; ?>>失败</option>
                <option value="0" <?php if($selresult=="0"): ?>selected<?php endif; ?>>处理中</option>
                <option value="3" <?php if($selresult=="3"): ?>selected<?php endif; ?>>其他</option>
            </select>
        </div>

        <div class="layui-inline">
            <input type="text" id='txt_number' placeholder="搜索卡号" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <input type="text" id='txt_orderid' placeholder="搜索订单号" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <input type="text" id='txt_pici' placeholder="搜索批次" autocomplete="off" class="layui-input" value="<?php echo $txt_pici; ?>">
        </div>
        <div class="layui-inline" style="width: 300px;">
            <input type="text" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',time()); ?> 00:00:00 - " value="">
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
            <button class='layui-btn layui-btn-warm' type="button" id="export" >导出</button>
        </div>
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
    layui.config({
        base: '/public/static/layui_exts/',
    }).extend({
        excel: 'excel',
    });
    layui.use(['table', 'form', 'laydate','excel'], function () {
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
            , url: "/pc/User/orders?search_time=<?php echo $search_time; ?>&txt_pici=<?php echo $txt_pici; ?>&selresult=<?php echo $selresult; ?>"
            ,totalRow: true
            , cols: [[
                {field: 'orderid', title: '订单号', width: 200,totalRowText:'合计：'}
                , {field: 'total_orderid', title: '批次', width: 120}
                , {field: 'kazhong', title: '卡种',width: 60 }
                , {field: 'crad_number', title: '卡号',width: 150}
                , {field: 'crad_pass', title: '卡密',width: 160}
                , {field: 'cash', title: '提面',totalRow:true}
                , {field: 'realvalue', title: '实面',totalRow:true}
                , {field: 'incash', title: '结算',totalRow:true}
                , {field: 'on_time',width: 110, title: '提交'}
                , {field: 'end_time',width: 110, title: '处理'}
                , {field: '', title: '描述', templet: function (d) {
                        var colors = 'green';
                        if (d.status == 1) {
                            if (Number(d.cash) != Number(d.realvalue)) {
                                colors = 'red';
                                d.status_desc = '实际面额不符';
                            }
                        } else {
                            colors = 'red';
                        }
                        if(!d.status_desc){
                            d.status_desc='';
                        }
                        return '<font color="' + colors + '">' + d.status_desc + '</font>';
                    }
                }
                , {field: 'status', width: 60, title: '状态', templet: function (d) {
                        var colors = 'blue';
                        if (d.status == 1) {
                            colors = 'green';
                        } else if (d.status == 2) {
                            colors = 'red';
                        }
                        return '<font color="' + colors + '">' + d.status_txt + '</font>';
                        
                        // if (d.status == 1) {
                        //     colors = 'green';
                        //     return '<font color="' + colors + '">成功</font>';
                        // } else if (d.status == 2) {
                        //     colors = 'red';
                        //     return '<font color="' + colors + '">处理中</font>';
                        // }else{
                        //     return '<font color="' + colors + '">处理中</font>';
                        // }
                    }
                }
                // , {field: '', width: 60, title: '操作', templet: '#caozuo'}
            ]]
            , id: 'testReload'
            , page: true
            , limit: 20
            , done: function (res,curr,count) {
                tdTitle();
            }

        })
        var excel = layui.excel;
        $('#export').on('click',function () {
            //使用ajax请求获取所有数据
            $.ajax({
                url: "/admin/index/ajax_order",
                type: 'post',
                data: {
                    exportall: 1,
                    search_time: $('#test1').val(),
                    sbt: 1,
                    txt_uid: $("#txt_uid").val(),
                    stype: $("#stype").val(),
                    agains: $('#agains').is(":checked")?$("#agains").val():'',
                    wcg: $('#wcg').is(":checked")?$("#wcg").val():'',
                    quchong: $('#quchong').is(":checked")?$("#quchong").val():'',
                    mianzhi_bufu: $('#mianzhi_bufu').is(":checked")?$("#mianzhi_bufu").val():'',
                    txt_tongdao: $("#txt_tongdao").val(),
                    selresult: $("#selresult").val(),
                    txt_number: $("#txt_number").val(),
                    txt_orderid: $("#txt_orderid").val(),
                    txt_fenzu: $("#txt_fenzu").val(),
                    txt_pici:  $("#txt_pici").val(),
                    api: "<?php echo $api; ?>",
                },
                async: false,
                dataType: 'json',
                success: function (res) {
                    res.data.unshift({
                        orderid: '订单号'
                        ,uid: "用户ID"
                        ,kazhong: '卡种'
                        ,crad_number: "卡号"
                        ,crad_pass: '卡密'
                        ,on_time: '提交时间'
                    });
                    var date=new Date();
                    var nowday="<?php echo date('Y-m-d H:i:s',time()); ?>";
                    // 3. 执行导出函数，系统会弹出弹框
                    //console.log(res.data);exit;
                    excel.exportExcel({
                        sheet1: res.data
                    }, nowday+'.xlsx', 'xlsx');

                    var timestart = Date.now();
                    var timeend = Date.now();

                    var spent = (timeend - timestart) / 1000;
                    layer.alert('单纯导出耗时 '+spent+' s');
                    //使用table.exportFile()导出数据
//                    table.exportFile('LAY_table_user', res.data, 'xls');
                },
                error:function(res){
                    layer.close(loading);
                    layer.msg(res.msg);
                }
            });
        });


        $('.search').on('click', function () {
            //执行重载
            table.reload('testReload', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    search_time: $('#test1').val(),
                    sbt: 1,
                    txt_uid: $("#txt_uid").val(),
                    stype: $("#stype").val(),
                    agains: $('#agains').is(":checked")?$("#agains").val():'',
                    wcg: $('#wcg').is(":checked")?$("#wcg").val():'',
                    quchong: $('#quchong').is(":checked")?$("#quchong").val():'',
                    mianzhi_bufu: $('#mianzhi_bufu').is(":checked")?$("#mianzhi_bufu").val():'',
                    txt_tongdao: $("#txt_tongdao").val(),
                    selresult: $("#selresult").val(),
                    txt_number: $("#txt_number").val(),
                    txt_orderid: $("#txt_orderid").val(),
                    txt_fenzu: $("#txt_fenzu").val(),
                    txt_pici:  $("#txt_pici").val(),
                    api: "<?php echo $api; ?>",
                }
            });
        });
        //监听删除编辑操作
        table.on('tool(LAY_table_user)', function (obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            if (layEvent === 'del') {
                var id = data.id;
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