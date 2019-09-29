<?php

namespace app\index\controller;

use app\common\GenerateNo;
use app\index\model\OrderGoods;
use think\Controller;
use think\Db;
use think\facade\Log;
use think\Request;

class DeliverGoods extends Base
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

            $client = Db::name('my_client')->where('user_id', $user_id)
                ->field('id,name')->all();

            $this->assign('product', $product);
            $this->assign('client', $client);
            return $this->fetch('deliver_goods/dl_fahuo');
        } catch (\Exception $e) {
            Log::error('fa_huo' . $e->getMessage());
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
        return json(['code' => 0,'msg'=>'当前商品库存不足']);
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

        $validate = new \app\index\validate\DeliverGoods();
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        Db::startTrans();
        try {
            $user = session('user');
            $my_product = Db::name('my_product')->where('user_id',$user['id'])->where('id',$form['id']);
            $repertory = $my_product->value('num');
            if($repertory-$form['num']<0){
                return json(['code'=>2,'msg'=>'库存不足']);
            }

            $product = Db::name('product')->where('id', $my_product->value('product_id'))->field('id,title,desc,price')->find();
            $form['product_id']=$product['id'];
            $product = json_encode($product,JSON_UNESCAPED_UNICODE);
            $no = (new GenerateNo())->generateNo($user['id']);
            $form['user_id'] = $user['id'];
            $form['type'] = 4;
            $form['no'] = $no;
            $form['product_value'] = $product;
            unset($form['id']);
            $order = OrderGoods::create($form);

            //减库存
            $my_product = $my_product->setDec('num',$form['num']);

            Db::commit();
            if ($order) {
                return json(['code' => 1, 'msg' => '操作成功']);
            } else {
                return json(['code' => 0, 'msg' => '操作失败']);
            }
        }catch(\Exception $e){
            Db::rollback();
            return json(['code'=>0,'msg'=>'操作失败']);
        }
    }


    public function order_list(Request $request)
    {
        $id = $request->get('id');
        if ($id) {
            //显示详情
            $order = Db::name('order_goods')->field('no,num,remark,create_time,product_value,address,phone,consignee')
                ->where('id', $id)->where('type', 4)->find();
            $array = json_decode($order['product_value'],true);
            $order['title']=$array['title'];

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
                ->where('status', $key)->where('type', 4)->order('create_time desc')->all();
            return json(['code' => 1, 'data' => $order]);
        }
        return $this->fetch('deliver_goods/dl_fahuo_list');
    }
}
