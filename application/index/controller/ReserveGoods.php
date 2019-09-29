<?php

namespace app\index\controller;

use app\index\controller\Pay;
use app\common\GenerateNo;
use app\index\model\MyProduct;
use app\index\model\OrderGoods;
use app\index\model\Product;
use app\index\model\Agency;
use app\index\model\User;
use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Log;
use think\Request;

class ReserveGoods extends Base
{
    protected $middleware=['Agency'];

    public function index()
    {
        try {
            $user_id = session('user')['id'];
            $my_product = MyProduct::where('user_id', $user_id)->column('product_id');
            $agency = Db::name('user')->where('id', $user_id)->value('agency_id');

            $product = Db::name('agency_product')->alias('ap')->join('product p', 'p.id=ap.product_id')
                ->field('p.id,p.title,ap.id as ap_id,ap.product_id,ap.agency_id,ap.agency_price,ap.agency_box_price,
                ap.first_boxful_num,ap.again_boxful_num,ap.type')
                ->where('ap.agency_id', $agency)->whereNotIn('ap.product_id', $my_product)->where('p.status', 1)
                ->where('p.delete_time', 0)->order('p.create_time desc')->all();
            $this->assign('product', $product);
            return $this->fetch('reserve_goods/dl_dinghuo');
        } catch (Exception $e) {
            Log::error('ding_huo:' . $e->getMessage());
            return json('系统错误');
            exit;
        }
    }

    public function select_product(Request $request)
    {
        $id = $request->get('id');

        $user_id = session('user')['id'];
        $agency = Db::name('user')->where('id', $user_id)->value('agency_id');
        $product = Db::name('agency_product')->alias('ap')->join('product p', 'p.id=ap.product_id')
            ->field('p.id,p.title,ap.id as ap_id,ap.product_id,ap.agency_id,ap.agency_price,ap.agency_box_price,
                ap.first_boxful_num,ap.again_boxful_num,ap.type')
            ->where('ap.agency_id', $agency)->where('ap.product_id', $id)->where('p.status', 1)
            ->where('p.delete_time', 0)->order('p.create_time desc')->find();

        if ($product) {
            return json(['code' => 1, 'data' => $product]);
        }
        return json(['code' => 0]);
    }

    public function save(Request $request)
    {
        $user = session('user');
        $user = Db::name('user')->where('openid',$user['openid'])->find();
        $form = $request->post();

        $product = Db::name('order_goods')->where('product_id',$form['product_id'])
            ->where('type',1)->where('status',0)->where('user_id',$user['id'])->count('id');
        if($product){
            return json(['code'=>0,'msg'=>'当前产品您以订购，请等待审核通过或发货']);
        }
        $pay=null;
        if(array_key_exists('pay',$form)){
            $pay = 1;
        }
        $validate = new \app\index\validate\ReserveGoods();
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        unset($form['total_price']);
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
        $form['type'] = 1;
        $form['no'] = $no;
        unset($form['box_type']);
//        dump($form);die;
        $order = OrderGoods::create($form);

        //在线支付
//        if($pay){
//
//            //miniProgramPay($token, $order_desc,$total_fee,$no,$url)
//            $user_openid = Db::name('user')->where('id',$user['id'])->value('openid');
//            if(!$user_openid){
//                return json(['code'=>0,'msg'=>'当前用户不存在']);
//            }
//            $product = Db::name('product')->where('id',$order['product_id'])->value('title');
//            $order_desc = '订购'.$product.$order['num'].'箱，合计'.$order['total_price'].'元';
//
//            $data = (new Pay())->miniProgramPay($user_openid,$order_desc,$order['total_price'],$order['no'],url('reserve_goods/index','','',true));
//            if($data['code']==0){
//                return json($data);
//            }else{
//                return json($data);
//            }
//
//        }


        if ($order) {
            return json(['code' => 1, 'msg' => '操作成功']);
        } else {
            return json(['code' => 0, 'msg' => '操作失败']);
        }
    }


    public function order_list(Request $request)
    {
        $id = $request->get('id');
        if ($id) {
            //详情
            $order = Db::name('order_goods')->alias('o')
                ->join('product p', 'o.product_id=p.id')
                ->field('o.no,p.title,o.num,o.price,o.total_price,o.remark,paid_at,o.payment_no,o.create_time,o.box_num')
                ->where('o.id', $id)->where('o.type', 1)->find();

            $order['create_time'] = date('Y-m-d H:i:s', $order['create_time']);
            $order['paid_at'] = $order['paid_at'] ? date('Y-m-d H:i:s', $order['paid_at']) : '';
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
                ->where('status', $key)->where('type', 1)->order('create_time desc')->all();
            return json(['code' => 1, 'data' => $order]);
        }
        return $this->fetch('reserve_goods/dl_diaohuo_list');
    }


}
