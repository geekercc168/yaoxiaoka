<?php

namespace app\admin\controller;

use think\Cache;

import('lib.global_arr', EXTEND_PATH);

class Tongdao extends Home
{
    //通道列表
    public function zc_profit()
    {
        if (request()->isAjax()){
            $search_name=input('search_name');
            $map=array();
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=MC('dk_config')->alias('a')->join('dk_list b','a.dk_id=b.id','left')->field('a.*,b.title')->where($map)->order('status desc,listorder asc')->limit($start,$limit)->select();

            $count=MC('dk_config')->where($map)->count();
            $tongdao_arr=\global_arr::tongdao_arr();
            foreach($list as &$v){
                if (($v['type']=='MOBILE_DISCOUNT' || $v['type']=='UNICOM_DISCOUNT') || $v['tongdao']==6 || $v[tongdao]==2  || $v['tongdao']==11  || $v['tongdao']==12) {
                    $v['is_edit']=1;
                }else{
                    $v['is_edit']=0;
                }
                $v['profit']=$v['profit']?:'';
                $v['tongdao']?$v['td_txt'] = $tongdao_arr[$v['tongdao']]:$v['td_txt']='新';
            }
            return mac_return(0,'查询成功',$list,$count);
        }else{
            return view();
        }
    }

    //编辑比率
    public function save()
    {
        if (request()->isPost()) {
            $update_arr=[];
            $update_arr['listorder']=input('listorder');
            $dk_code=input('dk_id');//卡种
            $id=input('id');
            if($dk_code=='101' || $dk_code=='102' || $dk_code=='103'){
                //return mac_return(0,'自设汇率不允许修改渠道费率');
                //$pro_arr=explode('-',input('profit'));
//                if(count($pro_arr)!=2){
//                    return mac_return(0,'自设汇率格式错误,格式必须为（费率-费率）');
//                }
//                $pro_arr[0]=number_format($pro_arr[0],2);
//                $pro_arr[1]=number_format($pro_arr[1],2);
//                if($pro_arr[0]<95 || $pro_arr[0]>99.5 || $pro_arr[1]<95 || $pro_arr[1]>99.5){
//                    return mac_return(0,'自设汇率设置有误,最低95，最高99.5');
//                }
                $profit='';
            }else{
                $profit=number_format(input('profit'),2);
                if($profit<80 || $profit>99.9){
                    return mac_return(0,'系统汇率设置有误,最低80，最高99.9');
                }
            }
            $update_arr[profit]=$profit;
            //$update_arr[dk_id]=$dk_code;
            $res=MC('dk_config')->where(['id'=>$id])->update($update_arr);
            if ($res) {
                return mac_return();
            } else {
                return mac_return(0);
            }

        }else{

            return view();
        }
    }

    //修改状态
    public function tongdao_status()
    {
        $type = intval(input('type'));
        $id = input('id');
        if (request()->isPost()) {
            if ($type == 1) {
            $msg = '通道已开启';
        } else {
            //关闭通道
            $msg = '通道已关闭';
        }
        //更新点卡配置表
        $r = MC('dk_config')->where(['id'=>$id])->update(['status'=>$type]);
        if ($r) {
            return mac_return(1, $msg);
        } else {
            return mac_return(0);
        }
        }else{
            return mac_return(0);
        }
    }
    //卡种列表
    public function dk_list(){
        if (request()->isAjax()){

            $search_name=input('search_name');
            $map=[];
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=MC('dk_list')->field('*')->where($map)->order('status desc,listorder asc,id desc')->limit($start,$limit)->select();
            $count=MC('dk_list')->where($map)->count();
            return mac_return(0,'查询成功',$list,$count);
        }else{
//            $tongdao_arr=\global_arr::type_arr();
//            foreach ($tongdao_arr as $v){
//                MC('dk_list')->insert(['title'=>$v]);
//            }
            return view();
        }
    }
    //编辑卡种
    public function dk_edit(){
        $id=input('id');
        if($id){
            $item = MC('dk_list')->where("id=$id")->find();
            $dk_config = MC('dk_config')->field('config_desc,id,profit,listorder,tongdao')->where('status=1 and dk_id='.$id)->select();

            //超快销
            if($item['isanyrate'] == 1){

                $sys_config=get_sys_config();
                $sys_config['xm_mobile']=explode(',',$sys_config['xm_mobile']);
                $sys_config['xm_unicom']=explode(',',$sys_config['xm_unicom']);
                $sys_config['xm_telecom']=explode(',',$sys_config['xm_telecom']);
                $this->assign('sys_config',$sys_config);
            }

            $tongdao_arr = \global_arr::tongdao_arr();
            $this->assign('dk_config',$dk_config);
            $this->assign('tongdao_arr',$tongdao_arr);
            $this->assign('item',$item);
        }
        if (request()->isPost()) {
            //MC('dk_list')->where('1=1')->update(['money'=>'10,15,20,30,50,100,200,300,500,1000']);dy(1);
            $filed=array('title','img','card_type','zc_profit','money','listorder','content','card','pwd');//允许通过的字段
            $parm=input();

            $up_dk_config_data = [];
            
            $str_zc_profit = $parm['zc_profit'];
            $str_money = $parm['money'];

            $str_money = rtrim($str_money,',');
            $arr_money = explode(',', $str_money);

            $str_zc_profit = rtrim($str_zc_profit,',');
            $arr_zc_profit = explode(',', $str_zc_profit);

            $_aaaNum = count($arr_zc_profit);
            $_bbbNum = count($arr_money);
            if($_aaaNum > 1){
                if($_aaaNum != $_bbbNum)
                return mac_return(0,'费率和面值个数不一致');
            }
           
            if(count($parm['dk_profit']) == count($parm['dk_listorder'])){

                foreach ($parm['dk_profit'] as $key => $val) {
                    $up_dk_config_data[$key]['id'] = $key;
                    $up_dk_config_data[$key]['profit'] = $val;
                }
                foreach ($parm['dk_listorder'] as $key => $val) {
                    $up_dk_config_data[$key]['listorder'] = $val;
                }
                
                $res = model('DkConfig')->saveAll($up_dk_config_data);
            }

            if($item['isanyrate'] == 1){
                $filedSoon=array(
                'xm_mobile','xm_unicom','xm_telecom','order_count','sxk_mobile','sxk_unicom','sxk_telecom',
                'xm_mobile_limit','xm_unicom_limit','xm_telecom_limit','sxk_mobile_limit','sxk_unicom_limit','sxk_telecom_limit'
                );//允许通过的字段
                $parmSoon =input();

                foreach($parmSoon as $k=>$v){
                    ($k=='xm_mobile' || $k=='xm_unicom'|| $k=='xm_telecom')&& $v=implode(',',$v);
                    if(in_array($k,$filedSoon)){
                        MC('sys_config')->where("k='".$k."'")->update(['v'=>$v]);
                    }else{
                        unset($parmSoon[$k]);
                    }
                }
            }

            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }
            if($id){
                if($item['isAnyRate']==1){
                    $pro_arr=explode('-',input('zc_profit'));
                    if(count($pro_arr)!=2){
                        return mac_return(0,'自设汇率格式错误,格式必须为（最低费率-最高费率）');
                    }
                    $pro_arr[0]=number_format($pro_arr[0],2,'.','');
                    $pro_arr[1]=number_format($pro_arr[1],2,'.','');

                    if($pro_arr[0]<95 || $pro_arr[0]>99.5 || $pro_arr[1]<95 || $pro_arr[1]>99.5){
                        return mac_return(0,'自设汇率设置有误,最低95，最高99.5');
                    }
                }else{
                    $profit=number_format(input('zc_profit'),2,'.','');
                    if($profit<80 || $profit>99.9){
                        return mac_return(0,'用户汇率设置有误,最低80，最高99.9');
                    }
                }
            }
            if ($id) {
                $sql = MC('dk_list')->where('id='.$id.'')->update($parm);
            }else{
                $sql = MC('dk_list')->insert($parm);
            }

            if ($sql >= 0) {
                return mac_return();
            }else{
                return mac_return(0);
            }
        }

        return view();
    }

    //点卡状态
    public function dk_status()
    {
        $type = intval(input('type'));
        $id = input('id');
        if (request()->isPost()) {
            //更新点卡配置表
            $r = MC('dk_list')->where(['id'=>$id])->update(['status'=>$type]);
            if ($r) {
                return mac_return();
            } else {
                return mac_return(0);
            }
        }else{
            return mac_return(0);
        }
    }

    //通道配置
    public function sys_config(){
        if (request()->isAjax()){
            $filed=array(
                'xm_mobile','xm_unicom','xm_telecom','order_count','sxk_mobile','sxk_unicom','sxk_telecom',
                'xm_mobile_limit','xm_unicom_limit','xm_telecom_limit','sxk_mobile_limit','sxk_unicom_limit','sxk_telecom_limit'
            );//允许通过的字段
            $parm=input();
            
            $parm['ltmxSt_20'] = input('ltmxSt_20')?? 0;
            $parm['ltmxSt_50'] = input('ltmxSt_50')?? 0;
            $parm['ltmxSt_30'] = input('ltmxSt_30')?? 0;
            $parm['ltmxSt_100'] = input('ltmxSt_100')?? 0;

            $parm['ltkxSt_20'] = input('ltkxSt_20')?? 0;
            $parm['ltkxSt_50'] = input('ltkxSt_50')?? 0;
            $parm['ltkxSt_30'] = input('ltkxSt_30')?? 0;
            $parm['ltkxSt_100'] = input('ltkxSt_100')?? 0;

            $parm['ltckxSt_20'] = input('ltckxSt_20')?? 0;
            $parm['ltckxSt_50'] = input('ltckxSt_50')?? 0;
            $parm['ltckxSt_30'] = input('ltckxSt_30')?? 0;
            $parm['ltckxSt_100'] = input('ltckxSt_100')?? 0;

            $parm['ydmxSt_20'] = input('ydmxSt_20')?? 0;
            $parm['ydmxSt_50'] = input('ydmxSt_50')?? 0;
            $parm['ydmxSt_30'] = input('ydmxSt_30')?? 0;
            $parm['ydmxSt_100'] = input('ydmxSt_100')?? 0;

            $parm['ydkxSt_20'] = input('ydkxSt_20')?? 0;
            $parm['ydkxSt_50'] = input('ydkxSt_50')?? 0;
            $parm['ydkxSt_30'] = input('ydkxSt_30')?? 0;
            $parm['ydkxSt_100'] = input('ydkxSt_100')?? 0;

            $parm['ydckxSt_20'] = input('ydckxSt_20')?? 0;
            $parm['ydckxSt_50'] = input('ydckxSt_50')?? 0;
            $parm['ydckxSt_30'] = input('ydckxSt_30')?? 0;
            $parm['ydckxSt_100'] = input('ydckxSt_100')?? 0;

            $parm['dxmxSt_20'] = input('dxmxSt_20')?? 0;
            $parm['dxmxSt_50'] = input('dxmxSt_50')?? 0;
            $parm['dxmxSt_30'] = input('dxmxSt_30')?? 0;
            $parm['dxmxSt_100'] = input('dxmxSt_100')?? 0;

            $parm['dxkxSt_20'] = input('dxkxSt_20')?? 0;
            $parm['dxkxSt_50'] = input('dxkxSt_50')?? 0;
            $parm['dxkxSt_30'] = input('dxkxSt_30')?? 0;
            $parm['dxkxSt_100'] = input('dxkxSt_100')?? 0;

            $parm['dxckxSt_20'] = input('dxckxSt_20')?? 0;
            $parm['dxckxSt_50'] = input('dxckxSt_50')?? 0;
            $parm['dxckxSt_30'] = input('dxckxSt_30')?? 0;
            $parm['dxckxSt_100'] = input('dxckxSt_100')?? 0;
            
            foreach($parm as $k=>$v){
                ($k=='xm_mobile' || $k=='xm_unicom'|| $k=='xm_telecom')&& $v=implode(',',$v);
                if(in_array($k,$filed)){
                    MC('sys_config')->where("k='".$k."'")->update(['v'=>$v]);
                }else{
                    $res = Cache::store('redis')->set($k,$v);
                    //unset($parm[$k]);
                }
            }

            return mac_return();
        }else{
            $sys_config=get_sys_config();
            $sys_config['xm_mobile']=explode(',',$sys_config['xm_mobile']);
            $sys_config['xm_unicom']=explode(',',$sys_config['xm_unicom']);
            $sys_config['xm_telecom']=explode(',',$sys_config['xm_telecom']);
            $this->assign('item',$sys_config);
            return view();
        }
    }

}