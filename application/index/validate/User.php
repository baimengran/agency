<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    protected $regex = ["phone" => "/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/"];
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'agency' => 'require|number|gt:0',
        'product_id' => 'number',
        'num' => 'number',
        'real_name' => 'require|min:2|max:15',
        'wechatid' => 'require',
        'phone' => "require|unique:user|regex:phone",
        't_phone' => ['regex' => '/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'agency' => '请选择代理等级',
        'product_id' => '商品错误',
        'num' => '数量错误',
        'real_name.require' => '真实姓名必须填写',
        'real_name.min' => '真实姓名不能少于2个字',
        'real_name.max' => '真实姓名不能大于15个字',
        'wechatid.require' => '微信号必须填写',
        'phone.require' => '联系方式必须填写',
        'phone.unique'=>'当前联系方式已存在',
        'phone.regex' => '联系方式填写错误',
        't_phone' => '推荐人电话格式错误'
    ];
}
