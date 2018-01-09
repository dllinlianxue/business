<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/6
 * Time: 下午4:51
 */
namespace app\common\model;

use think\Model;

class Category extends Model{

    /**
     * 根据parent_id获取分类信息
     * @param int $parent_id
     */
    public function getCategoriesByParentID($parent_id=0){
        //条件
        $data = [
//            'status' => 1,
            'parent_id' => $parent_id
        ];
        //排序
        $order = [
            'listorder'=> 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }


    /**
     * @param int $parent_id
     * 分页
     */
    public function getCategoriesByParentIDForPage($parent_id=0){
        //条件
        $data = [
//            'status' => 1,
            'parent_id' => $parent_id
        ];
        //排序
        $order = [
            'listorder'=> 'desc',
            'id' => 'desc'
        ];
        //paginate()是按照指定个数进行分页查找
        return $this->where($data)->order($order)->paginate(5);
    }

    /**
     * 根据指定数量获取数据
     * @param $parent_id
     * @param int $limit 想要获取的行数
     */
    public function getCategoriesByParentIdAndLimit($parent_id, $limit = 5){
        $data = [
            'status' => 1,
            'parent_id' => $parent_id
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where($data)->order($order);
        if ($limit > 0 ){
            $result= $result->limit($limit);
        }
        return $result->select();
    }

    /**
     * 根据存放一级分类id的数组获取所有二级分类
     * @param array $parent_ids
     */
    public function getSeCategoriesByParentIDs($parent_ids = []){
        $data = [
            'status' => 1,
            'parent_id' => ['in',implode(',',$parent_ids)]
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();

    }

    /**
     * 根据pid获取分类信息 (lists用)
     * @param int $parent_id
     *
     */
    public function getCategoriesByParentIDForFront($parent_id=0){
        //条件
        $data = [
//            'status' => 1,
            'parent_id' => $parent_id
        ];
        //排序
        $order = [
            'listorder'=> 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}