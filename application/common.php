<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\Db;
use think\Request;
use think\Response;
use app\admin\controller\Auth;
use think\Lang;
use think\Cache;

// 打印变量
function d()
{
    echo '<br/>------------debug info.-------------<pre>';
    if(func_num_args()>0){
        foreach(func_get_args() as $arg){
            if(is_array($arg))
                print_r($arg);
            else
                var_dump($arg);
            echo '<br/>';
        }
    }else{
        echo 'argument-empty.';
    }
    echo '</pre>------------debug end.-------------<br/>';
}

//返回指点的 keys
function returnKeys($keys){
    $res = [];
    $redis=LibRedis();
    if($redis){
        $res = $redis ->keys('*'.$keys.'*');
    }
    return $res;
}

//剩余时间
function returnKeyBlanceTime($key){
    $res = '-2';
    $redis=LibRedis();
    if($redis){
        $res = $redis ->TTL($key);
    }
    return $res;
}

/**
 * 过滤参数
 * @param string $str 接受的参数
 * @return string
 */
function filterWords($str)
{
    $farr = array(
            "/<(\\/?)(select|insert|update|delete|script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
            "/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|dump/is"
    );
    $str = preg_replace($farr,'',$str);
    return $str;
}

/**
 * 过滤接受的参数或者数组,如$_GET,$_POST
 * @param array|string $arr 接受的参数或者数组
 * @return array|string
 */
function jajaFilter($arr)
{
    if(is_array($arr)){
        $data = [];
        foreach($arr as $k => $v){
            $data[$k] = filterWords($v);
        }
        return $data;
    }else{
        $str = filterWords($arr);

        return $str;
    }
   
}

// 密码加密
function jaja_md5($username,$pwd,$salt = 'hxzlHadl@#563')
{
    return md5(md5($username . $pwd . $salt));
}

// 应用公共文件
/**
 * 所有用到密码的不可逆加密方式
 * @param string $password
 * @param string $password_salt
 * @return string
 * @author rainfer <81818832@qq.com>
 */
function encrypt_password($password, $password_salt)
{
    return md5(md5($password) . md5($password_salt));
}

/**
 * 列出本地目录的文件
 * @param string $path
 * @param string $pattern
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function list_file($path, $pattern = '*')
{
    if (strpos($pattern, '|') !== false) {
        $patterns = explode('|', $pattern);
    } else {
        $patterns [0] = $pattern;
    }
    $i = 0;
    $dir = array();
    if (is_dir($path)) {
        $path = rtrim($path, '/') . '/';
    }
    foreach ($patterns as $pattern) {
        $list = glob($path . $pattern);
        if ($list !== false) {
            foreach ($list as $file) {
                $dir [$i] ['filename'] = basename($file);
                $dir [$i] ['path'] = dirname($file);
                $dir [$i] ['pathname'] = realpath($file);
                $dir [$i] ['owner'] = fileowner($file);
                $dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
                $dir [$i] ['atime'] = fileatime($file);
                $dir [$i] ['ctime'] = filectime($file);
                $dir [$i] ['mtime'] = filemtime($file);
                $dir [$i] ['size'] = filesize($file);
                $dir [$i] ['type'] = filetype($file);
                $dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
                $dir [$i] ['isDir'] = is_dir($file);
                $dir [$i] ['isFile'] = is_file($file);
                $dir [$i] ['isLink'] = is_link($file);
                $dir [$i] ['isReadable'] = is_readable($file);
                $dir [$i] ['isWritable'] = is_writable($file);
                $i++;
            }
        }
    }
    $cmp_func = create_function('$a,$b', '
		if( ($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"]) ){
			return  $a["filename"]>$b["filename"]?1:-1;
		}else{
			if($a["isDir"]){
				return -1;
			}else if($b["isDir"]){
				return 1;
			}
			if($a["filename"]  ==  $b["filename"])  return  0;
			return  $a["filename"]>$b["filename"]?-1:1;
		}
		');
    usort($dir, $cmp_func);
    return $dir;
}

/**
 * 删除文件夹
 * @param string
 * @param int
 * @author rainfer <81818832@qq.com>
 */
function remove_dir($dir, $time_thres = -1)
{
    foreach (list_file($dir) as $f) {
        if ($f ['isDir']) {
            remove_dir($f ['pathname'] . '/');
        } else if ($f ['isFile'] && $f ['filename']) {
            if ($time_thres == -1 || $f ['mtime'] < $time_thres) {
                @unlink($f ['pathname']);
            }
        }
    }
}

/**
 * 格式化字节大小
 * @param number $size 字节数
 * @param string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author rainfer <81818832@qq.com>
 */
function format_bytes($size, $delimiter = '')
{
    $units = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 版本检测
 * @return string
 * @author rainfer <81818832@qq.com>
 */
function checkVersion()
{
    if (extension_loaded('curl')) {
        $url = 'http://www.yfcmf.net/index.php?m=home&c=upgrade&a=check';
        $params = array(
            'version' => config('yfcmf_version'),
            'domain' => $_SERVER['HTTP_HOST'],
        );
        $vars = http_build_query($params);
        //获取版本数据
        $data = go_curl($url, 'post', $vars);
        if (!empty($data) && strlen($data) < 400) {
            return $data;
        } else {
            return '';
        }
    } else {
        return '';
    }
}

/**
 * curl访问
 * @param string $url
 * @param string $type
 * @param boolean $data
 * @param string $err_msg
 * @param int $timeout
 * @param array $cert_info
 * @return string
 * @author rainfer <81818832@qq.com>
 */
function go_curl($url, $type, $data = false, &$err_msg = null, $timeout = 20, $cert_info = array())
{
    $type = strtoupper($type);
    if ($type == 'GET' && is_array($data)) {
        $data = http_build_query($data);
    }
    $option = array();
    if ($type == 'POST') {
        $option[CURLOPT_POST] = 1;
    }
    if ($data) {
        if ($type == 'POST') {
            $option[CURLOPT_POSTFIELDS] = $data;
        } elseif ($type == 'GET') {
            $url = strpos($url, '?') !== false ? $url . '&' . $data : $url . '?' . $data;
        }
    }
    $option[CURLOPT_URL] = $url;
    $option[CURLOPT_FOLLOWLOCATION] = TRUE;
    $option[CURLOPT_MAXREDIRS] = 4;
    $option[CURLOPT_RETURNTRANSFER] = TRUE;
    $option[CURLOPT_TIMEOUT] = $timeout;
    //设置证书信息
    if (!empty($cert_info) && !empty($cert_info['cert_file'])) {
        $option[CURLOPT_SSLCERT] = $cert_info['cert_file'];
        $option[CURLOPT_SSLCERTPASSWD] = $cert_info['cert_pass'];
        $option[CURLOPT_SSLCERTTYPE] = $cert_info['cert_type'];
    }
    //设置CA
    if (!empty($cert_info['ca_file'])) {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 1;
        $option[CURLOPT_CAINFO] = $cert_info['ca_file'];
    } else {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 0;
    }
    $ch = curl_init();
    curl_setopt_array($ch, $option);
    $response = curl_exec($ch);
    $curl_no = curl_errno($ch);
    $curl_err = curl_error($ch);
    curl_close($ch);
    // error_log
    if ($curl_no > 0) {
        if ($err_msg !== null) {
            $err_msg = '(' . $curl_no . ')' . $curl_err;
        }
    }
    return $response;
}

/**
 * 设置全局配置到文件
 *
 * @param $key
 * @param $value
 * @return boolean
 */
function sys_config_setbykey($key, $value)
{
    $file = ROOT_PATH . 'data/conf/config.php';
    $cfg = array();
    if (file_exists($file)) {
        $cfg = include $file;
    }
    $item = explode('.', $key);
    switch (count($item)) {
        case 1:
            $cfg[$item[0]] = $value;
            break;
        case 2:
            $cfg[$item[0]][$item[1]] = $value;
            break;
    }
    return file_put_contents($file, "<?php\nreturn " . var_export($cfg, true) . ";");
}

/**
 * 设置全局配置到文件
 *
 * @param array
 * @return boolean
 */
function sys_config_setbyarr($data)
{
    $file = ROOT_PATH . 'data/conf/config.php';
    if (file_exists($file)) {
        $configs = include $file;
    } else {
        $configs = array();
    }
    $configs = array_merge($configs, $data);
    return file_put_contents($file, "<?php\treturn " . var_export($configs, true) . ";");
}

/**
 * 获取全局配置
 *
 * @param $key
 * @return array|null
 */
function sys_config_get($key)
{
    $file = ROOT_PATH . 'data/conf/config.php';
    $cfg = array();
    if (file_exists($file)) {
        $cfg = (include $file);
    }
    return isset($cfg[$key]) ? $cfg[$key] : null;
}

/**
 * 返回带协议的域名
 * @author rainfer <81818832@qq.com>
 */
function get_host()
{
    $host = $_SERVER["HTTP_HOST"];
    $protocol = Request::instance()->isSsl() ? "https://" : "http://";
    return $protocol . $host;
}

/**
 * ajax数据返回，规范格式
 * @param array $data 返回的数据，默认空数组
 * @param string $msg 信息，一般用于错误信息提示
 * @param int $code 错误码，0-未出现错误|其他出现错误
 * @param array $extend 扩展数据
 * @return string
 */
function ajax_return($data = [], $msg = "", $code = 0, $extend = [])
{
    $msg = empty($msg) ? '失败' : $msg;
    $ret = ["code" => $code, "msg" => $msg, "data" => $data];
    $ret = array_merge($ret, $extend);
    return Response::create($ret, 'json');
}

/**
 * 根据用户id获取用户组,返回值为数组
 * @param int $uid 用户id
 * @return string
 */
function get_groups($uid)
{
    $auth = new Auth();
    $group = $auth->getGroups($uid);
    return $group[0]['title'];
}

/**
 * 随机字符
 * @param int $length 长度
 * @param string $type 类型
 * @param int $convert 转换大小写 1大写 0小写
 * @return string
 */
function random($length = 10, $type = 'letter', $convert = 0)
{
    $config = array(
        'number' => '1234567890',
        'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );

    if (!isset($config[$type])) $type = 'letter';
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $string{mt_rand(0, $strlen)};
    }
    if (!empty($convert)) {
        $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
    }
    return $code;
}

/**
 * 是否存在控制器
 * @param string $module 模块
 * @param string $controller 待判定控制器名
 * @return boolean
 */
function has_controller($module, $controller)
{
    $arr = \ReadClass::readDir(APP_PATH . $module . DS . 'controller');
    if ((!empty($arr[$controller])) && $arr[$controller]['class_name'] == $controller) {
        return true;
    } else {
        return false;
    }
}

/**
 * 是否存在方法
 * @param string $module 模块
 * @param string $controller 待判定控制器名
 * @param string $action 待判定控制器名
 * @return number 方法结果，0不存在控制器 1存在控制器但是不存在方法 2存在控制和方法
 */
function has_action($module, $controller, $action)
{
    $arr = \ReadClass::readDir(APP_PATH . $module . DS . 'controller');
    if ((!empty($arr[$controller])) && $arr[$controller]['class_name'] == $controller) {
        $method_name = array_map('array_shift', $arr[$controller]['method']);
        if (in_array($action, $method_name)) {
            return 2;
        } else {
            return 1;
        }
    } else {
        return 0;
    }
}

/**
 * 返回不含前缀的数据库表数组
 *
 * @param bool
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function db_get_tables($prefix = false)
{
    $db_prefix = config('database.prefix');
    $list = Db::query('SHOW TABLE STATUS FROM ' . config('database.database'));
    $list = array_map('array_change_key_case', $list);
    $tables = array();
    foreach ($list as $k => $v) {
        if (empty($prefix)) {
            if (stripos($v['name'], strtolower(config('database.prefix'))) === 0) {
                $tables [] = strtolower(substr($v['name'], strlen($db_prefix)));
            }
        } else {
            $tables [] = strtolower($v['name']);
        }

    }
    return $tables;
}

/**
 * 返回数据表的sql
 *
 * @param $table : 不含前缀的表名
 * @return string
 * @author rainfer <81818832@qq.com>
 *
 */
function db_get_insert_sqls($table)
{
    $db_prefix = config('database.prefix');
    $db_prefix_re = preg_quote($db_prefix);
    $db_prefix_holder = db_get_db_prefix_holder();
    $export_sqls = array();
    $export_sqls [] = "DROP TABLE IF EXISTS $db_prefix_holder$table";
    switch (config('database.type')) {
        case 'mysql' :
            if (!($d = Db::query("SHOW CREATE TABLE $db_prefix$table"))) {
                $this->error("'SHOW CREATE TABLE $table' Error!");
            }
            $table_create_sql = $d [0] ['Create Table'];
            $table_create_sql = preg_replace('/' . $db_prefix_re . '/', $db_prefix_holder, $table_create_sql);
            $export_sqls [] = $table_create_sql;
            $data_rows = Db::query("SELECT * FROM $db_prefix$table");
            $data_values = array();
            foreach ($data_rows as &$v) {
                foreach ($v as &$vv) {
                    //TODO mysql_real_escape_string替换方法
                    //$vv = "'" . @mysql_real_escape_string($vv) . "'";
                    $vv = "'" . addslashes(str_replace(array("\r", "\n"), array('\r', '\n'), $vv)) . "'";
                }
                $data_values [] = '(' . join(',', $v) . ')';
            }
            if (count($data_values) > 0) {
                $export_sqls [] = "INSERT INTO `$db_prefix_holder$table` VALUES \n" . join(",\n", $data_values);
            }
            break;
    }
    return join(";\n", $export_sqls) . ";";
}

/**
 * 检测当前数据库中是否含指定表
 *
 * @param $table : 不含前缀的数据表名
 * @return bool
 * @author rainfer <81818832@qq.com>
 *
 */
function db_is_valid_table_name($table)
{
    return in_array($table, db_get_tables());
}

/**
 * 不检测表前缀,恢复数据库
 *
 * @param $file
 * @param $prefix
 * @author rainfer <81818832@qq.com>
 *
 */
function db_restore_file($file, $prefix = '')
{
    $prefix = $prefix ?: db_get_db_prefix_holder();
    $db_prefix = config('database.prefix');
    $sqls = file_get_contents($file);
    $sqls = str_replace($prefix, $db_prefix, $sqls);
    $sqlarr = explode(";\n", $sqls);
    foreach ($sqlarr as &$sql) {
        Db::execute($sql);
    }
}

/**
 * 返回表前缀替代符
 * @return string
 * @author rainfer <81818832@qq.com>
 *
 */
function db_get_db_prefix_holder()
{
    return '<--db-prefix-->';
}

/**
 * 强制下载
 * @param string $filename
 * @param string $content
 * @author rainfer <81818832@qq.com>
 *
 */
function force_download_content($filename, $content)
{
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=$filename");
    echo $content;
    exit ();
}

/**
 * 数据表导出excel
 *
 * @param string $table ,不含前缀表名,必须
 * @param string $file ,保存的excel文件名,默认表名为文件名
 * @param string $fields ,需要导出的字段名,默认全部,以半角逗号隔开
 * @param string $field_titles ,需要导出的字段标题,需与$field一一对应,为空则表示直接以字段名为标题,以半角逗号隔开
 * @param string $tag ,筛选条件 以字符串方式传入,例："limit:0,8;order:post_date desc,listorder desc;where:id>0;"
 *      limit:数据条数,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 *      order:排序方式，如：post_date desc
 *      where:查询条件，字符串形式，和sql语句一样
 * @author rainfer <81818832@qq.com>
 *
 */
function export2excel($table, $file = '', $fields = '', $field_titles = '', $tag = '')
{
    //处理传递的参数
    if (stripos($table, config('database.prefix')) == 0) {
        //含前缀的表,去除表前缀
        $table = substr($table, strlen(config('database.prefix')));
    }
    $file = empty($file) ? config('database.prefix') . $table : $file;
    $fieldsall = Db::name($table)->getTableInfo('', 'fields');
    $field_titles = empty($field_titles) ? array() : explode(",", $field_titles);
    if (empty($fields)) {
        $fields = $fieldsall;
        //成员数不一致,则取字段名为标题
        if (count($fields) != count($field_titles)) {
            $field_titles = $fields;
        }
    } else {
        $fields = explode(",", $fields);
        $rst = array();
        $rsttitle = array();
        $title_y_n = (count($fields) == count($field_titles)) ? true : false;
        foreach ($fields as $k => $v) {
            if (in_array($v, $fieldsall)) {
                $rst[] = $v;
                //一一对应则取指定标题,否则取字段名
                $rsttitle[] = $title_y_n ? $field_titles[$k] : $v;
            }
        }
        $fields = $rst;
        $field_titles = $rsttitle;
    }
    //处理tag标签
    $tag = param2array($tag);
    $limit = !empty($tag['limit']) ? $tag['limit'] : '';
    $order = !empty($tag['order']) ? $tag['order'] : '';
    $where = array();
    if (!empty($tag['where'])) {
        $where_str = $tag['where'];
    } else {
        $where_str = '';
    }
    //处理数据
    $data = Db::name($table)->field(join(",", $fields))->where($where_str)->where($where)->order($order)->limit($limit)->select();
    //import("Org.Util.PHPExcel");
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/chongqing');
    $objPHPExcel = new \PHPExcel();
    //import("Org.Util.PHPExcel.Reader.Excel5");
    /*设置excel的属性*/
    $objPHPExcel->getProperties()->setCreator("rainfer")//创建人
    ->setLastModifiedBy("rainfer")//最后修改人
    ->setKeywords("excel")//关键字
    ->setCategory("result file");//种类

    //第一行数据
    $objPHPExcel->setActiveSheetIndex(0);
    $active = $objPHPExcel->getActiveSheet();
    foreach ($field_titles as $i => $name) {
        $ck = num2alpha($i++) . '1';
        $active->setCellValue($ck, $name);
    }
    //填充数据
    foreach ($data as $k => $v) {
        $k = $k + 1;
        $num = $k + 1;//数据从第二行开始录入
        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($fields as $i => $name) {
            $ck = num2alpha($i++) . $num;
            $active->setCellValue($ck, $v[$name]);
        }
    }
    $objPHPExcel->getActiveSheet()->setTitle($table);
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file . '.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

/**
 * 生成参数列表,以数组形式返回
 * @param string
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function param2array($tag = '')
{
    $param = array();
    $array = explode(';', $tag);
    foreach ($array as $v) {
        $v = trim($v);
        if (!empty($v)) {
            list($key, $val) = explode(':', $v);
            $param[trim($key)] = trim($val);
        }
    }
    return $param;
}

/**
 * 数字到字母列
 * @param int
 * @param int
 * @return string
 * @author rainfer <81818832@qq.com>
 */
function num2alpha($index, $start = 65)
{
    $str = '';
    if (floor($index / 26) > 0) {
        $str .= num2alpha(floor($index / 26) - 1);
    }
    return $str . chr($index % 26 + $start);
}

/**
 * 读取excel文件到数组
 * @param string $filename ,excel文件名（含路径）
 * @param string $type ,excel文件类型 'Excel2007', 'Excel5', 'Excel2003XML','OOCalc', 'SYLK', 'Gnumeric', 'HTML','CSV'
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function read($filename, $type = 'Excel5')
{
    $objReader = \PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($filename);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
    $excelData = array();
    for ($row = 1; $row <= $highestRow; $row++) {
        for ($col = 0; $col < $highestColumnIndex; $col++) {
            $excelData[$row][] = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
    }
    return $excelData;
}

/**
 * 获取新闻分类ids
 * @param int $id 待获取的id
 * @param boolean $self 是否返回自身，默认false
 * @param int $open 1表示只显示menu_open=1的，0表示只显示menu_open=0的，2表示不限制
 * @param string $field 默认只返回id数组(一维),其它如:"*"表示全部字段，"id,menu_name"表示返回二维数组
 * @param boolean $lang 是否只返回当前语言下分类，默认false
 * @return array|mixed
 * @author rainfer <81818832@qq.com>
 *
 */
function get_menu_byid($id = 0, $self = false, $open = 0, $field = 'id', $lang = false)
{
    if (empty($open)) {
        $where['menu_open'] = 0;
    } elseif ($open == 1) {
        $where['menu_open'] = 1;
    } else {
        $where = array();
    }
    if ($lang) {
        $where['menu_l'] = Lang::detect();
    }
    $arr = Db::name('menu')->where($where)->where(array('id' => $id))->select();
    if ($arr) {
        $tree = new \Tree();
        $tree->init($arr);
        $rst = $tree->get_childs($arr, $id, true, true);
    } else {
        $rst = $self ? array($id) : array();
    }
    if (empty($field) || $field == 'id') {
        return $rst;
    } else {
        $where = array();
        $where['id'] = array('in', $rst);
        $arr = Db::name('menu')->where($where)->field($field)->order('listorder asc')->select();
        return $arr;
    }
}

/**
 * 截取文字
 * @param string $text
 * @param int $length
 * @return string
 * @author rainfer <81818832@qq.com>
 *
 */
function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8') . '...';
    return $text;
}

/**
 * 将内容存到Storage中，返回转存后的文件路径
 * @param string $ext
 * @param string $content
 * @return string
 * @author rainfer <81818832@qq.com>
 */
function save_storage_content($ext = null, $content = null)
{
    $newfile = '';
    $path = './data/upload/';
    $path = substr($path, 0, 2) == './' ? substr($path, 2) : $path;
    $path = substr($path, 0, 1) == '/' ? substr($path, 1) : $path;
    if ($ext && $content) {
        do {
            $newfile = $path . date('Y-m-d/') . uniqid() . '.' . $ext;
        } while (file_exists($newfile));
        $dir = dirname($newfile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($newfile, $content);
    }
    return $newfile;
}

/**
 * 截取待html的文本
 * @param string $html
 * @param int $max
 * @param string $suffix
 * @return string;
 * @author rainfer <81818832@qq.com>
 */
function html_trim($html, $max, $suffix = '...')
{
    $html = trim($html);
    if (strlen($html) <= $max) {
        return $html;
    }
    $non_paired_tags = array('br', 'hr', 'img', 'input', 'param');
    $html = preg_replace('/<img([^>]+)>/i', '', $html);
    $count = 0;
    $tag_status = 0;
    $nodes = array();
    $segment = '';
    $tag_name = '';
    for ($i = 0; $i < strlen($html); $i++) {
        $char = $html[$i];
        $segment .= $char;
        if ($tag_status == 4) {
            $tag_status = 0;
        }
        if ($tag_status == 0 && $char == '<') {
            $tag_status = 1;
        }
        if ($tag_status == 1 && $char != '<') {
            $tag_status = 2;
            $tag_name = '';
            $nodes[] = array(0, substr($segment, 0, strlen($segment) - 2), 'text', 0);
            $segment = '<' . $char;
        }
        if ($tag_status == 2) {
            if ($char == ' ' || $char == '>' || $char == "\t") {
                $tag_status = 3;
            } else {
                $tag_name .= $char;
            }
        }
        if ($tag_status == 3 && $char == '>') {
            $tag_status = 4;
            $tag_name = strtolower($tag_name);
            $tag_type = 1;
            if (in_array($tag_name, $non_paired_tags)) {
                $tag_type = 0;
            } elseif ($tag_name[0] == '/') {
                $tag_type = 2;
            }
            $nodes[] = array(1, $segment, $tag_name, $tag_type);
            $segment = '';
        }
        if ($tag_status == 0) {
            if ($char == '&') {
                for ($e = 1; $e <= 10; $e++) {
                    if ($html[$i + $e] == ';') {
                        $segment .= substr($html, $i + 1, $e);
                        $i += $e;
                        break;
                    }
                }
            } else {
                $char_code = ord($char);
                if ($char_code >= 224) {
                    $segment .= $html[$i + 1] . $html[$i + 2];
                    $i += 2;
                } elseif ($char_code >= 129) {
                    $segment .= $html[$i + 1];
                    $i += 1;
                }
            }
            $count++;
            if ($count == $max) {
                $nodes[] = array(0, $segment . $suffix, 'text', 0);
                break;
            }
        }
    }
    $html = '';
    $tag_open_stack = array();
    for ($i = 0; $i < count($nodes); $i++) {
        $node = $nodes[$i];
        if ($node[3] == 1) {
            array_push($tag_open_stack, $node[2]);
        } elseif ($node[3] == 2) {
            array_pop($tag_open_stack);
        }
        $html .= $node[1];
    }
    while ($tag_name = array_pop($tag_open_stack)) {
        $html .= '</' . $tag_name . '>';
    }
    return $html;
}

/**
 * 获取当前request参数数组,去除值为空
 * @param string
 * @param int
 * @param int
 * @param string
 * @param bool
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return ($suffix && $slice != $str) ? $slice . '...' : $slice;
}

/**
 * 用于生成收藏内容用的key
 * @param string $table 收藏内容所在表
 * @param int $object_id 收藏内容的id
 * @return string
 */
function get_favorite_key($table, $object_id)
{
    $key = encrypt_password($table . '-' . $object_id, $table);
    return $key;
}

/**
 * 发送邮件
 * @param string $to 收件人邮箱
 * @param string $title 标题
 * @param string $content 内容
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function sendMail($to, $title, $content)
{
    $email_options = get_email_options();
    if ($email_options && $email_options['email_open']) {
        $mail = new PHPMailer(); //实例化
        // 设置PHPMailer使用SMTP服务器发送Email
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->IsHTML(true);
        // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->CharSet = 'UTF-8';
        // 添加收件人地址，可以多次使用来添加多个收件人
        $mail->AddAddress($to);
        // 设置邮件正文
        $mail->Body = $content;
        // 设置邮件头的From字段。
        $mail->From = $email_options['email_name'];
        // 设置发件人名字
        $mail->FromName = $email_options['email_rename'];
        // 设置邮件标题
        $mail->Subject = $title;
        // 设置SMTP服务器。
        $mail->Host = $email_options['email_smtpname'];
        //by Rainfer
        // 设置SMTPSecure。
        $mail->SMTPSecure = $email_options['smtpsecure'];
        // 设置SMTP服务器端口。
        $port = $email_options['smtp_port'];
        $mail->Port = empty($port) ? "25" : $port;
        // 设置为"需要验证"
        $mail->SMTPAuth = true;
        // 设置用户名和密码。
        $mail->Username = $email_options['email_emname'];
        $mail->Password = $email_options['email_pwd'];
        // 发送邮件。
        if (!$mail->Send()) {
            $mailerror = $mail->ErrorInfo;
            return array("error" => 1, "message" => $mailerror);
        } else {
            return array("error" => 0, "message" => "success");
        }
    } else {
        return array("error" => 1, "message" => '未开启邮件发送或未配置');
    }
}

/**
 * 获取后台管理设置的邮件连接
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function get_email_options()
{
    $email_options = cache("email_options");
    if (empty($email_options)) {
        $option = Db::name("Options")->where('option_l', Lang::detect())->where("option_name='email_options'")->find();
        if ($option) {
            $email_options = json_decode($option['option_value'], true);
        } else {
            $email_options = array();
        }
        cache("email_options", $email_options);
    }
    return $email_options;
}

/**
 * 获取后台管理设置的邮件激活连接
 * @return array
 * @author rainfer <81818832@qq.com>
 */
function get_active_options()
{
    $active_options = cache("active_options");
    if (empty($active_options)) {
        $option = Db::name("Options")->where('option_l', Lang::detect())->where("option_name='active_options'")->find();
        if ($option) {
            $active_options = json_decode($option['option_value'], true);
        } else {
            $active_options = array();
        }
        cache("active_options", $active_options);
    }
    return $active_options;
}

/**
 * 实时显示提示信息
 * @param string $msg 提示信息
 * @param string $class 输出样式（success:成功，error:失败）
 * @author huajie <banhuajie@163.com>
 */
function showmsg($msg, $class = '')
{
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}

/**
 * 加密函数
 * @param string $txt 需加密的字符串
 * @param string $key 加密密钥，默认读取data_auth_key配置
 * @return string 加密后的字符串
 */
function jiami($txt, $key = null)
{
    empty($key) && $key = config('data_auth_key');
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
    $nh = rand(0, 64);
    $ch = $chars[$nh];
    $mdKey = md5($key . $ch);
    $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
    $txt = base64_encode($txt);
    $tmp = '';
    $k = 0;
    for ($i = 0; $i < strlen($txt); $i++) {
        $k = $k == strlen($mdKey) ? 0 : $k;
        $j = ($nh + strpos($chars, $txt [$i]) + ord($mdKey[$k++])) % 64;
        $tmp .= $chars[$j];
    }
    return $ch . $tmp;
}

/**
 * 解密函数
 * @param string $txt 待解密的字符串
 * @param string $key 解密密钥，默认读取data_auth_key配置
 * @return string 解密后的字符串
 */
function jiemi($txt, $key = null)
{
    empty($key) && $key = config('data_auth_key');
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
    $ch = $txt[0];
    $nh = strpos($chars, $ch);
    $mdKey = md5($key . $ch);
    $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
    $txt = substr($txt, 1);
    $tmp = '';
    $k = 0;
    for ($i = 0; $i < strlen($txt); $i++) {
        $k = $k == strlen($mdKey) ? 0 : $k;
        $j = strpos($chars, $txt[$i]) - $nh - ord($mdKey[$k++]);
        while ($j < 0) {
            $j += 64;
        }
        $tmp .= $chars[$j];
    }
    return base64_decode($tmp);
}

/**
 * 获取图片完整路径
 * @param string $url 待获取图片url
 * @param int $cat 待获取图片类别 0为文章 1前台头像 2后台头像
 * @return string 完整图片imgurl
 */
function get_imgurl($url, $cat = 0)
{
    if (stripos($url, 'http') !== false) {
        //网络图片
        return $url;
    } elseif ($url && stripos($url, '/') === false && stripos($url, '\\') === false) {
        //头像
        return __ROOT__ . '/data/upload/avatar/' . $url;
    } elseif (empty($url)) {
        //$url为空
        if ($cat == 2) {
            $imgurl = 'girl.jpg';
        } elseif ($cat == 1) {
            $imgurl = 'headicon.png';
        } else {
            $imgurl = 'no_img.jpg';
        }
        return __ROOT__ . '/public/img/' . $imgurl;
    } else {
        //本地上传图片
        return __ROOT__ . $url;
    }
}

/**
 * 获取当前request参数数组,去除值为空
 * @return array
 */
function get_query()
{
    $param = request()->except(['s']);
    $rst = array();
    foreach ($param as $k => $v) {
        if (!empty($v)) {
            $rst[$k] = $v;
        }
    }
    return $rst;
}

/**
 * 货币转换
 * @param float
 * @return string
 */
function long_currency($long)
{
    return sprintf('%d.%02d', intval($long / 100), intval($long % 100));
}

/**
 * 货币转换
 * @param string
 * @return float
 */
function currency_long($currency)
{
    $s = explode('.', trim($currency));
    switch (count($s)) {
        case 1:
            return $s[0] * 100;
        case 2:
            if (strlen($s[1]) == 1) {
                $s[1] .= '0';
            } else if (strlen($s[1]) > 2) {
                $s[1] = substr($s[1], 0, 2);
            }
            return $s[0] * 100 + $s[1];
    }
    return 0;
}

/**
 * 返回前台菜单含model_name model_id model_title的菜单数组
 * @param array
 * @return array
 * @author  rainfer520@qq.com
 */
function get_menu_model($menus)
{
    $rst = array();
    foreach ($menus as $menu) {
        $menu['model_name'] = '';
        $menu['model_title'] = '';
        if (!empty($menu['menu_modelid'])) {
            $model = Db::name('model')->find($menu['menu_modelid']);
            $menu['model_name'] = $model['model_name'];
            $menu['model_title'] = $model['model_title'];
        }
        $rst[] = $menu;
    }
    return $rst;
}

/**
 * 通用获取数据表数据
 * @param string $table 如'news'不含前缀形式
 * @param string $join 如 'member_list'不含前缀形式
 * @param string $joinon 'a.news_auto =b.member_list_id'字符串形式,$table为a表,$join为b表
 * @param string $ids 如'id:1,2,3'形式或'1,2,3'形式
 * @param string $cid 如'cid:1,2,3'形式或'1,2,3'形式
 * @param string $field 多个字段用','隔开，类似sql如'a,b,c,d'形式
 * @param string $limit 类似sql的limit如'5,10'或'5'形式
 * @param string $order 类似sql的order如'a,b desc,c'形式
 * @param string $where_str 类似sql的where字符串如"news_open=1 and news_title='aa'"形式
 * @param boolean $ispage 是否分页
 * @param int $pagesize 单页分页数
 * @param string $key 搜索的关键字
 * @param int $page 取第几页
 * @return array
 * @author  rainfer520@qq.com
 */
function get_data($table, $join, $joinon, $ids, $cid, $field, $limit, $order, $where_str, $ispage, $pagesize, $key, $page = 0)
{
    $where = array();
    $config = array();
    if (!empty($page)) {
        $config['page'] = intval($page);
    }
    $model = Db::name('model')->where('model_name', $table)->find();
    //处理$key
    if ($key) {
        if (stripos($key, ':') !== false) {
            list($field_search, $k) = explode(':', $key);
            $search_list = str_replace(',', '|', $field_search);
            $where[$search_list] = array('like', '%' . $k . '%');
        } else {
            $k = $key;
            if ($model) {
                $search_list = $model['search_list'] ? explode(',', $model['search_list']) : array_keys($model['model_fields'] ? json_decode($model['model_fields'], true) : array());
                if ($search_list) {
                    $search_list = join('|', $search_list);
                    $where[$search_list] = array('like', '%' . $k . '%');
                }
            }
        }
    }
    //处理ids
    if ($ids) {
        if (stripos($ids, ':') !== false) {
            list($field_id, $id) = explode(':', $ids);
            $where[$field_id] = array('in', $id);
        } else {
            $id = $ids;
            if ($model) {
                $where[$model['model_pk']] = array('in', $id);
            }
        }
    }
    //处理cid
    if ($cid) {
        if (stripos($cid, ':') !== false) {
            list($field_cid, $id) = explode(':', $cid);
            $where[$field_cid] = array('in', $id);
        } else {
            $id = $cid;
            if ($model) {
                $where[$model['model_cid']] = array('in', $id);
            }
        }
    }
    $count = Db::name($table)->field($field)->where($where_str)->where($where)->count();
    if ($ispage == 'true') {
        if ($join && $joinon) {
            $data = Db::name($table)->alias('a')->join(config('database.prefix') . $join . ' b', $joinon)->field($field)->where($where_str)->where($where)->order($order)->paginate($pagesize, false, $config);
        } else {
            $data = Db::name($table)->field($field)->where($where_str)->where($where)->order($order)->paginate($pagesize, false, $config);
        }
        $show = $data->render();
    } else {
        if ($join && $joinon) {
            $data = Db::name($table)->alias('a')->join(config('database.prefix') . $join . ' b', $joinon)->field($field)->where($where_str)->where($where)->order($order)->limit($limit)->select();
        } else {
            $data = Db::name($table)->field($field)->where($where_str)->where($where)->order($order)->limit($limit)->select();
        }
        $show = '';
    }
    $content['ajax_page'] = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);;
    $content['page'] = $show;
    $content['data'] = $data;
    $content['count'] = $count;
    return $content;
}

/**
 * 获取客户端浏览器信息 添加win10 edge浏览器判断
 * @return string
 * @author  Jea杨
 */
function getBroswer()
{
    $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
    if (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];  //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "傲游";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif (stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号
    } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    } elseif (stripos($sys, 'Safari') > 0) {
        preg_match("/safari\/([^\s]+)/i", $sys, $safari);
        $exp[0] = "Safari";
        $exp[1] = $safari[1];
    } else {
        $exp[0] = "未知浏览器";
        $exp[1] = "";
    }
    return $exp[0] . '(' . $exp[1] . ')';
}

/**
 * 获取客户端操作系统信息包括win10
 * @return string
 * @author  Jea杨
 */
function getOs()
{
    $agent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10';#添加win10判断
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent)) {
        $os = 'Mac';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } elseif (preg_match('/ucweb|MQQBrowser|J2ME|IUC|3GW100|LG-MMS|i60|Motorola|MAUI|m9|ME860|maui|C8500|gt|k-touch|X8|htc|GT-S5660|UNTRUSTED|SCH|tianyu|lenovo|SAMSUNG/i', $agent)) {
        $os = 'mobile';
    } else {
        $os = '未知操作系统';
    }
    return $os;
}

/**
 * 返回按层级加前缀的菜单数组
 * @param array|mixed $menu 待处理菜单数组
 * @param string $id_field 主键id字段名
 * @param string $pid_field 父级字段名
 * @param string $lefthtml 前缀
 * @param int $pid 父级id
 * @param int $lvl 当前lv
 * @param int $leftpin 左侧距离
 * @return array
 * @author  rainfer
 */
function menu_left($menu, $id_field = 'id', $pid_field = 'pid', $lefthtml = '─', $pid = 0, $lvl = 0, $leftpin = 0)
{
    $arr = array();
    foreach ($menu as $v) {
        if ($v[$pid_field] == $pid) {
            $v['lvl'] = $lvl + 1;
            $v['leftpin'] = $leftpin;
            $v['lefthtml'] = '├' . str_repeat($lefthtml, $lvl);
            $arr[] = $v;
            $arr = array_merge($arr, menu_left($menu, $id_field, $pid_field, $lefthtml, $v[$id_field], $lvl + 1, $leftpin + 20));
        }
    }
    return $arr;
}

/**
 * 返回后台news相关菜单层级text数组
 * @return array|mixed
 * @author  rainfer
 */
function menu_text($lang = 'zh-cn')
{
    $menu_text = cache('menu_text');
    if (empty($menu_text)) {
        $map = [];
        if (!config('lang_switch_on')) {
            $map['menu_l'] = $lang;
        }
        $menu_text = Db::name('menu')->where('menu_type <> 4 and menu_type <> 2')->where($map)->order('menu_l desc,listorder')->select();
        $menu_text = menu_left($menu_text, 'id', 'parentid');
        cache('menu_text', $menu_text);
    }
    return $menu_text;
}

/**
 * 数据签名
 * @param array $data 被认证的数据
 * @return string 签名
 */
function data_signature($data = [])
{
    if (!is_array($data)) {
        $data = (array)$data;
    }
    ksort($data);
    $code = http_build_query($data);
    $sign = sha1($code);
    return $sign;
}

// 1 安卓  2 ios 3pc
function check_type()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
        return 2;
    } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
        return 1;
    } else {
        return 3;
    }
}

/**
 * 函数encrypt($string,$operation,$key)中$string：需要加密解密的字符串；$operation：判断是加密还是解密，E表示加密，D表示解密；$key：密匙
 **/
if (!function_exists('encrypt')) {
    function set_encrypt($string, $operation, $key = '')
    {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }
}
/**
 * 分页
 * $listnum  显示页数
 * $maodian  有无锚点
 */
if (!function_exists('get_multipage')) {
    function get_multipage($num, $perpage, $curpage, $mpurl, $listnum = 7, $maodian = "")
    {
        $multipage = "";
        if ($num > $perpage) {
            if ($curpage == 0) $curpage++;
            $realpages = @ceil($num / $perpage);
            $firstpage = ($curpage - $listnum / 2) <= 0 ? 1 : intval(($curpage - $listnum / 2));
            $prepage = $curpage - 1;
            $nextpage = $curpage + 1;

            $multipage = "<div class=\"pages\" id=\"pageid\"><ul>";

            if ($curpage > 1) {
                $multipage .= '<li><a href="' . $mpurl . $prepage . $maodian . '" class="topclass">&lt;上一页</a></li>';
            }

            for ($i = $firstpage; ($i <= $realpages) && ($i < ($firstpage + $listnum)); $i++) {
                if ($i == $curpage) {
                    $multipage .= "<li><a href=\"javascript:void(0)\" class=\"thisclass\"><strong>" . $curpage . "</strong></a></li> ";
                } else {
                    $multipage .= '<li><a href="' . $mpurl . $i . $maodian . '" class="text_07\">' . $i . '</a></li> ';
                }
            }
            if ($curpage < $realpages) {

                $multipage .= '<li><a href="' . $mpurl . $nextpage . $maodian . '" class="topclass">下一页&gt;</a></li>';

            }
            $multipage .= "<li><span class=\"pageinfo\">共 <strong>" . $realpages . "</strong> 页</span></li>";

            $multipage .= "<li>跳转：第 <select name=\"jumpMenu\" id=\"jumpMenu\" onchange=\"jumpMenu('parent',this,0)\" class=\"xiala\">";

            for ($i = 1; $i <= $realpages; $i++) {
                if ($curpage == $i) {
                    $multipage .= "<option selected value=\"{$mpurl}{$i}{$maodian}\">{$i}</option>";
                } else {
                    $multipage .= "<option value=\"{$mpurl}{$i}{$maodian}\">{$i}</option>";
                }
            }
            $multipage .= "</select> 页</li></ul></div>";
        } else {
            $multipage = "<div class=\"pages\" style=\"height:30px\"><span class=\"hongxin\">收录 {$num} 条信息</span></div>";
        }
        return $multipage;
    }
}
/**
 *处理字数
 **/
if (!function_exists('words_num')) {
    function words_num($num)
    {
        $res = 0;
        if ($num > 0) {
            $total = number_format($num / 10000, 1);
            $res = ($total > 1) ? $total . '万' : $num;
        }
        return $res;
    }
}

/*孙打印返回用*/
function dy($data, $t = 1)
{
    echo "<pre>";
    if ($t == 1) {
        var_dump($data);die;
    } elseif ($t == 2) {
        print_r($data);die;
    } elseif ($t == 0) {
        var_dump($data);//只打印不拦截
    }else{
        echo $data;die;
    }

}
//redis 连接
function LibRedis(){
    $redis = new \Redis();
    $redis->connect('127.0.0.1',6379);
    return $redis;
}
//redis 读数据
function GetRedis($key){
    $res = null;
    if($key){
        $redis=LibRedis();
        $res = $redis->get($key);
        if($res){
            $list = json_decode($res,true);
            $res = $list?$list:$res;
            unset($list);
        }
    }

    return $res;
}
//redis 读数据
function DelRedis($key){
    $res = null;
    if($key){
        $redis=LibRedis();
        $res = $redis->del($key);
    }

    return $res;
}
//redis 读数据
function SetRedis($key,$v,$timeout=3600){
    //不传时间 默认一个小时
    $res = null;
    if(is_array($v)){
        //只保存正确的结果
        $v  = json_encode($v,true);
    }
    if($key && $v){
        //使用缓存
        $redis=LibRedis();
        if($redis){
            $res = $redis->set($key,$v,$timeout);
        }
    }
    return $res;
}

//接口返回格式定义
function mac_return($code = 1, $msg = '', $data = '', $count = 0, $totalRow = '')
{
    if (empty($msg)) {
        $code == 1 ? $msg = '操作成功' : $msg = '操作失败';
    }
    if (is_array($msg)) {
        echo json_encode($msg,true);die;
    } else {
        empty($data) && $data = [];
        $rs = ['code' => $code, 'msg' => $msg, 'data' => $data, 'count' => $count, 'totalRow' => $totalRow];
        echo json_encode($rs,true);die;
    }
}

//$name 控制端表名
function MC($name = '', $config = 'db2')
{
    return db($name, config($config));
}

/**
 * 发送单个短信
 * @param unknown_type $phone
 */
function send_sms1($phone, $contents)
{
    return true;

    $username = 'hbjjfwl';//用户账号
    $password = 'Jj:159357@';    //密码
    $mobile = $phone;    //号码

    $content = iconv("UTF-8", "UTF-8", "【集集卡销卡中心】" . $contents);
    $productid = 95533;        //内容

    //$url="http://www.ztsms.cn:8800/sendXSms.do?username=$username&password=$password&mobile=$mobile&content=$content&productid=$productid";
    $url = "http://www.ztsms.cn/sendSms.do?username=$username&password=$password&mobile=$mobile&content=$content&productid=$productid";

    //file_put_contents('sendtmp.txt',$url."\n",FILE_APPEND);
    $file_contents = file_get_contents($url);
    $res = explode(",", $file_contents);
    //file_put_contents('sendtmpres.txt',json_encode($res)."\n",FILE_APPEND);
    if ($res[0] == 1) {
        return true;
    } else {
        return false;
    }
}
function send_sms($phone,$contents){
    //return true;
    include "./extend/lib/dysms/Sms.php";
    $sms = new \sms();
    $result=$sms->send_sms($phone,$contents);
    if($result ['Code']=='OK'){
        return true;
    }else{
        return false;
    }
}
//验证短信验证码
function check_code($txt_code='',$mobile='',$type=1){
    $code_res = MC('vire_code')->where(['type' => $type, 'mobile' => $mobile])->order('on_time desc')->find();
    if (($code_res['on_time'] + 300) < time()) {
        return mac_return('0', '验证码超时，请重新获取！');
    }
    if ($txt_code != $code_res['code']) {
        return mac_return('0', '验证码错误！');
    }
    return true;
}
//获取订单数据
function get_orders($parm){
    $api=$parm['api'];
    $status_arr = \global_arr::status_arr();
    $type_arr = \global_arr::type_arr();
    $fenzu_arr = \global_arr::fenzu_arr();
    $tongdao_arr = \global_arr::tongdao_arr();
    $type_arr_hst = \global_arr::type_arr_hst();
    $type_arr_xbh = \global_arr::type_arr_xbh();
    $type_arr_fl = \global_arr::type_arr_fl();
    $type_arr_bl = \global_arr::type_arr_bl();
    $type_arr_sxk = \global_arr::type_arr_sxk();
    $type_arr_xy = \global_arr::type_arr_xy();
    $type_arr_sup = \global_arr::type_arr_sup();
    $type_arr_ld = \global_arr::type_arr_ld();
    $type_arr_xkl = \global_arr::type_arr_xkl();
    $type_arr_xm = \global_arr::type_arr_xm();
    $type_arr_kami = \global_arr::type_arr_kami();
    //用来区分普通订单和api订单
    $map = array();
    $search_time = $parm['search_time'];
    $quchong = $parm['quchong'];
    $txt_uid = intval($parm['txt_uid']);
    $stype = $parm['stype'];
    $stype=='all' && $stype='';

    $agains = $parm['agains'];
    $wcg = $parm['wcg'];
    $txt_tongdao = $parm['txt_tongdao'];
    $txt_tongdao=='all' && $txt_tongdao='';

    $selresult = $parm['selresult'];
    $selresult=='all' && $selresult='';

    $txt_number = $parm['txt_number'];
    $txt_orderid = $parm['txt_orderid'];
    $txt_fenzu = $parm['txt_fenzu'];
    $txt_fenzu=='all' && $txt_fenzu='';

    $txt_pici = $parm['txt_pici'];
    //查询金额统计
    if ($quchong) {
        $tj_sql = "select count(distinct crad_number) crad_number,sum(cash) cash,sum(realvalue) realvalue,sum(successAmount) successAmount,sum(incash) incash from orders ";
    } else {
        $tj_sql = "select count(id) crad_number,sum(cash) cash,sum(realvalue) realvalue,sum(successAmount) successAmount,sum(incash) incash from orders ";
    }
    if($api==1){
        $whereStr=' where ext2=2 ';
    }else{
        $whereStr=' where ISNULL(ext2) ';
    }

    //$whereStr = '';
    if ($search_time) {
        $tmp_start = strtotime(explode(' - ', $search_time)[0]);
        $tmp_end = strtotime(explode(' - ', $search_time)[1]);
    }
    else{
        $tmp_start=strtotime(date('Y-m-d'));
        $tmp_end =time();
    }
    $tmp_start && $whereStr .= "  and on_time >" . $tmp_start;
    $tmp_end && $whereStr .= "  and on_time <" . $tmp_end;

    $parm['ac'] == 'tj' and $selresult = 1;

    if($parm['selresult'] == '666'){
        $whereStr .= " and status=1 and cash!=realvalue";
    }else{
        strlen($selresult) > 0 and $whereStr .= "  and status =" . intval($selresult);
    }
    
    if($parm['status_code'] == 1){
        $parm['status'] and $whereStr .= "  and status !=" . $parm['status'];
        unset($parm['status_code']);
    }else{
        $parm['status'] and $whereStr .= "  and status =" . $parm['status'];
    }
    
    $txt_uid and $whereStr .= "  and uid =" . intval($txt_uid);
    $txt_number and $whereStr .= "  and crad_number ='" . $txt_number . "'";
    $txt_orderid and $whereStr .= "  and orderid ='" . $txt_orderid . "'";
    $txt_tongdao and $whereStr .= "  and tongdao =" . intval($txt_tongdao);
    $txt_fenzu and $whereStr .= "  and fenzu ='" . $txt_fenzu . "'";
    $txt_pici and $whereStr .= "  and total_orderid ='" . $txt_pici . "'";

    //成功过的卡密
    if ($wcg) {
        $today_start = strtotime(date('Y-m-d 00:00:00', time())) - WEI_TIMES;
        //and uid =" . intval($txt_uid) . "
        $cg_sql = "select crad_number from orders where status=1  and on_time >" . $today_start;
        //dy($cg_sql);
        $cg_res = MC('crad_number')->query($cg_sql);
        $str_tmp = '';
        foreach ($cg_res as $k => $v) {
            $str_tmp .= "'" . $v['crad_number'] . "',";
        }
        $str_tmp = rtrim($str_tmp, ',');
        if($str_tmp){
            $whereStr .= "  and crad_number not in($str_tmp) ";
        }
    }

    //区分讯银和汇速通的卡类型
    strlen($stype)>0 && $whereStr .= sql_str($stype);
    $agains && $whereStr .= sql_kct();

    $tongji = MC('orders')->query($tj_sql . $whereStr);
    $tongji ? $tj = $tongji[0] : $tj = '';


    $p = trim($parm['page']) ? trim($parm['page']) : 1;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE;
    $start = ($p - 1) * $limit;

    if($parm['pc']==1){
        $filed='orderid,total_orderid,type,uid,orderid,tongdao,status,status_desc,crad_number,crad_pass,on_time,end_time,cash,realvalue,incash';
    }else{
        $filed='*';
    }
    if ($quchong) {
        $sql = "select ".$filed.",count(distinct crad_number) tmp from orders ";
    } else {
        $sql = "select ".$filed." from orders";
    }

    $sql .= $whereStr;
    if ($quchong) {
        $sql .= "  group by crad_number";
    }
    $sql .= "  order by on_time desc";
//统计总条数
    if ($quchong) {
        $sqlc = "select count(distinct crad_number) total from orders";
    } else {
        $sqlc = "select count(id) total from orders";
    }

    $count_tmp_arr = MC('orders')->query($sqlc . $whereStr);
    $count_tmp_arr ? $count_tmp = $count_tmp_arr[0] : $count_tmp = '';

    $count = $count_tmp['total'];
    if($parm['exportall']!=1){
        $sql .= ' limit ' . $start . ',' . $limit;
    }

    $list = MC('orders')->query($sql);
    //查询用户ID 用户名键值对
    foreach ($list as &$v) {
        if($v['uid']){
            $uname=MC('sys_user')->where("id=".$v['uid'])->find();
            $uname['truename'] ? $truename='-'.$uname['truename'] :$truename='';
            $uname['is_del']==1 ? $is_del='-已销户':$is_del='';
            $uname ? $v['uname']=$v['uid'].'['.$uname['username'].$truename.$is_del.']':$v['uname']=$v['uid'];
        }
        $v['status_txt']=$status_arr[$v['status']];
        switch ($v['tongdao']) {
            case 1:
                $v['kazhong'] = $type_arr[$v['type']];
                break;
            case 2:
                $v['kazhong'] = $type_arr_hst[$v['type']];
                break;
            case 3:
                $v['kazhong'] = '';
                break;
            case 4:
                $v['kazhong'] = $type_arr_fl[$v['type']];
                break;
            case 5:
                $v['kazhong'] = $type_arr_bl[$v['type']];
            case 6:
                $v['kazhong'] = $type_arr_sxk[$v['type']];
                break;
            case 7:
                $v['kazhong'] = $type_arr_xy[$v['type']];
                break;
            case 8:
                $v['kazhong'] = $type_arr_sup[$v['type']];
                break;
            case 9:
                $v['kazhong'] = $type_arr_ld[$v['type']];
                break;
            case 10:
                $v['kazhong'] = $type_arr_xkl[$v['type']];
                break;
            case 11:
                $v['kazhong'] = $type_arr_xm[$v['type']];
                break;
            case 12:
                $v['kazhong'] = $type_arr_kami[$v['type']];
                break;
            default:
                $v['kazhong'] = '新测试';
        };
        $v['tongdao']?$v['td_txt'] = $tongdao_arr[$v['tongdao']]:$v['td_txt']='新';
        $v['on_time']=date('m-d H:i:s',$v['on_time']);
        $v['end_time'] && $v['end_time']=date('m-d H:i:s',$v['end_time']);
        $v['realvalue']=number_format($v['realvalue'],2,'.','');
        //后台用户才显示
        if(session('login_type')==1){
            $v['successAmount']=number_format($v['successAmount'],2,'.','');
        }else{
            $v['successAmount']=0;
        }
        $v['incash']=number_format($v['incash'],2,'.','');
        if($parm['exportall']==1){
            $exp=['orderid','uid','orderid','kazhong','crad_number','crad_pass','on_time'];
            foreach ($v as $t=>&$tt){
                if(!in_array($t,$exp)){
                    unset($v[$t]);
                }
            }
        }
    }

    if(session('login_type')!=1){
        $tj['successAmount']=0;
    }
    return array('list'=>$list,'count'=>$count,'tj'=>$tj);
}
//获取公告列表
function get_notice($parm){
    $search_name=$parm['search_name'];
    $map=array();
    if($search_name){
        $map['title']= array('like',"%".$search_name."%");
    }
    $p = trim($parm['page']) ? trim($parm['page']) : 1 ;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE ;
    $start=($p-1)*$limit;
    $list=MC('notice')->field('*')->where($map)->order('is_top asc,id desc')->limit($start,$limit)->select();
    $count=MC('notice')->where($map)->count();
    return array('list'=>$list,'count'=>$count);
}

// 获取公告列表 仅用于首页展示
function get_index_notice($limit){

    $limit = $limit ?? 1;

    $data = Cache::get('get_index_notice');

    if($data == false){
        $data = MC('notice')->field('*')->where([])->order('is_top asc,id desc')->limit($limit)->select();
        Cache::set('get_index_notice',$data);
    }

    return $data;
}

//更新公告 缓存
function refresh_index_notice(){
    $data = MC('notice')->field('*')->where([])->order('is_top asc,id desc')->limit(3)->select();
    Cache::set('get_index_notice',$data);
}

// 获取问题列表 仅用于首页展示
function get_index_question($limit){

    $limit = $limit ?? 1;

    $data = Cache::get('get_index_question');

    if($data == false){
        $data = MC('question')->field('*')->where([])->order('is_top asc,id desc')->limit($limit)->select();
        Cache::set('get_index_question',$data);
    }

    return $data;
}

//更新问题列表 缓存
function refresh_index_question(){
    $data = MC('question')->field('*')->where([])->order('is_top asc,id desc')->limit(8)->select();
    Cache::set('get_index_question',$data);
}

// 获取新闻列表 仅用于首页展示
function get_index_article($limit){

    $limit = $limit ?? 1;

    $data = Cache::get('get_index_article');
    $map=array('status'=>1);
    if($data == false){
        $data = MC('sys_article')->alias('a')->join('sys_article_categ b','a.categ_id=b.categ_id')->field('a.*,b.categ_name')->where($map)->order('id desc')->limit($limit)->select();
        Cache::set('get_index_article',$data);
    }

    return $data;
}

//更新新闻列表 缓存
function refresh_index_article(){
    $data = MC('sys_article')->alias('a')->join('sys_article_categ b','a.categ_id=b.categ_id')->field('a.*,b.categ_name')->where(['status' => 1])->order('id desc')->limit(8)->select();
    Cache::set('get_index_article',$data);
}

//今日回收状态 $date int 1 // 昨天，0 //今天
function reback_status($date=0,$uid){

    $rows = [];

    if($date == 1){
        $where = "on_time<=".(strtotime(date('Y-m-d',time())."0:0:0")) ." and on_time>=".((strtotime(date('Y-m-d',time())."0:0:0"))-86400) ."  and uid=".$uid;

        // $where = "on_time<=".strtotime('2021-01-19 0:0:0') ." and on_time>=".(strtotime('2021-01-19 0:0:0')-86400) ."  and uid=".$uid;

        $dt = 'z_';
    }
    if($date == 0){
        $where = "on_time>=".(strtotime(date('Y-m-d',time())."0:0:0")) ."  and uid=".$uid;
        // $where = "on_time>=".strtotime('2021-01-19 0:0:0') ."  and uid=".$uid;
        $dt = 't_';
    }

    if($uid > 0){
        $rows = MC('orders')->field('cash,incash,status,on_time')->where($where)->select();
    }
    
    $data = [];

    $inta1 = $intb1 = $intc1 = 0;
    $inta0 = $intb0 = $intc0 = 0;
    $inta2 = $intb2 = $intc2 = 0;

    if(empty($rows)){
        $data[$dt . 'jy_cg']['bishu'] = $intc1;
        $data[$dt . 'jy_cg']['miane'] = $inta1;
        $data[$dt . 'jy_cg']['jiesuane'] = $intb1;
        $data[$dt . 'jy_ds']['bishu'] = $intc0;
        $data[$dt . 'jy_ds']['miane'] = $inta0;
        $data[$dt . 'jy_ds']['jiesuane'] = $intb0;
        $data[$dt . 'jy_sb']['bishu'] = $intc2;
        $data[$dt . 'jy_sb']['miane'] = $inta2;
        $data[$dt . 'jy_sb']['jiesuane'] = $intb2;
    }else{
        foreach ($rows as $key => $val) {
            if($val['status'] == 1){
                $inta1 += $val['cash'];
                $intb1 += $val['incash'];
                $intc1 ++;
                $data[$dt . 'jy_cg']['bishu'] = $intc1;
                $data[$dt . 'jy_cg']['miane'] = $inta1;
                $data[$dt . 'jy_cg']['jiesuane'] = sprintf("%.2f",$intb1);
            }
            if($val['status'] == 0){
                $inta0 += $val['cash'];
                $intb0 += $val['incash'];
                $intc0 ++;
                $data[$dt . 'jy_ds']['bishu'] = $intc0;
                $data[$dt . 'jy_ds']['miane'] = $inta0;
                $data[$dt . 'jy_ds']['jiesuane'] = sprintf("%.2f",$intb0);
            }
            if($val['status'] == 2){
                $inta2 += $val['cash'];
                $intb2 += $val['incash'];
                $intc2 ++;
                $data[$dt . 'jy_sb']['bishu'] = $intc2;
                $data[$dt . 'jy_sb']['miane'] = $inta2;
                $data[$dt . 'jy_sb']['jiesuane'] = sprintf("%.2f",$intb2);
            }
        }
    }

    return $data;

}

//获取问题列表
function get_question($parm){
    $search_name=$parm['search_name'];
    $map=array();
    if($search_name){
        $map['title']= array('like',"%".$search_name."%");
    }
    $p = trim($parm['page']) ? trim($parm['page']) : 1 ;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE ;
    $start=($p-1)*$limit;
    $list=MC('question')->field('*')->where($map)->order('is_top asc,id desc')->limit($start,$limit)->select();
    $count=MC('question')->where($map)->count();
    return array('list'=>$list,'count'=>$count);
}
//获取新闻列表
function get_article($parm){
    $search_name=$parm['search_name'];
    $map=array('status'=>1);
    if($search_name){
        $map['title']= array('like',"%".$search_name."%");
    }
    $p = trim($parm['page']) ? trim($parm['page']) : 1 ;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE ;
    $start=($p-1)*$limit;
    // $list=MC('sys_article')->alias('a')->join('sys_article_categ b','a.categ_id=b.categ_id')->field('a.*,b.categ_name')->where($map)->order('id desc')->limit($start,$limit)->select();
    $rows = MC('sys_article_categ')->cache(120)->where('categ_id>0')->field('categ_id,categ_name')->select();
    $cate_name_arr = [];
    foreach ($rows as $k => $v) {
        $cate_name_arr[$v['categ_id']] = $v['categ_name'];
    }

    $data = MC('sys_article')->cache(60)->where($map)->order('id desc')->limit($start,$limit)->select();
    $list = $data;
    foreach ($data as $key => $val) {
        $list[$key]['categ_name'] = $cate_name_arr[$val['categ_id']];
    }
    $count=MC('sys_article')->cache(60)->where($map)->count();
    return array('list'=>$list,'count'=>$count);
}
function get_statistics($parm){
    $whereStr = ' ';
    $search_time = $parm['search_time'];
    if ($search_time) {
        $tmp_start = strtotime(explode(' - ', $search_time)[0]);
        $tmp_end = strtotime(explode(' - ', $search_time)[1]);
    } else {
        $tmp_start = strtotime(date('Y-m-d'));
        $tmp_end = time();
    }
    $tmp_start && $whereStr .= "  and on_time >" . $tmp_start;
    $tmp_end && $whereStr .= "  and on_time <" . $tmp_end;
    $txt_uid = $parm['txt_uid'];
    $txt_tongdao = $parm['txt_tongdao'];
    $stype = $parm['stype'];
    $sql = "SELECT tongdao ,type types,cash mianzhi,sum(cash) tijiao,sum(realvalue) shimian,ROUND(sum(incash),2) jiesuan,count(id) num,sum(case when status=0 then 1 else 0 end) chuli,sum(case when status=1 then 1 else 0 end) chenggong,sum(case when status=2 then 1 else 0 end ) shibai FROM `orders` where 1=1";
    $txt_uid and $whereStr.="  and uid =".intval($txt_uid);
    strlen($txt_tongdao)>0 and $whereStr.="  and tongdao =".intval($txt_tongdao);
    strlen($stype)>0  && $whereStr.= sql_str($stype);//区分讯银和汇速通的卡类型
    $tongji=MC('orders')->query($sql.$whereStr);
    $tongji[0] && $tongji=$tongji[0];
    $sql.=$whereStr."  group by tongdao,type,cash";
    $list=MC('orders')->query($sql);
    foreach ($list as $k=>$v){
        $tongji_kz=get_kazhong($v['tongdao'],$v['types']);
        $list[$k]['kazhong']=$tongji_kz['kazhong'];
        $list[$k]['td_txt']=$tongji_kz['td_txt'];
    }
    
    return mac_return(0, '查询成功', $list, $count=0,$tongji);
}
function get_pici($parm){
    $sql = "SELECT count(distinct crad_number) tmp,total_orderid,type types,cash,on_time,user_huilv,sum(cash) tijiao,sum(realvalue) shimian,sum(incash) jiesuan,count(id) num,sum(case when status=0 then 1 else 0 end) chuli,sum(case when status=1 then 1 else 0 end) chenggong,sum(case when status=2 then 1 else 0 end ) shibai FROM `orders` where 1=1";
    $whereStr = ' ';
    $search_time = $parm['search_time'];
    if ($search_time) {
        $tmp_start = strtotime(explode(' - ', $search_time)[0]);
        $tmp_end = strtotime(explode(' - ', $search_time)[1]);
    } else {
        $tmp_start = strtotime(date('Y-m-d'));
        $tmp_end = time();
    }
    $tmp_start && $whereStr .= "  and on_time >" . $tmp_start;
    $tmp_end && $whereStr .= "  and on_time <" . $tmp_end;
    $pici = $parm['txt_pici'];
    $pici && $whereStr.="  and total_orderid =".intval($pici);
    $parm['txt_uid'] && $whereStr.=" and uid=".intval($parm['txt_uid']);
    $parm['cash'] && $whereStr.=" and cash=".intval($parm['cash']);
    $tongji=MC('orders')->query($sql.$whereStr);
    $tongji[0] && $tongji=$tongji[0];
    if($tongji){
        unset($tongji['total_orderid']);
        unset($tongji['mianzhi']);
    };
    $sql.=$whereStr."  group by total_orderid  order by id desc";

    $p = trim($parm['page']) ? trim($parm['page']) : 1;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE;
    $start = ($p - 1) * $limit;
    $count=count(MC('orders')->query($sql));
    $list=MC('orders')->query($sql." limit $start,$limit");
    return array('code' => 0, 'msg' => '查询成功', 'data' => $list, 'count' => $count, 'totalRow' => $tongji);
}
//获取提现记录
function tixian_list($parm = [])
{
    $kfdb=session('kfdb')?:'db2';
    $search_time = $parm['search_time'];
    if (!empty($search_time)) {
        $tmp_start = strtotime(explode(' - ', $search_time)[0]);
        $tmp_end = strtotime(explode(' - ', $search_time)[1]);
    } else {
        $tmp_start = strtotime(date('Y-m-d'),strtotime('-3 day'));
        $tmp_end = time();
    }
    $tmp_start && $map['create_time'] = ['between', "$tmp_start, $tmp_end"];
    $parm['txt_uid'] && $map['uid'] = $parm['txt_uid'];
    $parm['username'] && $map['username'] = ['like', "%" . $parm['username'] . "%"];
    strlen($parm['selresult'])>0 && $map['status'] = $parm['selresult'];

    $p = trim($parm['page']) ? trim($parm['page']) : 1;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE;
    $start = ($p - 1) * $limit;

    $count = MC('tixian_log',$kfdb)->where($map)->count();
    $list = MC('tixian_log',$kfdb)->where($map)->order('id desc')->limit($start, $limit)->select();
    $bank_arr = \global_arr::bank_arr();
    $status_arr = \global_arr::status_arr();
    foreach ($list as &$v) {
        $v['create_time'] && $v['create_time'] = date('Y-m-d H:i', $v['create_time']);
        $v['end_time'] && $v['end_time'] = date('Y-m-d H:i', $v['end_time']);
        $v['bank_r'] = $bank_arr[$v['bank']];
        $v['status_txt'] = $status_arr[$v['status']];
    }
    $title = MC('tixian_log',$kfdb)->field('count(id) as account,cast(sum(cash) as decimal(10,2)) cash,cast(sum(fee) as decimal(10,2)) as fee')->where($map)->find();
    return mac_return(0, '查询成功', $list, $count, $title);
}
//获取账变明细
function cash_log($parm = []){
    $kfdb=session('kfdb')?:'db2';
    $search_time=$parm['search_time'];//$parm['fenrun']
    if (!empty($search_time)) {
        $tmp_start = strtotime(explode(' - ', $search_time)[0]);
        $tmp_end = strtotime(explode(' - ', $search_time)[1]);
    }else{
        $tmp_start=strtotime(date('Y-m-d'));
        $tmp_end =time();
    }
    $map['on_time'] = ['between', "$tmp_start, $tmp_end"];
    $parm['txt_uid'] && $map['uid'] = $parm['txt_uid'];
    $parm['fenrun'] && $map['cash'] = ['gt', 4];
    $parm['crad_number'] && $map['crad_number'] =$parm['crad_number'];
    $p = trim($parm['page']) ? trim($parm['page']) : 1;
    $limit = trim($parm['limit']) ? trim($parm['limit']) : PAGESIZE;
    $start = ($p - 1) * $limit;
    $list = MC('finance',$kfdb)->alias('a')->field('a.*,b.username')->join('sys_user b','a.uid=b.id','left')->where($map)->limit($start, $limit)->order('on_time desc , id desc')->select();
    $count = MC('finance',$kfdb)->where($map)->count();//cast(sum(xxxxx) as decimal(10,2))
    return mac_return(0, '查询成功', $list, $count);
}
//是否实名认证
function is_truename($uid = 0)
{
    $res = MC('truename_auth')->cache('truename_auth_uid_'. $uid)->where("uid = '" . $uid . "'")->find();
    //$is_bank = MC('member_bank')->where(['uid' => $uid])->find();
    if ($res['idcard'] && $res['status'] == 1) {
        return 1;
    } else {
        return 0;
    }
}
//通过tongdao和type获取卡种和通道名
function get_kazhong($tongdao,$type){
    $type_arr = \global_arr::type_arr();
    $type_arr = \global_arr::type_arr();
    $tongdao_arr = \global_arr::tongdao_arr();
    $type_arr_hst = \global_arr::type_arr_hst();
    $type_arr_xbh = \global_arr::type_arr_xbh();
    $type_arr_fl = \global_arr::type_arr_fl();
    $type_arr_bl = \global_arr::type_arr_bl();
    $type_arr_sxk = \global_arr::type_arr_sxk();
    $type_arr_xy = \global_arr::type_arr_xy();
    $type_arr_sup = \global_arr::type_arr_sup();
    $type_arr_ld = \global_arr::type_arr_ld();
    $type_arr_xkl = \global_arr::type_arr_xkl();
    $type_arr_xm = \global_arr::type_arr_xm();
    $type_arr_kami = \global_arr::type_arr_kami();

    switch ($tongdao) {
        case 1:
            $kazhong = $type_arr[$type];
            break;
        case 2:
            $kazhong = $type_arr_hst[$type];
            break;
        case 3:
            $kazhong = '';
            break;
        case 4:
            $kazhong = $type_arr_fl[$type];
            break;
        case 5:
            $kazhong = $type_arr_bl[$type];
        case 6:
            $kazhong = $type_arr_sxk[$type];
            break;
        case 7:
            $kazhong = $type_arr_xy[$type];
            break;
        case 8:
            $kazhong = $type_arr_sup[$type];
            break;
        case 9:
            $kazhong = $type_arr_ld[$type];
            break;
        case 10:
            $kazhong = $type_arr_xkl[$type];
            break;
        case 11:
            $kazhong = $type_arr_xm[$type];
            break;
        case 12:
            $kazhong = $type_arr_kami[$type];
            break;
        default:
            $kazhong = '新测试';
    };
    $tongdao?$td_txt = $tongdao_arr[$tongdao]:$td_txt='新';
    return ['kazhong'=>$kazhong,'td_txt'=>$td_txt];
}
//配置表的配置
function get_sys_config(){
    $list=MC('sys_config')->where('1=1')->select();
    //拆解重组数据
    $data=[];
    foreach($list as $k=>$v){
        $data[$v['k']]=$v['v'];
    }
    return $data;
}
/**
 *
 * @param unknown $statName
 * @param unknown $labelAry 标题
 * @param unknown $dataAry  数量
 * @param unknown $po   附加参数
 * @param string $direct  横向或是竖向
 * @return string//总后台柱状图
 */
function rectStat($statName,$labelAry,$dataAry)
{

    global $height;
    $height=120*count($labelAry);
    $idx = 0;
    $lenAry = array();
    $sum = array_sum($dataAry);

    $strHTML = "<table width='".((''=="H") ? "1500" : "98%")."' border='0' cellspacing='1' cellpadding='1' bgcolor='#CCCCCC' align='center'>\n<tr><td bgcolor='#FFFFFF'>\n";
    $strHTML .= "<table width='100%' border='0' cellspacing='2' cellpadding='2'>\n";

    $dataHTML = "";
    $labelHTML = "";

    while (list ($key, $val) = each ($dataAry))
    {
        $dataHTML .= "<td>".$dataAry[$idx]."<br><img src='/public/static/admin/img/line.gif' border=0 width='30' height='".(($val/$sum)*$height)."'></td>\n";
        $labelHTML .= "<td>".$labelAry[$idx]."</td>\n";
        $idx++;
    }

    $headHTML = "<tr align='center'><td colspan='".$idx."'><b>".$statName."</b></td></tr>\n<tr align='center' valign='bottom'>\n";
    $bodyHTML = "</tr>\n<tr align='center'>\n";
    $footHTML = "</tr>\n";

    $strHTML .= $headHTML.$dataHTML.$bodyHTML.$labelHTML.$footHTML;

    $strHTML .= "</table>\n";
    $strHTML .= "</td></tr></table>\n";

    return $strHTML;
}
// 定义一个函数getIP()
function getIP()
{
    //global $ip;

    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else
        $ip = "Unknow";

    return $ip;
}

//闲卖post提交卡密数据
function myCurl($data, $url, $header = 0)
{
    $ch = curl_init($url);
    if ($header == 1) {
        $header = array(
            'Content-Type:' . 'application/json; charset=UTF-8'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;

}
function is_mobile()
{
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $iphone = (strpos($agent, 'iphone')) ? true : false;
    $ipad = (strpos($agent, 'ipad')) ? true : false;
    $android = (strpos($agent, 'android')) ? true : false;
    if($iphone || $ipad || $android){
        return true;
    } else {
        return false;
    };
}

