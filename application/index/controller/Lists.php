<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/17
 * Time: 下午3:45
 */
namespace app\index\controller;

class Lists extends Base{

//    protected function _initialize()
//    {
//        parent::_initialize();
//    }

    public function index(){
        //获取所有一级分类
        $categories = model('Category')->getCategoriesByParentIDForFront(0);
        //获取所有一级分类id
        $parent_ids = [];
        foreach ($categories as $cat){
            $parent_ids[] = $cat->id;
        }

        //存放排序查询条件的数组
        $data = [];

        $id = input('id',0,'intval');


        //id有三种情况
        //(1)点击'全部'过来的或直接访问本页面地址的, id=0
        //(2)点击一级分类过来的
        //(3)点击二级分类过来的
        $first_id = 0;//存放一级id

        if (in_array($id,$parent_ids)){
            //此时id是一级分类
            $first_id = $id;
        }
        else if ($id > 0){
            //此时id是二级分类
            $setCat = model('Category')->get($id);
            $first_id = $setCat->parent_id;
            $data['se_category_id'] = $id;
        }

        //根据合理的一级id查询其所有子类
        $se_categories = [
            ['id' =>0,'name'=>'请选择分类']
        ];
          if ($first_id > 0){
            $se_categories = model('Category')->getCategoriesByParentIDForFront($first_id);

          }



        $data['se_city_id'] = $this->city->id;
        $data['category_id'] = $first_id;


          //获取排序的参数(价格,销量,时间)
        $order_flag = '';
        if (input('order_sales')){
            $order_flag='order_sales';
        }
        if (input('order_price')){
            $order_flag='order_price';
        }
        if (input('order_time')){
            $order_flag='order_time';
        }

        $deals = model('Deal')->getDealsByCondition($data,$order_flag);

//        print_r($deals);
        return $this->fetch('',[
            'title' => $this->city->name.'团购',
            'categories' => $categories,
            'id' => $id,
            'first_id' => $first_id,
            'se_categories' => $se_categories,
            'flag' => $order_flag,
            'deals' => $deals
        ]);
    }
}