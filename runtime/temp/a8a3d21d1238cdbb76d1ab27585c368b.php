<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/www/wwwroot/yaoxiaoka/application/admin/view/tongdao/dk_edit.html";i:1627020818;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
    <link rel="stylesheet" href="/public//static/admin/kindeditor/themes/default/default.css" />
    <script charset="utf-8" src="/public//static/admin/kindeditor/kindeditor.js"></script>
    <script charset="utf-8" src="/public//static/admin/kindeditor/lang/zh_CN.js"></script>
<div class = 'outermost'>
<div class="layui-card-header" style='border-bottom: none;'>
        <fieldset class="layui-elem-field layui-field-title" style="    margin-top: -7px;">
            <legend >编辑</legend>
        </fieldset>
    </div>
<form class="layui-form" action="">

    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block" style="width: 670px">
          <input type="text" name="title" id='title' value="<?php echo !empty($item['title'])?$item['title'] : ''; ?>" lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属类型</label>
        <div class="layui-input-inline">
            <select name="card_type" id='card_type' lay-verify="required" lay-search="">
                <option value="1" <?php if($item['card_type']==1): ?> selected <?php endif; ?>>话费卡</option>
                <option value="2" <?php if($item['card_type']==2): ?> selected <?php endif; ?>>游戏卡</option>
                <option value="3" <?php if($item['card_type']==3): ?> selected <?php endif; ?>>加油卡</option>
                <option value="4" <?php if($item['card_type']==4): ?> selected <?php endif; ?>>商超卡</option>
                <option value="5" <?php if($item['card_type']==5): ?> selected <?php endif; ?>>电商卡</option>
                <option value="6" <?php if($item['card_type']==6): ?> selected <?php endif; ?>>影视卡</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">渠道费率</label>
        <div class="layui-input-block"  style="width: 670px">
            <table class="layui-table">
                <colgroup>
                <col width="150">
                <col width="150">
                <col width="200">
                <col>
                </colgroup>
                <thead>
                    <tr>
                        <th>系统费率</th>
                        <th>排序</th>
                        <th>接入方</th>
                    </tr> 
                </thead>
                <tbody>
                    <?php foreach($dk_config as $key=>$vo): ?>
                    <tr>
                        
                        <td>
                            <input type="text" name="dk_profit[<?php echo $vo['id']; ?>]"  value="<?php echo $vo['profit']; ?>" lay-verify="required" class="layui-input">
                        </td>
                        <td>
                            <input type="text" name="dk_listorder[<?php echo $vo['id']; ?>]" value="<?php echo $vo['listorder']; ?>" lay-verify="required" class="layui-input">
                        </td>
                        <td>
                            <input type="text" value="<?php echo $tongdao_arr[$vo['tongdao']]; ?>" lay-verify="required" class="layui-input" readonly="true">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php if($item['isanyrate'] ==1): if($item['id'] ==101): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">闲卖移动利润:</label>
        <?php foreach($sys_config['xm_mobile'] as $v): ?>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_mobile[]"  value="<?php echo $v; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <?php endforeach; ?>
        (对应面额分别为100,50,30,20,峰值)
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_mobile_limit" value="<?php echo $sys_config['xm_mobile_limit']; ?>"  class="layui-input">
        </div>
    </div>
    <?php endif; if($item['id'] ==103): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">闲卖联通利润:</label>
        <?php foreach($sys_config['xm_unicom'] as $v): ?>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_unicom[]"  value="<?php echo $v; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <?php endforeach; ?>
        (对应面额分别为100,50,30,20,峰值)

        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_unicom_limit"  value="<?php echo $sys_config['xm_unicom_limit']; ?>"  class="layui-input">
        </div>
    </div>
    <?php endif; if($item['id'] ==102): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">闲卖电信利润:</label>
        <?php foreach($sys_config['xm_telecom'] as $v): ?>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_telecom[]"  value="<?php echo $v; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <?php endforeach; ?>
        (对应面额分别为100,50,30,20,峰值)
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_telecom_limit"  value="<?php echo $sys_config['xm_telecom_limit']; ?>"  class="layui-input">
        </div>
    </div>
    <?php endif; if($item['id'] ==101): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">速销卡移动利润:</label>
        <div class="layui-input-inline" style="width: 100px;" >
            <input type="text" name="sxk_mobile" id='sxk_mobile' value="<?php echo $sys_config['sxk_mobile']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sxk_mobile_limit"  value="<?php echo $sys_config['sxk_mobile_limit']; ?>"  class="layui-input">
        </div>
        (利润,峰值)
    </div>
    <?php endif; if($item['id'] ==103): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">速销卡联通利润:</label>
        <div class="layui-input-inline" style="width: 100px;" >
            <input type="text" name="sxk_unicom" id='sxk_unicom' value="<?php echo $sys_config['sxk_unicom']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sxk_unicom_limit"  value="<?php echo $sys_config['sxk_unicom_limit']; ?>"  class="layui-input">
        </div>
        (利润,峰值)
    </div>
    <?php endif; if($item['id'] ==102): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">速销卡电信利润:</label>
        <div class="layui-input-inline"  style="width: 100px;">
            <input type="text" name="sxk_telecom" id='sxk_telecom' value="<?php echo $sys_config['sxk_telecom']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sxk_telecom_limit"  value="<?php echo $sys_config['sxk_telecom_limit']; ?>"  class="layui-input">
        </div>
        (利润,峰值)
    </div>
    <?php endif; endif; ?>

    <div class="layui-form-item">
        <label class="layui-form-label">用户费率</label>
        <div class="layui-input-inline">
            <input type="text" name="zc_profit" id='zc_profit' value="<?php echo $item['zc_profit']; ?>" lay-verify="required" placeholder="请输入注册费率" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">  注：如只有一个值表示以下面值费率都相同。如果面值与费率不一致，需依次填写并用英文逗号,隔开
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卡面值</label>
        <div class="layui-input-block" style="width: 670px">
            <input type="text" name="money" id='money' value="<?php echo $item['money']; ?>" lay-verify="required" placeholder="卡面值(10,20,30....)" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否需卡号</label>
        <div class="layui-input-inline">
            <input type="checkbox" name="card" value="<?php echo $item['card']; ?>" lay-skin="switch" lay-text="是|否" <?php if($item['card']=="1"): ?> checked="checked"<?php endif; ?>>
            </div>
        <label class="layui-form-label">是否需卡密</label>
        <div class="layui-input-inline">
            <input type="checkbox" name="pwd" value="<?php echo $item['pwd']; ?>" lay-skin="switch" lay-text="是|否" <?php if($item['pwd']=="1"): ?> checked="checked"<?php endif; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="listorder" id='listorder' value="<?php echo $item['listorder']; ?>" lay-verify="required" placeholder="排序(越小越靠前)" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">图标</label>
        <div class="layui-input-inline">
            <div class="layui-upload" style='width: 700px;'>
                <input style='width: 370px; float: left; ' type="hidden" class="layui-input" id='img' name="img" placeholder="可填写可上传" value="<?php echo !empty($item['img'])?$item['img'] : ''; ?>">
                <button  type="button" class="layui-btn" id="upload_pic">上传图片</button>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="demo"  src="<?php echo !empty($item['img'])?$item['img']:'/data/default.png'; ?>" style="width:80px;height:80px;" >
                </div>
            </div>
        </div>
    </div>
	<div class="layui-form-item">
        <label class="layui-form-label">卡密规则</label>
        <div class="layui-input-block">
          <textarea class="layui-textarea" name="content" id='content' lay-verify="content" style="width:400px;height: 200px" ><?php echo !empty($item['content'])?$item['content'] : ''; ?></textarea>
        </div>
    </div>
    <input type="hidden" name='id' id='id' value="<?php echo $item['id']; ?>">
    <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn" type='submit' lay-submit lay-filter="formDemo">立即提交</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form></div>

<script>
//Demo
layui.use('form', function(){
  var form = layui.form;

  //监听提交
    layui.use(['layer', 'form', 'table', 'upload'], function() {
        var layer = layui.layer, form = layui.form, table = layui.table,upload = layui.upload;
        //监听提交
        //普通图片上传
        upload.render({
            elem: '#upload_pic'
            ,url: "/admin/index/img_upload"
            , data: {"type":1}
            ,before: function(obj){
                layer.msg('上传中',{icon:16,time:false});
                // obj.preview(function(index, file, result){
                //     $('#demo').attr('src', result); //图片链接（base64）
                // });
            }
            ,done: function(res){
                //layer.msg(res.err);
                layer.closeAll();
                if(res.info==0){
                    layer.msg(res.err,{icon:5,time:2000});
                }else{
                    $('#img').val(res.data.src);
                    $('#demo').attr('src', res.data.src); //图片链接（base64）
                }
            }
            ,error: function(res){
                //请求异常回调
                layer.msg(res.err,{icon:5});
                layer.closeAll();
            }
        })
        form.on('submit(formDemo)', function (data) {
            var img = $('#img').val();
           // var old_path = $('#old_path').val();
            if (img=='') {
                layer.msg('请上传图片，图片不可以为空！！');
                return false;
            }
            $.post("/admin/Tongdao/dk_edit", $('.layui-form').serialize(), function (data) {
                if (data.code == 1) {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    layer.msg(data.msg, {icon: 1});
                    setTimeout(function () {
                        parent.layer.close(index);
                        //修改成功刷新父页面
                        if ($('#id').val()) {
                            window.parent.location.reload();
                        } else {
                            //添加页面直接返回上一页并刷新
                            window.location.reload();
                        }

                    }, 1000); //再执行关闭

                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            }, 'json')
            return false;
        });
    });
    });
</script>