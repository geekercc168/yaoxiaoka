<?php

namespace app\api\controller;

use think\Controller;
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
class Home extends Controller
{
    public function _initialize()
    {
//        parent::_initialize();//避免跨域请求异常
        // header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Credentials: true');
        // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
    }


}