<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Request;

class Article extends Home
{
    
    //关键词设置
    public function key_word()
    {
        if(Request()->isPost()){
            
            $jaja_title = input('jaja_title');
            $jaja_keywords = input('jaja_keywords');
            $jaja_desc = input('jaja_desc');

            $res1 = SetRedis('jaja_title',$jaja_title,86400*365);
            $res2 = SetRedis('jaja_keywords',$jaja_keywords,86400*365);
            $res3 = SetRedis('jaja_desc',$jaja_desc,86400*365);
            if($res1 = $res2 = $res3 = true){
                $code = 1;
            }else{
                $code = 0;
            }
            return mac_return($code);
        }else{
            
            $this->assign('jaja_title',GetRedis('jaja_title'));
            $this->assign('jaja_keywords',GetRedis('jaja_keywords'));
            $this->assign('jaja_desc',GetRedis('jaja_desc'));
            return view();
        }
    }
    
    //新闻管理
    public function article_list(){
        if (request()->isAjax()){
            $search_name=input('search_name');
            $this->assign('search_name',$search_name);
            $map=array();
            if($search_name){
                $map['title']= array('like',"%".$search_name."%");
            }
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=MC('sys_article')->alias('a')->join('sys_article_categ b','a.categ_id=b.categ_id')->field('a.*,b.categ_name,FROM_UNIXTIME(pub_time,"%Y-%m-%d %H:%i:%s") as pub_time')->where($map)->order('id desc')->limit($start,$limit)->select();
            $count=MC('sys_article')->where($map)->count();
            return mac_return(0,'查询成功',$list,$count);
        }else{
            return view();
        }

    }
    //新闻添加或编辑
    public function add_article(){
        $id=input('id');
        if (request()->isPost()) {
            $filed=array('uid','title','author','categ_id','content','logo','hot','status');//允许通过的字段
            $parm=input();
            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }
            if ($id) {

                $sql = MC('sys_article')->where('id='.$id.'')->update($parm);
                if ($sql) {
                    refresh_index_article();
                    return mac_return();
                }else{
                    return mac_return(0);
                }
            }else{
                $parm['pub_time']=time();
                $uinfo=session('user_info');
                $parm['uid']=$uinfo['userid'];
                $parm['author']=$uinfo['username'];
                $sql = MC('sys_article')->insert($parm);
                if ($sql) {
                    refresh_index_article();
                    return mac_return();
                }else{
                    return mac_return(0);
                }

            }

        }else{
//            $list=MC('sys_article','db3')->where('id>30')->select();
//            foreach ($list as $k=>$v){
//                $v['content']=str_replace('jijika.cn','1xiaoka.com',$v['content']);
//                $v['content']=str_replace('jijipay.com','1xiaoka.com',$v['content']);
//                $v['title']=str_replace('集集付','要销卡',$v['title']);
//                $v['content']=str_replace('集集付','要销卡',$v['content']);
//                $uinfo=session('user_info');
//                $v['uid']=$uinfo['userid'];
//                $v['author']=$uinfo['username'];
//                $v['pub_time']=time();
//                $v['status']=1;
//                unset($v['creat_time']);
//                unset($v['id']);
//                MC('sys_article')->insert($v);
//            }
//            dy(1);
            $cate=MC('sys_article_categ')->select();
            if($id){
                //该角色的权限
                $item=MC('sys_article')->where("id=$id")->find();
                $this->assign('item',$item);
            }
            $this->assign('list',$cate);

            return view();
        }
    }
    //新闻删除
    public function article_del()
    {
        if (Request::instance()->isAjax()) {
            $ids=explode(',',input('post.id'));
            if (MC('sys_article')->where(['id' => ['in',$ids]])->delete()) {
                refresh_index_article();
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }
    // 隐藏新闻
    public function article_on()
    {
        if (request()->isPost()){
            $ids=explode(',',input('post.id'));
            MC('sys_article')->where(['id' => ['in',$ids]])->update([
                'status'  => input('post.type'),
            ]);
            refresh_index_article();
            return mac_return();
        }else{
            return mac_return(0);
        }
    }
    //新闻类型
    public function cate_list(){
        if (request()->isAjax()){
            $map=array();
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=MC('sys_article_categ')->field('*,FROM_UNIXTIME(on_time,"%Y-%m-%d %H:%i:%s") as on_time')->where($map)->limit($start,$limit)->select();
            $count=MC('sys_article_categ')->where($map)->count();
            return mac_return(0,'查询成功',$list,$count);
        }else{
            return view();
        }

    }
    //新闻类型添加或编辑
    public function add_cate(){
        $categ_id=input('categ_id');
        if (request()->isPost()) {
            $filed=array('categ_id','categ_name');//允许通过的字段
            $parm=input();
            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }
            if ($categ_id) {
                $sql = MC('sys_article_categ')->where('categ_id='.$categ_id.'')->update($parm);
                if ($sql) {
                    return mac_return();
                }
            }else{
                if (MC('sys_article_categ')->where(["categ_name"=>$parm['categ_name']])->find()) {
                    return mac_return(0,'类别名已存在');
                }

                $parm['on_time']=time();
                $sql = MC('sys_article_categ')->insert($parm);
                if ($sql) {
                    return mac_return();
                }

            }

        }else{
            $menu=Db('menu')->where(['status'=>1])->order('listorder asc')->select();
            foreach($menu as $k=>$v){
                $menu[$k]['erji']=Db('menu_item')->where("submenu_id=$v[submenu_id]")->order('listorder asc')->select();
            }
            if($categ_id){
                //该角色的权限
                $group=MC('sys_article_categ')->where("categ_id=$categ_id")->find();
                $this->assign('group_roles',explode(',',$group['group_roles']));
                $this->assign('item',$group);
            }
            $this->assign('list',$menu);

            return view();
        }
    }
    //新闻类型删除
    public function cate_del()
    {
        if (Request::instance()->isAjax()) {
            $categ_id = input('categ_id');
            if (MC('sys_article_categ')->where('categ_id=' . $categ_id)->delete()) {
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }



    //公告列表
    public function notice_list(){
        if (request()->isAjax()){
            $res=get_notice(input());
            return mac_return(0,'查询成功',$res['list'],$res[count]);
        }else{
            return view();
        }

    }
    //公告添加或编辑
    public function add_notice(){
        $id=intval(input('id'));
        if (request()->isPost()) {
            $filed=array('uid','title','author','pub_user','content',);//允许通过的字段
            $parm=input();
            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }

            if ($id>0) {
                MC('notice')->where('id='.$id.'')->update($parm);
            }else{
                $parm['pub_time']=time();
                $uinfo=session('user_info');
                $parm['uid']=$uinfo['userid'];
                $parm['pub_user']=$uinfo['username'];
                MC('notice')->insert($parm);
            }

            refresh_index_notice();
            return mac_return();

        }else{
            if($id){
                $item=MC('notice')->where("id=$id")->find();
                $this->assign('item',$item);
            }
            return view();
        }
    }
    //公告删除
    public function notice_del()
    {
        if (Request::instance()->isAjax()) {
            $ids=explode(',',input('post.id'));
            if(MC('notice')->where(['id' => ['in',$ids]])->delete()) {

                refresh_index_notice();
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }

    // 操作公告状态
    public function notice_on()
    {
        if (request()->isPost()){
            $ids=explode(',',input('post.id'));
            MC('notice')->where(['id' => ['in',$ids]])->update([
                'is_top'  => input('post.type'),
            ]);
            refresh_index_notice();
            return mac_return();
        }else{
            return mac_return(0);
        }

    }

    //问题列表
    public function question_list(){
        if (request()->isAjax()){
            $res=get_question(input());
            return mac_return(0,'查询成功',$res['list'],$res[count]);
        }else{
            return view();
        }

    }
    //公告添加或编辑
    public function add_question(){
        $id=intval(input('id'));
        if (request()->isPost()) {
            $filed=array('uid','title','author','pub_user','content',);//允许通过的字段
            $parm=input();
            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }

            if ($id>0) {
                MC('question')->where('id='.$id.'')->update($parm);
            }else{
                $parm['pub_time']=time();
                $uinfo=session('user_info');
                $parm['uid']=$uinfo['userid'];
                $parm['pub_user']=$uinfo['username'];
                MC('question')->insert($parm);

            }

            refresh_index_question();
            return mac_return();

        }else{
            if($id){
                $item=MC('question')->where("id=$id")->find();
                $this->assign('item',$item);
            }
            return view();
        }
    }
    //公告删除
    public function question_del()
    {
        if (Request::instance()->isAjax()) {
            $ids=explode(',',input('post.id'));
            if(MC('question')->where(['id' => ['in',$ids]])->delete()) {
                refresh_index_question();
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }
    // 操作问题状态
    public function question_on()
    {
        if (request()->isPost()){
            $ids=explode(',',input('post.id'));
            MC('question')->where(['id' => ['in',$ids]])->update([
                'is_top'  => input('post.type'),
            ]);
            refresh_index_question();
            return mac_return();
        }else{
            return mac_return(0);
        }

    }

    //站内信列表
    public function message_list(){
        if (request()->isAjax()){
            $map=array();
            if(input('search_name')){
                $map['content']= array('like',"%".input('search_name')."%");
            }
            if(input('uid')){
                $map['uid']= input('uid');
            }
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=MC('message')->where($map)->order('id desc')->limit($start,$limit)->select();
            $count=MC('message')->where($map)->count();
            return mac_return(0,'查询成功',$list,$count);
        }else{
            return view();
        }
    }
    //新闻添加或编辑
    public function add_message(){
        $id=intval(input('id'));
        if (request()->isPost()) {
            $filed=array('uid','content',);//允许通过的字段
            $parm=input();
            if(intval($parm['uid'])>=0){
                foreach($parm as $k=>$v){
                    if(!in_array($k,$filed)){unset($parm[$k]);};
                }
                if ($id>0) {
                    MC('message')->where('id='.$id.'')->update($parm);
                    return mac_return();
                }else{
                    $parm['on_time']=time();
                    MC('message')->insert($parm);
                    return mac_return();

                }
            }else{
                return mac_return(0,'用户id异常');
            }
        }else{
            if($id){
                $item=MC('message')->where("id=$id")->find();
                $this->assign('item',$item);
            }
            return view();
        }
    }
    //新闻类型删除
    public function message_del()
    {
        if (Request::instance()->isAjax()) {
            $ids=explode(',',input('post.id'));
            if(MC('message')->where(['id' => ['in',$ids]])->delete()) {
                return mac_return();
            } else {
                return mac_return(0);
            }
        }
    }




}