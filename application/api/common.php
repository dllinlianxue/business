<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/9
 * Time: 上午10:20
 */
function show($code,$msg,$data){
    return json([
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    ]);
}