<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/www/wwwroot/yaoxiaoka/application/admin/view/tongdao/dk_list.html";i:1602297182;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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

<div style='clear:both'></div>

<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="change">
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="change" {{
           d.status==1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="caozuo">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">编辑</a>
</script>

<script>

    layui.use(['table', 'form', 'upload'], function () {
        var table = layui.table, form = layui.form;

        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: "/admin/Tongdao/dk_list"
            , cols: [[
                {field: 'id', title: '编号', unresize: true}
                , {field: 'title', title: '点卡名称', unresize: true}
                , {field: 'zc_profit', title: '用户费率', unresize: true}
                , {
                    field: 'card_type', title: '卡类型', unresize: true, templet: function (d) {
                        var type = '';
                        if (d.card_type == 1) {
                            type = '话费卡';
                        } else if (d.card_type == 2) {
                            type = '游戏卡';
                        } else if (d.card_type == 3) {
                            type = '加油卡';
                        } else if (d.card_type == 4) {
                            type = '商超卡';
                        } else if (d.card_type == 5) {
                            type = '电商卡';
                        } else if (d.card_type == 6) {
                            type = '影视卡';
                        }
                        return type;
                    }
                }

                , {field: 'img', title: 'logo', unresize: true, templet: function (d) {
                        if(d.img){
                            return "<img style='max-width: 80px;height: 80px' src="+d.img+">";
                        }else{
                            return ''
                        }

                    }}
                , {field: 'content', title: '卡密规则', unresize: true}
                , {field: 'status', title: '卡种状态', unresize: true, templet: '#change'}
                , {field: '', title: '操作', unresize: true, templet: '#caozuo'}
            ]]
            , id: 'testReload'
            //,page: true
            , limit: 100
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
                    search_name: $('#search_name').val(),

                }
            });
        });
        //监听单元格编辑
        table.on('edit(LAY_table_user)', function (obj) {
            var v = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            //console.log(data);return;
            var id = data.id;
            var value = $.trim(v);
            //layer.alert('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);return false;
            $.post("/admin/Tongdao/dk_fild", {
                id: id, field: field,
                value: value, type: data.type, zc_profit: data.zc_profit
            }, function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            })
        });

        form.on('switch(change)', function (obj) {
            var id = this.value;
            console.log(obj);
            var status = obj.elem.checked;
            if (status == true) {
                type = 1;
            } else {
                type = 0;
            }
            $.post("/admin/Tongdao/dk_status", {id: id, type: type}, function (data) {
                layer.msg(data.msg);
            },'json')
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
                    content: '/admin/Tongdao/dk_edit?id=' + id,
                });
            }
        });
    });
</script>

</body>
</html>