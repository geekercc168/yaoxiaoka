<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"/www/wwwroot/yaoxiaoka/application/admin/view/agent/agent_list.html";i:1618384348;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
	.layui-btn+.layui-btn{
		margin-left: 0px;
	}
	.layui-btn-xs{
		padding: 0 3px;
	}
	.layui-table-cell{
		padding: 0 1px;
	}
	.layui-inline{
		margin: 0 0 10px 0
	}
</style>
<body style='background: white;margin: 10px 10px 10px 10px; '> 

<!-- 功能栏 -->
<form class="layui-form" id='form1' style='float: left;'>
	<div class="demoTable" style='margin-left: 10px;'>
		<div class="layui-inline">
			<input type="text" class="layui-input" id="test1" placeholder="搜索注册时间">
		</div>
		<div class="layui-inline">
			<input type="text" name="txt_uid"  id='txt_uid' value="<?php echo $txt_uid; ?>"  placeholder="搜索用户ID" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-inline">
			<input type="text" name="username"  id='username'  placeholder="搜索用户名" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-inline">
			<input type="text" name="mobile"  id='mobile'  placeholder="搜索手机号" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-inline">
			<input type="text" name="qq"  id='qq'  placeholder="搜索qq号" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-inline">
			<select name="px_type" class="px_type" id='px_type' lay-search="">
				<option value="1" >时间倒序</option>
				<option value="2" >余额倒序</option>
				<option value="3" >在线置顶</option>
			</select>
		</div>
		<div class="layui-inline">
			<input type="checkbox" name="xiugai" id="xiugai" lay-filter="xiugai" title="是否改费率" value="1">
		</div>
		<div class="layui-inline">
			<input type="checkbox" name="weidenglu" id="weidenglu" lay-filter="weidenglu" title="30天未登录" value="1">
		</div>
		
	</div>
</form>
<div class="layui-inline" style="margin-left: 10px;">
	<button class='search layui-btn'>搜索</button>
	<button class='api-btn layui-btn'>API文档下载</button>
	<button class='add-btn layui-btn'>新增代理</button>
</div>


<div style='clear:both'></div>

<table class="layui-hide" id="LAY_table_user" lay-filter="LAY_table_user"></table>

<script type="text/html" id="caozuo">
<!-- 这里的 checked 的状态只是演示 -->
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="api-msg">API-信息</a>
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit_hl">改汇率</a>
<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">改信息</a>
<a class="layui-btn layui-btn-primary layui-btn-xs is_del"  lay-event="is_del" value="1">注销</a>
<a class="layui-btn layui-btn-primary layui-btn-xs dongjie"  lay-event="dongjie" value={{ d.group_id==1 ? '0' : '1' }}>{{ d.group_id==1 ? '冻结' : '解冻' }}</a>
<a class="layui-btn layui-btn-primary layui-btn-xs qiangti"  lay-event="qiangti" value="99">强踢</a>
<!--<a class="layui-btn layui-btn-primary layui-btn-xs linshi"  lay-event="linshi" value="1">授权添卡</a>-->
<!--<a class="layui-btn layui-btn-primary layui-btn-xs tixian"  lay-event="tixian" value="1">授权提现</a>-->


</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script type="text/html" id="change">
	<input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="正常|隐藏" lay-filter="change" {{ d.status==1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="time1">
	{{layui.util.toDateString(d.register_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script type="text/html" id="time2">
	{{layui.util.toDateString(d.last_login_time*1000, 'yyyy-MM-dd HH:mm:ss')}}
</script>
<script>

layui.use(['table','form','laydate'], function(){
  var table = layui.table,form = layui.form
	var laydate = layui.laydate;
	//日期范围
	laydate.render({
		elem: '#test1'
		,range: true
		,max: 0
	});
  //方法级渲染
  table.render({
    elem: '#LAY_table_user'
    ,url: "/admin/agent/agent_list?txt_uid=<?php echo $txt_uid; ?>"
    ,cols: [[
      // {checkbox: true, fixed: true}
      {field:'id', title: '用户ID',width:100,  unresize: true}
      ,{field:'username', title: '用户名' }
      ,{field:'truename', title: '姓名' }
      ,{field:'idcard', title: '身份证' ,width:160}
      ,{field:'mobile', title: '手机号' }
      ,{field:'qq', title: 'QQ' }
      ,{field:'zj_cash', title: '资金',templet: "<div>{{d.zj_cash ? '￥'+d.zj_cash : '0.00'}}</div>",sort: true}
	 // ,{field:'up_uid',width:60, title: '上线' }
	 ,{field:'is_login', width:60,title: '状态' ,templet: "<div>{{d.is_login == 1 ? '<span style='color: green'>在线</span>' : '离线'}}</div>",sort: true}
	 ,{field:'register_time',width:140, title: '注册时间' ,sort: true,templet: '#time1'}
      // ,{field:'last_login_time',width:140, title: '登录时间' ,sort: true,templet: '#time2'}
      ,{field:'', width:290, title: '操作',templet: '#caozuo' }
    ]]
    ,id: 'testReload'
    ,page: true
    ,limit: 20
	  , done: function (res) {
		  tdTitle();
	  }
  })
     $('.api-btn').on('click', function(){
		location.href = '/要销卡api文档.doc'
	});
	$('.add-btn').on('click', function(){
		layer.open({
			type: 2,
			title:'新增代理',
			shadeClose: true,
			area: ['80%', '80%'],
			shade: 0.8,
			content: '/admin/agent/add_agent',
		});
	});
	$('.search').on('click', function(){
		//执行重载
		table.reload('testReload', {
			page: {
				curr: 1 //重新从第 1 页开始
			}
			,where: {
				search_time:$('#test1').val(),
				px_type:$('#px_type').val(),
				username:$('#username').val(),
				txt_uid:$('#txt_uid').val(),
				qq:$('#qq').val(),
				mobile:$('#mobile').val(),
				xiugai:$('#xiugai').is(":checked")?1:0,
				weidenglu:$('#weidenglu').is(":checked")?1:0,
			}
		});
	});
	form.on('switch(change)', function(obj){
		var id = this.value;
		var status=obj.elem.checked;
		if (status== true) {
			type=1;
		}else{
			type=0;
		}
		$.post("/admin/member/member_del",{id:id,type:type},function(data){
			layer.msg(data.msg);
		})
	});
  	//监听删除编辑操作
    table.on('tool(LAY_table_user)', function(obj){
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象
        if(layEvent === 'edit'){ //编辑
            var id = data.id;
			layer.open({
				type: 2,
				title:'编辑',
				shadeClose: true,
				area: ['80%', '80%'],
				shade: 0.8,
				content: '/admin/member/add_member?id='+id,
			});
        }
        if(layEvent === 'edit_hl'){ //编辑
            var id = data.id;
			layer.open({
				type: 2,
				title:'编辑',
				shadeClose: true,
				area: ['60%', '90%'],
				shade: 0.8,
				content: '/admin/member/user_profit?uid='+id,
			});
        }
       
        if(layEvent === 'api-msg'){ //api-msg
            var id = data.id;
            var key = data.api_key;
            console.log(data);
			layer.open({
				type: 1,
				title:'API-信息',
				shadeClose: true,
				area: ['500px', '200px'],
				shade: 0.8,
				content: '<br/>&nbsp;&nbsp;&nbsp;商户编号:'+ id + '<br/><br/>&nbsp;&nbsp;&nbsp;商户秘钥:'  + key,
			});
        }
		if(layEvent === 'is_del' || layEvent === 'dongjie'|| layEvent === 'qiangti'|| layEvent === 'linshi'|| layEvent === 'tixian'|| layEvent === 'is_del'){
			var id = data.id;
			var type = tr.find('.'+layEvent).attr('value');
				layer.confirm('您确定操作吗？', {
					btn: ['确定','取消'] //按钮
				}, function(index){
					$.post( "/admin/member/member_del",{id:id,type:type,do:layEvent},function(data){
						if(data.code == 1){
							layer.msg(data.msg, {icon: 1,time:1500},function () {
								$('.search').click();
							});
						}else{
                            layer.msg(data.msg, {icon: 5});
						}
					},'json')
					layer.close(index);
				}, function(){
				});
		}
    });
});
</script>

</body>
</html>