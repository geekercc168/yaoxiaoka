<?php
namespace app\pc\controller;
use think\Controller;;
use think\Db;
use think\Request;
class About extends Controller {
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('is_mobile', is_mobile()?1:0);
    }
    public function index(){
        return view();
    }

    public function service(){
        return view();
    }
    public function protocol(){
        return view();
    }
    public function ze(){
        return view();
    }
    public function privacy(){
        return view();
    }
    public function me(){
        return view();
    }

}