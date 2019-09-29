<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class MyAddress extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $user = Db::name('user')->field('id,agency_id,avatar,nickname,status')
            ->where('id', session('user')['id'])->find();
        $data = getSite();
        $this->assign('site', $data);
        $this->assign('user', $user);
        return $this->fetch('my/my');
    }
    /**
     * 地址列表
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function address_index(Request $request)
    {
        if ($request->isAjax()) {
            Db::startTrans();
            try {
                $user_id = session('user')['id'];
                $field = $request->post('c');
                $id = $request->post('id');
                //修改默认
                if ($field == 'default' && $id) {
                    $address = Db::name('address')->where('id', $id)->value('status');
                    if ($address == 0) {
                        $status = 1;
                        $address = Db::name('address')->where('status', 1)->update(['status' => 0]);
                    } else {
                        $status = 0;
                    }
                    $address = Db::name('address')->where('id', $id)->update(['status' => $status]);
                    $address = Db::name('address')
                        ->field('id,name,phone,address,status')
                        ->where('user_id', $user_id)->all();
                    Db::commit();
                    return json(['code' => 1, 'data' => $address]);
                } else if ($field == 'delete' && $id) {
                    $address = Db::name('address')->where('id', $id)->delete();
                    $address = Db::name('address')
                        ->field('id,name,phone,address,status')
                        ->where('user_id', $user_id)->all();
                    Db::commit();
                    return json(['code' => 1, 'data' => $address]);
                }
                $address = Db::name('address')
                    ->field('id,name,phone,address,status')
                    ->where('user_id', $user_id)->all();
                return json(['code' => 1, 'data' => $address]);
            } catch (\Exception $e) {
                Db::rollback();
                return json(['code' => 0, 'msg' => '加载失败']);
            }
        }

        return $this->fetch('my/address');
    }

    /**
     * 添加地址
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function address_add(Request $request)
    {
        if ($request->isAjax()) {
            $form = $request->post();
            $user_id = session('user')['id'];
            $rule = [
                'name' => 'require|min:2|max:15',
                'phone' => ["require" | "regex" => "/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/"],
                'address1' => 'require',
                'address2' => 'require',
            ];
            $message = [
                'name.require' => '收货人必须填写',
                'name.min' => '收货人不能少于两个字',
                'name.max' => '收货人不能多于15个字',
                'phone.require' => '手机号码必须填写',
                'phone.regex' => '手机号码填写错误',
                'address1' => '所在地址必须填写',
                'address2' => '详细地址必须填写',
            ];

            $validate = new Validate($rule, $message);
            if (!$validate->check($form)) {
                return json(['code' => 0, 'msg' => $validate->getError()]);
            }
            $form['user_id'] = $user_id;
            $form['address'] = $form['address1'] . '-' . $form['address2'];
            $form['create_time'] = time();
            $form['update_time'] = time();
            unset($form['address1']);
            unset($form['address2']);
            $address = Db::name('address')->insert($form);
            if ($address) {
                return json(['code' => 1, 'msg' => '操作成功']);
            } else {
                return json(['code' => 0, 'msg' => '操作失败']);
            }
        }


        return $this->fetch('my/address_add');
    }

    /**
     * 编辑地址
     * @param Request $request
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function address_edit(Request $request)
    {
        if ($request->isAjax()) {
            $form = $request->post();
            $rule = [
                'name' => 'require|min:2|max:15',
                'phone' => ["require" | "regex" => "/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/"],
                'address1' => 'require',
                'address2' => 'require',
            ];
            $message = [
                'name.require' => '收货人必须填写',
                'name.min' => '收货人不能少于两个字',
                'name.max' => '收货人不能多于15个字',
                'phone.require' => '手机号码必须填写',
                'phone.regex' => '手机号码填写错误',
                'address1' => '所在地址必须填写',
                'address2' => '详细地址必须填写',
            ];

            $validate = new Validate($rule, $message);
            if (!$validate->check($form)) {
                return json(['code' => 0, 'msg' => $validate->getError()]);
            }
            $form['address'] = $form['address1'] . '-' . $form['address2'];
            $form['create_time'] = time();
            $form['update_time'] = time();
            unset($form['address1']);
            unset($form['address2']);
            $address = Db::name('address')->where('id', $form['id'])->update($form);
            return json(['code' => 1, 'msg' => '编辑成功']);
        }
        $id = $request->param('id');
        $user_id = session('user')['id'];
        $address = Db::name('address')->where('user_id', $user_id)->find();
        $array = explode('-', $address['address']);
        $address['address1'] = $array[0];
        $address['address2'] = $array[1];
        $this->assign('address', $address);
        return $this->fetch('my/address_edit');
    }
}
