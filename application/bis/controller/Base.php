<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/7
 * Time: 下午3:53
 */
namespace app\bis\controller;

use think\Controller;
use think\Session;

class Base extends Controller{
    //用来存放当前用户信息对象user
    public $account='';

    protected function _initialize()
    {

        //检测登陆状态
        if (!$this->checkLogin()){
            //未登录
            $this->redirect('login/index');
        }

        $this->assign('user',$this->account);
    }

    public function checkLogin(){
        $user = $this->getCurrentUserInfo();
        if (!$user){
            return false;
        }
        return true;
    }


    //为account赋值:当前session里的用户
    public function getCurrentUserInfo(){
        //惰性加载(懒加载)
        if (!$this->account){
            $this->account = Session::get('bis_user','o2o');
        }
        return $this->account;
    }


    /**
     * 实现数据校验
     * @param $ClassName
     */
    public function checkData($className,$scene,$data=[]){
        $validate = validate($className);
        $res= $validate->scene($scene)->check($data);
        if (!$res){
            $this->error($validate->getError());
        }
    }


    //修改状态
    public function status(){
        //接受从前端发送过来的status的值
        $status = input('status',0,'intval');
        $id = input('id',0,'intval');

        $modelName = input('model');
        //想要修改的表名
        //修改数据库的值,参数一是修改的值,参数2是条件
        $res = model($modelName)->save(['status'=>$status],['id'=>$id]);
        if (!$res){
            $this->error('状态修改失败');
        } else {
            $this->success('状态修改成功');
        }
    }

    /**
     *根据common.js发过来的parent_id,查询下属城市
     */
    public function get_se_cities()
    {

        if (request()->isPost()) {

            $parent_id = input('parent_id', 0, 'intval');

            //根据parent_id查询二级城市信息
            $cities = model('City')->getCitiesByParentID($parent_id);
            if (!$cities) {
                $this->result('', 0, '获取城市失败');
            } else {
                //返回到结果js请求出
                $this->result($cities, 1, '获取城市成功');
            }

        }
    }

    /**
     *根据一级分类的id,查询其所有子分类,有common.js使用
     */
    public function get_se_categories(){
        $parent_id = input('parent_id',0,'intval');
        $res = model('Category')->getCategoriesByParentID($parent_id);

        if (!$res && !is_array($res)){
            //空数组是数组,是假的
            $this->result('',0,'获取分类失败');
        }
        else {
            $this->result($res,1,'获取分类成功');
        }
    }



}