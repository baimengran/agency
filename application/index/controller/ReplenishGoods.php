<?php

namespace app\index\controller;

use app\common\GenerateNo;
use app\index\model\MyProduct;
use app\index\model\OrderGoods;
use app\index\model\Product;
use think\Controller;
use think\Db;
use think\facade\Log;
use think\Request;

class ReplenishGoods extends Base
{
    protected $middleware=['Agency'];
    public function index()
    {
        try {
            $user_id = session('user')['id'];
            $user = Db::name('user')->where('id',$user_id)->value('agency_id');

            $product = Db::name('my_product')->alias('m')
                ->join('product p', 'm.product_id=p.id')
                ->join('agency_product ap','ap.product_id=p.id')
                ->field('m.id,p.id as product_id,m.num,p.title,ap.again_boxful_num,ap.type')
                ->where('user_id',$user_id)->where('ap.agency_id',$user)->order('m.create_time desc')->all();

            $this->assign('product', $product);
            return $this->fetch('replenish_goods/dl_buhuo');
        }catch(\Exception $e){
            Log::error('bu_huo'.$e->getMessage());
            return json('系统错误');
        }
    }

    public function select_product(Request $request)
    {
        $id = $request->get('id');
        $user_id = session('user')['id'];

        $user = Db::name('user')->where('id',$user_id)->value('agency_id');

        $product = Db::name('agency_product')->where('product_id', $id)->where('agency_id', $user)
            ->find();
        if ($product) {
            return json(['code' => 1, 'data' => $product]);
        }
        return json(['code' => 0]);
    }

    public function save(Request $request)
    {
        $form = $request->post();

        $validate = new \app\index\validate\ReserveGoods();
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        $user = session('user');

        unset($form['total_price']);
        $form['total_price'] = round($form['price']*$form['num'],2);
        if($form['box_type']==0){
            $form['total_price'] = round($form['box_price'] * $form['num'], 2);
            $form['box_num']=$form['num'];
            unset($form['num']);
            $form['price']=$form['box_price'];
            unset($form['box_price']);
        }else{
            $form['total_price'] = round($form['price'] * $form['num'], 2);
            unset($form['box_price']);
        }

        $no = (new GenerateNo())->generateNo($user['id']);
        $form['user_id'] = $user['id'];
        $form['type'] = 2;
        $form['no'] = $no;

        unset($form['box_type']);

        $order = OrderGoods::create($form);
        if ($order) {
            return json(['code' => 1, 'msg' => '操作成功']);
        } else {
            return json(['code' => 0, 'msg' => '操作失败']);
        }
    }


    public function order_list(Request $request){
        $id = $request->get('id');
        if($id){
            //显示详情
            $order = Db::name('order_goods')->alias('o')
                ->join('product p','o.product_id=p.id')
                ->field('o.no,p.title,o.num,o.price,o.total_price,o.remark,paid_at,o.payment_no,o.create_time,o.box_num')
                ->where('o.id',$id)->where('o.type',2)->find();

            $order['create_time'] = date('Y-m-d H:i:s',$order['create_time']);
            $order['paid_at']=$order['paid_at']?date('Y-m-d H:i:s',$order['paid_at']):'';
            return json(['code'=>2,'data'=>$order]);
        }
        if($request->isAjax()){
            //筛选
            $key = $request->get('filtrate');
            if($key==''){
                $key = 0;
            }
            $user = session('user');
            $order = OrderGoods::field('id,no,num,status')->where('user_id',$user['id'])
                ->where('status',$key)->where('type',2)->order('create_time desc')->all();
            return json(['code'=>1,'data'=>$order]);
        }
        return $this->fetch('replenish_goods/dl_buhuo_list');
    }
}
