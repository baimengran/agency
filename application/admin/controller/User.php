<?php

namespace app\admin\controller;

use app\admin\model\Agency;
use app\admin\model\MyProduct;
use app\common\UserTree;
use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\User as UserModel;
use app\admin\model\OrderGoods as OrderGoodsModel;
use think\Validate;
use app\admin\validate\User as UserValidate;

class User extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function user_index()
    {
        try {
            $key = input('key');
            $data = new UserModel();
            if ($key) {
                $data = $data->where('nickname', 'like', '%' . $key . '%')
                    ->whereOr('real_name', 'like', '%' . $key . '%');
            }
            $data = $data->field('id,nickname,avatar,sex,city,province,agency_id')
                ->where('agency_id', 0)->order('create_time desc')->paginate(20);
            if ($data) {
                return view('index', [
                    'val' => $key,
                    'data' => $data,
                    'empty' => '<tr><td colspan="4" align="center"><span>暂无数据</span></td></tr>'
                ]);
            }
        } catch (\Exception $e) {
            return view('error/500');
        }
    }


    public function index()
    {
        try {
            $key = input('key');
            $data = new UserModel();
            if ($key) {
                $data = $data->where('nickname', 'like', '%' . $key . '%')
                    ->whereOr('real_name', 'like', '%' . $key . '%');
            }
            $data = $data
                ->where('agency_id', 'neq', 0)->order('create_time desc')->paginate(20);
            if ($data) {
                return view('user/agency_index', [
                    'val' => $key,
                    'data' => $data,
                    'empty' => '<tr><td colspan="7" align="center"><span>暂无数据</span></td></tr>'
                ]);
            }
        } catch (\Exception $e) {
            return view('error/500');
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $user = UserModel::get($id);
        $agency = Agency::where('delete_time', 0)->all();
        $this->assign('agency', $agency);
        $this->assign('data', $user);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $form = $request->post();

        $validate = new UserValidate();
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        Db::startTrans();
        try {
            $data = ['id' => $form['id'], 'agency_id' => $form['agency_id'],'phone'=>$form['phone']];
            if ($form['agency_id'] == 0) {
                $data['status'] = 0;
            }
            $user = UserModel::update($data);
            if ($form['agency_id'] == 0) {
                $my_product = Db::name('my_product')->where('user_id', $id)->delete();
                $order = Db::name('order_goods')->where('user_id', $id)->where('status', 0)->delete();
            }
            Db::commit();
            return json(['code' => 1, 'msg' => '编辑成功']);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    public function status(Request $request)
    {
        $user_id = $request->post('id');

        $form = $request->post();
        $json = [];
        Db::startTrans();
        try {
            if ($form['status'] == 2) {
                //取消补货
                $user = Db::name('user')->where('id', $user_id)->update(['status' => 2]);
                $json = ['status' => -1, 'code' => 0, 'msg' => '已取消', 'sleep' => 5000];
            }
            if ($form['status'] == 1) {
                $user = Db::name('user')->where('id', $user_id)->update(['status' => 1, 'status_time' => time()]);
                //查询是否下单了商品
                $order = Db::name('order_goods')->where('type', 1)->where('user_id', $user_id)->where('status', 0)
                    ->find();
                if ($order) {
                    if ($order['status'] == 0) {
                        $order = Db::name('order_goods')->where('type', 1)->where('user_id', $user_id)
                            ->update(['status' => 1]);
                        $order = Db::name('order_goods')->where('type', 1)->where('user_id', $user_id)
                            ->where('status', 1)->find();
                        $data = [
                            'user_id' => $order['user_id'],
                            'product_id' => $order['product_id'],
                            'create_time' => time(),
                            'update_time' => time(),
                        ];

                        if ($order['num'] != null) {
                            $data['num'] = $order['num'];
                        }
                        if ($order['box_num'] != null) {
                            $data['box_num'] = $order['box_num'];
                            $product_num = Db::name('product')->where('id', $order['product_id'])->value('num');
                            $data['num'] = $order['box_num'] * $product_num;
                        }
                        $my_product = Db::name('my_product')->insert($data);
                    }

                }
                $json = ['status' => 1, 'code' => 1, 'msg' => '已审核', 'sleep' => 5000];
            }
            Db::commit();
            return json($json);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => -1, 'msg' => '系统错误', 'sleep' => 3000]);
        }
    }

    public function show(Request $request)
    {

        $user = UserModel::get($request->param('id'));
        $path = $user['path'] . $user['id'] . '-';
        if ($request->isAjax()) {
            if ($request->param('product')) {
                $product = MyProduct::with('product')->where('user_id', $user['id'])->paginate(20);
                $data = $product->items();
                $page = $product->render();
                $data['page2'] = $page;
                $data['code'] = 1;
                return json($data);
            }
        }
        $total = MyProduct::where('user_id', $user['id'])->count('id');
        $product = MyProduct::with('product')->where('user_id', $user['id'])->paginate(20);
        $page2 = $product->render();
        $this->assign('product', $product);
        $this->assign('page2', $page2);
        $this->assign('total', $total);
        $this->assign('user', $user);
        return $this->fetch();
    }

    public function xiaji_index(Request $request)
    {
        try {
            $user = UserModel::get($request->param('id'));
            $path = $user['path'] . $user['id'] . '-';
            $users = Db::name('user')->alias('u')->join('agency a', 'u.agency_id=a.id')
                ->field('u.id,u.phone,u.nickname,u.real_name,u.agency_id,u.wechatid,u.avatar,u.sex,u.status,u.status_time,u.pid,u.level,u.path,u.province,u.create_time,u.city,a.title')
                ->where('path', 'like', $path . '%')->all();
            $users = (new UserTree())->getChildren($users, $user['id'], $user['id'], $path);

            $this->assign('data', $users);
            return $this->fetch('user/agency_xiaji');
        } catch (\Exception $e) {
            return $this->fetch('error/500');
        }
    }


    public function client_index(Request $request)
    {
        $id = $request->param('id');

        try {
            $client = Db::name('my_client')->where('user_id', $id)->all();
            $this->assign('data', $client);
            return $this->fetch('user/agency_client');
        } catch (\Exception $e) {
            return $this->fetch('error/500');
        }
    }


    public function exchange($id)
    {

//        $order = OrderGoodsModel::where('id', $id)->field('id,user_id,status,remark')->find();
        $user_product = MyProduct::where('user_id', $id)->select();
//        dump($user_product[1]->product->id);die;
//        $this->assign('order', $order);
        $this->assign('product', $user_product);
        return $this->fetch();
    }

    public function ex_update(Request $request)
    {
        $form = $request->post();

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
//    dump($product_inc);dump('--'.$product_dec);die;
        $rule = [
//            'id' => 'require',
//            'status' => 'require|in:1',
            'product' => 'require',
        ];
        $message = [
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

    public function jiesuan()
    {
        $id = $this->request->param('id');

        $earnings = Db::name('earnings')->where('user_id', $id)->paginate(20);
        $this->assign('user_id', $id);
        $this->assign('data', $earnings);
        return $this->fetch('user/jiesuan_index');
    }

    public function jiesuan_create()
    {
        $user_id = $this->request->param('user_id');
        $this->assign('user_id', $user_id);
        return $this->fetch('user/jiesuan_create');
    }

    public function jiesuan_add()
    {
        $form = $this->request->post();
        $rule = [
            'user_id' => 'require|number',
            'source' => 'require',
            'percent' => 'require|float',
            'money' => 'require|float',
        ];
        $message = [
            'user_id.require' => '请选择用户后操作',
            'user_id.number' => '请选择用户后操作',
            'user_id.unique' => '当前选择用户不存在',
            'source.require' => '结算来源必须填写',
            'percent.require' => '结算百分比必须填写',
            'percent.float' => '结算百分比填写错误',
            'money.require' => '结算金额必须填写',
            'money.float' => '结算金额填写错误'
        ];
        $validate = new Validate($rule, $message);
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        $form['percent'] = $form['percent'] . '%';
        $form['create_time'] = time();
        $form['update_time'] = time();
        $earnings = Db::name('earnings')->insert($form);
        if ($earnings) {
            return json(['code' => 1, 'msg' => '操作成功']);
        }
        return json(['code' => 0, 'msg' > '操作失败']);
    }

    public function jiesuan_edit($id)
    {
        try {
            $earnings = Db::name('earnings')->where('id', $id)->find();

            $earnings['percent'] = substr($earnings['percent'], 0, strripos($earnings['percent'], '%'));
            $this->assign('data', $earnings);
            return $this->fetch('user/jiesuan_create');
        } catch (\Exception $e) {
            return $this->fetch('error/500');
        }
    }

    public function jiesuan_update()
    {
        $form = $this->request->post();
        $rule = [
            'user_id' => 'require|number',
            'source' => 'require',
            'percent' => 'require|float',
            'money' => 'require',
        ];
        $message = [
            'user_id.require' => '请选择用户后操作',
            'user_id.number' => '请选择用户后操作',
            'user_id.unique' => '当前选择用户不存在',
            'source.require' => '结算来源必须填写',
            'percent.require' => '结算百分比必须填写',
            'percent.float' => '结算百分比填写错误',
            'money.require' => '结算金额必须填写',
        ];
        $validate = new Validate($rule, $message);
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        $form['percent'] = $form['percent'] . '%';
        $form['update_time'] = time();
        try {
            Db::name('earnings')->update($form);
            return json(['code' => 1, 'msg' => '操作成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }

    public function jiesuan_destroy($id)
    {
        try {
            Db::name('earnings')->where('id', $id)->delete();
            return json(['code' => 1, 'msg' => '操作成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }

}
