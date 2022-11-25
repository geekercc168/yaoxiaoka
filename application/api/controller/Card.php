<?php

namespace app\api\controller;

use think\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

class Card extends Home{

	// 卡类查询
	public function card_type_query()
	{
		$tid = input('cartId/d',0);
		$uid = input('customerId/d');
		$api_key = input('apiKey','','strip_tags');

		$res = model('Card')->cardTypeQuery($tid,$uid,$api_key);
		
		return json($res);
	}

	// 汇率查询
	public function card_rate_query()
	{
		$uid = input('customerId/d');
		$api_key = input('apiKey','','strip_tags');

		$res = model('Card')->cardRateQuery($uid,$api_key);
		
		return json($res);
	}

	// 创建订单
	public function card_order_create()
	{
		
		if(Request()->isPost()){
 
			$params = Request()->post();

			$way = $params['way'];

			if(in_array($way, ['single','batch'])){

				switch ($way) {
					
					case 'single':
						$res = model('Card')->cardOrderCreateSingle($params);
						
						break;
					case 'batch':
					    
						$res = model('Card')->cardOrderCreateBatch($params);
						break;
					default:
						$res = ['code' => 404,'msg' => '没有该方法'];
						break;
				}
				
				return json($res);
			}
			$res = ['code' => 404,'msg' => '没有该方法'];
			return json($res);
		}else{
			$res = ['code' => 999,'msg' => '只支持post提交'];
			return json($res);
		}
	}

	// 回调订单处理
	public function card_notify()
	{
		
	}

	// 查询订单  
	public function card_order_query()
	{
		$uid = input('customerId/d');
		$api_key = input('apiKey','','strip_tags');
		$start_time = input('startTime',date('Y-m-d 00:00:00'));
		$end_time = input('endTime',date('Y-m-d 23:59:59'));
		$page = input('page/d',1);

		$rows = model('Card')->cardOrderQuery($uid,$api_key,$start_time,$end_time,$page);
		
		$res = ['code' => 0,'msg' => 'success','data' => $rows];
		return json($res);
		
	}

}
