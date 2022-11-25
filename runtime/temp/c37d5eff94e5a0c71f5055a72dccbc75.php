<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"/www/wwwroot/yaoxiaoka/application/admin/view/finance/card_logg.html";i:1608183182;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
        <div class="layui-inline">
            <input type="text" id='txt_uid' placeholder="搜索用户ID" autocomplete="off"
                   class="layui-input" value="<?php echo $txt_uid; ?>">
        </div>
        <div class="layui-inline">
            <input type="text" id='txt_username' placeholder="搜索用户名称" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <input type="checkbox" id="fenrun" lay-filter="fenrun" title="去除代理分润" value="1">
        </div>
    </div>
</form>
<button class='search layui-btn'>搜索</button>

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
            , url: "/admin/Finance/card_logg?txt_uid=<?php echo $txt_uid; ?>"
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'id', title: '流水号', width: 180, unresize: true}
                , {field: 'uid', title: '用户编号[昵称]', width: 110, unresize: true,templet: function (d) {
                    var str='';
                    if(d.username){
                        str+='['+ d.username+']';
                        }
                        return "<a href='/admin/member/member_list/?txt_uid="+d.uid+"' target='_blank'><font color='green'>"+d.uid+"</font>"+str+"</a>"
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
                    username: $('#txt_username').val(),
                    txt_uid: $('#txt_uid').val(),
                    selresult: $('#selresult').val(),
                    fenrun: $('#fenrun').is(":checked")?$('#fenrun').val():'',
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

</body>
</html>