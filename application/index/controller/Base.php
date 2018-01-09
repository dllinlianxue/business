<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/15
 * Time: 下午2:59
 */
namespace app\index\controller;

use think\Controller;
use think\Session;

class Base extends Controller{
    public $account;
    public $city;//当前城市的全局变量

    protected function _initialize()
    {
        //获取城市信息发送给导航部分
        $hotCities = model('City')->getCitiesByParentID(['neq',0]);
//        print_r($hotCities);exit();
        //获取当前城市
        $this->getCurrentCity();
        $this->assign('hotCities',$hotCities);

        $this->account = session('user','','o2o');
        $this->assign('user',$this->account);

        $this->assign('city',$this->city);

        $this->assign('recArray',$this->getHotCategories());

        $this->assign('title','o2o团购网');

        //获取当前控制器的名字
        $this->assign('controller',strtolower(request()->controller()));
        //strtolower()把首字母转化成小写



    }

    /**
     *获取当前点击的城市
     */
    public function getCurrentCity(){
        //获取默认城市
        $defaultCity = model('City')->get(['is_default'=>1]);

//        print_r($defaultCity);exit();

        //判断前端界面是否点击了某个城市
        if (input('city_uname')){
            $uname = input('city_uname',$defaultCity->uname,'trim');

            $current_city = model('City')->get(['uname'=>$uname]);

            session('curr_city',$current_city,'o2o');
        }
        else
        {
            if (Session::get('curr_city','o2o'))
            {
                $current_city = Session::get('curr_city','o2o');
            }
            else
            {
                $current_city = $defaultCity;
                session('curr_city',$current_city,'o2o');
            }

        }

        $this->city = $current_city;

//        print_r($current_city);exit();
        return $current_city;
    }

    /**
     *获取五个排序靠前的一级分类及其子分类
     */
    public function getHotCategories(){
        $parentIDs = [];
        //存放一级分类id
        $seArray = [];
        //存放整理完毕的二级子分类
        $recommendArray = [];
        //存放最终的数组

        //获取parent_id=0排序靠前的前五个一级分类
        $categories = model('Category')->getCategoriesByParentIdAndLimit(0,5);
//        print_r($categories);exit();

        //循环获取所有一级分类的id
        foreach ($categories as $cat){
            $parentIDs[] = $cat->id;
        }
        //获取parentIDs对应的所有子分类
        $seCategories  = model('Category')->getSeCategoriesByParentIDs($parentIDs);

//        print_r($seCategories);exit();

        foreach ($seCategories as $se_cats){
            $seArray[$se_cats->parent_id][]=[
                'id'=> $se_cats->id,
                'name'=> $se_cats->name
            ];

//           [
//             '1' => ['6','麻辣烫'],
//             '1' => ['id','name'],
//             '1' => ['id','name'],
//             '1' => ['id','name'],
//             '2' => ['26','奔跑的兄弟'],
//
//           ];

        }
        //构造最终前端需要的数组
        foreach ($categories as $cat){
           $recommendArray[$cat->id] = [$cat->name,empty($seArray[$cat->id])?[]:$seArray[$cat->id]];
        }
//        print_r($recommendArray[$cat->id]);exit();

        //        [
//            '1' => ['美食', [obj1, obj2, obj3] ],
//            '2' => ['旅游', [obj1, obj2, obj3] ],
//            '3' => ['阅读', [obj1, obj2, obj3] ],
//            '4' => ['娱乐', [obj1, obj2, obj3] ],
//            '5' => ['休闲', [obj1, obj2, obj3] ],
//        ]

        return $recommendArray;

    }
}