<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/6
 * Time: 下午3:32
 */
namespace app\admin\controller;

use think\Controller;

class Category extends Base {
    //在当前Controller里使用的操作数据库的对象
    private $obj;

    //初始化方法:全局访问
    protected function _initialize()
    {
        $this->obj = model('Category');
        //是把model文件里的Category.PHP文件赋予obj吗?
    }

    public function index(){
        //获取前端发送回来的参数
        $parent_id = input('parent_id',0,'intval');
        //input('post.');
        //input取出一个值,'post.'就是所有的
        //查询数据
        $res = $this->obj->getCategoriesByParentIDForPage($parent_id);
        return $this->fetch('',[
            'categories' => $res,
            'flag' =>$parent_id
        ]);
    }
    //修改状态
    public function status(){
        //接受从前端发送过来的status的值
        $status = input('status',0,'intval');
        $id = input('id',0,'intval');
        //修改数据库的值,参数一是修改的值,参数2是条件
        $res = $this->obj->save(['status'=>$status],['id'=>$id]);
        if (!$res){
            $this->error('状态修改失败');
        } else {
            $this->success('状态修改成功');
        }
    }

    /**
     *添加分类的界面
     */
    public function add(){
        //如果是post请求过来的就去执行添加操作
        if (request()->isPost())
        {
            $data = input('post.');
            //数据校验
            $validate = validate('Category');//实例化
            $res = $validate->scene('add')->check($data);
            //验证id和name是否为空
            //返回值是真和假
            if (!$res){
                $this->error($validate->getError());
            }
            //验证此分类是否在相应的parent下存在
            $res = $this->obj->get([
               'parent_id' => $data['parent_id'],
                'name' => $data['name']
            ]);
            if ($res){
                $this->error('该分类已经存在');
            }
            //入库操作 save既可以完成添加又可以更新
            $res = $this->obj->save($data);
            if (!$res){
                $this->error('添加分类失败');
            }
            else {
                $this->success('添加分类成功');
            }
        }

        //把所有一级分类查询出来,显示到select标签上
        $categories = $this->obj->getCategoriesByParentID();
        return $this->fetch('',[
           'categories' => $categories
            ]);
    }

    /**
     *编辑分类信息的方法
     */
    public function edit(){
        if (request()->isPost()){
            $data = input('post.');
            //数据校验
            $validate = validate('Category');
            $res = $validate->scene('add')->check($data);
            if (!$res){
                $this->error($validate->getError());
            }
            //执行更新
            $res = $this->obj->save($data,['id'=>$data['id']]);
            if (!$res){
                $this->error('更新失败');
            }
            else {
                $this->success('更新成功');
            }
        }
        //获取当前想编辑的id
        $id = input('id',0,'intval');
        //根据id获取这一个分类的详情
        $res = $this->obj->get($id);
        //把所有一级分类查询出来,显示到select标签上
        $categories = $this->obj->getCategoriesByParentID();
        return $this->fetch('',[
            'category'=>$res,
            'categories' => $categories

        ]);
    }

    /**
     *修改排序顺序的方法
     */
    public function listorder(){
        if (request()->isPost()){
            $id = input('id',0,'intval');

            $listorder = input('listorder',0,'intval');

            //更新排序
            $res = $this->obj->save(['listorder'=>$listorder],['id'=>$id]);
            if (!$res){
                $this->result('',0,'状态更新失败');
            }
            else {
                $this->result($_SERVER['HTTP_REFERER'],1,'状态更新成功');
            }
        }

    }

}