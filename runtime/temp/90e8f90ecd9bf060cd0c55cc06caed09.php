<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:107:"C:\Users\geeker_yuyu\Desktop\coder\workspace\A-jobstack\yaoxiaoka/application/admin\view\member\orders.html";i:1628503125;s:107:"C:\Users\geeker_yuyu\Desktop\coder\workspace\A-jobstack\yaoxiaoka\application\admin\view\common\header.html";i:1614909998;}*/ ?>
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
    .layui-inline{
        margin: 0 0 10px 0
    }
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '>

<!-- 功能栏 -->

    <div class="demoTable" style='margin-left: 10px;'>
        <form class="layui-form" id='form1' style='float: left;'>
        <div class="layui-inline" style="width: 300px;">
            <input type="text" class="layui-input" id="test1" placeholder="<?php echo date('Y-m-d',time()); ?> 00:00:00 - " value="">
        </div>
        <div class="layui-inline">
            <select class="px_type" id='stype' lay-search="">
                <option value="">选择卡种</option>
                <?php foreach($type_arr as $k=>$v): ?>
                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="layui-inline">
            <input type="checkbox" id="agains" lay-filter="agains" title="可重提" value="1">
        </div>
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
                <option value="">状态</option>
                <option value="1">成功</option>
                <option value="2">失败</option>
                <option value="0">处理中</option>
                <option value="666">金额不符</option>
                <option value="3">其他</option>
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
<!--        <div class="layui-inline">-->
<!--            <select class="txt_fenzu" id='txt_fenzu' lay-search="">-->
<!--                <option value="">选择分组</option>-->
<!--                <?php foreach($fenzu_arr as $k=>$v): ?>-->
<!--                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>-->
<!--                <?php endforeach; ?>-->
<!--            </select>-->
<!--        </div>-->

        <div class="layui-inline">
            <input type="text" id='txt_uid' placeholder="搜索用户ID" autocomplete="off"
                   class="layui-input" value="<?php echo $txt_uid; ?>">
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
            <input type="text" id='txt_pici' placeholder="搜索批次" autocomplete="off" value="<?php echo $txt_pici; ?>"
                   class="layui-input">
        </div>
        <div class="layui-inline">
            
            <button class='layui-btn layui-btn-warm' type="button" id="export" >导出</button>
            <button class='layui-btn again_init' type="button" tid="88" >重提原</button>
            <button class='layui-btn again_init' type="button" tid="6">重提速</button>
            <button class='layui-btn again_init' type="button" tid="99">重提速急</button>
            <button class='layui-btn again_init' type="button" tid="2">重提汇</button>
            <button class='layui-btn again_init' type="button" tid="11">重提闲</button>
            <button class='search layui-btn' type="button">搜索</button>
        </div>

        <div class="layui-inline item-date">
            <span class="layui-btn layui-btn-primary" data-item="yestoday">昨天</span>
            <span class="layui-btn layui-btn-primary" data-item="today">今天</span>
            <span class="layui-btn layui-btn-primary" data-item="lastWeek">近一周</span>
            <span class="layui-btn layui-btn-primary" data-item="lastMonth">近一个月</span>
            <span class="layui-btn layui-btn-primary" data-item="month">近三个月</span>
        </div>
        
        </form>
    </div>
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
            , url: "/admin/member/orders1?api=<?php echo $api; ?>&txt_uid=<?php echo $txt_uid; ?>&search_time=<?php echo $search_time; ?>&txt_pici=<?php echo $txt_pici; ?>&selresult=<?php echo $selresult; ?>"
            ,totalRow: true
            , cols: [[
                // {checkbox: true, fixed: true}
                {field: 'orderid', title: '订单号', width: 200,totalRowText:'合计：'}
                , {field: 'total_orderid', title: '批次', width: 120}
                , {field: 'uid', title: '编号',templet:function (d) {
                        return "<a href='/admin/member/member_list/?txt_uid="+d.uid+"' target='_blank'><font color='green'>"+d.uid+"</font></a>"
                        // return '<div >'+d.uid+'</div>';
                    }}
                , {field: 'kazhong', title: '卡种',width: 60 }
                , {field: 'crad_number', title: '卡号',width: 150}
                <?php if(( $group_id == 1)): ?>
                , {field: 'crad_pass', title: '卡密',width: 160}
                <?php endif; ?>
                , {field: 'cash', title: '提面'}
                , {field: 'realvalue', title: '实面'}
                , {field: 'incash', title: '结算'}
                , {field: 'successAmount', title: '渠道价'}
                , {field: 'on_time',width: 110, title: '提交'}
                , {field: 'end_time',width: 110, title: '处理'}
                , {field: 'td_txt', title: '通道',width: 60}
                , {field: 'xt_huilv', title: '系统率',unresize: true}
                // , {field: 'agent_huilv', title: '代理率'}
                , {field: 'user_huilv', title: '用户率'}
                , {
                    field: '', title: '描述',  templet: function (d) {
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
                , {
                    field: 'status', width: 60, title: '状态', templet: function (d) {
                        var colors = 'blue';
                        if (d.status == 1) {
                            colors = 'green';
                            //return '<font color="' + colors + '">成功</font>';
                        } else if (d.status == 2) {
                            colors = 'red';
                            //return '<font color="' + colors + '">处理中</font>';
                        }
                       return '<font color="' + colors + '">' + d.status_txt + '</font>';
                        
                    }
                }, {
                    field: 'tongzhi_status', width: 60, title: '通知状态', templet: function (d) {
                        var colors = 'blue';
                        if (d.tongzhi_status == 0 && d.callbackURL != '0') {
                            colors = 'red';
                            return '<font color="' + colors + '">未通知</font>';
                        } else if (d.tongzhi_status == 1 && d.callbackURL != '0') {
                            colors = 'green';
                            return '<font color="' + colors + '">已通知</font>';
                        }else{
                            return '-';
                        }
                        
                    }
                }
                , {field: '', width: 60, title: '操作', templet: '#caozuo'}
            ]]
            , id: 'testReload'
            , page: true
            , limit: 20
            , done: function (res,curr,count) {
                tdTitle();
            }
        })
        var excel = layui.excel;
        $('.again_init').on('click',function () {
            var tid = $(this).attr('tid');
            layer.prompt({title: '请输入最新的系统汇率：'},function (val, index) {
                if(val>=100 || val<=0){
                    layer.msg('系统汇率设置错误');return;
                }
                $.post("/admin/Member/again_init", {
                    again_td: tid,
                    xt_huilv: val,
                    search_time: $('#test1').val(),
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
                }, function (data) {
                    if (data.code == 1) {
                        layer.msg(data.msg, {icon: 1,time:2000},function () {
                            $('.search').click();
                        });
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }
                }, 'json')
                layer.close(index);
            });
        })
        $('#export').on('click',function () {
            //使用ajax请求获取所有数据
            $.ajax({
                url: "/admin/member/orders",
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