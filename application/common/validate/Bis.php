<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/9
 * Time: 下午5:43
 */
namespace app\common\validate;

use think\Validate;

class Bis extends Validate{
    //规则
    protected $rule = [
        'name' =>'require',
        'email' =>'email',
        'logo' => 'require',
        'licence_logo' =>'require',
        'description' => 'require',
        'city_id' => 'require',
        'bank_info' => 'require',
        'bank_name' => 'require',
        'bank_user' => 'require',
        'faren'=> 'require',
        'faren_tel' => 'require'
    ];
    //信息
    protected $message = [
        'name.require' =>'商店名称不能为空',
        'email.email' =>'请输入邮箱',
        'logo.require' => '请上传图片',
        'licence_logo.require' =>'请上传营业执照',
        'description.require'=>'请填写描述',
        'city_id.require'=>'请选择城市信息',
        'bank_info.require'=>'请输入银行卡号',
        'bank_name.require'=>'请输入开户行名称',
        'bank_user.require'=>'请输入开户人姓名',
        'faren.require'=>'请输入法人姓名',
        'faren_tel.require'=>'请输入法人电话号码'

    ];
    //场景
    protected $scene = [
        'add'=>['name','email','logo','licence_logo','description','city_id','bank_info','bank_name','bank_user','faren','faren_tel']
    ];
}