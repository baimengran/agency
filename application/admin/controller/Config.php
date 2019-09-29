<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;

class Config extends Base
{
    const WEB_SITE_PATH = CONFIG_PATH . 'web_site.json';

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        $data = json_decode(file_get_contents(self::WEB_SITE_PATH),true);
//        dump($data);die;
        $this->assign('site', $data);
        return $this->fetch();
    }

    public function save()
    {
        $form = \think\facade\Request::post();
        $rule = [
            'title' => 'require',
            'youhui' => 'require|number',
            'yunfei' => 'require|number',
            'status' => 'require|number',
            'contact_us'=>"require",
        ];
        $message = [
            'title.require' => '网站标题必须填写',
            'youhui.require' => '优惠必须填写',
            'youhui.number' => '优惠请填写正整数',
            'yunfei.require' => '运费必须填写',
            'yunfei.number' => '运费请填写正整数',
            'status.require' => '商城状态必须设置',
            'status.number' => '商城状态设置错误',
            'contact_us.require'=>'联系我们必须填写',
        ];
        $validate = new Validate($rule, $message);
        if (!$validate->check($form)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }

        $data = json_encode($form);
        $status = file_put_contents(self::WEB_SITE_PATH, $data);
        if ($status) {
            return json(['code' => 1, 'msg' => '设置成功']);
        } else {
            return json(['code' => 0, 'msg' => '设置失败']);
        }
    }
}
