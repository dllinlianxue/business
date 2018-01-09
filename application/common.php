<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 根据状态值返回状态信息
 * @param $status 1:正常 0:待审 -1:删除
 */
function status($status){
    $str = '';

    if ($status == 1){
        $str = '<label class="btn btn-success">正常</label>';
    } else if ($status == 0){
        $str = '<label class="btn btn-warning">待审</label>';
    } else if ($status == -1){
        $str = '<label class="btn btn-danger">删除</label>';
    }
   return $str;
}

//分页处理方法
function pagination($pageData){
    if (!$pageData){
        return '';
    }
    $param = request()->param();
    $htmlString = "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>". $pageData->appends($param)->render() ."</div>";
    return $htmlString;
}

//专门进行网络请求的函数
/**
 * @param $url 想要请求的地址
 * @param int $type POST->1/GET->0 方式
 * @param array $danta POST的参数
 */
function doCurl($url, $type=0, $data=[]){
    //初始化一个curl实例
    $ch = curl_init();
    //设置基本选项:set option
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);

    //判断请求类型
    if ($type == 1){
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    //发起请求
    $result = curl_exec($ch);

    //关闭curl请求
    curl_close($ch);
    return $result;
}

//通过Category_path获取子分类并进行选中状态的添加
function getSeCategories($category_path){
    if (!$category_path){
        return '';
    }
    //检测一个字符串是否符合某种规则(正则)
    if (preg_match('/,/',$category_path)){
        $tempArr = explode(',',$category_path);
        $se_categories = model('Category')->getCategoriesByParentID(intval($tempArr[0]));
        $se_ids = explode('|',$tempArr[1]);
        //遍历se_categories
        $htmlString = '';
        foreach ($se_categories as $obj){
            if (in_array($obj->id,$se_ids)){
                $htmlString .= "<input name='se_categories[]' type='checkbox' value='".$obj->id."'checked><label>".$obj->name."</label>";
            }
            else {
                $htmlString .= "<input name='se_categories[]' type='checkbox' value='".$obj->id."'><label>".$obj->name."</label>";
            }
        }
        return $htmlString;
    }
    else {
        return '';
    }
}
//获取客户端的IP地址
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if(isset($_SERVER['HTTP_X_REAL_IP'])){//nginx 代理模式下，获取客户端真实IP
        $ip=$_SERVER['HTTP_X_REAL_IP'];
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

//根据分类id获取分类名称
function getCategoryNameById($category_id){
    if (!$category_id){
        return '';
    }
    return model('Category')->where(['id'=>$category_id])->value('name');
}

//根据城市id获取城市名称
function getCityNameById($city_id){
    if (!$city_id){
        return '';
    }
    return model('City')->where(['id'=>$city_id])->value('name');
}

//根据deal里的location_IDS(字符串)获取门店个数
function countLocations($location_ids){
    if (!$location_ids){
        return 0;
    }
    $array = explode(',',$location_ids);
    return count($array);
}
