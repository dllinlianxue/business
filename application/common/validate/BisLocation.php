<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/9
 * Time: 下午5:43
 */
namespace app\common\validate;

use think\Validate;

class BisLocation extends Validate{
    //规则
    protected $rule = [
        'name' =>'require',
        'logo' => 'require',
        'address' => 'require',
        'tel' => 'require',
        'contact'=> 'require',
        'open_time' => 'require',
        'content'=>'require',
        'city_id' => 'require',
        'category_id' => 'require',
    ];
    //信息
    protected $message = [
        'name.require' =>'店铺名称不能为空',
        'logo.require' => '请上传店铺缩略图',
        'address.require' => '地址不能为空',
        'tel.require' => '电话不能为空',
        'contact.require'=> '联系人姓名不能为空',
        'open_time.require' => '营业时间不能为空',
        'content.require'=>'简介不能为空',
        'city_id.require' => '请选择城市信息',
        'category_id.require' => '请选择分类',

    ];
    //场景
    protected $scene = [
        'add'=>['name','logo','address','tel','contact','open_time','content','city_id','category_id']
    ];
}