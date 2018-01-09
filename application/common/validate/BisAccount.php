<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/7
 * Time: 上午10:36
 */
namespace app\common\validate;

use think\Validate;

class BisAccount extends Validate{
    //规则
    protected $rule = [
        'username'=>'require',
        'password'=>'require'
        ];
    //信息
    protected $message = [
       'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空',

    ];
    //场景
    protected $scene = [
        'login' => ['username','password'],
        'add' => ['username','password']
    ];
}