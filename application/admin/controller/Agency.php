<?php

namespace app\admin\controller;

use app\admin\model\AgencyProduct;
use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\Agency as AgencyModel;
use app\admin\validate\Agency as AgencyValidate;


class Agency extends Base
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
            $data = Db::name('agency')->alias('a');
            if ($key) {
                $data = $data->where('a.title', 'like', '%' . $key . '%');
            }
            $data = $data->where('a.delete_time', 0);
            $ids = $data->column('id');
            $data = $data->order('a.create_time desc')->paginate(20);

            foreach($data as $k=>$v){
                $v['num'] = Db::name('agency_product')->where('agency_id',$v['id'])->count('id');
                $data[$k]=$v;
            }

            if ($data) {
                return view('index', [
                    'val' => $key,
                    'data' => $data,
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
        $product = Db::name('product')->field('id,title')->where('status', 1)->where('delete_time', 'eq',0)->all();
        $this->assign('product', $product);
        return $this->fetch('agency/add_edit');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function store(Request $request)
    {
        $form = $request->post();
        $validate = new \app\admin\validate\Agency();
        if(!$validate->check($form)){
            return json(['code'=>0,'msg'=>$validate->getError()]);
        }
        unset($form['id']);
        unset($form['product_id']);
        Db::startTrans();
        try {
            $agency = Db::name('agency')->insertGetId(['title' => $form['title'], 'create_time' => time(), 'update_time' => time(), 'delete_time' => 0]);
            $data = [];
            foreach ($form['product'] as $k => $v) {
                $data[$k]['agency_id'] = $agency;
                $data[$k]['product_id'] = $k;
                $data[$k]['type']=$v['status'];
                $data[$k]['agency_price'] = $v['agency_price'];
                $data[$k]['agency_box_price'] = $v['agency_box_price'];
                $data[$k]['first_boxful_num'] = $v['first_boxful_num'];
                $data[$k]['again_boxful_num'] = $v['again_boxful_num'];
            }
            $agency_product = Db::name('agency_product')->insertAll($data);
            Db::commit();
            if ($agency_product) {
                return json(['code' => 1, 'msg' => '创建成功']);
            }
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 0, 'msg' => '系统错误']);
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
        $agency = Db::name('agency')->where('id', $id)->find();
        $agency_product = Db::name('agency_product')->alias('ap')->join('product p','ap.product_id=p.id')
            ->field('ap.id as ap_id,ap.agency_id,ap.product_id,ap.agency_price,ap.agency_box_price,ap.first_boxful_num,ap.again_boxful_num,ap.type,p.id,p.title')
            ->where('ap.agency_id',$agency['id'])->select();
        $ids = [];
        foreach($agency_product as $v){
            $ids[]=$v['id'];
        }

        $product = Db::name('product')->where('id','not in',$ids)
            ->where('status',1)->where('delete_time',0)->select();

        $this->assign('agency', $agency);
        $this->assign('product',$product);
        $this->assign('agency_product',$agency_product);
        return $this->fetch('agency/add_edit');
    }

    public function del_agency_product(){
        $id = $this->request->get('id');
        Db::startTrans();
        try{
            $product_id = Db::name('agency_product')->where('id',$id)->value('product_id');
            $product = Db::name('product')->field('id,title')->where('id',$product_id)->find();
            Db::name('agency_product')->delete($id);
            Db::commit();
            return json(['code'=>1,'msg'=>'删除成功','data'=>$product]);
        }catch(\Exception $e){
            Db::rollback();
            return json(['code'=>0,'msg'=>'系统错误']);
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        $form = $request->post();
//dump($form);die;
        $validate = new \app\admin\validate\Agency();
        if(!$validate->check($form)){
            return json(['code'=>0,'msg'=>$validate->getError()]);
        }
        unset($form['product_id']);
        Db::startTrans();
        try {
            $agency = Db::name('agency')->where('id',$form['id'])->update(['title'=>$form['title']]);
            $data = [];
            foreach ($form['product'] as $k => $v) {
                if(array_key_exists('id',$v)){
                    $data[$k]['id']= $v['id'];
                }
                $data[$k]['agency_id'] = $form['id'];
                $data[$k]['product_id'] = $k;
                $data[$k]['type']=$v['status'];
                $data[$k]['agency_price'] = $v['agency_price'];
                $data[$k]['agency_box_price'] = $v['agency_box_price'];
                $data[$k]['first_boxful_num'] = $v['first_boxful_num'];
                $data[$k]['again_boxful_num'] = $v['again_boxful_num'];
            }
//            dump($data);die;
            $agency_product = (new AgencyProduct())->saveAll($data);
            Db::commit();
            if ($agency_product) {
                return json(['code' => 1, 'msg' => '编辑成功']);
            }
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
    public function destroy($id)
    {
        try {
            $user_num = Db::name('user')->where('agency_id', $id)->count('id');
            if ($user_num) {
                return json(['code' => 0, 'msg' => '当前代理等级下已有代理客户，禁止删除']);
            }

            Db::name('agency')->where('id', $id)->update(['delete_time' => time()]);
            return json(['code' => 1, 'msg' => '删除成功']);
        } catch (\Exception $e) {
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
