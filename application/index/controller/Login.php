<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/15
 * Time: 下午5:43
 */
namespace app\index\controller;

use think\Controller;
use think\Session;

class Login extends Controller {

    public function index(){
        if (Session::get('user','','o2o')){
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    public function check(){
        if (request()->isPost()){
            $data = input('post.');

            //数据校验
            $validate = validate('BisAccount');
            $res = $validate->scene('login')->check($data);
            //判断res准确性
            if (!$res){
                $this->error($validate->getError());
            }

            //查询数据库里的用户名
            $user = model('User')->get(['username' => $data['username']]);
            if (!$user){
                $this->error('用户名不存在');
            }


            if ($user->password != md5($data['password'].$user->code)){
                $this->error('密码错误');
            }

            //登录之前存入session
            session('user',$user,'o2o');
            $this->redirect('index/index');
        }
    }
    /**
     *退出登陆
     */
    public function logout(){
        Session::delete('user','o2o');
        //跳转界面
        $this->redirect('login/index');
    }


}