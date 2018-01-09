<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/13
 * Time: 上午10:12
 */
namespace app\common\model;

use think\Model;

class Deal extends Model{
    public function getDeals(){
        $data =[

        ];
        $order = [
            'listorder'=>'desc',
            'id'=>'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
    public function getDealByCondition($con_data = []){
        $order = [
          'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($con_data)->order($order)->select();
    }

    public function getDealsByCategoryIdLimitCity($category_id,$limit,$se_city_id){
        $data = [
            'status' => 1,
            'category_id' => $category_id,
            'se_city_id' => $se_city_id
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where($data)->order($order);
        if ($limit>0){
            $result = $result->limit($limit);
        }
        return $result->select();

    }

    /**
     *根据前端的排序条件查询数据
     */
    public function getDealsByCondition($data = [],$order_flag){
        //排序条件
        $order = [];
        if ($order_flag == 'order_sales'){
            $order['buy_count']='desc';
        }
        if ($order_flag == 'order_price'){
            $order['current_price']='desc';
        }
        if ($order_flag == 'order_time'){
            $order['create_time']='desc';
        }
        //默认的情况下,按id排序
        $order['id'] = 'desc';

        //查询条件
        $conData[] = 'status=1';
        $conData[] = 'se_city_id='.$data['se_city_id'];
        $conData[] = 'end_time>'.time();

//最终形成的格式:[' status=1',' se_city_id='.$data['se_city_id'],' end_time>'.time()]
        //判断分类id
        if (!empty($data['category_id'])){
            $conData[] = 'category_id='.$data['category_id'];
        }
        if (!empty($data['se_category_id'])){
            $conData[] = 'find_in_set('.$data['se_category_id'].',se_category_id)';
        }
        //MySQL中find_in_set(str,strlist)函数使用方法
        //查询
        $result = $this->where(implode(' AND ',$conData))->order($order)->paginate(3);
//        print_r($result);
        return $result;
    }
}