<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/8
 * Time: 下午3:17
 */
namespace app\bis\controller;

use think\Controller;

class Register extends Controller
{
    public function index()
    {
        //获取一级城市(省provinces份信息)
        $provinces = model('City')->getCitiesByParentID();

        $categories = model('Category')->getCategoriesByParentID();


        return $this->fetch('', [
            'provinces' => $provinces,
            'categories' => $categories
        ]);

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


    /**
     *注册新商户的方法
     */
    public function add(){
        if (request()->isPost()) {
            $data = input('post.');

            //数据校验:username和password是否有值
//            $validate = validate('BisAccount');
//            $res = $validate->scene('add')->check($data);
//            if (!$res){
//                $this->error($validate->getError());
//            }
            $this->checkData('BisAccount', 'add', $data);

            //检测该用户名是否存在
            $res = model('BisAccount')->get(['username' => $data['username']]);
            if ($res) {
                $this->error('该用户名已存在');
            }

            //Bis的数据校验
            $this->checkData('Bis', 'add', $data);

            //判断输入的地理信息是否精准(百度地图0是成功)
            $locationResult = \Map::getLngLat($data['address']);
            if ($locationResult['status'] != 0 ||    $locationResult['result']['precise'] != 1){
                $this->error('商户地址信息不准确');
            }

            //整理bis表的数据,准备入库
            $bisData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'logo' => $data['logo'],
                'licence_logo' =>$data['licence_logo'],
                'description' => $data['description'],
                'city_id' => $data['city_id'],
                'city_path' => $data['city_id'].','.$data[('se_city_id')],
                'bank_info' => $data['bank_info'],
                'bank_name' => $data['bank_name'],
                'bank_user' => $data['bank_user'],
                'faren' => $data['faren'],
                'faren_tel' => $data['faren_tel']

            ];
            //存入数据库,返回bis_id
            $bis_id = model('Bis')->add($bisData);

            //准备Category——path：
            $se_cats = $data['se_categories'];
            $cat_string = '';
            if (!empty($se_cats)){
                $cat_string = ','.implode('|',$se_cats);
                //数组转换成字符串
            }


            //准备bis_location表的数据
            $locationData = [
                'name' => $data['name'],
                'logo' => $data['logo'],
                'address' => $data['address'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'xpoint' => $locationResult['result']['location']['lng'],
                'ypoint' => $locationResult['result']['location']['lat'],
                'bis_id' => $bis_id,
                'open_time' => $data['open_time'],
                'content'=>$data['content'],
                'is_main' => 1,
                'api_address' => $data['address'],
                'city_id' => $data['city_id'],
                'city_path' => $bisData['city_path'],
                'category_id'=> $data['category_id'],
                'category_path'=>$data['category_id'].$cat_string,
                'bank_info' => $data['bank_info']

            ];

            //入库操作
            $location_res = model('BisLocation')->save($locationData);

            //bisAccount表数据准备:
            $code = mt_rand(1000,9999);
            $accountData = [
                'username' => $data['username'],
                'password' => md5($data['password'].$code),
                'code' => $code,
                'bis_id' => $bis_id,
                'is_main' => 1
            ];
            $account_res = model('BisAccount')->save($accountData);

            if ($bis_id && $location_res && $account_res){
                $this->success('注册成功',url('login/index'));
            }
            else {
                $this->error('注册失败/(T o T)');
            }





        }
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


}