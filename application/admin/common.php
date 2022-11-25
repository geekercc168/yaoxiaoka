<?php

//订单查询页面的查询语句
function sql_str($stype){

    switch($stype){
        case 8:
            $sql ="  and (type in(8,13) or  (type=31 and tongdao=4) or (tongdao=5 and type='SZX') or (tongdao=6 and type like 'MOBILE%') or (tongdao=7 and type='1008') or (tongdao=8 and type='3') or (tongdao=9 and type='203')  or (tongdao=11 and type='MOBILE') or (tongdao=12 and type=6)) ";
            break;
        case 12:
            $sql ="   and (type in(12,61,45) or (tongdao=5 and type='SFT') or (tongdao=6 and type='SFT')) ";
            break;
        case 10:
            $sql =" and (( type=10 and tongdao=1 ) or (type=14 and tongdao=2)  or (tongdao=5 and type='LT') or (tongdao=6 and type like 'UNICOM%') or (tongdao=7 and type='1010') or (type=25 and tongdao=4) or (tongdao=8 and type='5') or (tongdao=9 and type='205') or (tongdao=11 and type='UNICOM') or (tongdao=12 and type=7)) ";
            break;
        case 9:
            $sql =" and (( type=9 and tongdao=1 ) or (type=15 and tongdao=2)  or (tongdao=5 and type='DX') or (tongdao=6 and type like 'TELECOM%')  or (tongdao=7 and type='1009') or (type=26 and tongdao=4)  or (tongdao=8 and type='4') or (tongdao=9 and type='204') or (tongdao=11 and type='TELECOM') or (tongdao=12 and type=8)) ";
            break;
        case 6:
            $sql =" and ( type=6  or (type=10 and tongdao=2)  or (tongdao=6 and type='JW') or (tongdao=5 and type='JW') or (type=30 and tongdao=4) ) ";
            break;
        case 14:
            $sql =" and ( (type=14 and tongdao=1)  or (tongdao=6 and type='QB')  or (tongdao=5 and type='QQ') or (type=18 and tongdao=4) )";
            break;
        case 7:
            $sql =" and ( (type=7 and tongdao=1)   or (tongdao=6 and type='JY')  or (tongdao=5 and type='JY') or (type=28 and tongdao=4) )";
            break;
        case 2:
            $sql =" and ( (type=2 and tongdao=1)   or (tongdao=2 and type=44)  or (tongdao=6 and type='WM')  or (tongdao=5 and type='WM')  or (type=24 and tongdao=4) )";
            break;
        case 3:
            $sql =" and ( (type=3 and tongdao=1)   or (tongdao=6 and type='SH')  or (tongdao=5 and type='SH') or (type=35 and tongdao=4) )";
            break;
        case 4:
            $sql =" and ( (type=4 and tongdao=1)  or (tongdao=6 and type='ZT')  or (tongdao=5 and type='ZT') or (type=47 and tongdao=4) )";
            break;
        case 5:
            $sql =" and ( (type=5 and tongdao=1)  or (tongdao=6 and type='WY') or (tongdao=5 and type='WY')  or (type=22 and tongdao=4) )";
            break;
        case 15:
            $sql =" and ( (type=15 and tongdao=1) or (type=60 and tongdao=2) or (tongdao=6 and type='TH') or (tongdao=5 and type='TH') or (type=32 and tongdao=4)  )";
            break;
        case 43:
            $sql =" and ( (type=43 and tongdao=10)   )";
            break;
        case 60:
            $sql =" and ( (type=60 and tongdao=10)   )";
            break;
        case 44:
            $sql =" and ( (type=44 and tongdao=10)   )";
            break;
        case 39:
            $sql =" and ( (type=39 and tongdao=10)  or   (tongdao=6 and type='WRM'))";
            break;
        case 32:
            $sql =" and ( (type=32 and tongdao=10)  or   (tongdao=6 and type='DDLP'))";
            break;
        case 41:
            $sql =" and ( (type=41 and tongdao=10)  or   (tongdao=6 and type='YMS'))";
            break;
        default:
            $sql ="  and type ='".$stype."'";
            break;
    }

    return $sql;

}
//可重提构造语句
function sql_kct(){

    $sql = "  and (status_desc like '%处理失败%' or status_desc='系统繁忙，请稍后再试' or status_desc='人工删除' or status_desc like '%超时%' or status_desc like '%可重提%' or status_desc like '%未匹配%' or status_desc ='卡密未使用'  or status_desc like '%可再次提交%' or status_desc like '%非卡密原因失败%' or status_desc like '%销卡失败,未尝试%' or ISNULL(status_desc) ) ";
    return $sql;

}


//生成新的重提订单
function newOrder($order_res,$tongdao,$type,$xt_huilv){
    $neworderid = 'jjp'.date("YmdHis",time()).rand(1000000,9999999);
        $insert_array = array(
            'uid' =>$order_res['uid'],
            'orderid' =>$neworderid,
            'crad_number' =>$order_res['crad_number'],
            'crad_pass' =>$order_res['crad_pass'],
            'cash' =>$order_res['cash'],
            'type' =>$type,
            'status' =>0,
            'on_time' =>time(),
            'total_orderid'=>$order_res['total_orderid'],
            'tongdao'=>$tongdao,
            'user_huilv'=>$order_res['user_huilv'],
            'xt_huilv'=>$xt_huilv,
        );
        $res=MC('orders')->insert($insert_array);//生成用户订单
}
