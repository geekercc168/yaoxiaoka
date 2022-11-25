<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"/www/wwwroot/yaoxiaoka/application/admin/view/member/truename_auth.html";i:1607994741;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
<body style='background: white;margin: 10px 10px 10px 10px; '>
<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
    <div class="demoTable" style='margin-left: 10px;'>
        <div class="layui-inline">
            <input type="text" name="search_name" id='search_name' value="" placeholder="请输入用户id或用户名" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-inline">
            <select name="selresult" class="selresult" id='selresult' lay-search="">
                <option value="" >所有</option>
                <option value="1" >成功</option>
                <option value="2" >失败</option>
                <option value="0" >处理中</option>
                <option value="3" >其他</option>
            </select>
        </div>
    </div>
</form>
<button class='search layui-btn'>搜索</button>

<div style='clear:both'></div>

<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
    {{# if (d.status == 1) { }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="init">重置</a>
    {{# } else { }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="pass">通过</a>
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="not_pass">拒绝</a>
    {{# } }}
</script>

<script type="text/html" id="idcard_z">
    <img onclick='magnify("idcard_z")' style='width: 21px;height: 28px' src="{{d.idcard_z}}">
    <div class='tongidcard_z' style='display: none; '><img style='max-width: 100%;' src="{{d.idcard_z}}"></div>
</script>
<script type="text/html" id="idcard_f">
    <img onclick='magnify("idcard_f")' style='width: 21px;height: 28px' src="{{d.idcard_f}}">
    <div class='tongidcard_f' style='display: none; '><img style='max-width: 100%;' src="{{d.idcard_f}}"></div>
</script>
<script type="text/html" id="caeatetime">
    {{layui.util.toDateString(d.on_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    // 图片点击放大
    function magnify(obj) {
        layer.open({
            type: 1,
            title: false,
            //closeBtn: 1,
            skin: 'layui-layer-nobg', //没有背景色
            //shadeClose: false,
            content: $('.tong' + obj)
        });
    }

    layui.use(['table', 'form'], function () {
        var table = layui.table, form = layui.form;
        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: "/admin/Member/truename_auth"
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'uid', title: '用户ID', width: 100, unresize: true}
                , {field: 'truename', title: '用户名', unresize: true}
                , {field: 'idcard', title: '身份证号', unresize: true}
                , {
                    field: 'pingtai', title: '平台', unresize: true, templet: function (d) {
                        if (d.pingtai == 1) {
                            return '<font color="red">付</font>';
                        } else {
                            return '<font color="green">卡</font>';
                        }
                    }
                }
                , {
                    field: 'status', width: 120, title: '状态', unresize: true, templet: function (d) {
                        var colors = '';
                        var txt="";
                        if (d.status == 1) {
                            colors = 'green';
                            txt="<?php echo $status_arr[1]; ?>";
                        } else if (d.status == 2) {
                            colors = 'red';
                            txt="<?php echo $status_arr[2]; ?>";
                        } else {
                            txt="<?php echo $status_arr[0]; ?>";
                            colors = 'blue';
                        }
                        return '<font color="' + colors + '">' + txt + '</font>';
                    }
                }
                , {field: 'on_time', width: 180, title: '提交时间', unresize: true, sort: true, templet: '#caeatetime'}
                , {
                    field: 'chuli_desc', title: '处理备注', unresize: true, templet: function (d) {
                        d.chuli_desc=d.chuli_desc ? d.chuli_desc: '';
                        if (d.status == 1) {
                            return '<font color="green">' + d.chuli_desc + '</font>';
                        } else {
                            return '<font color="red">' + d.chuli_desc + '</font>';
                        }
                    }
                }
                , {field: '', width: 180, title: '操作', unresize: true, templet: '#caozuo'}
            ]]
            , id: 'testReload'
            , page: true
            , limit: 20
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
                    status: $('#selresult').val(),
                    search_name: $('#search_name').val(),

                }
            });
        });
        form.on('switch(change)', function (obj) {
            var id = this.value;
            var status = obj.elem.checked;
            if (status == true) {
                type = 1;
            } else {
                type = 2;
            }
            $.post("/admin/article/notice_on", {id: id, type: type}, function (data) {
                layer.msg(data.msg);
            })
        });
        //监听删除编辑操作
        table.on('tool(LAY_table_user)', function (obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            if (layEvent === 'pass' || layEvent === 'not_pass' || layEvent === 'init') {
                var chuli_desc='资料完整，处理成功';
                var check=1;
                if (layEvent == 'not_pass') {
                    //弹出输入处理意见窗口
                    layer.prompt(function(val, index){
                        chuli_desc=val;
                        layer.close(index);
                        check=2;
                        $.post("/admin/Member/truename_status", {id: data.id,'status':check,'chuli_desc':chuli_desc,uid:data.uid}, function (data) {
                            if (data.code == 1) {
                                layer.msg(data.msg, {icon: 1});
                                // obj.update({
                                //     status:check,
                                //     chuli_desc:chuli_desc,
                                // });
                                window.location.reload();
                            } else {
                                layer.msg(data.msg, {icon: 5});
                            }
                        }, 'json')
                        layer.close();
                    });
                }else{
                    if(layEvent == 'init'){
                        chuli_desc='审核已重置';
                        check=0;
                    }
                    $.post("/admin/Member/truename_status", {id: data.id,'status':check,'chuli_desc':chuli_desc,uid:data.uid}, function (data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 1});
                            window.location.reload();
                            // obj.update({
                            //     status:check,
                            //     chuli_desc:chuli_desc,
                            // });
                        } else {
                            layer.msg(data.msg, {icon: 5});
                        }
                    }, 'json')
                }

                layer.close();
            }
        });
    });
</script>

</body>
</html>