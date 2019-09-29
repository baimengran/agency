<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Log;
use think\facade\Request;
use app\index\model\Product as ProductModel;

class Index extends Base
{
    public function index()
    {
        $user = session('user');
        try {
            $user = Db::name('user')->where('id',$user['id'])->find();
            $product = ProductModel::field('id,title,pic,price')->where('delete_time', 0)->where('status', 1)
                ->order('create_time desc')->all();

            $data = getSite();
            $this->assign('site',$data);
            $this->assign('data', $product);
            $this->assign('user', session('user'));
            return $this->fetch();
        } catch (\Exception $e) {
            return $this->fetch();
        }

    }
}
