<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use think\Db;
use think\Request;
use think\Session;

class Admin extends Home
{
	/**
	 * 管理员列表
	 */
	public function admin_list()
	{
        if (request()->isAjax()){
            $search_name=input('search_name');
            $this->assign('search_name',$search_name);
            $map=array();
            if($search_name){
                $map['username']= array('like',"%".$search_name."%");
            }
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $admin_list=Db::name('user')->alias('a')
                ->join('user_group b','a.group_id=b.group_id','left')->field('a.*,FROM_UNIXTIME(reg_time,"%Y-%m-%d %H:%i:%s") as reg_time,b.groupname')->where($map)->limit($start,$limit)->order('userid')->select();
            foreach($admin_list as &$v){
                unset($v['password']);
            }
            $count=Db::name('user')->where($map)->order('userid')->count();
            return mac_return(0,'查询成功',$admin_list,$count);
        }else{
            return $this->fetch();
        }

	}
	/**
	 * 管理员添加
	 */
	public function admin_add()
	{
        $id = input('id');
        if (request()->isPost()){
            // echo '提交的时候';
            $admin = Db::name('user');
            $filed=array('userid','username','password','group_id','email','qq','mobile','truename','cash');//允许通过的字段
            $parm=input();
            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }
            if ($id) {
                $sql = Db::name('user')->where(["username"=>$parm['username'],'userid'=>['neq',$id]])->find();
                if ($sql) {
                    return mac_return(0,'用户名重复');
                }
                $info= Db::name('user')->where(['userid'=>$id])->find();
                if($parm['password']!=$info['password']){
                    $parm['password']=md5("JJpay:!@#%".$parm['password']);
                }
                $sql = $admin->where('userid='.$id.'')->update($parm);
                if ($sql) {
                    return mac_return();
                }
            }else{
                $sql = Db::name('user')->where(["username"=>$parm['username']])->find();
                if ($sql) {
                    return mac_return(0,'用户名重复');die;
                }
                $parm['password']=md5("JJpay:!@#%".$parm['password']);
                $parm['reg_time']=time();
                $sql = $admin->insert($parm);
                if ($sql) {
                    return mac_return();
                }

            }
        }else{
            $auth_group=Db::name('user_group')->select();
            $this->assign('list',$auth_group);
            if($id){
                $item=Db('user')->where("userid=$id")->find();
                $this->assign('item',$item);
            }
            return $this->fetch();
        }
	}
	// 隐藏管理员
	public function manager_on()
	{
		if (request()->isPost()){
			if (input('post.id') == 1) {
				exit;
			}
			Db('user')->where(['userid' => input('post.id')])->update([
			    'status'  => input('post.type'),
			]);
			$code = 1;
		}else{
			$code = 2;
		}
		return json_encode($code);
	}
	//删除管理员
    public function manager_del()
    {
        if (Request::instance()->isAjax()) {
            $id = input('id');
            if (Db::name('user')->where('userid=' . $id)->delete()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo -1;
        }
    }
	//用户组管理
    public function user_group(){
        if (request()->isAjax()){
            $search_name=input('search_name');
            $this->assign('search_name',$search_name);
            $map=array();
            if($search_name){
                $map['username']= array('like',"%".$search_name."%");
            }
            $p = trim(input('page')) ? trim(input('page')) : 1 ;
            $limit = trim(input('limit')) ? trim(input('limit')) : PAGESIZE ;
            $start=($p-1)*$limit;
            $list=Db::name('user_group')->field('*,FROM_UNIXTIME(on_time,"%Y-%m-%d %H:%i:%s") as on_time')->where($map)->limit($start,$limit)->select();
            $count=Db::name('user_group')->where($map)->count();
            return mac_return(0,'',$list,$count);
        }else{
            return view();
        }

    }
    //用户组添加或编辑
    public function user_group_add(){
	    $group_id=input('group_id');
        if (request()->isPost()) {
            $filed=array('group_roles','group_id','groupname');//允许通过的字段
            $parm=input();
            foreach($parm as $k=>$v){
                if(!in_array($k,$filed)){unset($parm[$k]);};
            }
            $parm['group_roles']=implode(',',$parm['group_roles']);
            if ($group_id) {
                $sql = Db('user_group')->where('group_id='.$group_id.'')->update($parm);
                if ($sql) {
                    return mac_return();
                }
            }else{
                $parm['on_time']=time();
                $sql = Db('user_group')->insert($parm);
                if ($sql) {
                    return mac_return();
                }

            }

        }else{
            $menu=Db('menu')->where(['status'=>1])->order('listorder asc')->select();
            foreach($menu as $k=>$v){
                $_str = $v['submenu_id'];
                $menu[$k]['erji'] = Db('menu_item')->where("submenu_id='{$_str}'")->order('listorder asc')->select();
            }
            if($group_id){
                //该角色的权限
                $group=Db('user_group')->where("group_id=$group_id")->find();
                $this->assign('group_roles',explode(',',$group['group_roles']));
                $this->assign('item',$group);
            }
            $this->assign('list',$menu);

            return view();
        }
    }
    //用户组删除
    public function user_group_del()
    {
        if (Request::instance()->isAjax()) {
            $group_id = input('group_id');
            if (Db::name('user_group')->where('group_id=' . $group_id)->delete()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo -1;
        }
    }


	// 个人信息
	public function profile()
	{
		if (request()->isPost()){
			$user = session::get('admin_user');//用户名
			$sql = Db::name('admin')->where("admin_username",$user)->find();
			$email = input('post.admin_email');
			$realname = input('post.admin_realname');
			$tel = input('post.admin_tel');
			if ($sql['admin_email'] == $email && $sql['admin_realname'] == $realname && $sql['admin_tel'] == $tel ) {
				$this->redirect('admin/profile');
			}
			$manager = AdminModel::get(['admin_username' => $user]);
			$manager->admin_email     = $email;
			$manager->admin_realname  = $realname;
			$manager->admin_tel       = $tel;
			$sql = $manager->save();
			if ($sql) {
				$this->redirect('admin/profile');
			}
		}else{
			$user = session::get('admin_user');//用户名
			$sql = Db::name('admin')->where("admin_username",$user)->find();
			$this->assign('list',$sql);
			return view('info');
		}
	}
	//上传图片
	function manager_upload(){
		$file = request()->file('file');
		// 移动到框架应用根目录/public/static/admin/banner/当前时间/文件 目录下
	    if($file){
	        $info = $file->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'admin'. DS . 'manager');
	        if($info){
	            // 成功上传后 获取上传信息
	            $data['code'] = 0;
	            $data['msg']= '';
	            $data['data'] = [
	            	'src' => $info->getSaveName(),
	            ];
	            echo json_encode($data);
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }
	    }
	}
}