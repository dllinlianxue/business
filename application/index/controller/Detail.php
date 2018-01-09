<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/20
 * Time: 下午5:23
 */
namespace app\index\controller;


class Detail extends Base{

    public function index(){
        $id = input('id',0,'intval');
        if (!$id){
            $this->error('商品ID异常');
        }

        $deal = model('Deal')->get($id);
        //获取商户的名称
        $bis_name = model('BisAccount')->where(['bis_id'=>$deal->bis_id])->value('username');
        //获取分类的名称
        $catName = model('Category')->where(['id'=>$deal->category_id])->value('name');
        //获取location的address
        $locations = array();
        foreach (explode(',',$deal->location_ids) as $id){
            //把字符串切割成一块一块
            $locations[] = model('BisLocation')->get($id);//向数组后面加元素
        }

//        print_r($locations);exit();

        return $this->fetch('',[
            'title' => $this->city->name.'_团购_'.$deal->name,
            'deal' => $deal,
            'bis_name' => $bis_name,
            'catName' => $catName,
            'locations' => $locations
        ]);
    }
}