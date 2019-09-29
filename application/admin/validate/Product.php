<?php

namespace app\admin\validate;

use think\Validate;

class Product extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'title'=>'require|min:3|max:20',
        'pic'=>'require',
        'price'=>'require|float',
        'num'=>'number'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'title.require'=>'商品标题必须填写',
        'title.min'=>'商品标题不能小于3个字',
        'title.max'=>'商品标题不能超过20个字',
        'pic.require'=>'请上传商品图片',
        'price.require'=>'商品价格必须填写',
        'price.float'=>'商品价格填写错误',
        'num.number'=>'每箱数量填写错误'
    ];
}
