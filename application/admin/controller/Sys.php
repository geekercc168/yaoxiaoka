<?php

// +----------------------------------------------------------------------

// | YFCMF [ WE CAN DO IT MORE SIMPLE ]

// +----------------------------------------------------------------------

// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.

// +----------------------------------------------------------------------

// | Author: rainfer <81818832@qq.com>

// +----------------------------------------------------------------------

namespace app\admin\controller;



use app\admin\model\AuthRule;

use app\admin\model\Options;

use app\admin\model\MenuModel;

use think\Request;

use think\Db;

use think\Cache;



class Sys extends Home

{

	/**

	 * 权限(后台菜单)列表

	 */

	public function admin_rule_list()

	{

		return view('menu_list');

	}

	// ajax菜单数据

	public function ajax_menu_list()

	{

		$menu = new MenuModel();

		$list=$menu->ajax_menu_list();

		$data['code'] = '0';

		$data['msg'] = '';

		$data['data'] = $list;

		$data['count']=count($list);

		$data=json_encode($data);

		echo $data;

	}

	// 隐藏菜单

	public function menu_del()

	{

		if (request()->isPost()){

			$menu = new MenuModel;

			$menu->save([

			    'status'  => input('post.type'),

			],['id' => input('post.id')]);

			$code = 1;

		}else{

			$code = 2;

		}

		return json_encode($code);

	}

	/**

	 * 权限(后台菜单)添加

	 */

	public function admin_rule_add()

	{

		$pid=input('pid',0);

		//全部规则

		$admin_rule_all=Db::name('auth_rule')->where('status = 1')->order('sort')->select();

		$arr = $this->menu_left($admin_rule_all);

		$this->assign('list',$arr);

		$this->assign('pid',$pid);

		return view('menu_add');

	}

	public function menu_add()

	{

		if (request()->isPost()){

			// echo '提交的时候';

			$menu = new MenuModel();

			$id = input('post.id');

			$ziduan = input('post.field');

			$val = input('post.value');

			if ($id) {

				$sql = $menu->save([

				    $ziduan  => $val,

				],['Id' => $id]);

				if ($sql) {

					$data['status'] = '1';

					$data['tips'] = '添加成功';

					echo json_encode($data);

				}

			}else{

				$menu->pid=input('post.pid');

				$menu->name=input('post.name');

				$menu->title=input('post.title');

				$menu->css=input('post.css');

				$menu->sort=input('post.sort');

				$menu->addtime=time();

				$sql = $menu->save();

				if ($sql) {

					$data['status'] = '1';

					$data['tips'] = '添加成功';

					echo json_encode($data);

				}

			}

		}

	}

	/**

	* 返回按层级加前缀的菜单数组

	* @author  rainfer

	* @param array|mixed $menu 待处理菜单数组

	* @param string $id_field 主键id字段名

	* @param string $pid_field 父级字段名

	* @param string $lefthtml 前缀

	* @param int $pid 父级id

	* @param int $lvl 当前lv

	* @param int $leftpin 左侧距离

	* @return array

	*/

	function menu_left($menu,$id_field='id',$pid_field='pid',$lefthtml = '─' , $pid=0 , $lvl=0, $leftpin=0)

	{

	    $arr=array();

	    foreach ($menu as $v){

	        if($v[$pid_field]==$pid){

	            $v['lvl']=$lvl + 1;

	            $v['leftpin']=$leftpin;

	            $v['lefthtml']='├'.str_repeat($lefthtml,$lvl);

	            $arr[]=$v;

	            $arr= array_merge($arr,$this->menu_left($menu,$id_field,$pid_field,$lefthtml,$v[$id_field], $lvl+1 ,$leftpin+20));

	        }

	    }

	    return $arr;

	}

	public function basic_set()

	{

		if (Request::instance()->isPost()) {


			$options['site_name'] = input('site_name');

			$options['site_icp'] = input('site_icp');

			$options['site_tongji'] = input('site_tongji');

			$options['site_copyright'] = input('site_copyright');

			$options['site_host'] = input('site_host');

			$options['status'] = input('status');
            $options['num'] = input('num');
            
            

			//更新

			$lang='zh-cn';

            $type = 'site_optionss';


            $sql = Db::name('options')->where(['option_l'=>$lang,'option_name'=>$type])->setField('option_value',json_encode($options));



			$path = input('path');

			$old_path = input('old_path');//旧轮播图

			if(!empty($path)){

				// 这个删除文件的目录是上传的那个目录

				$url = ROOT_PATH . $old_path;

				if (file_exists($url)) {

					unlink($url);

				}

				$data['img'] = '/public' . DS . 'static'. DS . 'admin'. DS . 'banner'. DS . $path;

			}else{

				$data['img'] = $old_path;

			}

			$data['hrefs'] = input('hrefs');

			$sql1 = Db::name('logo')->where('id',1)->update($data);

			if ($sql || $sql1) {

				$this->redirect('sys/basic_set');

			}else{

				$this->redirect('sys/basic_set');

			}

		}else{

			$sql = Db::name('options')->where(['option_name'=>'site_optionss'])->find();

			$arr = $this->object_array(json_decode($sql['option_value']));

			$this->assign('sys',$arr);

			$info = Db::name('logo')->find();

			$this->assign('info',$info);

			return view();

		}

	}
	public function seo()

	{

		if (Request::instance()->isPost()) {

			$options['site_seo_title'] = input('site_seo_title');

			$options['site_seo_keywords'] = input('site_seo_keywords');

			$options['site_seo_description'] = input('site_seo_description');

			//更新

			$lang='zh-cn';

            $type = 'seo_options';

            $sql = Db::name('options')->where(['option_l'=>$lang,'option_name'=>$type])->setField('option_value',json_encode($options));

            if ($sql) {

				$this->redirect('sys/seo');

			}else{

				$this->redirect('sys/seo');

			}

		}else{

			$sql = Db::name('options')->where(['option_name'=>'seo_options'])->find();

			$arr = $this->object_array(json_decode($sql['option_value']));

			$this->assign('sys',$arr);

			return view();

		}

	}



    function object_array($array)

    {

        if (is_object($array)) {

            $array = (array)$array;

        }

        if (is_array($array)) {

            foreach ($array as $key => $value) {

                $array[$key] = $this->object_array($value);

            }

        }

        return $array;

    }



	/**

	 * 支付设置

	 */

	public function paysys()

	{

		$payment=sys_config_get('payment');

		$this->assign('payment',$payment);

		return $this->fetch();



	}

	/**

	 * 支付设置保存

	 */

	public function runpaysys()

	{

		if (!request()->isPost()){

			$this->error('提交方式不正确',url('admin/Sys/paysys'));

		}else{

		    $config = input('config/a');

			$rst=sys_config_setbyarr(['payment'=>$config]);

			if($rst!==false){

				Cache::clear();

				$this->success('设置保存成功',url('admin/Sys/paysys'));

			}else{

				$this->error('设置保存失败',url('admin/Sys/paysys'));

			}

		}

	}

	/**

	 * 微信公众号

	 */

	public function wesys()

	{

		$payment=sys_config_get('we_options');

		$this->assign('sys',$payment);

		return $this->fetch();



	}

	/**

	 * 微信公众号保存

	 */

	public function runwesys()

	{

		if (!request()->isPost()){

			$this->error('提交方式不正确',url('admin/Sys/wesys'));

		}else{

		    $config = input('we_options/a');

			$rst=sys_config_setbyarr(['we_options'=>$config]);

			if($rst!==false){

				Cache::clear();

				$this->success('设置保存成功',url('admin/Sys/wesys'));

			}else{

				$this->error('设置保存失败',url('admin/Sys/wesys'));

			}

		}

	}

	public function plug_link_list(){

		if (Request::instance()->isAjax()) {

			$p = trim(input('page')) ? trim(input('page')) : 1 ;

			$limit = trim(input('limit')) ? trim(input('limit')) : 10 ;

			$start=($p-1)*$limit;

			

			$arr=Db::name('plug_link')->limit($start,$limit)->select();

			$count=Db::name('plug_link')->count();

			$data['code'] = '0';

			$data['msg'] = '';

			$data['data'] = $arr;

			$data['count']=$count;

			$data=json_encode($data);

			echo $data;

		}else{

			return $this->fetch();

		}

	}

	public function plug_link_add(){

		if (request()->isPost()) {

			if (empty(input('post.logo'))) {

				$img = 1;

			}else{

				$img = '/public' . DS . 'static'. DS . 'admin'. DS . 'plug_link'. DS . input('post.logo');

			}

			$sl_data=array(

				'plug_link_name'=>input('plug_link_name'),

				'plug_link_l'=>input('plug_link_l','zh-cn'),

				'plug_link_url'=>input('plug_link_url'),

				'plug_link_target'=>input('plug_link_target','_blank'),

				'plug_link_typeid'=>input('plug_link_typeid','0'),

				'plug_link_qq'=>input('plug_link_qq',0),

				'plug_link_order'=>input('plug_link_order'),

				'plug_link_addtime'=>time(),

				'plug_link_open'=>input('plug_link_open'),

				'plug_link_pic'=>$img,

			);

			$rst=Db::name('plug_link')->insert($sl_data);

			if($rst!==false){

				$this->redirect('sys/plug_link_list');

			}else{

				$this->error('友情链接添加失败',url('admin/sys/plug_link_add'));

			}

		}else{

			return view();

		}

	}

	public function plug_link_edit(){

		if (Request::instance()->isPost()) {

			$path = input('post.logo');

			$old_path = input('old_path');//旧轮播图

			if(!empty($path)){

				// 这个删除文件的目录是上传的那个目录

				if ($old_path != 1) {

					$url = ROOT_PATH . $old_path;

					if (!empty($old_path)) {

						if (file_exists($url)) {

							unlink($url);

						}

					}

				}

					

				$img = '/public' . DS . 'static'. DS . 'admin'. DS . 'plug_link'. DS . $path;

			}else{

				$img = $old_path;

			}

			$sl_data=array(

				'plug_link_id'=>input('plug_link_id'),

				'plug_link_name'=>input('plug_link_name'),

				'plug_link_l'=>input('plug_link_l','zh-cn'),

				'plug_link_url'=>input('plug_link_url'),

				'plug_link_target'=>input('plug_link_target','_blank'),

				'plug_link_typeid'=>input('plug_link_typeid','0'),

				'plug_link_qq'=>input('plug_link_qq',0),

				'plug_link_order'=>input('plug_link_order'),

				'plug_link_addtime'=>time(),

				'plug_link_open'=>input('plug_link_open'),

				'plug_link_pic'=>$img,

			);

			Db::name('plug_link')->update($sl_data);

			$this->success('友情链接修改成功',url('sys/plug_link_list'));

		}else{

			$id=Request::instance()->param('id');

			$data=Db::name('plug_link')->where('plug_link_id',$id)->find();

			$this->assign('data',$data);

			return $this->fetch();

		}

	}

	/*

     * 友情链接删除

	 * @author rainfer <81818832@qq.com>

     */

	public function plug_link_del()

	{

		if (Request::instance()->isAjax()) {

			$id=input('post.id');

			if (Db::name('plug_link')->where('plug_link_id',$id)->delete()) {

				echo 1;//删除成功

			}else{

				echo 0;

			}



		}else{

			echo -1;//非法提交

		}

	}

	// 是否审核通过

	public function ajax_plug_link()

	{

		if (request()->isPost()){

			Db::name('plug_link')->where('plug_link_id',input('post.id'))->update(['plug_link_open' => input('post.type')]);

			// echo Db::name('bookrack')->getlastsql();

		}

	}

	//友情链接图片

	function plug_link_upload(){

	    $file = request()->file('file');

	    // 移动到框架应用根目录/public/uploads/ 目录下

	    if($file){

	        $info = $file->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'admin'. DS . 'plug_link');

	        if($info){

	            // 成功上传后 获取上传信息

	            $data['code'] = 0;

	            $data['msg']= '';

	            $data['data'] = [

	                'src' => $info->getSaveName(),

	                'preview' =>'static'. DS . 'admin'. DS . 'plug_link'. DS .$info->getSaveName(),

	            ];

	            echo json_encode($data);

	        }else{

	            // 上传失败获取错误信息

	            echo $file->getError();

	        }

	    }

	}

	public function link()

	{

		if (request()->isAjax()) {

			$list = DB::name('domain')->select();

			$data['code'] = '0';

			$data['msg'] = '';

			$data['data'] = $list;

			$data['count']=count($list);

			$data=json_encode($data);

			echo $data;

		}else{

			return view();

		}

	}

	public function link_add()

	{

		if (request()->isPost()) {

			$sql = Db::name('domain')->insert(['link_title'=>input('post.name'),'status'=>input('post.status')]);

			if ($sql) {

				$this->redirect('sys/link');

			}else{

				$this->redirect('sys/link_add');

			}

		}else{

			return view();

		}

	}

	// 单元格编辑

	public function ajax_edit()

	{

		if (request()->isPost()){

			$id = input('post.id');

			$ziduan = input('post.field');

			$val = input('post.value');

			if ($id) {

					$sql = Db::name('domain')->where('id',$id)->update([$ziduan => $val]);

				if ($sql) {

					$data['status'] = '1';

					$data['tips'] = '修改成功';

					echo json_encode($data);

				}

			}

		}

	}

	// 删除轮播图

	function ajax_del()

	{

		Db::name('domain')->where('id',input('post.id'))->delete();

	}

	// 修改为超级管理员或者是普通管理员

	public function is_manager()

	{

		if (request()->isPost()){

			Db::name('domain')->where('id',input('post.id'))->update(['status' => input('post.type')]);

			$code = 1;

		}else{

			$code = 2;

		}

		return json_encode($code);

	}
 
	public function admin_log()
	{

      if(request()->isAjax()){
        $p = trim(input('page')) ? trim(input('page')) : 1 ;
		$limit = trim(input('limit')) ? trim(input('limit')) : 10 ;
		$start=($p-1)*$limit;
		$list=Db::name('admin_login_log')->field('*')->limit($start,$limit)->order('createtime desc')->select();
        foreach($list as $k=>$v){
          $list[$k]['createtime']=date('Y-m-d H:i:s',$v['createtime']);
        }
		$data['code'] = '0';
		$data['msg'] = '';
		$data['data'] = $list;
		$data['count']= Db::name('admin_login_log')->field('*')->count();
		$data=json_encode($data);
		echo $data;
      }else{
       
		return $this->fetch();
      }
		
	}
  	public function operate_log()
	{
      if(request()->isAjax()){
        $p = trim(input('page')) ? trim(input('page')) : 1 ;
		$limit = trim(input('limit')) ? trim(input('limit')) : 10 ;
		$start=($p-1)*$limit;
		$list=Db::name('operate_log')->field('*')->limit($start,$limit)->order('createtime desc')->select();
         foreach($list as $k=>$v){
          $list[$k]['createtime']=date('Y-m-d H:i:s',$v['createtime']);
        }
		$data['code'] = '0';
		$data['msg'] = '';
		$data['data'] = $list;
		$data['count']= Db::name('operate_log')->field('*')->count();
		$data=json_encode($data);
		echo $data;
      }else{
       
		return $this->fetch();
      }
		
	}

}