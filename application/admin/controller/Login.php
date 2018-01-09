<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/14
 * Time: 上午9:49
 */
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Login extends Controller {
    public function index(){
        if (session('admin_user','','o2o')){
            $this->redirect('login/index');
        }
        return $this->fetch();
    }

    /**
     *判断管理员登录的方法
     */
    public function check(){
        if (request()->isPost()){

//            $username = input('username',0,'intval');
//            $password = input('password',0,'intval');

            $data = input('post.');

            //数据校验
            $validate = validate('BisAccount');
            $res = $validate->scene('login')->check($data);

            if (!$res){
                $this->error($validate->getError());
            }

            //查询用户信息(根据用户名)
            $user = model('Admin')->get(['username'=>$data['username']]);
            if (!$user){
                $this->error('用户名不存在');
            }

            //判断密码
            if ($user->password != md5($data['password'])){
                $this->error('密码错误');
            }
            //登录成功之前存session
            session('admin_user',$user,'o2o');
            $this->redirect('index/index');

        }
    }

    /**
     *退出登录
     */
    public function logout(){
        Session::delete('admin_user','o2o');
        $this->redirect('login/index');
    }
}