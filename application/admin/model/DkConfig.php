<?php
namespace app\admin\model;

use think\Model;

class DkConfig extends Model
{
	protected $table = 'dk_config';

	// 设置当前模型的数据库连接
    protected $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'xk_jjpay',
        // 数据库用户名
        'username'    => 'xk_jjpay',
        // 数据库密码
        'password'    => '6SA2tN3SjCRTykKL',
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
        'hostport'    => '61444',
        // 数据库调试模式
        'debug'       => false,
    ];
}
?>