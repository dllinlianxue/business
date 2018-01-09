<?php
namespace app\index\controller;

use Prophecy\Call\CallCenter;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        //获取轮播图信息
        $midImages = model('Featured')->getAllFeaturedByCondition(['status'=>1,'type'=>0]);
        $rightImages = model('Featured')->getAllFeaturedByCondition(['status'=>1,'type'=>1]);

//        print_r($midImages);exit();

//    phpinfo();//查看你当前使用的版本

        //主体内容区域数据的查询 Deal表 根据分类id+个数+当前城市
        $deals = model('Deal')->getDealsByCategoryIdLimitCity(1,10,$this->city->id);

//        print_r($deals);

        //获取美食栏目的子栏目
        $se_cats = model('Category')->getCategoriesByParentIdAndLimit(1,4);

        return $this->fetch('',[
            'midImages' => $midImages,
            'rightImages' => $rightImages,
            'deals' => $deals,
            'se_cats' => $se_cats
        ]);

    }


}
