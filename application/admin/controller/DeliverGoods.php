<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\OrderGoods as OrderGoodsModel;

class DeliverGoods extends Base
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
            $data = $data->where('delete_time', 0)->where('type',4)
                ->order('status asc,create_time', 'desc')->paginate(20);
            if ($data) {
                return view('index', [
                    'val' => $key,
                    'data' => $data,
                    'empty' => '<tr><td colspan="8" align="center"><span>暂无数据</span></td></tr>'
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
        try {
            $order = OrderGoodsModel::get($form['id']);

            if ($form['status'] == 2) {
                //取消补货
                $order_update = $order->update(['id' => $form['id'], 'status' => 2]);
                $json = ['status' => -1, 'code' => 0, 'msg' => '已取消', 'sleep' => 5000];
//                return json(['code' => 0, 'msg' => '以取消', 'sleep' => 5000]);
            }
            if ($form['status'] == 1) {
                //自动补货
                $order_update = $order->update(['id' => $form['id'], 'status' => 1]);
                $json = ['status' => 1, 'code' => 1, 'msg' => '以发货', 'sleep' => 5000];
            }
            Db::commit();
            return json($json);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => -1, 'msg' => '系统错误', 'sleep' => 3000]);
        }
    }

    public function userShow($id){
        $user = \app\admin\model\User::get($id);
        $this->assign('user',$user);
        return $this->fetch();
    }
}
