<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\OrderGoods as OrderGoodsModel;
use think\Validate;

class UserOrder extends Base
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
            $data = $data->where('delete_time', 0)->where('type', 5)
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

    public function edit($id)
    {
        $order = Db::name('order_goods')->where('type', 5)->where('id', $id)->find();
        $array = json_decode($order['product_value'], true);
        $product = [];
        foreach ($array as $k => $v) {
            $product[] = [
                'id' => $v['id'],
                'title' => $v['title'],
                'price' => $v['price'],
                'pic' => $v['pic'],
                'num' => $v['num'],
            ];
        }
        $this->assign('count', count($product));
        $this->assign('order', $order);
        $this->assign('id', $order['id']);
        $this->assign('product', $product);
        return $this->fetch();
    }

    public function update()
    {
        $form = $this->request->post();

        $rule = [
            'waybill_no' => 'require',
            'logistics' => 'require',
            'status' => 'require|number'
        ];
        $message = [
            'logistics' => '物流必须填写',
            'waybill_no' => '运单号必须填写',
            'status' => '请选择发货或取消发货',
        ];
        if($form['status']&&$form['status']==1){
            $validate = new Validate($rule, $message);
            if (!$validate->check($form)) {
                return json(['code' => 0, 'msg' => $validate->getError()]);
            }
        }
        try {
            $order = Db::name('order_goods')->where('id', $form['id'])->update(['logistics' => $form['logistics'], 'waybill_no' => $form['waybill_no'], 'status' => $form['status']]);
            return json(['code' => 1, 'msg' => '操作成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }

    public function status()
    {
        $id = $this->request->post('id');
        $cate = $this->request->post('cate');
        try {
            if ($cate == 1) {
                Db::name('order_goods')->where('id', $id)->update(['status' => 1]);
                return json(['code' => 1, 'msg' => '已发货']);
            } else {
                Db::name('order_goods')->where('id', $id)->update(['status' => 2]);
                return json(['code' => 2, 'msg' => '已取消']);
            }
        } catch (\Exception $e) {
            return json(['code' => 3, 'msg' => '系统错误', 'sleep' => 5000]);
        }
    }


    public function userShow($id)
    {
        $user = \app\admin\model\User::get($id);
        $this->assign('user', $user);
        return $this->fetch();
    }
}
