<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/10
 * Time: 上午9:36
 */
namespace app\bis\controller;

use think\Controller;

class Location extends Base {
    public function index(){
        //查询店铺数据
        $locations = model('BisLocation')->getLocationsByBisID($this->account->bis_id);


        return $this->fetch('',[
            'locations' => $locations
        ]);
    }



    /**
     *添加分店方法
     */
    public function add(){
        if (request()->isPost()){
            $data = input('post.');
//            print_r($data);exit();

            //数据校验
            $this->checkData('BisLocation','add',$data);


            //判断输入的地理信息是否精准(百度地图0是成功)
            $locationResult = \Map::getLngLat($data['address']);
            if ($locationResult['status'] != 0 || $locationResult['result']['precise'] != 1){
                $this->error('商户地址信息不准确');
            }


            //准备Category——path：
            $se_cats = $data['se_categories'];
            $cat_string = '';
            if (!empty($se_cats)){
                $cat_string = ','.implode('|',$se_cats);
                //数组转换成字符串
            }

            //准备bis_location表的数据
            $locationData = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'xpoint' => $locationResult['result']['location']['lng'],
                'ypoint' => $locationResult['result']['location']['lat'],
                'bis_id' => $this->account->bis_id,
                'open_time' => $data['open_time'],
                'content'=>$data['content'],
                'is_main' => 0,//分店
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'].','.$data['se_city_id'],
                'category_id'=> $data['category_id'],
                'category_path'=>$data['category_id'].$cat_string

            ];
            //--------------------------//
            //判断是更新操作(来自detail页面的修改按钮)
            if (isset($data['id'])){

                $res = model('BisLocation')->save($locationData,['id'=>$data['id']]);

                if (!$res){
                    $this->error('更新失败');
                }
                else {
                    $this->success('更新成功');
                }
            }
            //------------------------------//

            //入库操作
            $location_res = model('BisLocation')->save($locationData);
            if (!$location_res){
                $this->error('新增失败');
            }
            else {
                $this->success('新增成功');
            }

        }

        //获取一级城市(省provinces份信息)
        $provinces = model('City')->getCitiesByParentID();
        //获取所有一级分类
        $categories = model('Category')->getCategoriesByParentID();
        return $this->fetch('',[
            'provinces'=> $provinces,
            'categories' => $categories
        ]);
    }

    /**
     *获取一个店铺的详情
     */
    public function detail(){
        $id = input('id',0,'intval');
        $res = model('BisLocation')->get($id);
        //获取一级城市(省provinces份信息)
        $provinces = model('City')->getCitiesByParentID();
        //获取二级城市
        $cities = model('City')->getCitiesByParentID(intval($res['city_id']));
        //获取二级城市se_city_id
        $se_city_id = explode(',',$res['city_path'])[1];//explode把字符串拆成数组
        //获取所有一级分类
        $categories = model('Category')->getCategoriesByParentID();

        return $this->fetch('',[
            'location' => $res ,
            'provinces'=> $provinces,
            'categories' => $categories,
            'cities'=>$cities,
            'se_city_id'=>$se_city_id
        ]);
    }

}