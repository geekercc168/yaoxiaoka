<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use \think\Request;
// 异常错误报错级别,
error_reporting(E_ERROR | E_PARSE );

$basename = Request::instance()->root();
if (pathinfo($basename, PATHINFO_EXTENSION) == 'php') {
    $basename = dirname($basename);
}

define("ZFB_Public_key","MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmdmISHihV6e6K/0wqVLpCyfAh2YNLLFzFQ3g3tIkaNCKjYsCPczXxM/airFVyt1xF5vcSNeCiDBlE+a6i+dah7ttrF6K2WPjO8m3v5xPfuCZRkqbAP3zPYhRzlAml9UsVVUl7WZpli2LnjMEbEFQ5/wrr8OZnfplQPWo1I1KYDnf8X9skWmwpyljNxXkFlXBFhLeK1tn+n4cTIaowfKx5cznzLMx1/BnsHZjfwP2WetNWFr+iolsLyl7lKbTsW0mHTP8Jkg/QJAhKuo5tAc1oJYd8qeIgZUnYFnLkStSAXdpLlu9QAIvk2N/SocgQoOFu1OL/OQWrx6QVCvy5Zn3MwIDAQAB");//支付宝公钥
define("ZFB_Private_key","MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCZ2YhIeKFXp7or/TCpUukLJ8CHZg0ssXMVDeDe0iRo0IqNiwI9zNfEz9qKsVXK3XEXm9xI14KIMGUT5rqL51qHu22sXorZY+M7ybe/nE9+4JlGSpsA/fM9iFHOUCaX1SxVVSXtZmmWLYueMwRsQVDn/Cuvw5md+mVA9ajUjUpgOd/xf2yRabCnKWM3FeQWVcEWEt4rW2f6fhxMhqjB8rHlzOfMszHX8GewdmN/A/ZZ601YWv6KiWwvKXuUptOxbSYdM/wmSD9AkCEq6jm0BzWglh3yp4iBlSdgWcuRK1IBd2kuW71AAi+TY39KhyBCg4W7U4v85BavHpBUK/LlmfczAgMBAAECggEART4akEN6mjDrIZE6rXqbWGHzzPypQUw8N2Wfp6l8qY/yS/IceCQRmIrUGUfnDP7NP4rugfo8zX66f1KA8yaVIDHDEqkaZO0IAIixIpP/U2NSmMhLKw8gwrjv2KNKO1u+MEm6YDaPnv+wrurXOsHK4B4mq1ylbuybVbk62y8cImIxh4k7ZeZ+BlUFtNRiDbw/zdB+q453XXAca9Pb8dV2QDtRECKknielwW39x8iDfHA0JI9PpXWO6faYRBHZSC3P0jcRb8I5UmnFEHyKG+zjl0HfcE+rk6dLVBCZOJk6wfh3MXizSI64UG42lHS4ge1BAPFVi0BZHWePQq+THDaQgQKBgQD/WmBlGXH3AkfWDQdCYkZikruX9OlqnTncIbcqh8+SHPhVvx4hncATbOiBUWqqSeQbnOf2FefWkhzLSKSBwcOqrzv++vwY3CIiwYtft8PqoK7klBhdq6h+3kkRauLK6+53Qkpw3i1I8BylTw19O0zP58DzHK0fC/L0et3WCmdL6wKBgQCaPVH3tv8e1fGf9u+slgKdZs0iALqXZw+scuEzVCmUqRX3HiUGxwgX6slBda9q/J/No0Gy8SYp7UQ3QHb9oHJaK703gM6sxk22QECOXmFuX+HADPuoV4f9L/YWn8Uhi4sWW5P/7OOLM6Qb2ekIsKZnGtw1nbdPsrevM4JGsQmX2QKBgQDaOZp3zC8hMcnCnI+/o80TIONBEgUJICT6g7XNmxNBg5CXdyWBBRfJgiGRosrNjShskMOMA1yGe4gwEnzEh5t4mxli54vakwZ5PX6m5p2APqI4pnfMVY9CHSXExNvdH5RER1rm6nk5BDr264BTrgIPC7hSDAfHqKaRWQ+MhIeS0QKBgF3Om7KwTru/XSRwOFbcKZz3sB1VGicJHIRCnmrsbhmnON/CKrzTgj2ho2O3osfL+5lDCKs/dXmcf5enEnexBLuIzJ0cLxbvyMXmkBzGlDVgBVoby1cYXXIEoIQkCe4cA6zGZ94Igl/gOZhi0RNi9OHSeUn2sU28oXDiQAKkm/QJAoGBAJZ93BrzFuRXlBPKBv58aI12Y+RTUYXff8HZHF0gWMrGm59ktt7aUm+sK/3kX4Iq3r7dG++nrf03oMN4sYJLFGJ65jNDCJg+gZUhLKfzwzMiDU9DdW4iF93Qno8VblXxr/zWc8PsZkCQQE4N5rVJ3SgS0/U4Y6ip+iuWjUTQ26M4");//支付宝私钥

define("ZFB_APPID","2021002113699267");//2021002113699267
define("PWD_JJF","jijipay!@#");//密码加密盐
define("IMG_SIZE","10240");//图片默认限制K
define("BD_KEY","0768f79a1df1f84385ca");//补单key
define("YXK_KEFU_KEY","yxk123456");//要销卡手机端客服key
define("JJF_KEFU_KEY","jjfc235e6791f840413");//集集付手机端客服key
define("TOKEN","1CECE2221211DDCB613882C3311EC670");

define ( "NUMS", 20);
//汇速通参数
define ( "HID", "2111580-11");
define ( "HMD5", "B5AD26DA5E6340048CB1CDE6");
define ( "H3DES", "367B1919DD16419D86A89952");
define ( "H3DES_TOP", "367B1919");
//福禄参数
define ( "FID", "2560-11");
define ( "FMD5", "cc6abeab7a204b0db5ed1b1d1ab5a14c");

//定义八零接口的基本参数
define ( "BID", "0a5c9833-11");
define ( "BMD5", "0e1c535ed4b348038115fd07");

/*
//定义速销卡接口的基本参数
define ( "SUID", "7246511550");
define ( "SMD5", "wmuy12eyfpimnwhsbm83b0tmkk5f2z95");
define ( "S3DES", "ir3ju301h3vtpqnc00168ayjxcg49r6k");
*/


//定义速销卡接口的基本参数
define ( "SUID", "4655891025");
define ( "SMD5", "z5dak6sh8hyu9sg6cfgqiaqed1smj74h");
define ( "S3DES", "80e287mgtf2gxn608dm0ugs3rhkxfce2");


//讯银参数
define ( "XID", "2010-11");
define ( "XMD5", "ba5b1fb3436f0a64c768385caf79a1df");

//SUP参数
define ( "SUPID", "1439-11");
define ( "SUPMD5", "0f9bf15ff655f6730c041636f5cfc5a0");
//销卡啦参数
define ( "XKLUID", "102829-11");
define ( "XKLMD5", "05f45282f12b461fa22aa09f799f0d61");
//LD参数
define ( "LDID", "18602184487-11");
define ( "LDMD5", "3a1c472dcb0945b9aa7bb84ae87b59aa");

//闲卖参数
define ( "XMUID", "88120917");
define ( "XMMD5", "c3f04013720d40cb86befd56655ab5ff");
define ( "XMKAMD5", "bc7d09e231c0457594f093c80f07fea2");

//咔咪参数
define ( "CAMIUID", "1104");
define ( "CAMIKEY", "9sg6cfgqiaqed1smj74h6sz5dakh8hyu");
define ( "CAMISIHNKEY", "d6cf6sj74ed1smjh9sg");

//echo 2;die;
return [
    //数据库2
    'db2'=>[
        // 数据库类型
        'type'           => 'mysql',
        // 服务器地址
        'hostname'       => '127.0.0.1',
        // 数据库名
        'database'       => 'xk_jjpay',
        // 用户名
        'username'       => 'xk_jjpay',
        // 密码
        'password'       => '6SA2tN3SjCRTykKL',
        // 端口
        'hostport'       => '61444',
        // 连接dsn
        'dsn'            => '',
        // 数据库连接参数
        'params'         => [],
        // 数据库编码默认采用utf8
        'charset'        => 'utf8',
        // 数据库表前缀
        'prefix'         => '',
        // 数据库调试模式
        'debug'          => false,
        // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'deploy'         => 0,
        // 数据库读写是否分离 主从式有效
        'rw_separate'    => false,
        // 读写分离后 主服务器数量
        'master_num'     => 1,
        // 指定从服务器序号
        'slave_no'       => '',
        // 是否严格检查字段是否存在
        'fields_strict'  => true,
        // 数据集返回类型 array 数组 collection Collection对象
        'resultset_type' => 'array',
        // 是否自动写入时间戳字段
        'auto_timestamp' => false,
        // 是否需要进行SQL性能分析
        'sql_explain'    => false,
    ],
    'db3'=>[
        // 数据库类型
        'type'           => 'mysql',
        // 服务器地址
        'hostname'       => '47.92.81.194',
        // 数据库名
        'database'       => 'jj_pay11111',
        // 用户名
        'username'       => 'kefujjf',
        // 密码
        'password'       => 'JJFKEFU@@59357@@',
        // 端口
        'hostport'       => '61444',
        // 连接dsn
        'dsn'            => '',
        // 数据库连接参数
        'params'         => [],
        // 数据库编码默认采用utf8
        'charset'        => 'utf8',
        // 数据库表前缀
        'prefix'         => '',
        // 数据库调试模式
        'debug'          => true,
        // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'deploy'         => 0,
        // 数据库读写是否分离 主从式有效
        'rw_separate'    => false,
        // 读写分离后 主服务器数量
        'master_num'     => 1,
        // 指定从服务器序号
        'slave_no'       => '',
        // 是否严格检查字段是否存在
        'fields_strict'  => true,
        // 数据集返回类型 array 数组 collection Collection对象
        'resultset_type' => 'array',
        // 是否自动写入时间戳字段
        'auto_timestamp' => false,
        // 是否需要进行SQL性能分析
        'sql_explain'    => false,
    ],

    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用调试模式
    'app_debug'              => false,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => 'htmlspecialchars,addslashes,strip_tags',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => true,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,
    // 全局请求缓存排除规则
    'request_cache_except'   => [],

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件
    'exception_tmpl'         => THINK_PATH . 'tpl' . DS . 'think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => 'error',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
        'expire'=>86400
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 3600*24*7,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],
    'view_replace_str' => [
        '__ROOT__'   => $basename,
        // '__DATA__'   => $basename . '/data',
        '__PUBLIC__' => '/public/',
        // '__UPLOAD__'=> $basename . '/data/upload',
    ],
];
