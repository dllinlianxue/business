<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/13
 * Time: 上午10:09
 */
namespace app\bis\controller;

class Deal extends Base{
    public $obj;
    protected function _initialize()
    {
        parent::_initialize();
        $this->obj=model('Deal');
    }

    public function index(){


        $deals = $this->obj->getDeals();

        return $this->fetch('',[
            'deals'=>$deals

        ]);
    }

    /**
     *添加团购商品
     */
    public function add(){
        if (request()->isPost()){
            $data = input('post.');
//            print_r($data);exit();
            //数据校验
            $this->checkData('Deal','add',$data);

            //构造数据
            $cat_string = '';
            if (!empty($data['se_categories'])){
                $cat_string = ','.implode('|',$data['se_categories']);
            }

            //组合location_ids(支持门店)
            $location_string = '';
            if (!empty($data['location_ids'])){
                $location_string = implode(',',$data['location_ids']);
            }
            $dealData = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'].$cat_string,
                'bis_id' => $this->account->bis_id,
                'location_ids' => $location_string,
                'image' => $data['image'],
                'description' => $data['description'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'city_id' => $data['city_id'],
                'total_count' => $data['total_count'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'bis_account_id' => $this->account->id,
                'notes' => $data['notes'],
                'city_path' => $data['city_id'].','.$data['se_city_id'],
                'se_category_id' => empty($cat_string) ? '' : substr($cat_string,1),
                'se_city_id' => $data['se_city_id']
            ];

            //--------------------------//
            //判断是更新操作(来自detail页面的修改按钮)
            if (isset($data['id'])){

                $res = model('Deal')->save($dealData,['id'=>$data['id']]);

                if (!$res){
                    $this->error('更新失败');
                }
                else {
                    $this->success('更新成功');
                }
            }
            //------------------------------//

            //入库操作
            $res = $this->obj->save($dealData);
            if (!$res){
                $this->error('添加失败');
            }
            else {
                $this->success('添加成功');
            }
        }
        //获取一级城市(省provinces份信息)
        $provinces = model('City')->getCitiesByParentID();

        $categories = model('Category')->getCategoriesByParentID();

        //获取当前登录商户的所有门店
        $shops = model('BisLocation')->getLocationsByBisID($this->account->bis_id);
        return $this->fetch('',[
            'provinces'=>$provinces,
            'categories'=>$categories,
            'shops' => $shops
        ]);
    }

    public function detail(){
        $id = input('id',0,'intval');
        //查询id对应的deal数据
        $deal = $this->obj->get($id);
        //获取一级城市(省provinces份信息)
        $provinces = model('City')->getCitiesByParentID();

        //获取二级城市
        $cities = model('City')->getCitiesByParentID(intval($deal['city_id']));
        //获取二级城市se_city_id
        $se_city_id = explode(',',$deal['city_path'])[1];//explode把字符串拆成数组

        $categories = model('Category')->getCategoriesByParentID();

        //获取当前登录商户的所有门店
        $shops = model('BisLocation')->getLocationsByBisID($this->account->bis_id);

        //获取location_ids数组进行拆分

        $locationArray = [];

        if ($deal['location_ids']){
            $locationArray = explode(',',$deal['location_ids']);

        }

        return $this->fetch('',[
            'deal' => $deal,
            'provinces'=>$provinces,
            'categories'=>$categories,
            'shops' => $shops,
            'cities' => $cities,
            'se_city_id' => $se_city_id,
            'locationArray' => $locationArray
        ]);
    }
}