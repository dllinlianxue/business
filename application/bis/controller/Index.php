<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/7
 * Time: 下午3:40
 */
namespace app\bis\controller;

use think\Controller;
use think\Session;

class Index extends Base {

    public function index(){
//print_r(Session::get('bis_user','o2o'));

        return $this->fetch('',[
            'user'=>$this->account
        ]);
    }
}