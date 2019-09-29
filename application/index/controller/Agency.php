<?php

namespace app\index\controller;

use app\common\GenerateNo;
use app\index\model\OrderGoods;
use app\index\model\Product;
use app\index\validate\ReserveGoods;
use app\index\validate\User;
use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Agency extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $user = session('user');
        if(\think\facade\Request::isAjax()){
            $user = Db::name('user')->where('openid',$user['openid'])->find();
            if($user['agency_id']==0){
                return json(['code'=>0,'msg'=>'请申请代理后重试，或等待审核通过']);
            }else{
                return json(['code'=>1]);
            }
        }
        $user = Db::name('user')->alias('u')->join('agency a','u.agency_id=a.id')
            ->field('u.id,u.avatar,u.nickname,u.pid,u.wechatid,a.id as agency_id,a.title')->where('openid',$user['openid'])->find();
        $p_user = Db::name('user')->where('id',$user['pid'])->value('real_name');
        $this->assign('real_name',$p_user);
        $this->assign('user',$user);
        return $this->fetch('agency/mydl');
    }

    public function select_agency(Request $request)
    {
        if ($request->isAjax()) {
            $keyword = $request->get('keyword');
            $keyword = ['keyword'=>$keyword];
            $rule = ['keyword'=>'number'];
            $message=['keyword.number'=>'请输入代理ID或手机号'];
            $validate = new Validate($rule,$message);
            if(!$validate->check($keyword)){
                return json(['code'=>0,'msg'=>$validate->getError()]);
            }
            try {
                $user = Db::name('user')->alias('u')->join('agency a', 'u.agency_id=a.id')
                    ->field('u.id,u.agency_id,u.real_name,u.pid,u.phone,u.wechatid,u.status,u.status_time,a.title')
                    ->where('u.id', $keyword['keyword'])->whereOr('u.phone', $keyword['keyword'])->find();

                if ($user) {
                    if ($user['status'] == 1) {
                        $user['status'] = '正常';
                    } else if ($user['status'] == 0) {
                        $user['status'] = '待审核';
                    } else {
                        $user['status'] = '未通过';
                    }
                    $p_user = Db::name('user')->where('id',$user['pid'])->value('real_name');
                    $user['status_time'] = $user['status_time'] ? date('Y-m-d', $user['status_time']) : '';
                    $user['p_user']=$p_user;

                    return json(['code' => 1, 'data' => $user]);
                }
                return json(['code' => 0, 'msg' => '查询的代理商不存在']);
            } catch (\Exception $e) {
                return json(['code' => 0, 'msg' => '系统错误']);
            }
        }

        return $this->fetch('agency/checkauth');
    }

    public function i_want(Request $request)
    {

        if ($request->isAjax()) {
            $field = $request->post('field');
            $agency_id = $request->post('agency_id');
            if ($field == 'agency') {
                try {
                    $agency = Db::name('agency')->field('id,title')
                        ->where('delete_time', 0)->select();
                    return json(['code' => 1, 'data' => $agency]);
                } catch (\Exception $e) {
                    return json(['code' => 0, 'msg' => '系统错误']);
                }
            } else if ($field == 'ag') {
                try {
                    $product = Db::name('product')->alias('p')->join('agency_product ap','ap.product_id=p.id')
                        ->field('p.id,p.title,ap.agency_price,ap.agency_box_price,ap.first_boxful_num,ap.again_boxful_num,ap.type')
                        ->where('p.status', 1)->where('p.delete_time', 0)
                        ->where('ap.agency_id',$agency_id)->select();

                    return json(['code' => 1, 'data' => $product]);
                } catch (\Exception $e) {
                    return json(['code' => 0, 'msg' => '系统错误']);
                }
            } else if ($field == 'save') {
                $form = $request->post();

                $validate = new User();
                if (!$validate->check($form)) {
                    return json(['code' => 0, 'msg' => $validate->getError()]);
                }
                Db::startTrans();
                try {
                    $user_id = session('user')['id'];
                    if ($form['t_phone']) {
                        $t_user = Db::name('user')->where('phone', $form['t_phone'])->find();
                        if (!$t_user) {
                            return json(['code' => 0, 'msg' => '输入的推荐人不存在']);
                        }
                        $data = [
                            'real_name' => $form['real_name'] ? $form['real_name'] : 0,
                            'wechatid' => $form['wechatid'],
                            'phone' => $form['phone'],
                            'agency_id' => $form['agency'] ? $form['agency'] : 0,
                            'pid' => isset($t_user) ? $t_user['id'] : 0,
                            'level' => isset($t_user) ? $t_user['level'] + 1 : 0,
                            'path' => isset($t_user) ? $t_user['path'] . $t_user['id'] . '-' : '-',
                        ];
                    }

                    $data = [
                        'real_name' => $form['real_name'] ? $form['real_name'] : 0,
                        'wechatid' => $form['wechatid'],
                        'phone' => $form['phone'],
                        'agency_id' => $form['agency'] ? $form['agency'] : 0,
                    ];
                    //修改用户属性
                    $user = Db::name('user')->where('id', $user_id)->update($data);
                    //增加订货订单
                    if ($form['product_id'] && $form['agency']) {
                        $agency_product = Db::name('agency_product')->where('product_id',$form['product_id'])->where('agency_id',$form['agency'])->find();
                        $data = [
                            'no' => (new GenerateNo())->generateNo($user_id),
                            'user_id' => $user_id,
                            'product_id' => $form['product_id'],
                            'type' => 1,
                            'create_time'=>time(),
                            'update_time'=>time(),
                        ];

                        if($form['type']==0){
                            $data['total_price'] = round($agency_product['agency_box_price'] * $agency_product['first_boxful_num'], 2);
                            $data['box_num']=$agency_product['first_boxful_num'];
                            $data['price']=$agency_product['agency_box_price'];
                        }else{
                            $data['total_price'] = round($agency_product['agency_price'] * $agency_product['first_boxful_num'], 2);
                            $data['num']=$agency_product['first_boxful_num'];
                            $data['price']=$agency_product['agency_price'];
                        }

                        $order = Db::name('order_goods')->insert($data);
                    }
                    Db::commit();
                    return json(['code' => 1, 'msg' => '提交成功']);
                } catch (\Exception $e) {
                    Db::rollback();
                    return json(['code' => 0, 'msg' => '系统错误']);
                }
            }

            if($field=='i_wart'){
                $user = session('user');
                $user = Db::name('user')->where('openid',$user['openid'])->find();
                if($user){
                    if($user['agency_id']!=0&&$user['status']==0||$user['status']==2){
                        return json(['code'=>0,'msg'=>'您已申请过代理，请等待管理员审核']);
                    }else if($user['agency_id']!=0&&$user['status']==1){
                       return json(['code'=>2]);
                    }
                    else{
                        return json(['code'=>1]);
                    }
                }
            }
        }

        $user = session('user');
        $user = Db::name('user')->where('openid',$user['openid'])->find();
        if($user['agency_id']==0){
            return $this->fetch('agency/joinus');
        }else{
            return redirect('agency/index');
        }

    }
}
