<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected  $regex = ["regex"=>"/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/"];
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = ['phone' =>"require|unique:user|regex:regex",];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'phone.require' => '联系方式必须填写',
        'phone.regex' => '联系方式填写错误',
        'phone.unique'=>'当前联系方式已存在'
    ];
}
