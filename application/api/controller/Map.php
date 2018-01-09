<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/8
 * Time: 下午2:17
 */
namespace app\api\controller;

use think\Controller;

class Map extends Controller
{
    public function get_image()
    {
        $res = \Map::getStaticImage('北京市故宫博物馆');
        return $res;
    }

    public function get_image_detail_xy()
    {
        $xpoint = input('xpoint');
        $ypoint = input('ypoint');
        $res = \Map::getStaticImage($xpoint. ',' .$ypoint);
        return $res;
    }
}
