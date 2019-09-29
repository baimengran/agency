<?php

namespace app\admin\controller;

use app\admin\model\MyProduct;
use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\OrderGoods as OrderGoodsModel;
use think\Validate;

class ReserveGoods extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        try {
            $key = input('key');
            $data = new OrderGoodsModel();
            if ($key) {
                $data = $data->where('no', 'like', '%' . $key . '%');
            }
            $data = $data->with('user')->where('delete_time', 0)->where('type', 1)
                ->order('status asc,create_time', 'desc')->paginate(20);
            if ($data) {
                return view('index', [
                    'val' => $key,
                    'data' => $data,
                    'empty' => '<tr><td colspan="11" align="center"><span>暂无数据</span></td></tr>'
                ]);
            }
        } catch (\Exception $e) {
            return view('error/500');
        }
    }

    public function status(Request $request)
    {
        $form = $request->post();
        $json = [];
        Db::startTrans();
//        try {
            $order = OrderGoodsModel::get($form['id']);
            if ($form['status'] == 3) {
                //取消补货
                $order_update = $order->update(['id' => $form['id'], 'status' => 2]);
                $json = ['status' => -1, 'code' => 0, 'msg' => '已取消', 'sleep' => 5000];
            }
            if ($form['status'] == 1) {
                $order_status = Db::name('order_goods')->where('id', $form['id'])->value('status');
                if ($order_status == 0) {
                    $order_update = $order->update(['id' => $form['id'], 'status' => 1]);
                    $data = [
                        'user_id' => $order['user_id'],
                        'product_id' => $order['product_id'],
                        'create_time'=>time(),
                        'update_time'=>time(),
                    ];

                    if($order['num']!=null){
                        $data['num']=$order['num'];
                    }
                    if($order['box_num']!=null){
                        $data['box_num']=$order['box_num'];
                        $product_num = Db::name('product')->where('id',$order['product_id'])->value('num');
                        $data['num']=$order['box_num']*$product_num;
                    }

                    $myProduct = (new MyProduct())->save($data);
                    $json = ['status' => 1, 'code' => 1, 'msg' => '以完成', 'sleep' => 5000];
                }else {
                    $json = ['code' => -1, 'msg' => '当前订单已发货', 'sleep' => 5000];
                }
            }
            Db::commit();
            return json($json);
//        } catch (\Exception $e) {
//            Db::rollback();
//            return json(['code' => -1, 'msg' => '系统错误', 'sleep' => 3000]);
//        }
    }

    public function edit($id)
    {
        $order = OrderGoodsModel::where('id', $id)->field('id,user_id,status,remark')->find();
        $user_product = MyProduct::where('user_id', $order['user_id'])->select();
        $this->assign('order', $order);
        $this->assign('product', $user_product);
        return $this->fetch();
    }

    public function update(Request $request)
    {
        $form = $request->post();
        if ($form['status'] == 2) {
            try {
                $order = OrderGoodsModel::where('id', $form['id'])->update(['status' => 2]);
                return json(['code' => 1, 'msg' => '取消调货成功']);
            } catch (\Exception $e) {
                return json(['code' => 0, 'msg' => '系统错误']);
            }
        }
        $product_inc = [];
        $product_dec = [];

        foreach ($form['product'] as $k => $v) {
            if (!$v) {
                unset($form['product'][$k]);
            }
            if (stristr($v, '+')) {
                $product_inc[] = ['id' => $k, 'inc' => substr($v, 1)];
            }
            if (stristr($v, '-')) {
                $product_dec [] = ['id' => $k, 'dec' => substr($v, 1)];
            }
        }
        if (count($product_inc) == 0 && count($product_dec) == 0) {
            $form['product'] = null;
        }

        $rule = [
            'id' => 'require',
            'status' => 'require|in:1',
            'product' => 'require',
        ];
        $message = [
            'id.require' => 'id不能为空',
            'status' => '状态不能为空',
            'product' => '调货信息填写错误'
        ];
        $validate = new Validate($rule, $message);
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
//        dump($product_inc);die;
        Db::startTrans();
        try {
            $order = OrderGoodsModel::update(['id' => $form['id'], 'status' => $form['status']]);
            foreach ($product_inc as $k => $v) {
                $my_product = MyProduct::where('id', $v['id'])->setInc('num', $v['inc']);
            }
            foreach ($product_dec as $k => $v) {
                $my_product = MyProduct::where('id', $v['id'])->find();
                $num = $my_product['num'] - $v['dec'];
                if ($num < 0) {
                    return json(['code' => 0, 'msg' => $my_product->product->title . '商品数量不足']);
                }
                $my_product = $my_product->setDec('num', $v['dec']);
            }
            Db::commit();
            return json(['code' => 1, 'msg' => '调货成功']);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }

    public function userShow($id)
    {
        $user = \app\admin\model\User::get($id);
        $this->assign('user', $user);
        return $this->fetch();
    }
}
