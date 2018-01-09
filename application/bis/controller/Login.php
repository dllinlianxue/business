<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/7
 * Time: 下午3:46
 */
namespace app\bis\controller;

use think\Controller;
use think\Session;

class Login extends Controller{
    public function index(){
        if (Session::get('bis_user','o2o')){
            //如果已经登陆了,就直接跳转到后台页面
            $this->redirect('index/index');
        }
        //否则显示登录页面
       return $this->fetch();
    }

    public function check(){
        if (request()->isPost()){
            $data = input('post.');
            //数据校验
            $validate = validate('BisAccount');
            $res = $validate->scene('login')->check($data);
            if (!$res){
                $this->error($validate->getError());
            }
            //根据username查找信息
            $user = model('BisAccount')->get(['username'=>$data['username']]);
            if (!$user){
                $this->error('该用户名不存在');
            }
            //匹配密码
            if ($user->password != md5($data['password'].$user->code)){
                $this->error('密码不正确');
            }
            //登陆成功 1:存储session(服务端存,有时效性)  2:界面跳转
            session('bis_user',$user,'o2o');
            $this->redirect('index/index');

        }
    }

    /**
     *退出登陆
     */
    public function logout(){
        //清空session
//        session('bis_user',null,'o2o');

        Session::delete('bis_user','o2o');
        //跳转界面
        $this->redirect('login/index');
    }
}