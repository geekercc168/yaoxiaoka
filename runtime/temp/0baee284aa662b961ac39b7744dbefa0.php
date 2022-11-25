<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"/www/wwwroot/yaoxiaoka/application/admin/view/finance/yjfx.html";i:1626251092;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
	*{
		font-size: 14px;
	}
</style>
<body style='margin: 10px'>
<!-- 功能栏 -->
<form class="layui-form" id='form1' action="" method="get" style='float: left;'>
	<div class="demoTable" style='float: left; '>
		<div class="layui-inline" style="width: 300px;">
			<input type="text" name="search_time" value="<?php echo $search_time; ?>" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',strtotime('-7 day')); ?> 00:00:00 - ">
		</div>
	</div>
	
</form>
	<button class='search layui-btn' type="button" style=" margin-left: 10px;">搜索</button>
	<button class='layui-btn layui-btn-warm' type="button"  style=" margin-left: 10px;" id="export" >导出</button>
<div class="company-box">

    <div class="company-conwrap">
        <div class="layui-row">
        	<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
        </div>
    </div>
</div>


</section>
</body>
<script type="text/html" id="time1">
	{{layui.util.toDateString(d.on_time*1000, 'yyyy-MM-dd')}}
</script>
<script>
layui.config({
    base: '/public/static/layui_exts/',
}).extend({
    excel: 'excel',
});
layui.use(['table', 'form', 'laydate','excel'], function(){
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
    ,url: "/admin/Finance/yjfx"
    ,cols: [[
      {field:'on_time', title: '日期',width:120,  unresize: true,sort: true},
      {field:'zuoyingli', title: '平台盈利',width:120,sort: true },
      {field:'riyingli', title: '销卡盈利',width:120,sort: true },
      {field:'zuoptsuode', title: '平台所得',width:120,sort: true },
      {field:'zuoyhsuode', title: '用户所得',width:120,sort: true },
      {field:'zuoyhhuizong', title: '用户汇总',width:120,sort: true },
      {field:'zuoyinglilv', title: '盈利率',width:120,sort: true },
      {field:'zuoxiaokarenshu', title: '销卡人数',width:120,sort: true },
      {field:'zuotixianjine', title: '提现金额',width:120,sort: true },
      {field:'zuoxinzhuce', title: '新注册',width:120,sort: true },
      {field:'zuoweitixian', title: '未提现金额',width:120,sort: true },
      {field:'zuoweichuli', title: '未处理金额',width:120,sort: true }
    ]]
    ,id: 'testReload'
    ,page: true
    ,limit: 20
	  , done: function (res) {
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
 var excel = layui.excel;
 $('#export').on('click',function () {
    //使用ajax请求获取所有数据
    $.ajax({
        url: "/admin/Finance/yjfx",
        type: 'post',
        data: {
            exportall: 1,
            search_time: $('#test1').val(),
        },
        async: false,
        dataType: 'json',
        success: function (res) {
            res.data.unshift({
                on_time: '日期',
                zuoyingli: '平台盈利',
                riyingli: '销卡盈利',
                zuoptsuode: '平台所得',
                zuoyhsuode: '用户所得',
                zuoyhhuizong: '用户汇总',
                zuoyinglilv: '盈利率',
                zuoxiaokarenshu: '销卡人数',
                zuotixianjine: '提现金额',
                zuoxinzhuce: '新注册',
                zuoweitixian: '未提现金额',
                zuoweichuli: '未处理金额'
            });
            var date=new Date();
            var nowday="<?php echo date('Y-m-d H:i:s',time()); ?>";
            // 3. 执行导出函数，系统会弹出弹框
            // console.log(res.data);exit;
            excel.exportExcel({
                sheet1: res.data
            }, nowday+'.xlsx', 'xlsx');

            var timestart = Date.now();
            var timeend = Date.now();

            var spent = (timeend - timestart) / 1000;
            layer.alert('单纯导出耗时 '+spent+' s');
            //使用table.exportFile()导出数据
            //table.exportFile('LAY_table_user', res.data, 'xls');
        },
        error:function(res){
            layer.close(loading);
            layer.msg(res.msg);
        }
    });
});

  	
});


</script>