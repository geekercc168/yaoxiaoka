<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:61:"/www/wwwroot/yaoxiaoka/application/admin/view/finance/tj.html";i:1608625283;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
            <select class="stype" id='stype' lay-search="">
                <option value="">选择卡种</option>
                <?php foreach($type_arr as $k=>$v): ?>
                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="layui-inline">
            <select class="txt_tongdao" id='txt_tongdao' lay-search="">
                <option value="">选择通道</option>
                <?php foreach($tongdao_arr as $k=>$v): ?>
                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</form>
<button class='search layui-btn'>搜索</button>

<div style='clear:both'></div>
<blockquote class="layui-elem-quote">
    <div class="layui-inline">
        当日：
        平台盈利：<font color=red><?php echo !empty($day_total_yl)?$day_total_yl:0; ?></font>  &nbsp;&nbsp;
        <?php if($is_power==1): ?>
        周盈利：<font color=red><?php echo !empty($tongji_res['zhouyingli'])?$tongji_res['zhouyingli']:0; ?></font> &nbsp;&nbsp;
        月盈利：<font color=red><?php echo !empty($tongji_res['yueyingli'])?$tongji_res['yueyingli']:0; ?></font> &nbsp;&nbsp;
        上月盈利：<font color=red><?php echo !empty($tongji_res['shangyueyingli'])?$tongji_res['shangyueyingli']:0; ?> </font> &nbsp;&nbsp;
        总盈利：<font color=red><?php echo !empty($tongji_res['zongyingli'])?$tongji_res['zongyingli']:0; ?>  </font>
        <?php else: endif; ?>
    </div>
    <br>
    <div class="layui-inline">
        昨日：
        平台盈利：<font color=red><?php echo !empty($tongji_res['zuoyingli'])?$tongji_res['zuoyingli']:0; ?></font> &nbsp;&nbsp;
        销卡盈利：<font color=red><?php echo !empty($tongji_res['riyingli'])?$tongji_res['riyingli']:0; ?></font> &nbsp;&nbsp;
        平台所得：<font color=red><?php echo !empty($tongji_res['zuoptsuode'])?$tongji_res['zuoptsuode']:0; ?></font> &nbsp;&nbsp;
        用户所得：<font color=red><?php echo !empty($tongji_res['zuoyhsuode'])?$tongji_res['zuoyhsuode']:0; ?></font> &nbsp;&nbsp;
<!--        上线利润：<font color=red><?php echo $tongji_res['zuosxlirun']; ?></font> &nbsp;&nbsp;-->
        用户汇总：<font color=red><?php echo !empty($tongji_res['zuoyhhuizong'])?$tongji_res['zuoyhhuizong']:0; ?></font> &nbsp;&nbsp;
        盈利率：<font color=red><?php echo !empty($tongji_res['zuoyinglilv'])?$tongji_res['zuoyinglilv']:0; ?></font> &nbsp;&nbsp;
        销卡人数：<font color=red><?php echo !empty($tongji_res['zuoxiaokarenshu'])?$tongji_res['zuoxiaokarenshu']:0; ?></font>  &nbsp;&nbsp;
        提现金额：<font color=red><?php echo !empty($tongji_res['zuotixianjine'])?$tongji_res['zuotixianjine']:0; ?></font> &nbsp;&nbsp;
        新注册：<font color=red><?php echo !empty($tongji_res['zuoxinzhuce'])?$tongji_res['zuoxinzhuce']:0; ?></font> &nbsp;&nbsp;
        未提现金额：<font color=red><?php echo !empty($tongji_res['zuoweitixian'])?$tongji_res['zuoweitixian']:0; ?></font> &nbsp;&nbsp;
        未处理金额：<font color=red><?php echo !empty($tongji_res['zuoweichuli'])?$tongji_res['zuoweichuli']:0; ?></font> &nbsp;
    </div>
</blockquote>
<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 }-->
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
            , url: "/admin/Finance/tj"
            ,totalRow:true
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'uid', title: '用户ID',totalRowText:'统计：'}
                , {field: 'username', title: '用户名称'}
                , {field: 'total_num', title: '订单总数'}
                , {field: 'chenggong', style:'color:green',title: '成功总数'}
                , {field: 'shibai', style:'color:red',title: '失败总数'}
                , {field: 'chulizhong',style:'color:blue', title: '处理中'}
                , {field: 'succ_cash',style:'color:#eb0057', title: '销卡金额'}
                , {field: 'yidong',style:'color:#FF7B0E', title: '移动'}
                , {field: 'dianxin',style:'color:#FF7B0E', title: '电信'}
                , {field: 'liantong',style:'color:#1BB974', title: '联通'}
                , {field: 'pt_lirun',style:'color:#1BB974', title: '平台获利'}
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
                    search_time: $('#test1').val(),
                    txt_tongdao: $('#txt_tongdao').val(),
                    txt_uid: $('#txt_uid').val(),
                    stype: $('#stype').val(),
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