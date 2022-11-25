<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"/www/wwwroot/yaoxiaoka/application/admin/view/member/pici.html";i:1608183182;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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

    .tj_num {
        color: red;
        font-size: 16px;
        font-weight: bold;
    }

    .layui-elem-quote > div {
        margin-left: 15px;
    }
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>
<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="demoTable" style='margin-left: 10px;'>
        <div class="layui-inline" style="width: 300px;">
            <input type="text" class="layui-input" id="test1"
                   placeholder="<?php echo date('Y-m-d',time()); ?> 00:00:00 - ">
        </div>
        <div class="layui-inline">
            <input type="text" class="layui-input" name="txt_pici" id="txt_pici" placeholder="搜索批次号">
        </div>
        <div class="layui-inline">
            <input type="text" class="layui-input" name="cash" id="cash" placeholder="搜索面值">
        </div>
    </div>
</form>
<button class='search layui-btn'  data-type='search'>搜索</button>
<button class="layui-btn" data-type="getCheckData" style="background:#7185a2">批量改价</button>


<div style='clear:both'></div>
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 }-->
<script type="text/html" id="time1">
    {{layui.util.toDateString(d.on_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script type="text/html" id="time2">
    {{layui.util.toDateString(d.last_login_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script type="text/html" id="on_time">
    {{layui.util.toDateString(d.on_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>

    layui.use(['table', 'form', 'laydate'], function () {
        var table = layui.table, form = layui.form
        var laydate = layui.laydate;
        //日期范围
        laydate.render({
            elem: '#test1'
            , type: 'datetime'
            , range: true
        });
        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: "/admin/Member/pici"
            , totalRow: true
            , cols: [[
                {checkbox: true, fixed: true}
                , {field: 'total_orderid', title: '批次', totalRowText: '统计：'}
                , {field: 'cash', title: '面值'}
                , {field: 'user_huilv', title: '费率'}
                , {field: 'tijiao', title: '提交总金额'}
                , {field: 'shimian', title: '成功金额'}
                , {field: 'jiesuan', title: '结算金额'}
                , {
                    field: '', title: '总提交（张）', 'templet': function (d) {
                        var search_time = $('#test1').val();
                        return '<a style="color:orange" href="/admin/Member/orders?selresult=&search_time=' + search_time + "&txt_pici=" + d.total_orderid + '" target="_blank">' + d.num + '</a>';
                    }
                }
                , {
                    field: '', title: '处理中（张）', 'templet': function (d) {
                        var search_time = $('#test1').val();
                        return '<a style="color:blue" href="/admin/Member/orders?selresult=0&search_time=' + search_time + "&txt_pici=" + d.total_orderid + '" target="_blank">' + d.chuli + '</a>';
                    }
                }
                , {
                    field: '', title: '成功（张）', 'templet': function (d) {
                        var search_time = $('#test1').val();
                        return '<a style="color:green" href="/admin/Member/orders?selresult=1&search_time=' + search_time + "&txt_pici=" + d.total_orderid + '" target="_blank">' + d.chenggong + '</a>';
                    }
                }
                , {field: '', title: '失败（张）', 'templet': function (d) {
                        var search_time = $('#test1').val();
                        return '<a style="color:red" href="/admin/Member/orders?selresult=2&search_time=' + search_time + "&txt_pici=" + d.total_orderid + '" target="_blank">' + d.shibai + '</a>';
                    }}
                , {field: 'on_time', title: '提交时间',templet:'#on_time'}
            ]]
            , id: 'testReload'
            // , page: true
            , limit: 15
            , done: function (res, curr, count) {
                tdTitle();
            }
        })
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
            if (layEvent === 'batchset') {
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
        var active = {
            //注释：layui 搜索模块 Start
            search: function(){
                table.reload('testReload', {
                    page: {
                        curr: 1
                    }
                    ,where: {
                        search_time: $('#test1').val(),
                        txt_pici: $('#txt_pici').val(),
                    }
                });
            },
            //注释：layui 搜索模块 End
            //注释：layui 批量删除 Start
            getCheckData:function(){
                var checkStatus = table.checkStatus('testReload');// table.checkStatus是Layui中自带，id: 'testReload'可自定义
                if(checkStatus.data.length==0){
                    layer.msg('请先选择要改价的数据行！', {icon: 2});
                    return ;
                }
                var codeId=[];
                for(var i=0;i<checkStatus.data.length;i++){
                    codeId.push(checkStatus.data[i].total_orderid);
                }
                var total_orderid=codeId.join(',');
                    layer.open({
                        type: 1
                        ,title: '批量修改渠道费率和系统费率：' //不显示标题栏
                        ,closeBtn: false
                        // ,area: '300px;'
                        ,shade: 0.8
                        // ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                        ,btn: ['修改', '取消']
                        ,btnAlign: 'c'
                        ,moveType: 1 //拖拽模式，0或者1
                        ,content:'<div style="padding: 5px;"><h3 style="color:red;margin-bottom: 10px">请确保闲卖渠道费率一致！！</h3>' +
                            '<label>系统费率：<input type="number"  id="xthl" value=""></label><br/><br/>' +
                            '<label>用户费率：<input type="number"   id="yhfl" value=""></label>'
                        ,yes: function(layero){
                            var xthl=$("#xthl").val();
                            var yhfl=$("#yhfl").val();
                            if(xthl>100 || xthl<=0){
                                layer.msg('系统费率填写错误');return;
                            }
                            if(yhfl>100 || yhfl<=0){
                                layer.msg('用户费率填写错误');return;
                            }
                            $.post("/admin/member/gaijia", {total_orderid:total_orderid, xt_huilv:xthl, user_huilv:yhfl,},
                                function(ret){
                                    if(ret.code==1){
                                        layer.msg(ret.msg, {icon: 1,time:2000},function () {
                                            layer.closeAll();
                                        });
                                    }else{
                                        layer.msg(ret.msg, {icon: 5});
                                    }
                                },'json');
                        }
                        ,cancel: function(){
                            //右上角关闭回调
                            //return false 开启该代码可禁止点击该按钮关闭
                        }
                    });
                // layer.confirm("您确定要删除吗？"+codeId,function(){
                //     $.ajax({
                //         type:"POST",
                //         url: './json/servertheme.json',
                //         data:{"id":codeId},
                //         success:function (data) {
                //             layer.closeAll('loading');
                //             if(data.code==1){
                //                 parent.layer.msg('改价成功！', {icon: 1,time:2000,shade:0.2});
                //                 location.reload(true);
                //             }else{
                //                 parent.layer.msg('改价失败！', {icon: 2,time:3000,shade:0.2});
                //             }
                //         }
                //     })
                // })
            }
            //注释：layui 批量删除 End
            //通用按钮
        };
        //注释：layui 批量删除 End
        $('.layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>

</body>
</html>