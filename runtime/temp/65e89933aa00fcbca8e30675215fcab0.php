<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"/www/wwwroot/yaoxiaoka/application/admin/view/tongdao/sys_config.html";i:1627037848;s:64:"/www/wwwroot/yaoxiaoka/application/admin/view/common/header.html";i:1614909998;}*/ ?>
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
    .layui-form-item>label{
        width: 120px;
    }
    .zdcx>li{
        margin: 10px;
    }
    .zdcx>li>a{
        color: blue !important;
    }
</style>
<div class = 'outermost'>
<div class="layui-card-header" style='border-bottom: none;'>
        <fieldset class="layui-elem-field layui-field-title" style="    margin-top: -7px;">
            <legend >通道配置</legend>
        </fieldset>
    </div>
<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">通道排队限制数:</label>
        <div class="layui-input-inline" >
            <input type="type" name="order_count" id='order_count' value="<?php echo $item['order_count']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">闲卖移动利润:</label>
        <?php foreach($item['xm_mobile'] as $v): ?>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_mobile[]"  value="<?php echo $v; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <?php endforeach; ?>
        (对应面额分别为100,50,30,20,峰值)
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_mobile_limit" value="<?php echo $item['xm_mobile_limit']; ?>"  class="layui-input">
        </div>
    </div>
   
    <div class="layui-form-item">
        <label class="layui-form-label">闲卖联通利润:</label>
        <?php foreach($item['xm_unicom'] as $v): ?>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_unicom[]"  value="<?php echo $v; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <?php endforeach; ?>
        (对应面额分别为100,50,30,20,峰值)

        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_unicom_limit"  value="<?php echo $item['xm_unicom_limit']; ?>"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">闲卖电信利润:</label>
        <?php foreach($item['xm_telecom'] as $v): ?>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_telecom[]"  value="<?php echo $v; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <?php endforeach; ?>
        (对应面额分别为100,50,30,20,峰值)
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="xm_telecom_limit"  value="<?php echo $item['xm_telecom_limit']; ?>"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">速销卡移动利润:</label>
        <div class="layui-input-inline" style="width: 100px;" >
            <input type="text" name="sxk_mobile" id='sxk_mobile' value="<?php echo $item['sxk_mobile']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sxk_mobile_limit"  value="<?php echo $item['sxk_mobile_limit']; ?>"  class="layui-input">
        </div>
        (利润,峰值)
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">速销卡联通利润:</label>
        <div class="layui-input-inline" style="width: 100px;" >
            <input type="text" name="sxk_unicom" id='sxk_unicom' value="<?php echo $item['sxk_unicom']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sxk_unicom_limit"  value="<?php echo $item['sxk_unicom_limit']; ?>"  class="layui-input">
        </div>
        (利润,峰值)
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">速销卡电信利润:</label>
        <div class="layui-input-inline"  style="width: 100px;">
            <input type="text" name="sxk_telecom" id='sxk_telecom' value="<?php echo $item['sxk_telecom']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="text" name="sxk_telecom_limit"  value="<?php echo $item['sxk_telecom_limit']; ?>"  class="layui-input">
        </div>
        (利润,峰值)
    </div>
    <div class="layui-form-item">
        <div class="layui-container"> 
            <div class="layui-row">
                <div class="layui-col-md12">
                    <table class="layui-table">
                        <thead>
                            <tr>
                                <th>卡种</th>
                                <th>面值</th>
                                <th>时间范围(分钟)如：5-8</th>
                                <th>折扣范围(超快销)如：90-95</th>
                                <th>状态</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <!-- 联通(慢销) -->
                                <tr>
                                    <td rowspan="4">联通(慢销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="ltmx_20"  value="<?php echo cache('ltmx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td rowspan="4">--</td>
                                    <td>
                                        <input type="checkbox" name="ltmxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltmxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="ltmx_30"  value="<?php echo cache('ltmx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltmxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltmxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="ltmx_50"  value="<?php echo cache('ltmx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltmxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltmxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="ltmx_100"  value="<?php echo cache('ltmx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltmxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltmxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 联通(慢销) -->

                            <!-- 联通(快销) -->
                                <tr>
                                    <td rowspan="4">联通(快销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="ltkx_20"  value="<?php echo cache('ltkx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td rowspan="4">--</td>
                                    <td>
                                        <input type="checkbox" name="ltkxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltkxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="ltkx_30"  value="<?php echo cache('ltkx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltkxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltkxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="ltkx_50"  value="<?php echo cache('ltkx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltkxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltkxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="ltkx_100"  value="<?php echo cache('ltkx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltkxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltkxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 联通(快销) -->

                            <!-- 联通(超快销) -->
                                <tr>
                                    <td rowspan="4">联通(超快销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="ltckx_20"  value="<?php echo cache('ltckx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ltckxCk_20"  value="<?php echo cache('ltckxCk_20'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltckxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltckxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="ltckx_30"  value="<?php echo cache('ltckx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ltckxCk_30"  value="<?php echo cache('ltckxCk_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltckxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltckxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="ltckx_50"  value="<?php echo cache('ltckx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ltckxCk_50"  value="<?php echo cache('ltckxCk_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltckxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltckxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="ltckx_100"  value="<?php echo cache('ltckx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ltckxCk_100"  value="<?php echo cache('ltckxCk_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ltckxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ltckxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 联通(快销) -->

                            <!-- 移动(慢销) -->
                                <tr>
                                    <td rowspan="4">移动(慢销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="ydmx_20"  value="<?php echo cache('ydmx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td rowspan="4">--</td>
                                    <td>
                                        <input type="checkbox" name="ydmxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydmxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="ydmx_30"  value="<?php echo cache('ydmx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydmxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydmxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="ydmx_50"  value="<?php echo cache('ydmx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydmxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydmxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="ydmx_100"  value="<?php echo cache('ydmx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydmxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydmxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 移动(慢销) -->

                            <!-- 移动(快销) -->
                                <tr>
                                    <td rowspan="4">移动(快销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="ydkx_20"  value="<?php echo cache('ydkx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td rowspan="4">--</td>
                                    <td>
                                        <input type="checkbox" name="ydkxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydkxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="ydkx_30"  value="<?php echo cache('ydkx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydkxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydkxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="ydkx_50"  value="<?php echo cache('ydkx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydkxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydkxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="ydkx_100"  value="<?php echo cache('ydkx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydkxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydkxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 移动(快销) -->

                            <!-- 移动(超快销) -->
                                <tr>
                                    <td rowspan="4">移动(超快销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="ydckx_20"  value="<?php echo cache('ydckx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ydckxCk_20"  value="<?php echo cache('ydckxCk_20'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydckxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydckxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="ydckx_30"  value="<?php echo cache('ydckx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ydckxCk_30"  value="<?php echo cache('ydckxCk_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydckxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydckxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="ydckx_50"  value="<?php echo cache('ydckx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ydckxCk_50"  value="<?php echo cache('ydckxCk_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydckxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydckxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="ydckx_100"  value="<?php echo cache('ydckx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="ydckxCk_100"  value="<?php echo cache('ydckxCk_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="ydckxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('ydckxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 移动(快销) -->

                            <!-- 电信(慢销) -->
                                <tr>
                                    <td rowspan="4">电信(慢销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="dxmx_20"  value="<?php echo cache('dxmx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td rowspan="4">--</td>
                                    <td>
                                        <input type="checkbox" name="dxmxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxmxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="dxmx_30"  value="<?php echo cache('dxmx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxmxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxmxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="dxmx_50"  value="<?php echo cache('dxmx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxmxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxmxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="dxmx_100"  value="<?php echo cache('dxmx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxmxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxmxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 电信(慢销) -->

                            <!-- 电信(快销) -->
                                <tr>
                                    <td rowspan="4">电信(快销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="dxkx_20"  value="<?php echo cache('dxkx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td rowspan="4">--</td>
                                    <td>
                                        <input type="checkbox" name="dxkxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxkxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="dxkx_30"  value="<?php echo cache('dxkx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxkxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxkxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="dxkx_50"  value="<?php echo cache('dxkx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxkxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxkxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="dxkx_100"  value="<?php echo cache('dxkx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxkxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxkxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 电信(快销) -->

                            <!-- 电信(超快销) -->
                                <tr>
                                    <td rowspan="4">电信(超快销)</td>
                                    <td>20</td>
                                    <td>
                                        <input type="text" name="dxckx_20"  value="<?php echo cache('dxckx_20'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="dxckxCk_20"  value="<?php echo cache('dxckxCk_20'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxckxSt_20" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxckxSt_20') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>30</td>
                                    <td>
                                        <input type="text" name="dxckx_30"  value="<?php echo cache('dxckx_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="dxckxCk_30"  value="<?php echo cache('dxckxCk_30'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxckxSt_30" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxckxSt_30') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>50</td>
                                    <td>
                                        <input type="text" name="dxckx_50"  value="<?php echo cache('dxckx_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="dxckxCk_50"  value="<?php echo cache('dxckxCk_50'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxckxSt_50" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxckxSt_50') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td>100</td>
                                    <td>
                                        <input type="text" name="dxckx_100"  value="<?php echo cache('dxckx_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="text" name="dxckxCk_100"  value="<?php echo cache('dxckxCk_100'); ?>"  class="layui-input">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dxckxSt_100" lay-skin="switch" lay-text="开启|关闭" lay-filter="switchTest" value="1" <?php if((cache('dxckxSt_100') == 1)): ?>checked<?php endif; ?>>
                                    </td>
                                </tr>
                            <!-- 电信(快销) -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-inline">
          <button class="layui-btn" type='button' lay-submit lay-filter="formDemo">立即提交</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>

    </div>
</form>
    <div class="zdcx">
        <!-- <li><a href="/zdcx_hst" target="_blank" style="text-decoration:underline;">汇速通主动查询</a></li> -->
        <li onclick="go_check('/zdcx_sxk','速销卡主动查询')"><a href="javascript:;" style="text-decoration:underline;">速销卡主动查询</a></li>
        <!-- <li><a href="/zdcx_sup" target="_blank" style="text-decoration:underline;">sup(新讯银)主动查询</a></li> -->
        <!-- <li><a href="/zdcx_xkl" target="_blank" style="text-decoration:underline;">销卡啦主动查询</a></li> -->
        <li onclick="go_check('/zdcx_xm','闲卖主动查询')"><a href="javascript:;" style="text-decoration:underline;">闲卖主动查询</a></li>
    </div>
</div>


<script>
//Demo
layui.use('form', function(){
  var form = layui.form;

  //监听提交
    layui.use(['layer', 'form', 'table', 'upload'], function() {
        var layer = layui.layer, form = layui.form, table = layui.table,upload = layui.upload;
        form.on('submit(formDemo)', function (data) {
            $.post("/admin/Tongdao/sys_config", $('.layui-form').serialize(), function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1,time:1500},function () {
                            window.location.reload();
                    });
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            }, 'json')
            return false;
        });
    });
    });
    function go_check(url,title){

        layer.open({
            // type: 1,
            title:[title, 'text-align:center'],
            shadeClose: true,
            area: ['50%', '300px'],
            shade: 0.8,
            content: '<div class="layui-form-item"><label class="layui-form-label" style="width: 80px;">订单号</label><div class="layui-input-block"><input type="text" name="orderid" placeholder="请输入订单号" autocomplete="off" class="layui-input"></div></div><div class="layui-form-item"><label class="layui-form-label" style="width: 80px;"></label><div class="layui-input-inline"><input style="display:none" type="text" name="check_result" lay-vertype="tips" autocomplete="off" class="layui-input"></div><div class="layui-form-mid layui-word-aux"></div></div><div class="layui-form-item"><div class="layui-input-block btn-check-now"><button class="layui-btn" lay-filter="formDemo" onclick=\'go_check_url("'+url+'")\'>立即提交</button></div></div>',
            btn: ''
        });
        
    }
    
    function go_check_url(url){
        let orderid = $( "input[name='orderid']").val()
        $.get(url, {'show':1,'orderid':orderid}, function(res){
            if(res.code == 0){
                $( "input[name='check_result']").css('display','block');
                $( "input[name='check_result']").val(res.msg)  
            }else{
                layer.msg(res.msg);
            }
        });
    }
</script>