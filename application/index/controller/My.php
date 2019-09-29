<?php

namespace app\index\controller;

use app\common\UserTree;
use app\index\model\MyProduct;
use app\index\model\User;
use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Log;
use think\Request;
use think\Validate;

class My extends Base
{
    protected $middleware=['Agency'];
    public function my()
    {
        $user = session('user');
        try {
            $user = Db::name('user')->alias('u')->join('agency a', 'a.id=u.agency_id')
                ->field('u.id,u.phone,u.agency_id,u.real_name,u.wechatid,u.status,u.status_time,u.create_time,a.title')
                ->where('u.id', $user['id'])->find();
            $num = MyProduct::where('user_id', $user['id'])->sum('num');
            $user['status_time'] = $user['status_time'] != 0 ? date('Y-m-d H:i:s', $user['status_time']) : "";
            $user['create_time'] = $user['create_time'] != 0 ? date('Y-m-d H:i:s', $user['create_time']) : '';

            if ($user['status'] == 1) {
                $user['status'] = '正常';
            } else if ($user['status'] == 0) {
                $user['status'] = '待审核';
            } else {
                $user['status'] = '未通过';
            }
            $user['num'] = $num;
            $this->assign('user', $user);
            return $this->fetch('my/dl_mymsg');
        } catch (\Exception $e) {
            Log::error('my:' . $e->getMessage());
            return json('系统错误');
        }
    }

    /**
     * 我的下级代理
     * @param Request $request
     * @return mixed|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function my_agency(Request $request)
    {
        $id = $request->param('id');
        if (!$id) {
            $id = session('user')['id'];
        }
        $user = Db::name('user')->where('id', $id)->field('id,level,pid,path')->find();
        $path = $user['path'] . $user['id'] . '-';

        if ($request->isAjax()) {
            $filtrate = $request->get('filtrate');
            $show = $request->get('show');
            if ($show) {
                $user = Db::name('user')->alias('u')->join('agency a', 'u.agency_id=a.id')
                    ->where('u.id', $show)
                    ->field('u.id,u.real_name,u.agency_id,u.status,u.status_time,u.wechatid,u.phone,a.title')->find();
                $user['status_time'] = $user['status_time'] != 0 ? date('Y-m-d H:i:s', $user['status_time']) : '';
                $user['status'] = $user['status'] == 1 ? '正常' : $user['status'] == 0 ? '待审核' : $user['status']==2?'已审核':'未通过';
                return json(['code' => 2, 'data' => $user, 'id' => $user['id']]);

            }
            if ($filtrate == 0) {
                $users = Db::name('user')->alias('u')->join('agency a', 'u.agency_id=a.id')
                    ->where('u.path', 'like', $path . '%')->where('u.status', 1)
                    ->field('u.id,u.real_name,u.agency_id,u.status,u.pid,u.level,u.path,u.avatar,u.province,u.city,u.create_time,u.phone,u.status_time,u.wechatid,a.title')->select();
            } else {
                $users = Db::name('user')->alias('u')->join('agency a', 'u.agency_id=a.id')
                    ->where('u.path', 'like', $path . '%')->where('u.status', 0)->whereOr('u.status',2)->whereOr('u.status',-1)
                    ->field('u.id,u.real_name,u.agency_id,u.status,u.pid,u.level,u.path,u.avatar,u.province,u.city,u.create_time,u.phone,u.status_time,u.wechatid,a.title')->select();
            }
//            dump($users);die;
            $data = (new UserTree())->getChildren($users, $user['id'], $user['id'], $path);
            return json(['code' => 1, 'data' => $data, 'id' => $id]);
        }
        $this->assign('id', $id);
        return $this->fetch('my/dl_myxj');
    }

    /**
     * 审核我的下级代理
     */
    public function status(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return json(['code' => 0, 'msg' => '操作无效']);
        }
        try {
            $user = session('user');
            $user = Db::name('user')->where('id', $id)->value('status');
            if ($user != 0) {
                return json(['code' => 0, 'msg' => '您当前下级代理已审核过或已被管理员拒绝']);
            }
            $user = Db::name('user')->where('id', $id)->update(['status' => 2]);
            if ($user) {
                return json(['code' => 1, 'msg' => '操作成功，请等待管理员审核通过']);
            }
            return json(['code' => 0, 'msg' => '操作失败']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '系统错误']);
        }
    }

    /**
     * 下级代理生成
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function agency_generate()
    {
        $user_id = session('user')['id'];
        $user = Db::name('user')->where('id', $user_id)->find();

        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=';
        if (!Cache::has('AccessToken')) {
            (new Base)->accessToken();
        }
        $accessToken = Cache::get('AccessToken');

        $url = $url . $accessToken;
        //{"action_name": "QR_LIMIT_STR_SCENE",
        // "action_info": {"scene": {"scene_str": "test"}}}
        $info = json_encode(['type' => 'agency', 'userid' => $user['id']]);
        $data = [
            'action_name' => 'QR_LIMIT_STR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $info,
                ]
            ],
        ];

        $data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            Log::error("error:" . curl_error($ch));
            exit;
        }
        curl_close($ch);

        $res = json_decode($res, true);

        if (!array_key_exists('ticket', $res) ) {
            Cache::rm('AccessToken');
            (new Base())->accessToken();
                $this->agency_generate();
                exit;
        }

        //获取二维码
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
        $url = $url . urlencode($res['ticket']);
        $this->assign('img', $url);
        return $this->fetch('my/agency_generate');

    }


    /**
     * 我的收益
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function my_earnings(Request $request)
    {
        $key = $request->get('filtrate');

        if ($request->isAjax()) {
            $user = session('user');

            if ($key == 0) {
                $date = 'FROM_UNIXTIME(create_time,"%Y%m")=DATE_FORMAT(CURDATE(),"%Y%m")';
            } else {
                $date = 'DATE_FORMAT(NOW(),"%Y%m")-FROM_UNIXTIME(create_time,"%Y%m") =1';
            }
            try {
                $my_earnings = Db::name('earnings')->where('user_id', $user['id'])
                    ->whereRaw($date)->all();
                $num = Db::name('earnings')->where('user_id', $user['id'])
                    ->whereRaw($date)->sum('money');
                return json(['code' => 1, 'data' => $my_earnings, 'num' => $num]);
            } catch (\Exception $e) {
                return json(['msg' => '系统错误']);
            }
        }
        return $this->fetch('my/dl_myjs');
    }

    /**
     * 我的顾客
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function my_client(Request $request)
    {
        $user = session('user');
        $key = $request->get('id');
        try {
            if ($key) {
                $client = Db::name('my_client')->where('id', $key)
                    ->field('id,name,phone,birthday,address,buy_num,buy_time,create_time')->find();
                if ($client) {
                    $client['birthday'] = $client['birthday'] != 0 ? date('Y-m-d', $client['birthday']) : '';
                    $client['buy_time'] = $client['buy_time'] != 0 ? date('Y-m-d H:i:s', $client['buy_time']) : '';
                    $client['create_time'] = date('Y-m-d H:i:s', $client['create_time']);
                    return json(['code' => 2, 'data' => $client]);
                } else {
                    return json(['code' => 0, 'msg' => '未找到当前客户']);
                }
            }
            if ($request->isAjax()) {
                $client = Db::name('my_client')->where('user_id', $user['id'])
                    ->field('id,name,phone,birthday')->order('create_time desc')->all();
                foreach($client as $k=>$v){
                    $client[$k]['birthday'] = $v['birthday']==''?'':date('Y-m-d',$v['birthday']);
                }
                return json(['code' => 1, 'data' => $client]);
            }

            return $this->fetch('my/dl_mygk');
        } catch (\Exception $e) {
            Log::error('my_client:' . $e->getMessage());
            return json('系统错误');
        }
    }

    /**
     * 添加客户
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function create_client(Request $request)
    {

        if ($request->isAjax()) {
            $form = $request->post();
            $rule = [
                'name' => 'require|min:2|max:10',
                'birthday' => 'date',
                'phone' => ['require' | "regex" => "/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/"],
                'address' => 'require|max:100',
                'buy_num' => 'number',
                'buy_time' => 'date',
            ];
            $message = [
                'name.require' => '客户姓名必须填写',
                'name.min' => '客户姓名不能少于2个字',
                'name.max' => '客户姓名不能多于10个字',
                'birthday' => '生日填写错误',
                'phone.require' => '客户电话必须填写',
                'phone.regex' => '请输入正确手机号或座机号码',
                'address.require' => '客户地址必须填写',
                'address.max' => '客户地址不能多于100个字',
                'buy_num' => '购买数量填写错误',
                'buy_time' => '购买时间填写错误',
            ];

            $validate = new Validate($rule, $message);
            if (!$validate->check($form)) {
                return json(['code' => 0, 'msg' => $validate->getError()]);
            }
            $form['user_id'] = session('user')['id'];
            $form['buy_time'] = $form['buy_time'] ? strtotime($form['buy_time']) : '';
            $form['birthday'] = $form['birthday'] ? strtotime($form['birthday']) : '';
            $form['create_time'] = time();
            $form['update_time'] = time();
            $my_client = Db::name('my_client')->insert($form);
            if ($my_client) {
                return json(['code' => 1, 'msg' => '创建成功']);
            }
            return json(['code' => 0, 'msg' => '创建失败']);
        }
        return $this->fetch('my/dl_add_kh');
    }


}
