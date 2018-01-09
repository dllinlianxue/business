<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/14
 * Time: 下午4:20
 */

namespace app\admin\controller;

class Deal extends Base
{
    private $obj;

    protected function _initialize()
    {
        parent::_initialize();
        $this->obj = model('Deal');
    }

    public function index()
    {
        $data = input('post.');
        if (empty($data)) {
            $data['category_id'] = 0;
            $data['city_id'] = 0;
            $data['start_time'] = '';
            $data['end_time'] = '';
            $data['name'] = '';
        }
        //存放条件的数组
        $con_data = [];
        if ($data['category_id']) {
            $con_data['category_id'] = $data['category_id'];
        }
        if ($data['city_id']) {
            $con_data['se_city_id'] = $data['city_id'];
        }
        //gt = greater than 大
        if ($data['start_time']) {
            $con_data['start_time'] = [
                'gt', strtotime($data['start_time'])
            ];
        }
        //lt = less than 大
        if ($data['end_time']) {
            $con_data['end_time'] = [
                'lt', strtotime($data['end_time'])
            ];
        }
        //保证开始时间不能大于结束时间
        if ($data['start_time'] && $data['end_time'] && strtotime($data['start_time']) > strtotime($data['end_time'])) {
            $con_data['start_time'] = [
                'gt', strtotime($data['end_time'])
            ];
            $con_data['end_time'] = [
                'lt', strtotime($data['start_time'])
            ];
        }

        if ($data['name']) {
            $con_data['name'] = [
                'like', '%' . $data['name'] . '%'
                //like模糊查询_一个,%所有
            ];
        }

//        print_r($con_data);

        //获取所有团购商品
        $deals = $this->obj->getDealByCondition($con_data);
        //获取所有分类
        $categories = model('Category')->getCategoriesByParentID();

        //获取所有二级城市分类
        $cities = model('City')->getCitiesByParentID(['neq', 0]);

        return $this->fetch('', [
            'deals' => $deals,
            'categories' => $categories,
            'cities' => $cities,
            'data' => $data //记录着查询的条件
        ]);
    }
}