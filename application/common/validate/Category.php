<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/7
 * Time: 上午10:36
 */
namespace app\common\validate;

use think\Validate;

class Category extends Validate{
    //require要求
    //规则
    protected $rule = [
        'name'=>'require|max:30',
        'parent_id'=>'require|number'
        ];
    //信息
    protected $message = [
       'name.require' => '分类名称不能为空',
        'name.max' => '名称长度不能超过30',
        'parent_id.require' => '请选择所属分类',
        'parent_id.number' => '分类类型有误'
    ];
    //场景
    protected $scene = [
        'add' => ['name','parent_id']
    ];
}