<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/www/wwwroot/yaoxiaoka/application/admin/view/finance/rongcuo.html";i:1626312615;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<body style='background: white;margin: 10px 10px 10px 10px;'>
<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="demoTable" style='margin-left: 10px;'>
        <div class="layui-inline" style="width: 300px;">
            <input type="text" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',time()); ?> 00:00:00 - ">
        </div>
    </div>
</form>
<button class='search layui-btn'>搜索</button>

<div style='clear:both'></div>
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
<script>
function newTab(url, tit) {
        if (top.layui.index) {
            top.layui.index.openTabsPage(url, tit)
        } else {
            window.open(url)
        }
    }
    function aaa(){
        var url = $('#test1').val();
        newTab('/admin/member/orders?tijao=1&selresult=666&search_time='+url,'订单查询');
    }
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
            , url: "/admin/Finance/rongcuo"
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'c_nums', title: '金额不符张数', templet: function (d) {
                        return '<a href="javascript:;" onclick="aaa()">'+d.c_nums+'</a>';
                    }
                }
                , {field: 'z_nums', title: '总张数'}
                , {field: 'c_realvalue', title: '金额不符实际金额'}
                , {field: 'z_realvalue', title: '总实际金额'}
                , {field: 'cuo_lv', title: '实际金额错误率'}
            ]]
            , id: 'testReload'
            // , page: true
            , limit: 100
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
                    search_time: $('#test1').val(),
                }
            });
        });
    });
</script>

</body>
</html>