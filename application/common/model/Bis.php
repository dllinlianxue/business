<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/9
 * Time: 下午7:59
 */
namespace app\common\model;

use think\Model;

class Bis extends Model{
    /**
     *添加门店信息的方法,返回新的id
     */
    public function add($data = []){
        $data['status'] = 1 ;
        $this->save($data);
        return $this->id;
    }

    public function getBisByStatus($status){
        $data = [
          'status' => $status
        ];
        $order = [
          'listorder' => 'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->paginate(5);
    }
}