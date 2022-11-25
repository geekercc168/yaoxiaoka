<?php

namespace app\admin\controller;

use app\admin\model\MenuModel;
use think\Request;

class Main extends Home
{
    public function index()
    {
        $menu = new MenuModel();

      	//halt($menu->menu());
        $this->assign('list', $menu->menu());
        if(is_mobile()){
           // dy($menu->menu());
            return view('m_index');
        }else{
            return view();
        }

    }

    public function console()
    {
         if(!Request::instance()->isAjax()){

         }
        $this->redirect('admin/Member/member_list');
         echo '引导页面，带完善';die;
        return view();
    }

    /*public function ajax_console()
    {
        $str = '';
        $wher = array();
        if (!empty(input('value'))) {
            $str = input('value');
            $where_strat = strtotime(substr($str, 0, strpos($str, '~')));
            $where_end = strtotime(substr($str, strpos($str, '~') + 1)) + 86399;
            $wher['create_time'] = array('between', array($where_strat, $where_end));
        }

        $p = trim(input('page')) ? trim(input('page')) : 1;
        $limit = trim(input('limit')) ? trim(input('limit')) : 10;
        $start = ($p - 1) * $limit;
        $list = Db::name('payment')->field('FROM_UNIXTIME(create_time, \'%Y-%m-%d\') as datetime,create_time')->where($wher)->group('datetime')->order('create_time desc')->limit($start,$limit)->select();
        $list_count = Db::name('payment')->field('FROM_UNIXTIME(create_time, \'%Y-%m-%d\') as datetime')->where($wher)->group('datetime')->count();
        foreach ($list as $k => $v) {
            unset($list[$k]['create_time']);
            $start = strtotime($list[$k]['datetime']);
            $end = strtotime($list[$k]['datetime']) + 86399;
            $map['create_time'] = array('between', array($start, $end));
            $list[$k]['sum_money'] = Db::name('payment')->where(['status' => 1])->where($map)->sum('money');
            $list[$k]['coin_count'] = Db::name('payment')->where(['status' => 1, 'type' => 1])->where($map)->sum('money');
            $list[$k]['member_coin_count'] = Db::name('payment')->where(['status' => 1, 'type' => 1])->where($map)->group('uid')->count();
            if ($list[$k]['coin_count'] == 0 && $list[$k]['member_coin_count'] == 0) {
                $list[$k]['probablity_coin'] = 0;
            } else {
                $list[$k]['probablity_coin'] = round($list[$k]['coin_count'] / $list[$k]['member_coin_count'], 2);
            }
            $list[$k]['count_coin_order'] = Db::name('payment')->where(['type' => 1])->where($map)->count();
            $list[$k]['count_coin_error_order'] = Db::name('payment')->where(['status' => 0, 'type' => 1])->where($map)->count();
            if ($list[$k]['count_coin_order'] == $list[$k]['count_coin_error_order']) {
                $list[$k]['count_coin_error_probablity'] = 0;
            } elseif ($list[$k]['count_coin_error_order'] == 0) {
                $list[$k]['count_coin_error_probablity'] = 100;
            } else {
                $list[$k]['count_coin_error_probablity'] = 100 - (round($list[$k]['count_coin_error_order'] / $list[$k]['count_coin_order'], 2) * 100);
            }
            //vip

            $list[$k]['vip_count'] = Db::name('payment')->where(['status' => 1, 'type' => 2])->where($map)->sum('money');
            $list[$k]['member_vip_count'] = Db::name('payment')->where(['status' => 1, 'type' => 2])->where($map)->group('uid')->count();
            if ($list[$k]['vip_count'] == 0 && $list[$k]['member_vip_count'] == 0) {
                $list[$k]['probablity_vip'] = 0;
            } else {
                $list[$k]['probablity_vip'] = round($list[$k]['vip_count'] / $list[$k]['member_vip_count'], 2);
            }
            $list[$k]['count_vip_order'] = Db::name('payment')->where(['type' => 2])->where($map)->count();
            $list[$k]['count_vip_error_order'] = Db::name('payment')->where(['status' => 0, 'type' => 2])->where($map)->count();
            if ($list[$k]['count_vip_order'] == $list[$k]['count_vip_error_order']) {
                $list[$k]['count_vip_error_probablity'] = 0;
            } elseif ($list[$k]['count_vip_error_order'] == 0) {
                $list[$k]['count_vip_error_probablity'] = 100;
            } else {
                $list[$k]['count_vip_error_probablity'] = 100 - (round($list[$k]['count_vip_error_order'] / $list[$k]['count_vip_order'], 2) * 100);
            }
        }
        $datas['code'] = '0';
        $datas['msg'] = '';
        $datas['data'] = $list;
        $datas['count'] = $list_count;
        $datas = json_encode($datas);
        echo $datas;
    }*/
}
