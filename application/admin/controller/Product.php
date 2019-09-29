<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\facade\Validate;
use think\Request;
use app\admin\model\Product as ProductModel;
use app\admin\validate\Product as ProductValidate;

class Product extends Base
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
            $data = new ProductModel();
            if ($key) {
                $data = $data->where('title', 'like', '%' . $key . '%');
            }
            $data = $data->where('delete_time', 0)
                ->order('create_time', 'desc')->paginate(20);
            if ($data) {
                return view('index', [
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
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch('product/add_edit');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function store(Request $request)
    {
        $form = $request->only('title,desc,price,pic,status,num');
        $validate = new ProductValidate();
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        if($form['num']==''){
            unset($form['num']);
        }
        $form['status']=1;
        $product = ProductModel::create($form);
        if ($product) {
            return json(['code' => 1, 'msg' => '创建成功']);
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
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $product = Db::name('product')->where('id', $id)->find();
        $this->assign('data', $product);
        return $this->fetch('product/add_edit');
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
        $form = $request->only('id,title,desc,pic,price,status,num');
        $validate = new ProductValidate();
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        if($form['num']==''){
            unset($form['num']);
        }
        $form['status']=1;
        try {
            $admin = ProductModel::update($form);
            return json(['code' => 1, 'msg' => '编辑成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '编辑失败']);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function destroy($id)
    {
        Db::startTrans();
        try{
            Db::name('product')->where('id',$id)->update(['delete_time'=>time()]);
            Db::name('agency_product')->where('product_id',$id)->delete();
            Db::commit();
            return json(['code'=>1,'msg'=>'删除成功']);
        }catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

    public function status()
    {
        $id = input('param.id');

        try {
            $status = Db::name('product')->where(array('id' => $id))->field('status')->value('status');//判断当前状态情况

            if ($status == 0) {
                $flag = Db::name('product')->where(array('id' => $id))->setField(['status' => 1]);
                return json(['code' => 1, 'data' => $flag['data'], 'msg' => '启用']);
            } else {
                $flag = Db::name('product')->where(array('id' => $id))->setField(['status' => 0]);
                return json(['code' => 0, 'data' => $flag['data'], 'msg' => '禁用']);
            }
        } catch (\Exception $e) {
            return json(['code' => 0, 'data', 'msg' => '出错啦']);
        }
    }
}
