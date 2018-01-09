<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/14
 * Time: 上午11:13
 */
namespace app\admin\controller;

class Bis extends Base{
    private $obj;
    protected function _initialize()
    {
        parent::_initialize();
        $this->obj = model('Bis');
    }

    /**
     * 正常状态的商户列表
     */
    public function index(){
        $bis = $this->obj->getBisByStatus(1);

        return $this->fetch('',[
            'bis' => $bis
        ]);
    }

    /**
     *待审核的商户列表
     */
    public function apply(){
        $bis = $this->obj->getBisByStatus(0);
        return $this->fetch('',[
           'bis' => $bis
        ]);
    }

    /**
     *已删除的商户列表
     */
    public function dellist(){
        $bis = $this->obj->getBisByStatus(-1);
        return $this->fetch('',[
            'bis' => $bis
        ]);
    }

    /**
     *删除详情
     */
    public function detail(){
        $id = input('id',0,'intval');

        //从bis表获取基本信息
        $bisData = $this->obj->get($id);
        $locationData = model('BisLocation')->get(['bis_id'=>$id]);
//        print_r($locationData);

        $username = model('BisAccount')->where(['bis_id'=>$id])->value('username');

        //获取一级城市
        $provinces = model('City')->getCitiesByParentID();

        //获取一级分类
        $categories = model('Category')->getCategoriesByParentID();

        //根据city_path获取二级城市id和二级城市信息
        $cities = model('City')->getCitiesByParentID(intval($bisData['city_id']));
        //获取二级城市se_city_id
        $se_city_id = explode(',',$bisData['city_path'])[1];//explode把字符串拆成数组

        return $this->fetch('',[
            'bisData' => $bisData,
            'locationData' => $locationData,
            'provinces' => $provinces,
            'categories' => $categories,
            'cities' => $cities,
            'se_city_id' => $se_city_id,
            'username' => $username
        ]);
    }


}