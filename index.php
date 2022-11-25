<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// echo '<html><head><title>403 Forbidden</title></head>
// <body>
// <center><h1>403 Forbidden</h1></center>
// <hr><center>nginx</center>


// <!-- a padding to disable MSIE and Chrome friendly error page -->
// <!-- a padding to disable MSIE and Chrome friendly error page -->
// <!-- a padding to disable MSIE and Chrome friendly error page -->
// <!-- a padding to disable MSIE and Chrome friendly error page -->
// <!-- a padding to disable MSIE and Chrome friendly error page -->
// <!-- a padding to disable MSIE and Chrome friendly error page -->
// </body></html>';exit;
// [ 应用入口文件 ]
// echo '维护中1';die;
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 加载框架引导文件
// define('BIND_MODULE','test');
define("WEB_URL","http://1xiaoka.com/");
define("IMG_URL","");
define("Android_URL",'');
define("IOS_URL","");
define("PAGESIZE","20");//分页默认数量

require __DIR__ . '/thinkphp/start.php';

// \think\Build::module('test');