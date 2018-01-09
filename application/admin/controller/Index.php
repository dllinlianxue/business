<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Base {
    public function index(){

        return $this->fetch();

    }

    public function welcome(){
//        $res =  \Map::getLngLat('大连市沙河口软件园路3号');
//        print_r($res);
//        $src = \Map::getStaticImage('大连市沙河口软件园路3号');

        return $this->fetch();
    }
}