<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\pc\controller;
use think\Controller;
use think\Request;

class Help extends Controller {
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('is_mobile', is_mobile()?1:0);
    }
    public function gzh(){
        Request()->input();
        $this->assign('nav',3);
        return view();
    }
    //公告列表
    public function notice_list(){
        if(Request()->isAjax()){
            $re=get_notice(input());
            mac_return(0,'查询成功',$re['list'],$re['count']);
        }else{
            return view();
        }
    }
    //问题列表
    public function question_list(){
        if(Request()->isAjax()){
            $re=get_question(input());
            mac_return(0,'查询成功',$re['list'],$re['count']);
        }else{
            return view();
        }
    }
    //公告和问题详情
    public function notice_info(){
        $t=input('t')?:1;//默认是公告
        $id=intval(input('id'));
        $where='id='.$id;
        $table='notice';
        $show = intval(input('show',0));
        
        if($t==2){
           //默认公告
            $table='question';
        }elseif ($t==3){
            $table='sys_article';
        }
        $info=MC($table)->where($where)->find();
        $info['content']=htmlspecialchars_decode($info['content']);
        
        if($show == 1){
            return json(['code' => 0,'data' => $info]);
        }
        
        $this->assign('info',$info);
        $this->assign('t',$t);
        $this->assign('id',$id);
        return view();
    }
    //资讯列表
    public function article_list(){
        if(Request()->isAjax()){
            $re=get_article(input());
            mac_return(0,'查询成功',$re['list'],$re['count']);
        }else{
            return view();
        }
    }
    //api咨询
    public function api(){
        return view();
    }
    public function company(){
//        $list=MC('message')->paginate(2,false,input())->each(function (&$item,$key){
//            //return $item;
//            if($item['status']==1){
//                return $item;
//            }else{
//                unset($item);
//            }
//
//        })->toArray();
//        dy($list);
        return view();
    }
    public function card_rate_query()
    {
        if(Request()->isAjax()){
            $uid = session('uid');
            $search_name = input('search_name');
            
            $cinfo = MC('dk_list')->field('title,id,zc_profit,money,isanyrate')->where(['status' => 1])
            ->order('card_type ASC')
            ->select();

            $mdk_config = MC('m_dk_config')->where(['uid' => $uid])->find();

            $data = [];
            foreach ($cinfo as $k => $val) {
                $aaa = 'type' . $val['id'];
                if(!empty($mdk_config[$aaa])){
                    $data[$k]['id'] = $val['id']; 
                    $data[$k]['title'] = $val['title']; 
                    $data[$k]['rate'] = number_format($mdk_config[$aaa] / 10,2);//转为折扣; 
                    $data[$k]['money'] = $val['money']; 
                    $data[$k]['isanyrate'] = $val['isanyrate']; 
                }else{
                    $data[$k]['id'] = $val['id']; 
                    $data[$k]['title'] = $val['title']; 
                    $data[$k]['rate'] = $val['zc_profit']; 
                    $data[$k]['money'] = $val['money']; 
                    $data[$k]['isanyrate'] = $val['isanyrate']; 
                }
                
            }
             mac_return(0,'查询成功',$data,count($data));
        }else{
            return view();
        }
        
    }
}