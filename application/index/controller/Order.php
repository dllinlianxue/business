<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/11/21
 * Time: 上午9:36
 */
namespace app\index\controller;


use alipay\Pagepay;
use think\Session;

class Order extends Base
{
    public function index(){
        //登陆判断
        if (!Session::get('user','o2o')){
            $this->redirect('login/index');
        }
        $id = input('id',0,'intval');
        if (!$id){
            $this->error('ID异常');
        }
        $deal = model('Deal')->get($id);

        return $this->fetch('',[
            'email' => $this->account->email,
            'deal' => $deal
        ]);
    }
    //发起支付的方法
    public function pay()
    {
       //获取订单界面的数据,生成一个订单信息(未支付)
        $data = input('post.');

        //根据id获取deal的信息
        $deal = model('Deal')->get(intval($data['id']));

        //构造订单数组
        $order_data = [
            'trade_id' => time().$this->account->id.mt_rand(1000,9999),
            'user_id' => $this->account->id,
            'deal_id' => $data['id'],
            'description' => $deal->description,
            'last_ip' => get_client_ip(),
            'bis_id' => $deal->bis_id,
            'status' => 0, //未完成
            'buy_count' => $data['buy_count'],
            'total_price' => $data['total_price']
        ];

        //入库操作
        $res = model('Order')->save($order_data);
        if (!$res){
            $this->error('订单生成失败');
        }
        else
        {
            $pay_data = [
                'subject' => $deal->name,
                'out_trade_no' => $order_data['trade_id'],
                'total_amount' => $order_data['total_price']
            ];
            //调用支付宝的支付界面
            Pagepay::pay($pay_data);
            //信息会发送到支付宝,通知通过notify_URL和return_URL来决定
        }
    }

    //接收支付成功后支付宝的反馈,return_url->前端
    public function finish_front()
    {
//        print_r(input('get.'));exit();

        $data = input('get.');

        if (!empty($data['out_trade_no']))
        {
            //根据订单号查询订单信息
            $order_info = model('Order')->get(['trade_id'=>$data['out_trade_no']]);

            if ($order_info->status != 1)
            {
                $res = model('Order')->save(['status'=>1],['trade_id'=>$data['out_trade_no']]);
                if (!$res)
                {
                    $this->error('订单更新失败');
                }
                else
                {
                    $this->success('订单更新成功',url('index/index'));
                }
            }
        }
    }

    //notify_url -> 服务端
    public function finish_server()
    {
        $data = input('post.');

        if (!empty($data['out_trade_no'])) {
            //根据订单号查询订单信息
            $order_info = model('Order')->get(['trade_id' => $data['out_trade_no']]);

            if ($order_info->status != 1) {
                $res = model('Order')->save(['status' => 1], ['trade_id' => $data['out_trade_no']]);
                if (!$res) {
                    echo 'fail';
                } else {
                    echo 'success';
                }
            }
        }
    }

}