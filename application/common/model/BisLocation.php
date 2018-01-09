<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/9
 * Time: 下午8:20
 */
namespace app\common\model;

use think\Model;

class BisLocation extends Model{
    /**
     *  $bis_id 根据获取当前管理员所拥有的店铺
     * @param
     */
    public function getLocationsByBisID($bis_id){
        $data = [
            'bis_id' => $bis_id
        ];
        $order = [
          'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where($data)->order($order)->select();
//        print_r($this->getLastSql());exit();查询SQL原生语句
        return $result;

    }
}