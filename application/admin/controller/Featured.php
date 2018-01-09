<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/15
 * Time: 上午9:54
 */
namespace app\admin\controller;

class Featured extends Base{
    private $obj;
    protected function _initialize()
    {
        parent::_initialize();
        $this->obj = model('Featured');
    }
    public function index(){
        $data = input('post.');

        $con_data = [];
        if (isset($data['type'])){
            $con_data['type'] = $data['type'];
        }
        if (empty($data)){
            $data['type'] = -1;
        }

        $featured = $this->obj->getAllFeaturedByCondition($con_data);
        //获取所有推荐位类型数组
        $types = config('type');
        return $this->fetch('',[
           'featured' => $featured,
            'types' => $types,
            'data' => $data
        ]);
    }

    /**
     *添加内容
     */
    public function add(){
        if (request()->isPost()){
            $data = input('post.');
            //数据校验
            $this->checkData('featured','add',$data);
            //入库操作
            $res = $this->obj->save($data);
            if (!$res){
                $this->error('添加推荐位失败');
            }
            else {
                $this->success('添加推荐位成功');
            }

        }
        $types = config('type');
        return $this->fetch('',[
            'types' => $types
        ]);


    }
}
