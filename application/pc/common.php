<?php
/**
 * 编码转换
 * @param unknown $_input_charset 转换之前
 * @param unknown $_output_charset 转换之后
 * @param unknown $input
 * @return unknown|Ambigous <unknown, string>
 */
function charset_encode($_input_charset, $_output_charset, $input) {
    $output = "";
    $string = $input;
    if (is_array ( $input )) {
        $key = array_keys ( $string );
        $size = sizeof ( $key );
        for($i = 0; $i < $size; $i ++) {
            $string [$key [$i]] = charset_encode ( $_input_charset, $_output_charset, $string [$key

            [$i]] );
        }
        return $string;
    } else {
        if (! isset ( $_output_charset ))
            $_output_charset = $_input_charset;
        if ($_input_charset == $_output_charset || $input == null) {
            $output = $input;
        } elseif (function_exists ( "mb_convert_encoding" )) {
            $output = mb_convert_encoding ( $input, $_output_charset, $_input_charset );
        } elseif (function_exists ( "iconv" )) {
            $output = iconv ( $_input_charset, $_output_charset, $input );
        } else
            die ( "sorry, you have no libs support for charset change." );
        return $output;
    }
}
//咔咪秘钥字符串组合方式
function cami_getSign($params) {
    $key = CAMISIHNKEY;
    $str = "";
     
    foreach ($params as $k => $v ) {
       $str .= $v."&";
    }
    $str.=$key;
   
    return strtolower(md5($str));
}
//闲卖卡秘钥字符串组合方式
function xm_getSign($params) {
    $key = XMMD5;
    $str = "";
    ksort($params);
    foreach ( $params as $k => $v ) {
        if(!is_null($v) && isset($v)){
            $str .= $k."=".$v."&";
        }
    }
    $str.="key=".$key;
    //file_put_contents('md5str.txt',$str."\n",FILE_APPEND);
    return strtoupper(md5($str));
}

//速销卡秘钥字符串组合方式
function sxk_getSign($params) {
    $key = SMD5;
    $str = "";
    foreach ( $params as $k => $v ) {
        $str .= $v."&";
    }
    $str.=$key;
    //file_put_contents('md5str.txt',$str."\n",FILE_APPEND);
    return strtolower(md5($str));
}
//汇速通秘钥字符串组合方式
function hst_getSign($params) {
    $MD5key = HMD5;
    $str = "";
    foreach ( $params as $k => $v ) {
        $str .= $k."=".$v."&";
    }
    $str =rtrim($str,'&');
    $str.= "|||".$MD5key;
    return md5($str);
}
//汇速通秘钥字符串组合方式
function sup_getSign($params) {
    $key = SUPMD5;
    $str = "";
    foreach ( $params as $k => $v ) {
        $str .= $k."=".$v."&";
    }
    $str =rtrim($str,'&');
    $str.= $key;
    return md5($str);
}
//销卡啦秘钥字符串组合方式
function xkl_getSign($params) {
    $key = XKLMD5;
    ksort($params);
    $str = "";
    foreach ( $params as $k => $v ) {
        if(isset($v) && !is_null($v)){
            $str .= $k."=".$v."&";
        }
    }
    $str.='key='.$key;
    return strtolower(md5($str));
}