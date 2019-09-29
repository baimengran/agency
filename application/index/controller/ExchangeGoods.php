<?php

namespace app\index\controller;

use app\common\GenerateNo;
use app\index\model\OrderGoods;
use app\index\model\Product;
use think\Controller;
use think\Db;
use think\facade\Log;
use think\Request;

class ExchangeGoods extends Base
{
    protected $middleware=['Agency'];
    public function index()
    {
        try {
            $user_id = session('user')['id'];
            $product = Db::name('my_product')->alias('m')
                ->join('product p', 'm.product_id=p.id')
                ->field('m.id,p.id as product_id,m.num,p.title')
                ->where('m.user_id', $user_id)->order('m.create_time desc')->all();

            $this->assign('product', $product);
            return $this->fetch('exchange_goods/dl_diaohuo');
        } catch (\Exception $e) {
            Log::error('diao_huo' . $e->getMessage());
            return json('系统错误');
        }
    }

    public function select_product(Request $request)
    {
        $id = $request->get('id');
        $product = Db::name('my_product')->where('id', $id)
            ->where('user_id', session('user')['id'])->value('num');
        if ($product) {
            return json(['code' => 1, 'data' => $product]);
        }
        return json(['code' => 0]);
    }

    public function select_client(Request $request)
    {
        $id = $request->get('id');
        try {
            $client = $client = Db::name('my_client')->where('id', $id)
                ->field('id,name,phone,address,buy_num')->find();
            return json(['code' => 2, 'data' => $client]);
        } catch (\Exception $e) {
            return json(['code' => 0]);
        }
    }

    public function save(Request $request)
    {
        $form = $request->post();
        Db::startTrans();
        try {
            $user = session('user');

            $my_product_1 = Db::name('my_product')->where('user_id', $user['id'])->where('id', $form['goods_1']);
            $repertory = $my_product_1->value('num');
            $my_product_2 = Db::name('my_product')->where('user_id', $user['id'])->where('id', $form['goods_2']);
            if ($repertory - $form['num'] < 0) {
                return json(['code' => 2, 'msg' => '库存不足']);
            }

            $product_1 = Db::name('product')->where('id', $my_product_1->value('product_id'))->field('title')->find();
            $product_2 = Db::name('product')->where('id', $my_product_2->value('product_id'))->field('title')->find();
            $form['remark'] = '申请从 【' . $product_1['title'] . ' 】调取 ' . $form['num'] . ' 件货物到 【' . $product_2['title'] . ' 】';

            $no = (new GenerateNo())->generateNo($user['id']);
            $form['user_id'] = $user['id'];
            $form['type'] = 3;
            $form['no'] = $no;
            unset($form['goods_1']);
            unset($form['goods_2']);
//            unset($form['num']);
            $order = OrderGoods::create($form);

            Db::commit();
            if ($order) {
                return json(['code' => 1, 'msg' => '操作成功']);
            } else {
                return json(['code' => 0, 'msg' => '操作失败']);
            }
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 0, 'msg' => '操作失败']);
        }
    }


    public function order_list(Request $request)
    {
        $id = $request->get('id');
        if ($id) {
            //显示详情
            $order = Db::name('order_goods')->field('no,num,remark,create_time')
                ->where('id', $id)->where('type', 3)->find();

            $order['create_time'] = date('Y-m-d H:i:s', $order['create_time']);
            return json(['code' => 2, 'data' => $order]);
        }
        if ($request->isAjax()) {
            //筛选
            $key = $request->get('filtrate');
            if ($key == '') {
                $key = 0;
            }
            $user = session('user');
            $order = OrderGoods::field('id,no,num,status')->where('user_id', $user['id'])
                ->where('status', $key)->where('type', 3)->order('create_time desc')->all();
            return json(['code' => 1, 'data' => $order]);
        }
        return $this->fetch('exchange_goods/dl_diaohuo_list');
    }
}
