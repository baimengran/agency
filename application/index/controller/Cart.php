<?php

namespace app\index\controller;

use app\common\GenerateNo;
use think\Controller;
use think\Db;
use think\facade\Log;
use think\Request;

class Cart extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {

        $user_id = session('user')['id'];
        try {
            if ($request->isAjax()) {
                $cart = Db::name('cart')->alias('c')->join('product p', 'c.product_id=p.id')
                    ->field('c.id,c.product_id,p.title,p.pic,p.price,c.num')
                    ->where('c.user_id', $user_id)->order('c.create_time desc')->all();

                $xuan = [];
                foreach ($cart as $v) {
                    $xuan[] = ['xuan' => false, 'num' => $v['num'], 'o_id' => $v['id'], 'pri' => $v['price']];
                }
                $xuan = json_encode($xuan, JSON_UNESCAPED_UNICODE);
                return json(['code' => 1, 'data' => $cart, 'xuan' => $xuan]);
            }
            $count = Db::name('cart')->where('user_id', $user_id)->count('id');

            $this->assign('count', $count);
            return $this->fetch('cart/car');
        } catch (\Exception $e) {
            Log::error('cart_index' . $e->getMessage());
            return json('系统错误');
        }
    }


    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $id = $request->post('id');
        $user_id = session('user')['id'];
        if (!$id) {
            return json(['code' => 0, '页面错误1']);
        }
        try {
            $cart_num = Db::name('cart')->field('num')->where('user_id', $user_id)->where('product_id', $id)->find();
            if ($cart_num) {
                $cart = \app\index\model\Cart::where('product_id', $id)->where('user_id', $user_id)->setInc('num', $cart_num);
            } else {
                $cart = \app\index\model\Cart::create(['product_id' => $id, 'user_id' => $user_id, 'num' => 1]);
            }

            if ($cart) {
                return json(['code' => 1, 'msg' => '加入购物车成功']);
            } else {
                return json(['code' => 0, 'msg' => '加入购物车失败']);
            }
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }


    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }


    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        try {
            $cart = Db::name('cart')->where('id', $id)->delete();
            if ($cart) {
                return json(['code' => 1, 'msg' => '删除成功']);
            }
            return json(['code' => 0, 'msg' => '删除失败']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }


    public function order_place(Request $request)
    {
        $field = $request->param('field');
        if ($field == 'ti') {
            $ids = $request->param('ids');
            $ids = explode(',', $ids);
            foreach ($ids as $k => $v) {
                if (empty($v)) {
                    unset($ids[$k]);
                }
            }
            $cart = Db::name('cart')->alias('c')->join('product p', 'c.product_id=p.id')
                ->field('c.id,c.product_id,c.num,p.id as p_id,p.title,p.pic,p.price')->where('c.id', 'in', $ids)->all();
            $total_price = 0;
            foreach ($cart as $v) {
                $total_price = $total_price + $v['price'] * $v['num'];
            }
            $site = getSite();
            $total_price = $total_price + $site['yunfei'] + $site['youhui'];
            $address = Db::name('address')->where('user_id', session('user')['id'])->where('status', 1)->find();
            if (!$address) {
                $address = Db::name('address')->where('user_id', session('user')['id'])->where('status', 0)->find();
            }
            $site = getSite();

            $this->assign('site', $site);
            $this->assign('total_price', $total_price);
            $this->assign('address', $address);
            $this->assign('cart', $cart);
            return $this->fetch('cart/order_tj');
        }
        if ($request->isAjax()) {
            $id = $request->post('id');
            $num = $request->post('num');
            try {
                $cart = Db::name('cart')->where('id', $id)->update(['num' => $num]);
                if ($cart) {
                    return json(['code' => 1]);
                }
            } catch (\Exception $e) {
                return json(['code' => 0, '操作失败']);
            }
        }
    }

    //以付款
    public function order_index(Request $request)
    {
        $user = session('user');
        $user_id = Db::name('user')->where('openid',$user['openid'])->value('id');

        $page = $request->get('page');
        $page = $page ?: 1;
        $lastRow = 10;
        $order = Db::name('order_goods')->where('user_id',$user_id)->where('type', 5)->where('status', 1)->where('payment_no','neq','');
        $order = $order->order('closed asc,create_time desc')->select();
        foreach ($order as $k => $v) {
            $order[$k]['product'] = json_decode($v['product_value'], true);
        }
        if($request->isAjax()){
            return json(['code'=>1,'data'=>$order]);
        }
        $this->assign('order_yi', $order);
        return $this->fetch('cart/order');
    }

    /**
     * 未付款
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function order_wei_pay(Request $request){
        $user = session('user');
        $user_id = Db::name('user')->where('openid',$user['openid'])->value('id');
        //判断订单日期，超过两小时没付款自动取消订单
        $order = Db::name('order_goods')->field('id,create_time')->where('user_id',$user_id)
            ->where('type', 5)->where('status', 0)->where('payment_no',null)->select();
        $data = [];
        $now = time();
        foreach($order as $v){
            if($now-$v['create_time']>24*3600){
                $data[]=$v['id'];
            }
        }
        if(count($data)){
            $order = Db::name('order_goods')->where('id','in',$data)->update(['status'=>2]);
        }

        $page = $request->get('page');
        $page = $page ?: 1;
        $lastRow = 10;
        $order = Db::name('order_goods')->where('type', 5)->where('user_id',$user_id)
            ->where('status', 0)->where('payment_no',null);
        $order = $order->order('closed asc,create_time desc')->select();
        foreach ($order as $k => $v) {
            $order[$k]['product'] = json_decode($v['product_value'], true);
        }
        return json(['code'=>1,'data'=>$order]);
    }

    /**
     * 代发货
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function order_dai_fa(Request $request){
        $user = session('user');
        $user_id = Db::name('user')->where('openid',$user['openid'])->value('id');
        $page = $request->get('page');
        $page = $page ?: 1;
        $lastRow = 10;
        $order = Db::name('order_goods')->where('type', 5)->where('user_id',$user_id)
            ->where('status', 0)->where('payment_no','neq','');
        $order = $order->order('closed asc,create_time desc')->select();

        foreach ($order as $k => $v) {
            $order[$k]['product'] = json_decode($v['product_value'], true);
        }
        return json(['code'=>1,'data'=>$order]);
    }

    /**
     * 取消发货
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     */
    public function order_cancel(Request $request){
        $user = session('user');
        $user_id = Db::name('user')->where('openid',$user['openid'])->value('id');
        $page = $request->get('page');
        $page = $page ?: 1;
        $lastRow = 10;
        $order = Db::name('order_goods')->where('type', 5)->where('status', 2);
        $order = $order->order('closed asc,create_time desc')->select();
        foreach ($order as $k => $v) {
            $order[$k]['product'] = json_decode($v['product_value'], true);
        }
        return json(['code'=>1,'data'=>$order]);
    }

    /**
     * 确认收货
     * @param Request $request
     * @return \think\response\Json
     */
    public function take_goods(Request $request)
    {
        $id = $request->get('id');
        try {
            $order = Db::name('order_goods')->where('id', $id)->update(['closed' => 2]);
            if ($order) {
                return json(['code' => 1, 'msg' => '操作成功']);
            }
        } catch (\Exception $e) {
            return json(['code' => 0, '系统错误']);
        }
    }

    public function order_add(Request $request)
    {
        if ($request->isAjax()) {
            $ids = $request->post('ids');
            $address_id = $request->post('address_id');
            $total_price = $request->post('total_price');
            Db::startTrans();
            try {
                $product = Db::name('product')->field('id,title,price,pic')
                    ->where('id', 'in', $ids)->all();
                $address = Db::name('address')->where('id', $address_id)->find();
                $user_id = session('user')['id'];
                $no = (new GenerateNo())->generateNo($user_id);

                $cart = Db::name('cart')->where('product_id', 'in', $ids)->all();
                foreach ($product as $k => $v) {
                    foreach ($cart as $key => $item) {
                        if ($v['id'] == $item['product_id']) {
                            $product[$k]['num'] = $item['num'];
                        }
                    }
                }

                $data = [
                    'no' => $no,
                    'user_id' => $user_id,
                    'type' => 5,
                    'product_value' => json_encode($product, JSON_UNESCAPED_UNICODE),
                    'address' => $address['address'],
                    'phone' => $address['phone'],
                    'consignee' => $address['name'],
                    'total_price' => $total_price,
                    'create_time' => time(),
                    'update_time' => time(),
                ];

                $order = Db::name('order_goods')->insertGetId($data);
                if ($order) {
                    $cart = Db::name('cart')->where('product_id', 'in', $ids)->where('user_id', $user_id)->delete();
                    Db::commit();
                    return json(['code' => 1, 'msg' => '下单成功', 'data' => $order]);
                } else {
                    Db::rollback();
                    return json(['code' => 0, 'msg' => '下单失败']);
                }
            } catch (\Exception $e) {
                Db::rollback();
                return json(['code' => 0, 'msg' => '系统错误']);
            }
        }
    }

    public function order_show(Request $request)
    {
        $id = $request->param('id');
        $order = Db::name('order_goods')->where('type', 5)->where('id', $id)->find();
        if (!$order) {
            return json(['code' => 0, 'msg' => '未找到相应订单']);
        }
        $product_value = json_decode($order['product_value'], true);
        $address = ['address' => $order['address'], 'phone' => $order['phone'], 'consignee' => $order['consignee']];
        $site = getSite();
        $order_info = ['no'=>$order['no'],'total_price' => $order['total_price'], 'create_time' => $order['create_time'], 'yunfei' => $site['yunfei'], 'youhui' => $site['youhui']];
        $this->assign('product', $product_value);
        $this->assign('address', $address);
        $this->assign('order_info', $order_info);
        return $this->fetch('cart/order_xq');
    }

    /**
     * 订单支付
     */
    public function pay(Request $request)
    {
        $no = $request->post('no');
        $user = session('user');
        try {
            $order = Db::name('order_goods')->where('no', $no)->find();
            $user_openid = Db::name('user')->where('id',$user['id'])->value('openid');
            if(!$user_openid){
                return json(['code'=>0,'msg'=>'当前用户不存在']);
            }
            $product = Db::name('product')->where('id',$order['product_id'])->value('title');
            $order_desc = '订购'.$product.$order['num'].'箱，合计'.$order['total_price'].'元';
            $data = (new Pay())->miniProgramPay($user_openid,$order_desc,$order['total_price'],$order['no'],url('cart/order_show','','',true));
        }catch(\Exception $e){
            return json(['code'=>0,'msg'=>'未找到相应订单']);
        }
    }
}
