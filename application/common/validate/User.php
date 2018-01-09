<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/15
 * Time: 下午5:24
 */
namespace app\common\validate;

use think\Validate;

class User extends Validate{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'email' => 'email',
        'verifyCode' => 'require',
        'confirm' => 'require'
    ];
    protected $message = [
       'username.require' => '请填写名字',
        'password.require' => '请输入密码',
        'email.email' => '邮箱格式不正确',
        'verifyCode.require' => '请填写验证码',
        'confirm.require' => '请再次输入密码'
    ];
    protected $scene = [
      'add' => ['username','password','email','verifyCode','confirm']
    ];
}