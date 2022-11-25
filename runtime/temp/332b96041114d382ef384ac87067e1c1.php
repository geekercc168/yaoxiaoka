<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"/www/wwwroot/yaoxiaoka/application/admin/view/finance/tx_shenhe.html";i:1623835327;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
    .layui-btn+.layui-btn{
        margin-left:0px;
    }
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>

<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="demoTable" style='margin-left: 10px;'>
        <div class="layui-inline" style="width: 300px;">
            <input type="text" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',strtotime('-3 day')); ?> 00:00:00 - ">
        </div>
        <div class="layui-inline">
            <input type="text" id='txt_uid' placeholder="搜索用户ID" autocomplete="off"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            <input type="text" id='txt_username' placeholder="搜索用户名称" autocomplete="off"
                   class="layui-input">
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
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
    <!-- 这里的 checked 的状态只是演示 -->
    {{# if (d.status == 0) { }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="pass">人工转账</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="kjt">KJT</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="ZFB">ZFB</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="die">失败</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="card_logg">查看账变</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="orders">查看订单</a>
    {{# } }}
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
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
        var tx_bj="<?php echo $tx_bj; ?>";
       
        //日期范围
        laydate.render({
            elem: '#test1'
            ,type: 'datetime'
            , range: true
        });
        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: "/admin/Finance/tx_shenhe"
            ,totalRow:true
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'id', title: '序号',totalRowText:'合计： '}
                , {field: 'uid', title: '用户ID'}
                , {field: 'username', title: '用户名称'}
                , {field: 'account', width: 160,title: '卡号',totalRow:true}
                , {field: 'bank_r', title: '提现方式', width: 110}
                , {field: 'bankname', title: '所属银行', width: 110}
                , {field: 'create_time', title: '申请时间'}
                , {field: 'cash', title: '提现金额',totalRow:true}
                , {field: 'fee', title: '手续费',totalRow:true}
                , {field: 'ext', title: '描述'}
                , {
                    field: 'status', width: 60, title: '状态', templet: function (d) {
                        var colors = 'blue';
                        if (d.status == 1) {
                            colors = 'green';
                        }else{
                            if(d.is_llp==1){
                                colors = 'red';
                            }
                        }
                        return '<font color="' + colors + '">' + d.status_txt + '</font>';
                    }
                }
                , {field: 'ext', title: '操作',width:320,templet:'#caozuo'}
            ]]
            , id: 'testReload'
            , page: true
            , limit: 20
            , done: function (res,curr,count) {tdTitle();}
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
                    uid: $('#txt_uid').val(),
                }
            });
        });
        //监听删除编辑操作
        table.on('tool(LAY_table_user)', function (obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            var id = data.id;
            if (layEvent === 'pass' || layEvent === 'die') {
                //var type = tr.find('.' + layEvent).attr('value');
                if(layEvent === 'pass'){
                    layer.confirm('您确定操作吗？', {
                        btn: ['确定', '取消'] //按钮
                    }, function (index) {
                        $.post("/admin/Finance/tx_status", {id: id,type: 1}, function (data) {
                            if (data.code == 1) {
                                layer.msg(data.msg, {icon: 1,time:2000},function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }, 'json')
                        layer.close();

                    });
                }else{
                    layer.prompt({
                        title: '拒绝理由',
                    },function(val, index){
                        $.post("/admin/Finance/tx_status", {id: id,'type':2,'chuli_desc':val}, function (data) {
                            if (data.code == 1) {
                                layer.msg(data.msg, {icon: 1,time:2000},function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                            layer.closeAll();
                        }, 'json')

                    });
                }

            }
            if(layEvent === 'card_logg' || layEvent === 'orders') {
                var id = data.id;
                var url = '/admin/member/add_member?txt_uid=' + data.uid;
                var title = '';
                if (layEvent === 'card_logg') {
                    title = '用户账变';
                    url = '/admin/Finance/card_logg?txt_uid=' + data.uid;
                } else if (layEvent === 'orders') {
                    title = '用户订单';
                    url = '/admin/member/orders?txt_uid=' + data.uid;
                }
                window.open(url)
                
            }
            if(layEvent === 'kjt'){
                layer.prompt({
                    formType: 0,
                    value: '',
                    title: '请输入打款验证码',
                    area: ['200px', '150px'] //自定义文本域宽高
                }, function(val, index){
                    $('.layui-layer-btn0').css('pointer-events','none');
                    $.post("/admin/Finance/tx_kjt", {id: id,'type':2,'pwd':val}, function (data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 1,time:2000},function () {
                                window.location.reload();
                            });
                        } else {
                            layer.closeAll();
                            layer.msg(data.msg, {icon: 5});
                        }
                    }, 'json')

                });
            }

            if(layEvent === 'ZFB'){
                layer.prompt({
                    formType: 0,
                    value: '',
                    title: '请输入打款验证码',
                    area: ['200px', '150px'] //自定义文本域宽高
                }, function(val, index){
                    $('.layui-layer-btn0').css('pointer-events','none');
                    $.post("/admin/Finance/alipay_trans", {id: id,'type':2,'pwd':val}, function (data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 1,time:2000},function () {
                                window.location.reload();
                            });
                        } else {
                            layer.closeAll();
                            layer.msg(data.msg, {icon: 5});
                        }
                    }, 'json')

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