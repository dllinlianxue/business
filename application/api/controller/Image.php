<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/9
 * Time: 上午9:57
 */
namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller{
    public function upload(){
        //实例化一个文件操作对象,Request::instance()请求实例
        $file = Request::instance()->file('file');
        //将接受到的文件存储到指定文件夹下
        $info = $file->move('upload');
        if ($info && $info->getPathname()){
            //getPathname 抽象方法
           return show(1,'上传成功','/'.$info->getPathname());
        }
        return show(0,'上传失败','');

    }
}