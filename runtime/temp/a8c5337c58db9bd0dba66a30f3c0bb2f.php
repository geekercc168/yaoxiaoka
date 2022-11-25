<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"/www/wwwroot/yaoxiaoka/application/admin/view/main/m_index.html";i:1608626247;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>要销卡平台-提供充值卡回收|点卡回收， 充值卡兑换|点卡兑换， 充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/public/static/admin/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/admin/layuiadmin/style/admin.css?v=<?php echo time(); ?>" media="all">
    <script src="/public/static/admin/layuiadmin/layui/layui.js"></script>
    <script src="/public/static/admin/js/jquery.js"></script>
    <link rel="stylesheet" href="/public/static/admin/layuiadmin/style/login.css?v=1.0" media="all">
    <link rel="stylesheet" href="/public/wap/css/style_mobile.css?v=<?php echo time(); ?>">
</head>
<style>
    .acc_list_m li{
        position: relative;
        border-bottom: 1px solid #eee;
        padding: 10px;
    }
    .acc_list_m li>h3 {
        padding: 16px 0 12px 12px;
        font-size: 18px;
        font-weight: 500;
    }
    .madmin_index>a{
        display: block;
        /*position: absolute;*/
        /*right: 12px;*/
        /*bottom: 24px;*/
        padding: 4px;
        /*height: 24px;*/
        background-color: #5673ff;
        border-radius: 2px;
        color: #fff;
        font-size: 12px;
        line-height: 24px;
        margin: 5px 5px 5px 5px;
    }
</style>

<div class="acc_list_m">
    <ul>
        <?php foreach($list as $v): ?>
        <li>
            <h3 class=""><?php echo $v['submenu_name']; ?></h3>
            <div class="madmin_index">
                <?php foreach($v['erji'] as $t): ?>
                <a href="/<?php echo $t['resource_url']; ?>"><?php echo $t['resource_name']; ?></a>
                <?php endforeach; ?>
            </div>
        </li>
        <?php endforeach; ?>

    </ul>
</div>